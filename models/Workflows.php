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
use Arikaim\Core\Db\Traits\DateCreated;
use Arikaim\Core\Db\Traits\UserRelation;
use Arikaim\Core\Db\Traits\Slug;

/**
 * Workflows database model
 */
class Workflows extends Model
{
    use Uuid,
        DateCreated,
        Slug,
        UserRelation,
        Find;
 
    /**
     * Fillable attributes
     *
     * @var array
    */
    protected $fillable = [
        'uuid',
        'title',
        'user_id',      
        'note',
        'slug',
        'date_created',
        'status'       
    ];
    
    /**
     * Db table name
     *
     * @var string
     */
    protected $table = 'workflows';

    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find workflow
     *
     * @param string $slug
     * @return Model|null
     */
    public function findWorkflow(string $slug): ?object
    {
        $model = $this->findBySlug($slug);

        return ($model == null) ? $this->findById($slug) : $model;
    } 

    /**
     * Save or update workflow
     *
     * @param string $slug
     * @param array $data
     * @return boolean
     */
    public function saveWorkflow(string $slug, array $data): bool
    {
        $model = $this->findWorkflow($slug);
        if ($model != null) {
            return (bool)$model->update($data); 
        }
        $data['slug'] = $slug;
        $data['title'] = (empty($data['title']) == true) ?  $data['slug'] : $data['title'];
        $created = $this->create($data);

        return ($created != null);
    }
}
