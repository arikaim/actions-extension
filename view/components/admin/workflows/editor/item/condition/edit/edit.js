'use strict';

arikaim.component.onLoaded(function() { 
    arikaim.ui.form.onSubmit("#condition_form",function() {  
        return workflowEditor.updateCondition('#condition_form');
    },function(result) { 
        return arikaim.page.loadContent({
            id: 'condition_content_' + result.uuid,           
            component: 'actions::admin.workflows.editor.item.condition',
            params: { uuid: result.uuid }            
        }); 
    });
});
