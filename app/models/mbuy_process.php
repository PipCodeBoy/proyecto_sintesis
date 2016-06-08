<?php

	class mBuy_process extends Model{

		function __construct($params){
			parent::__construct($params);
			
		}

		/**
		 * 
		 * Selects all the users with their addresses from db
 		 *
		 * @return array, All users
		 * 
		 * */
		

		function getuser(){
			$sql="SELECT * FROM usuarios LEFT JOIN domicilios on domicilios.usuario = usuarios.id_usuario WHERE id_usuario = :id";
			$this->query($sql);
			$this->bind(':id',$_SESSION['user']->idUser);
			$this->execute();
			$dades=$this->single();
			return $dades;
		}

		/**
		 * 
		 * Selects all the cities from db
 		 *
		 * @return array, All cities
		 * 
		 * */

		function getpobs(){
			
			$sql="SELECT * FROM poblaciones";
			$this->query($sql);
			$this->execute();
			$dades=$this->resultSet();
			return $dades;

		}

		/**
		 * 
		 * Adds a new sell bill with its details to db
 		 *
 		 * @param $envio int
 		 * @param $fact int
		 * @return array, A message to know if the bill has been created or not
		 * 
		 * */

		function addbill($envio,$fact){
			$carro = Session::get('carro');
	       	try{
		   		$this->beginTransaction();

		   		//Comprobamos si hay suficiente stock para poder vender todos los productos
		        for($i=0;$i<count($carro->detalle);$i++){
			        $sql="SELECT id_producto, nombre, stock_actual FROM productos WHERE id_producto=?";
					$this->query($sql);
					$this->bind(1,$carro->detalle[$i]->producto);
					$this->execute();
			       	$res=$this->single();
			       	if( $this->rowCount()==1){		       		
			       		if($carro->detalle[$i]->cantidad>$res['stock_actual']){
			       			$this->cancelTransaction();
		              		return $msg = array('response' => '-1', 'producto' => $carro->detalle[$i]->nombre_producto);
			       		}
			       	}else{
		       			$this->cancelTransaction();
		              	return $msg = array('response' => '-2', 'producto' => $carro->detalle[$i]->nombre_producto);
			       	}
		        }
				
		        //Si hemos llegado a este punto del codigo, significa que el stock es correcto y podemos proseguir
		        //Restamos todo el stock de los productos
	       		for($i=0;$i<count($carro->detalle);$i++){
	        		for($i=0;$i<count($carro->detalle);$i++){
				        $sql="UPDATE productos SET stock_actual=stock_actual-? WHERE id_producto=?";
						$this->query($sql);
						$this->bind(1,$carro->detalle[$i]->cantidad);
						$this->bind(2,$carro->detalle[$i]->producto);
						$this->execute();
				       	$res=$this->single();
				       	if( $this->rowCount()==0){
			       			$this->cancelTransaction();
			              	return $msg = array('response' => '-3');
				       	}
			        }
		        }

		        //Eliminamos el detalle del carro
        		for($i=0;$i<count($carro->detalle);$i++){
			    	$this->Query("DELETE FROM detalle_carro WHERE id_detalle_carro=?");
					$this->Bind(1,$carro->detalle[i]->id_detalle_carro);
					$res=$this->Execute();
			       	if( $res==false){
		       			$this->cancelTransaction();
		              	return $msg = array('response' => '-4');
			       	}
		        }

		        //Eliminamos el carro
		        $this->Query("DELETE FROM carro WHERE id_carro=?");
				$this->Bind(1,$carro->id_carro);
				$res=$this->Execute();
		       	if( $res==false){
	       			$this->cancelTransaction();
	              	return $msg = array('response' => '-5');
		       	}

		        //Una vez descontado el stock vamos a crear la factura y el detalle
			    $sql="INSERT INTO facturas_venta VALUES(null,:id,:envio,:fact,now(),'creado',0)";
				$this->query($sql);
				$this->bind(':id',$_SESSION['user']->idUser);
				$this->bind(':envio',$envio);
				$this->bind(':fact',$fact);
				$this->execute();
			    $fact = $this->lastInsertId();
				       
		       	$res=$this->single();
		       	if( $this->rowCount()==1){
		       		for($i=0;$i<count($carro->detalle);$i++)
		       		{
		       			$this->Query("INSERT INTO detalle_facturas_venta VALUES(null,?,?,?,?)");
				     	$this->Bind(1,$fact);
				     	$this->Bind(2,$carro->detalle[$i]->producto);
				     	$this->Bind(3,$carro->detalle[$i]->cantidad);
				     	$this->Bind(4,$carro->detalle[$i]->precio_unitario);
				     	$this->Execute();
				        // $carro->detalle[$i]->id_detalle_carro = $this->lastInsertId();
		       		}	        	
		        	$res=$this->single();
		        	if( $this->rowCount()==1){
		         		$this->endTransaction();
		              	return $msg = array('response' => '0');
		           	}else{
		            	$this->cancelTransaction();
		              return $msg = array('response' => '-6');
		         	}
		       	}else{
		       		$this->cancelTransaction();
	             	return $msg = array('response' => '-7');
	         	}
		       	
		   	}catch(PDOException $e){
		   		$this->cancelTransaction();
             	echo "Error: ".$e->getMessage();
             	return FALSE;
			    
        	}
			
			return TRUE;
		}


		/**
		 * 
		 * Selects all directions for the selected user
 		 *
		 * @return array, Directions of that user
		 * 
		 * */

		function getdirectionsbyuser(){
			
			$sql="SELECT * FROM domicilios WHERE usuario = :id";
			$this->query($sql);
			$this->bind(':id',$_SESSION['user']->idUser);
			$this->execute();
			$dades=$this->resultSet();
			return $dades;

		}

	}