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
 * Rules database model
 */
class Rules extends Model
{
    use Uuid,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'status',
        'user_id',      
        'package_name',
        'category',
        'title',
        'description',
        'code',
        'options'
    ];
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = 'rules';

    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    
}
