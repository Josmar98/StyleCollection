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
        <?php echo $modulo; ?>
        <small><?php echo $modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> <?=$modulo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      

      <div class="row">

        <?php
          // $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          // $accesoBloqueo = "0";
          // $superAnalistaBloqueo="1";
          // $analistaBloqueo="1";
          // foreach ($configuraciones as $config) {
          //   if(!empty($config['id_configuracion'])){
          //     if($config['clausula']=='Analistabloqueolideres'){
          //       $analistaBloqueo = $config['valor'];
          //     }
          //     if($config['clausula']=='Superanalistabloqueolideres'){
          //       $superAnalistaBloqueo = $config['valor'];
          //     }
          //   }
          // }
          // if($_SESSION['home']['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          // if($_SESSION['home']['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          // if($accesoBloqueo=="0"){
          //   // echo "Acceso Abierto";
          // }
          // if($accesoBloqueo=="1"){
          //   // echo "Acceso Restringido";
          // }

        ?>

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Catalogo - Ciclo ".$num_ciclo."/".$ano_ciclo; ?></h3>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <div class="row" style="text-align:right;margin-right:10px;">
                <div class="col-xs-12">
                  <a href="?<?=$menu; ?>&route=Cart<?=$addUrlAdmin; ?>" class="dropdown-toggle box_notificaciones" style="" >
                    <i class="glyphicon glyphicon-shopping-cart" style="font-size:1.2em"></i>
                    <span class="label cantidad_carrito <?=$classHidden; ?>" style="background:#00000022;border-radius:10px;font-size:1em;position:relative;top:-10px;right:0px;"><?=$cantidadCarrito; ?></span>
                  </a>
                </div>
              </div>
              <br>

              <?php 
                if($accesoPedidosClienteR){
                  if($addUrlAdmin != ""){
                    ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <form action="">
                          <input type="hidden" name="c" value="<?=$_GET['c'] ?>">
                          <input type="hidden" name="n" value="<?=$_GET['n'] ?>">
                          <input type="hidden" name="y" value="<?=$_GET['y'] ?>">
                          <input type="hidden" name="route" value="<?=$_GET['route'] ?>">
                          <input type="hidden" name="action" value="<?=$_GET['action'] ?>">
                          <input type="hidden" name="admin" value="<?=$_GET['admin'] ?>">
                          <select class="form-control select2" style="width:100%;" name="lider">
                            <option value="">Ningún(a) - Seleccionar</option>
                            <?php foreach ($lideres as $lid){ if(!empty($lid['id_cliente'])){ ?>
                              <?php
                              $permitido = 0;
                              if(!empty($accesosEstructuras)){
                                if(count($accesosEstructuras)>1){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$lid['id_cliente']){
                                        $permitido = 1;
                                      }
                                    }
                                  }
                                }else if($personalInterno){
                                  $permitido = 1;
                                }
                              }
                              if($permitido){
                              ?>
                            <option value="<?=$lid['id_cliente']; ?>" <?php if(!empty($_GET['lider']) && $_GET['lider']==$lid['id_cliente']){ echo "selected"; } ?>><?=$lid['primer_nombre']." ".$lid['primer_apellido']." ".$lid['cedula']; ?></option>
                            <?php } } } ?>
                          </select>
                          <button class="btn enviar2">Seleccionar Lider</button>
                        </form>
                      </div>
                    </div>
                    <?php
                  }
                }
              ?>
              <div class="row">
                <br>
                <div class="col-xs-12" style="padding:0px 25px;">
                  <label>Buscar:</label>
                  <input type="text" class="form-control buscar" name="">
                </div>
                <br>
                <?php foreach ($catalogos as $cat){ if(!empty($cat['cod_inventario'])){ ?>
                  <div class="boxCatalogo col-xs-6 col-sm-4 col-md-3" style="padding:10px 25px;box-sizing:border-box;">
                    <div style="background:;text-align:center;">
                      <a href="?<?=$menu; ?>&route=Pedidos&action=Detalles&cod=<?=$cat['cod_inventario'].$addUrlAdmin; ?>">
                        <img src="<?=$cat['imagen_inventario']; ?>" style="max-width:100%;margin-top:5%;margin-bottom:5%;">
                        <br>
                        <span style="font-size:1.2em;"><?=$cat['nombre_inventario']; ?></span>
                        <br>
                        <span style="color:#555;"><?="$".number_format($cat['precio_inventario'],2,',','.'); ?></span>
                      </a>
                      <!-- <br>
                      <div class="input-group" style="max-width:100%;">
                        <span id="<?=$cat['cod_inventario']; ?>" class="Menoss input-group-addon btn" style="width:25%;">-</span>
                        <input type="number" step="1" min="1" value="1" id="val<?=$cat['cod_inventario']; ?>" style="text-align:center;" class="form-control valuesCant">
                        <span id="<?=$cat['cod_inventario']; ?>" class="Mass input-group-addon btn" style="width:25%;">+</span>
                      </div>
                      <span class="btn enviar" style="width:100%;margin-top:10px;">Agregar al carrito</span> -->
                    </div>
                  </div>
                <?php } } ?>
              </div>
              <br><br>
            </div>
            <!-- /.box-body -->
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

<?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
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
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  }
  $(".Mass").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($("#val"+cod).val());
    $("#val"+cod).val(val+1);
  });
  $(".Menoss").click(function(){
    var cod = $(this).attr("id");
    var val = parseInt($("#val"+cod).val());
    if( (val-1)>0 ){
      $("#val"+cod).val(val-1);
    }
  });
  $('.valuesCant').on('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  $(".buscar").keyup(function(){
    $(".boxCatalogo").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".boxCatalogo:not(:contains('"+buscar+"'))").hide();
    }
  });
});  
</script>
</body>
</html>
