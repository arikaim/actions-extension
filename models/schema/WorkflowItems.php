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
 * Workflow database table schema definition.
 */
class WorkflowItems extends Schema  
{   
    /**
     * Db table name
     *
     * @var string
     */ 
    protected $tableName = 'workflow_items';

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
        $table->relation('workflow_id','workflows');
        $table->status();
        $table->text('rule_condition')->nullable(true);
        $table->string('trigger_type')->nullable(true);
        $table->string('trigger_value')->nullable(true);
        $table->string('action')->nullable(true);      
        $table->text('action_options')->nullable(true);   

        $table->options();
        $table->dateCreated();

        // indexes              
        $table->index('action');
        $table->index('trigger_type');
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
