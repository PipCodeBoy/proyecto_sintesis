<?php
	/**
	 *  
	 *  Prepares and loads the corresponding Template
	 *  @author Guillem y sus 2 secuaces
	 * 
	 * */
	class vBuy_process extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			$this->tpl=Template::load('buy_process',$this->view_data);
		}

	}