/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ContorlPanelActions() {

    this.saveConfig = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/action/config',formId,onSuccess,onError);      
    };

    this.import = function(packageName, onSuccess, onError) {
        var data = {
            package: packageName
        };
        
        return arikaim.put('/api/admin/actions/import',data,onSuccess,onError);      
    };   
}

var adminActions = new ContorlPanelActions();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.actions-tab-item','actions_content');   
});
