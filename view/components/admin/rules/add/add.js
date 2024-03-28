'use strict';

arikaim.component.onLoaded(function() { 
    arikaim.ui.form.onSubmit("#rule_form",function() {  
        return currency.add('#rule_form');
    },function(result) {
        arikaim.ui.form.clear('#rule_form');
        arikaim.ui.form.showMessage(result.message);
    });
});