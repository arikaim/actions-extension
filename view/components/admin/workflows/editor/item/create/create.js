'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.cancel-button',function(element) {
        $('#new_workflow_item').html('');
    });

    arikaim.ui.form.onSubmit("#workflow_item_form",function() {  
        return workflowEditor.add('#workflow_item_form');
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

        arikaim.page.loadContent({
            id: 'condition_content',           
            component: 'actions::admin.workflows.editor.item.condition.form',
            params: { 
                uuid: result.uuid                           
            }            
        },function(result) {
            arikaim.ui.form.onSubmit("#condition_form",function() {  
                return workflowEditor.updateCondition('#condition_form');
            },function(result) { 
                return arikaim.page.loadContent({
                    id: 'action_config_content',           
                    component: 'actions::admin.workflows.editor.item.condition',
                    params: { uuid: result.uuid }            
                }); 
            });
        });  
    });
});
