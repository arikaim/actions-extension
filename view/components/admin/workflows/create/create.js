'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.addRules('#workflow_form');

    arikaim.ui.form.onSubmit("#workflow_form",function() {  
        return workflows.add('#workflow_form');
    },function(result) { 
        arikaim.page.toastMessage(result.message);   

        arikaim.page.loadContent({
            id: 'workflows_content',           
            component: 'actions::admin.workflows.editor',
            params: { uuid: result.uuid }            
        });  
    });
});
