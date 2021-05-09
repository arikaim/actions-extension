'use strict';

arikaim.component.onLoaded(function() {
    $('.schedule-date').calendar({
        type: 'datetime',
        today: true,
        onChange: function(value) {           
        }
    });

    $('.condition-dropdown').dropdown({
        onChange: function(value) {
            $('.condition-type').addClass('hidden');
            if (value == 'scheduled') {               
                $('.scheduled-type').removeClass('hidden');
                $('.scheduled-type').show();
            }
            if (value == 'recurring') {
                $('.recurring-type').removeClass('hidden');
                $('.recurring-type').show();
            }           
        }
    });

    arikaim.ui.button('.cancel-button',function(element) {
        var uuid = $('#uuid').val();

        return arikaim.page.loadContent({
            id: 'condition_content_' + uuid,           
            component: 'actions::admin.workflows.editor.item.condition',
            params: { uuid: uuid }            
        });  
    });
});
