<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions;

use Arikaim\Core\Extension\Extension;

/**
 * Actions extension class
 */
class Actions extends Extension
{
    /**
     * Install extension
     *
     * @return void
     */
    public function install()
    {
        // Control Panel
        $this->addApiRoute('PUT','/api/admin/actions/import','ActionsControlPanel','import','session'); 
       // $this->addApiRoute('PUT','/api/admin/actions/action/config','ActionsControlPanel','saveConfig','session'); 
      //  $this->addApiRoute('PUT','/api/admin/actions/action/settings','ActionsControlPanel','saveSettings','session'); 
        // Api 
      //  $this->addApiRoute('PUT','/api/actions/run','ActionsApi','run',['public','token']); 
        // Create db tables
        $this->createDbTable('Actions');     
       // $this->createDbTable('Workflows');               
       // $this->createDbTable('WorkflowItems');  
       // $this->createDbTable('Rules');     
       // $this->createDbTable('RuleTriggers');     
        // Services
        $this->registerService('Actions');  
        // Console
        $this->registerConsoleCommand('RunRule');             
        $this->registerConsoleCommand('ImportActions');                 
    }
    
    /**
     * UnInstall extension
     *
     * @return void
     */
    public function unInstall()
    {  
    }
}
