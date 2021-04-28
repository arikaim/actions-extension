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

use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\DateCreated;
use Arikaim\Core\Db\Traits\UserRelation;

/**
 * Workflow items database model
 */
class WorkflowItems extends Model
{
    use Uuid,
        DateCreated,
        UserRelation,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'action',
        'user_id',      
        'condition_type',
        'condition_value',
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
     * @param string|int $id
     * @param array $config
     * @return boolean
     */
    public function saveConfig($id, array $config): bool
    {
        $model = $this->findById($id);      
        if (empty($model) == true) {
            return false;
        }

        return (bool)$model->update([
            'config' => \json_encode($config)
        ]);
    }

    /**
     * Create or update action
     *
     * @param array $data
     * @return boolean
     */
    public function saveAction(array $data): bool
    {
        $name = $data['name'] ?? null;
        $handlerClass = $data['handler_class'] ?? null;
        if (empty($name) == true || empty($handlerClass) == true) {
            return false;
        }

        $model = $this->findByColumn($handlerClass,'handler_class');
        $result = (\is_object($model) == true) ? $model->update($data) : $this->create($data);

        return (\is_object($result) == true) ? true : (bool)$result;
    }
}
