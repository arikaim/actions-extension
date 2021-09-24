'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.cancel-button',function(element) {
        var uuid = $('#uuid').val();

        return arikaim.page.loadContent({
            id: 'config_content_' + uuid,           
            component: 'actions::admin.workflows.editor.item.config',
            params: { uuid: uuid }            
        });  
    });

    arikaim.ui.form.onSubmit("#config_form",function() {  
        return workflowEditor.updateConfig('#config_form');
    },function(result) { 
        return arikaim.page.loadContent({
            id: 'config_content_' + result.uuid,           
            component: 'actions::admin.workflows.editor.item.config',
            params: { uuid: result.uuid }            
        }); 
    });
});