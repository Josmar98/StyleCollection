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
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>&action=Ver"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Canjear gemas"; ?></h3>
            </div>
            <!-- /.box-header -->
    
            <div class="box-body">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-xs-12 text-right">
                    <?php
                      if(
                          $_SESSION['nombre_rol']=="Superusuario" || 
                          $_SESSION['nombre_rol']=="Administrador" || 
                          $_SESSION['nombre_rol']=="Administrativo2" || 
                          $_SESSION['nombre_rol']=="Analista Supervisor" || 
                          $_SESSION['nombre_rol']=="Analista"
                        ){
                          if((!empty($_GET['admin']) && $_GET['admin']==1) && (isset($_GET['lider']))){
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
                            <div class="form-group text-left">
                              <form action="" method="get" class="formClientCanjeo">
                                <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                                <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                                <input type="hidden" name="id" value="<?=$_GET['id']; ?>">
                                <input type="hidden" name="admin" value="<?=$_GET['admin']; ?>">
                              <label for="lider">Líder</label>
                              <select class="form-control select2 selectLiderCanjeo" name="lider" id="lider" required="" style="width:100%">
                                <option value="">Seleccione</option>
                                <?php 
                                  foreach ($clientes as $client) { if($client['id_cliente']){
                                    $proceder = false;
                                    if($accesoBloqueo=="1"){
                                      if(!empty($accesosEstructuras)){
                                        foreach ($accesosEstructuras as $struct) {
                                          if(!empty($struct['id_cliente'])){
                                            if($struct['id_cliente']==$client['id_cliente']){
                                              $proceder = true;
                                            }
                                          }
                                        }
                                      }
                                    }else if($accesoBloqueo=="0"){
                                      $proceder = true;
                                    }
                                    if($proceder){
                                      ?>
                                      <option <?php if($client['id_cliente']==$_GET['lider']){ echo "selected"; } ?> value="<?php echo $client['id_cliente']; ?>"><?php echo $client['primer_nombre']." ".$client['primer_apellido']." - ".$client['cedula']; ?></option>
                                      <?php
                                    }
                                  } } 
                                ?>
                              </select>
                              </form>
                              <br>
                              <br>
                            </div>
                            <?php
                            if($_GET['lider']>0){
                              $lidergemasCanjeadas = 0;
                              $lidercanjeoGemasCliente = 0;
                              $lidergemasAdquiridasNombramiento = 0;
                              $lidergemasObsequiosAdquirido = 0;

                              $lidergemasAdquiridasBloqueadas = 0;
                              $lidergemasAdquiridasDisponibles = 0;
                              $lidergemasAdquiridasFactura = 0;
                              $lidergemasAdquiridasFacturaBloqueadas = 0;
                              $lidergemasAdquiridasFacturaDisponibles = 0;
                              $lidergemasAdquiridasBonos = 0;
                              $lidergemasBonos = 0;

                              $lidergemasLiquidadas = 0;
                              $liderid_cliente_personal = $_GET['lider'];
                              $lidercanjeosPersonales = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$liderid_cliente_personal} and canjeos.estatus = 1");
                              foreach ($lidercanjeosPersonales as $canje) {
                                if(!empty($canje['precio_gemas'])){
                                  $lidergemasCanjeadas += ($canje['unidades'] * $canje['precio_gemas']);
                                }
                              }

                              $lidercanjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_cliente = {$liderid_cliente_personal} and canjeos_gemas.estatus = 1");
                              foreach ($lidercanjeosGemasCliente as $canje) {
                                if(!empty($canje['cantidad'])){
                                  $lidercanjeoGemasCliente += $canje['cantidad'];
                                }
                              }

                              $lidernombramientoAdquirido = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$liderid_cliente_personal} and estatus = 1");
                              foreach ($lidernombramientoAdquirido as $data) {
                                if(!empty($data['id_nombramiento'])){
                                  $lidergemasAdquiridasNombramiento += $data['cantidad_gemas'];
                                }
                              }

                              $liderobsequiosAdquirido = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE id_cliente = {$liderid_cliente_personal} and estatus = 1");
                              foreach ($liderobsequiosAdquirido as $data) {
                                if(!empty($data['id_obsequio_gema'])){
                                  $lidergemasObsequiosAdquirido += $data['cantidad_gemas'];
                                }
                              }


                              $lidergemasAdquiridas = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_cliente = {$liderid_cliente_personal} and gemas.estatus = 1");
                              foreach ($lidergemasAdquiridas as $data) {
                                if(!empty($data['id_gema'])){
                                  $lidergemasBonos += $data['cantidad_gemas'];
                                  if($data['estado']=="Bloqueado"){
                                    $lidergemasAdquiridasBloqueadas += $data['cantidad_gemas'];
                                  }
                                  if($data['estado']=="Disponible"){
                                    $lidergemasAdquiridasDisponibles += $data['activas'];
                                  }


                                  if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
                                    $lidergemasAdquiridasFactura += $data['cantidad_gemas'];
                                    if($data['estado']=="Bloqueado"){
                                      $lidergemasAdquiridasFacturaBloqueadas += $data['cantidad_gemas'];
                                    }
                                    if($data['estado']=="Disponible"){
                                      $lidergemasAdquiridasFacturaDisponibles += $data['cantidad_gemas'];
                                    }
                                  }
                                  if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
                                    $lidergemasAdquiridasBonos += $data['cantidad_gemas'];
                                  }
                                }
                              }

                              $lidergemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$liderid_cliente_personal}");
                              foreach ($lidergemas_liquidadas as $data) {
                                if(!empty($data['id_descuento_gema'])){
                                  $lidergemasLiquidadas += $data['cantidad_descuento_gemas'];
                                }
                              }
                              // echo "gemasAdquiridasNombramiento: ".$gemasAdquiridasNombramiento."<br>";
                              // echo "gemasAdquiridasBloqueadas: ".$gemasAdquiridasBloqueadas."<br>";
                              // echo "gemasAdquiridasDisponibles: ".$gemasAdquiridasDisponibles."<br>";
                              // echo "gemasAdquiridasFactura: ".$gemasAdquiridasFactura."<br>";
                              // echo "gemasAdquiridasFacturaBloqueadas: ".$gemasAdquiridasFacturaBloqueadas."<br>";
                              // echo "gemasAdquiridasFacturaDisponibles: ".$gemasAdquiridasFacturaDisponibles."<br>";
                              // echo "gemasAdquiridasBonos: ".$gemasAdquiridasBonos."<br>";
                              // echo "gemasBonos: ".$gemasBonos."<br>";

                              //if($gemasAdquiridasDisponibles+$gemasAdquiridasBloqueadas==$gemasBonos){ 
                              $lidergemasAdquiridasDisponibles += $lidergemasAdquiridasNombramiento;
                              $lidergemasAdquiridasDisponibles += $lidergemasObsequiosAdquirido;
                              
                              $lidergemasAdquiridasDisponibles -= $lidergemasCanjeadas;
                              $lidergemasAdquiridasDisponibles -= $lidergemasLiquidadas;
                              $lidergemasAdquiridasDisponibles -= $lidercanjeoGemasCliente;
                              $gemasAdquiridasDisponibles = $lidergemasAdquiridasDisponibles;
                              $gemasAdquiridasBloqueadas = $lidergemasAdquiridasBloqueadas;
                            }
                          }else{
                        ?>

                          <a class="btn" style="float:right;margin-right:20px;margin-top:10px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>" 
                              href="?route=<?=$_GET['route']; ?>&action=<?=$_GET['action']; ?>&id=<?=$_GET['id']; ?>&admin=1&lider=0">
                            <b>Canjear premios por líder</b>
                          </a>
                          <br><br>
                        <?php
                          }
                      }
                    ?>
                  </div>
                  <div class="col-xs-12">
                    <b> Gemas Disponibles: <?=number_format($gemasAdquiridasDisponibles,2,',','.')?> </b>
                    <span style="color:#999;"> | <b> Gemas Bloqueadas: <?=number_format($gemasAdquiridasBloqueadas,2,',','.')?> </b></span>
                  </div>
                </div>
                <?php $color = "#CCC"; ?>
                <?php foreach ($catalogos as $data): ?>
                  <?php if (!empty($data['id_catalogo'])): ?>
                  <div class="row">
                    <div class="col-xs-12" style="border-top:1px solid <?=$color?>;border-bottom:1px solid <?=$color?>;">
                      <h2 style="color:<?=$fucsia;?>">
                        <img style="width:60px;padding:0;margin:0;margin-left:15px;" src="<?=$fotoGema?>">
                        <b><?=number_format($data['cantidad_gemas'],2,',','.');?> Gemas</b>
                      </h2>
                      <div style="clear:both;"></div>
                    </div>
                  </div>

                  <div class="row box<?=$cant['cantidad_gemas']?>" style="margin-top:5px">
                    <div class="col-xs-12 col-sm-6" style="text-align:center;font-size:1.1em">
                      <div class="row">
                        <div class="">
                          <?php if (!empty($data['imagen_catalogo'])): ?>
                            <div class="col-xs-1"></div>
                            <img style="margin:0;padding:0;" class="col-xs-10" src="<?=$data['imagen_catalogo']?>">
                            <div class="col-xs-1"></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <style>
                      .title{
                        color:<?=$fucsia; ?>;
                        /*text-transform:uppercase;*/
                        font-size:1.3em;
                      }
                      .info{
                        font-size:1.1em;
                      }
                    </style>
                    <div class="col-xs-12 col-sm-6" style="text-align:left;font-size:1.1em;">
                      <span style="font-size:2em;"><?=$data['nombre_catalogo']?></span>
                      <br>
                      <br>
                      <span style="font-size:1.5em;"><img style="width:35px" src="<?=$fotoGema?>"> <?=number_format($data['cantidad_gemas'],2,',','.');?></span>
                      <br>
                      <br>
                      <div class="row">
                        <div class="col-xs-12 col-sm-12" style="margin-top:2%;">
                          <input type="hidden" id="totalGemasDisponibles" value="<?=$gemasAdquiridasDisponibles; ?>">
                          <?php
                          // echo ;
                            $catalogos=$lider->consultarQuery("SELECT * FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and catalogos.estatus = 1 and catalogos.id_catalogo={$id} ORDER BY catalogos.cantidad_gemas asc;");
                            // print_r($catalogos);
                            $procederCanjear=false;
                            if(!empty($catalogos[0]['nombre_premio'])){
                              $procederCanjear=true;
                            }
                            if($data['id_premio']==-1){
                              $procederCanjear=true;
                            }
                            if ($gemasAdquiridasDisponibles >= $data['cantidad_gemas'] && $procederCanjear==true){
                              // CUANDO SI HAY SUFICIENTE GEMAS
                              $buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
                              $apertura = "";
                              $cierre = "";
                              if(count($buscar)>1){
                                $apertura = $buscar[0]['fecha_apertura_catalogo'];
                                $cierre = $buscar[0]['fecha_cierre_catalogo'];
                              }
                              $hoy = date('Y-m-d');
                              // $hoy = "2023-04-28";
                              // echo $apertura."<br>";
                              // echo $hoy."<br>";
                              // echo $cierre."<br>";
                              if($apertura != "" && $cierre != ""){

                                if(($hoy >= $apertura) && $hoy <= $cierre){ ?>
                                    <!-- CUANDO SE ESTÁ DENTRO DE LOS LIMITES Y TODO BIEN -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                      </div>
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <span class="btn enviar2 canjearBtn form-control" style="font-size:1em;border:0;background:none;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></span>
                                      </div>
                                      <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">
                                    </div>
                                    <!-- SE CANJEA SIN PROBLEMAS -->
                                
                                <?php }else{ ?>
                                  
                                  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                                    
                                    <!-- CUANDO SE ESTÁ FUERA DE LA FECHA LIMITE PERO TIENES PERMISO AUN ASÍ Y TODO BIEN -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                      </div>
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <span class="btn enviar2 canjearBtn form-control" style="font-size:1em;border:0;background:none;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></span>
                                      </div>
                                    </div>
                                    <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">
                                    <!-- SE CANJEA SIN PROBLEMAS -->

                                  <?php } else { ?>
                                    
                                    <!-- CUANDO SE ESTÁ FUERA DE LA FECHA LIMITE -->
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                      </div>
                                      <div class="col-xs-12 col-sm-6">
                                        <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                      <div class="col-xs-12">
                                        <button class="btn col-xs-12" style="font-size:1em;color:#FFF;background:#999;border:0;"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></button>
                                      </div>
                                    </div>
                                    <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">
                                    <!-- NO SE CANJEA POR ESTÁR CERRADO -->
                                  
                                  <?php } ?>


                                <?php }
                              }else{ ?>

                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                                    
                                  <!-- CUANDO SE ESTÁ FUERA DE LA FECHA LIMITE PERO TIENES PERMISO AUN ASÍ Y TODO BIEN -->
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                      <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                      <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <span class="btn enviar2 canjearBtn col-xs-12" style="font-size:1em;border:0;background:none;" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_catalogo'] ?>"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></span>
                                    </div>
                                  </div>
                                  
                                  <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">
                                  <!-- SE CANJEA SIN PROBLEMAS -->

                                <?php } else { ?>

                                  <!-- CUANDO NISIQUIERA HAY FECHAS ASIGNADAS PARA EL CATALOGO DE GEMAS -->
                                  <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                      <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                      <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div class="col-xs-12">
                                      <button class="btn col-xs-12" style="font-size:1em;color:#FFF;background:#999;border:0;"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></button>
                                    </div>
                                  </div>
                                  <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">
                                  <!-- NO SE CANJEA POR ESTÁR CERRADO -->

                                <?php } ?>


                              <?php }
                            } else { ?>
                              <!-- CUANDO NO HAY SUFICIENTE GEMAS -->
                              <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                  <input type="number" class="form-control" id="unids" value="1" style="width:100%;">
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                  <input type="number" class="form-control" id="preciosT" value="<?=$data['cantidad_gemas']; ?>" readonly>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-xs-12">
                                  <button class="btn col-xs-12" style="font-size:1em;color:#FFF;background:#999;border:0;"><span class="fa fa-diamond"></span> Canjear <span class="fa fa-diamond"></span></button>
                                </div>
                              </div>
                              <input type="hidden" id="precioGema" value="<?=$data['cantidad_gemas']; ?>">

                            <?php } ?>
                        </div>
                      </div>
                    </div>
                    <br>
                  </div>
                  <div class="row">
                    <div class="col-xs-12 col-sm-6" style="font-size:1.2em;padding-left:5%;">
                      <?php 
                        $descripcionPremios = ""; 
                        if (trim($data['codigo_catalogo'])!=""){ 
                          $descripcionPremios .= "Codigo: #".$data['codigo_catalogo']."<br>";
                        }
                        if (trim($data['marca_catalogo'])!=""){
                          $descripcionPremios .= "Marca ".$data['marca_catalogo']."<br>";
                        }
                        if (trim($data['color_catalogo'])!=""){
                          $descripcionPremios .= "Color ".$data['color_catalogo']."<br>";
                        }
                        if (trim($data['voltaje_catalogo'])!=""){
                          $descripcionPremios .= "Voltaje ".$data['voltaje_catalogo']."<br>";
                        }
                        if (trim($data['puestos_catalogo'])!=""){
                          $descripcionPremios .= "".$data['puestos_catalogo']." puestos<br>";
                        }
                        if (trim($data['caracteristicas_catalogo'])!=""){
                          $descripcionPremios .= "".$data['caracteristicas_catalogo']."<br>";
                        }
                        if (trim($data['otros_catalogo'])!=""){
                          $descripcionPremios .= "".$data['otros_catalogo']."<br>";
                        }
                        if($descripcionPremios!=""){
                          echo "<h3>Descripción</h3>";
                          echo $descripcionPremios;
                        }
                      ?>
                    </div>
                  </div>
                  <br>
                  <br>

                  <?php endif; ?>
                <?php endforeach; ?>

              </div>
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
  $(".selectLiderCanjeo").change(function(){
    var val = $(this).val();
    if(val!=""){
      $(".formClientCanjeo").submit();
    }
  });

  $("#unids").change(function(){
    var totalGemasDisponibles = $("#totalGemasDisponibles").val();
    var cant = parseFloat($(this).val());
    var precio = parseFloat($("#precioGema").val());
    var limit = parseInt(totalGemasDisponibles);
    if(cant > limit){
      cant = limit;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    if(cant < 1){
      cant = 1;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    var newTotal = precio*cant;
    $("#preciosT").val(newTotal);
  });

  $("#unids").focusout(function(){
    var totalGemasDisponibles = $("#totalGemasDisponibles").val();
    var cant = parseFloat($(this).val());
    var precio = parseFloat($("#precioGema").val());
    var limit = parseInt(totalGemasDisponibles);
    if(cant > limit){
      cant = limit;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    if(cant < 1){
      cant = 1;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    var newTotal = precio*cant;
    $("#preciosT").val(newTotal);
  });

  $("#unids").keyup(function(){
    var totalGemasDisponibles = $("#totalGemasDisponibles").val();
    var cant = parseFloat($(this).val());
    var precio = parseFloat($("#precioGema").val());
    var limit = parseInt(totalGemasDisponibles);
    if(cant > limit){
      cant = limit;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    if(cant < 1){
      cant = 1;
      $(this).val(cant);
      cant = parseFloat($(this).val());
    }
    var newTotal = precio*cant;
    $("#preciosT").val(newTotal);
  });

  $(".canjearBtn").click(function(){
    swal.fire({ 
          title: "¿Desea canjear este premio?",
          text: "Al canjear este premio se descontara de su cantidad disponibles de gemas, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Canjear!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){
            var cantidadPremios = $("#unids").val();
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                  valueCanjeo: true,
                  cantidad: cantidadPremios,
                },
                success: function(respuesta){
                  // alert(respuesta);
                  if (respuesta == "1"){
                    swal.fire({
                        type: 'success',
                        title: '¡Premio canjeado con exito!',
                        confirmButtonColor: "#ED2A77",
                    }).then(function(){
                      window.location = "?route=Catalogo&action=Ver";
                    });
                  }
                  if (respuesta == "2"){
                    swal.fire({
                        type: 'error',
                        title: '¡Error al canjear el premio!',
                        confirmButtonColor: "#ED2A77",
                    });
                  }
                  // if (respuesta == "5"){ 
                  //   swal.fire({
                  //       type: 'error',
                  //       title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                  //       confirmButtonColor: "#ED2A77",
                  //   });
                  // }
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
