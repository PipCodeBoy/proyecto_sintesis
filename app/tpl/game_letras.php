<div class="content wrapper-letras">

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
		
	<div class="wrapper-titulo-letras">
		<h1>Aprende a escribir!</h1>
	</div>
	
	<div class="wrapper-resultados-letras">
		<img src="" alt="" class="imagen-letras">
		<div class="palabra-letras"></div>
	</div>

	<div class="wrapper-opciones-letras">
		<div><span id="opcion1-letra" class="opcion-letras"></span></div>
		<div><span id="opcion2-letra" class="opcion-letras"></span></div>
		<div><span id="opcion3-letra" class="opcion-letras"></span></div>
		<div><span id="opcion4-letra" class="opcion-letras"></span></div>
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