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
 * Actions database table schema definition.
 */
class ActionsSchema extends Schema  
{   
    /**
     * Db table name
     *
     * @var string
     */ 
    protected $tableName = 'actions';

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
        $table->string('name')->nullable(true);
        $table->string('handler_class')->nullable(false);      
        $table->string('extension_name')->nullable(true);
        $table->string('module_name')->nullable(true);
        $table->text('config')->nullable(true);
        // indexes         
        $table->unique('name');
        $table->index('extension_name');
        $table->index('module_name');
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
