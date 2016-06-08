<?php
	/**
	 *  Controller
	 *  
	 *  @author Guillem y sus 2 secuaces
	 *  @package sys
	 *	
	 * 
	 * 
	 * */
	
	class Controller{
		protected $model;
		protected $menu;
		protected $paginator;
		protected $view; 
		protected $params;
		protected $conf;
		function __construct($params){
			$this->params=$params;
			$this->model = new Model();
			//Coder::codear($this->params);
			$this->conf=Registry::getInstance();
			$this->menu = $this->getmenu();
			$this->menu = utf8_string_array_encode($this->menu);
		}

		/**
		*    
		*  @param Array $output from a model query result 
		* 
		* */

		function json_out($output){
			ob_clean();
			if (is_array($output)){
				echo json_encode($output);
			}
		}

		function getmenu(){
			return $this->model->categories();
		}
	}