<?php


	class vRegister extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			
			$this->tpl=Template::load('register',$this->view_data);
			
		}

	}