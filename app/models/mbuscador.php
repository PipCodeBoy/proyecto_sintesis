<?php

	class mBuscador extends Model{

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

		
		function contadorPaginasGamesCategoria($categoria){			
			$sql="SELECT CEILING(COUNT(juegos.nombre)/12) as maxPaginas FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego WHERE  categoria=".$categoria;
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

       	function gamesCategoria($categoria, $pagina){
			$sql="SELECT *,juegos.nombre FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego WHERE  categoria=".$categoria." LIMIT 12";
			if($pagina>1){
				$sql=$sql." OFFSET ".(($pagina)-1)*12;
			}
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

		function buscarJuegoAutocompletado($busqueda){

			/*
			* PARA QUE FUNCIONE EL MATCH AGAINST, NECESITO INDEXAR LOS CAMPOS QUE VOY A UTILIZAR CON EL SIGUIENTE COMANDO:
			*
			* --> ALTER TABLE ARTICULOS ADD FULLTEXT(TITULO, DESARROLLO);
			*
			* El "IN BOOLEAN MODE" de la consulta solo se debe poner si la base de datos tiene las tablas con MyISAM, en vez de innoDB
			* La opcion de FULLTEXT para innoDB es a partir de la version 5.6, el vesta y el openshift no la tienen
			*/
			//$sql="SELECT * , MATCH (nombre,descripcion) AGAINST ('juego de sumas') AS puntuacion FROM `juegos` WHERE MATCH (nombre, descripcion) AGAINST ('juego de sumas') ORDER BY puntuacion DESC";
			$sql="SELECT CONCAT(nombre,': ',descripcion) as resultado, id_juego, MATCH (nombre,descripcion) AGAINST ('".$busqueda."' IN BOOLEAN MODE) AS puntuacion FROM juegos WHERE MATCH (nombre, descripcion) AGAINST ('".$busqueda."' IN BOOLEAN MODE) ORDER BY puntuacion DESC";
           	$this->query($sql);
           	$resultado=$this->execute();

           	$datos = array();
       	 	while ($row=$this->single()){ 	 			
           	 	$datos[] = array(
					"label" => $row['resultado'],
					"value" => $row['id_juego']
				);

	       	}
	       	return $datos;
           	//return $dades=$this->resultSet();
       	}

	}