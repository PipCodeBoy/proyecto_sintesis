<div class="content wrapper-instrumentos">

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
		
	<div class="wrapper-titulo-instrumentos">
		<h1>Cómo suenan?</h1>
	</div>
	
	<div class="wrapper-opciones-instrumentos">
		<div><img id="opcion1-instrumentos" src="<?= APP_W."pub/img/juegos/flauta.png" ?>"></span></div>
		<div><img id="opcion2-instrumentos" src="<?= APP_W."pub/img/juegos/guitarra.png" ?>"></span></div>
		<div><img id="opcion3-instrumentos" src="<?= APP_W."pub/img/juegos/maracas.png" ?>"></span></div>
		<div><img id="opcion4-instrumentos" src="<?= APP_W."pub/img/juegos/pandereta.png" ?>"></span></div>
		<div><img id="opcion5-instrumentos" src="<?= APP_W."pub/img/juegos/piano.png" ?>"></span></div>
		<div><img id="opcion6-instrumentos" src="<?= APP_W."pub/img/juegos/tambor.png" ?>"></span></div>
		<div><img id="opcion7-instrumentos" src="<?= APP_W."pub/img/juegos/trompeta.png" ?>"></span></div>
		<div><img id="opcion8-instrumentos" src="<?= APP_W."pub/img/juegos/violin.png" ?>"></span></div>
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