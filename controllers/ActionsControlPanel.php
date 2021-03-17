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
use Arikaim\Core\Queue\Cron;

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
     * Get queue worker status
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getStatusController($request, $response, $data) 
    {         
        $this->onDataValid(function($data) {
            $name = $data->getSring('name','cron');
            $manager = $this->get('queue')->createWorkerManager($name);

            $running = $manager->isRunning();

            $this->setResponse(\is_object($manager),function() use($running,$name) {                                
                $this
                    ->message('worker.status')
                    ->field('name',$name)
                    ->field('running',$running);                                                                                        
            },'errors.worker.status');
        });
        $data->validate();        
    }
}
