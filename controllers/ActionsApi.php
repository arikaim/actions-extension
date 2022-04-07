<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Actions\Controllers;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Controllers\ApiController;

/**
 * Actions api controller
*/
class ActionsApi extends ApiController
{
    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('actions::messages');
    }

    /**
     * Run action
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function runController($request, $response, $data) 
    {       
        $params = $request->getQueryParams();
        $data = \array_merge($data->toArray(),$params);
        $name = $data['name'] ?? '';
        $secret = $data['secret'] ?? '';
      
        if (empty($name) == true) {
            $this->error('Not valid action name');
            return false;
        }
            
        $action = Model::Actions('actions')->findAction($name);
        if (\is_object($action) == false) {
            $this->error('Not valid action name');
            return false;
        }

        if ($action->allow_http_execution != true) {
            $this->error('Not allowed http execution.');
            return false;
        }

        if (empty(\trim($action->secret)) == false && $action->secret != $secret) {
            $this->error('Not valid secret.');
            return false;
        }

        $job = $this->get('queue')->create($action->handler_class,null,null,$data);

        if (\is_object($job) == false) {
            $this->error('Not valid action.');
            return false;
        }

        $jobResult = $job->execute();
        $jobResult = (\is_array($jobResult) == false) ? [$jobResult] : $jobResult;
        $error = $jobResult['error'] ?? null;

        $this->setResponse((empty($error) == true),function() use($error,$jobResult) {     
            $this                    
                ->setResultFields($jobResult);
        },$error);                                
    }
}
