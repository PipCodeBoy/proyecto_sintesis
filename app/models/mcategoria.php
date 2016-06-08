<?php

	class mCategoria extends Model{

		function __construct($params){
			parent::__construct($params);
			
		}
		/**
		 * 
         * Recives email and password and tries to connect, if succeeds it will create a 'Session' called 'user' with an object inside that contains email,id,rol and username of the user contains email,id,rol and username of the user
		 *
		 * @param String $email, String $pass
		 * @return boolean
		 * 
		 * */

		
		function comprobarExisteCategoria($categoria){			
			$sql="SELECT * FROM categorias_juego WHERE id_categoria_juego=".$categoria;
           	$this->query($sql);
           	$this->Execute();
			if($this->RowCount()>0){
   				return true;
			}else{
				return false;
			}
       	}

		function contadorPaginasGamesCategoria($categoria){			
			$sql="SELECT CEILING(COUNT(juegos.nombre)/12) as maxPaginas FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego WHERE  categoria=".$categoria;
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

       	function gamesCategoria($categoria, $pagina){
			$sql="SELECT *,juegos.nombre, categorias_juego.nombre as nombre_categoria FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego WHERE  categoria=".$categoria." LIMIT 12";
			if($pagina>1){
				$sql=$sql." OFFSET ".(($pagina)-1)*12;
			}
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

	}