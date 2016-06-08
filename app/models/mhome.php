<?php

	class mHome extends Model{

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

		function login($email,$pass){
			// die($pass);
			$sql="SELECT * FROM usuarios WHERE (email=:email OR apodo=:email) AND password=:password";
			$this->query($sql);
			$this->bind(':email',$email);
			$this->bind(':password',$pass);
			$this->execute();
			$user=$this->single();
			// echo $user;
			// die(var_dump($user));
			
			//$this->debugDumpParams();
			if($this->rowcount()==1){

				Session::set('user',new user($user['email'],
				$user['id_usuario'],
				$user['rol'],
				$user['apodo'],
				$user['sexo']));
				return true;
			}
			else{
				return false;
			}

		}

		function games(){
			$sql="SELECT *,juegos.nombre FROM juegos INNER JOIN categorias_juego ON juegos.categoria = categorias_juego.id_categoria_juego WHERE juegos.destacado=1";
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}
	
		function comprobarCarro($id_carro){
			$sql="SELECT * FROM carro INNER JOIN detalle_carro ON carro.id_carro = detalle_carro.carro INNER JOIN productos ON detalle_carro.producto=productos.id_producto where carro.id_carro=".$id_carro;
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}
	}