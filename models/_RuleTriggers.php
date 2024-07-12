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
 * Rule triggers database model
 */
class RuleTriggers extends Model
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
        'rule_id',
        'key',
        'type'
    ];
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = 'rule_triggers';

    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    
}
