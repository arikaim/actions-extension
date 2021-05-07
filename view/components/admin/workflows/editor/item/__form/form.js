'use strict';

arikaim.component.onLoaded(function() {
    $('.condition-dropdown').dropdown({
        onChange: function(value) {
            return arikaim.page.loadContent({
                id: 'condition_content',           
                component: 'actions::admin.condition.params',
                params: { condition: value }            
            });  
        }
    });
});
