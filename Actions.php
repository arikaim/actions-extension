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
        $this->addApiRoute('PUT','/api/admin/actions/action/config','ActionsControlPanel','saveConfig','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/action/settings','ActionsControlPanel','saveSettings','session'); 
        // workflows 
        $this->addApiRoute('POST','/api/admin/actions/workflow/add','WorkflowsControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/actions/workflow/update','WorkflowsControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/actions/workflow/delete/{uuid}','WorkflowsControlPanel','delete','session');     
        $this->addApiRoute('PUT','/api/admin/actions/workflow/status','WorkflowsControlPanel','setStatus','session'); 
        // workflow editor
        $this->addApiRoute('POST','/api/admin/actions/workflow/editor/add','WorkflowEditorControlPanel','createItem','session');   
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/update','WorkflowEditorControlPanel','updateItem','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/condition','WorkflowEditorControlPanel','updateCondition','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/config','WorkflowEditorControlPanel','updateConfig','session');      
        $this->addApiRoute('DELETE','/api/admin/actions/workflow/editor/delete/{uuid}','WorkflowEditorControlPanel','deleteItem','session');     
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/status','WorkflowEditorControlPanel','setStatus','session'); 
        $this->addApiRoute('PUT','/api/admin/actions/workflow/editor/job','WorkflowEditorControlPanel','pushActionJob','session'); 
        
        // Api 
        $this->addApiRoute('PUT','/api/actions/run','ActionsApi','run',['public','token']); 
        $this->addApiRoute('POST','/api/actions/run','ActionsApi','run',['public','token']); 
        $this->addApiRoute('GET','/api/actions/run','ActionsApi','run',['public','token']); 
        
        // Create db tables
        $this->createDbTable('ActionsSchema');     
        $this->createDbTable('WorkflowsSchema');               
        $this->createDbTable('WorkflowItemsSchema');  
        
        // Services
        $this->registerService('Actions');                
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
