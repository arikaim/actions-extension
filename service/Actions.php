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
use Arikaim\Core\Interfaces\ConfigPropertiesInterface;
use Arikaim\Core\Arikaim;

/**
 * Actions service class
*/
class Actions extends Service implements ServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
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
        $model = Model::Workflows('actions');
        
        return $model->saveWorkflow($slug,[
            'title'   => $title,
            'note'    => $note,            
            'user_id' => $userId
        ]);
    }

    /**
     * Import job(s) from extension into actions
     *
     * @param string $packageName
     * @param string $packageType
     * @return integer
     */
    public function importActions(string $packageName, string $packageType = 'extension'): int
    {
        $actions = Model::Actions('actions');
        $packageManager = Arikaim::get('packages')->create($packageType);
        $properties = $packageManager->getPackageProperties($packageName,true);
        $imported = 0;

        foreach ($properties['jobs'] as $item) {
            $item['handler_class'] = $item['class'];
            $item['package_name'] = $packageName;
            $item['package_type'] = $packageType;

            // create job action 
            $job = Arikaim::get('queue')->create($item['handler_class']);
            $config = ($job instanceof ConfigPropertiesInterface) ? $job->createConfigProperties() : [];
            $item['config'] = \json_encode($config);

            $result = $actions->saveAction($item);
            $imported += ($result == true) ? 1 : 0;
        }
        
        return $imported;
    }
}
