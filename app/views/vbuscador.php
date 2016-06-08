<?php
	/**
	 *  vHome
	 *  Prepares and loads the corresponding Template
	 *  @author Guillem
	 * 
	 * */
	class vBuscador extends View{
		
		function __construct($array=null){
			parent::__construct($array);
			$this->tpl=Template::load('buscador',$this->view_data);
		}

	}