<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Jobs;

use Arikaim\Core\Queue\Jobs\Job;
use Arikaim\Core\Collection\Traits\ConfigProperties;
use Arikaim\Core\Collection\Properties;
use Arikaim\Core\Interfaces\ConfigPropertiesInterface;
use Arkaim\Core\Actions\Actions;

/**
 * Run action
 */
class RunActionJob extends Job implements ConfigPropertiesInterface
{
    use 
        ConfigProperties;

        /**
     * Init job
     *
     * @return void
     */
    public function init(): void
    {
        $this->setName('run.action');
    }

    /**
     * Run job
     *
     * @return mixed
     */
    public function execute()
    {
        $config = $this->getConfigProperties();  
 
        $actionName = $config->getValue('action_name');
        $packageName = $config->getValue('package_name');

        $action = Actions::create($actionName,$packageName,$config)->run();
        if ($action->hasError() == true) {

        }
    }

    /**
     * Init config properties
     *
     * @param Properties $properties
     * @return void
     */
    public function initConfigProperties(Properties $properties): void
    {
    }
}
