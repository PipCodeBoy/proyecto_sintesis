<div class="content">
	<?php
		$data = array_values($data);
		echo '<nav>
			<ol class="cd-breadcrumb">
				<li><a href="'.APP_W.'">Home</a></li>
				<li class="current"><em style="color:#EB9532!important;">Tienda</em></li>
			</ol>
		</nav>';
		echo '<div class="paginado">';
			if($_GET['pag']>1){
				echo '<a href="'.APP_W.'store/load?pag='.($_GET['pag']-1).'" id="flecha-atras"></a>';
			}
			echo '<span>';
				 echo $_GET['pag'].'/'.$data[count($data)-1]["maxPaginas"]; 
			echo '</span>';
			if($_GET['pag']<$data[count($data)-1]["maxPaginas"]){
				echo '<a href="'.APP_W.'store/load?pag='.($_GET['pag']+1).'" id="flecha-adelante"></a>';
			}
		echo '</div>';
	?>

	<div id="content-store">
		<?php
			foreach($data as $value){
		      	if(is_array($value) && array_key_exists('id_producto',$value)){
					echo '<div class="product-box">';
						echo '<div class="product-title">'.$value['nombre'].'</div>';
						echo '<img src="'.APP_W.$value['imagen'].'" />';
						echo '<div class="product-footer">';
							echo '<div class="product-price">'.$value['precio'].'€</div>';
							echo '<div class="btn-buy" data-precio_unitario="'.$value['precio'].'" data-id_producto="'.$value['id_producto'].'" data-nombre_producto="'.$value['nombre'].'" data-imagen="'.APP_W.$value['imagen'].'">COMPRAR</div>';
						echo '</div>';
					echo '</div>';
				}
			}
		?>
	</div>

	<div class="paginado">
		<?php
			if($_GET['pag']>1){
				echo '<a href="'.APP_W.'store/load?pag='.($_GET['pag']-1).'" id="flecha-atras"></a>';
			}
			echo '<span>';
				 echo $_GET['pag'].'/'.$data[count($data)-1]["maxPaginas"]; 
			echo '</span>';
			if($_GET['pag']<$data[count($data)-1]["maxPaginas"]){
				echo '<a href="'.APP_W.'store/load?pag='.($_GET['pag']+1).'" id="flecha-adelante"></a>';
			}
		?>
	</div>

	<div id="dialog-mensaje" title="Info" style="display:none;">
		<p id="mensajeModal"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span></p>
	</div>

</div>
