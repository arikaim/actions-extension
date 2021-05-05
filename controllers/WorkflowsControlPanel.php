<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Actions\Controllers;

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Controllers\Traits\Crud;
use Arikaim\Core\Controllers\Traits\Status;

/** 
 *  Workflows control panel api controller
 */
class WorkflowsControlPanel extends ControlPanelApiController
{
    use 
        Crud,
        Status;

    /**
     * Unique columns
     *
     * @var array
     */
    protected $uniqueColumns = [
        'title'       
    ];

    /**
     * Create msg
     *
     * @var string
     */
    protected $createMessage = 'workflow.add';

    /**
     * Update msg
     *
     * @var string
     */
    protected $updateMessage = 'workflow.update';

    /**
     * Delete msg
     *
     * @var string
     */
    protected $deleteMessage = 'workflow.delete';

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('actions::admin.messages');
    }

    /**
     * Constructor
     * 
     * @param Container $container  
    */
    public function __construct($container = null)
    {
        parent::__construct($container);
        
        $this->setExtensionName('actions');
        $this->setModelClass('Workflows');
    }
}
