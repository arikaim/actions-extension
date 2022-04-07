'use strict';

arikaim.component.onLoaded(function() {
    $('#scheduled_condition').checkbox({
        onChecked: function() {
            arikaim.page.loadContent({
                id: 'condition_content',           
                component: 'actions::admin.condition.schedule',
                params: {

                }            
            }); 
        }
    });
    $('#recurring_condition').checkbox({
        onChecked: function() {
           arikaim.page.loadContent({
                id: 'condition_content',           
                component: 'actions::admin.condition.recurring',
                params: {
                    
                }            
            }); 
        }
    });
    $('#event_condition').checkbox({
        onChecked: function() {
            arikaim.page.loadContent({
                id: 'condition_content',           
                component: 'actions::admin.condition.event',
                params: {
                    
                }            
            }); 
        }
    });
});
