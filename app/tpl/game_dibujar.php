<div class="content">
  <?php
    $data = array_values($data);
    echo '<nav>
      <ol class="cd-breadcrumb">
        <li><a href="'.APP_W.'">Home</a></li>
        <li><a href="'.APP_W.'categoria/load/id/'.$data[count($data)-1]["id_categoria_juego"].'">'.$data[count($data)-1]["nombre_categoria"].'</a></li>
        <li class="current"><em style="color: rgb('.$data[count($data)-1]['color'].')!important;">'.$data[count($data)-1]["nombre"].'</em></li>
      </ol>
    </nav>';
    ?>

  <div class="wrapper-dibujo">
  <canvas width="600px" height="400px" id="canvas">
    <p>test</p>
  </canvas>
  <div class="controls">
    <div>
      <span class="line-slider"><input id="line-size" name="line-size" type="range" min=2 max=14 value=5></span>
    </div>
    <div class="select-color">
      <ul>
        <li class="red selected"></li>
        <li class="green"></li>
        <li class="blue"></li>
      </ul>
    </div>
    <div class="new-color">
      <button class="new-color-btn">Nuevo Color</button>
      <div class="anim-wrap">
        <span class="triangle"></span>
        <div class="add-color">
          <span class="color-preview"></span>
          <div class="rgb-sliders">
            <p>
              <label for="red">Rojo</label>
              <input id="red" name="red" type="range" min=0 max=255 value=0>
            </p>
            <p>
              <label for="green">Verde</label>
              <input id="green" name="green" type="range" min=0 max=255 value=0>
            </p>
            <p>
              <label for="blue">Azul</label>
              <input id="blue" name="blue" type="range" min=0 max=255 value=0>
            </p>
          </div>
          <div>
            <button class="add-color-btn">Añade un color</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <div id="msg-dibujar">Este juego no esta disponible para versión mobil o tablet.</div>

</div>