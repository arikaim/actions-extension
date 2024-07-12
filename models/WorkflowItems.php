<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Extensions\Actions\Models\Actions;
use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\DateCreated;
use Arikaim\Core\Db\Traits\OptionsAttribute;

/**
 * Workflow items database model
 */
class WorkflowItems extends Model
{
    use Uuid,
        DateCreated,
        OptionsAttribute,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'workflow_id', 
        'rule_condition',    
        'trigger_type',
        'trigger_value',
        'action',
        'action_options',
        'date_created',
        'status',     
        'options'
    ];
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = 'workflow_items';

    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

}
