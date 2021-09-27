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
use Arikaim\Core\Interfaces\ConfigPropertiesInterface;

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
     * @return Psr\Http\Message\ResponseInterface
    */
    public function importController($request, $response, $data) 
    {         
        $this->onDataValid(function($data) {
            $packageName = $data->getString('package');
            $type = $data->getString('type','extension');
            $actions = Model::Actions('actions');

            $packageManager = $this->get('packages')->create($type);

            $properties = $packageManager->getPackageProperties($packageName,true);
            $imported = 0;

            foreach ($properties['jobs'] as $item) {
                $item['handler_class'] = $item['class'];
                $item['package_name'] = $packageName;
                $item['package_type'] = $type;
                // create job action 
                $job = $this->get('queue')->create($item['handler_class']);
            
                $config = ($job instanceof ConfigPropertiesInterface) ? $job->createConfigProperties() : [];
                $item['config'] = \json_encode($config);
              
                $result = $actions->saveAction($item);
                $imported += ($result == true) ? 1 : 0;
            }

            $this->setResponse(true,function() use($packageName,$imported) {                                
                $this
                    ->message('import')        
                    ->field('imported',$imported)       
                    ->field('package',$packageName);                                                                                        
            },'errors.import');
        });
        $data->validate();        
    }
}
