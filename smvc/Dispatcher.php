<?php

/**
 * Dispatcher
 */
class Dispatcher
{
    private $_view;
    private $_actions;
    private $_bootstrap;
    private $_controllerPath;

    private $_eventManager;

    private $_viewsQueue;

    private $_headers = array();

    private $_router;
    private $_request;

    public function __construct(View $view)
    {
        $this->_view = $view;
        $this->_actions = array();
        $this->_viewsQueue = array();
    }

    public function setRouter(Router $router)
    {
        $this->_router = $router;
    }

    public function getRouter()
    {
        return $this->_router;
    }

    public function setRequest(Request $request)
    {
        $this->_request = $request;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setControllerPath($path)
    {
        $this->_controllerPath = $path;
    }

    public function getControllerPath()
    {
        return $this->_controllerPath;
    }

    public function setEventManager(EventManager $em)
    {
        $this->_eventManager = $em;
    }

    public function getEventManager()
    {
        return $this->_eventManager;
    }

    public function setBootstrap($bootstrap)
    {
        $this->_bootstrap = $bootstrap;
    }

    public function getBootstrap()
    {
        return $this->_bootstrap;
    }

    public function add(Route $route)
    {
        $this->_actions[] = $route;
    }

    /**
     * dispatch an action
     */
    public function dispatch(Route $route)
    {
        do {
            $this->getEventManager()->publish("pre.dispatch", array($route, $this));

            $protoView = $this->_view->cloneThis();
            $controllerClassName = $route->getControllerName() . "Controller";
            $action = $route->getActionName() . "Action";
            $classPath = $this->getControllerPath() . DIRECTORY_SEPARATOR . $controllerClassName . ".php";
            $viewPath = $route->getControllerPath()
                . DIRECTORY_SEPARATOR
                . $route->getActionPath()
                . $protoView->getViewExt();

            if (!file_exists($classPath)) {
                // Use base controller
                $controllerClassName = 'Controller';
            } else {
                require_once $classPath;
            }

            $controller = new $controllerClassName($this);
            $controller->setRouter($this->getRouter());
            $controller->setRequest($this->getRequest());
            $controller->setParams(
                array_merge(
                    array(
                        "dispatcher" => $this,
                        "bootstrap" => $this->getBootstrap()
                    ),
                    $route->getParams()));
            $controller->setRawBody(@file_get_contents('php://input'));

            $controller->setView($protoView->cloneThis());
            $controller->view->controllerPath = $this->getControllerPath();

            if (method_exists($controller, $action)) {
                ob_start();
				$s=strtolower($route->getControllerName().'/'.$route->getActionName().'/');
				$pos=strpos($_SERVER['REQUEST_URI'],$s);
				if($pos>0)$id=substr($_SERVER['REQUEST_URI'],$pos+strlen($s));
				else $id='';
                $controller->init();
                $controller->$action($id);
                array_push($this->_viewsQueue, ob_get_contents());
                ob_end_clean();
            } else {
                if (!file_exists($controller->view->getViewPath() . DIRECTORY_SEPARATOR . $viewPath)) {
                    throw new RuntimeException("Page not found {$route->getControllerName()} -> {$route->getActionName()}".$controller->view->getViewPath() . DIRECTORY_SEPARATOR . $viewPath, 404);
                }
            }

            if ($controller->view->getViewPath()) {
                array_push(
                    $this->_viewsQueue,
                    $controller->getView()->render(
                        (($controller->getViewPath() !== false) ? $controller->getViewPath() : $viewPath))
                );
            }

            $this->getEventManager()->publish("post.dispatch", array($this));
        } while(($route = array_shift($this->_actions)));

        return implode("", $this->_viewsQueue);
    }

    public function sendHeaders()
    {
        $headers = $this->getHeaders();
        foreach ($headers as $header) {
            header($header["string"], $header["replace"], $header["code"]);
        }
    }

    public function clearHeaders()
    {
        $this->_headers = array();
    }

    public function addHeader($key, $value, $httpCode = 200, $replace  = true)
    {
        $this->_headers[] = array('string' => "{$key}:{$value}", "replace" => $replace, "code" => (int)$httpCode);
    }

    public function getHeaders()
    {
        return $this->_headers;
    }
}
