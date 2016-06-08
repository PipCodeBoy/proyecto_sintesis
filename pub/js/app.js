$(document).ready(function(){

   window.appw = $("#appw").val(); //Variable global con la appw


/* -------------------------------------------------------- APP 2 -------------------------------------------------------- */

//login
    function fill_up(){
    $("#content").html("<img src='img/loading.gif' width='200' />");
    $.ajax({
            type: 'POST',
            url: 'profile/getallusers',
            dataType: 'json',
            success: function(resp){
                $("#content").html("<table><tbody></tbody></table>");
                $("tbody").append("<tr><td>EMAIL</td><td>NOMBRE</td><td>TELEFONO</td><td>ROL</td><td colspan='2' id='btn-new-user'>Nuevo usuario</td></tr>");
                for(i=0;i<resp.length;i++){
                    $("tbody").append("<tr id='"+resp[i].id_usuario+"'>");
                        $("tr:last").append("<td>"+resp[i].email+"</td>");
                        $("tr:last").append("<td>"+resp[i].nombre+"</td>");
                        $("tr:last").append("<td>"+resp[i].telefono_contacto+"</td>");
                        switch(resp[i].rol){
                            case '1': rol="Admin";
                                    break;
                            case '2': rol="User";
                                    break;
                            case '3': rol="Moderator";
                                    break;
                            default:rol="Undefined";
                                    break;
                        }
                        $("tr:last").append("<td>"+rol+"</td>");
                        $("tr:last").append("<td class='btn-edit'>Editar</td>");
                        $("tr:last").append("<td class='btn-delete'>Borrar</td>");
                    $("tbody").append("</tr>");
                }
            }
        });
    }fill_up();

    $("#content").on("click", ".btn-delete", function(){    
        id_user = $(this).closest("tr").attr("id");
        user = $("#"+id_user+" td:first").text();
        if(confirm("Are you sure you want to delete the user '"+user+"'?")){
            $("#edit-form").slideUp(200);
            $("#new-user-form").slideUp(200);
            $("#msg").html("<img src='img/loading.gif' width='100' />");
            $.ajax({
                type: 'POST',
                url: 'profile/deleteadmin',
                data: {'id_user' : id_user, 'user':user},
                dataType: 'json',
                success: function(resp){
                    setTimeout(function(){
                        if(resp.response == "deleted"){
                            fill_up();
                            $("#msg").html("EL usuario a sido borrado");                   
                        }else if(resp.response == "user_not_exists"){
                            $("#msg").html("El usuario no existe.");
                        }else if(resp.response == "cannot_delete"){
                            $("#msg").html("El usuario no puedo ser borrado.");
                        }else if(resp.response == "param_error"){
                            $("#msg").html("Error de parametros.");
                        }
                        $("#msg").slideDown(200);
                    },500);
                    var clear = setInterval(function(){
                        $("#msg").slideUp(200);
                    }, 5000);
                },
                error:function(resp){
                    alert(resp);
                }
            });
        }   
    });

    $("#content").on("click", ".btn-edit", function(){
        id_user = $(this).closest("tr").attr("id");
        $("btn-action-edit").attr("name",id_user);
        $("#new-user-form").slideUp(200);
        $("#edit-form").slideUp(100);

        $.ajax({ // RELLENA LOS CAMPOS DEL EDIT
            type: 'POST',
            url: 'profile/getallusers',
            dataType: 'json',
            success: function(resp){
                for(i=0;i<resp.length;i++){
                    if(resp[i].id_usuario == id_user){
                        $("#ed-email").val(resp[i].email);
                        $("#ed-email").attr("placeholder", resp[i].email);
                        $("#ed-name").val(resp[i].nombre);
                        $("#ed-name").attr("placeholder", resp[i].nombre);
                        $("#ed-nick").val(resp[i].apodo);
                        $("#ed-nick").attr("placeholder", resp[i].apodo);
                        $("#ed-phone").val(resp[i].telefono_contacto);
                        $("#ed-phone").attr("placeholder", resp[i].telefono_contacto);
                    }
                }
            }
        });

        $("#edit-form").slideDown(300);
    }); 

    $("#btn-action-edit").on("click", function(){
        $("#msg").stop(true, true).slideUp();
        $("#msg").html("<img src='img/loading.gif' width='100' />");
        email = $("#ed-email").val();
        name = $("#ed-name").val();
        nick = $("#ed-nick").val();
        phone = $("#ed-phone").val();
        rol = $("#ed-rol option:selected").val();

        $.ajax({ // RELLENA LOS CAMPOS DEL EDIT
            type: 'POST',
            url: 'profile/editadmin',
            dataType: 'json',
            data: {'id_user' : id_user, 'email' : email, 'name' : name,'nick':nick, 'phone' : phone, 'rol' : rol},
            success: function(resp){    
                setTimeout(function(){
                    if(resp.response == "updated"){
                        fill_up();                  
                        $("#msg").html("The user has been updated.");                   
                    }else if(resp.response == "user_not_exists"){
                        $("#msg").html("The user does not exist.");
                    }else if(resp.response == "cannot_update"){
                        $("#msg").html("No change detected. No change was made.");
                    }else if(resp.response == "missing_params"){
                        $("#msg").html("Fill all required fields (*)");
                    }
                    $("#msg").slideDown(200);
                },500);         
                var clearMsg = setInterval(function(){
                    $("#msg").slideUp(200);
                }, 5000);
            },
            error:function(ms){
                alert(ms);
            }
        });
    }); 

    /* ---------------------------- SHOW NEW USER FORM ---------------------------- */
    $("#content").on("click", "#btn-new-user", function(){
        $("#new-user-form input:text").val("");
        $("#edit-form").slideUp(200);
        $("#new-user-form").slideUp(100);
        $("#new-user-form").slideDown(300);
    }); 

    $("#btn-action-create").on("click", function(){
        $("#msg").stop(true, true).slideUp();
        $("#msg").html("<img src='img/loading.gif' width='100' />");
        email = $("#nu-email").val();
        password = $("#nu-password").val();
        nick = $("#nu-nick").val();
        rep_pass = $("#nu-rep-pass").val();
        name = $("#nu-name").val();
        phone = $("#nu-phone").val();
        sex = $("#nu-sex").val();
        date = $("#nu-date").val();
        ape = $("#nu-ape").val();
        rol = $("#nu-rol option:selected").val();

        if(password == rep_pass){
            $.ajax({ // RELLENA LOS CAMPOS DEL EDIT
                type: 'POST',
                url: 'profile/newuseradmin',
                dataType: 'json',
                data: {'email' : email, 'password': password, 'name' : name,'nick':nick, 'phone' : phone, 'rol' : rol,'sex':sex,'date':date,'ape':ape},
                success: function(resp){    
                    setTimeout(function(){
                        if(resp.response == "created"){
                            fill_up();
                            $("#msg").html("The user has been created.");                       
                        }else if(resp.response == "user_exists"){
                            $("#msg").html("The user already exists.");
                        }else if(resp.response == "cannot_create"){
                            $("#msg").html("The user can not be created.");
                        }else if(resp.response == "missing_params"){
                            $("#msg").html("Fill all required fields. (*)");
                        }
                        $("#msg").slideDown(200);                   
                    },500);             
                },
                error:function(ms){
                    alert(ms);
                }
            });
        }else{
            setTimeout(function(){
                $("#msg").html("Passwords do not match.");
                $("#msg").slideDown(200);           
            },500);
        }
        var clear = setInterval(function(){
            $("#msg").slideUp(200);
        }, 5000);   
    }); 

    //Solo cargo los juegos cuando es la pagina "Inicio"
    var loc=String(document.location).split("/");
    if(loc[loc.length-1]===""){
        $.ajax({
            type: 'POST',
            url: 'home/games',
            datatype:'json',
            success:function(msg){loadgames(msg);},
            error:function(msg){alert(msg);},
        });
    }

    function loadgames(dades){
        json = $.parseJSON(dades);
        var cont = json.length;
        for (var i=0; i<cont; i++) {
            str = "";
            str+='<div class="game-box" style="background:rgba('+json[i].color+',0.8)" id="'+json[i].id_juego+'">';
                str+='<a href="game/load/id/'+json[i].id_juego+'">';
                    str+='<div class="game-box-img">';
                        str+='<div class="games-img-hover" style="background-image:url('+json[i].imagen+');"></div>';
                        str+='<input type="hidden" name="'+json[i].id_juego+'" />';
                    str+='</div>';
                    str+='<div class="game-box-title">'+json[i].nombre+'</div>';
                str+='</a>';
            str+='</div>';
            $("#content-home").append(str);
            str="";
        }  
    }

    if(loc[loc.length-1]==="profile"){
        $.ajax({
            type: 'POST',
            url: 'profile/getdatauser',
            datatype:'json',
            success:function(msg){loaduserdata(msg);},
            error:function(msg){alert(msg);},
        });
    }

    // $('#act-add-ship-addr').click(function(){
    //     dir = $('#addres-prfile').val();
    //     postal = $('#postal-prfile').val();
    //     pob = $('#pob-addr').val();
    //     // alert(pob);
    //     // alert(dir);
    //     // alert(postal);
    //     $.ajax({
    //         type: 'POST',
    //         url: 'profile/addaddres',
    //         data:{'dir':dir,'postal':postal,'pob':pob},
    //         datatype:'json',
    //         success:function(msg){location.reload();},
    //         error:function(msg){alert(msg);},
    //     }); 
    // });

    // $('#act-add-fact-addr').click(function(){
    //     dir = $('#fact-addrs').val();
    //     postal = $('#fact-postal').val();
    //     pob = $('#pob-fact-addr').val();
    //     // alert(pob);
    //     // alert(dir);
    //     // alert(postal);
    //     $.ajax({
    //         type: 'POST',
    //         url: 'profile/addaddres',
    //         data:{'dir':dir,'postal':postal,'pob':pob},
    //         datatype:'json',
    //         success:function(msg){location.reload();},
    //         error:function(msg){alert(msg);},
    //     }); 
    // });

    $('#del-ship-addr').click(function(){
        dir = $('#ship-addr').val();
        $.ajax({
            type: 'POST',
            url: 'profile/deladdres',
            data:{'dir':dir},
            datatype:'json',
            success:function(msg){location.reload();},
            error:function(msg){alert(msg);},
        }); 
    });

    $('#del-fact-addr').click(function(){
        dir = $('#fact-addr').val();
        $.ajax({
            type: 'POST',
            url: 'profile/deladdres',
            data:{'dir':dir},
            datatype:'json',
            success:function(msg){location.reload();},
            error:function(msg){alert(msg);},
        }); 
    });

    $('#def-ship-addr').click(function(){
        dir = $('#ship-addr').val();
        $.ajax({
            type: 'POST',
            url: 'profile/setdefault',
            data:{'dir':dir,'type':1},
            datatype:'json',
            success:function(msg){location.reload()},
            error:function(msg){alert(msg);},
        }); 
    });

    $('#def-fact-addr').click(function(){
        dir = $('#fact-addr').val();
        $.ajax({
            type: 'POST',
            url: 'profile/setdefault',
            data:{'dir':dir,'type':2},
            datatype:'json',
            success:function(msg){location.reload()},
            error:function(msg){alert(msg);},
        }); 
    });

    $('#save-profile').click(function(){
        name    = $('#name').val();
        ape     = $('#last-name').val();
        date    = $('#birth-date').val();
        email   = $('#email').val();
        nick    = $('#nick').val();
        phone   = $('#phone').val();
        pass   = $('#pass').val();
        $.ajax({
            type: 'POST',
            url: 'profile/saveprofile',
            data:{'name':name,'ape':ape,'date':date,'email':email,'nick':nick,'phone':phone,'pass':pass},
            datatype:'json',
            success:function(msg){location.reload()},
            error:function(msg){alert(msg);},
        }); 
    });

    var flag2 = 0;
    function loaduserdata(dades){
        json = $.parseJSON(dades);
        cont = json.length;

        $('#name').val(json[0].nombre);
        $('#last-name').val(json[0].apellidos);
        $('#birth-date').val(json[0].fecha_nacimiento);
        $('#email').val(json[0].email);
        $('#nick').val(json[0].apodo);
        $('#phone').val(json[0].telefono_contacto);
        if(flag2 === 0)
        {
            if((typeof json[0].id_domicilio !== "undefined"))
            {
                for (var i=0; i<cont; i++) {
                    str = "";
                    str+="<option value='"+json[i].id_domicilio+"'>"+json[i].direccion+"</option>";
                    $(".addrs").append(str);
                    str="";
                } 
            }
           
            flag2 = -1;
        }
        
    }

    $('.add-ico').click(function(){
        $.ajax({
            type: 'POST',
            url: 'profile/getpob',
            datatype:'json',
            success:function(msg){loadpobs(msg);},
            error:function(msg){alert(msg);},
        });
    });
    var flag = 0;
    function loadpobs(dades){
        json = $.parseJSON(dades);
        cont = json.length;
        if(flag === 0)
        {
            for (var i=0; i<cont; i++) {
                str = "";
                str+="<option value='"+json[i].id_poblacion+"'>"+json[i].nombre+"</option>";
                $(".pob-addr").append(str);
                str="";
            }
            flag = -1;
        }
    }

    if(loc[loc.length-2]==="buy_process" && loc[loc.length-1]==="load"){
        if(!(typeof Cookies.get('userid') === "undefined")) {
            $.ajax({
                type: 'POST',
                url: window.appw+'buy_process/getuser',
                datatype:'json',
                success:function(msg){chargeuserdata(msg);},
                error:function(msg){alert(msg);},
            });

            $.ajax({
                type: 'POST',
                url: window.appw+'buy_process/getpobs',
                datatype:'json',
                success:function(msg){chargepobs(msg);},
                error:function(msg){alert(msg);},
            });

            $.ajax({
                type: 'POST',
                url: window.appw+'buy_process/getdirectionsbyuser',
                datatype:'json',
                success:function(msg){chargedirection(msg);},
                error:function(msg){alert(msg);},
            });

            $('#btnContinuarPaso3').click(function(){
                envio = $('#address1').val();
                fact = $('#address2').val();
                $.ajax({
                    type: 'POST',
                    url: window.appw+'buy_process/addbill',
                    data:{'envio':envio,'fact':fact},
                    datatype:'json',
                    success:function(msg){openlast(msg)},
                    error:function(msg){alert("ss");},
                });
            });
        }

        $("#copyFields").click(function(){
            if($("#copyFields").prop('checked') === true){
                $('#postal2').val($('#postal1').val());
                $('#telef2').val($('#telef1').val());
                $('#name2').val($('#name1').val());
                $('#lastname2').val($('#lastname1').val());
                $('#pob2').val($("#pob1").val());
                $('#address2').val($("#address1").val());
            }
            else
            {
               $('#postal2').val(""); 
               $('#telef2').val(""); 
               $('#name2').val(""); 
               $('#lastname2').val(""); 
            }
        });

        $('#btnContinuarPaso2').click(function(){
            $('#resName1').text($('#name1').val()+" "+$('#lastname1').val());
            $('#resAddress1').text($('#address1 option:selected').text());
            $('#resPostal1').text($('#postal1').val());
            $('#resPob1').text($('#pob1').text());

            $('#resName2').text($('#name2').val()+" "+$('#lastname2').val());
            $('#resAddress2').text($('#address2 option:selected').text());
            $('#resPostal2').text($('#postal2').val());
            $('#resPob2').text($('#pob2').text());
        });
        
    }// BUY PROCES AJAXES

    function chargeuserdata(dades){
        json = $.parseJSON(dades);
        cont = json.length;
        $('#name1').val(json.nombre);
        $('#lastname1').val(json.apellidos);
        $('#postal1').val(json.codigo_postal);
        $('#telef1').val(json.telefono_contacto);
        $('#name2').val(json.nombre);
        $('#lastname2').val(json.apellidos);
        $('#postal2').val(json.codigo_postal);
        $('#telef2').val(json.telefono_contacto);
    }

    function chargepobs(dades){
        json = $.parseJSON(dades);
        cont = json.length;
        for (var i=0; i<cont; i++) {
            str = "";
            str+="<option value='"+json[i].id_poblacion+"'>"+json[i].nombre+"</option>";
            $("#pob1").append(str);
            $("#pob2").append(str);
            str="";
        }
    }
    

    function chargedirection(dades){
        json = $.parseJSON(dades);
        cont = json.length;
        for (var i=0; i<cont; i++) {
            str = "";
            str+="<option value='"+json[i].id_domicilio+"'>"+json[i].direccion+"</option>";
            $("#address1").append(str);
            $("#address2").append(str);
            str="";
        }
    }

    function openlast(dades){
        json = $.parseJSON(dades);
        cont = json.length;
        if(json.response == '0'){
            $("#numProdCarro").html("");
            $("#ui-id-2").hide();
            $("#ui-id-4").hide();
            $("#imgOkPaso3").css("display","inline");
            $("#procesoCompra").accordion( "option", "active", 2 );
        }else if(json.response == '-1'){
            dialogoMensaje("No tenemos stock del producto: \""+json.producto+"\", quitelo del carro y vuelva a intentar realizar la compra");
        }else if(json.response == '-2'){
            dialogoMensaje("No tenemos suficiente stock del producto: \""+json.producto+"\", intente comprar menos cantidad");
        }else{
            dialogoMensaje("Error al realizar la compra, vuelva a intentarlo");
        }
    }


    /* CHECK DE TODO RELLENO EN EL ENVIO/PAGO DEL PROCESO DE COMPRA */

    /* COMPROBACIONES DEL FORMULARIO DEL PERFIL */
    $("#btnContinuarPaso2").on("click",function(e){
        e.preventDefault();

        check = 1;
        name1 = $("#name1").val();
        lastname1 = $("#lastname1").val();
        pob1 = $("#pob1 option:selected").val();
        address1 = $("#address1 option:selected").val();
        postal1 = $("#postal1").val();
        telef1 = $("#telef1").val();
        name2 = $("#name2").val();
        lastname2 = $("#lastname2").val();
        pob2 = $("#pob2 option:selected").val();
        address2 = $("#address2 option:selected").val();
        postal2 = $("#postal2").val();
        telef2 = $("#telef2").val();

        $("#msg-process").css("font-weight","bold");

        if(name1 != null && name1 != "" && lastname1 != null && lastname1 != "" && 
           pob1 != null && pob1 != "" && address1 != null && address1 != "" && 
           postal1 != null && postal1 != "" && telef1 != null && telef1 != "" && 
           name2 != null && name2 != "" && lastname2 != null && lastname2 != "" && 
           pob2 != null && pob2 != "" && address2 != null && address2 != "" && 
           postal2 != null && postal2 != "" && telef2 != null && telef2 != ""){

            $("#msg-process").html("");

            if(!$.isNumeric(postal1) || postal1.length != 5){
                check=0;
                $("#msg-process").append("<p>El código postal de los datos de envio no es válido.</p>");
            }

            if(!$.isNumeric(telef1) || telef1.length != 9){
                check=0;
                $("#msg-process").append("<p>El teléfono de los datos de envio no es válido.</p>");
            }

            if(!$.isNumeric(postal2) || postal2.length != 5){
                check=0;
                $("#msg-process").append("<p>El código postal de los datos de facturación no es válido.</p>");
            }

            if(!$.isNumeric(telef2) || telef2.length != 9){
                check=0;
                $("#msg-process").append("<p>El teléfono de los datos de facturación no es válido.</p>");
            }

            if(check == 1){
                // Abrir paso 3
                $("#imgOkPaso2").css("display","inline");
                $("#procesoCompra").accordion( "option", "active", 1 );
            }    

        }else{
            $("#msg-process").html("Todos los campos deben rellenarse.");
        }
        
    });



/* -------------------------------------------------------- APP 3 -------------------------------------------------------- */




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
                if(numAciertos==6){//Comprobamos si hemos llegado al numero de aciertos maximo para ganar
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


/* -------------------------------------------------------- APP 1 -------------------------------------------------------- */

 

    /* POSICIONAMIENTO DINÁMICO DE LA CAJA DESPLEGABLE DEL LOGIN */
    function login_pos(){
        x = $("#top-menu").position();
        top_part = eval($("#top-menu").height());
        left_part = eval($("#top-menu").width() - 300 + x.left);
        $("#login-box").css({
            "top": top_part+"px",
            "left": left_part+"px"
        });
    }

    setTimeout(function(){login_pos()}, 100); 

    function logged_drop_pos(){
        x = $("#top-menu").position();
        top_part = eval($("#top-menu").height());
        left_part = eval($("#top-menu").width() - 170 + x.left);
        $("#logged-drop").css({
            "top": top_part+"px",
            "left": left_part+"px"
        });
    }

    setTimeout(function(){logged_drop_pos()}, 100);     

    $(window).resize(function(){
        login_pos();
        logged_drop_pos();
    });

    /* DESPLIEGUE DEL LOGIN */
    $("#top-login").on("click",function(){
        $("#login-box").slideToggle(200);
    });

    /* DESPLIEGUE DE LAS OPCIONES UNA VEZ LOGEADO */
    $("#logged").on("click",function(){
        $("#logged-drop").slideToggle(200);
    });

    // Cerrar el login cuando se clica fuera
    $(document).on("click",function(e){
        var container1 = $("#login-box");
        var container2 = $("#top-login");
        var container3 = $("#logged");
        var container4 = $("#logged-drop");

        if (!container1.is(e.target) && container1.has(e.target).length === 0 && !container2.is(e.target) && container2.has(e.target).length === 0){
            container1.slideUp(200);
        }

        if (!container3.is(e.target) && container3.has(e.target).length === 0 && !container4.is(e.target) && container4.has(e.target).length === 0){
            container4.slideUp(200);
        }
    });


    /* COMPROBACIONES DEL FORMULARIO DE REGISTRO */
    $("#btn-act-register").on("click",function(e){
        e.preventDefault();

        check = 0;
        name = $("#name").val();
        last_name = $("#last-name").val();
        birth_date = $("#birth-date").val();
        email = $("#email").val();
        nick = $("#nick").val();
        pass = $("#pass").val();
        repass = $("#repass").val();

        $("#reg-msg").css("font-weight","bold");


        if(name != null && name != "" && last_name != null && last_name != "" && 
           birth_date != null && birth_date != "" && email != null && email != "" && 
           nick != null && nick != "" && pass != null && pass != "" && 
           repass != null && repass != ""){

            $("#reg-msg").html("");

            // Check de fechas
            birth_date = birth_date.substr(0,4);
            today = new Date();
            today = today.getFullYear();

            if(birth_date >= today && birth_date < 1916){
                $("#reg-msg").append("<p>Fecha de nacimiento no válida.</p>");
                check=1;
            }

            // Check de contraseñas
            if(pass != repass){
                $("#reg-msg").append("<p>Las contraseñas no coinciden.</p>");
                check=1;
            }

            // Check email
            regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(regex.test(email) == false){
                $("#reg-msg").append("<p>Formato del email no válido.</p>");
                check=1;
            }

            if(check == 0){
                $("#register-form").submit();
            }            

        }else{
            $("#reg-msg").html("<p>Todos los campos deben rellenarse.</p>");
        }
    });


    /* COMPROBACIONES DEL FORMULARIO DEL PERFIL */
    $("#save-profile").on("click",function(e){
        e.preventDefault();

        check = 0;
        email = $("#email").val();
        nick = $("#nick").val();
        pass = $("#pass").val();
        repass = $("#repass").val();

        $("#reg-msg").css("font-weight","bold");


        if(email != null && email != "" && nick != null && nick != "" && 
           pass != null && pass != "" && repass != null && repass != ""){

            $("#profile-msg").html("");

            // Check de contraseñas
            if(pass != repass){
                $("#profile-msg").append("<p>Las contraseñas no coinciden.</p>");
                check=1;
            }

            // Check email
            regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(regex.test(email) == false){
                $("#profile-msg").append("<p>Formato del email no válido.</p>");
                check=1;
            }

            if(check == 0){
                $("#profile-form").submit();
            }            

        }else{
            $("#profile-msg").html("<p>Todos los campos deben rellenarse.</p>");
        }
    });


    /* COMPROBACIONES DEL FORMULARIO DEL PERFIL - AÑADIR DIRECCIÓN DE ENVIO */
    $("#act-add-ship-addr").on("click",function(e){        
        e.preventDefault();

        dir = $('#addres-prfile').val();
        postal = $('#postal-prfile').val();
        pob = $('#pob-addr').val();

        if(dir != "" && dir != null && postal != "" && postal != null){
            if($.isNumeric(postal)){
                $.ajax({
                    type: 'POST',
                    url: 'profile/addaddres',
                    data:{'dir':dir,'postal':postal,'pob':pob},
                    datatype:'json',
                    success:function(msg){location.reload();},
                    error:function(msg){alert(msg);},
                }); // EXECUTE AJAX
            }else{
            $("#ship-msg").append("<p>Código postal no válido.</p>");   
            }
        }else{
            $("#ship-msg").html("<p>Todos los campos deben rellenarse.</p>");            
        }        
    });


    /* COMPROBACIONES DEL FORMULARIO DEL PERFIL - AÑADIR DIRECCIÓN DE FACTURACION */
    $("#act-add-fact-addr").on("click",function(e){   
        e.preventDefault();

        dir = $('#fact-addrs').val();
        postal = $('#fact-postal').val();
        pob = $('#pob-fact-addr').val();

        if(dir != "" && dir != null && postal != "" && postal != null){
            if($.isNumeric(postal)){
                $.ajax({
                    type: 'POST',
                    url: 'profile/addaddres',
                    data:{'dir':dir,'postal':postal,'pob':pob},
                    datatype:'json',
                    success:function(msg){location.reload();},
                    error:function(msg){alert(msg);},
                });// EXECUTE AJAX
            }else{
                $("#fact-msg").append("<p>Código postal no válido.</p>");   
            }
        }else{
            $("#fact-msg").html("<p>Todos los campos deben rellenarse.</p>");            
        }    
    });


    /* DESPLEGABLE DE NUEVA DIRECCIÓN DE ENVIO Y FACTURACIÓN */

    $("#add-ship-addr").on("click",function(){
        $("#add-ship-addr-box").slideToggle(200);
    });

    $("#add-fact-addr").on("click",function(){
        $("#add-fact-addr-box").slideToggle(200);
    });

    /* DESPLEGABLE DEL MENU DE CATEGORIAS EN MOBILE */
    $("#cat-menu-hamb").on("click",function(){
        $("#cat-menu").slideToggle(200);
    });

    /* ACORDEON EN PROCESO DE COMPRA */
    $('#filtroTematica').collapsible();
    $("#procesoCompra").accordion({
        heightStyle: "content"
    });

    $( "#procesoCompra" ).accordion( "option", "disabled", true );

    if($("#imgOkPaso1").length == 0) {

    }else{
        $('#btnCrearCuenta, #btnAcceder').on('click',function(){
            $("#imgOkPaso1").css("display","inline");
            $("#procesoCompra").accordion( "option", "active", 1 );
        });

        $('#btnContinuarPaso3').on('click',function(){
            $("#imgOkPaso3").css("display","inline");
            $("#procesoCompra").accordion( "option", "active", 3 );
        });

    }

    $("#ui-id-2").on("click", function(){
        $("#imgOkPaso2").css("display","none");
        $("#procesoCompra").accordion( "option", "active", 0);
    });


    /* Change border cat */

    var color_border = $(".current em").css("color");
    var current_cat = $(".current em").text();

    switch(current_cat){
        case "Matemáticas": $("#cat-Matemáticas").addClass("cat-active");
                            $("#cat-Matemáticas").css("color",color_border);
                            break;

        case "Música":      $("#cat-Música").addClass("cat-active");
                            $("#cat-Música").css("color",color_border);
                            break;

        case "Memoria":     $("#cat-Memoria").addClass("cat-active");
                            $("#cat-Memoria").css("color",color_border);
                            break;

        case "Lengua":      $("#cat-Lengua").addClass("cat-active");
                            $("#cat-Lengua").css("color",color_border);
                            break;

        case "Creatividad": $("#cat-Creatividad").addClass("cat-active");
                            $("#cat-Creatividad").css("color",color_border);
                            break;

        case "Tienda":      $("#cat-Tienda").addClass("cat-active");
                            $("#cat-Tienda").css("color",color_border);
                            break;
    }

});


/* PARTE DE APP3 FUERA DE DOCREADY */

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
