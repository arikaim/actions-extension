'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#condition_form",function() {  
        return workflowEditor.saveCondition('#condition_form');
    },function(result) { 
        arikaim.page.loadContent({
            id: 'action_select_config',           
            component: 'actions::admin.actions.details',
            params: { 
                uuid: result.action_id,              
                table_class: 'mini',
                hide_config: true
            }            
        });  
    });
});
