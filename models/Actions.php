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

/**
 * Actions database model
 */
class Actions extends Model
{
    use Uuid,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'name',
        'handler_class',      
        'package_name',
        'package_type',
        'allow_http_execution',
        'secret',
        'config'
    ];
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = 'actions';

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
     * Find action
     *
     * @param mixed $key
     * @return object|null
     */
    public function findAction($key): ?object
    {
        $model = $this->findByColumn($key,'name');

        return ($model == null) ? $this->findById($key) : $model;
    }

    /**
     * Save action config
     *
     * @param string|int $id
     * @param array $config
     * @return boolean
     */
    public function saveActionConfig($id, array $config): bool
    {
        $model = $this->findById($id);
        if (empty($model) == true) {
            $model = $this->findByColumn($id,'name');
        }
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
