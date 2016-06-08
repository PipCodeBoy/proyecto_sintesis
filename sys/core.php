<?php
	/**
	 *  Core: Front Controller
	 *  
	 * @author Guillem y sus 2 secuaces
	 * @package sys
	 * 
	 * */

	class Core{
		static private $controller;
		static private $action;
		static private $params;

		static function init(){
			// begining to extract 
			// routing elements
			Request::retrieve();

			$controller=Request::getCont();
			self::$controller=$controller;
		
			$action=Request::getAct();
			self::$action=$action;
			
			$params=(array)Request::getParams();
			self::$params=$params;
			
			// routing to the correspondig 
			// controller

			self::router();
		}

		static function router(){
			//extract(self::$params);


			//redirects Control to respective controller
			$route=(self::$controller!="")?self::$controller:'home';
			$action=(self::$action!="")?self::$action:'home';

			$fileroute=strtolower($route).'.php';
			//if exists the file controller
			if(is_readable(APP.'controllers'.DS.$fileroute)){
				// create an instance of new controller
				self::$controller=new $route(self::$params);
				$conf=Registry::getInstance();
				$conf->route=$route;
				$conf->action=$action;
				
				if (is_callable(array(self::$controller,$action))){
					//if exists the  method....
					call_user_func(array(self::$controller, $action));
				}else{ 
					echo $action.": Unexistent method!";
				}

			}else{
				self::$controller=new Error;
			}
		}

	}