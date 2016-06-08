<?php
	/**
	 *  vProducts
	 *  Prepares and loads the corresponding Template
	 *  @author Guillem y sus 2 secuaces
	 * 
	 * */
	class vStore extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			$this->tpl=Template::load('store',$this->view_data);
		}

	}