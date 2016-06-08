<?php
	// section 1
	// fucntions helping correct routing

	function is_base(){
            if (APP_W!='/'){
               return false; 
            }
            else{
                return true;
            }
        }
    function isValidMd5($md5 ='')
    {
        return preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    // section 2
    // class Autoload
	spl_autoload_register(null,false);
	spl_autoload_register('MAutoload::SysLoader');
	spl_autoload_register('MAutoload::ContLoader');
	spl_autoload_register('MAutoload::ModLoader');
	spl_autoload_register('MAutoload::ViewLoader');
	spl_autoload_register('MAutoload::MapLoader');


	class MAutoload{

		static function SysLoader($class){
			$filename=strtolower($class).'.php';
			$file=ROOT.'sys'.DS.$filename;
			if(!file_exists($file)){
				return false;
			}
			require $file;
		}
		static function ContLoader($class){
			$filename=strtolower($class).'.php';
			$file=APP.'controllers'.DS.$filename;
			if(!file_exists($file)){
				return false;
			}
			require $file;
		}
		static function ModLoader($class){
			$filename=strtolower($class).'.php';
			$file=APP.'models'.DS.$filename;
			if(!file_exists($file)){
				return false;
			}
			require $file;
		}
		static function ViewLoader($class){
			$filename=strtolower($class).'.php';
			$file=APP.'views'.DS.$filename;
			if(!file_exists($file)){
				return false;
			}
			require $file;
		}
		static function MapLoader($class){
			$filename=strtolower($class).'.php';
			$file=APP.'map'.DS.$filename;
			if(!file_exists($file)){
				return false;
			}
			require $file;
		}
	}
	/**
	 * 
	 *  Coder
	 *  makes  var_dump easy
	 *  @author Toni
	 * 
	 * */
	class Coder{
		static function code($var){
			echo '<pre>'.$var.'</pre>';
		}

		static function codear($var){
			echo '<pre>'.var_dump($var).'</pre>';
		}


	}
/**
/	Helps in building menus
/
**/
 class MMenu{

        static function create($menu=array()){
            echo '<ul>';
            foreach ($menu as $item => $link) {
                echo '<a href="'.$link.'"><li>'.$item.'</li></a>';
            }
            echo '</ul>';
        }
    }
/**
/	Helps in building buttons
/
**/

 class MButton{
        static function create($menu=array()){
            echo '<ul>';
            foreach ($menu as $item ) {
                echo '<button type="button">'.$item.'</button>';
            }
            echo '</ul>';
        }
    }

    function utf8_string_array_encode(&$array){
	   $func = function(&$value,&$key){
	       if(is_string($value)){
	           $value = utf8_encode($value);
	       } 
	       if(is_string($key)){
	           $key = utf8_encode($key);
	       }
	       if(is_array($value)){
	           utf8_string_array_encode($value);
	       }
	   };
	   array_walk($array,$func);
	   return $array;
	}



	