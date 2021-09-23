<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Controllers;

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Db\Model;
use Arikaim\Core\Utils\DateTime;
use Arikaim\Core\Collection\PropertiesFactory;

/**
 * Workflow editor control panel controler
*/
class WorkflowEditorControlPanel extends ControlPanelApiController
{
    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('actions::admin.messages');
    }

    /**
     * Create workflow item
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function createItemController($request, $response, $data) 
    {         
        $this->onDataValid(function($data) {
            $uuid = $data->getString('workflow');
            $action = $data->getString('action',null);
            $workflow = Model::Workflows('actions')->findById($uuid);
            if (\is_object($workflow) == false) {
                $this->error('Not valid workflow uuid.');
                return false;
            }
            $actions = Model::Actions('actions')->findById($action);
            if (\is_object($actions) == false) {
                $this->error('Not valid action uuid.');
                return false;
            }

            $workflowItems = Model::WorkflowItems('actions');

            $item = $workflowItems->create([
                'action_id'   => $actions->id,
                'workflow_id' => $workflow->id,
                'user_id'     => $this->getUserId(),
                'config'      => \json_encode($actions->config)
            ]);

            $this->setResponse(\is_object($item),function() use($uuid,$item) {                                
                $this
                    ->message('editor.create')                             
                    ->field('workflow',$uuid)
                    ->field('action_id',$item->action_id)
                    ->field('uuid',$item->uuid);                                                                                        
            },'errors.import');
        });
        $data
            ->addRule('text:min=1|required','action')
            ->addRule('text:min=1|required','workflow')
            ->validate();        
    }

    /**
     * Save workflow item condition
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateConditionController($request, $response, $data) 
    {   
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $type = $data->get('type');
            $scheduleTime = $data->get('schedule_time');
            $recurringInterval = $data->get('recurring_interval');

            $item = Model::WorkflowItems('actions')->findById($uuid);
            if (\is_object($item) == false) {
                $this->error('Not valid workflow item uuid.');
                return false;
            }

            $value = ($type == 'recurring') ? $recurringInterval : DateTime::toTimestamp($scheduleTime);

            $result = $item->update([
                'condition_type'  => $type,
                'condition_value' => $value
            ]);

            $this->setResponse($result,function() use($uuid) {                                
                $this
                    ->message('editor.update_condition')                             
                    ->field('uuid',$uuid);                                                                                                      
            },'errors.update_condition');
        });
        $data
            ->addRule('text:min=1|required','uuid')
            ->validate();  
    }

    /**
     * Save workflow item config
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateConfigController($request, $response, $data) 
    {   
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $item = Model::WorkflowItems('actions')->findById($uuid);
            if (\is_object($item) == false) {
                $this->error('Not valid workflow item uuid.');
                return false;
            }                         
            $data->offsetUnset('uuid');

            // change config valus
            $config = PropertiesFactory::createFromArray($item['config']); 
            $config->setPropertyValues($data->toArray());

            $result = $item->saveConfig($config->toArray());
            if ($result == true && empty($item->job_id) == false) {
                // update job config in queue
                $this->get('queue')->saveJobConfig($item->job_id,$config->toArray());
            }

            $this->setResponse($result,function() use($uuid) {                                
                $this
                    ->message('editor.item_config')                             
                    ->field('uuid',$uuid);                                                                                                      
            },'errors.item_config');
        });
        $data
            ->addRule('text:min=1|required','uuid')
            ->validate();
    }

    /**
     * Delete workflow item
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function deleteItemController($request, $response, $data) 
    {         
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $item = Model::WorkflowItems('actions')->findById($uuid);
            if (\is_object($item) == false) {
                $this->error('Not valid workflow item uuid.');
                return false;
            }
            // delete item
            $result = $item->delete();
            if ($result !== false && empty($item->job_id) == false) {
                // delete job form queue
                $this->get('queue')->deleteJob($item->job_id);
            }
            
            $this->setResponse($result,function() use($uuid) {                                
                $this
                    ->message('editor.create')                             
                    ->field('uuid',$uuid);                                                                                                      
            },'errors.create');
        });
        $data
            ->addRule('text:min=1|required','uuid')
            ->validate();        
    }

    /**
     * Push action job to queue
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function pushActionJobController($request, $response, $data) 
    {         
        $this->onDataValid(function($data) {
            $uuid = $data->get('uuid');
            $item = Model::WorkflowItems('actions')->findById($uuid);
            if (\is_object($item) == false) {
                $this->error('Not valid workflow item uuid.');
                return false;
            }

            // add job to queue
            $jobName = $item->action->name;
            if ($this->get('queue')->has($jobName) == true) {
                $jobName .= '-' . (string)$item->id;
            }
           
            if ($item->condition_type == 'recurring') {
                $job = $this->get('queue')->create('ActionRecurringJob','actions');
                $recuringInterval = $item->condition_value;
                $job->setRecurringInterval($recuringInterval);
                $scheduleTime = null;
            }
            if ($item->condition_type == 'scheduled') {
                $job = $this->get('queue')->create('ActionScheduledJob','actions');
                $scheduleTime =  $item->condition_value;
                $job->setScheduleTime($scheduleTime);
                $recuringInterval = null;
            }
           
            $job->setName($jobName);
            $properties = PropertiesFactory::createFromArray($item->config);           
            $properties->property('job_class',[
                'value' => $item->action->handler_class,
                'type'  => 'text'
            ]);
 
            // add job
            $result = $this->get('queue')->addJob($job,null,false,$recuringInterval,$scheduleTime,$properties->toArray());
         
            $this->setResponse($result,function() use($uuid, $jobName, $item) {   
                // update job id in workflow item
                $job = $this->get('queue')->getJob($jobName);
                $item->update(['job_id' => $job['id']]);
                
                $this
                    ->message('editor.push_job')                             
                    ->field('uuid',$uuid);                                                                                                      
            },'errors.push_job');            
        });
        $data
            ->addRule('text:min=1|required','uuid')
            ->validate();        
    }
}
