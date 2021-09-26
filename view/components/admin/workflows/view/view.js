/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function WorkflowEditorView() {
    var self = this;

    this.init = function() {     
        this.loadMessages('actions::admin.workflows.editor');

        paginator.init('workflow_rows',"actions::admin.workflows.editor.items",'workflow'); 

        $('.workflows-dropdown').dropdown({
            onChange: function(value) {
                return arikaim.page.loadContent({
                    id: 'editor_content',           
                    component: 'actions::admin.workflows.editor.view',
                    params: { uuid: value }            
                });  
            }
        });

        arikaim.ui.button('.create-action-item',function(element) {
            var workflow = $(element).attr('workflow');
            $('#item_edit_content').removeClass('hidden');
            
            return arikaim.page.loadContent({
                id: 'item_edit_content',           
                component: 'actions::admin.workflows.item.create',
                params: { workflow: workflow }            
            });  
        });
    };

    this.loadConditionDetails = function(uuid) {
        return arikaim.page.loadContent({
            id: 'condition_content_' + uuid,           
            component: 'actions::admin.condition.details',
            params: { uuid: uuid }            
        });  
    };

    this.loadItems = function(workflowId) {
        return arikaim.page.loadContent({
            id: 'workflow_items',           
            component: 'actions::admin.workflows.view.items',
            params: { 
                workflow_id: workflowId 
            }            
        });
    };

    this.initRows = function() {
        
        arikaim.ui.button('.delete-item',function(element) {
            var uuid = $(element).attr('uuid'); 
            
            return modal.confirmDelete({ 
                title: self.getMessage('delete.title'),
                description: self.getMessage('delete.content')
            },function() {
                workflowEditor.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('.row-' + uuid);     
                });
            });                 
        });

        arikaim.ui.button('.edit-item-condition',function(element) {
            var uuid = $(element).attr('uuid');
            $('#item_edit_content').removeClass('hidden');
            
            return arikaim.page.loadContent({
                id: 'item_edit_content',           
                component: 'actions::admin.workflows.item.edit',
                params: { uuid: uuid }            
            });  
        });

        arikaim.ui.button('.edit-item-config',function(element) {
            var uuid = $(element).attr('uuid');
            $('#item_edit_content').removeClass('hidden');

            return arikaim.page.loadContent({
                id: 'item_edit_content',           
                component: 'actions::admin.workflows.item.config.edit',
                params: { uuid: uuid }            
            });  
        });

        arikaim.ui.button('.push-queue-button',function(element) {
            var uuid = $(element).attr('uuid');
 
            workflowEditor.pushActionJob(uuid,function(result) {
                console.log(result);
            });
        });
    };
}

var workflowEditorView = createObject(WorkflowEditorView,ControlPanelView);

arikaim.component.onLoaded(function() {
    workflowEditorView.init();
    workflowEditorView.initRows();
});