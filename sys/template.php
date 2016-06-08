<?php
	/**
	 * Template :  template for making html
	 *             loads $contents and $data
	 * @author Toni
	 * 
	 * */

	class Template{
		// the current_view provide navigation informations in template
		static $current_view;
		
		static function load($contents,$data=null){
			
			if(is_array($data)){
				extract($data);
			}
			self::$current_view=$contents;
			include APP.'tpl'.DS.'head.php';
			include APP.'tpl'.DS.$contents.'.php';
			include APP.'tpl'.DS.'footer.php';
		}
	}