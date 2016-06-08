<?php
	
	class Cart extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mCart(1);
		 	$parametros = array_merge($this->menu);
        	$this->view= new vCart($parametros);
		}
		
		function home(){
			// $this->games();
		}

		/**
		* 
		* Recives all the games and transforms them to json
		* 
		* */
    	function upgradeQuantityProduct(){
			if(isset($_POST["id_detalle"]) && isset($_POST["id_producto"])){
				$carro=Session::get('carro');
				$nuevoDetalle=new detalle_carro(null,$_POST["id_producto"],$_POST["nombre_producto"],$_POST["imagen"],1,$_POST["precio_unitario"]);
				$posicion=$this->buscarActiculoCarro($carro, $_POST["id_detalle"]);
				//Si que esta el articulo en el carro
				$carro->detalle[$posicion]->cantidad++;
				$res=$this->model->upgradeQuantityProductShoppingCart($carro->detalle[$posicion]);
				if($res==false){
					$carro->detalle[$posicion]->cantidad--;
					$output=["NO_STOCK"];
					$this->json_out($output);
				}else{
					//Guardamos los cambios en el carro de session
					Session::set('carro',$carro);
					$output=["OK",$carro->detalle[$posicion]->id_detalle_carro];
					$this->json_out($output);
				}
			}
			return false;
    	}

    	function downgradeQuantityProduct(){
			if(isset($_POST["id_detalle"]) && isset($_POST["id_producto"])){
				$carro=Session::get('carro');
				$nuevoDetalle=new detalle_carro(null,$_POST["id_producto"],$_POST["nombre_producto"],$_POST["imagen"],1,$_POST["precio_unitario"]);
				$posicion=$this->buscarActiculoCarro($carro, $_POST["id_detalle"]);
				//Si que esta el articulo en el carro
				if($carro->detalle[$posicion]->cantidad>1){
					$carro->detalle[$posicion]->cantidad--;
					$res=$this->model->downgradeQuantityProductShoppingCart($carro->detalle[$posicion]);
					if($res==false){
						$carro->detalle[$posicion]->cantidad++;
						$output=["KO"];
						$this->json_out($output);
					}else{
						//Guardamos los cambios en el carro de session
						Session::set('carro',$carro);
						$output=["OK",$carro->detalle[$posicion]->id_detalle_carro];
						$this->json_out($output);
					}
				}else{
					$output=["CANTIDAD_MINIMA"];
					$this->json_out($output);
				}
			}
			return false;
    	}

    	function deleteProduct(){
			if(isset($_POST["id_detalle"])){
				$carro=Session::get('carro');
				$nuevoDetalle=new detalle_carro(null,$_POST["id_producto"],$_POST["nombre_producto"],$_POST["imagen"],1,$_POST["precio_unitario"]);
				$posicion=$this->buscarActiculoCarro($carro, $_POST["id_detalle"]);
				$res=$this->model->deleteProductShoppingCart($carro->detalle[$posicion]);
				if($res==false){
					$output=["KO"];
					$this->json_out($output);
				}else{
					$output=["OK",$carro->detalle[$posicion]->id_detalle_carro];
					//Guardamos los cambios en el carro de session
					unset($carro->detalle[$posicion]);
					$carro->detalle=array_values($carro->detalle);
					Session::set('carro',$carro);
					//devolvemos el resultado
					$this->json_out($output);
				}	
			}
			return false;
    	}

    	function buscarActiculoCarro($carro, $id_detalle){   		
    		for($x=0;$x<count($carro->detalle);$x++){
				if($carro->detalle[$x]->id_detalle_carro==$id_detalle){
					return $x;
				}
    		}
    	}

    	function removeCart(){
			$carro=Session::get('carro');
			$res=$this->model->removeCart($carro);
			if($res==false){
				$output=["KO"];
				$this->json_out($output);
			}else{
				//eliminamos la session y la cookie
	    		SESSION::del('carro');
	    		setcookie("id_carro","", time()-3600, APP_W);
				unset ($_COOKIE['id_carro']);
				//devolvemos el resultado
				$output=["OK"];
				$this->json_out($output);
			}	
    		
    	}



}