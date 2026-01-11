'use strict';

arikaim.component.onLoaded(function() {
    $('.workflows-dropdown').dropdown({
        onChange: function(value) {
            return arikaim.page.loadContent({
                id: 'workflow_items',           
                component: 'actions::admin.workflows.view.items',
                params: { uuid: value }            
            });  
        }
    });      
});
