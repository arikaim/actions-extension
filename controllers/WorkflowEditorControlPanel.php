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
            $workflowItems = Model::WorkflowItems('actions');

            $item = $workflowItems->create([
                'action'      => $action,
                'workflow_id' => $workflow->id,
                'user_id'     => $this->getUserId()
            ]);

            $this->setResponse(\is_object($item),function() use($uuid,$item) {                                
                $this
                    ->message('editor.create')                             
                    ->field('workflow',$uuid)
                    ->uuid('uuid',$item->uuid);                                                                                        
            },'errors.import');
        });
        $data
            ->addRule('text:min=1|required','action')
            ->validate();        
    }
}
