'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.close-button',function(element) {
        $('#action_details').html('');
    });
});