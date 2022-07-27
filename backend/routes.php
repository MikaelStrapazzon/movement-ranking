<?php
require_once 'controllers/movement.php';

class Routers {
    public $routes = array();

    /**
     * Enter all possible routes
     * @param array $routes All possible routes in the API
     *  string route => url route requested
     *  string method => http method requested
     *  string controller => controller that will be executed (ex: MovementController::listAction)
     *
     * @return void
     */
    public function __construct($routes) {
        $this->routes = $routes;
    }

    /**
     * Checks and executes the requested route in the http request
     *
     * @return array
     *  (optional) string code => http code for response
     *  (optional) string error => error message for response
     *  (optional) string data => data requested in the request
     */
    public function getRequestResponse() {
        $routeRequest = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 1);
        $methodRequest = $_SERVER['REQUEST_METHOD'];

        foreach($this->routes as $route) {
            if($routeRequest == $route['route'] && $methodRequest == $route['method'])
                return $route['controller']();
        }

        return ['error' => 'Route does not exist'];
    }
}
