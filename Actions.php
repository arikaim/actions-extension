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
        // Create db tables
        $this->createDbTable('Actions');           
        $this->createDbTable('Workflows');               
        $this->createDbTable('WorkflowItems');  
        // Services
        $this->registerService('Actions');  
        // Console    
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
