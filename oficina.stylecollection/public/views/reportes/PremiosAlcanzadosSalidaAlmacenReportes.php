<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>
  <script src="public/vendor/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="public/vendor/plugins/select2/js/select2.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      // $("body").hide("500");
      $('.select2').select2();
    });
  </script>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Alcanzados";} echo " "; ?></li>
      </ol>
    </section>
          <br>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }

        ?>




        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Reporte de <?php echo "Premios Alcanzados por Líderes"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" role="form" class="form_register">




              <!-- BUSQUEDA GUARDADA -->
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <?php
                      $name_reporte = $_GET['action'];
                      $rutaURL = $_SERVER['QUERY_STRING'];
                      $campanasAbiertas = $lider->consultarQuery("SELECT * FROM campanas WHERE estado_campana=1 and estatus=1");
                      $stringIdCampanas = "";
                      $limiteCampanasAbiertas=count($campanasAbiertas)-1;
                      $indexCampAbiertas=1;
                      foreach ($campanasAbiertas as $camps) {
                        if(!empty($camps['id_campana'])){
                          $stringIdCampanas.=$camps['id_campana'];
                          if($indexCampAbiertas<$limiteCampanasAbiertas){
                            $stringIdCampanas.=", ";
                          }
                          $indexCampAbiertas++;
                        }
                      }
                      $busquedasG = $lider->consultarQuery("SELECT * FROM historial_busqueda_reportes WHERE historial_busqueda_reportes.name_reporte='{$name_reporte}' and historial_busqueda_reportes.id_campana IN ({$stringIdCampanas})");
                      // foreach ($busquedasG as $busqGuardada) {
                      //   if(!empty($busqGuardada['id_campana'])){
                      //     print_r($busqGuardada);
                      //     echo "<br><br>";
                      //   }
                      // }
                    ?>
                    <label for="busquedasguardadas">Busquedas Guardadas</label>
                    <select class="form-control select2" id="busquedasguardadas">
                      <option value=""></option>
                      <?php
                        foreach ($busquedasG as $busqGuardada) {
                          if(!empty($busqGuardada['id_campana'])){
                            ?>
                            <option <?php if($rutaURL==$busqGuardada['rutaURL']){ echo "selected"; } ?> value="<?=$busqGuardada['rutaURL']; ?>"><?=$busqGuardada['fecha_guardado']." ".$busqGuardada['hora_guardado']." - Ruta ".$busqGuardada['nombre_ruta']; ?></option>
                            <?php
                          }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-xs-12">
                    <span class="btn enviar2 cargarBusqueda">Cargar busqueda</span>
                  </div>
                </div>
                <hr>
              </div>
              <!-- BUSQUEDA GUARDADA -->





              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-12">
                      <?php 
                        $campanasDespachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;");  
                      ?>
                        <input type="hidden" name="route" value="Reportes">
                        <input type="hidden" name="action" value="PremiosAlcanzadosSalidaAlmacen">

                        <label for="selectedPedido"><b style="color:#000;">Seleccionar Pedido de Campaña</b></label>
                        <select id="selectedPedido" name="P" class="form-control select2" style="width:100%;">
                            <option value="0"></option>
                              <?php 
                                if(count($campanasDespachos)>1){
                                  foreach ($campanasDespachos as $key) {
                                    if(!empty($key['id_campana'])){                        
                                      ?>
                                      <option 
                                            value="<?=$key['id_despacho']?>" 
                                            <?php if(!empty($id_despacho)){if($key['id_despacho']==$id_despacho){echo "selected='1'";}} ?>    >
                                        <?php
                                          $ndp = "";
                                          if($key['numero_despacho']=="1"){ $ndp = "1er"; }
                                          if($key['numero_despacho']=="2"){ $ndp = "2do"; }
                                          if($key['numero_despacho']=="3"){ $ndp = "3er"; }
                                          if($key['numero_despacho']=="4"){ $ndp = "4to"; }
                                          if($key['numero_despacho']=="5"){ $ndp = "5to"; }
                                          if($key['numero_despacho']=="6"){ $ndp = "6to"; }
                                          if($key['numero_despacho']=="7"){ $ndp = "7mo"; }
                                          if($key['numero_despacho']=="8"){ $ndp = "8vo"; }
                                          if($key['numero_despacho']=="9"){ $ndp = "9no"; }
                                        ?>
                                        <?php 
                                          if($key['numero_despacho']!="1"){
                                            // echo $key['numero_despacho'];
                                            echo $ndp;
                                          }
                                          echo " Pedido ";
                                          echo " de Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana'];
                                        ?>
                                      
                                      </option>
                                      <?php 

                                    }
                                  }

                                }
                              ?>
                        </select>
                        <span class="errors error_selected_pedido"></span>
                        
                    </div>
                    <div class="form-group col-sm-4">
                      <label for="conductor">Nombre del Conductor: </label>
                      <input type="text" class="form-control conductor" id="conductor" name="conductor" value="<?php if(isset($_GET['conductor'])){ echo $_GET['conductor']; } ?>" required>
                      <span class="errors error_conductor"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="cedula">Cedula del Conductor: </label>
                      <input type="text" class="form-control cedula" id="cedula" name="cedula" value="<?php if(isset($_GET['cedula'])){ echo $_GET['cedula']; } ?>" required>
                      <span class="errors error_cedula"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="tlf">Telefono del Conductor: </label>
                      <input type="text" maxlength="12" class="form-control tlf" id="tlf" name="tlf" value="<?php if(isset($_GET['tlf'])){ echo $_GET['tlf']; } ?>" required>
                      <span class="errors error_tlf"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="vehiculo">Tipo de Vehículo: </label>
                      <input type="text" class="form-control vehiculo" id="vehiculo" name="vehiculo" value="<?php if(isset($_GET['vehiculo'])){ echo $_GET['vehiculo']; } ?>" required>
                      <span class="errors error_vehiculo"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="placa">Placa del Vehículo: </label>
                      <input type="text" class="form-control placa" id="placa" name="placa" value="<?php if(isset($_GET['placa'])){ echo $_GET['placa']; } ?>" required>
                      <span class="errors error_placa"></span>
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="ruta">Nombre de la Ruta: </label>
                      <input type="text" class="form-control ruta" id="ruta" name="ruta" value="<?php if(isset($_GET['ruta'])){ echo $_GET['ruta']; } ?>" required>
                      <span class="errors error_ruta"></span>
                    </div>

                    <div class="form-group col-sm-12">
                      <label for="selectedLideres"><b style="color:#000;">Seleccionar Líderes</b></label>
                      <select id="selectedLideres" name="L[]" multiple class="form-control select2" style="width:100%;">
                        <option value="0"></option>
                          <?php 
                            if(count($lideres)>1){
                              foreach ($lideres as $key) {
                                if(!empty($key['id_cliente'])){                        
                                  ?>
                                  <option 
                                        value="<?=$key['id_cliente']?>" 
                                          <?php foreach ($clientesss as $cl){ if($cl==$key['id_cliente']){ echo "selected"; } } ?>
                                        >
                                    
                                    <?php 
                                      echo "".$key['primer_nombre']." ".$key['segundo_nombre']." ".$key['primer_apellido']." ".$key['segundo_apellido']." (".$key['cedula'].")";
                                    ?>
                                  
                                  </option>
                                  <?php 

                                }
                              }

                            }
                          ?>
                      </select>
                      <span class="errors error_selected_lider"></span>
                    </div>
                  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>
            </form>
        <?php if(!empty($_GET['P'])){ 
            ?>
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                    <br>
                    <hr style="border-bottom:1px solid #bbb">
                </div>
              </div>
            </div>
            <div class="box-body"> 
              <div class="row">
                <div class="col-xs-12">
                  <div class="row">
                    <div class="col-xs-12 text-right">
                      <button class="btn enviar2 guardarUrl" value="<?php echo $_SERVER['QUERY_STRING']; ?>">Guardar Busqueda</button>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12">


                    <div class="row">
                      <div class="col-xs-10 col-xs-offset-1">
                        <h4 style="font-size:1.7em;margin:0;padding:0;">
                          <b>
                          Pedido 
                          <?php if($despachos[0]['numero_despacho']!="1"){ echo $despachos[0]['numero_despacho']; } ?>
                           de Campana 
                            <?=$despachos[0]['numero_campana']."/".$despachos[0]['anio_campana']; ?>
                          -
                            <?=$despachos[0]['nombre_campana']; ?>
                          </b>
                        </h3>
                      </div>
                    </div>
                    <br>

                    
                    <div class="row">
                      <div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-6">
                          <div class="input-group">
                              <label for="buscando">Buscar: </label>&nbsp
                              <input type="text" id="buscando">
                          </div>
                          <br>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;">
                          <?php
                            // $indexL = "";
                            // foreach ($clientesss as $key => $value){
                            //   $indexL .= "&L%5B%5D=".$value;
                            //   // echo $key."=> ".$value."<br>";
                            // }
                            // echo $indexL;
                          ?>
                          <?php
                            $indexL = "";
                            foreach ($clientesss as $key => $value){
                              $indexL .= "&L%5B%5D=".$value;
                            }
                            $routePDF = "route=".$_GET['route']."&action=Generar".substr($_SERVER['QUERY_STRING'], strpos($_SERVER['QUERY_STRING'], "action=")+strlen("action="));
                          ?>
                          <a href="?<?=$routePDF; ?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                      </div>
                    </div>
                    <table class="table text-center" id="">
                        <thead style="background:#ccc;font-size:1.05em;">
                            <tr>
                                <th style="width:10%;text-align:center;">Cant. Unidades</th>
                                <th style="width:35%;text-align:left;">Descripción</th>
                                <th style="width:55%;text-align:left;" colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($facturado as $data) {
                              $conceptos = [];
                              $comparar2=mb_strtolower("premios de");
                              foreach ($data['conceptos'] as $con) {
                                $comparar1=mb_strtolower($con);
                                if(strlen(strpos($comparar1, $comparar2))>0){
                                  $con=substr($con, strlen(mb_strtolower("premios de"))+1);
                                }
                                $comparar1=mb_strtolower($con);
                                if(strlen(strpos($comparar1, $comparar2)) > 0){
                                  $con=substr($con, strlen(mb_strtolower("premios de"))+1);
                                }
                                $conceptos[count($conceptos)]=$con;
                              }
                              $conceptosNR=[];
                              foreach ($conceptos as $conc) {
                                if(empty($conceptosNR[$conc])){
                                  $conceptosNR[$conc]=$conc;
                                }
                              }
                              $limiteConceptos=count($conceptosNR);
                              $index=1;
                              $data['concepto']="";
                              foreach ($conceptosNR as $concep) {
                                $data['concepto'].=$concep;
                                if($index<$limiteConceptos){
                                  $data['concepto'].=", ";
                                }
                                $index++;
                              }
                              ?>
                              <tr style='padding:0;margin:0;'>
                                  <td style="text-align:center;"><?=$data['cantidad']; ?></td>
                                  <td style="text-align:left;"><?=$data['descripcion']; ?></td>
                                  <td style="text-align:left;"><?="Premios de ".$data['concepto']; ?></td>
                                  <td style="text-align:left;"><?="N° Doc: ".$data['id_factura']; ?></td>
                              </tr>
                              <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    
                </div>
              </div>
            </div>
        <?php } ?>
          </div>

        </div>
        <!--/.col (left) -->

        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php //require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->
<?php require_once 'public/views/assets/footered.php'; ?>

<?php if(!empty($response)){ ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php } ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
</style>
<script>
$(document).ready(function(){

  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Configuraciones";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
  }
  $(".cargarBusqueda").click(function(){
    swal.fire({
      title: "¿Desea cargar la busqueda?",
      text: "Los datos guardados de la busqueda van a precargar el formulario, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Cargar!",
      cancelButtonText: "Cancelar", 
      closeOnConfirm: true,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        var rutaURL=$("#busquedasguardadas").val();
        window.location = "?"+rutaURL;
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "#ED2A77",
        });
      }
    });
  });
  $(".guardarUrl").click(function(){
    swal.fire({ 
      title: "¿Desea guardar los datos?",
      text: "Los datos guardados podrán visualizarse mas adelante, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Guardar!",
      cancelButtonText: "Cancelar", 
      closeOnConfirm: true,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){
        var ruta = $(this).val();
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            validarData: true,
            ruta: ruta,
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados correctamente!',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "2"){
              swal.fire({
                type: 'error',
                title: '¡Error al guardar la informacion!',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "3"){
              swal.fire({
                type: 'warning',
                title: '¡Busqueda ya guardada !',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "9"){
              swal.fire({
                type: 'error',
                title: '¡Los datos ingresados estan repetidos!',
                confirmButtonColor: "#ED2A77",
              });
            }
            if (respuesta == "5"){ 
              swal.fire({
                type: 'error',
                title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                confirmButtonColor: "#ED2A77",
              });
            }
          }
        });
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "#ED2A77",
        });
      }
    });
  });
    
  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");

      swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);

  $("#buscando").keyup(function(){
    $(".elementTR").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".elementTR:not(:contains('"+buscar+"'))").hide();
    }
  });
});

function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var selected = parseInt($("#selectedPedido").val());
  var rselected = false;
  if(selected > 0){
    rselected = true;
    $(".error_selected_pedido").html("");
  }else{
    rselected = false;
    $(".error_selected_pedido").html("Debe Seleccionar un Pedido");      
  }
  /*===================================================================*/

  
  /*===================================================================*/
  var conductor = $("#conductor").val();
  var rconductor = false;
  if(conductor!=""){
    rconductor=true;
    $(".error_conductor").html("");
  }else{
    $(".error_conductor").html("Ingrese la información del conductor");
    rconductor=false;
  }

  var cedula = $("#cedula").val();
  var rcedula = false;
  if(cedula!=""){
    rcedula=true;
    $(".error_cedula").html("");
  }else{
    $(".error_cedula").html("Ingrese la cedula del conductor");
    rcedula=false;
  }

  var tlf = $("#tlf").val();
  var rtlf = false;
  if(tlf!=""){
    rtlf=true;
    $(".error_tlf").html("");
  }else{
    $(".error_tlf").html("Ingrese el telefono del conductor");
    rtlf=false;
  }


  var vehiculo = $("#vehiculo").val();
  var rvehiculo = false;
  if(vehiculo!=""){
    rvehiculo=true;
    $(".error_vehiculo").html("");
  }else{
    $(".error_vehiculo").html("Ingrese la información del vehículo");
    rvehiculo=false;
  }


  var placa = $("#placa").val();
  var rplaca = false;
  if(placa!=""){
    rplaca=true;
    $(".error_placa").html("");
  }else{
    $(".error_placa").html("Ingrese la placa del vehículo");
    rplaca=false;
  }

  var ruta = $("#ruta").val();
  var rruta = false;
  if(ruta!=""){
    rruta=true;
    $(".error_ruta").html("");
  }else{
    $(".error_ruta").html("Ingrese la ruta del recorrido");
    rruta=false;
  }


  /*===================================================================*/
  var lideres = parseInt($("#selectedLideres").val());
  var rlideres = false;
  if(lideres > 0){
    rlideres = true;
    $(".error_selected_lider").html("");
  }else{
    rlideres = false;
    $(".error_selected_lider").html("Debe Seleccionar un Líder");      
  }
  /*===================================================================*/

  /*===================================================================*/

  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //     $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //   $("#error_cantidad").html("");
  // }


  /*===================================================================*/
  var result = false;
  if( rselected==true && rconductor==true && rcedula==true && rtlf==true && rvehiculo==true && rplaca==true && rruta==true && rlideres==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  // alert(result);
  return result;
}

</script>
</body>
</html>
