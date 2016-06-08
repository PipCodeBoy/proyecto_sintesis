<?php

	class mRegister extends Model{

		function __construct(){
			parent::__construct();
			
		}
		/**
		 * 
		 * Recives all data from the controller and looks for the user in the db, if it find a user with that credentias it will return false, otherwise it will set the rol of the user to 2 (client) and it will procede to the next function, the insert itself
 		 *
		 * @param String $user, String $ape1, String $ape2, String $date, String $sex, String $alias, String $email, String $pass
		 * @return boolean
		 * 
		 * */
		function register($user,$ape1,$date,$sex,$alias,$email,$pass){
			// die($sex);
			$sql="SELECT * FROM usuarios WHERE email=:email AND password=:password";
			$this->query($sql);
			$this->bind(':email',$email);
			$this->bind(':password',$pass);
			$this->execute();
			//$this->debugDumpParams();
			if($this->rowcount()==1){
				return false;
			}
			else{
				$rol='2';
				$tlf='1234';
				$this->new_user($user,$ape1,$date,$sex,$alias,$email,$pass,$rol,$tlf);	
				return true;
			}
		}

		/**
		 * 
		 *Recives all data from the previous function and preceeds to do the insert, if it succeeds it will create 2 Sessions, one with the name 'islogged' set to TRUE and the other with name 'user' set to $user
  		 *
		 * @param String $user, String $ape1, String $ape2, String $date, String $sex, String $alias, String $email, String $pass
		 * @return boolean
		 * 
		 * */
		function new_user($user,$ape1,$date,$sex,$alias,$email,$pass,$rol){
			try{
				// die($date);
			    $sql="INSERT INTO usuarios(id_usuario, nombre, apellidos, fecha_nacimiento, sexo, apodo, email, password, rol, telefono_contacto, envio_defecto, facturacion_defecto) VALUES(null,:user,:ape1,:date,:sex,:alias,:email,md5(:pass),2,null,null,null)";
			    $this->query($sql);
			    $this->bind(":user",utf8_decode($user));
			    $this->bind(":ape1",utf8_decode($ape1));
			    $this->bind(":date",$date);
			    $this->bind(":sex",$sex);
			    $this->bind(":alias",utf8_decode($alias));
			    $this->bind(":email",$email);
			    $this->bind(":pass",$pass);
			    $this->execute();
			    $lastId = $this->lastInsertId();
			    
			    $res=$this->single();
			    if( $this->rowCount()==1){
			    	$sql="SELECT * FROM usuarios WHERE id_usuario = :id";
					$this->query($sql);
					$this->bind(':id',$lastId);
					$this->execute();
					$user=$this->single();

			    	Session::set('user',new user($user['email'],
					$user['id_usuario'],
					$user['rol'],
					$user['apodo'],
					$user['sexo']));
		          	Session::set('islogged',TRUE);
		          	// die(var_dump($_SESSION));
		          	return TRUE;
			    }
		    	else {
		         	Session::set('islogged',FALSE);
		          	return FALSE;
		      	}
		    }
		    catch(PDOException $e){
		       echo "Error:".$e->getMessage();
		   	}
		}
	}