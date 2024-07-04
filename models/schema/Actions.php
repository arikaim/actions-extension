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
class Actions extends Schema  
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
        $table->string('package_name')->nullable(true);
        $table->string('package_type')->nullable(true);
        $table->integer('allow_http_execution')->nullable(true);
        $table->string('secret')->nullable(true);
        $table->options();
        // indexes         
        $table->unique('name');
        $table->unique('handler_class');
        
        $table->index('package_name');       
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
