<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Models\Schema;

use Arikaim\Core\Db\Schema;

/**
 * Rule triggers database table schema definition.
 */
class RuleTriggers extends Schema  
{   
    /**
     * Db table name
     *
     * @var string
     */ 
    protected $tableName = 'rule_triggers';

    /**
     * Create table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function create($table) 
    {            
        // columns
        $table->id();
        $table->prototype('uuid');
        $table->status();
        $table->relation('rule_id','rules');
        $table->string('key')->nullable(false);
        $table->integer('type')->nullable(false)->default(1);
        // indexes         
        $table->unique(['rule_id','key','type']);       
    }

    /**
     * Update table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function update($table)
    {       
    }
}
