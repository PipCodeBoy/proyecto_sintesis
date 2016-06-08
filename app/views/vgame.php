<?php
	/**
	 *  vHome
	 *  Prepares and loads the corresponding Template
	 *  @author Toni
	 * 
	 * */
	class vGame extends View{
		
		function __construct($ruta, $array=null){
			parent::__construct($array);
			$this->tpl=Template::load($ruta, $this->view_data);
		}

	}