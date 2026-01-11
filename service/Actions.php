<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Service;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;

/**
 * Actions service class
*/
class Actions extends Service implements ServiceInterface
{
    /**
     * Init
     */
    public function boot()
    {
        $this->setServiceName('actions');
    }

    /**
     * Create workflow
     *
     * @param string $slug
     * @param string $title
     * @param integer|null $userId    
     * @param string|null $note
     * @return boolean
     */
    public function createWorkflow(string $slug, string $title = null, ?int $userId = null, ?string $note = null): bool
    {
        return Model::Workflows('actions')->saveWorkflow($slug,[
            'title'   => $title,
            'note'    => $note,            
            'user_id' => $userId
        ]);
    }
}
