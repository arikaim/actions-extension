/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function WorkflowView() {
    var self = this;

    this.init = function() {     
        paginator.init('workflow_rows',"actions::admin.workflows.view.items",'workflow'); 

        arikaim.ui.button('.create-action-item',function(element) {
            var workflow = $(element).attr('workflow');
            
            console.log('in');
            
            return arikaim.page.loadContent({
                id: 'new_workflow_item',           
                component: 'actions::admin.workflows.item.form',
                params: { workflow: workflow }            
            });  
        });
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
                id: 'job_details',           
                component: 'actions::admin.actions.details',
                params: { uuid: uuid }            
            });  
        });
    };
}

var workflowView = createObject(WorkflowView,ControlPanelView);

arikaim.component.onLoaded(function() {
    workflowView.init();
    workflowView.initRows();
});