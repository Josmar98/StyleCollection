	<?php 
      $actualizargemasfacturaD = 0;
      $actualizargemasfacturaB = 0;
      $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
      foreach ($configuraciones as $config) {
        if(!empty($config['id_configuracion'])){
          if($config['clausula']=="Actgemasfacturad"){
            $actualizargemasfacturaD = $config['valor'];
          }
          if($config['clausula']=="Actgemasfacturab"){
            $actualizargemasfacturaB = $config['valor'];
          }
        }
      }

  ?>


<!-- jQuery 3 -->
<script src="public/vendor/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="public/vendor/bower_components/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="public/vendor/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<!-- Morris.js charts -->
<!-- <script src="public/vendor/bower_components/raphael/raphael.min.js"></script> -->
<!-- <script src="public/vendor/bower_components/morris.js/morris.min.js"></script> -->
<!-- Sparkline -->
<script src="public/vendor/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="public/vendor/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="public/vendor/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="public/vendor/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="public/vendor/bower_components/moment/min/moment.min.js"></script>
<script src="public/vendor/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="public/vendor/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="public/vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="public/vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="public/vendor/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="public/vendor/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="public/vendor/plugins/DataTables/datatables.js"></script>
<!-- <script src="public/vendor/plugins/DataTables/DataTables/js/jquery.dataTables.js"></script> -->

<script src="public/vendor/plugins/DataTables/DataTables/js/dataTables.bootstrap.js"></script>
<script src="public/vendor/plugins/DataTables/DataTables/js/dataTables.responsive.min.js"></script>
<!-- SlimScroll -->
<script src="public/vendor/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="public/vendor/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="public/vendor/dist/js/adminlte.js"></script>
<script src="public/vendor/plugins/sweetalert/sweet-alert.js"></script>
<script src="public/vendor/plugins/select2/js/select2.js"></script>
<script src="public/assets/js/validacionCampos.js"></script>
<script src="public/assets/js/volver.js"></script>

<!-- <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->
<!-- AdminLTE for demo purposes -->


<!-- FOUNDATION -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.7.5/js/foundation.min.js"></script> -->

<!-- MATERIALIZE CSS -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script> -->

<!-- SEMANTIC UI -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js"></script> -->

<!-- SKELETON -->
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css"></script> -->



<!-- <script src="public/vendor/dist/js/demo.js"></script> -->
<!-- page script -->
<style>
th{font-size:.85em !important;}
</style>
<script>
$(document).ready(function(){
          // var inFormOrLink;
    // $('a[href]:not([target]),a[href][target=_self]').live('click', function(){ inFormOrLink = true; });
    // $('form').bind('submit', function(){ inFormOrLink = true; });
    // $(window).bind('beforeunload', function(event){
    //   var returnValue = undefined;
    //   if(!inFormOrLink){
    //     returnValue = "Seguro que quiere cerrar?";
    //   }
    //   event.returnValue = returnValue;
    //   return returnValue;
    // });


      // alert('JAJAJA');

    // var widthImage = $(".RealImage").width();
    // $(".imageImage").attr("style","height:"+30+"vh;width:"+30+"vh");
    var widthImage2 = $(".ReadlImage2").width();
    $(".imageImage2").attr("style","height:"+widthImage2+"px;width:"+widthImage2+"px");
    $(window).resize(function(){
      // var widthImage = $(".RealImage").width();
      // $(".imageImage").attr("style","height:"+30+"vh;width:"+30+"vh");
  
      var widthImage2 = $(".ReadlImage2").width();
      $(".imageImage2").attr("style","height:"+widthImage2+"px;width:"+widthImage2+"px");
    }); 
});
  $(function () {
    $('.datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
      },
      responsive: true,
    });
    $('.datatable2').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 0, "desc" ]],
      responsive: true,
    });
    $('.datatable1').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "asc" ]],
    });
    $('.datatable3').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "asc" ],[ 2, "asc" ]],
      responsive: true,
    });
    $('.datatable31').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 1, "desc" ]],
      responsive: true,
    });
    $('#datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
      },
      responsive: true,
    });
    $('#datatable2').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
      },
      "order": [[ 0, "desc" ]],
      responsive: true,
    });
    $('#mini-datatable').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
        'pageLength': 5,
      },
      responsive: true,
    });
    $('#datatableOrder').DataTable({
      "language": {
        "url": "public/vendor/plugins/DataTables/spanish.json",
        'info': true,
      },
      responsive: true,
      "order": [[ 2, "desc" ],[ 3, "desc" ]],
    });
    $('#datatable3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
    $('.select2').select2();
    $("input").attr("autocomplete","off");
    






    var rolhidden = $(".rolhidden").val();
    // if(rolhidden == "Administrador" || rolhidden == "Superusuario"  || rolhidden == "Analista"){
    if(rolhidden != "Vendedor"){
      verifyNotifyAdmin();
    }
    if(rolhidden == "Vendedor"){
      verifyNotifyVendedor();
    } 

    verPedidoPendiente();
    verPlanesAgregados();
    verTiempoDeDesperfectos();

    calendarioVerificarDia();

    <?php if($_SESSION['nombre_rol']=="Superusuario" && $actualizargemasfacturaD=="1"){ ?>
      actualizarGemasFacturaPedidosD();
    <?php } ?>
    <?php if($_SESSION['nombre_rol']=="Superusuario" && $actualizargemasfacturaB=="1"){ ?>
      actualizarGemasFacturaPedidosB();
    <?php } ?>

  })
function verifyNotifyAdmin(){

  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarNuevoPedido: "openorclose"
    },
    success: function(respuesta){
      var dataJson = JSON.parse(respuesta);
      // console.log(dataJson);

      // alert(dataJson.cantidad);
      var cantidadAll = dataJson.cantidadAll;
      var cantidad = dataJson.cantidad;
      var campaing = "";
      // var campaing = $(".campaing").val();
      var num_campaing = "";
      // var num_campaing = $(".num_campaing").val();
      var year_campaing = "";
      // var year_campaing = $(".year_campaing").val();
      var despacho_id = "";
      // var despacho_id = $(".despacho_id").val();
      var num_despacho = "";
      // var num_despacho = $(".num_despacho").val();
      var ruta = "";
      // var ruta = "?campaing="+campaing+"&n="+num_campaing+"&y="+year_campaing+"&dpid="+despacho_id+"&dp="+num_despacho+"&route=Pedidos";
        $(".cantidadNoVista").html(cantidad);
        if(cantidad==1){
          // $(".tipoNovista").html("no revisados");
          $(".tipoNovista").html("pedido no revisado");
        }else{
          $(".tipoNovista").html("pedidos no revisados");
        }
        if(cantidadAll > 0){
          if(cantidad > 0){
            $(".cantidad_notificaciones").removeClass("d-none");
            $(".cantidad_notificaciones").html(cantidad);
            $(".cantidad_notificaciones").attr("style","background:#9900FF;border:1px solid #d00;font-size:0.8em;");
          }
          var notificA = "";
          var notificF = "";
          var html = "";
          for (var i = 0; i < cantidadAll; i++) {

            campaing = dataJson[i].id_campana;
            num_campaing = dataJson[i].numero_campana;
            year_campaing = dataJson[i].anio_campana;
            despacho_id = dataJson[i].id_despacho;
            num_despacho = dataJson[i].numero_despacho;
            ruta = "?campaing="+campaing+"&n="+num_campaing+"&y="+year_campaing+"&dpid="+despacho_id+"&dp="+num_despacho+"&route=Pedidos"+"&id="+dataJson[i].id_pedido;
            // ruta += "&id="+dataJson[i].id_pedido;
            if(dataJson[i].visto_admin==0){
              notificA = "<li style='background:#ddd'><a href='"+ruta+"'><i class='fa fa-user' style='color:#EA018C;font-size:1.15em;'></i> ";
            }else{
              notificA = "<li><a href='"+ruta+"'><i class='fa fa-user' style='color:#47C'></i> ";              
            }
            notificF = "</a></li>";
            html += notificA;
            html += "<span style='font-size:0.8em;position:relative;float:right;'>"+dataJson[i].fecha_pedido+" | "+dataJson[i].hora_pedido+"</span>";
            html += "<b style='margin-left:-10px;'>"+dataJson[i].primer_nombre + " " + dataJson[i].primer_apellido + "</b> <br>Hizo un pedido de " + dataJson[i].cantidad_pedido + " colecciones";
            html += "<br>";
            html += "<small>Pedido - Campaña "+dataJson[i].numero_campana+"/"+dataJson[i].anio_campana+"</small>";
            html += notificF;
          }

          // html += $(".menu_notificaciones").html();
          // alert(html);
          $(".menu_notificaciones").html(html);
          // var notific = '<span class="notification-icon"></span>';
          // alert()
        }
        // if(respuesta > 0){
          // var notific = '<span class="notification-icon" style="background:red;"></span>';
        // }
        // $(".alertNotifi").html(notific);
        setTimeout("verifyNotifyAdmin()",30000);

    }
  }); 

}
function verifyNotifyVendedor(){

  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarPedidosAprobados: "openorclose"
    },
    success: function(respuesta){
      // alert(respuesta);
      var dataJson = JSON.parse(respuesta);
      // console.log(dataJson);

      // alert(dataJson.cantidad);
      var cantidadAll = dataJson.cantidadAll;
      var cantidad = dataJson.cantidad;
      var campaing = "";
      // var campaing = $(".campaing").val();
      var num_campaing = "";
      // var num_campaing = $(".num_campaing").val();
      var year_campaing = "";
      // var year_campaing = $(".year_campaing").val();
      var despacho_id = "";
      // var despacho_id = $(".despacho_id").val();
      var num_despacho = "";
      // var num_despacho = $(".num_despacho").val();
      var ruta = "";
      // var ruta = "?campaing="+campaing+"&n="+num_campaing+"&y="+year_campaing+"&dpid="+despacho_id+"&dp="+num_despacho+"&route=Pedidos";
      // alert(cantidadAll);
        $(".cantidadNoVista").html(cantidad);
        if(cantidad==1){
          $(".tipoNovista").html("pedido aprobado");
        }else{
          $(".tipoNovista").html("pedidos aprobados");
        }
        if(cantidadAll > 0){
          if(cantidad > 0){
            $(".cantidad_notificaciones").removeClass("d-none");
            $(".cantidad_notificaciones").html(cantidad);
            $(".cantidad_notificaciones").attr("style","background:#9900FF;border:1px solid #d00");
          }

          var notificA = "";
          var notificF = "";
          var html = "";
          for (var i = 0; i < cantidadAll; i++) {
            if(dataJson[i].cantidad_aprobado > 0){
              campaing = dataJson[i].id_campana;
              num_campaing = dataJson[i].numero_campana;
              year_campaing = dataJson[i].anio_campana;
              despacho_id = dataJson[i].id_despacho;
              num_despacho = dataJson[i].numero_despacho;
              ruta = "?campaing="+campaing+"&n="+num_campaing+"&y="+year_campaing+"&dpid="+despacho_id+"&dp="+num_despacho+"&route=Pedidos"+"&id="+dataJson[i].id_pedido;
              if(dataJson[i].visto_cliente==2){
                notificA = "<li style='background:#ddd'><a href='"+ruta+"'><i class='fa fa-user' style='color:#47C'></i> ";
              }else{
                notificA = "<li><a href='"+ruta+"'><i class='fa fa-user' style='color:#47C'></i> ";              
              }

              notificF = "</a></li>";
              html += notificA;
              html += "<span style='font-size:0.8em;position:relative;float:right;'>"+dataJson[i].fecha_aprobado+" / "+dataJson[i].hora_aprobado+"</span>";
              html += "<b style='margin-left:-10px;'>Saludos "+dataJson[i].primer_nombre+"</b> <br>";
              html += "Tu pedido fue aprobado con <br> una cantidad de " + dataJson[i].cantidad_aprobado + " colecciones";

              html += "<br>";
              html += "<small>Pedido - Campaña "+dataJson[i].numero_campana+"/"+dataJson[i].anio_campana+"</small>";
              html += notificF;
              
            }

          }

          // html += $(".menu_notificaciones").html();
          // alert(html);
          $(".menu_notificaciones").html(html);
          // var notific = '<span class="notification-icon"></span>';
          // alert()
        }
        // if(respuesta > 0){
          // var notific = '<span class="notification-icon" style="background:red;"></span>';
        // }
        // $(".alertNotifi").html(notific);
        setTimeout("verifyNotifyVendedor()",30000);

    }
  }); 

}
function verPedidoPendiente(){

  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarFechaLimitePedido: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);
      var dataJson2 = JSON.parse(respuesta);
      // console.log(dataJson2);

      if(dataJson2['exec']){
        // console.log(dataJson);
        if(dataJson2.data.length > 0){
          for (var i = 0; i < dataJson2.data.length; i++) {
            dataJson = dataJson2.data[i];

            if(dataJson['limite']){ //Hay fecha limite cerca
              var dias = dataJson['dias_restante'];
              if(dias!="-1"){
                var fecha_limite = dataJson['limite_pedido'];
                var despacho = dataJson['despacho'];
                var campana = dataJson['campana'];
                var cantDias = "";
                var tiempo = "";
                if(dias<2){
                  if(dias == 0){
                    var tiempo = "Queda Hasta Hoy";
                  }
                  if(dias == 1){
                    cantDias = " dia";
                    tiempo = "Queda Hasta Mañana";
                  }
                }else{
                  cantDias = " dias";
                  tiempo = "Quedan "+dias+cantDias;
                }
                // $(".Informaciones").hide();
                $(".Informaciones").removeClass("d-none");
                $(".Informaciones").attr("style","font-size:0.8em;background:#9900FF;border:1px solid #000;color:#fff");

                var html = "";
                // alert("Quedan "+dias+cantDias+" para realizar pedido del despacho "+despacho['numero_despacho']+" de Campaña "+campana['numero_campana']+"/"+campana['anio_campana']);

                  // notificA = "<li><a style='color:#222'><i class='fa fa-user text-aqua'></i> "; 
                  notificA = "<li style='background:#FFF;padding:10px;'><a style='color:#222;background:#ddd'><i style='font-size:1.5em;color:#EA018C' class='fa fa-user text-danger' ></i> "; 
                  notificF = "</a></li>";
                  html += notificA;
                  // html += "<span style='font-size:0.9em;position:relative;float:right;'>"+campana['numero_campana']+"/"+campana['anio_campana']+"</span>";
                  html += "<b style='margin-left:0px;'>Saludos "+"<?=$_SESSION['cuenta']['primer_nombre'].' '.$_SESSION['cuenta']['primer_apellido']?>"+"</b> <br>";
                  if(despacho['numero_despacho']>1){
                    html += "A la fecha ''<?php echo date('d-m-Y'); ?>''<br><b style='font-size:1.2em;'><u>"+tiempo+"</u></b><br>para realizar su "+despacho['numero_despacho']+" Pedido <br> de esta Campaña "+campana['numero_campana']+"/"+campana['anio_campana']+"";
                  }else{
                    html += "A la fecha ''<?php echo date('d-m-Y'); ?>''<br><b style='font-size:1.2em;'><u>"+tiempo+"</u></b><br>para realizar su Pedido <br> de esta Campaña "+campana['numero_campana']+"/"+campana['anio_campana']+"";
                  }
                  html += notificF;
                  html += $(".menu_informaciones").html();
                  $(".menu_informaciones").html(html);
              }else{
                // $(".menu_informaciones").html("<li><a style='color:#222'>No tiene Informaciones sobre pedidos</a></li>");
                var html = $(".menu_informaciones").html();
                html += "<li><a style='color:#222'>No tiene Informaciones sobre pedidos</a></li>";
                $(".menu_informaciones").html(html);

              }

            }
          }
        }else{ // No hay ninguna fecha limite cerca
            var html = $(".menu_informaciones").html();
            html += "<li><a style='color:#222'>No tiene Informaciones sobre pedidos</a></li>";
            $(".menu_informaciones").html(html);
        }

      }else{

      }
              //   notificA = "<li><a href='#'><i class='fa fa-user text-aqua'></i> "; 

              // notificF = "</a></li>";
              // html += notificA;
              // html += "<span style='font-size:0.8em;position:relative;float:right;'>"+dataJson[i].fecha_aprobado+" / "+dataJson[i].hora_aprobado+"</span>";
              // html += "<b style='margin-left:-10px;'>Saludos "+dataJson[i].primer_nombre+"</b> <br>";
              // html += "Tu pedido fue aprobado con <br> una cantidad de " + dataJson[i].cantidad_aprobado + " colecciones";
              // html += notificF;

              // $(".menu_notificaciones").append(html);
      // setTimeout("verPedidoPendiente()",3600000);

    }
  }); 
}
function verPlanesAgregados(){

  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarFechaLimitePlanes: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);
      var dataJsonV = JSON.parse(respuesta);
      // console.log(dataJsonV);
      if(dataJsonV['exec']){
        // console.log(dataJsonV.data.length);
        if(dataJsonV.data.length>0){
          for (var i = 0; i < dataJsonV.data.length; i++) {
            dataJson = dataJsonV.data[i];
            if(dataJson['limite']){ //Hay fecha limite cerca
              var dias = dataJson['dias_restante'];
              if(dias!="-1"){
                var fecha_limite = dataJson['limite_pedido'];
                var despacho = dataJson['despacho'];
                var campana = dataJson['campana'];
                // console.log(campana);
                var cantDias = "";
                // if(dias==1){
                //   cantDias = " dia";
                // }else{
                //   cantDias = " dias";
                // }
                if(dias<2){
                  if(dias == 0){
                    var tiempo = "Queda Hasta Hoy";
                  }
                  if(dias == 1){
                    cantDias = " dia";
                    var tiempo = "Queda Hasta Mañana";
                  }
                }else{
                  cantDias = " dias";
                  var tiempo = "Quedan "+dias+cantDias;
                }
                // $(".Informaciones").hide();
                $(".Informaciones").removeClass("d-none");
                $(".Informaciones").attr("style","font-size:0.8em;background:#9900FF;border:1px solid #000;color:#fff");

                var html = "";
                // alert("Quedan "+dias+cantDias+" para realizar pedido del despacho "+despacho['numero_despacho']+" de Campaña "+campana['numero_campana']+"/"+campana['anio_campana']);

                  // notificA = "<li><a style='color:#222'><i class='fa fa-user text-aqua'></i> "; 
                  notificA = "<li style='background:#FFF;padding:10px;'><a style='color:#222;background:#ddd'><i style='font-size:1.5em;color:#EA018C' class='fa fa-user text-danger' ></i> "; 
                  notificF = "</a></li>";
                  html += notificA;
                  // html += "<span style='font-size:0.9em;position:relative;float:right;'>"+campana['numero_campana']+"/"+campana['anio_campana']+"</span>";
                  html += "<b style='margin-left:0px;'>Saludos "+"<?=$_SESSION['cuenta']['primer_nombre'].' '.$_SESSION['cuenta']['primer_apellido']?>"+"</b> <br>";
                  if(despacho['numero_despacho']>1){
                    html += "A la fecha ''<?php echo date('d-m-Y'); ?>''<br><b style='font-size:1.2em;'><u>"+tiempo+"</u></b><br>para seleccionar sus planes <br> y premios del Pedido "+despacho['numero_despacho']+" de esta <br> Campaña "+campana['numero_campana']+"/"+campana['anio_campana']+"";
                  }else{
                    html += "A la fecha ''<?php echo date('d-m-Y'); ?>''<br><b style='font-size:1.2em;'><u>"+tiempo+"</u></b><br>para seleccionar sus planes <br> y premios del Pedido de esta <br> Campaña "+campana['numero_campana']+"/"+campana['anio_campana']+"";
                  }
                  html += notificF;
                  html += $(".menu_informaciones").html();
                  $(".menu_informaciones").html(html);
              }else{
                // $(".menu_informaciones").html("<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>");
                var html = $(".menu_informaciones").html();
                html += "<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>";
                $(".menu_informaciones").html(html);
              }

            }
          }
        }else{ // No hay ninguna fecha limite cerca
                
            // $(".menu_informaciones").html("<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>");
            var html = $(".menu_informaciones").html();
            html += "<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>";
            $(".menu_informaciones").html(html);
        }
      }else{

      }
              //   notificA = "<li><a href='#'><i class='fa fa-user text-aqua'></i> "; 

              // notificF = "</a></li>";
              // html += notificA;
              // html += "<span style='font-size:0.8em;position:relative;float:right;'>"+dataJson[i].fecha_aprobado+" / "+dataJson[i].hora_aprobado+"</span>";
              // html += "<b style='margin-left:-10px;'>Saludos "+dataJson[i].primer_nombre+"</b> <br>";
              // html += "Tu pedido fue aprobado con <br> una cantidad de " + dataJson[i].cantidad_aprobado + " colecciones";
              // html += notificF;

              // $(".menu_notificaciones").append(html);
      // setTimeout("verPedidoPendiente()",3600000);

    }
  }); 
}
function verTiempoDeDesperfectos(){

  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarFechaLimiteDesperfectos: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);  
      var dataJson = JSON.parse(respuesta);
      // console.log(dataJson);
      if(dataJson['exec']){

        if(dataJson['limite']){ //Hay fecha limite cerca
          var dias = dataJson['dias_restante'];
          if(dias!="-1"){
            var fecha_limite = dataJson['limite_pedido'];
            var despacho = dataJson['despacho'];
            var campana = dataJson['campana'];
            // console.log(campana);
            var cantDias = "";
            if(dias==1){
              cantDias = " dia";
            }else{
              cantDias = " dias";
            }
            // $(".Informaciones").hide();
            $(".Informaciones").removeClass("d-none");
            $(".Informaciones").attr("style","font-size:0.8em;background:#9900FF;border:1px solid #000;color:#fff");

            var y1 = dataJson['fecha_inicio_desperfecto'].substring(0,4);
            var m1 = dataJson['fecha_inicio_desperfecto'].substring(5,7);
            var d1 = dataJson['fecha_inicio_desperfecto'].substring(8,10);

            var y2 = dataJson['fecha_fin_desperfecto'].substring(0,4);
            var m2 = dataJson['fecha_fin_desperfecto'].substring(5,7);
            var d2 = dataJson['fecha_fin_desperfecto'].substring(8,10);


            if(m1 == "01"){m1="Enero";}
            if(m1 == "02"){m1="Febrero";}
            if(m1 == "03"){m1="Marzo";}
            if(m1 == "04"){m1="Abril";}
            if(m1 == "05"){m1="Mayo";}
            if(m1 == "06"){m1="Junio";}
            if(m1 == "07"){m1="Julio";}
            if(m1 == "08"){m1="Agosto";}
            if(m1 == "09"){m1="Septiembre";}
            if(m1 == "10"){m1="Octubre";}
            if(m1 == "11"){m1="Noviembre";}
            if(m1 == "12"){m1="Diciembre";}

            if(m2 == "01"){m2="Enero";}
            if(m2 == "02"){m2="Febrero";}
            if(m2 == "03"){m2="Marzo";}
            if(m2 == "04"){m2="Abril";}
            if(m2 == "05"){m2="Mayo";}
            if(m2 == "06"){m2="Junio";}
            if(m2 == "07"){m2="Julio";}
            if(m2 == "08"){m2="Agosto";}
            if(m2 == "09"){m2="Septiembre";}
            if(m2 == "10"){m2="Octubre";}
            if(m2 == "11"){m2="Noviembre";}
            if(m2 == "12"){m2="Diciembre";}

            var html = "";
            // alert("Quedan "+dias+cantDias+" para realizar pedido del despacho "+despacho['numero_despacho']+" de Campaña "+campana['numero_campana']+"/"+campana['anio_campana']);

              // notificA = "<li><a style='color:#222'><i class='fa fa-user text-aqua'></i> "; 
              notificA = "<li style='background:#FFF;padding:10px;'><a style='color:#222;background:#ddd'><i style='font-size:1.5em;color:#EA018C' class='fa fa-user text-danger' ></i> "; 
              notificF = "</a></li>";
              html += notificA;
              // html += "<span style='font-size:0.9em;position:relative;float:right;'>"+campana['numero_campana']+"/"+campana['anio_campana']+"</span>";
              html += "<b style='margin-left:0px;'>Saludos "+"<?=$_SESSION['cuenta']['primer_nombre'].' '.$_SESSION['cuenta']['primer_apellido']?>"+"</b> <br>";
              
              // html += "A la fecha ''<?php echo date('d-m-Y'); ?>''<br>Tiene desde la fecha <b><u>"+d1+"-"+m1+"-"+y1+"</u></b><br>Hasta la fecha <b><u>"+d2+"-"+m2+"-"+y2+"</u></b><br>para reportar los desperfectos <br> presentados en sus Productos";
              
              html += "A la fecha ''<?php echo date('d-m-Y'); ?>'' tiene <br>desde el <b><u>"+d1+" de "+m1+" del "+y1+"</u></b><br>Hasta el <b><u>"+d2+" de "+m2+" del "+y2+"</u></b><br>para reportar los desperfectos <br> presentados en sus Productos";


              html += notificF;
              html += $(".menu_informaciones").html();
              $(".menu_informaciones").html(html);
          }else{
            // $(".menu_informaciones").html("<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>");
            var html = $(".menu_informaciones").html();
            html += "<li><a style='color:#222'>No tiene Informaciones sobre <br>Desperfectos</a></li>";
            $(".menu_informaciones").html(html);
          }

        }else{ // No hay ninguna fecha limite cerca
              
          // $(".menu_informaciones").html("<li><a style='color:#222'>No tiene Informaciones sobre seleccion<br> de planes</a></li>");
          var html = $(".menu_informaciones").html();
          html += "<li><a style='color:#222'>No tiene Informaciones sobre <br>Desperfectos</a></li>";
          $(".menu_informaciones").html(html);
        }

      }else{

      }
              //   notificA = "<li><a href='#'><i class='fa fa-user text-aqua'></i> "; 

              // notificF = "</a></li>";
              // html += notificA;
              // html += "<span style='font-size:0.8em;position:relative;float:right;'>"+dataJson[i].fecha_aprobado+" / "+dataJson[i].hora_aprobado+"</span>";
              // html += "<b style='margin-left:-10px;'>Saludos "+dataJson[i].primer_nombre+"</b> <br>";
              // html += "Tu pedido fue aprobado con <br> una cantidad de " + dataJson[i].cantidad_aprobado + " colecciones";
              // html += notificF;

              // $(".menu_notificaciones").append(html);
      // setTimeout("verPedidoPendiente()",3600000);
    }
  }); 
}
function actualizarGemasFacturaPedidosD(){
  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarActualizarGemasFacturaPedidosDispo: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);
      console.log(respuesta);
    }
  });
}
function actualizarGemasFacturaPedidosB(){
  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      verificarActualizarGemasFacturaPedidosBloq: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);
      console.log(respuesta);
    }
  });
}

function calendarioVerificarDia(){
  $.ajax({
    url: '?route=Notificaciones&action=Generar',
    type: 'POST',
    data: {
      calendarioVerificarDia: "openorclose",
    },
    success: function(respuesta){
      // alert(respuesta);
      // console.log(respuesta);
    }
  });
}

</script>
<style>
th{text-align:center;} 

@media screen and (max-width:780px){
  tbody,table{font-size:0.89em} 
  .contenido{font-size:1.4em}
  .contenido2{font-size:1.1em}
  th{font-size:65%}
  .xs-none{display: none};
}
/*@media screen and (max-width:480px){
  tbody,table{font-size:75%;} 
  .contenido{font-size:160%}
  th{font-size:65%}
}*/
</style>
<script>
$(document).ready(function(){

console.clear();
});
</script>