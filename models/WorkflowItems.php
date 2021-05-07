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

/**
 * Workflow items database model
 */
class WorkflowItems extends Model
{
    use Uuid,
        DateCreated,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'action_id',
        'workflow_id',      
        'condition_type',
        'condition_value',
        'job_id',
        'date_created',
        'status',     
        'config'
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

    /**
     * Mutator (get) for config attribute.
     *
     * @return array
     */
    public function getConfigAttribute()
    {
        return (empty($this->attributes['config']) == true) ? [] : \json_decode($this->attributes['config'],true);
    }
    
    /**
     * Save action config
     *   
     * @param array $config
     * @param string|int|null $id
     * @return boolean
     */
    public function saveConfig(array $config, $id = null): bool
    {
        $model = (empty($id) == true) ? $this : $this->findById($id);      
        if (empty($model) == true) {
            return false;
        }

        return (bool)$model->update([
            'config' => \json_encode($config)
        ]);
    }   
    
    /**
     * Action relation
     *
     * @return Relation|null
     */
    public function action()
    {
        return $this->belongsTo(Actions::class,'action_id');
    }   
}
