/**
 *  Arikaim
 *  @copyright  Copyright (c) Konstantin Atanasov <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function Actions() {

    this.saveConfig = function(formId, onSuccess, onError) {
        return arikaim.put('/api/admin/actions/action/config',formId,onSuccess,onError);      
    }
}

var actions = new Actions();
