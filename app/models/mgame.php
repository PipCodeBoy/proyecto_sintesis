<?php

	class mGame extends Model{

		function __construct($params){
			parent::__construct($params);
			
		}
		/**
		 * 
         * Obtains the template of the game
		 *
		 * @param int $id
		 * @return Array, with the template of the game.
		 * 
		 * */

		function obtenerTemplate($id){
			$sql="SELECT juegos.nombre, template, categorias_juego.nombre as nombre_categoria, color, id_categoria_juego FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego where id_juego=".$id;
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

       	/**
		 * 
         * Checks if the game its been completed by the user
		 *
		 * @param String $usuario
		 * @param String $juego
		 * @return Boolean,
		 * 
		 * */

       	function comprobarJuegoPasado($usuario,$juego){
       		try{
				$sql="SELECT fecha FROM puntuacion WHERE usuario=? and juego=?";
				$this->Query($sql);
				$this->Bind(1,$usuario);
				$this->Bind(2,$juego);
				$this->Execute();
				if($this->RowCount()>0){
       				return true;
				}else{
					return false;
				}
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
			return false;
       	} 

       	/**
		 * 
         * Inserts a registry when a user has completed a game
		 *
		 * @param String $usuario
		 * @param String $juego
		 * @return Boolean,
		 * 
		 * */   	

       	function registrarJuegoPasado($usuario,$juego){
       		try{
				$sql="INSERT INTO puntuacion (usuario, juego, fecha) VALUES (?,?,now())";
				$this->Query($sql);
				$this->Bind(1,$usuario);
				$this->Bind(2,$juego);
				$this->Execute();
				return true;
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
			return fasle;
       	}

	}