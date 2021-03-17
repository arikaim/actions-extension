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
        'extension_name',
        'module_name',
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
     * Save action config
     *
     * @param string|int $id
     * @param array $config
     * @return boolean
     */
    public function saveJobConfig($id, array $config): bool
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
}
