/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
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

    this.updateCondition = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/workflow/editor/condition',data,onSuccess,onError);          
    };

    this.updateConfig = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/workflow/editor/config',data,onSuccess,onError);          
    };

    this.pushActionJob = function(uuid, onSuccess, onError) {
        var data = {
            uuid: uuid
        };
        
        return arikaim.put('/api/admin/actions/workflow/editor/job',data,onSuccess,onError);          
    };

    this.hideEditPanel = function hideEditPanel() {
        $('#item_edit_content').html('');
        $('#item_edit_content').addClass('hidden');
    }

    this.init = function() {     
        $('.workflows-dropdown').dropdown({
            onChange: function(value) {
                return arikaim.page.loadContent({
                    id: 'editor_content',           
                    component: 'actions::admin.workflows.view',
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
