$(document).ready(function(){
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

    window.appw = $("#appw").val();
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

});