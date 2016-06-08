<?php

	class Session{

		static function init(){
			session_start();
			self::set('id',session_id());
			self::set('islogged',FALSE);

		}

		static function set($key,$value){
			$_SESSION[$key]=$value;
		}

		static function get($key){
			if(self::exist($key)){
				return $_SESSION[$key];
			}
			else{
				return null;
			}
		}

		static function exist($key){
			if(array_key_exists($key, $_SESSION)){
				return true;
			}else{
				return false;
			}
		}
		static function del($key){
			if (self::exist($key)){
				unset($_SESSION[$key]);
			}
		}

		static function destroy(){
			session_destroy();
		}
	}