<?php
	
	class Game extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mGame(1);
		}
		
		function home(){
			// $this->games();
		}

		/**
		* 
		* Recives all the games and transforms them to json
		* 
		* */
        function load(){
        	if (isset($this->params['id'])){
        		$template=$this->model->obtenerTemplate($this->params['id']);
        		$template=utf8_string_array_encode($template);
	            $parametros = array_merge($this->menu, $template);
            	$this->view= new vGame($template[0]['template'], $parametros);	
        	}
        }

        function comprobarJuegoPasado(){
    		if(isset($_POST['usuario']) && isset($_POST['juego'])){
				$usuario=filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
				$juego=filter_input(INPUT_POST, 'juego', FILTER_SANITIZE_STRING);
				$res=$this->model->comprobarJuegoPasado($usuario,$juego);
				if($res==true){
					$output=["OK"];
					$this->json_out($output);
				}else{
					$output=["KO"];
					$this->json_out($output);
				}
			}
        }

        function registrarJuegoPasado(){
    		if(isset($_POST['usuario']) && isset($_POST['juego'])){
				$usuario=filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
				$juego=filter_input(INPUT_POST, 'juego', FILTER_SANITIZE_STRING);
				$res=$this->model->registrarJuegoPasado($usuario,$juego);
				if ($res==true){
					$output=["OK"];
					$this->json_out($output);
				}else{
					$output=["KO"];
					$this->json_out($output);
				}
			}
        }
}