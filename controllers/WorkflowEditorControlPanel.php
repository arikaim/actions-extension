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

            $this->setResponse($result,function() use($uuid) {                                
                $this
                    ->message('editor.create')                             
                    ->field('uuid',$uuid);                                                                                                      
            },'errors.import');
        });
        $data
            ->addRule('text:min=1|required','uuid')
            ->validate();        
    }
}
