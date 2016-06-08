<?php

	class mStore extends Model{

		function __construct($params){
			parent::__construct($params);
			
		}
		/**
		 * 
		 * 
		 *
		 * 
		 * @return boolean
		 * 
		 * */

		
		function contadorPaginasProductos(){			
			$sql="SELECT CEILING(COUNT(productos.nombre)/12) as maxPaginas FROM productos WHERE  productos.stock_actual > 0";
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

       	function gamesCategoria($pagina){
			$sql="SELECT *,productos.nombre FROM productos WHERE productos.stock_actual > 0 LIMIT 12";
			if($pagina>1){
				$sql=$sql." OFFSET ".(($pagina)-1)*12;
			}
           	$this->query($sql);
           	$this->execute();
           	return $dades=$this->resultSet();
       	}

       	function createShoppingCart($carro){
       		try{
				$this->beginTransaction();
				$this->Query("INSERT INTO carro(fecha_creacion, fecha_actualizacion) VALUES(?,?)");
				$this->Bind(1,$carro->fecha_creacion);
				$this->Bind(2,$carro->fecha_actualizacion);
				$this->Execute();
				$carro->id_carro = $this->lastInsertId();
			    
			    $res=$this->single();
			    if( $this->rowCount()==1){
			    	$this->Query("INSERT INTO detalle_carro(carro, producto, cantidad, precio_unitario) VALUES(?,?,?,?)");
					$this->Bind(1,$carro->id_carro);
					$this->Bind(2,$carro->detalle[0]->producto);
					$this->Bind(3,$carro->detalle[0]->cantidad);
					$this->Bind(4,$carro->detalle[0]->precio_unitario);
					$this->Execute();
			    	$carro->detalle[0]->id_detalle_carro = $this->lastInsertId();
			    	
			    	$res=$this->single();
			    	if( $this->rowCount()==1){
				    	$this->endTransaction();
			          	return TRUE;
		        	}else{
		        		$this->cancelTransaction();
	          			return FALSE;
			        }
			    }
		    	else {
		          	return FALSE;
		      	}
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

       	function addProductShoppingCart($carro){
       		try{
			   	$this->Query("INSERT INTO detalle_carro(carro, producto, cantidad, precio_unitario) VALUES(?,?,?,?)");
				$this->Bind(1,$carro->id_carro);
				$this->Bind(2,$carro->detalle[count($carro->detalle)-1]->producto);
				$this->Bind(3,$carro->detalle[count($carro->detalle)-1]->cantidad);
				$this->Bind(4,$carro->detalle[count($carro->detalle)-1]->precio_unitario);
				$this->Execute();
		    	$carro->detalle[count($carro->detalle)-1]->id_detalle_carro = $this->lastInsertId();
		    	$res=$this->single();
		    	if($this->rowCount()==1){
		          	return TRUE;
	        	}else{
          			return FALSE;
		        }
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

       	function upgradeQuantityProductShoppingCart($detalle){
       		try{
				$this->beginTransaction();
				$this->Query("SELECT id_producto FROM productos WHERE id_producto=? AND stock_actual>?");
				$this->Bind(1,$detalle->producto);
				$this->Bind(2,$detalle->cantidad-1);
				$this->Execute();
			    $res=$this->single();
			    if( $this->rowCount()==1){
			    	$this->Query("UPDATE detalle_carro SET cantidad=? WHERE id_detalle_carro=?");
					$this->Bind(1,$detalle->cantidad);
					$this->Bind(2,$detalle->id_detalle_carro);
					$this->Execute();
			    	$res=$this->single();
			    	if( $this->rowCount()==1){
				    	$this->endTransaction();
			          	return TRUE;
		        	}else{
		        		$this->cancelTransaction();
	          			return FALSE;
			        }
			    }
		    	else {
		          	return FALSE;
		      	}
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

	}