<?php

class profile extends Controller{
		protected $model;
		protected $view;
		
		function __construct($params,$array=null){
			parent::__construct($params);
			$this->model=new mprofile();
			$this->view= new vprofile($this->menu);
			
			//echo 'Hello controller!';
		}

		/**
		*    
		*  This function is defined in every controller, it charges the view of this controller
		* 
		* */
		function home(){
			
		}

		/**
		*    
		*  Recives all users from db and transforms them to json
		* 
		* */

		function getallusers(){
			$user=$this->model->getallusers();
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}

		/**
		*    
		*  Recives all users with their addresses from db and transforms them to json
		* 
		* */

		function getdatauser(){
			$user=$this->model->getdatauser();
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}

		/**
		*    
		*  Recives all cities from db and transforms them to json
		* 
		* */

		function getpob(){
			$user=$this->model->getpob();
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}

		/**
		*    
		*  Gets data from a form and sends it to the model to insert an address
		* 
		* */

		function addaddres(){
			$dir = $_POST['dir'];
			$postal = $_POST['postal'];
			$pob = $_POST['pob'];
			// die($pob);
			$user=$this->model->addaddres($dir,$postal,$pob);
		}

		/**
		*    
		*  Recives identificator from ajax and proceeds to delete that address
		* 
		* */

		function deladdres(){
			$dir = $_POST['dir'];
			
			$user=$this->model->deladdres($dir);
		}

		/**
		*    
		*  Recives id and type to set default that address depending on id it will be the billing address or the sending address
		* 
		* */

		function setdefault(){
			$dir = $_POST['dir'];
			$type = $_POST['type'];
			$user=$this->model->setdefault($dir,$type);
		}

		/**
		*    
		*  Recives name, surnames, born date, email, nick, phone, password and sends it to the model
		* 
		* */

		function saveprofile(){
			$name = $_POST['name'];
			$ape = $_POST['ape'];
			$date = $_POST['date'];
			$email = $_POST['email'];
			$nick = $_POST['nick'];
			$phone = $_POST['phone'];
			$pass = md5($_POST['pass']);
			$user=$this->model->saveprofile($name,$ape,$date,$email,$nick,$phone,$pass);
		}

		/**
		*    
		*  Delete for admin.
		*
		*  Gets user id and sends it to the model. It parses the response to json
		* 
		* */

		function deleteadmin(){
			$user = $_POST['id_user'];
			$email = $_POST['user'];
			// echo $email;
			// die($email);
			$user=$this->model->deleteadmin($user,$email);
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}

		/**
		*    
		*  Edit for admin.
		*
		*  Recives name, surnames, born date, email, nick, phone, password and sends it to the model. It parses the response to json
		* 
		* */

		function editadmin(){
			$user = $_POST['id_user'];
			$name = $_POST['name'];
			$nick = $_POST['nick'];
			$email = $_POST['email'];
			$rol = $_POST['rol'];
			$phone = $_POST['phone'];
			$user=$this->model->editadmin($user,$name,$nick,$email,$rol,$phone);
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}

		/**
		*    
		*  New user for admin.
		*
		*  Recives name, surnames, born date, email, nick, phone, password, rol, sex and sends it to the model. It parses the response to json
		* 
		* */

		function newuseradmin(){
			$pass = md5($_POST['password']);
			$name = $_POST['name'];
			$nick = $_POST['nick'];
			$email = $_POST['email'];
			$rol = $_POST['rol'];
			$phone = $_POST['phone'];
			$sex = $_POST['sex'];
			$ape = $_POST['ape'];
			$date = $_POST['date'];
			$user=$this->model->newuseradmin($pass,$name,$nick,$email,$rol,$phone,$sex,$ape,$date);
			$user=utf8_string_array_encode($user);
			$this->json_out($user);
		}
}