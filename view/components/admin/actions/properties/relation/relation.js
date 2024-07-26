'use strict';

arikaim.component.onLoaded(function() {
    $('.relation-dropdown').dropdown({
        onChange: function(selected) {
            var fieldId = $(this).attr('field-id');
            $('#' + fieldId).val(selected);
        }
    });
});