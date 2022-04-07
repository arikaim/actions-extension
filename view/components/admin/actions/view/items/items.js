'use strict';

arikaim.component.onLoaded(function() {
    safeCall('actionsView',function(obj) {
        obj.initRows();
    },true);   
});