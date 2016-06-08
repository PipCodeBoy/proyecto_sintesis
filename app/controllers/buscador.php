<?php
	
	class Buscador extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mBuscador(1);
		}
		
		function home(){
			// $this->games();

		}

		/**
		* 
		* Recives all the games and transforms them to json
		* 
		* */
   //      function load(){
			// if (isset($this->params['key'])){
			// 	if (isset($_GET['pag'])){
			// 		$_GET['pag']=filter_input(INPUT_GET, 'pag', FILTER_SANITIZE_STRING);
			// 	}else{
			// 		$_GET['pag']=1;
			// 	}

			// 	//-mente
			// 	//adverbio
			// 	$arrayAdverbios = array('ahora',
			// 						'antes',
			// 						'despues',
			// 						'tarde',
			// 						'luego',
			// 						'ayer',
			// 						'temprano',
			// 						'ya',
			// 						'todavia',
			// 						'anteayer',
			// 						'aun',
			// 						'pronto',
			// 						'hoy',
			// 						'aqui',
			// 						'ahi',
			// 						'alli',
			// 						'cerca',
			// 						'lejos',
			// 						'fuera',
			// 						'dentro',
			// 						'alrededor',
			// 						'aparte',
			// 						'encima',
			// 						'debajo',
			// 						'delante',
			// 						'detras	',
			// 						'asi',
			// 						'bien',
			// 						'mal',
			// 						'despacio',
			// 						'deprisa',
			// 						'como	',
			// 						'mucho',
			// 						'poco',
			// 						'muy',
			// 						'casi',
			// 						'todo',
			// 						'nada',
			// 						'algo',
			// 						'medio',
			// 						'demasiado',
			// 						'bastante',
			// 						'mas',
			// 						'menos',
			// 						'ademas',
			// 						'incluso',
			// 						'tambien',
			// 						'si',
			// 						'tambien',
			// 						'asimismo',
			// 						'no',
			// 						'tampoco',
			// 						'jamas',
			// 						'nunca	',
			// 						'acaso',
			// 						'quiza');

			// 	//preposiciones
			// 	$arrayPreposiciones = array('a',
			// 						'ante',
			// 						'bajo',
			// 						'cabe ',
			// 						'con',
			// 						'contra',
			// 						'de',
			// 						'desde',
			// 						'en',
			// 						'entre',
			// 						'hacia',
			// 						'hasta',
			// 						'para',
			// 						'por',
			// 						'segun',
			// 						'sin',
			// 						'so',
			// 						'sobre',
			// 						'tras ');


			// 	$palabras = explode("%20", $this->params['key']);
			// 	//SELECT * FROM juegos WHERE descripcion REGEXP 'Divertido|instrumentos'
   //      		/*$idCategoria=filter_input(INPUT_POST, 'idCategoria', FILTER_SANITIZE_STRING);
			// 	$pagina=filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_STRING);*/
			// 	$contGames=$this->model->contadorPaginasBusqueda($this->params['key']);
			// 	$games=$this->model->gamesBusqueda($this->params['id'],$_GET['pag']);
	  //           $games=utf8_string_array_encode($games);
	  //           $parametros = array_merge($this->menu, $games, $contGames);
   //          	$this->view= new vBuscador($parametros);
   //      	}
   //      }

		function autoCompletar(){
			if(isset($_GET['q'])){
				$games=$this->model->buscarJuegoAutocompletado($_GET['q']);
				$games=utf8_string_array_encode($games);
				$this->json_out($games);
			}
        }

}