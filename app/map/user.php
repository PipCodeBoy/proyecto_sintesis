<?php

	class User{
		public $email;
		public $rol;
		public $username;
		public $idUser;
		public $sex;

		function __construct($email,$idUser,$rol,$username,$sex){
			$this->email=$email;
			$this->idUser=$idUser;
			$this->rol=$rol;
			$this->username=$username;
			$this->sex=$sex;
		}

		
	}