<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Subscribers;

use Arikaim\Core\Events\EventSubscriber;
use Arikaim\Core\Interfaces\Events\EventSubscriberInterface;
use Arikaim\Core\Db\Model;
use Arikaim\Core\Actions\Actions;
use Arikaim\Modules\Rules\Rule;

/**
 * WorkflowsSubscriber run in each event
*/
class WorkflowsSubscriber extends EventSubscriber implements EventSubscriberInterface
{
    /**
     * Constructor
     */
    public function __construct() 
    {
        $this->subscribe('*');
    }

    /**
     * Run 
     *
     * @param EventInterface $event
     * @return array
     */
    public function execute($event)
    {
        $workflows = Model::Workflows('actions')->activeQuery()->get();
        
        foreach ($workflows as $workflow) {
            $items = $workflow->queryItems('event',$event->getName())->activeQuery()->get();
            foreach ($items as $item) {
                $this->runWorkflowItem($item,$event);
            }            
        }
        
    }

    /**
     * Run workflow item
     * 
     * @param mixed $item
     * @param mixed $event
     * @return bool
     */
    protected function runWorkflowItem($item, $event): bool
    {
        $ruleIsTrue = (empty($item->rule_condition) == true) ? 
            true : 
            Rule::isTrue($item->rule_condition,$event->getParameters());

        if ($ruleIsTrue == true) {
            // run action
            $options = $item->getOptions('action_options');
            $action = Actions::create($item->action,null,$options)->getAction();
            $action->run();

            if ($action->hasError() == false) {
                return true;
            }
        }

        return false;
    }
}
