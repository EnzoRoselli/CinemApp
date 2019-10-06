<?php namespace config;
    class Router {
        public function __construct()
        {
            # code...
        }
        /**
         * @method route
         * Se encarga de direccionar a la pagina solicitada
         *
         * @param Request $request
         */
        public static function route(Request $request) {
            /**
             * Concatena el primer dato que obtuvo el request (el que usaremos como controlador) con la palabra Controller
             */
            $controller = $request->getController() . 'Controller';
            /**
             * Guarda en una variable el segundo dato obtenido por el request (el que usaremos como método).
             */
            $method = $request->getMethod();
            /**
             * Guarda en una variable todos los datos obtenidos a partir del segundo dato de la url o los que llegan de formularios (el que usaremos como método).
             */
            $parameters = $request->getParameters();
            /**
             * Concatena controllers (namespace del paquete) con el nombre de la clase controladora a instanciar
             */
            $class = "controllers\\". $controller;
            /**
             * Crea la instancia controladora
             */
            $instance = new $class;
            
            /**
             *
             */
            if(!isset($parameters)) {
                call_user_func(array($instance, $method));
            } else {
                call_user_func_array(array($instance, $method), $parameters);
            }
        }
    }
?>