<div class="content">
	<?php
		
		echo '<nav>
			<ol class="cd-breadcrumb">
				<li><a href="'.APP_W.'">Home</a></li>
				<li><a href="'.APP_W.'cart/home">Carro</a></li>
				<li class="current"><em style="color:#EB9532!important;">Proceso de Compra</em></li>
			</ol>
		</nav>';
		?>
<!--<?php //die(var_dump($_SESSION["carro"]->detalle[1])); ?>-->
<section class="seccionProcesoCompra">
	<div class="colProcesoCompra1">
		<div class="cabeceraProcesoCompra">
			<div class="tituloPrincipalProcesoCompra"><h2>Proceso de compra</h2></div>
		</div>
		<div class="contenedorProcesoCompra">
			<div id="procesoCompra">
				<?php if(!isset($_SESSION['user']))
					{
				 ?>
					
				<h3>Paso 1. Identificarse <img id="imgOkPaso1" src="<?= APP_W.'pub/img/general/check.png'; ?>" alt="" style="width: 21px; height: 17px; display: none"></h3>
				<div class="paso1">
					<div class="contNuevoUsuario">
						<div class="contTitulo"><h2>Nuevo usuario</h2></div>
						<div class="contCuerpo">
							<div id="width-cuenta">
								<a href="<?= APP_W.'register'; ?>" class="botonSiguiente" id="btnCrearCuenta">Crear cuenta</a>
							</div>
						</div>
					</div>
					<hr class="hrVertical">
					<div class="contUsuario" id="proRegister">
						<div class="contTitulo"><h2>Usuario Registrado</h2></div>
						<div class="contCuerpo">
								<form action="<?= APP_W.'home/log'; ?>" method="post">
									<div>
										<label for="correo1">Correo electronico:</label>
										<input type="text" id="correo1" name="user" />
									</div>
									<div>
										<label for="pass1" id="contrar">Contraseña:</label>
										<input type="password" id="pass1" name="pass" />
										<input type="hidden" name="process" value="process"/>
									</div>
									<div>
										<a href="#" style="margin-right: 25px;">Olvidé la contraseña</a>
										<input type="submit" class="botonSiguiente btnAcceder" id="btn-login" value="Acceder"></input>
									</div>
								</form>
						</div>	
					</div>
				</div>
				<?php } if(isset($_SESSION['user'])){ ?>
				<h3>Paso 2. Envío/Pago <img id="imgOkPaso2" src="<?= APP_W.'pub/img/general/check.png'; ?>" alt="" style="width: 21px; height: 17px; display: none"></h3>
				<div class="paso2">
					<div class="alineadorFlexLinea ocuparw100" id="datosEnvFac">
						<div class="contEnvio">
							<div class="contTitulo"><h2>Datos de envio</h2></div>
							<div class="contCuerpo">
								<div>
									<label for="name1">Nombre:</label>
									<input type="text" id="name1">
								</div>
								<div>
									<label for="lastname1">Apellidos:</label>
									<input type="text" id="lastname1">
								</div>
								<div>
									<label for="pob1">Población:</label>									
									<select id="pob1"></select>
								</div>
								<div>
									<label for="address1">Dirección:</label>
									<select id="address1"></select>
								</div>
								<div>
									<label for="postal1">Código postal:</label>
									<input type="text" id="postal1" maxlength="5">
								</div>
								<div>
									<label for="telef1">Teléfono:</label>
									<input type="text" id="telef1" maxlength="9">
								</div>
								<div class="justificarFlex_End">
									<input type="checkbox" id="copyFields">
									<label for="copyFields">&nbsp Copiar datos para facturación</label>
								</div>
							</div>
						</div>
						<div class="contFacturacion">
							<div class="contTitulo"><h2>Datos de Facturación</h2></div>
							<div class="contCuerpo">
								<div>
									<label for="name2">Nombre:</label>
									<input type="text" id="name2">
								</div>
								<div>
									<label for="lastname2">Apellidos:</label>
									<input type="text" id="lastname2">
								</div>
								<div>
									<label for="pob2">Población:</label>									
									<select id="pob2"></select>
								</div>
								<div>
									<label for="address2">Dirección:</label>								
									<select id="address2"></select>
								</div>
								<div>
									<label for="postal2">Código postal:</label>
									<input type="text" id="postal2" maxlength="5">
								</div>
								<div>
									<label for="telef2">Teléfono:</label>
									<input type="text" id="telef2" maxlength="9">
								</div>
							</div>
						</div>
					</div>
					<hr class="separador1 ocuparw100">
					<div class="alineadorFlexLinea ocuparw100" id="pago">
						<div class="contEnvio">
							<div class="contTitulo"><h2>Método de pago</h2></div>
							<div class="contCuerpo justificarFlex_End">
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="" checked>
									<label for="nuCorreo">V.me by Visa</label>
								</div>
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="">
									<label for="nuPass">Tarjeta de crédito/débito</label>
								</div>
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="">
									<label for="nuRePass">Sofort - Transferencia bancaria</label>
								</div>
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="">
									<label for="nuRePass">Transferencia</label>
								</div>
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="">
									<label for="nuRePass">PayPal</label>
								</div>
								<div class="justificarFlex_End">
									<input type="radio" name="metodoPago" value="">
									<label for="nuRePass">Contra reembolso</label>
								</div>
							</div>
						</div>
						<div class="contEnvio" id="opEnvio">
							<div class="contTitulo"><h2>Opciones de envio</h2></div>
							<div class="contCuerpo">
								<div class="justificarFlex_End">
									<input type="radio" name="metodoEnvio" value="" checked>
									<img src="<?= APP_W.'pub/img/tienda/seur.png'; ?>" alt="">
								</div>
								<div class="justificarFlex_End" style="margin-top:15px;">
									<input type="radio" name="metodoEnvio" value="">
									<img src="<?= APP_W.'pub/img/tienda/correos.png'; ?>" alt="">
								</div>
								<div class="justificarFlex_End" style="margin-top:15px;">
									<input type="radio" name="metodoEnvio" value="">
									<img src="<?= APP_W.'pub/img/tienda/redyser.png'; ?>" alt="">
								</div>
							</div>
						</div>
					</div>
					<div class="centerChildren">
						<div id="msg-process"></div>
						<button class="botonSiguiente" id="btnContinuarPaso2" style="margin:0px;">Continuar</button>
					</div>
				</div>
				<h3>Paso 3. Resumen <img id="imgOkPaso3" src="<?= APP_W.'pub/img/general/check.png'; ?>" alt="" style="width: 21px; height: 17px; display: none"></h3>
				<div id="paso3">
				<div id="paso3-1">
					<div class="contenedorCarro" id="processCart">
						<div class="cabeceraCarro">
							<div class="tituloCarro">
								<div class="c1ItemCarro" ><h3 style="font-size: 17px;">Articulo</h3></div>
								<div class="c2ItemCarro"><h3 style="font-size: 17px;">Precio/U.</h3></div>
								<div class="c3ItemCarro"><h3 style="font-size: 17px;">Cantidad</h3></div>
								<div class="c4ItemCarro"><h3 style="font-size: 17px;">Subtotal</h3></div>
							</div>
						</div>

						<?php
							for($i=0;$i<count($_SESSION['carro']->detalle);$i++)
							{
								echo 
									'<div class="itemCarro">
										<div class="contenidoItemCarro nombreItemCarro">
											<div class="nombreItemCarro">
												<span><img width="50px" height="50px" src="'.$_SESSION['carro']->detalle[$i]->imagen_producto.'"/> '.$_SESSION['carro']->detalle[$i]->nombre_producto.'</span>
											</div>
										</div>
										<div class="precioUnitarioItemCarro c2ItemCarro">'.$_SESSION['carro']->detalle[$i]->precio_unitario.'€</div>
										<div class="cantidadItemCarro c3ItemCarro">
											<p>'.$_SESSION['carro']->detalle[$i]->cantidad.'</p>
										</div>
										<div class="subtotalItemCarro c4ItemCarro"><span>'.$_SESSION['carro']->detalle[$i]->precio_unitario*$_SESSION['carro']->detalle[$i]->cantidad.'€</span></div>
									</div>';
							}
							
						?>
						
						<!--<div class="itemCarro">
							<div class="contenidoItemCarro c1ItemCarro">
								<div class="nombreItemCarro">
									<span">1</span>
								</div>
							</div>
							<div class="precioUnitarioItemCarro c2ItemCarro">22.90€</div>
							<div class="cantidadItemCarro c3ItemCarro">
								<p>1</p>
							</div>
							<div class="subtotalItemCarro c4ItemCarro">
								<span>22.90€</span>
							</div>
						</div>-->

					</div>
					<div id="resumenDatos">
						<div>
							<div class="datosResumen">
								<div class="contTitulo"><h2 style="font-size: 17px;">Datos de facturación:</h2></div>
								<div class="contCuerpo">
									<p id="resName1">Manuel Solé Gallardo</p>
									<p id="resAddress1">C/ Colomeres 15ª 1º </p>
									<p><span id="resPostal1">08850 </span><span id="resPob1"> Gava</span></p>
									<p>España</p>
								</div>
							</div>
						</div>
						<div>
							<div class="datosResumen">
								<div class="contTitulo"><h2 style="font-size: 17px;">Dirección de entrega:</h2></div>
								<div class="contCuerpo">
									<p id="resName2">Manuel Solé Gallardo</p>
									<p id="resAddress2">C/ Colomeres 15ª 1º </p>
									<p><span id="resPostal2">08850 </span><span id="resPob2"> Gava</span></p>
									<p>España</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="finComp">
					<button class="botonSiguiente" id="btnContinuarPaso3" style="margin:0px;">Finalizar Compra</button>
				</div>
				</div>
					<h3>Paso 4. Finalizar</h3>
				<div  id="finalText">
					<img id="img-correct" src="<?= APP_W.'pub/img/general/correct.png'; ?>" alt="" style="width: 250px;height: 250px;">
					<div>
						<p style="font-size: 20px;">Gracias por su compra, recibirá su pedido en un plazo de 7 días.</p>
						<p><a href="<?= APP_W.'store/load'; ?>" class="link-volver-tienda">Pulse Aquí </a>para volver a la tienda</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="dialog-mensaje" title="Info" style="display:none;">
		<p id="mensajeModal"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
	</div>
</section>
</div>