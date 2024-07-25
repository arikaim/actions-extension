/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function WorkflowEditorView() {
    var self = this;

    this.init = function() {     
        this.loadMessages('actions::admin.workflows.editor');

        paginator.init('workflow_rows',"actions::admin.workflows.editor.items",'workflow'); 
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
}

var workflowEditorView = createObject(WorkflowEditorView,ControlPanelView);

arikaim.component.onLoaded(function() {
    workflowEditorView.init();
    workflowEditorView.initRows();
});