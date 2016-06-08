<?php
	/**
	 *  vHome
	 *  Prepares and loads the corresponding Template
	 *  @author Guillem y sus 2 secuaces
	 * 
	 * */
	class vCategoria extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			$this->tpl=Template::load('categoria',$this->view_data);
		}

	}