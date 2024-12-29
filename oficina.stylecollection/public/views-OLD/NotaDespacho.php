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
        <?php echo "Notas de Despacho"; ?>
        <small><?php echo "Ver Notas"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Facturas de Despacho"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Factura";}else{echo "Facturas";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Nota de Despacho</a></div>
            <?php } ?>
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

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"): ?>
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        <?php endif; ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>

        
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Notas de Despacho"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Nombre y Apellido</th>
                  <th>Fecha de Facturacion</th>
                  <th>Colecciones</th>
                  <th>---</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($notass as $data):
                if(!empty($data['id_nota_despacho'])):  
            ?>
                <?php
                            if($accesoBloqueo=="1"){
                              if(!empty($accesosEstructuras)){
                                foreach ($accesosEstructuras as $struct) {
                                  if(!empty($struct['id_cliente'])){
                                    if($struct['id_cliente']==$data['id_cliente']){
                                        ?>
                                      <tr>
                                        <td style="width:5%">
                                          <span class="contenido2">
                                            <?php echo $num++; ?>
                                          </span>
                                        </td>
                                        <td style="width:10%">
                                          <?php if($estado_campana=="1"){ ?>
                                              <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?=$data['id_nota_despacho']?>">
                                                <span class="fa fa-wrench"></span>
                                              </button>
                                              <?php if ($_SESSION['nombre_rol']!="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                                <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_pedido'] ?>&permission=1">
                                                    <span class="fa fa-trash"></span>
                                                </button> -->
                                              <?php endif; ?>
                                          <?php } ?>
                                        </td>
                                        <td style="width:20%">
                                          <span class="contenido2">
                                            <?php echo  $data['primer_nombre']. " " . $data['primer_apellido']; ?>
                                            <br>
                                            <?php 
                                              $num_nota2 = $data['numero_nota'];
                                              if(strlen($num_nota2)==1){$num_nota = "00000".$num_nota2;}
                                              else if(strlen($num_nota2)==2){$num_nota = "0000".$num_nota2;}
                                              else if(strlen($num_nota2)==3){$num_nota = "000".$num_nota2;}
                                              else if(strlen($num_nota2)==4){$num_nota = "00".$num_nota2;}
                                              else if(strlen($num_nota2)==5){$num_nota = "0".$num_nota2;}
                                              else if(strlen($num_nota2)==6){$num_nota = $num_nota2;}
                                              else {$num_nota = $num_nota2;}
                                              echo $num_nota;
                                            ?>
                                          </span>
                                        </td>
                                        <td style="width:20%">
                                          <span class="contenido2">
                                            <?php echo $lider->formatFecha($data['fecha_emision']) . " -> " . $lider->formatFecha($data['fecha_vencimiento']); ?>
                                          </span>
                                        </td>
                                        <td style="width:20%">
                                          <span class="contenido2">
                                            <?php echo $data['cantidad_colecciones']. " Colecciones"; ?>
                                          </span>
                                        </td>
                        
                       
                                        <td style="width:25%">
                                          <table style="background:;text-align:center;width:100%">
                                            <tr>
                                              <td style="width:50%">
                                                  <?php 
                                                    $emision = $data['fecha_emision'];
                                                    $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision' and estatus = 1");
                                                    if(Count($tasas)>1){
                                                  ?>
                                                      <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generarbs&id=<?php echo $data['id_nota_despacho'] ?>">
                                                        Generar Factura en Bs.D.
                                                      </a> -->
                                                  <?php }else{ ?>
                                                        <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:#aaa;color:#FFF" disabled>
                                                          Generar Factura en Bs.D.
                                                        </a> -->
                                                  <?php } ?>

                                                    <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generarusd&id=<?php echo $data['id_nota_despacho'] ?>">
                                                      Generar Factura en USD.
                                                    </a> -->
                                                    <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generar&id=<?php echo $data['id_nota_despacho'] ?>">
                                                      Generar Factura
                                                    </a>
                                                  <?php 
                                                    $fiscal = $lider->consultarQuery("SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1");
                                                    if(count($fiscal)>1){

                                                  ?>
                                                    <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=GenerarFiscal&id=<?php echo $data['id_nota_despacho'] ?>">
                                                      Generar Factura Fiscal.
                                                    </a> -->
                                                  <?php } else { ?>
                                                    <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:#aaa;color:#FFF">
                                                      Generar Factura Fiscal.
                                                    </a> -->
                                                  <?php } ?>
                                                
                                              </td>
                                            </tr>
                                          </table>
                                        </td>
                                            
                                            
                                      </tr>
                                        <?php 
                                    }
                                  }
                                }
                              }
                            }else if($accesoBloqueo=="0"){
                                ?>
                              <tr>
                                <td style="width:5%">
                                  <span class="contenido2">
                                    <?php echo $num++; ?>
                                  </span>
                                </td>
                                <td style="width:10%">
                                  <?php if($estado_campana=="1"){ ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?=$data['id_nota_despacho']?>">
                                        <span class="fa fa-wrench"></span>
                                      </button>
                                      <?php if ($_SESSION['nombre_rol']!="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                        <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_pedido'] ?>&permission=1">
                                            <span class="fa fa-trash"></span>
                                        </button> -->
                                      <?php endif; ?>
                                  <?php } ?>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php echo  $data['primer_nombre']. " " . $data['primer_apellido']; ?>
                                    <br>
                                    <?php 
                                      $num_nota2 = $data['numero_nota'];
                                      if(strlen($num_nota2)==1){$num_nota = "00000".$num_nota2;}
                                      else if(strlen($num_nota2)==2){$num_nota = "0000".$num_nota2;}
                                      else if(strlen($num_nota2)==3){$num_nota = "000".$num_nota2;}
                                      else if(strlen($num_nota2)==4){$num_nota = "00".$num_nota2;}
                                      else if(strlen($num_nota2)==5){$num_nota = "0".$num_nota2;}
                                      else if(strlen($num_nota2)==6){$num_nota = $num_nota2;}
                                      else {$num_nota = $num_nota2;}
                                      echo $num_nota;
                                    ?>
                                  </span>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php echo $lider->formatFecha($data['fecha_emision']) . " -> " . $lider->formatFecha($data['fecha_vencimiento']); ?>
                                  </span>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php echo $data['cantidad_colecciones']. " Colecciones"; ?>
                                  </span>
                                </td>
                
               
                                <td style="width:25%">
                                  <table style="background:;text-align:center;width:100%">
                                    <tr>
                                      <td style="width:50%">
                                          <?php 
                                            $emision = $data['fecha_emision'];
                                            $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision' and estatus = 1");
                                            if(Count($tasas)>1){
                                          ?>
                                              <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generarbs&id=<?php echo $data['id_nota_despacho'] ?>">
                                                Generar Factura en Bs.D.
                                              </a> -->
                                          <?php }else{ ?>
                                                <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:#aaa;color:#FFF" disabled>
                                                  Generar Factura en Bs.D.
                                                </a> -->
                                          <?php } ?>

                                            <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generarusd&id=<?php echo $data['id_nota_despacho'] ?>">
                                              Generar Factura en USD.
                                            </a> -->

                                            <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Generar&id=<?php echo $data['id_nota_despacho'] ?>">
                                              Generar Factura
                                            </a>
                                          <?php 
                                            $fiscal = $lider->consultarQuery("SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1");
                                            if(count($fiscal)>1){

                                          ?>
                                            <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?php echo $color_btn_sweetalert ?>;color:#FFF" target="_blank" href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=GenerarFiscal&id=<?php echo $data['id_nota_despacho'] ?>">
                                              Generar Factura Fiscal.
                                            </a> -->
                                          <?php } else { ?>
                                            <!-- <a class="btn" style="border:1px solid #fff;border-radius:5px;background:#aaa;color:#FFF">
                                              Generar Factura Fiscal.
                                            </a> -->
                                          <?php } ?>
                                        
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                    
                                    
                              </tr>
                                <?php
                            }
                          ?>
          <?php
              endif; endforeach;
          ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Nombre y Apellido</th>
                  <th>Fecha de Facturacion</th>
                  <th>Colecciones</th>
                  <th>---</th>
                </tr>
                </tfoot>
              </table>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

              <!-- <br> -->

                            <!-- <input type="color" name=""> -->
          <?php 
            // $color[0] = "rgb(14, 216, 27)";
            // $color[1] = "rgb(216, 14, 152)";
            // $color[2] = "rgb(105, 14, 216)";
            // $color[3] = "rgb(194, 169, 46)";
            // $color[4] = "rgb(185, 182, 167)";
            // $color[5] = "rgb(140, 218, 238)";
            // $num = 0;
            // foreach ($liderazgos as $data):
            //   if(!empty($data['id_liderazgo'])):
          ?>
              <!-- <div style="border:1px solid #000;background: <?php echo $color[$num] ?>; width: <?php echo ($data['total_descuento'] * 30)."px" ?>; padding:10px;margin-left:5%;"> -->
                <?php 
                  // echo "Líder <b>".$data['nombre_liderazgo']."</b>"; 
                  // echo "<br>";
                  // if($data['maxima_cantidad'] == ""){
                  //   echo "<b>".$data['minima_cantidad']." o más</b>";
                  // }else{
                  //   echo "<b>".$data['minima_cantidad']." - ".$data['maxima_cantidad']."</b>";
                  // }
                  // echo "<br>";
                  // echo "Colecciones";
                ?>    
              <!-- </div> -->
              <?php //$num++; ?>
         <?php //endif; endforeach;?>

            <!-- <br><br> -->




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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<?php endif; ?>
<script>
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=LiderazgosCamp";
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
            // alert($(this).val());
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

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
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
</script>
</body>
</html>
