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

/**
 * Run rule command
 */
class RunRule extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('rule:run')->setDescription('Run rule.'); 
        //$this->addOptionalArgument('id','User id or uuid');
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
    
        
        $arikaim->get('event')->addDispatchEventJob('myevent',[
            'param1' => 100
        ]);
  //      $variables = Rule::getVariables('test');
        
//        print_r($variables);

        $this->showCompleted();
    }
}
