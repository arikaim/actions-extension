/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function WorkflowEditor() {
  
    this.add = function(data, onSuccess, onError) {
        return arikaim.post('/api/admin/actions/workflow/editor/add',data,onSuccess,onError);          
    };

    this.update = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/workflow/editor/update',data,onSuccess,onError);          
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/actions/workflow/editor/delete/' + uuid,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) {
        var data = {
            uuid: uuid,
            status: status
        };

        return arikaim.put('/api/admin/actions/workflow/editor/status',data,onSuccess,onError);          
    };   

    this.init = function() {     
        $('.workflows-dropdown').dropdown({
            onChange: function(value) {
                return arikaim.page.loadContent({
                    id: 'editor_content',           
                    component: 'actions::admin.workflows.editor.view',
                    params: { uuid: value }            
                });  
            }
        });       
    };    
}

var workflowEditor = new WorkflowEditor();

arikaim.component.onLoaded(function() {
    workflowEditor.init();  
});