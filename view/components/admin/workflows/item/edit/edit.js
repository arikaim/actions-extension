'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.addRules('#workflow_item_form');

    arikaim.ui.button('.cancel-button',function(element) {
        workflowEditor.hideEditPanel();
    });

    arikaim.ui.form.onSubmit("#workflow_item_form",function() {  
        return workflowEditor.updateCondition('#workflow_item_form');
    },function(result) { 
        arikaim.page.toastMessage(result.message);
        workflowEditorView.loadConditionDetails(result.uuid);
        workflowEditor.hideEditPanel();       
    });   
});
