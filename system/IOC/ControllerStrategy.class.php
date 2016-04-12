<?php

/**
 * @author ShiO
 */
class ControllerStrategy {
    public $requestAction = null;
    public $requestMethod = null;
    protected $service = array();


    /**
     * @author ShiO
     * ControllerStrategy constructor.
     * @param $requestAction
     * @param $requestMethod
     */
    public function __construct($requestAction, $requestMethod) {
        $this->requestAction = $requestAction;
        $this->requestMethod = $requestMethod;
    }

    /**
     * @author ShiO
     */
    public function init() {
        try {
            $class = new ReflectionClass($this->requestAction);
            if (!$class) {
                throw new URLCallException(null, 1, null);
            }
            $obj = $class->newInstance();
            $method = new ReflectionMethod($this->requestAction, $this->requestMethod);
            if (!$method) {
                throw new URLCallException(null, 2, null);
            }
            $pars = $method->getParameters();
            if ($pars && $pars[0]) {
                return 'request';
            }
        } catch (URLCallException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @author ShiO
     * @param $service
     */
    public function bindParam($service) {
        $this->service = $service;
    }

    /**
     * @author ShiO
     */
    public function execute() {
        $action = $this->createActionObj();
        $actionMethodName = $this->requestMethod;
        if ($this->service) {
            $action->$actionMethodName($this->service);
        } else {
            $action->$actionMethodName();
        }
    }

    /**
     * @author ShiO
     * @return mixed
     */
    private function createActionObj() {
        return new $this->requestAction();
    }
}