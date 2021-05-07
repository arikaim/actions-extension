<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Arcade\Jobs;

use Arikaim\Core\Queue\Jobs\ScheduledJob;
use Arikaim\Core\Collection\Traits\ConfigProperties;
use Arikaim\Core\Collection\Properties;

use Arikaim\Core\Interfaces\ConfigPropertiesInterface;
use Arikaim\Core\Interfaces\Job\JobInterface;
use Arikaim\Core\Interfaces\Job\ScheduledJobInterface;

/**
 * ActionScheduledJob job decorator
 */
class ActionScheduledJob extends ScheduledJob implements JobInterface, ScheduledJobInterface, ConfigPropertiesInterface
{
    use 
        ConfigProperties;

    /**
     * Constructor
     *
     * @param string|null $extension
     * @param string|null $name    
     */
    public function __construct(?string $extension = null, ?string $name = null)
    {
        parent::__construct($extension,$name);
    }

    /**
     * Run job
     *
     * @return mixed
     */
    public function execute()
    {
        $config = $this->getConfigProperties();  
        $jobClass = '';
        
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
