'use strict';

arikaim.component.onLoaded(function() {
    $('.schedule-date').calendar({
        type: 'datetime',
        today: true,
        onChange: function(value) {           
        }
    });
});
