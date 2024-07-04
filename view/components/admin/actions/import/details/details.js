'use strict';

arikaim.component.onLoaded(function() {  
    arikaim.ui.button('.import-actions',function(element) {
        var packageName = $(element).attr('package-name');
        var packageType = $(element).attr('package-type');

        return adminActions.import(packageName,packageType,function(result) {
            arikaim.page.toastMessage(result.message);                                  
        });
    });
});