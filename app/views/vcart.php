<?php
	/**
	 *  vHome
	 *  Prepares and loads the corresponding Template
	 *  @author Guillem
	 * 
	 * */
	class vCart extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			$this->tpl=Template::load('cart',$this->view_data);
		}

	}