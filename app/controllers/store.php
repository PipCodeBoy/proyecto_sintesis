<?php
	
	class Store extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mStore(1);
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
			if (isset($_GET['pag'])){
				$_GET['pag']=filter_input(INPUT_GET, 'pag', FILTER_SANITIZE_STRING);
			}else{
				$_GET['pag']=1;
			}
    		/*$idCategoria=filter_input(INPUT_POST, 'idCategoria', FILTER_SANITIZE_STRING);
			$pagina=filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_STRING);*/
			$contGames=$this->model->contadorPaginasProductos();
			if($_GET['pag']<=$contGames[0]["maxPaginas"]){
				$games=$this->model->gamesCategoria($_GET['pag']);
	            $games=utf8_string_array_encode($games);
	            $parametros = array_merge($this->menu, $games, $contGames);
	        	$this->view= new vStore($parametros);
	        }else{
	        	header("Location: ".APP_W.'store/load');
	        }
    	}
       
		/**
		* 
		* Recives all the games and transforms them to json
		* 
		* */
    	function addProductShoppingCart(){
			if(isset($_POST["id_producto"]) && isset($_POST["precio_unitario"]) && isset($_POST["nombre_producto"]) && isset($_POST["imagen"])){
				//Comprobamos si tenemos un carro cargado en session
				if(Session::exist('carro')){
					$carro=Session::get('carro');
					$nuevoDetalle=new detalle_carro(null,$_POST["id_producto"],$_POST["nombre_producto"],$_POST["imagen"],1,$_POST["precio_unitario"]);
					$posicion=$this->comprobarActiculoCarro($carro, $nuevoDetalle);
					if($posicion==-1){
						//No esta el articulo en el carro
						array_push($carro->detalle, $nuevoDetalle);
						$res=$this->model->addProductShoppingCart($carro);
					}else{
						//Si que esta el articulo en el carro
						$carro->detalle[$posicion]->cantidad++;
						$res=$this->model->upgradeQuantityProductShoppingCart($carro->detalle[$posicion]);
						if($res==false){
							$carro->detalle[$posicion]->cantidad--;
							$output=["NO_STOCK"];
							$this->json_out($output);
							return false;
						}
					}
				}else{
					//No hay carrito en esta session, creamos uno y creamos la cookie en el pc
					$detalleCarro=array(new detalle_carro(null,$_POST["id_producto"],$_POST["nombre_producto"],$_POST["imagen"],1,$_POST["precio_unitario"]));//Creamos el detalle primero
					//Comprobamos si tenemos la id del usaurio
					if (isset($_SESSION['user']->idUser)){
						$user=$_SESSION['user']->idUser;
					}else{
						$user=null;
					}
					$carro=new carro(null,date("Y-m-d H:i:s"),null,$detalleCarro);//Creamos el carro
					$res=$this->model->createShoppingCart($carro);//Lamamos al modelo y que haga el insert en la base de datos
				}

				if($res==true){
						//Guardamos el carro en session
						Session::set('carro',$carro);
						//Creamos una cookie con el id_carro que hemos creado
						setcookie('id_carro',$_SESSION['carro']->id_carro,time()+(7*24*60*60),APP_W);//time()+(7*24*60*60) expira en una semana
						//Devolvemos OK
						$output=["OK"];
						$this->json_out($output);
					}else{
						$output=["KO"];
						$this->json_out($output);
					}
			}
			return false;
    	}

    	function comprobarActiculoCarro($carro, $nuevoDetalle){   		
    		for($x=0;$x<count($carro->detalle);$x++){
				if($carro->detalle[$x]->producto==$nuevoDetalle->producto){
					return $x;
				}
    		}
    		return -1;
    	}

    	function contarProductosCarro(){
    		if(Session::exist('carro')){
    			$output=[str_pad(count(Session::get('carro')->detalle), 2, "0", STR_PAD_LEFT)];
			}else{
				$output=["KO"];
			}
			$this->json_out($output);
    	}

}