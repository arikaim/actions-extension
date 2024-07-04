/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ContorlPanelActions() {

   // this.saveConfig = function(formId, onSuccess, onError) {
   //     return arikaim.put('/api/admin/actions/action/config',formId,onSuccess,onError);      
  //  };

    this.saveSettings = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/action/settings',formId,onSuccess,onError);      
    };

    this.import = function(packageName, packageType, onSuccess, onError) {
      
        return arikaim.put('/api/admin/actions/import',{
            package: packageName,
            type: packageType
        },onSuccess,onError);      
    };   
}

var adminActions = new ContorlPanelActions();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.actions-tab-item','actions_content');   
});
