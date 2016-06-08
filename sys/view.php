<?php

	class View{

		protected $tpl;
		protected $view_data;
		function __construct($array=null){
			$conf=Registry::getInstance();
			// access to app_data that configures html-view
			$this->view_data=(array)$conf->app;
			if($array){
			$this->addData($array);}
			ob_start();
		}
		function addData($array){
			$this->view_data=array_merge($this->view_data,$array);
			// die();
		}
		
	}