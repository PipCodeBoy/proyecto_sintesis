<!DOCTYPE html>
<html lang="ES">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta charset="UTF-8">
  <title><?= $title; ?></title>
	
  <link rel="icon" href="<?= APP_W.'pub/img/general/logo.png'; ?>" type="image/png" sizes="16x16">
  <link rel="stylesheet" href="<?= APP_W.'pub/css/font-awesome.min.css'; ?>">
  <link rel="stylesheet"  type="text/css" href="<?= APP_W.'pub/css/style.css'; ?>">
  <script src="<?= APP_W.'pub/js/jquery.min.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/jquery-ui.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/jquery.ui.touch-punch.min.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/jquery.collapsible.min.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/js.cookie.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/jquery.cookiesdirective.js'; ?>"></script>
  <script src="<?= APP_W.'pub/js/app.js'; ?>"></script>

</head>


<div id="main">

<div id="top-menu">
  	<div id="logo"><a href="<?= APP_W ?>"><img src="<?= APP_W.'pub/img/general/logo.png'; ?>" alt="logo" /></a></div>
  	<div id="top-title"><a href="<?= APP_W ?>">TicTac Juegos</a></div>
  	<div id="cart"><a href="<?= APP_W.'cart/home'?>" class="cart-ico"><div id="numProdCarro">
    <?php
      if (Session::exist('carro')==true){
        echo str_pad(count(Session::get('carro')->detalle), 2, "0", STR_PAD_LEFT);
      }
    ?>
    </div></a></div>
  	<?php
      if(isset($_COOKIE['user']))
      {
        if($_COOKIE['user'] == 'h' || $_COOKIE['user'] == 'm'){
          if($_COOKIE['user'] == 'm')
          {
            echo "<div id='logged'><img src='".APP_W."pub/img/general/girl.jpg' /><div id='arrow-down'></div></div>";
          }
          else
          {
            echo "<div id='logged'><img src='".APP_W."pub/img/general/boy.jpg' /><div id='arrow-down'></div></div>";
          }
        }else{
          echo "<div id='top-login'><div class='user-ico'></div><div>LOGIN</div></div>";
        }
      } 
      else{
        echo "<div id='top-login'><div class='user-ico'></div><div>LOGIN</div></div>";
      }
  		
  	?>
</div>


<div id="login-box">
	<form action="<?= APP_W.'home/log'?>" method="post">
		<div id="fields">
			<div id="login-user"><input type="text" name="user" placeholder="Email o Usuario" /></div>
			<div id="login-pass"><input type="password" name="pass" placeholder="Contraseña" /></div>
		</div>

		<div id="login-actions">
			<a href="<?= APP_W.'register'?>"><input type="button" id="btn-regis" value="REGISTRATE" /></a>
			<input type="submit" id="btn-login" value="ENTRAR" />
		</div>
	</form>

	<div id="forgot"><a href="#">Olvidé la contraseña</a></div>
</div>

<div id="logged-drop">
  <?php
      if(isset($_COOKIE['user'])){
        echo '<a href="'.APP_W.'tictacjuegosapp.rar"><div class="logged-opt">Descargar App java</div></a>';
      }
  ?>
	<a href='<?= APP_W.'profile'?>'><div class="logged-opt"><div id="config-ico"></div>Configurar perfil</div></a>
	<a href='<?= APP_W.'home/logout'?>'><div class="logged-opt"><div id="logout-ico"></div>Cerrar sesión</div></a>
</div>	


<div id="ham-search">
	<div id="cat-menu-hamb"></div>

	<form id="search-bar-box" method="POST">
		<input type="text" id="search-bar" name="search-bar" placeholder="Sumar, aprender..." /><button id="btn-search"></button>
	</form>
</div>

<div id="cat-menu">
	<?php
    $x = -1;//Empieza en -1 porque tenemos un elemento que no es un array al principio de este array $data
		foreach($data as $value){
      if(is_array($value) && array_key_exists('id_categoria_juego',$value) && count($value)==4){//Asi identificamos el array con los datos de las categorias
  			echo "<a href='".APP_W."categoria/load/id/".$value['id_categoria_juego']."' id='cat-".$value['nombre']."' onmouseover=\"this.style.borderTop='4px solid rgba(".$value['color'].",1)';\" onmouseout=\"this.style.borderTop='none';\">".$value['nombre']."</a>";
  			unset($data[$x]);
      }
      $x++;
		}
	?>
	<a href="<?php echo APP_W.'store/load'; ?>">Tienda</a>
</div>


<input type="text" id="appw" value="<?= APP_W ?>" style="display:none;">