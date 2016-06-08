<div class="content wrapper-suma">
	<?php
    $data = array_values($data);
    echo '<nav style="align-self:flex-start;">
      <ol class="cd-breadcrumb">
        <li><a href="'.APP_W.'">Home</a></li>
        <li><a href="'.APP_W.'categoria/load/id/'.$data[count($data)-1]["id_categoria_juego"].'">'.$data[count($data)-1]["nombre_categoria"].'</a></li>
        <li class="current"><em style="color: rgb('.$data[count($data)-1]['color'].')!important;">'.$data[count($data)-1]["nombre"].'</em></li>
      </ol>
    </nav>';
    ?>

	<div class="wrapper-titulo-suma">
		<h1>Aprende a sumar!</h1>
	</div>
	
	<div class="wrapper-resultados-suma">
		<div id="operador1"></div>
		<div id="operacion"></div>
		<div id="operador2"></div>
		<div>=</div>
		<div id="resultado"></div>
	</div>

	<div class="wrapper-opciones-suma">
		<div><span id="opcion1-suma" class="opcion-suma"></span></div>
		<div><span id="opcion2-suma" class="opcion-suma"></span></div>
		<div><span id="opcion3-suma" class="opcion-suma"></span></div>
		<div><span id="opcion4-suma" class="opcion-suma"></span></div>
	</div>

	<div id="dialog" title="" style="display:none;">
		<div class="cssload-container">
			<div class="cssload-circle-1">
				<div class="cssload-circle-2">
					<div class="cssload-circle-3">
						<div class="cssload-circle-4">
							<div class="cssload-circle-5">
								<div class="cssload-circle-6">
									<div class="cssload-circle-7">
										<div class="cssload-circle-8">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>