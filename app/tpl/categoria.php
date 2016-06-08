<div class="content">
	<?php
		$data = array_values($data);

		echo '<nav>
			<ol class="cd-breadcrumb">
				<li><a href="'.APP_W.'">Home</a></li>
				<li class="current"><em style="color: rgb('.$data[count($data)-2]['color'].')!important;">'.$data[count($data)-2]["nombre_categoria"].'</em></li>
			</ol>
		</nav>';
		
		// <li ><a href="'.APP_W.'categoria/load/id/'.$data[count($data)-2]["id_categoria_juego"].'">'.$data[count($data)-2]["nombre_categoria"].'</a></li>
		if($data[count($data)-1]["maxPaginas"]>1){
			echo '<div class="paginado">';
			if($_GET['pag']>1){
				echo '<a href="'.APP_W.'categoria/load/id/'.$data[count($data)-2]["id_categoria_juego"].'?pag='.($_GET['pag']-1).'" id="flecha-atras"></a>';
			}
			echo '<span>';
				 echo $_GET['pag'].'/'.$data[count($data)-1]["maxPaginas"]; 
			echo '</span>';
			if($_GET['pag']<$data[count($data)-1]["maxPaginas"]){
				echo '<a href="'.APP_W.'categoria/load/id/'.$data[count($data)-2]["id_categoria_juego"].'?pag='.($_GET['pag']+1).'" id="flecha-adelante"></a>';
			}
			echo '</div>';
		}
	?>

	<div id="content-home">
		<?php
			foreach($data as $value){
		      if(is_array($value) && array_key_exists('id_juego',$value)){
		      	echo '<div class="game-box" style="background:rgba('.$value['color'].',0.8)" id="'.$value['id_juego'].'">';
				echo '<a href="'.APP_W.'game/load/id/'.$value['id_juego'].'">';
					    echo '<div class="game-box-img">';
					        echo '<div class="games-img-hover" style="background-image:url('.APP_W.$value['imagen'].');"></div>';
					        echo '<input type="hidden" name="'.$value['id_juego'].'" />';
					    echo '</div>';
					    echo '<div class="game-box-title">'.$value['nombre'].'</div>';
					echo '</a>';
				echo '</div>';
				}
			}

		?>
	</div>
	
	<?php
		if($data[count($data)-1]["maxPaginas"]>1){
			echo '<div class="paginado">';
			if($_GET['pag']>1){
				echo '<a href="'.APP_W.'categoria/load/id/'.$data[count($data)-2]["id_categoria_juego"].'?pag='.($_GET['pag']-1).'" id="flecha-atras"></a>';
			}
			echo '<span>';
				 echo $_GET['pag'].'/'.$data[count($data)-1]["maxPaginas"]; 
			echo '</span>';
			if($_GET['pag']<$data[count($data)-1]["maxPaginas"]){
				echo '<a href="'.APP_W.'categoria/load/id/'.$data[count($data)-2]["id_categoria_juego"].'?pag='.($_GET['pag']+1).'" id="flecha-adelante"></a>';
			}
			echo '</div>';
		}
	?>
	
</div>
