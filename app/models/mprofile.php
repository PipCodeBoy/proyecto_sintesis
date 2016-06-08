<?php

	class mprofile extends Model{

		function __construct(){
			parent::__construct();
			
		}

		/**
		 * 
		 * Selects all the users from db
 		 *
		 * @return array, All users
		 * 
		 * */

		function getallusers(){
			
			$sql="SELECT * FROM usuarios";
			$this->query($sql);
			$this->execute();
			$dades=$this->resultSet();
			return $dades;
		}

		/**
		 * 
		 * Selects all the users with their addresses from db
 		 *
		 * @return array, All users
		 * 
		 * */

		function getdatauser(){
			
			$sql="SELECT * FROM usuarios INNER JOIN domicilios on domicilios.usuario = usuarios.id_usuario WHERE id_usuario = :id";
			$this->query($sql);
			$this->bind(':id',$_SESSION['user']->idUser);
			$this->execute();
			$dades=$this->resultSet();

			if($this->rowCount() == 0)
			{
				$sql="SELECT * FROM usuarios WHERE id_usuario = :id";
				$this->query($sql);
				$this->bind(':id',$_SESSION['user']->idUser);
				$this->execute();
				$dades=$this->resultSet();
				// die(var_dump($dades));
			}
			return $dades;

		}

		/**
		 * 
		 * Selects all the cities from db
 		 *
		 * @return array, All cities
		 * 
		 * */

		function getpob(){
			
			$sql="SELECT * FROM poblaciones";
			$this->query($sql);
			$this->execute();
			$dades=$this->resultSet();
			return $dades;

		}

		/**
		 * 
		 * Adds and addres to the db for the logged user.
 		 *
		 * @param String $dir
		 * @param String $post
 		 * @param String $pob
		 * 
		 * 
		 * */

		function addaddres($dir,$postal,$pob){

			// die(var_dump($postal));
			$sql="INSERT INTO domicilios VALUES(null,:user,:dir,:pob,:code,1)";
			$this->query($sql);
			$this->bind(':user',$_SESSION['user']->idUser);
			$this->bind(':dir',$dir);
			$this->bind(':pob',$pob);
			$this->bind(':code',$postal);
			$this->execute();
			// die($pob);
		}

		/**
		 * 
		 * Selects the default addres of the user, if its null it will delete that addres from the table "domicilios" otherwise it will update that user addres and set it to NULL so it can be deleted from the other table
 		 *
 		 * @param String $dir
		 * @return array, All users
		 * 
		 * */

		function deladdres($dir){
			
			// die(var_dump($dir));
			$sql="SELECT envio_defecto FROM usuarios WHERE id_usuario = :id";
			$this->query($sql);
			$this->bind(':id',$_SESSION['user']->idUser);
			$this->execute();

			$res = $this->single();
			// var_dump($res);
			// die($res);

			if($res['envio_defecto'] != NULL)
			{
				$sql="UPDATE usuarios set envio_defecto = NULL WHERE id_usuario = :user";
				$this->query($sql);
				$this->bind(':user',$_SESSION['user']->idUser);
				$this->execute();
			}

			$sql="DELETE FROM domicilios WHERE id_domicilio = :id";
			$this->query($sql);
			$this->bind(':id',$dir);
			$this->execute();

			

		}

		/**
		 * 
		 * Sets to default the provided direction, it changed to billing or send address depending on $type
 		 *
 		 * @param String $dir
 		 * @param String $type
		 * 
		 * */

		function setdefault($dir,$type){
			
			// die(var_dump($type));
			if($type == 1)
			{
				$sql="UPDATE usuarios set envio_defecto = :id WHERE id_usuario = :user";
			}
			else
			{
				$sql="UPDATE usuarios set facturacion_defecto = :id WHERE id_usuario = :user";
			}
			
			$this->query($sql);
			$this->bind(':id',$dir);
			$this->bind(':user',$_SESSION['user']->idUser);
			$this->execute();

		}

		/**
		 * 
		 * Updates user information from config profile form
 		 *
 		 * @param String $dir
 		 * @param String $name
 		 * @param String $date
 		 * @param String $email
 		 * @param String $nick
 		 * @param String $phone
 		 * @param String $pass
		 *  
		 *
		 *
		 * */

		function saveprofile($name,$ape,$date,$email,$nick,$phone,$pass){

			$sql="UPDATE usuarios set nombre = :name, apellidos = :ape, fecha_nacimiento = :date, apodo = :nick, email = :email, password = :pass, telefono_contacto = :phone WHERE id_usuario = :user";
			$this->query($sql);
			$this->bind(':user',$_SESSION['user']->idUser);
			$this->bind(':name',$name);
			$this->bind(':ape',$ape);
			$this->bind(':date',$date);
			$this->bind(':nick',$nick);
			$this->bind(':email',$email);
			$this->bind(':pass',$pass);
			$this->bind(':phone',$phone);
			$this->execute();
		}


		/**
		 * 
		 * Admin function. Deletes the selected user.
 		 *
 		 * @param String $user
 		 * @param String $email
		 * @return Array, A message to know if the user has been deleted or not
		 *
		 *
		 * */

		function deleteadmin($user,$email){

			$sql='SELECT * FROM usuarios WHERE id_usuario = :id_user OR email = :email';
			$this->query($sql);
			$this->bind(':id_user', $user);
			$this->bind(':email', $email);
			$this->execute();

			if($this->rowCount() == 0){
				$msg = "user_not_exists";
			}else{
				$sql = "DELETE FROM usuarios WHERE id_usuario = :id_user OR email = :email";	
				$this->query($sql);
				$this->bind(':id_user', $user);	
				$this->bind(':email', $email);
				$this->execute();
				if($this->rowCount() > 0){
					$msg = array('response' => 'deleted');
				}else{
					$msg = array('response' => 'cannot_delete');
				}
			}

			return $msg;
		}

		/**
		 * 
		 * Admin function. Updates the selected user.
 		 *
 		 * @param String $user
 		 * @param String $email
 		 * @param String $name
 		 * @param String $nick
 		 * @param String $rol
 		 * @param String $phone
		 * @return Array, A message to know if the user has been updated or not
		 *
		 *
		 * */

		function editadmin($user,$name,$nick,$email,$rol,$phone){


			if(!empty($user) && !empty($email) && !empty($name)){

				$sql='SELECT * FROM usuarios WHERE id_usuario = :id_user';
				$this->query($sql);
				$this->bind(':id_user', $user);
				$this->execute();
				$this->single();

				if($this->rowCount() == 0){
					$msg = array('response' => 'user_not_exists');
				}else{

					$sql="UPDATE usuarios SET email = :email, nombre = :name, telefono_contacto = :phone, rol = :rol, apodo = :nick WHERE id_usuario = :id_user";	
					$this->query($sql);
					$this->bind(':id_user', $user);	
					$this->bind(':email', $email);
					$this->bind(':name', $name);
					$this->bind(':nick', $nick);
					$this->bind(':phone', $phone);
					$this->bind(':rol', $rol);
					$res2 =  $this->execute();
					if($this->rowCount() > 0){
						$msg = array('response' => 'updated');
					}else{
						$msg = array('response' => 'cannot_update');
					}
				}		
			}else{
				$msg = array('response' => 'missing_params');
			}

			return $msg;
		}

		/**
		 * 
		 * Admin function. Creates a new user.
 		 *
 		 * @param String $email
 		 * @param String $name
 		 * @param String $nick
 		 * @param String $rol
 		 * @param String $phone
 		 * @param String $pass
 		 * @param String $sex
 		 * @param String $ape
 		 * @param String $date
		 * @return Array, A message to know if the user has been created or not
		 *
		 *
		 * */

		function newuseradmin($pass,$name,$nick,$email,$rol,$phone,$sex,$ape,$date){


			if(!empty($email) && !empty($pass) && !empty($name)){
				

				$sql='SELECT * FROM users WHERE email = :email';
				$this->query($sql);
				$this->bind(':email', $email, PDO::PARAM_STR);
				$this->execute();

				if($this->rowCount() > 0){
					$msg = array('response' => 'user_exists');
				}else{
					$sql='INSERT INTO usuarios(id_usuario, nombre, apellidos, fecha_nacimiento, sexo, apodo, email, password, rol, telefono_contacto, envio_defecto, facturacion_defecto) VALUES(null,:name,:ape1,:date,:sex,:alias,:email,md5(:pass),:rol,:phone,null,null)';	
					$this->query($sql);	
					$this->bind(':email', $email);
					$this->bind(':pass', $pass);
					$this->bind(':name', $name);
					$this->bind(':ape1', $ape);
					$this->bind(':date', $date);
					$this->bind(':alias', $nick);
					$this->bind(':sex', $sex);
					$this->bind(':phone', $phone);
					$this->bind(':rol', $rol);
					$res = $this->execute();

					if($this->rowCount() > 0){
						$msg = array('response' => 'created');
					}else{
						$msg = array('response' => 'cannot_create');
					}
				}		
			}else{
				$msg = array('response' => 'missing_params');
			}

			return $msg;

		}
	}//END CLASS