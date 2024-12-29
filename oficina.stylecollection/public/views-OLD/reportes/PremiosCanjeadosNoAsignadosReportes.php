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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo "Premios Canjeados";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Premios Canjeados";} echo " "; ?></li>
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
              <h3 class="box-title">Reporte de <?php echo "Premios Canjeados No Asignados"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-12">
                      <label for="tipoElemento"><b style="color:#000;">Seleccionar Tipo de Elemento del catálogo</b></label>
                      <select id="tipoElemento" class="form-control select2" style="width:100%;">
                        <option value="0"></option>
                        <option <?php if (isset($_GET['T']) && $_GET['T']=="1"): ?> selected <?php endif; ?> value="1">Cantidad de Gemas del catálogo</option>
                        <option <?php if (isset($_GET['T']) && $_GET['T']=="2"): ?> selected <?php endif; ?> value="2">Premios del catálogo</option>
                      </select>
                      <span class="errors error_tipoElemento"></span>
                    </div>

                    
                  <form action="" method="get" role="form" class="form_register formgemasCatalogo">
                    <input type="hidden" name="route" value="Reportes">
                    <input type="hidden" name="action" value="PremiosCanjeadosNoAsignados">
                    <input type="hidden" name="T" value="1">
                    <div class="form-group col-sm-12 boxgemasCatalogo" <?php if (( isset($_GET['T']) && $_GET['T']!="1" ) || ( empty($_GET['T']) )): ?> style="display:none;" <?php endif; ?> >
                        <label for="gemasCatalogo"><b style="color:#000;">Cantidad de Gemas del catálogo </b></label>
                        <select id="gemasCatalogo" name="C" class="form-control select2" style="width:100%;">
                            <option value="0" id="C0">Todas</option>
                            <?php  if(count($gemasCatalogo)>1){ foreach ($gemasCatalogo as $key) { if(!empty($key['cantidad_gemas'])){ ?>
                            <option value="<?=$key['cantidad_gemas']?>" 
                              <?php if(!empty($_GET['C'])){if($key['cantidad_gemas']==$_GET['C']){echo "selected='1'";}} ?> >
                              <?php 
                                if($key['cantidad_gemas']=="1"){ $str = " Gema"; }else{ $str = " Gemas"; }
                                echo $key['cantidad_gemas'].$str;
                              ?>
                            </option>
                            <?php } } } ?>
                        </select>
                        <span class="errors error_gemasCatalogo"></span>
                    </div>
                  </form>

                  <form action="" method="get" role="form" class="form_register formelementosCatalogo">
                    <input type="hidden" name="route" value="Reportes">
                    <input type="hidden" name="action" value="PremiosCanjeadosNoAsignados">
                    <input type="hidden" name="T" value="2">
                    <div class="form-group col-sm-12 boxelementosCatalogo" <?php if (( isset($_GET['T']) && $_GET['T']!="2" ) || ( empty($_GET['T']) )): ?> style="display:none;" <?php endif; ?> >
                        <label for="elementosCatalogo"><b style="color:#000;">Premios del catálogo </b></label>
                        <select id="elementosCatalogo" name="ID" class="form-control select2" style="width:100%;">
                            <option value="0" id="ID0">Todas</option>
                            <?php if(count($elementosCatalogo)>1){ foreach ($elementosCatalogo as $key) { if(!empty($key['nombre_catalogo'])){ ?>
                            <option value="<?=$key['id_catalogo']?>" 
                              <?php if(!empty($_GET['ID'])){if($key['id_catalogo']==$_GET['ID']){echo "selected='1'";}} ?> >
                              <?php echo $key['nombre_catalogo'];?>
                            </option>
                            <?php } } } ?>
                        </select>
                        <span class="errors error_elementosCatalogo"></span>
                    </div>
                  </form>


              
                  </div>
                  
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>


        <?php if(isset($_GET['C']) || isset($_GET['ID'])){ ?>
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
                      <div class="col-xs-10 col-xs-offset-1">
                        <h4 style="font-size:1.7em;margin:0;padding:0;">
                          <b>
                          <?php if (!empty($despachos)): ?>
                            
                          Pedido 
                          <?php if($despachos[0]['numero_despacho']!="1"): echo $despachos[0]['numero_despacho']; endif; ?>
                           de Campana 
                            <?=$despachos[0]['numero_campana']."/".$despachos[0]['anio_campana']; ?>
                          -
                            <?=$despachos[0]['nombre_campana']; ?>
                          <?php endif ?>
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
                          $rutaReporte = "?route=Reportes&action=GenerarPremiosCanjeadosNoAsignados";
                          if(!empty($_GET['T']) && isset($_GET['C'])){
                            $rutaReporte .= "&T=".$_GET['T']."&C=".$_GET['C'];
                          }
                          if(!empty($_GET['T']) && isset($_GET['ID'])){
                            $rutaReporte .= "&T=".$_GET['T']."&ID=".$_GET['ID'];
                          }
                        ?>
                          <a href="<?=$rutaReporte;?>" target="_blank"><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a>
                          <!-- <a><button class="btn" style="background:<?=$fucsia?>;color:#FFF;">Generar PDF</button></a> -->
                      </div>
                    </div>
                    <?php //if (isset($_GET['C'])): ?>
                    <table class="table table-bordered table-striped text-center" style="font-size:1.1em;">
                      <thead style="background:#ccc;font-size:1.05em;">
                        <tr>
                          <th>Nº</th>
                          <th>Lider</th>
                          <th>Premios Canjeados No Asignados</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $num = 1; ?>
                        <?php foreach ($lideres as $data): if(!empty($data['id_cliente'])): ?>
                          <?php
                            $permitido = "0";
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$data['id_cliente']){
                                      $permitido = "1";
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                              $permitido = "1";
                            }


                            if($permitido=="1"):
                          ?>
                              <?php foreach ($newData2 as $info): if (!empty($info['id_cliente'])): if($data['id_cliente']==$info['id_cliente']): ?>
                              
                              <tr class="elementTR">
                                <td><?=$num;?></td>
                                <td>
                                  <?php 
                                    echo number_format($data['cedula'],0,'','.')." ".$data['primer_nombre']." ".$data['primer_apellido'];
                                  ?>
                                </td>
                                <td style="text-align:left;">
                                  <?php
                                  $newData = [];
                                  foreach ($listado as $elemento) {
                                    if(!empty($elemento['id_cliente'])){
                                      if($elemento['id_cliente']==$data['id_cliente']){
                                        // if($elemento['estado_canjeo']!="Asignado"){

                                        if(empty($newData[$elemento['id_catalogo']]['cantidad_canjeo'])){
                                          $newData[$elemento['id_catalogo']]['cantidad_canjeo']=0;
                                        }
                                        $newData[$elemento['id_catalogo']]['id_catalogo'] = $elemento['id_catalogo'];
                                        $newData[$elemento['id_catalogo']]['nombre_catalogo'] = $elemento['nombre_catalogo'];
                                        $newData[$elemento['id_catalogo']]['cantidad_gemas'] = $elemento['cantidad_gemas'];
                                        $newData[$elemento['id_catalogo']]['marca_catalogo'] = $elemento['marca_catalogo'];
                                        $newData[$elemento['id_catalogo']]['cantidad_canjeo']++;
                                        $newDataAcum[$elemento['id_catalogo']]['cantidad']++;
                                        // }
                                      }
                                    }
                                  }
                                  
                                  foreach ($newData as $info2) {
                                    if(!empty($info2['id_catalogo'])){
                                        echo "(".$info2['cantidad_canjeo'].") &nbsp&nbsp ".$info2['nombre_catalogo']." ".$info2['marca_catalogo']."<br>";
                                    }
                                  }

                                  ?>
                                </td>
                              </tr>


                              <?php $num++; ?>
                              <?php endif; endif; endforeach; ?>

                            <?php endif; ?>
                        <?php endif; endforeach; ?>
                          <tr style="background:#eee;">
                            <td></td>
                            <td><b>Total: </b></td>
                            <td style="text-align:left;">
                              <b>
                                <?php 
                                  foreach ($newDataAcum as $key) {
                                    if($key['cantidad']>0){
                                      echo "(".$key['cantidad'].") &nbsp&nbsp".$key['nombre']." ".$key['marca']."<br>";
                                    }
                                  }
                                ?>
                              </b>
                            </td>
                          
                          </tr>
                      </tbody>
                    </table>
                    <?php //endif; ?>
                   
                      
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
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>

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
    
  $("#tipoElemento").change(function(){
    var tipo = $(this).val();
    $(".boxgemasCatalogo").slideUp(500);
    $(".boxelementosCatalogo").slideUp(500);
    $(".error_tipoElemento").html("");
    if(tipo=="1"){
      $(".boxgemasCatalogo").slideDown(500);
    }
    if(tipo=="2"){
      $(".boxelementosCatalogo").slideDown(500);
    }
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
            var tipo = $("#tipoElemento").val();
            if(tipo=="1"){
              $(".formgemasCatalogo").submit();
            }
            if(tipo=="2"){
              $(".formelementosCatalogo").submit();
            }
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
  var selected = parseInt($("#tipoElemento").val());
  var rselected = false;
  if(selected > 0){
    rselected = true;
    $(".error_tipoElemento").html("");
  }else{
    rselected = false;
    $(".error_tipoElemento").html("Debe Seleccionar un tipo de elemento");      
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
  if( rselected==true){
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
