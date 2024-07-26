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
        $this->writeLn('Import from extensions');

        $extensions = $arikaim->get('packages')->create('extension')->getPackages(true);
        foreach ($extensions as $extension) {
            $this->writeLn($extension,'  ','green');
            $action = Actions::create('ImportActions','actions',[
                'package_name' => $extension,
                'package_type' => 'extension'
            ])->run();
        }

        $this->writeLn('');
        $this->writeLn('Import from modules');

        $modules = $arikaim->get('packages')->create('module')->getPackages(true);
        foreach ($modules as $module) {
            $this->writeLn($module,'  ','green');
            $action = Actions::create('ImportActions','actions',[
                'package_name' => $module,
                'package_type' => 'module'
            ])->run();
        }
      
        $this->showCompleted();
    }
}
