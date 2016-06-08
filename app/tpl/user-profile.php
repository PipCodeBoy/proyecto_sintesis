<div class="content" id="profile-content">
<?php
    
    echo '<nav style="align-self: flex-start;">
      <ol class="cd-breadcrumb">
        <li><a href="'.APP_W.'">Home</a></li>
        <li class="current"><em style="color:rgb(101, 190, 210)!important;">Perfil de usuario</em></li>
      </ol>
    </nav>';
    ?>

  <div id="profile-title">Configuración del perfil</div>

  <form id="profile-form" action="" method="post">
    <label for="name">Nombre</label><input type="text" readonly id="name" name="name" maxlength="24" placeholder="" /><br>

    <label for="last-name">Apellidos</label><input readonly type="text" id="last-name" name="last-name" maxlength="90" placeholder="" /><br>

    <label for="birth-date">Fecha de nacimiento</label><input readonly type="date" id="birth-date" name="birth-date" placeholder="" /><br>

    <label for="email">Email</label><input type="email" id="email" name="email" maxlength="95" placeholder="" /><br>

    <label for="nick">Apodo</label><input type="text" id="nick" name="nick" maxlength="24" placeholder="" /><br>
    
    <label for="pass">Contraseña</label><input type="password" id="pass" name="pass" maxlength="30" placeholder="" /><br>
    
    <label for="repass">Confirmar</label><input type="password" id="repass" name="repass" maxlength="30" placeholder="" /><br>
    
    <label for="phone">Telefono</label><input type="text" id="phone" name="phone" maxlength="15" placeholder="" /><br>

    <div>
      <label for="ship-addr">Dirección de envio</label>
      <select class="addrs" id="ship-addr" name="ship-addr">
      </select>
      <span class="add-ico" id="add-ship-addr"></span>
      <span class="del-ico" id="del-ship-addr"></span>
      <span class="def-ico" id="def-ship-addr"></span>
      <div id="add-ship-addr-box">
        <input type="text" class="address" id="addres-prfile" placeholder="Dirección" />
        <input type="text" class="postal" id="postal-prfile" maxlength="5" placeholder="Código Postal" />
        <select id="pob-addr" class="pob-addr" name="ship-addr">
        </select>
        <input type="button" id="act-add-ship-addr" class="btn" value="AÑADIR" />
        <div id="ship-msg"></div>
      </div>
    </div>

    <div>
      <label for="fact-addr">Dirección de facturación</label>
      <select class="addrs" id="fact-addr" name="fact-addr">
      </select>
      <span class="add-ico" id="add-fact-addr"></span>
      <span class="del-ico" id="del-fact-addr"></span>
      <span class="def-ico" id="def-fact-addr"></span>
      <div id="add-fact-addr-box">
        <input type="text" class="address" id="fact-addrs"  placeholder="Dirección" />
        <input type="text" class="postal" id="fact-postal" maxlength="5" placeholder="Código Postal" />
        <select id="pob-fact-addr" class="pob-addr" name="fact-addr">
        </select>
        <input type="button" id="act-add-fact-addr" class="btn" value="AÑADIR" />
        <div id="fact-msg"></div>
      </div>
    </div>

    <div id="profile-msg"></div>

    <input type="submit" value="GUARDAR" id="save-profile" class="btn">
      

  </form>




</div>