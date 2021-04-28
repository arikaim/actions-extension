'use strict';

arikaim.component.onLoaded(function() {  
    arikaim.ui.button('.import-actions',function(element) {
        var packageName = $(element).attr('package-name');
        
        adminActions.import(packageName,function(result) {

        });
    });
});