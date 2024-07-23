<?php

namespace Arikaim\Extensions\Actions\Actions;

use Arikaim\Core\Actions\Action;
use Arikaim\Core\Actions\Actions;
use Arikaim\Core\Actions\ActionNotFound;

use Arikaim\Core\Db\Model;

/**
* Action class
*/
class ImportActions extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
    }

    /**
     * Run action
     *
     * @param mixed ...$params
     * @return bool
     */
    public function run(...$params)
    {
        global $arikaim;

        $packageName = $this->getOption('package_name',null);
        if (empty($packageName) == true) {
            $this->error('Not valid package name');
            return false;
        }
        
        $packageType = $this->getOption('package_type',null);
        if (empty($packageType) == true) {
            $this->error('Not valid package type');
            return false;
        }

        $model = Model::Actions('actions');
        $packageManager = $arikaim->get('packages')->create($packageType);
        $package = $packageManager->createPackage($packageName);
        $actions = $package->getPackageActions();
        $imported = 0;

        foreach ($actions as $actionClass) {
            
            if ($packageType == 'extension') {              
                $action = Actions::createFromExtension($actionClass,$packageName)->getAction();
            } else {
                $action = Actions::createFromModule($actionClass,$packageName)->getAction();
            }

            if (($action instanceof ActionNotFound) == false) {
                $info = $action->toArray();
                $info['package_type'] = $packageType;
                $info['package_name'] = $packageName;
                $result = $model->saveAction($info);
                $imported += ($result == true) ? 1 : 0;
            }
        }
        
        $this->result('imported',$imported);
    }

    /**
    * Init properties descriptor
    *
    * @return void
    */
    protected function initDescriptor(): void
    {
        $this->descriptor->get('options')->property('package_name',function($property) {
            $property
                ->title('Package Name')
                ->type('text')  
                ->required(true)                    
                ->readonly(false);              
        }); 

        $this->descriptor->get('options')->property('package_type',function($property) {
            $property
                ->title('Package Type')
                ->type('text')    
                ->required(true)                              
                ->readonly(false);              
        }); 
    }
}
