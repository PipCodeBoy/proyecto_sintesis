<?php

	class mCart extends Model{

		function __construct($params){
			parent::__construct($params);
			
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

       	function downgradeQuantityProductShoppingCart($detalle){
       		try{
		    	$this->Query("UPDATE detalle_carro SET cantidad=? WHERE id_detalle_carro=?");
				$this->Bind(1,$detalle->cantidad);
				$this->Bind(2,$detalle->id_detalle_carro);
				$this->Execute();
		    	$res=$this->single();
		    	if( $this->rowCount()==1){
		          	return TRUE;
	        	}else{
          			return FALSE;
		        }
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

       	
		function deleteProductShoppingCart($detalle){
       		try{
		    	$this->Query("DELETE FROM detalle_carro WHERE id_detalle_carro=?");
				$this->Bind(1,$detalle->id_detalle_carro);
				$res=$this->Execute();
				return $res;
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

       	function removeCart($carro){
       		try{
		    	$this->Query("DELETE FROM carro WHERE id_carro=?");
				$this->Bind(1,$carro->id_carro);
				$res=$this->Execute();
				return $res;
			}catch(PDOException $e){
				echo "Error: ".$e->getMessage();
			}
       	}

	}