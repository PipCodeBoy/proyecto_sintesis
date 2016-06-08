<div class="content" id="register-content">
	<?php
	echo '<nav style="align-self: flex-start;">
			<ol class="cd-breadcrumb">
				<li><a href="'.APP_W.'">Home</a></li>
				<li class="current"><em style="color:color:rgb(101, 190, 210)!important;">Registro</em></li>
			</ol>
		</nav>';
	?>
	<form id="register-form" action="<?= APP_W.'register/reg';?>" method="post">
		<label for="name">Nombre</label><input type="text" id="name" name="name" maxlength="24" /><br>
		<label for="last-name">Apellidos</label><input type="text" id="last-name" name="last-name" maxlength="90"><br>
		<label for="birth-date">Fecha de nacimiento</label><input type="date" id="birth-date" name="birth-date" /><br>
		<label for="email">Email</label><input type="email" id="email" name="email" maxlength="95" /><br>
		<label for="nick">Apodo</label><input type="text" id="nick" name="nick" maxlength="24" /><br>
		<label for="pass">Contraseña</label><input type="password" id="pass" name="pass" maxlength="30" /><br>
		<label for="repass">Confirmar</label><input type="password" id="repass" name="repass" maxlength="30" /><br>
		<label for="boy">Chico</label><input type="radio" id="boy" name="sex" value="h" class="input-radio" checked /><br>
		<label for="girl">Chica</label><input type="radio" id="girl" name="sex" value="m" class="input-radio" /><br>
		<div id="reg-msg"><p>Todos los campos deben rellenarse.<p></div>
		<input type="submit" value="Registrar" id="btn-act-register" class="btn" />
	</form>
</div>