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
        <?php echo "Movimientos"; ?>
        <small><?php echo "Ver Filtro de Movimientos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Home" ?>"><?php echo "Inicio"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Movimientos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "Filtro de Movimientos";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=Movimientos&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Movimientos</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box"> 

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "Filtro de Movimientos Bancarios"; ?></a></h3>
              
                <?php //if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <br><br>

                <style>
                    .text-xs {
                      text-align:center;
                    }
                  @media (max-width: 768px) {
                    .text-xs {
                      text-align:right !important;
                    }
                  }
                </style>

                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                </div>
                <br>
                <div class="row">

                  <div class="form-group col-xs-12">
                    <label for="banco">Seleccione al banco</label>
                    <select class="form-control select2 selectbanco" id="banco" name="Banco" style="width:100%;">
                      <option></option>
                      <?php foreach ($bancos as $data): ?>
                        <?php if (!empty($data['id_banco'])): ?>
                        <option <?php if (!empty($_GET['Banco'])): if($data['id_banco']==$_GET['Banco']): ?>
                            selected="selected"
                        <?php endif; endif; ?> value="<?=$data['id_banco']?>"><?=$data['nombre_banco']." - ".$data['nombre_propietario']." ".$data['cedula_cuenta']." (Cuenta ".$data['tipo_cuenta'].")";?></option>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                  </div>

                </div>
                <hr>
                <div class="row">
                      <div class="col-xs-12" style="text-align:center;margin-bottom:15px">
                        <a style="color:#FFF;border-radius:7px !important" class="btn enviar2 FiltroMovimientos"><b><u>Filtrar Movimientos Bancarios<u></b></a>
                      </div>
           
                </div>

              <hr>
            </div>

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
</style>

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<!-- 
  fa-calendar-times-o
  fa-calendar-check-o
-->
<script>
function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?route=Movimientoss";
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

  
  $(".FiltroMovimientos").click(function(){
    var ruta = "Movimientos";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var banco = $("#banco").val();

    var menuInicial = "route="+ruta;
    var menuFinal = "route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }
    if(menuInicial != menuFinal){
      swal.fire({ 
        title: "¿Filtrar Movimientos Bancarios?",
        text: "Se Buscaran los movimientos con las opciones seleccionadas, ¿Desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "#ED2A77",
        confirmButtonText: "Buscar",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
      }).then((isConfirm) => {
        if (isConfirm.value){            
          // window.location = $(this).val();
          location.href = "?"+menuFinal;
        }else { 
          swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "#ED2A77",
          });
        } 
      });
    }else{
      swal.fire({
          type: 'warning',
          title: '¡Debe seleccionar alguna opción para filtrar!',
          confirmButtonColor: "#ED2A77",
      });
    }
  });

  // DivisasFitro
  // BancariosFiltro
  // PagosFiltro

});  
</script>
</body>
</html>
