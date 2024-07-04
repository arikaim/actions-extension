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
use Arikaim\Core\Db\Traits\OptionsAttribute;

/**
 * Actions database model
 */
class Actions extends Model
{
    use Uuid,
        OptionsAttribute,
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
     * Find action
     *
     * @param mixed $key
     * @return object|null
     */
    public function findAction($key): ?object
    {
        $model = $this->findByColumn($key,'name');
        if ($model == null) {
            $model = $this->findByColumn($key,'handler_class');
        }

        return ($model == null) ? $this->findById($key) : $model;
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

        $model = $this->findAction($name);
        if ($model == null) {
            $model = $this->findAction($handlerClass);
        }

        if ($model !== null) {
            return ($model->update($data) !== false);
        }

        $model = $this->create($data);

        return ($model !== null);
    }
}
