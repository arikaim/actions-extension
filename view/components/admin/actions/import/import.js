'use strict';

arikaim.component.onLoaded(function() {  
    $('#extensions_dropdown').dropdown({
        onChange: function(name) {              
            arikaim.page.loadContent({
                id: 'import-details',
                component: "actions::admin.actions.import.details",
                params: { extension_name : name },
                useHeader: true
            });     
        }
    });   
});