<?php
	class Request{
		static private $query=array();

		static function retrieve(){
			$array_query=explode('/',$_SERVER['REQUEST_URI']);
			//extract the first "/"
			array_shift($array_query);
			// if we publish in root
			
			if (!is_base()){
				array_shift($array_query);
			}
			//deleting blanks at the end
			if(end($array_query)==""){
				array_pop($array_query);
			}

			//return value to static $query
			self::$query=$array_query;
		}

		static function getCont(){
			return array_shift(self::$query);
		}

		static function getAct(){
			//Para evitar que esto de errores al recortar la url cuando se le pasan parametros get
			//compruebo si estoy pasando algun parametro get y lo quito de la parte donde se supone que esta el metodo
			//dejando solo el nombre del metodo
			if (count(self::$query)>0){
				$pos=strpos(self::$query[0],"?");
				if (!$pos===false){
					self::$query[0]=substr(self::$query[0],0,$pos);	
				}
				return array_shift(self::$query);
			}
		}

		static function getParams(){
			//primer comprovar que queda algo
			if (count(self::$query)>0){
				//comprovar si és parell
				if((count(self::$query)%2)==0){
					for($i=0;$i<count(self::$query);$i++){
						if(($i%2)==0){
							$key[]=self::$query[$i];
						}else{
							$pos=strpos(self::$query[$i],"?");
							if ($pos===false){
								$value[]=self::$query[$i];
							}else{
								$value[]=substr(self::$query[$i],0,$pos);
							}
						}
					}
					$result=array_combine($key, $value);
					return $result;
				}else{
					echo 'ERROR in params array';
				}
			}
		}

	}