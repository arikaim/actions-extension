<?php

namespace Arikaim\Extensions\Actions\Actions;

use Arikaim\Core\Actions\Action;

/**
*  Logger action class
*/
class LoggerAction extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
        $this->name('logger');
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

        $message = $this->getOption('message',null);
        if (empty($message) == true) {
            $this->error('Not valid log message');
            return false;
        }
        
        $context = $this->getOption('context',[]);
       
        $arikaim->get('logger')->info($message,$context);
    }

    /**
    * Init properties descriptor
    *
    * @return void
    */
    protected function initDescriptor(): void
    {
        $this->descriptor->get('options')->property('message',function($property) {
            $property
                ->title('Message')
                ->type('text-area')  
                ->required(true)                    
                ->readonly(false);              
        }); 

        $this->descriptor->get('options')->property('context',function($property) {
            $property
                ->title('Context')
                ->type('array')    
                ->required(false)                              
                ->readonly(false);              
        }); 
    }
}
