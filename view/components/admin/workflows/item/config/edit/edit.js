'use strict';

arikaim.component.onLoaded(function() {

    arikaim.ui.button('.cancel-button',function(element) {
        workflowEditor.hideEditPanel();  
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