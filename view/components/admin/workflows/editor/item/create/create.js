'use strict';

arikaim.component.onLoaded(function() {
   // arikaim.ui.form.addRules('#workflow_item_form',{});

    arikaim.ui.form.onSubmit("#workflow_item_form",function() {  
        return workflowEditor.add('#workflow_item_form');
    },function(result) {
        $('#action_select').state('removeState','active');
        $('#action_config').state('setState','active');  
    });
});
