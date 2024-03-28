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

/**
 * ActionRecurringJob job decorator
 */
class ActionRunJob extends Job
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
        $this->setName('action.run');
    }

    /**
     * Run job
     *
     * @return mixed
     */
    public function execute()
    {
        $config = $this->getConfigProperties();  
 
        $jobClass = $config->getValue('job_class');
        $job = new $jobClass($this->getExtensionName(),$this->getName(),$this->params);

        if ($job instanceof ConfigPropertiesInterface) {
            $job->setConfigProperties($config);
        }

        return $job->execute();
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
