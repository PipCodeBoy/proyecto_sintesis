<?php
	
	class Buy_process extends Controller{
		
		function __construct($params){
			parent::__construct($params);
			$this->model=new mBuy_process(1);
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
            if(SESSION::exist('carro')){
                $this->view= new vBuy_process($this->menu);
            }else{
                header('Location: '.APP_W);
            }
    	}

    	/**
		*    
		*  Recives all users from db and transforms them to json
		* 
		* */

    	function getuser(){
    		$user=$this->model->getuser();
        	$user=utf8_string_array_encode($user);
        	$this->json_out($user);
    	}

    	/**
		*    
		*  Recives all cities from db and transforms them to json
		* 
		* */

    	function getpobs(){
    		$pobs=$this->model->getpobs();
        	$pobs=utf8_string_array_encode($pobs);
        	$this->json_out($pobs);
    	}

    	/**
		*    
		*  Recives directions and sends them to model to insert  new bill
		* 
		* */

    	function addbill(){
    		$fact = 0;
    		$envio = $_POST['envio'];

    		if(isset($_POST['fact']) && $_POST['fact'] != "")
    		{
    			$fact = $_POST['fact'];
    		}
    		
    		$pobs=$this->model->addbill($envio,$fact);
            if($pobs["response"]==0){
                //Todo ha ido bien, eliminamos la cookie y la session del carro
                //eliminamos la session y la cookie
                SESSION::del('carro');
                setcookie("id_carro","", time()-3600, APP_W);
                unset ($_COOKIE['id_carro']);
            }
            $pobs=utf8_string_array_encode($pobs);
        	$this->json_out($pobs);
    	}

    	/**
		*    
		*  Recives all directions from the logged user and transforms them to json
		* 
		* */

    	function getdirectionsbyuser(){
    		$pobs=$this->model->getdirectionsbyuser();
        	$pobs=utf8_string_array_encode($pobs);
        	$this->json_out($pobs);
    	}

}