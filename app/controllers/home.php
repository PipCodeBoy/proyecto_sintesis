<?php
	
	class Home extends Controller{
		protected $model;
		protected $view;
		protected $params;

		//protected $paginator;
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mHome(1);
			//Compruebo si tiene un carro en la base de datos y de solo cargarlo una unica vez durante toda la session
			if (isset($_COOKIE['id_carro']) && Session::exist('carro')==false){
				$this->comprobarCarro($_COOKIE['id_carro']);
			}
			// die(var_dump($this->menu));
			$this->view= new vHome($this->menu);
			
			
			//$this->model->pagination=true;
			//$this->pag=new paginator();
			
			//echo 'Hello controller!';
		}
		function home(){
			// $this->games();
		}

		/**
		 * 
		 * Calls the model of this controller trying to login, it gets all the data from the form and pass it to the model,
		 * then, if the login is succesful, it will create 2 cookies, one with user's email and the other with the user's rol * and redirect it to the profile
		 *
		 * 
		 * */
		function log(){
			if (!empty($_POST['user']) && !empty($_POST['pass'])) {
				$email=strtolower($_POST['user']);
				$password=md5($_POST['pass']);
				$user=$this->model->login($email,$password);
				if ($user==true){
					Session::set('islogged',TRUE);
					setcookie('user',$_SESSION['user']->sex,0,APP_W);
					setcookie('userid',$_SESSION['user']->idUser,0,APP_W);
					setcookie('rol',$_SESSION['user']->rol,0,APP_W);
					if (isset($_POST['process'])) {
						header("Location: ".APP_W.'buy_process/load');
					}else{
						header("Location: ".APP_W);
					}
				}else{
					if(isset($_POST['process'])){
						header("Location: ".APP_W.'buy_process/load');
					}else{
						header("Location: ".APP_W);	
					}
				}
			}else{
				if(isset($_POST['process'])){
					header("Location: ".APP_W.'buy_process/load');
				}else{
					header("Location: ".APP_W);	
				}
			}
		}

		/**
		 * 
		 * Destroys de session and logs out the current user
		 * 
		 * */

		function logout(){
			Session::destroy();
			setcookie('user',0,0,APP_W);
			header('Location:'.APP_W);
		}

		/**
		* 
		* Recives all the games and transforms them to json
		* 
		* */
        function games(){
            $games=$this->model->games();
            $games=utf8_string_array_encode($games);
            $this->json_out($games);
        }

        /**
		* 
		* Recives a cardshop and transforms them to json
		* 
		* */
        function comprobarCarro($id_carro){
        	$datosCarro=$this->model->comprobarCarro($id_carro);
        	$detalle=array();
        	foreach($datosCarro as $value){
      			array_push($detalle,new Detalle_carro($value['id_detalle_carro'],$value['producto'],$value['nombre'],APP_W.$value['imagen'],$value['cantidad'],$value['precio_unitario']));
			}
			Session::set('carro',new Carro($datosCarro[0]['id_carro'],$datosCarro[0]['fecha_creacion'],$datosCarro[0]['fecha_actualizacion'],$detalle));
        }

        /*function crearCarro(){
			if(isset($_POST["id_producto"]) && isset($_POST["precio_unitario"])){
				$detalleCarro=array(new detalle_carro(null,$_POST["id_producto"],1,$_POST["precio_unitario"]));//Creamos el detalle primero
				//Comprobamos si tenemos la id del usaurio
				if (isset($_SESSION['user']->idUser)){
					$user=$_SESSION['user']->idUser;
				}else{
					$user=null;
				}
				$carro=new ccarro(null,Session::get('id'),$user,date("Y-m-d H:i:s"),null,$detalleCarro);//Creamos el carro
				$res=$this->model->insertarCarro($carro);//Lamamos al modelo y que haga el insert en la base de datos
				if($res==true){
					$output=["OK"];
					$this->json_out($output);
				}else{
					$output=["KO"];
					$this->json_out($output);
				}
			}
		}*/

		/*function crearCarro($carro){
			try{
				$this->beginTransaction();
				$this->Query("INSERT INTO carro(cookie, usuario, fecha_creacion, fecha_actualizacion) VALUES(?,?,?,?)");
				$this->Bind(1,$carro->cookie);
				$this->Bind(2,$carro->usuario);
				$this->Bind(3,$carro->fecha_creacion);
				$this->Bind(4,$carro->fecha_actualizacion);
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
				    	Session::set('carro',new user($user['email'],
						$user['id_usuario'],
						$user['rol'],
						$user['apodo'],
						$user['sexo']));
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

		}*/
}