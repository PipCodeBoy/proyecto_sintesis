<?php
	/**
	 *  v
	 *  Prepares and loads the corresponding Template
	 *  @author Toni
	 * 
	 * */
	class vprofile extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			
			$this->tpl=Template::load('profile',$this->view_data);
			
		}

	}