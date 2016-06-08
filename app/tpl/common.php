<body>
<header>
	<div class="page-header">
		<div class="font-effect-anaglyph"><h1><a href="<?= APP_W; ?>"><?= $title; ?></a></h1></div>
	</div>
	<?php 
		if (!isset($_SESSION['user'])){
			echo '<div class="login">
					<form class="form-log" method="POST" action="'.APP_W.'home/log">
						<label for="email">User:<input type="text" name="email"></label>
						<label for="password">Password:<input type="password" name="password"></label>
						<input type="submit" class="btn btn-default" id="login-button" value="Entra">
					</form>';
		}else{
			echo '<div class="head-msg">';
			echo '<p>'.$_SESSION['user']->email.' | <a href="'.APP_W.'home/logout" >Logout</a></p>';
		}
	?>
	</div>
	</div>
	
</header>