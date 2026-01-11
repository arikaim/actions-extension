'use strict';

arikaim.component.onLoaded(function() {
    safeCall('workflowEditorView',function(obj) {
        obj.initRows();
    },true);   
});