/**
* Author: Manuel Solé Gallardo
* Date: 2016
**/

$(document).ready(function(){
	window.appw = $("#appw").val();
	//Inicializar sonidos
	var sonidoError = createsoundbite(window.appw+'pub/sound/error.mp3');
	var sonidoCorrecto = createsoundbite(window.appw+'pub/sound/correcto.mp3');


	//Variable de localizacion
	var loc=String(document.location).split("/");

	/*
	*
	*JUEGO DE MATEMATICAS
	*
	*/
	var numAciertos = 0;
	var resultadoSuma;
	cargarJuegoSuma();

	//$(".contenedor2 .opcion span").draggable({opacity: 0.7, helper: "clone", cursor: "pointer"}); //Otra forma de draggable
	$(".opcion-suma").draggable({
		containment: "window",
		scroll: false,
		revert:true
	});
	
	$("#resultado").droppable({
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		accept: ".opcion-suma",
		drop: function(event, ui){

			if(ui.draggable.text()==resultadoSuma){//Comprobamos si el numero arrastrado es el correcto
		 		//El resultado es el correcto
		 		sonidoCorrecto.playclip();
		 		ui.draggable.hide();//Escondemos el numero arrastrado
          		$("#resultado").droppable( "option", "disabled", true );//Desabilitamos la secccion del ?
		 		$(".opcion-suma").draggable("disable"); //Desabilitamos el resto de opciones, ahora no se pueden mover
		 		$("#resultado").css('color', '#2BDE20');
		 		$("#resultado").html("✓");

		 		numAciertos++;//Sumamos un acierto al contador
		 		if(numAciertos==2){//Comprobamos si hemos llegado al numero de aciertos maximo para ganar
		 			$("#dialog").dialog({
						open: function(event, ui) { 
							$(".ui-dialog-titlebar-close").hide();
							$(".ui-dialog-titlebar").hide();
							$(".ui-dialog").removeClass('ui-dialog');
					},
						modal: true
					});

		 			if (!(typeof Cookies.get('userid') === "undefined")) {
			 			//Tenemos que comprobar si ya se habia pasado el juego antes
			 			if (ComprobarJuegoPasado(Cookies.get('userid'),loc[loc.length-1])==false){//loc[loc.length-1] contiene el id del juego actual
			 				RegistrarJuegoPasado(Cookies.get('userid'),loc[loc.length-1]);//Guardamos que se ha pasado el juego
			 			}
			 		}
			 		
			 		setTimeout(
		 				function(){
							$("#dialog").dialog("close");
							//El usuario se ha pasado el juego, mostramos un mensaje para que lo vea
							$("nav").addClass("nav-post-juego");
				 			$(".wrapper-titulo-suma h1").html("TE HAS PASADO EL JUEGO!");
				 			$(".wrapper-titulo-suma h1").addClass('titulo-fin-juego');
							$(".wrapper-resultados-suma").html('<a href="'+window.appw+'game/load/id/'+loc[loc.length-1]+'" class="btn-volver-jugar">Volver a jugar</a>');
			 				$(".wrapper-opciones-suma").remove();
						}, 1000);
		 		}else{
					$("#dialog").dialog({
						open: function(event, ui) { 
							$(".ui-dialog-titlebar-close").hide();
							$(".ui-dialog-titlebar").hide();
							$(".ui-dialog").removeClass('ui-dialog');
					},
						modal: true
					});
		 			setTimeout(
		 				function(){
		 					$("#resultado").removeAttr('style');
		 					$("#resultado").text("?");
		 					var mensajeTituloSuma = "LLEVAS "+numAciertos+" ACIERTO"
		 					if(numAciertos>1){
								mensajeTituloSuma+="S";
		 					}
		 					/*mensajeTituloSuma+=", SIGUE ASÍ";*/
							$(".wrapper-titulo-suma h1").html(mensajeTituloSuma);
							$("#dialog").dialog("close");
							cargarJuegoSuma();
		 					ui.draggable.show();
          					$("#resultado").droppable( "option", "disabled", false );
		 					$(".opcion-suma").draggable("enable");
		 				}, 1500);
		 		}
		 	}else{
		 		sonidoError.playclip();
		 		$("#resultado").css('color', '#DE1111');
		 		$("#resultado").html("❌");//Coloco el simbolo de la X que en "Decimal Escape" es &#10060;
		 		setTimeout(
		 			function(){
		 				$("#resultado").removeAttr('style');
		 				$("#resultado").text("?");
		 			}, 1000);
		 	}
	        
		}
	});	

	function cargarJuegoSuma(){
		resultadoSuma = Math.floor((Math.random() * 10) + 1);
		var operador1 = Math.floor((Math.random() * resultadoSuma));
		var operador2 = resultadoSuma - operador1;
	    var numRandom = [resultadoSuma]; //Guardo los operadores en un array
		//Genero el resto de operadores de forma aleatoria hasta 4 posibilidades
		do {
			randomTemp = Math.floor((Math.random() * 10) + 1);
			//Recorro el array para comprobar que el numero generado aleatoriamente no existe ya
			encontrado=false;
			x=0;
			while(x<numRandom.length && encontrado==false){
				if(numRandom[x]==randomTemp){
					encontrado=true;
				}
				x++;
			}
			//Si no encuentro el numero en el array, lo añado
			if(!encontrado){
				numRandom.push(randomTemp);
			}
		}while(numRandom.length<=3);

	    //Ahora que tengo todos los posibles operadores, los desordeno
	    numRandom.sort(function() { return 0.5 - Math.random() });
	    //Mostramos los datos en sus respectivas casillas
		$("#operador1").text(operador1);
		$("#operacion").text("+");
		$("#operador2").text(operador2);
	    $("#resultado").text("?");
	    for(x=0;x<4;x++){
			$("#opcion"+(x+1)+'-suma').text(numRandom[x]);
	    }
	}

	/*
	*
	*JUEGO DE LAS PALABRAS
	*
	*/

	//var alberto = "/TicTac/";

	// lo que habia antes window.appw

	var imagenes = [window.appw+'pub/img/juegos/arbol.png',
				window.appw+'pub/img/juegos/libros.png',
				window.appw+'pub/img/juegos/pelota.png',
				window.appw+'pub/img/juegos/reloj.png',
				window.appw+'pub/img/juegos/tictac.png'];	
	var palabras = ['ARBOL','LIBROS','PELOTA','RELOJ','TICTAC'];//Como regla impuesta por el cliente, las palabras deben tener como mínimo dos vocales
    var indicePalabra = null;
	var vocales = ['A','E','I','O','U'];
	var abecedario = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","U","V","W","X","Y","Z"];
	var aciertosLetras = null;
	var aciertosPalabras = 0;

	cargarJuegoLetras();
	
	$(".opcion-letras").draggable({
		containment: "window",
		scroll: false,
		revert:true
	});

	function volverFormatoLetraCorrecta(x,letra){
		setTimeout(function(){
		x.html(letra);
		},1000);
	}

	function volverFormatoLetraErronea(x){
		setTimeout(function(){
		x.removeAttr('style');
		x.html("_");},1000);
	}

	function cargarJuegoLetras(){
		var letrasResultado = [];
		aciertosLetras = 0;
		indicePalabra = Math.floor((Math.random() * palabras.length));//Elegimos una palabra al azar;
		var palabraElegida = palabras[indicePalabra];
		//Elegimos dos vocales de forma aleatoria para que sean resultas en el juego sobre la palabra elegida anteriormente
		do {
			var vocalAleatoria = vocales[Math.floor((Math.random() * vocales.length))]; //obtenemos una vocal de forma aleatoria
			var posPalabraElegida = palabraElegida.indexOf(vocalAleatoria); //buscamos la vocal dentro de la palabra
			if(posPalabraElegida>-1){
				letrasResultado.push(vocalAleatoria); //si encuentro la vocal, la añado como opcion de respuesta
				//Substituimos la vocal por el caracter "_" dentro de la palabra
				palabraElegida = palabraElegida.substring(0,posPalabraElegida)+'_'+palabraElegida.substring(posPalabraElegida+1,palabraElegida.length); 
			}
		} while(letrasResultado.length<2);
	    
		//Genero el resto de resultados de forma aleatoria hasta 4 posibilidades
		do {
			var letraRandom = abecedario[Math.floor((Math.random() * abecedario.length))];
			var encontrado = false;
			var x = 0;
			while(x<letrasResultado.length && encontrado==false){ //Recorro el array para comprobar que el numero generado aleatoriamente no existe ya
				if(letrasResultado[x]==letraRandom){encontrado=true;}//Salgo del bucle
				x++;
			}
			if(!encontrado){letrasResultado.push(letraRandom);}//Si no estaba en el array la añado
		}while(letrasResultado.length<4);

	    letrasResultado.sort(function() { return 0.5 - Math.random() }); //Ahora que tengo todos los posibles resultados, los desordeno

	    //Mostramos los datos en sus respectivas casillas
		$(".imagen-letras").attr('src',imagenes[indicePalabra]);

		$(".palabra-letras").html("");
		//PALABRA
		for(x=0;x<palabraElegida.length;x++){
			var cadenaTemp='<div class="letraPalabra-letras';
			if(palabraElegida.charAt(x)=="_"){cadenaTemp+=' palabraDrop-letras';}
				cadenaTemp+='" id="'+x+'">'+palabraElegida.charAt(x)+'</div>';
			$(".palabra-letras").append(cadenaTemp);
	    }

	    //Añadimos la funcion dropable aqui para que siempre este lista para usarse
	    $(".palabraDrop-letras").droppable({
			activeClass: "ui-state-default",
			hoverClass: "ui-state-hover",
			accept: ".opcion-letras",
			drop: function(event, ui){
				if(ui.draggable.text()==palabras[indicePalabra].charAt($(this).attr("id"))){
					//El resultado es el correcto
			 		aciertosLetras++;
			 		sonidoCorrecto.playclip();
	          		$(this).removeClass('palabraDrop-letras');
			 		$(this).css('color', '#2BDE20');
			 		$(this).html("✓");
			 		volverFormatoLetraCorrecta($(this), ui.draggable.text());
			 		ui.draggable.html("");
			 	}else{
			 		sonidoError.playclip();
			 		$(this).css('color', '#DE1111');
			 		$(this).html("❌");//Coloco el simbolo de la X que en "Decimal Escape" es &#10060;
			 		volverFormatoLetraErronea($(this));
			 	}
		        
		        if (aciertosLetras==2){
		        	aciertosPalabras++;
	    			//$(".palabraDrop-letras").droppable( "option", "disabled", false );
		        	if (aciertosPalabras==5){
						$("#dialog").dialog({
							open: function(event, ui) { 
							$(".ui-dialog-titlebar-close").hide();
							$(".ui-dialog-titlebar").hide();
							$(".ui-dialog").removeClass('ui-dialog');
					},
							modal: true
						});

			 			if (!(typeof Cookies.get('userid') === "undefined")) {
				 			//Tenemos que comprobar si ya se habia pasado el juego antes
				 			if (ComprobarJuegoPasado(Cookies.get('userid'),loc[loc.length-1])==false){//loc[loc.length-1] contiene el id del juego actual
				 				RegistrarJuegoPasado(Cookies.get('userid'),loc[loc.length-1]);//Guardamos que se ha pasado el juego
				 			}
				 		}
				 		
				 		setTimeout(
			 				function(){
								$("#dialog").dialog("close");
								//El usuario se ha pasado el juego, mostramos un mensaje para que lo vea
								$("nav").addClass("nav-post-juego");
					 			$(".wrapper-titulo-letras h1").html("TE HAS PASADO EL JUEGO!");
								$(".wrapper-titulo-suma h1").addClass('titulo-fin-juego');
								$(".wrapper-resultados-letras").html('<a href="'+window.appw+'game/load/id/'+loc[loc.length-1]+'" class="btn-volver-jugar">Volver a jugar</a>');
				 				$(".wrapper-opciones-letras").remove();
							}, 1000);
		        	}else{
		        		numAciertos++;
		        		palabras.splice(indicePalabra,1);//Eliminamos la palabra que ya han completado
		        		imagenes.splice(indicePalabra,1);
		        		$("#dialog").dialog({
							open: function(event, ui) { 
							$(".ui-dialog-titlebar-close").hide();
							$(".ui-dialog-titlebar").hide();
							$(".ui-dialog").removeClass('ui-dialog');
					},
							modal: true
						});
			 			setTimeout(
			 				function(){
			 					var mensajeTituloSuma = "LLEVAS "+numAciertos+" ACIERTO"
			 					if(numAciertos>1){
									mensajeTituloSuma+="S";
			 					}
			 					/*mensajeTituloSuma+=", SIGUE ASÍ";*/
								$(".wrapper-titulo-letras h1").html(mensajeTituloSuma);
								$("#dialog").dialog("close");
								cargarJuegoLetras();
			 					ui.draggable.show();
	          					$("#resultado").droppable( "option", "disabled", false );
			 					$(".opcion-letra").draggable("enable");
			 				}, 1500);
		        	}
		        }
			}
		});

	    //OPCIONES
	    for(x=0;x<4;x++){
			$("#opcion"+(x+1)+"-letra").text(letrasResultado[x]);
	    }
	}


	/*
	*
	*JUEGO DE LA MEMORIA
	*
	*/

	var arrimg_memoria = [];
	var imagen1_memoria;
	var imagen2_memoria;
	var clic2 = false;
	var imagenes_memoria = [window.appw+'pub/img/juegos/abaco.jpg',
							window.appw+'pub/img/juegos/arcoiris.jpg',
							window.appw+'pub/img/juegos/cereza.jpg',
							window.appw+'pub/img/juegos/cometa.jpg',
							window.appw+'pub/img/juegos/leon.jpg',
							window.appw+'pub/img/juegos/mariquita.jpg',
							window.appw+'pub/img/juegos/pecera.jpg',
							window.appw+'pub/img/juegos/perro.jpg'];
		
	arrimg_memoria = arrimg_memoria.concat(imagenes_memoria); 
	arrimg_memoria = arrimg_memoria.concat(imagenes_memoria);

	arrimg_memoria.sort(function() { return 0.5 - Math.random() }); 

	$(".celda-memoria").on("click", comprobar);

	function comprobar(){
		if($(this).index()!=imagen1_memoria){//Compruebo que no hayan hecho clic sobre la primera imagen elegida
			$(".celda-memoria").off();//Bloqueo los botones
			$(this).css({//Cambio la imagen del interrogante por la de la posicion del array y rotamos la imagen para dar dinamismo
				'background-image': 'url('+arrimg_memoria[$(this).index()]+')',
				'transform': 'rotateY(180deg)'
			});
			if(clic2){//Compruebo si es la segunda imagen que eligen
				//Es la segunda imagen que eligen, debemos comprobar si concuerda la imagen con la primera
				if(arrimg_memoria[$(this).index()]==arrimg_memoria[imagen1_memoria]){
					sonidoCorrecto.playclip();
					//Las imagenes de la primera y la segunda coinciden
					numAciertos+=1;
					//Cambio  las clases de los div para evitar que puedan hacer clic de nuevo
					$("div.celda-memoria:nth-child("+(imagen1_memoria+1)+")").removeClass("celda-memoria").addClass("celdaCompleta-memoria");
					$(this).removeClass("celda-memoria").addClass("celdaCompleta-memoria");
					//Reseteo variables para comenzar el ciclo de nuevo
					imagen1_memoria = null;
					clic2=false;
					//Vuelvo a activar los botones
					$(".celda-memoria").on("click", comprobar);
				}else{
					sonidoError.playclip();
					//Las imagenen de la primera no coincide con el de la segunda
					imagen2_memoria = $(this).index();//Guardo el indice del div que han hecho clic para usarlo posteriormente entro del setTimeOut, ya que cuando salta la funcion del setTimeOut el $(this) no tiene ningun valor
					window.setTimeout( function(){
						//Quito las imagenes y vuelvo a poner el interrogante
			      		$("div.celda-memoria:nth-child("+(imagen1_memoria+1)+")").removeAttr("style");
						$("div.celda-memoria:nth-child("+(imagen2_memoria+1)+")").removeAttr("style");
						//Reseteo variables para comenzar el ciclo de nuevo
						imagen1_memoria = null;
						clic2=false;
						//Vuelvo a activar los botones	
						$(".celda-memoria").on("click", comprobar);
				    }, 1000 );
				}
			}else{
				//Es la primera imagen que seleccionan
				imagen1_memoria = $(this).index();//Guardo el indice del div clicado
				clic2=true;
				$(".celda-memoria").on("click", comprobar);//Vuelvo a activar los botones
			}
		}
		
		if(numAciertos==8){//Si el numero de aciertos es el maximo finalizo el juego
			$("#dialog").dialog({
				open: function(event, ui) { 
							$(".ui-dialog-titlebar-close").hide();
							$(".ui-dialog-titlebar").hide();
							$(".ui-dialog").removeClass('ui-dialog');
					},
				modal: true
			});

 			if (!(typeof Cookies.get('userid') === "undefined")) {
	 			//Tenemos que comprobar si ya se habia pasado el juego antes
	 			if (ComprobarJuegoPasado(Cookies.get('userid'),loc[loc.length-1])==false){//loc[loc.length-1] contiene el id del juego actual
	 				RegistrarJuegoPasado(Cookies.get('userid'),loc[loc.length-1]);//Guardamos que se ha pasado el juego
	 			}
	 		}
	 		
	 		setTimeout(
 				function(){
					$("#dialog").dialog("close");
					//El usuario se ha pasado el juego, mostramos un mensaje para que lo vea
					$("nav").addClass("nav-post-juego");
		 			$(".wrapper-titulo-memoria h1").html("TE HAS PASADO EL JUEGO!");
					$(".wrapper-titulo-suma h1").addClass('titulo-fin-juego');
					$(".wrapper-tabla-memoria").html('<a href="'+window.appw+'game/load/id/'+loc[loc.length-1]+'" class="btn-volver-jugar">Volver a jugar</a>');
				}, 1000);
		}

	}


	/*
	*
	*JUEGO DE LOS INSTRUMENTOS
	*
	*/

	//Inicializar sonidos
	var sonidoInstrumentoFlauta = createsoundbite(window.appw+'pub/sound/flauta.mp3');
	var sonidoInstrumentoGuitarra = createsoundbite(window.appw+'pub/sound/guitarra.mp3');
	var sonidoInstrumentoMaraca = createsoundbite(window.appw+'pub/sound/maraca.mp3');
	var sonidoInstrumentoPandereta = createsoundbite(window.appw+'pub/sound/pandereta.mp3');
	var sonidoInstrumentoPiano = createsoundbite(window.appw+'pub/sound/piano.mp3');
	var sonidoInstrumentoTambor = createsoundbite(window.appw+'pub/sound/tambor.mp3');
	var sonidoInstrumentoTrompeta = createsoundbite(window.appw+'pub/sound/trompeta.mp3');
	var sonidoInstrumentoViolin = createsoundbite(window.appw+'pub/sound/violin.mp3');
	
	$("#opcion1-instrumentos").on("click",function(){
		sonidoInstrumentoFlauta.playclip();
	});
	$("#opcion2-instrumentos").on("click",function(){
		sonidoInstrumentoGuitarra.playclip();
	});
	$("#opcion3-instrumentos").on("click",function(){
		sonidoInstrumentoMaraca.playclip();
	});
	$("#opcion4-instrumentos").on("click",function(){
		sonidoInstrumentoPandereta.playclip();
	});
	$("#opcion5-instrumentos").on("click",function(){
		sonidoInstrumentoPiano.playclip();
	});
	$("#opcion6-instrumentos").on("click",function(){
		sonidoInstrumentoTambor.playclip();
	});
	$("#opcion7-instrumentos").on("click",function(){
		sonidoInstrumentoTrompeta.playclip();
	});
	$("#opcion8-instrumentos").on("click",function(){
		sonidoInstrumentoViolin.playclip();
	});



	/*
	*
	*JUEGO DEL DIBUJO
	*
	*/
	if(loc[loc.length-4]==="game" && loc[loc.length-3]==="load" && loc[loc.length-2]==="id" && loc[loc.length-1]==="5"){
		var $colorPalette = $(".select-color ul");
		var $canvas = $("#canvas");
		var ctx = $canvas[0].getContext("2d");
		var mouseDown = false;
		var canvasClicked = false;

		// Adds selected class to chosen color
		$colorPalette.on("click", "li", function() {
		  selectColor($(this));
		});

		// Removes class from siblings, adds class to chosen
		function selectColor(e) {
		  e.siblings().removeClass("selected");
		  e.addClass("selected");
		}

		// Toggles and animates hidden panel
		$(".new-color-btn").click("click", function() {
		  togglePanel();
		});

		// Allows animation to toggle
		function togglePanel() {
		  renewElement($(".anim-wrap"));
		  var $animated = $(".anim-wrap");
		  var shown = $animated.hasClass('on');
		  $animated.toggleClass('on', !shown).toggleClass('off', shown);
		}

		// Allows animation to play more than once
		function renewElement(e) {
		  var newElement = e.clone(true);
		  e.remove();
		  $(".new-color").append(newElement);
		}

		// Changes the color preview to the user defined color
		$(".rgb-sliders input").change(function() {
		  $(".color-preview").css("background", currentColor());
		})

		// Returns the RGB from the defined slider values
		function currentColor() {
		  var r = $("#red").val();
		  var g = $("#green").val();
		  var b = $("#blue").val();
		  var color = "rgb(" + r + "," + g + "," + b + ")";

		  return color;
		}

		// Appends new color onto color selection menu
		$(".add-color-btn").on("click", function() {
		  var $newColor = $("<li></li>").hide();
		  $newColor.css("background", currentColor());
		  $colorPalette.append($newColor);
		  selectColor($newColor);
		  $newColor.animate({ width: 'toggle' }, 200);
		  togglePanel();
		});

		// Allows user to draw onto canvas
		$canvas.mousedown(function(e) {
		  lastEvent = e;
		  mouseDown = true;
		  removeLogo();
		}).mousemove(function(e) {
		  if (mouseDown) {
		    ctx.beginPath();
		    ctx.moveTo(lastEvent.offsetX, lastEvent.offsetY);
		    ctx.lineTo(e.offsetX, e.offsetY);
		    ctx.strokeStyle = $(".selected").css("background-color");
		    ctx.lineWidth = $("#line-size").val();
		    ctx.lineJoin = ctx.lineCap = 'round';
		    ctx.stroke();
		    lastEvent = e;
		  }
		}).mouseup(function() {
		  mouseDown = false;
		}).mouseleave(function() {
		  $canvas.mouseup();
		});

		// Removes the logo background when user starts to draw
		function removeLogo() {
		  if (!canvasClicked) {
		    var bg = $("canvas").css("background-image");
		    var bgs = bg.split(',');
		    bgs.splice(0, 1);
		    $("canvas").css("background-image", bgs.concat());
		    $("canvas").css("background-repeat", "repeat");
		    canvasClicked = true;
		  }
		}
	}

	/*
	* BUSCADOR
	*/

	$('#search-bar').autocomplete({
		source: function(request, response){
			$.ajax({
				url:window.appw+"buscador/autoCompletar",
				dataType: "json",
				data:{q:request.term},
				success: function(data){

					response(data);

				},
				error: function(data){
					console.log(data);
				}
			});
		},
		minLength:1,
		select: function(event, ui){
			event.preventDefault();
 			$(location).attr("href",window.appw+"game/load/id/"+ui.item.value);
		}
   	});


	/*
	*
	*Funciones Carro
	*
	*/

	$(".btn-buy").on("click",function(){		
		$.ajax({
			url:window.appw+"store/addProductShoppingCart",
			type:"POST",
			data:{'id_producto':$(this).attr("data-id_producto"),
			'precio_unitario':$(this).attr("data-precio_unitario"),
			'nombre_producto':$(this).attr("data-nombre_producto"),
			'imagen':$(this).attr("data-imagen")},
			dataType: "json",
			success: function(data){
				if(data=="OK"){
					dialogoMensaje("Producto añadido correctamente");
					$.ajax({
						url:window.appw+'store/contarProductosCarro',
						dataType:'json',
						success: function(data){
							if(data!="KO"){
								$("#numProdCarro").html(data);
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				}else if(data=="NO_STOCK"){
					dialogoMensaje("No disponemos de suficiente stock para añadir más cantidad de ese producto al carro");
				}else{
					dialogoMensaje("Error al añadir el producto. Vuelva a intentarlo");
				}
				/*setTimeout(function(){
					 $("#dialog-mensaje").dialog( "close" );
				},10000);*/
			},
			error: function(data){
				console.log(data);
			}
		});
	});


	/*
	*
	*Mostrar mensaje en la pantalla
	*
	*/
	function dialogoMensaje(mensaje) {
	  $("#mensajeModal").text(mensaje);
	  $("#dialog-mensaje").dialog({
	      open: function(event, ui) { $(".ui-dialog-titlebar-close").hide();},
	    draggable: false,
	    resizable: false,
	    width:300,
	    height:150,
	    modal: true,
	    buttons: {
	      "Aceptar": function() {
	        $( this ).dialog( "close" );
	      }
	    }
	  });
	}

	/*
	*
	* FUNCIONES EL CARRITO
	*
	*/
	$(".btnPlusProductCart").on("click",function(){		
		$.ajax({
			url:window.appw+"cart/upgradeQuantityProduct",
			type:"POST",
			data:{'id_detalle':$(this).attr("data-id_detalle"),
			'id_producto':$(this).attr("data-id_producto")},
			dataType: "json",
			success: function(data){

				if(data[0]=="OK"){
					var cantidad=eval(eval($("#cantidad"+data[1]).val())+eval(1));
					var precio=eval($("#precio"+data[1]).text().substring(0,$("#precio"+data[1]).text().length-1));
					$("#cantidad"+data[1]).val(cantidad);
					$("#subtotal"+data[1]).html(eval( cantidad * precio)+"€");
					//dialogoMensaje("Producto añadido correctamente");
				}else if(data[0]=="NO_STOCK"){
					dialogoMensaje("No disponemos de suficiente stock para añadir más cantidad de ese producto al carro");
				}else{
					dialogoMensaje("Error al añadir el producto. Vuelva a intentarlo");
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	});

	$(".btnMinusProductCart").on("click",function(){	
		$.ajax({
			url:window.appw+"cart/downgradeQuantityProduct",
			type:"POST",
			data:{'id_detalle':$(this).attr("data-id_detalle"),
			'id_producto':$(this).attr("data-id_producto")},
			dataType: "json",
			success: function(data){

				if(data[0]=="OK"){
					var cantidad=eval(eval($("#cantidad"+data[1]).val())-eval(1));
					var precio=eval($("#precio"+data[1]).text().substring(0,$("#precio"+data[1]).text().length-1));
					$("#cantidad"+data[1]).val(cantidad);
					$("#subtotal"+data[1]).html(eval( cantidad * precio)+"€");
					//dialogoMensaje("Producto añadido correctamente");
				}else if(data[0]=="CANTIDAD_MINIMA"){
					dialogoMensaje("La cantidad mínima para cualquier producto es 1, si desea eliminar el producto debe hacer clic en el icono de la papelera");
				}else{
					dialogoMensaje("Error al quitar el producto. Vuelva a intentarlo");
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	});
    
	$(".btnDeleteProductCart").on("click",function(){	
		$.ajax({
			url:window.appw+"cart/deleteProduct",
			type:"POST",
			data:{'id_detalle':$(this).attr("data-id_detalle")},
			dataType: "json",
			success: function(data){
				if(data[0]=="OK"){
					$("#ItemCart"+data[1]).remove();
					if($(".itemCarro").length==0){
						//elimino todo lo relacionado con el carro
						$.ajax({
							url:window.appw+'cart/removeCart',
							dataType:'json',
							success: function(data){
								if(data=="OK"){
									$(location).attr('href',window.appw+"cart/home");
								}else{
									dialogoMensaje("Error al eliminar el carro. Vuelva a intentarlo");
								}
							},
							error: function(data){
								console.log(data);
							}
						});
					}
				}else{
					dialogoMensaje("Error al eliminar el producto. Vuelva a intentarlo");
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	});


	$.cookiesDirective({
    	privacyPolicyUri: window.appw+'my-privacy-policy.html',
    	position: 'bottom'
    });



});


/*
*
*Crear audio para reproducir
*
*/
var html5_audiotypes={ 
	"mp3": "audio/mpeg",
	"mp4": "audio/mp4",
	"ogg": "audio/ogg",
	"wav": "audio/wav"
}

function createsoundbite(sound){
	var html5audio=document.createElement('audio')
	
	if (html5audio.canPlayType){ //Comprobar soporte para audio HTML5
	
		for (var i=0; i<arguments.length; i++){

			var sourceel=document.createElement('source');
			
			sourceel.setAttribute('src', arguments[i]);
			
			if (arguments[i].match(/.(w+)$/i))
				sourceel.setAttribute('type', html5_audiotypes[RegExp.$1]);
				html5audio.appendChild(sourceel);
			}
			
			html5audio.load();
			html5audio.playclip=function(){
				/*html5audio.pause()*/
				html5audio.currentTime=0
				html5audio.play()
			}

		return html5audio

	}else{
		return {playclip:function(){throw new Error('Su navegador no soporta audio HTML5')}}
	}
}

/*
*
* Funcion ajax para comprobar si ya tiene este juego pasado
*
*/

function ComprobarJuegoPasado(usuario, juego){
 	var respuesta = ($.ajax({
		url:window.appw+'game/comprobarJuegoPasado',
		type:"POST",
		data:{'usuario': usuario, 'juego': juego},
		dataType:'json',
 		async: false,
		success: function(output){},
		error: function(output){
			console.log(output);
		}
  	}));

  	if(respuesta["responseText"]=="[\"OK\"]"){
  		return true;
  	}else{
  		return false;
  	}
};

function RegistrarJuegoPasado(usuario, juego){
  	return ($.ajax({  		
		url:window.appw+'game/registrarJuegoPasado',
		type:"POST",
		data:{'usuario': usuario, 'juego': juego},
		dataType:'json',
		success: function(output){
		},
		error: function(output){
			console.log(output);
		}
  	}));
};

/*
*
*Cargar juegos por categoria mediante ajax
*
*/
/*function gamesCategoria(idCategoria){
	$.ajax({
		url:window.appw+'home/gamesCategoria',
		type:"POST",
		data:{'idCategoria': idCategoria, 'pagina': paginaActual},
		dataType:'json',
		success: function(output){
			loadgames(output);
		},
		error: function(output){
			console.log(output);
		}
  	});
}*/

