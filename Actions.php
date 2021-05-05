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
        $this->addApiRoute('PUT','/api/admin/actions/start','ActionsControlPanel','start','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/import','ActionsControlPanel','import','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/action/config','ActionsControlPanel','saveConfig','session'); 
        // workflows 
        $this->addApiRoute('POST','/api/admin/actions/workflow/add','WorkflowsControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/actions/workflow/update','WorkflowsControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/actions/workflow/delete/{uuid}','WorkflowsControlPanel','delete','session');     
        $this->addApiRoute('PUT','/api/admin/actions/workflow/status','WorkflowsControlPanel','setStatus','session'); 
        // workflow editor
        $this->addApiRoute('POST','/api/admin/actions/workflow/editor/add','WorkflowEditorControlPanel','createItem','session');   
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/update','WorkflowEditorControlPanel','updateItem','session');       
        $this->addApiRoute('DELETE','/api/admin/actions/workflow/editor/delete/{uuid}','WorkflowEditorControlPanel','deleteItem','session');     
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/status','WorkflowEditorControlPanel','setStatus','session'); 

        // Create db tables
        $this->createDbTable('ActionsSchema');     
        $this->createDbTable('WorkflowsSchema');               
        $this->createDbTable('WorkflowItemsSchema');                  
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
