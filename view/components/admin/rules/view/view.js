/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function ActionsView() {
    var self = this;

    this.init = function() {     
        paginator.init('actions_rows',"actions::admin.actions.view.items",'actions'); 
    };

    this.loadJobItem = function(uuid) {
        return arikaim.page.loadContent({
            id: 'row_' + uuid,           
            component: 'queue::admin.jobs.view.item',
            params: { uuid: uuid }            
        },function(result) {
            self.initRows();
        });  
    };

    this.initRows = function() {
        arikaim.ui.button('.action-details',function(element) {
            var uuid = $(element).attr('uuid'); 
            return arikaim.page.loadContent({
                id: 'action_details',           
                component: 'actions::admin.actions.details',
                params: { uuid: uuid }            
            });  
        });

        arikaim.ui.button('.action-docs',function(element) {
            var uuid = $(element).attr('uuid'); 
            return arikaim.page.loadContent({
                id: 'action_details',           
                component: 'actions::admin.actions.help.api',
                params: { uuid: uuid }            
            });  
        });

        arikaim.ui.button('.action-settings',function(element) {
            var uuid = $(element).attr('uuid'); 
            return arikaim.page.loadContent({
                id: 'action_details',           
                component: 'actions::admin.actions.settings',
                params: { uuid: uuid }            
            });  
        });
    };
}

var actionsView = createObject(ActionsView,ControlPanelView);

arikaim.component.onLoaded(function() {
    actionsView.init();
    actionsView.initRows();
});