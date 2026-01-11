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
use Arikaim\Core\Utils\Uuid;
use Arikaim\Core\Extension\Extension;

/**
 * Workflows database table schema definition.
 */
class Workflows extends Schema  
{   
    /**
     * Db table name
     *
     * @var string
     */ 
    protected $tableName = 'workflows';

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
        $table->userId();
        $table->status();
        $table->string('title')->nullable(false);     
        $table->slug();   
        $table->text('note')->nullable(true);
        $table->dateCreated();
        // indexes              
        $table->index('title');
        $table->index(['title','user_id']);       
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

    /**
     * Insert or update rows in table
     *
     * @param Seed $seed
     * @return void
     */
    public function seeds($seed)
    {
        $items = Extension::loadJsonConfigFile('workflows.json','actions');
        $seed->createFromArray(['title'],$items,function($item) {
            $item['uuid'] = Uuid::create();          
            return $item;
        });
    }
}
