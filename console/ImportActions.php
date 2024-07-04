<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
 */
namespace Arikaim\Extensions\Actions\Console;

use Arikaim\Core\Console\ConsoleCommand;
use Arikaim\Core\Db\Model;
use Arikaim\Extensions\Actions\Rules\Rule;

use Arikaim\Core\Actions\Actions;

/**
 * Run rule command
 */
class ImportActions extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('actions:import')->setDescription('Import actions.');        
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function executeCommand($input, $output)
    {       
        global $arikaim;

        $this->showTitle();
    
        $this->writeLn('From extensions:');

        $action = Actions::create('ImportActions','actions',[
            'package_name' => 'telegram',
            'package_type' => 'extension'
        ])->getAction();
         
        $action->run();


        $this->writeLn('Imported:' . $action->get('imported'));

        $this->showCompleted();
    }
}
