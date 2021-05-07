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
class WorkflowItemsSchema extends Schema  
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
        $table->relation('action_id','actions');  
        $table->integer('job_id')->nullable(true);    
        $table->string('condition_type')->nullable(true);      
        $table->string('condition_value')->nullable(true);   
        $table->text('config')->nullable(true);
        $table->dateCreated();

        // indexes              
        $table->index('condition_type');
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
