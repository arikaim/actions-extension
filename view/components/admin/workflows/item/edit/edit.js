'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.addRules('#workflow_item_form');

    arikaim.ui.button('.cancel-button',function(element) {
        $('#item_edit_content').html('');
        $('#item_edit_content').addClass('hidden');
    });

    arikaim.ui.form.onSubmit("#workflow_item_form",function() {  
        return workflowEditor.updateCondition('#workflow_item_form');
    },function(result) { 
              
    });
});
