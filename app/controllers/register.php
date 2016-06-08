<?php

	class Register extends Controller{
		protected $model;
		protected $view;
		
		function __construct($params,$array=null){
			parent::__construct($params);
			$this->model=new mRegister();
			$this->view= new vRegister($this->menu);
		}
		function home(){

		}

		/**
		 * 
		 * Calls the model of this controller to register one user if it cans it will redirect the user to his profile
		 * 
		 * */
		function reg(){
			$user = $_POST['name'];
			$ape1 = $_POST['last-name'];
			$date = $_POST['birth-date'];
			$sex = $_POST['sex'];
			$alias = strtolower($_POST['nick']);
			$email = strtolower($_POST['email']);
			$pass = md5($_POST['pass']);		
			// die($pass);
			
			$user=$this->model->register($user,$ape1,$date,$sex,$alias,$email,$pass);
			if($user==true){
				setcookie('user',$_SESSION['user']->sex,0,APP_W);
				setcookie('rol',$_SESSION['user']->rol,0,APP_W);
				setcookie('userid',$_SESSION['user']->idUser,0,APP_W);
				// die($_SESSION);
				header("Location: ".APP_W.'profile');
			}	

		}
	}