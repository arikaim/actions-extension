/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function RulesAdminApi() {

    this.add = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/rule/add',formId,onSuccess,onError);      
    };

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/rule/update',formId,onSuccess,onError);      
    };
}

var rulesApi = new RulesAdminApi();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.rules-tab-item','rules_content');   
});
