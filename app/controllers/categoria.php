<?php
	
	class Categoria extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mCategoria(1);
		}
		
		function home(){
			// $this->games();

		}

		/**
		* 
		* Recives all the categories, transforms them to json and create the view.
		* 
		* */
        function load(){
			if (isset($this->params['id'])){
				if (isset($_GET['pag'])){
					$_GET['pag']=filter_input(INPUT_GET, 'pag', FILTER_SANITIZE_STRING);
				}else{
					$_GET['pag']=1;
				}
        		/*$idCategoria=filter_input(INPUT_POST, 'idCategoria', FILTER_SANITIZE_STRING);
				$pagina=filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_STRING);*/
				$res=$this->model->comprobarExisteCategoria($this->params['id']);
				if($res==true){
					$contGames=$this->model->contadorPaginasGamesCategoria($this->params['id']);
					if($_GET['pag']<=$contGames[0]["maxPaginas"]){
						$games=$this->model->gamesCategoria($this->params['id'],$_GET['pag']);
			            $games=utf8_string_array_encode($games);
			            $parametros = array_merge($this->menu, $games, $contGames);
		            	$this->view= new vCategoria($parametros);
					}else{
						header("Location: ".APP_W.'categoria/load/id/'.$this->params['id']);
					}
				}else{
					header("Location: ".APP_W);
				}
        	}
        }

}