<?php
	/**
	 *  vHome
	 *  Prepares and loads the corresponding Template
	 *  @author Alberto
	 * 
	 **/
	class vError extends View{

		function __construct($array=null){
			parent::__construct($array);
			
			$this->tpl=Template::load('error',$this->view_data);			
		}
	}