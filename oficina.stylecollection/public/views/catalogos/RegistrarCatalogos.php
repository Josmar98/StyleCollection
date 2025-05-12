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
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $url; ?></h3>
            </div>

            <form action="" method="post" class="form_register" enctype="multipart/form-data">
                    
              <div class="box-body">

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="nombre">Nombre de premio</label>
                       <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" placeholder="Ingresar nombre del premio">
                       <span id="error_nombre" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="codigo">Codigo de premio</label>
                       <input type="text" class="form-control" id="codigo" name="codigo" maxlength="100" placeholder="Ingresar el codigo del premio">
                       <span id="error_codigo" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="marca">Marca de premio</label>
                       <input type="text" class="form-control" id="marca" name="marca" maxlength="100" placeholder="Ingresar marca del premio">
                       <span id="error_marca" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="color">Color</label>
                       <input type="text" class="form-control" id="color" name="color" maxlength="100" placeholder="Ingresar el color del premio">
                       <span id="error_color" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="voltaje">Voltaje</label>
                       <input type="text" class="form-control" id="voltaje" name="voltaje" maxlength="100" placeholder="Ingresar voltaje del premio">
                       <span id="error_voltaje" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="caracteristicas">Caracteristicas</label>
                       <input type="text" class="form-control" id="caracteristicas" name="caracteristicas" maxlength="100" placeholder="Ingresar el caracteristicas del premio">
                       <span id="error_caracteristicas" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="puestos">Puestos</label>
                       <input type="text" class="form-control" id="puestos" name="puestos" maxlength="100" placeholder="Ingresar puestos del premio">
                       <span id="error_puestos" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="otros">Otros</label>
                       <input type="text" class="form-control" id="otros" name="otros" maxlength="100" placeholder="Ingresar el otros del premio">
                       <span id="error_otros" class="errors"></span>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="cantidad">Precio en gemas</label>
                       <div class="input-group">
                        <span class="input-group-addon"><img style="width:25px" src="<?=$fotoGema?>"></span>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" step="0.01" placeholder="Ingresar el precio en gemas, Ej, 10,25">
                       </div>
                       <span id="error_cantidad" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="imagen">Imagen de premio</label>
                       <input type="file" class="form-control" id="imagen" name="imagen" maxlength="100" placeholder="Ingresar el imagen del premio">
                       <span id="error_imagen" class="errors"></span>
                    </div>
                  </div>

                  <hr>

                  <input type="hidden" id="limiteElementos" value="<?=$limiteElementos; ?>">
                  <div class="row" style="padding:0px 17px;">
                    <div style="width:20%;float:left" class=" box-inventariosProductos1 box-inventariosMercancia1 box-inventario">
                      <label>Cantidad</label>
                    </div>
                    <div style="width:80%;float:left" class=" box-inventariosProductos1 box-inventariosMercancia1 box-inventario">
                      <label>Descripcion</label>
                    </div>
                  </div>
                  <?php for($z=1; $z<=$limiteElementos; $z++){ ?>
                    <div class="row" style="padding:0px 15px;">
                      <div style="width:20%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                        <input type="number" class="form-control" id="stock<?=$z; ?>" min="0" name="stock[]" step="1" placeholder="Cantidad (150)">
                        <span id="error_stock<?=$z; ?>" class="errors"></span>
                      </div>
                      <div style="width:80%;float:left;" class=" box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>">
                        <select class="form-control select2 inventarios" id="inventario<?=$z; ?>" min="<?=$z;?>" name="inventario[]"  style="width:100%">
                          <option value=""></option>
                          <option value="-1">Servicio</option>
                          <?php foreach($productos as $inv){ if(!empty($inv['id_producto'])){ ?>
                            <option value="<?php echo $inv['id_producto']; ?>"><?php echo "(".$inv['codigo_producto'].") ".$inv['producto']."(".$inv['cantidad'].") ".$inv['marca_producto']; ?></option>
                          <?php } } ?>
                          <?php foreach($mercancia as $inv){ if(!empty($inv['id_mercancia'])){ ?>
                            <option value="m<?php echo $inv['id_mercancia']; ?>"><?php echo "(".$inv['codigo_mercancia'].") ".$inv['mercancia']."(".$inv['medidas_mercancia'].") ".$inv['marca_mercancia']; ?></option>
                          <?php } } ?>
                        </select>
                        <input type="hidden" id="tipo<?=$z; ?>" name="tipos[]">
                        <span id="error_inventario<?=$z; ?>" class="errors"></span>
                      </div>
                    </div>
                    <div style='width:100%;'>
                      <span style='float:left' id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success box-inventarios<?=$z; ?> box-inventario <?php if($z>1){ echo "d-none"; } ?>"><b>+</b></span>
                      <span style='float:right' id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger box-inventarios<?=$z; ?> box-inventario d-none"><b>-</b></span>
                    </div>
                  <?php } ?>
                  <input type="hidden" id="cantidad_elementos" name="cantidad_elementos" value="1">
                  <hr>

              </div>

              <div class="box-footer">
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
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
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.addMore, .addMenos{
  border-radius:40px;
  border:1px solid #CCC;
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
        window.location = "?route=Catalogos";
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

  $(".box-inventarios").hide();
  $(".box-inventarios").removeClass("d-none");
  $(".addMore").click(function(){
    // var id=$(this).attr('id');
    // var index=$(this).attr('min');
    alimentarFormInventario();
  });
  $(".addMenos").click(function(){
    // var id=$(this).attr('id');
    // var index=$(this).attr('min');
    retroalimentarFormInventario();
  });
  function alimentarFormInventario(){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementos").val());
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant++;
    $(`.box-inventarios${cant}`).show();
    if(cant == limite){
      $("#addMore"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  function retroalimentarFormInventario(){
    var cant = parseInt($("#cantidad_elementos").val());
    $(`.box-inventarios${cant}`).hide();
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant--;
    $("#addMore"+cant).show();
    $("#addMenos"+cant).show();
    if(cant<2){
      $("#addMenos"+cant).hide();
    }
    $("#cantidad_elementos").val(cant);
  }
  $(".inventarios").on('change', function(){
    var value = $(this).val();
    var index = $(this).attr("min");
    if(value!=""){
      if(value==-1){
        $("#tipo"+index).val('Servicio');
      }else{
        var pos = value.indexOf('m');
        if(pos>=0){ //Mercancia
          $("#tipo"+index).val('Mercancia');
        }else if(pos < 0){ //Productos
          $("#tipo"+index).val('Productos');
        }
      }
    }else{
      $("#tipo"+index).val('');
    }
  });
    
  $(".enviar").click(function(){
    var response = validar();
    // var response = true;

    if(response == true){
      $(".btn-enviar").attr("disabled");
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
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
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      nombre: $("#nombre").val(),
                      codigo: $("#codigo").val(),
                      cantidad: $("#cantidad").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
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

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern2);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre del producto no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo de nombre del producto ");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // var codigo = $("#codigo").val();
  // var rcodigo = checkInput(codigo, alfanumericPattern);
  // if( rcodigo == false ){
  //   if(codigo.length != 0){
  //     $("#error_codigo").html("La codigo de producto no debe contener caracteres especiales");
  //   }else{
  //     $("#error_codigo").html("Debe llenar una codigo para el producto");      
  //   }
  // }else{
  //   $("#error_codigo").html("");
  // }
  /*===================================================================*/
  
  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern2);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de producto no debe contener caracteres especiales");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad para el producto");      
    }
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cantidad_elementos = $("#cantidad_elementos").val();
  var rstocks = false;
  var rinventarios = false;
  if(cantidad_elementos==0){
    var rstocks = false;
    var rinventarios = false;
  }else{
    var erroresStock=0;
    var erroresInventario=0;
    for (let i=1; i<=cantidad_elementos;i++) {
      /*===================================================================*/
        var stock = $("#stock"+i).val();
        var rstock = checkInput(stock, numberPattern);
        if( rstock == false ){
          if(stock.length != 0){
            $("#error_stock"+i).html("La cantidad de unidades #"+i+" no debe contener letras o caracteres especiales");
          }else{
            $("#error_stock"+i).html("Debe llenar una cantidad de unidades #"+i);      
          }
        }else{
          $("#error_stock"+i).html("");
        }
        if(rstock==false){ erroresStock++; }
      /*===================================================================*/
      
      /*===================================================================*/
        var inventario = $("#inventario"+i).val();
        var rinventario = false;
        if(inventario==""){
          rinventario=false;
          $("#error_inventario"+i).html("Debe seleccionar un elemento del inventario #"+i);
        }else{
          rinventario=true;
          $("#error_inventario"+i).html("");
        }
        if(rinventario==false){ erroresInventario++; }
      /*===================================================================*/
    }
    
    if(erroresStock==0){ rstocks=true; }
    if(erroresInventario==0){ rinventarios=true; }
  }
  /*===================================================================*/
  
  /*===================================================================*/
  var result = false;
  // if( rnombre==true && rcodigo==true && rcantidad==true){
  if( rnombre==true && rcantidad==true && rstocks==true && rinventarios==true){
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
