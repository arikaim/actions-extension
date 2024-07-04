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
use Arikaim\Core\Actions\Actions;

/**
 * Actions control panel controler
*/
class ActionsControlPanel extends ControlPanelApiController
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
     * Import actions from extension or module package
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return mixed
    */
    public function importController($request, $response, $data) 
    {         
        $data
            ->validate(true);    

        $packageName = $data->getString('package');
        $type = $data->getString('type','extension');

        $action = Actions::create('ImportActions','actions',[
            'package_name' => $packageName,
            'package_type' => $type
        ])->getAction();
         
        $action->run();
        
        if ($action->hasError() == true) {
            $this->error($action->getError());
            return false;
        }

        $this
            ->message('import')        
            ->field('imported',$action->get('imported'))       
            ->field('type',$type)       
            ->field('package',$packageName);                                                                                        
    }
}
