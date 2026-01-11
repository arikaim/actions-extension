'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.close-button',function(element) {
        $('#action_details').html('');
    });
    // form init
    arikaim.ui.form.addRules('#action_settings_form');
    arikaim.ui.form.onSubmit("#action_settings_form",function() {  
        return adminActions.saveSettings('#action_settings_form');
    },function(result) { 
        arikaim.ui.form.showMessage(result.message);   
    });
});