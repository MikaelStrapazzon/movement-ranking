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
            if(!preg_match('/\<(.[^\/])+\>/', $route['route'])) {
                if($routeRequest == $route['route'] && $methodRequest == $route['method'])
                    return $route['controller']();
            }
            else {
                $explodeRoute = explode('/', $route['route']);
                $explodeRouteRequest = explode('/', $routeRequest);

                if(count($explodeRoute) != count($explodeRouteRequest))
                    continue;

                $valuesParameters = [];
                foreach($explodeRoute as $indice => $partRoute) {
                    if(preg_match('/^\<.+\>$/', $partRoute))
                        $valuesParameters[] = $explodeRouteRequest[$indice];
                    else if($partRoute != $explodeRouteRequest[$indice])
                        continue 2;
                }

                return call_user_func_array($route['controller'], $valuesParameters);
            }
        }

        return [
            'code' => 404,
            'error' => 'Route does not exist'
        ];
    }
}
