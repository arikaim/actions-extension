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
        global $arikaim;

        try {
            $ruleIsTrue = (empty($item->rule_condition) == true) ? 
                true : 
                Rule::isTrue($item->rule_condition,$event->getParameters());

            if ($ruleIsTrue == true) {
                // run action
                $options = $item->getOptions('action_options');
                $options = $this->resolveActionVars($event,$options);

                $arikaim->get('logger')->info('workflow action options',$options);
                
                $action = Actions::create($item->action,null,$options)->getAction();
                $action->run();

                if ($action->hasError() == false) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            $arikaim->get('logger')->error($e->getMessage());
            return false;
        }
     
        return false;
    }

    /**
     * Evaluate options relations
     * @param mixed $event
     * @param array $actionOptions
     * @return array
     */
    protected function resolveActionVars($event, array $actionOptions): array
    {
        global $arikaim;

        $params = $event->getParameters();

        foreach ($actionOptions as $key => $value) {
            if ($arikaim->get('content')->isValidSelector($value) == true) {
                $item = $arikaim->get('content')->get($value,$params);
                $actionOptions[$key] = ($item == null) ? null : $item->getValue(0);
            }
        }

        return $actionOptions;
    }
}
