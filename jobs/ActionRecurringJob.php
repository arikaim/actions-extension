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

use Arikaim\Core\Queue\Jobs\RecurringJob;
use Arikaim\Core\Collection\Traits\ConfigProperties;
use Arikaim\Core\Collection\Properties;

use Arikaim\Core\Interfaces\ConfigPropertiesInterface;
use Arikaim\Core\Interfaces\Job\JobInterface;
use Arikaim\Core\Interfaces\Job\RecurringJobInterface;

/**
 * ActionRecurringJob job decorator
 */
class ActionRecurringJob extends RecurringJob implements JobInterface, RecurringJobInterface, ConfigPropertiesInterface
{
    use 
        ConfigProperties;

    /**
     * Constructor
     *  
     * @param string|null $extension
     * @param string|null $name
     * @param array $params
     */
    public function __construct(?string $extension, ?string $name = null, array $params = [])
    {
        parent::__construct($extension,$name,$params);       
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
