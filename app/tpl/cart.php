<div class="content" id="content-cart">
	<?php
		echo '<nav style="margin-left:-3%;">
			<ol class="cd-breadcrumb">
				<li><a href="'.APP_W.'">Home</a></li>
				<li class="current"><em style="color:#EB9532!important;">Tienda</em></li>
			</ol>
		</nav>';
	?>
	<section class="seccionCarro">
		<div class="contenedorCarro">
			<div class="cabeceraCarro">
				
			<?php
				if (Session::exist('carro')==true){
					echo '<div class="tituloPrincipalCarro"><h2>Carro de la compra</h2> 
							<a href="'.APP_W.'buy_process/load" class="btn-pay"><button class="btn">Ir a pagar</button></a>
							</div>	
							<div class="tituloCarro">
							<div class="c1ItemCarro"><h3>Producto</h3></div>
							<div class="c2ItemCarro"><h3>Precio unitario</h3></div>
							<div class="c3ItemCarro"><h3>Cantidad</h3></div>
							<div class="c4ItemCarro"><h3>Subtotal</h3></div>
							<div class="c5ItemCarro"></div>
						</div>
					</div>';

					for($i=0;$i<count($_SESSION['carro']->detalle);$i++)
					{
						echo 
							'<div class="itemCarro" id="ItemCart'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'">
								<div class="contenidoItemCarro c1ItemCarro">
									<div class="imagenItemCarro">
										<a href="#" class="linkSinEstilo"><img src="'.$_SESSION['carro']->detalle[$i]->imagen_producto.'" alt=""></a>
									</div>
									<div class="nombreItemCarro">'.$_SESSION['carro']->detalle[$i]->nombre_producto.'</div>
								</div>
								<div class="precioUnitarioItemCarro c2ItemCarro" id="precio'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'">'.$_SESSION['carro']->detalle[$i]->precio_unitario.'€</div>
								<div class="cantidadItemCarro c3ItemCarro">
									<div class="ico-minus btnMinusProductCart" data-id_detalle="'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'" data-id_producto="'.$_SESSION['carro']->detalle[$i]->producto.'"></div>
									<input type="text" value="'.$_SESSION['carro']->detalle[$i]->cantidad.'" id="cantidad'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'">
									<div class="ico-plus btnPlusProductCart"  data-id_detalle="'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'" data-id_producto="'.$_SESSION['carro']->detalle[$i]->producto.'"></div>
								</div>
								<div class="subtotalItemCarro c4ItemCarro">
									<span id="subtotal'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'">'.($_SESSION['carro']->detalle[$i]->precio_unitario*$_SESSION['carro']->detalle[$i]->cantidad).'€</span>
								</div>
								<div class="eliminarItemCarro c5ItemCarro btnDeleteProductCart" data-id_detalle="'.$_SESSION['carro']->detalle[$i]->id_detalle_carro.'"><div class="ico-trash" data-id="1"></div></div>
							</div>';
					}
				}else{
					echo '<div id="no-productos">No tienes productos en el carrito</div>';
				}
			?>

			<!-- <div class="itemCarro">
				<div class="contenidoItemCarro c1ItemCarro">
					<div class="imagenItemCarro">
						<a href="#" class="linkSinEstilo"><img src="http://image.casadellibro.com/a/l/t1/81/9788408151081.jpg" alt=""></a>
					</div>
					<div class="nombreItemCarro">Nombre del producto</div>
				</div>
				<div class="precioUnitarioItemCarro c2ItemCarro">22.90€</div>
				<div class="cantidadItemCarro c3ItemCarro">
					<div class="ico-minus"  data-id="1"></div>
					<input type="text" value="1">
					<div class="ico-plus"  data-id="1"></div>
				</div>
				<div class="subtotalItemCarro c4ItemCarro">
					<span>22.90€</span>
				</div>
				<div class="eliminarItemCarro c5ItemCarro"><div class="ico-trash" data-id="1"></div></div>
			</div>
			
			<div class="itemCarro">
				<div class="contenidoItemCarro c1ItemCarro">
					<div class="imagenItemCarro">
						<a href="#" class="linkSinEstilo"><img src="http://image.casadellibro.com/a/l/t1/81/9788408151081.jpg" alt=""></a>
					</div>
					<div class="nombreItemCarro">Nombre del producto Nombre del producto Nombre del </div>
				</div>
				<div class="precioUnitarioItemCarro c2ItemCarro">22.90€</div>
				<div class="cantidadItemCarro c3ItemCarro">
					<div class="ico-minus"  data-id="1"></div>
					<input type="text" value="1">
					<div class="ico-plus"  data-id="1"></div>
				</div>
				<div class="subtotalItemCarro c4ItemCarro">
					<span>22.90€</span>
				</div>
				<div class="eliminarItemCarro c5ItemCarro"><div class="ico-trash" data-id="1"></div></div>
			</div> -->

			<?php 
				if (Session::exist('carro')==true){
					echo '<a href="'.APP_W.'buy_process/load" class="btn-pay last"><button class="btn">Ir a pagar</button></a>';
				}
			?>
		</div>
		<div id="dialog-mensaje" title="Info" style="display:none;">
			<p id="mensajeModal"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
		</div>
	</section>
</div>