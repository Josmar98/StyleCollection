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
        <?php echo "Factura personalizada"; ?>
        <small><?php if(!empty($action)){echo "Modificar Factura personalizada";} echo " "; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Factura"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "Modificar ";} echo " Factura personalizada"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu3 ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Factura personalizada"; ?></a></div>
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
              <h3 class="box-title">Modificar <?php echo "Factura personalizada"; ?></h3>
            </div>
            <div class="box-body row">
              <div class="col-xs-12" style="">
                <form action="" method="get" class="form form_select_cantidad">
                  <label for="cant">Escoja la cantidad de registros</label>
                  <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                  <input type="hidden" value="<?=$numero_campana;?>" name="n">
                  <input type="hidden" value="<?=$anio_campana;?>" name="y">
                  <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                  <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                  <input type="hidden" value="<?=$_GET['route']; ?>" name="route">
                  <input type="hidden" value="<?=$_GET['action']; ?>" name="action">
                  <input type="hidden" value="<?=$_GET['id']; ?>" name="id">
                  <?php 
                    $cantRegistros = $nx;
                    if (!empty($_GET['cant'])){
                      $cantRegistros = $_GET['cant'];
                    }
                  ?>
                  <input type="number" class="form-control" value="<?=$cantRegistros; ?>" id="cant" name="cant">
                </form>
                <button class="btn enviar2 cargarCantidad">Cargar</button>
              </div>
            </div>
            <form action="" method="post" class="form table-responsive">
              <div class="box-body ">
                <input type="hidden" value="<?=$cantRegistros; ?>" name="cantidadRegistros">
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-4">
                      <label for="num_factura">Numero de Factura</label>
                      <input type="number" class="form-control" id="num_factura" name="num_factura" <?php if(!empty($_SESSION['cargaTempFactPersonalizadaMod']['numero_factura'])){ ?> value="<?=$_SESSION['cargaTempFactPersonalizadaMod']['numero_factura']; ?>" <?php } ?>>
                      <span id="error_num_factura" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="control1">Numero de control #1</label>
                       <input type="number" class="form-control" id="control1" name="control1" <?php if(!empty($_SESSION['cargaTempFactPersonalizadaMod']['numero_control'])){ ?> value="<?=$_SESSION['cargaTempFactPersonalizadaMod']['numero_control']; ?>" <?php } ?>>
                       <span id="error_control1" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                      <label for="lider">Seleccione al Lider</label>
                      <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                        <option></option>
                          <?php foreach ($lideres as $data): ?>
                            <?php if (!empty($data['id_cliente'])): ?>
                              <?php
                                if($accesoBloqueo=="1"){
                                  if(!empty($accesosEstructuras)){
                                    foreach ($accesosEstructuras as $struct) {
                                      if(!empty($struct['id_cliente'])){
                                        if($struct['id_cliente']==$data['id_cliente']){
                                            ?>
                                          <option <?php if (!empty($_SESSION['cargaTempFactPersonalizadaMod']['id_cliente'])){ if($data['id_cliente']==$_SESSION['cargaTempFactPersonalizadaMod']['id_cliente']){ ?> selected="selected" <?php } } ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                            <?php 
                                        }
                                      }
                                    }
                                  }
                                }else if($accesoBloqueo=="0"){
                                    ?>
                                  <option <?php if (!empty($_SESSION['cargaTempFactPersonalizadaMod']['id_cliente'])){ if($data['id_cliente']==$_SESSION['cargaTempFactPersonalizadaMod']['id_cliente']){ ?> selected="selected" <?php } } ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                    <?php
                                }
                              ?>
                            <?php endif ?>
                          <?php endforeach ?>
                      </select>
                      <span id="error_lider" class="errors"></span>
                    </div>
                  </div>

                  <input type="hidden" class="form-control" id="forma" name="forma" value="Crédito">
                    
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="lugar">Lugar de Emisión #1</label>
                       <input type="text" class="form-control" id="lugar" name="lugar" <?php if(!empty($_SESSION['cargaTempFactPersonalizadaMod']['lugar'])){ ?> value="<?=$_SESSION['cargaTempFactPersonalizadaMod']['lugar']; ?>" <?php } else { ?> value="Barquisimeto" <?php } ?>>
                       <span id="error_lugar" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="fecha1">Emision de Factura</label>
                       <input type="date" class="form-control" id="fecha1" name="fecha1" <?php if(!empty($_SESSION['cargaTempFactPersonalizadaMod']['emision'])){ ?> value="<?=$_SESSION['cargaTempFactPersonalizadaMod']['emision']; ?>" <?php } else { ?> value="<?=date('Y-m-d'); ?>" <?php } ?>>
                       <span id="error_fecha1" class="errors"></span>
                    </div>
                    
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="fecha2">Vencimiento de Factura</label>
                       <input type="date" class="form-control" id="fecha2" name="fecha2" min="<?php echo date('Y-m-d'); ?>" <?php if(!empty($_SESSION['cargaTempFactPersonalizadaMod']['fecha_vencimiento'])){ ?> value="<?=$_SESSION['cargaTempFactPersonalizadaMod']['fecha_vencimiento']; ?>" <?php } ?>>
                       <span id="error_fecha2" class="errors"></span>
                    </div>
                  </div>

               
                <div class="">
                  <div class="col-xs-12">
                    <span><b style="color:<?=$fucsia; ?>;">Nota:</b> <b>Deberá llenar todas las opciones del renglón, pidiendo omitir únicamente el concepto, de lo contrario no se guardará el registro.</b></span>
                    <div class="table-responsive">
                      <table class="table table-bordered text-left table-striped table-hover" id="">
                        <thead style="background:#DDD;font-size:1.05em;">
                          <tr>
                            <th style="text-align:center;width:8%;">Cantidad</th>
                            <th style="text-align:center;width:14%;">Tipo de Premio</th>
                            <th style="text-align:left;width:33%;">Descripcion</th>
                            <th style="text-align:left;width:12%;">Precio</th>
                            <th style="text-align:left;width:35%;">Concepto</th>
                          </tr>
                          <style>
                            .col1{text-align:center;}
                            .col2{text-align:center;}
                            .col3{text-align:left;}
                            .col4{text-align:left;}
                          </style>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i < $cantRegistros; $i++){ ?>
                            <?php
                              $cantidadTemp = "";
                              $tipoTemp = "";
                              $productoTemp = "";
                              $premioTemp = "";
                              $precioTemp = "";
                              $conceptoTemp = "";
                              $opcionTemp = "";
                              if(!empty($_SESSION['cargaTempFactPersonalizadaMod'])){
                                $sessionTemp = $_SESSION['cargaTempFactPersonalizadaMod'];
                                if(!empty($sessionTemp['cantidades'])){
                                  $cantidadT = $sessionTemp['cantidades'];
                                  if(!empty($cantidadT[$i])){
                                    $cantidadTemp=$cantidadT[$i];
                                  }
                                }
                                if(!empty($sessionTemp['tipos'])){
                                  $tiposT = $sessionTemp['tipos'];
                                  if(!empty($tiposT[$i])){
                                    $tipoTemp=$tiposT[$i];
                                  }
                                }
                                if(!empty($sessionTemp['productos'])){
                                  $prodT = $sessionTemp['productos'];
                                  if(!empty($prodT[$i])){
                                    $productoTemp=$prodT[$i];
                                  }
                                }
                                if(!empty($sessionTemp['premios'])){
                                  $premT = $sessionTemp['premios'];
                                  if(!empty($premT[$i])){
                                    $premioTemp=$premT[$i];
                                  }
                                }
                                if(!empty($sessionTemp['precios'])){
                                  $preciT = $sessionTemp['precios'];
                                  if(isset($preciT[$i])){
                                    $precioTemp=$preciT[$i];
                                  }
                                }
                                if(!empty($sessionTemp['conceptos'])){
                                  $concepT = $sessionTemp['conceptos'];
                                  if(!empty($concepT[$i])){
                                    $conceptoTemp=$concepT[$i];
                                  }
                                }
                              }
                            ?>
                            <tr class="codigo<?=$i; ?>">
                              <td class="col1">
                                <input type="number" class="form-control cantidades cantidad<?=$i; ?> texts<?=$i; ?>" name="cantidades[]" <?php if(!empty($cantidadTemp) && $cantidadTemp!=""){ ?> value="<?=$cantidadTemp; ?>" <?php } ?>>
                              </td>
                              <td class="col2">
                                <select class="form-control tipos tipo<?=$i; ?> texts<?=$i; ?>" id="<?=$i; ?>" name="tipos[]">
                                  <option value=""></option>
                                  <option <?php if(!empty($tipoTemp) && $tipoTemp!=""){ if($tipoTemp=="Productos"){ ?> selected <?php } } ?>>Productos</option>
                                  <option <?php if(!empty($tipoTemp) && $tipoTemp!=""){ if($tipoTemp=="Premios"){ ?> selected <?php } } ?>>Premios</option>
                                </select>
                              </td>
                              <td class="col3">
                                <input type="text" class="form-control idss ids<?=$i; ?> textsV<?=$i; ?> <?php if($tipoTemp==""){}else{ echo "d-none"; } ?>" name="ids[]" readonly>
                                  
                                <div class="box-productos box-producto<?=$i; ?> <?php if($tipoTemp=="Productos"){}else{ echo "d-none"; } ?>">
                                  <select class="form-control select2 productos producto<?=$i; ?> textsOp<?=$i; ?>" style="width:100%;" name="productos[]" >
                                    <option value=""></option>
                                    <?php foreach ($productos as $prod){ ?>
                                      <option <?php if($prod['id_producto']==$productoTemp){ echo "selected"; } ?> value="<?=$prod['id_producto']; ?>"><?=$prod['producto']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>

                                <div class="box-premios box-premio<?=$i; ?> <?php if($tipoTemp=="Premios"){}else{ echo "d-none"; } ?>">
                                  <select class="form-control select2 premios premio<?=$i; ?> textsOp<?=$i; ?>" style="width:100%;" name="premios[]">
                                    <option value=""></option>
                                    <?php foreach ($premios as $prem){ ?>
                                      <option <?php if($prem['id_premio']==$premioTemp){ echo "selected"; } ?> value="<?=$prem['id_premio']; ?>"><?=$prem['nombre_premio']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </td>
                              <td class="col4">
                                  <input type="number" class="form-control precios precio<?=$i; ?> texts<?=$i; ?>" name="precios[]" <?php if(!empty($precioTemp) && $precioTemp!=""){ ?> value="<?=$precioTemp; ?>" <?php } ?>>
                                </td>
                              <td class="col5">
                                <input type="text" class="form-control conceptos concepto<?=$i; ?> texts<?=$i; ?>" name="conceptos[]"  <?php if(!empty($conceptoTemp) && $conceptoTemp!=""){ ?> value="<?=$conceptoTemp; ?>" <?php } ?> maxlength="250">
                              </td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <span type="submit" class="btn enviar">Enviar</span>
                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>
            </form>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:hidden;
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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=FacturaPersonalizada";
        window.location.href=menu;
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
  
  // $(".productos").hide();
  // $(".premios").hide();

  $(".selectLider").change(function(){
    var select = $(this).val();
    // alert(select);
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".tipos").change(function(){
    var id = $(this).attr("id");
    var val = $(this).val();
    $(".ids"+id).hide();
    $(".box-producto"+id).hide();
    $(".box-premio"+id).hide();
    if(val==""){
      $(".ids"+id).show();
    }
    if(val=="Productos"){
      $(".box-producto"+id).show();
    }
    if(val=="Premios"){
      $(".box-premio"+id).show();
    }
  });
  $(".cargarCantidad").click(function(){
    console.clear();
    var cant = $("#cant").val();
    var cantDefault = 5;
    if(cant==""){
      $("#cant").val(cantDefault);
    }
    cant = $("#cant").val();
    var cantidades = Array();
    var tipos = Array();
    var productos = Array();
    var premios = Array();
    var precios = Array();
    var conceptos = Array();
    for (var i = 0; i < cant; i++) {
      cantidades[i] = $(".cantidad"+i).val();
      tipos[i] = $(".tipo"+i).val();
      productos[i] = $(".producto"+i).val();
      premios[i] = $(".premio"+i).val();
      precios[i] = $(".precio"+i).val();
      conceptos[i] = $(".concepto"+i).val();
    }
    $.ajax({
      url: "",
      type: "POST",
      data: {
        refrescandoCantidades: true,
        cantidades: cantidades,
        tipos: tipos,
        productos: productos,
        premios: premios,
        precios: precios,
        conceptos: conceptos,
      },
      success: function(response){
        if(response=="1"){
          $(".form_select_cantidad").submit();
        }
      }
    });
    // alert(cantidades);
    // console.log(cantidades);
  });

  var cant = $("#cant").val();
  var cantDefault = 5;
  if(cant==""){
    $("#cant").val(cantDefault);
  }
  cant = $("#cant").val();
  for (var i = 0; i < cant; i++) {
    var cod = i;
    var val = $(".opcion"+cod).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
      $(".texts"+cod).attr("style", "");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
      $(".texts"+cod).attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
    }
  }

  $(".opciones").change(function(){
    var cod = $(this).attr("id");
    var val = $(this).val();
    if(val == "Y"){
      $(".codigo"+cod).attr("style", "");
      $(".texts"+cod).attr("style", "");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "");
    }
    if(val == "N"){
      $(".codigo"+cod).attr("style", "color:#DDD;");
      $(".texts"+cod).attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-producto"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
      $(".box-premio"+cod+" span.select2 span.selection span.select2-selection span.select2-selection__rendered").attr("style", "color:#DDD;background:#FEFEFE;");
    }
  });

  $(".enviar").click(function(){
    var response = validar();
    var response = true;

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


  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            window.location = $(this).val();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
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
