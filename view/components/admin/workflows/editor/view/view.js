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
          
            return arikaim.page.loadContent({
                id: 'new_workflow_item',           
                component: 'actions::admin.workflows.editor.item.create',
                params: { workflow: workflow }            
            });  
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
                    arikaim.ui.table.removeRow('#row_' + uuid);     
                });
            });                 
        });
    };
}

var workflowEditorView = createObject(WorkflowEditorView,ControlPanelView);

arikaim.component.onLoaded(function() {
    workflowEditorView.init();
    workflowEditorView.initRows();
});