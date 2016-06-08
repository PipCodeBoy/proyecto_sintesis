<div class="content" id="admin-panel">

<?php
    
    echo '<nav style="align-self: flex-start;">
      <ol class="cd-breadcrumb">
        <li><a href="'.APP_W.'">Home</a></li>
        <li class="current"><em style="color:rgb(101, 190, 210)!important;">Perfil de administrador</em></li>
      </ol>
    </nav>';
    ?>

<div id="admin-align">

<div id="content" class="wrapper-admin-profile"></div>

<div class="form" id="new-user-form">
	<label for='nu-email'>Email* </label><input type="text" name="email" placeholder="ejemplo@email.com" id="nu-email" /> <br>
	<label for='nu-nick'>Apodo* </label><input type="text" name="nick" placeholder="nick" id="nu-nick" /> <br>
	<label for='nu-password'>Contraseña* </label><input type="text" name="password" id="nu-password" /> <br>
	<label for='nu-rep-pass'>Repetir Contraseña.* </label><input type="text" name="password" id="nu-rep-pass" /> <br>
	<label for='nu-name'>Nombre* </label><input type="text" name="name" id="nu-name" /> <br>
	<label for='nu-ape'>Apellidos* </label><input type="text" name="name" id="nu-ape" /> <br>
	<label for='nu-sex'>Sexo* </label><input maxlength="1" type="text" name="name" id="nu-sex" /> <br>
	<label for='nu-date'>Fecha Nacimiento* </label><input type="date" name="name" id="nu-date" /> <br>
	<label for='nu-phone'>Telefono* </label><input type="text" name="phone" id="nu-phone" /> <br>
	<label for='nu-rol'>Rol </label><select id="nu-rol">
										<option value="2">User</option>
										<option value="3">Moderator</option>
									</select> <br><br>
	<input type="button" value="Create" class="btn" id="btn-action-create" />
</div>
<div class="form" id="edit-form">
	<label for='ed-email'>Email* </label><input type="text" name="email" placeholder="" value="" id="ed-email" /> <br>
	<label for='ed-name'>Nombre* </label><input type="text" name="name" placeholder="" value="" id="ed-name" /> <br>
	<label for='ed-nick'>Apodo* </label><input type="text" name="name" placeholder="" value="" id="ed-nick" /> <br>
	<label for='ed-phone'>Telefono </label><input type="text" name="phone" placeholder="" value="" id="ed-phone" /> <br>
	<label for='ed-rol'>Rol </label><select id="ed-rol">
			<option value="2">User</option>
			<option value="1">Moderator</option>
		 </select> <br><br>
	<input type="button" value="Edit" class="btn" id="btn-action-edit" />
</div>

<div id="msg"></div>

</div>





</div>