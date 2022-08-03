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
        <?php echo $url.""; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo $url.""; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo $url."";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?=$url?></a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box"> 
               <?php
                $aux = $url;
                $aux2 = "";
                if(isset($_GET['lider'])){
                  $aux.="&admin=1&lider=".$_GET['lider'];
                  $aux2.="&admin=1&lider=".$_GET['lider'];
                }
                if(isset($_GET['Banco'])){
                  $aux.="&Banco=".$_GET['Banco'];
                  $aux2.="&Banco=".$_GET['Banco'];
                }
                if(isset($_GET['rangoI']) && isset($_GET['rangoF'])){
                  $aux.="&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
                  $aux2.="&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];
                }
                if(isset($_GET['Abonado'])){
                  $aux.="&Abonado=".$_GET['Abonado'];
                  $aux2.="&Abonado=".$_GET['Abonado'];
                }
                if(isset($_GET['Diferido'])){
                  $aux.="&Diferido=".$_GET['Diferido'];
                  $aux2.="&Diferido=".$_GET['Diferido'];
                }
                if($aux==$url){
                  $aux = "Pagoss";
                }
                if($aux2==""){
                  $aux = "Pagoss";
                }
                echo $aux2;
              ?>

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "".$url; ?></a></h3>

                <?php //if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <br><br>
                <div class="row">
                  <form action="" method="get">
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="<?=$url;?>" name="route">
                      <?php if(!empty($_GET['admin'])){ ?>
                        <input type="hidden" value="1" name="admin">
                        <?php } ?>
                        <?php if(!empty($_GET['lider'])){ ?>
                        <input type="hidden" value="<?=$_GET['lider']?>" name="lider">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoI'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoI']?>" name="rangoI">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoF'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoF']?>" name="rangoF">
                        <?php } ?>
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>
                        
                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                      <br>
                      <button class="btn enviar ">Enviar</button>
                    </div>
                  </form>
                </div>
                <br>
                
                <?php //} ?>
            </div>
            <!-- /.box-header -->


            <?php    
              $superopcionconcilio = 0;
              $adminopcionconcilio = 0;

              $superopcionpago = 0;
              $adminopcionpago = 0;
              $analistaeditarpago = 0;
              $analistaborrarpago = 0;
              $superanalistaborrarpago = 0;
              $superanalistaeditarpago = 0;
              $analistaaccesorapido = 0;
              $adminborrarpago = 0;
              $superadminborrarpago = 0;
              $tablasdatatable = 0;

              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              foreach ($configuraciones as $config) {
                if(!empty($config['id_configuracion'])){
                  if($config['clausula']=="Superopcionpago"){
                    $superopcionpago = $config['valor'];
                  }
                  if($config['clausula']=="Adminopcionpago"){
                    $adminopcionpago = $config['valor'];
                  }
                  if($config['clausula']=="Analistaeditarpago"){
                    $analistaeditarpago = $config['valor'];
                  }
                  if($config['clausula']=="Analistaborrarpago"){
                    $analistaborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaborrarpago"){
                    $superanalistaborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superanalistaeditarpago"){
                    $superanalistaeditarpago = $config['valor'];
                  }
                  if($config['clausula']=="Adminborrarpago"){
                    $adminborrarpago = $config['valor'];
                  }
                  if($config['clausula']=="Superadminborrarpago"){
                    $superadminborrarpago = $config['valor'];
                  }
                  
                  if($config['clausula']=="Analistaaccesorapido"){
                    $analistaaccesorapido = $config['valor'];
                  }
                  if($config['clausula']=="Pagosdatatable"){
                    $tablasdatatable = $config['valor'];
                  }
                  if($config['clausula']=="Superopcionconcilio"){
                    $superopcionconcilio = $config['valor'];
                  }
                  if($config['clausula']=="Adminopcionconcilio"){
                    $adminopcionconcilio = $config['valor'];
                  }
                }
              }



              $ruta = "PagosBorrados";
              // if(!empty($_GET['admin']) && !empty($_GET['lider'])){
              //   $ruta = "PagosBorrados&admin=1&lider=".$_GET['lider'];                      
              // } else if($_SESSION['id_cliente']==$id_cliente){
              //   $ruta = "PagosBorrados";
              // }else{
              //   $ruta = "PagosBorrados&admin=1&lider=".$id_cliente;                      
              // }
              if(!empty($_GET['admin']) && !empty($_GET['lider'])){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  $ruta = "PagosBorrados&admin=1&lider=".$_GET['lider']."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                }else{
                  $ruta = "PagosBorrados&admin=1&lider=".$_GET['lider'];                      
                }
              } else if($_SESSION['id_cliente']==$id_cliente){
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  $ruta = "PagosBorrados&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                }else{
                  $ruta = "PagosBorrados";
                }
              }else{
                if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
                  $ruta = "PagosBorrados&admin=1&lider=".$id_cliente."&rangoI=".$_GET['rangoI']."&rangoF=".$_GET['rangoF'];                      
                }else{
                  $ruta = "PagosBorrados&admin=1&lider=".$id_cliente;                      
                }
              }

            ?>

            <div class="box-body">

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>

              <hr>




              <div class="box-header">
                <?php
                  $montosContado=0;
                  $equivalenciasContado=0;
                  $equivalenciasAbonadasContado=0;
                ?>
                <h3 class="box-title"><?php echo "Contado"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_contado">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_contado" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>

                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th>
                        <th>---</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        $num = 1;
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"):
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%;">

                            <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];

                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                              $equivalenciasAbonadasContado += $data['equivalente_pago'];
                            }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosContado += $data['monto_pago'];
                                  $equivalenciasContado += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasContado += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class='elementos_tr_contado_<?=$data['id_pago']?> tr<?=$data['id_pago']?>' style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }

                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr >
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                      <tr style="background:#CCC;">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'>
                          <h4>Contados:</h4>
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                              $precioCol = $despacho['precio_coleccion'];
                              $descuentoContado = $despacho['contado_precio_coleccion'];
                            if($equivalenciasAbonadasContado!=0){
                              $totalContado = $equivalenciasAbonadasContado / ($precioCol - $descuentoContado);
                            }else{
                              $totalContado = 0;
                            }
                            echo number_format($totalContado,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b><?=number_format($montosContado,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasContado,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoContado=0;
                  $diferidoContado=0;
                  $abonadoContado=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Contado"):
                            if($data['estado']=="Abonado"){
                              $reportadoContado += $data['equivalente_pago'];
                              $abonadoContado += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoContado += $data['equivalente_pago'];
                              $diferidoContado += $data['equivalente_pago'];
                            }else{
                              $reportadoContado += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado Contado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoContado, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido Contado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoContado, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado Contado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoContado, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>









              <div class="box-header">
                <?php
                  $montosI=0;
                  $equivalenciasI=0;
                  $equivalenciasAbonadasI=0;
                ?>
                <h3 class="box-title"><?php echo "Iniciales"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_inicial">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_inicial" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>


                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th>
                        <th>---</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        $num = 1;
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"):
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                        ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                            $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" ||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }
                              else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosI += $data['monto_pago'];
                                  $equivalenciasI += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_inicial']){
                            
                        $equivalenciasAbonadasI += $data['equivalente_pago'];
                          }
                       ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_inicial_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }
                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr >
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                      <tr style="background:#CCC;">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style='padding:0;margin:0;'></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'>
                          <h4>Iniciales:</h4>
                        </th>
                        <th style='padding:0;margin:0;'>
                          <h4><b>
                          <?php
                              $precioInicial = $despacho['inicial_precio_coleccion'];
                            if($equivalenciasAbonadasI!=0){
                              $totalIniciales = $equivalenciasAbonadasI / $precioInicial;
                            }else{
                              $totalIniciales = 0;
                            }
                            echo number_format($totalIniciales,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'><h4>Monto: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b><?=number_format($montosI,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'><h4>Eqv: </h4></th>
                        <th style='padding:0;margin:0;'><h4><b>$<?=number_format($equivalenciasI,2, ",",".")?></b></h4></th>
                        <th style='padding:0;margin:0;'></th>
                        <th style='padding:0;margin:0;'></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoInicial=0;
                  $diferidoInicial=0;
                  $abonadoInicial=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Inicial"):
                            if($data['estado']=="Abonado"){
                              $reportadoInicial += $data['equivalente_pago'];
                              $abonadoInicial += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoInicial += $data['equivalente_pago'];
                              $diferidoInicial += $data['equivalente_pago'];
                            }else{
                              $reportadoInicial += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado Inicial</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoInicial, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido Inicial</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoInicial, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado Inicial</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoInicial, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>



              <div class="box-header">
                <?php
                  $montosP1=0;
                  $equivalenciasP1=0;
                  $equivalenciasAbonodasP1=0;
                ?>
                <h3 class="box-title"><?php echo "Primer Pago"; ?></h3>
                <br>
                  <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                      <div class="input-group">
                          <label for="buscando">Buscar: </label>&nbsp
                          <input type="text" id="buscar_table_primer">
                      </div>
                      <br>
                  </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">

                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_primer" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>

                    <thead>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th>
                        <th>---</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php 
                        $num = 1;
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"):
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                          <?php if($data['estado']=="Abonado"){ 
                              if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                                
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosP1 += $data['monto_pago'];
                                  $equivalenciasP1 += $data['equivalente_pago'];
                          ?>
                        <?php if($data['estado']=="Abonado"){ 
                            if($data['fecha_pago'] <= $despacho['fecha_primera_senior']){
                            
                                  $equivalenciasAbonodasP1 += $data['equivalente_pago'];
                          }
                        ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_primer_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>

                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="conten">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_monto">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2" class="td_equivalente">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }
                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                      <tr style="background:#CCC">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;">
                          <h4>(P.P) Premios: </h4>
                        </th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php
                              $precioPrimerP = $despacho['primer_precio_coleccion'];
                            if($equivalenciasAbonodasP1!=0){
                              $totalPrimer = $equivalenciasAbonodasP1 / $precioPrimerP;
                            }else{
                              $totalPrimer = 0;
                            }
                            echo number_format($totalPrimer,2,',','.'); 
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"><h4>Monto:</h4></th>
                        <th style="padding:0;margin:0;"><h4><b><?=number_format($montosP1,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;"><h4>Eqv:</h4></th>
                        <th style="padding:0;margin:0;"><h4><b>$<?=number_format($equivalenciasP1,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php 
                            if(!empty($_GET['lider'])){

                              if($acumTotalPrimerPago!=0){
                                $porcentajeDePrimerPago = ($equivalenciasAbonodasP1*100)/$acumTotalPrimerPago;
                              }else{
                                $porcentajeDePrimerPago = 0;
                              }
                              echo number_format($porcentajeDePrimerPago,2,',','.')."%";
                            }
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoPrimer=0;
                  $diferidoPrimer=0;
                  $abonadoPrimer=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Primer Pago"):
                            if($data['estado']=="Abonado"){
                              $reportadoPrimer += $data['equivalente_pago'];
                              $abonadoPrimer += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoPrimer += $data['equivalente_pago'];
                              $diferidoPrimer += $data['equivalente_pago'];
                            }else{
                              $reportadoPrimer += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado 1er.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido 1er.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado 1er.P.</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoPrimer, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>



              <div class="box-header">
                <?php
                  $montosC=0;
                  $equivalenciasC=0;
                ?>
                <h3 class="box-title"><?php echo "Segundo Pago"; ?></h3>
                <br>
                <!-- <div class="col-xs-offset-1 col-xs-10 col-sm-offset-1 col-sm-6">
                    <div class="input-group">
                        <label for="buscando">Buscar: </label>&nbsp
                        <input type="text" id="buscar_table_cierre">
                    </div>
                    <br>
                </div> -->
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                    <?php if ($tablasdatatable=="1"): ?>
                  <table id="" class="datatable1 table table-bordered table-striped datatablee table_cierre" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php else: ?>
                  <table id="" class="table table-bordered table-striped datatablee table_cierre" style="text-align:center;min-width:100%;max-width:100%;">
                    <?php endif ?>

                    <thead>
                      <tr>
                        <?php if(  $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"  || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th>---</th>
                        <?php endif; ?>
                        <!-- <th class="fichas">Ficha</th> -->
                        <th>Nº</th>
                        <th>Fechas</th>
                        <th>Forma de Pago</th>
                        <th>Bancos</th>
                        <th>Referencia Bancaria</th>
                        <th>Monto</th>
                        <th>Tasa</th>
                        <th>Equivalencia</th>
                        <th>Concepto</th>
                        <th>---</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php 
                        $num = 1;
                        foreach ($pagos as $data):
                          if(!empty($data['id_pago'])):
                            if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"):
                              if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){
                                if($data['estado']=="Diferido"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                      ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              } else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){
                                if($data['estado']=="Abonado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                                }
                              }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }else {
                                  $montosC += $data['monto_pago'];
                                  $equivalenciasC += $data['equivalente_pago'];
                        ?>
                      <?php if($data['estado']=="Abonado"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(0,210,0,.5)">
                      <?php }else if($data['estado']=="Diferido"){ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:rgba(210,0,0,.5)">
                      <?php } else{ ?>
                      <tr class="elementos_tr_cierre_<?=$data['id_pago']?> tr<?=$data['id_pago']?>" style="background:;">
                        <?php } ?>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <td style="width:10%">
                                <?php 
                              if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                                
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=ModificarAutorizados&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                  <span class="fa fa-wrench">
                                    
                                  </span>
                                </button>
                                
                                <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>

                                <?php }else{ ?>
                                    <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                <?php } ?>
                                <?php 
                              }else{
                                if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionpago=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionpago=="1")){ ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    
                                    <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                      <span class="fa fa-wrench">
                                        
                                      </span>
                                    </button>
                                  <?php endif ?>
                                  
                                  <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                    
                                    <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                    </button>
                                  <?php endif ?>
                                <?php
                                }else{
                                  if($data['estado']!="Abonado"){  
                                ?>
                                  <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                    <?php if ($_SESSION['nombre_rol']=="Analista"||$_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaeditarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaeditarpago=="1")): ?>
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      <?php endif ?>                                  
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if (($_SESSION['nombre_rol']=="Analista" && $analistaborrarpago=="1") || ($_SESSION['nombre_rol']=="Analista Supervisor" && $superanalistaborrarpago=="1")): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif ?>
                                    <?php else: ?>

                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?=$menu?>&route=Pagos&action=Modificar&id=<?php echo $data['id_pago'] ?>&aux=<?=$aux?>">
                                        <span class="fa fa-wrench">
                                        </span>
                                      </button>
                                      
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>

                                      <?php if ($_SESSION['nombre_rol']=="Administrador" && $adminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                      <?php if ($_SESSION['nombre_rol']=="Superusuario" && $superadminborrarpago=="1"): ?>
                                      <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu?>&route=<?=$url?>&id=<?php echo $data['id_pago'] ?>&permission=1">
                                        <span class="fa fa-trash"></span>
                                      </button>
                                      <?php endif; ?>
                                    <?php endif; ?>
                                  <?php else: ?>
                                        <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                                  <?php endif; ?>
                            <?php 
                                  }else{ ?>
                                      <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
                              <?php }
                                } 
                              } 
                            ?>
                        </td>
                        <?php endif ?>
                        <!-- <td class="fichas"><button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button></td> -->
                        <td style="width:5%">
                          <span class="contenido2">
                            <?php echo $num++; ?>
                          </span>
                        </td>
                        <td style="width:20%" class='td_fechas' value="<?=$data['id_pago']?>">
                          <span class="contenido2">
                            <span class='contenido_fecha_pago'><?php echo $lider->formatFecha($data['fecha_pago']); ?></span>
                            <br>
                            <?php
                              if($data['tipo_pago']=="Contado" || $data['tipo_pago']=="contado" || $data['tipo_pago']=="CONTADO"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Inicial" || $data['tipo_pago']=="inicial" || $data['tipo_pago']=="INICIAL"){
                                $restriccion = $despacho['fecha_inicial'];
                              }
                              if($data['tipo_pago']=="Primer Pago" || $data['tipo_pago']=="primer pago" || $data['tipo_pago']=="PRIMER PAGO"){
                                $restriccion = $despacho['fecha_primera_senior'];
                              }
                              if($data['tipo_pago']=="Segundo Pago" || $data['tipo_pago']=="segundo pago" || $data['tipo_pago']=="SEGUNDO PAGO"){
                                $restriccion = $despacho['fecha_segunda_senior'];
                              }
                              $temporalidad = "";
                              if($data['fecha_pago'] <= $restriccion){
                                $temporalidad = "Puntual";
                              }else{
                                $temporalidad = "Impuntual";
                              }
                            ?>
                            <small class='contenido_temporalidad'><?=$temporalidad?></small>
                          </span>
                        </td>
                        <td style="width:20%" class="td_forma_de_pago">
                          <?php
                            if($data['forma_pago']=="Transferencia Banco a Banco"){
                              $forma_pago = "T-BB";
                            } else if($data['forma_pago']=="Transferencia de Otros Bancos"){
                              $forma_pago = "T-OB";
                            } else if($data['forma_pago']=="Pago Movil Banco a Banco"){
                              $forma_pago = "PM-BB";
                            } else if($data['forma_pago']=="Pago Movil de Otros Bancos"){
                              $forma_pago = "PM-OB";
                            }else{
                              $forma_pago = $data['forma_pago'];
                            }
                          ?>
                          <span class="contenido2">
                            <span class='contenido_forma_pago'><?php echo $forma_pago; ?></span>
                          </span>
                        </td>
                        <td class="td_bancos">
                          <span class="contenido2">
                            <?php foreach ($bancos as $bank): ?>
                                <?php if (!empty($bank['id_banco'])): ?>
                                  <?php if ($bank['id_banco']==$data['id_banco']): ?>
                                    <span class='contenido_banco'><?php echo $bank['nombre_banco']." <small>".$bank['nombre_propietario']."</small>" ?></span>
                                  <?php endif ?>
                                <?php endif ?>
                            <?php endforeach ?>
                          </span>
                          
                        </td>
                        <td style="width:20%" class="td_referencias">
                          <span class="contenido2">
                            <span class='contenido_referencia'><?php echo $data['referencia_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_monto">
                          <span class="contenido2">
                            <span class='contenido_monto'><?php if($data['monto_pago']!=""){ echo number_format($data['monto_pago'],2,',','.'); }else{ echo "0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tasa'><?php if($data['tasa_pago']!=""){ echo number_format($data['tasa_pago'],2,',','.'); }else{ echo ""; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%" class="td_equivalente">
                          <span class="contenido2">
                            <span class='contenido_equivalente'><?php if($data['equivalente_pago']!=""){ if($data['forma_pago']=="Divisas Euros"){ echo "€"; }else { echo "$"; } echo number_format($data['equivalente_pago'],2,',','.'); }else{ echo "$0,00"; } ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <span class="contenido2">
                            <span class='contenido_tipo_pago'><?php echo $data['tipo_pago']; ?></span>
                          </span>
                        </td>
                        <td style="width:20%">
                          <!-- <button class="btn editarPagoBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_modulo'] ?>"> -->
                          <?php 
                          if($data['forma_pago'][0]=="A"&&$data['forma_pago'][1]=="u"&&$data['forma_pago'][2]=="t"&&$data['forma_pago'][3]=="o"&&$data['forma_pago'][4]=="r"&&$data['forma_pago'][5]=="i"&&$data['forma_pago'][6]=="z"&&$data['forma_pago'][7]=="a"&&$data['forma_pago'][8]=="d"&&$data['forma_pago'][9]=="o"){ ?>
                            <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"){ ?>
                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                            <span class="fa fa-pencil"></span>
                          </button>
                            <?php } ?>
                          <?php }else{ ?>

                              <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>
                                <?php if ($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"): ?>
                                      <?php if ($analistaaccesorapido=="1"): ?>
                                          <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                            <span class="fa fa-pencil"></span>
                                          </button>
                                      <?php endif; ?>              
                                <?php elseif($_SESSION['nombre_rol']=="Conciliador"): ?>
                                      <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn editarPagoBtnConciliador" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                      <?php } ?>
                                <?php else: ?>
                                    <button class="btn editarPagoBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-pencil"></span>
                                    </button>
                                <?php endif; ?>
                              <?php } ?>
                          <?php } ?>
                          <?php if(($_SESSION['nombre_rol']=="Superusuario" && $superopcionconcilio=="1") || ($_SESSION['nombre_rol']=="Administrador" && $adminopcionconcilio=="1")){ ?>
                                  <?php if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                                  <?php if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php } ?>

                          <?php }else{ ?>
                              <?php  if($data['estado']!="Abonado"){  ?>
                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Conciliador"){ if($data['id_banco']!=""){ ?>
                                    <button class="btn diferirPagoBtnConciliadores" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnConciliadores" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>

                                  <?php if($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ if($data['id_banco']==""){ ?>
                                    <button class="btn diferirPagoBtnAnalista" style="border:0;background:none;color:#CC0000" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-times-circle" style='background:#FFF;border-radius:100%;'></span>
                                    </button>
                                    <button class="btn aprobarPagoBtnAnalista" style="border:0;background:none;color:#00CC00" value="<?=$data['id_pago']?>">
                                      <span class="fa fa-check-circle" style='background:#fff;border-radius:100%;'></span>
                                    </button>
                                  <?php }} ?>
                              <?php } ?>

                          <?php } ?>
                            



                        </td>
                      </tr>
                        <?php
                              }
                            endif; endif; endforeach;
                        ?>
                    </tbody>

                    <tfoot>
                      <tr>
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                      <tr style="background:#CCC">
                        <?php if( $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                        <th style="padding:0;margin:0;"></th>
                        <?php endif; ?>
                        <!-- <th class="fichas" style="padding:0;margin:0;"></th> -->
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"></th>
                        <th style="padding:0;margin:0;"><h4>Monto: </h4></th>
                        <th style="padding:0;margin:0;"><h4><b><?=number_format($montosC,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;"><h4>Eqv: </h4></th>
                        <th style="padding:0;margin:0;"><h4><b>$<?=number_format($equivalenciasC,2, ",",".")?></b></h4></th>
                        <th style="padding:0;margin:0;">
                          <h4><b>
                          <?php 
                            if(!empty($_GET['lider'])){
                              // echo $nuevoTotal;
                              if($nuevoTotal!=0){
                                $porcentajeDeSegundoPago = ($abonado*100)/$nuevoTotal;
                              }else{
                                $porcentajeDeSegundoPago = 0;
                              }
                              echo number_format($porcentajeDeSegundoPago,2,',','.')."%";
                            }
                          ?>
                          </b></h4>
                        </th>
                        <th style="padding:0;margin:0;"></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <?php 
                  $reportadoSegundo=0;
                  $diferidoSegundo=0;
                  $abonadoSegundo=0;
                  foreach ($pagos as $data):
                        if(!empty($data['id_pago'])):
                          if($data['tipo_pago']=="Segundo Pago"):
                            if($data['estado']=="Abonado"){
                              $reportadoSegundo += $data['equivalente_pago'];
                              $abonadoSegundo += $data['equivalente_pago'];
                            }
                            else if($data['estado']=="Diferido"){
                              $reportadoSegundo += $data['equivalente_pago'];
                              $diferidoSegundo += $data['equivalente_pago'];
                            }else{
                              $reportadoSegundo += $data['equivalente_pago'];
                            }
                          endif;
                        endif;
                  endforeach;
                ?>
                <div class="row text-center" style="padding:10px 20px;">
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta;?>">
                      <b style="color:#000 !important">Reportado 2do.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 style="color:#0000FF !important"><b>$<?=number_format($reportadoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                      <b style="color:#000 !important">Diferido 2do.P.</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferidoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                  </div>
                  <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                        <b style="color:#000 !important">Abonado 2do.P.</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonadoSegundo, 2, ",", ".")?></b></h4>
                    </a>
                    <?php  ?>
                  </div>
                </div>
                <br>
              </div>

              <div class="box-header">
                <?php
                  $montosT=$montosContado+$montosI+$montosP1+$montosC;
                  $equivalenciasT=$equivalenciasContado+$equivalenciasI+$equivalenciasP1+$equivalenciasC;
                ?>
                <h3 class="box-title"><?php echo "Total"; ?></h3>
              </div>
              <div class="box" style="border-top:none">
                <div class="box-body table-responsive">
                  <table id="" class="table table-bordered table-striped datatablee" style="text-align:center;min-width:100%;max-width:100%;">
                    <thead>
                    
                    </thead>
                    <tbody>
                    
                      <tr>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td style="width:8.5%"></td>
                        <td><h4>Monto: </h4></td>
                        <td><h4><b><?=number_format($montosT,2, ",",".")?></b></h4></td>

                        <?php if(!empty($_GET['Diferido']) && $_GET['Diferido']=="Diferido"){ ?>
                            <td><h4 style="color:#DD0000">Total: </h4></td>
                            <td><h4><b style="color:#DD0000">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Abonado']) && $_GET['Abonado']=="Abonado"){ ?>
                            <td><h4 style="color:#00DD00">Total: </h4></td>
                            <td><h4><b style="color:#00DD00">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php }else if(!empty($_GET['Reportado']) && $_GET['Reportado']=="Reportado"){ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php } else{ ?>
                            <td><h4 style="color:#0000DD">Total: </h4></td>
                            <td><h4><b style="color:#0000DD">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td>
                        <?php } ?>


                        <?php if($nuevoTotal!=0 && !empty($_GET['lider'])){ ?>
                        <td><h4 style="color:#DD0000">Resta: </h4></td>
                        <td><h4><b style="color:#DD0000">$<?=number_format($nuevoTotal-$abonado,2, ",",".")?></b></h4></td>
                        <?php }else{ ?>
                          <td></td>
                        <?php } ?>
                        <!-- <td><h4 style="color:#DD0000">Resta: </h4></td> -->
                        <!-- <td><h4><b style="color:#DD0000">$<?=number_format($equivalenciasT,2, ",",".")?></b></h4></td> -->
                      </tr>
                    
                    </tbody>
                    <tfoot>
                    
                    </tfoot>
                  </table>
                </div>
              </div>

              <hr>

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">


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

    <div class="box-modalFichaDetalle  " style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalFichaDetalle" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <!-- <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3> -->
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>
                  <br>
                  <div class="box-body" style="padding-left:20px;padding-right:20px;">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_fecha"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_tasa"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_forma"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_banco"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_referencia"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_concepto"></span>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_monto"></span>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <span style="font-size:1.3em" class="ficha_detalle_equivalente"></span>
                      </div>
                    </div>
                  </div>
                  <br>
                    <!-- <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" name="rol" value="Conciliador">
                    <input type="hidden" class="id_pago_modal" name="id_pago_modal"> -->
       

                  <!-- <div class="container">
                    <span class="text-ficha-detalle"></span>
                  </div> -->
                  <!-- <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalFichaDetalle  ">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalConciliador   d-none" disabled="" >enviar</button>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="box-modalEditar" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModal" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tipo_pago">Concepto de pago</label>
                           <select class="form-control tipo_pago" id="tipo_pago"  name="tipo_pago" style="width:100%;z-index:91000">
                             <option></option>
                             <option class="optIncial">Inicial</option>
                             <option class="optPrimer">Primer Pago</option>
                             <option class="optCierre">Cierre</option>
                           </select>
                           <span id="error_tipoPagoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tasa">Tasa del dolar</label>
                           <input type="number" class="form-control tasaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="tasa" id="tasa" max="<?=date('Y-m-d')?>">
                           <span id="error_tasaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModal">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modal d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


  <div class="box-modalAprobarConcialiador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalAprobarConciliadores" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firma">Firma</label>
                           <input type="text" class="form-control firmaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="firma" max="<?=date('Y-m-d')?>">
                           <span id="error_firmaModal" class="errors"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyenda">Leyenda</label>
                           <input type="text" class="form-control leyendaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="leyenda" id="leyenda" max="<?=date('Y-m-d')?>">
                           <span id="error_leyendaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalAprobadoConciliadores">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalAprobadoConciliadores d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalDiferirConcialiador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDiferirConciliadores" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirma">Firma</label>
                           <input type="text" class="form-control diferirFirmaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="diferirFirma" max="<?=date('Y-m-d')?>">
                           <span id="error_diferirFirmaModal" class="errors"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacion">Motivo</label>
                           <select class="form-control observacion" id="observacion"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optRepetido">Repetido</option>
                             <option class="optComprobante">Se solicita comprobante</option>
                             <option class="optOtraEmpresa">No realizado a la empresa</option>
                           </select>
                           <span id="error_observacionModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDiferidoConciliadores">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDiferidoConciliadores d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

    <div class="box-modalAprobarAnalista" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalAprobarAnalista" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firmaAnalista">Firma</label>
                           <input type="text" class="form-control firmaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="firmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_firmaAnalistaModal" class="errors"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyendaAnalista">Leyenda</label>
                           <input type="text" class="form-control leyendaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="leyenda" id="leyendaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_leyendaAnalistaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalAprobadoAnalista">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalAprobadoAnalista d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <div class="box-modalDiferirAnalista" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDiferirAnalista" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Datos de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirmaAnalista">Firma</label>
                           <input type="text" class="form-control diferirFirmaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="diferirFirmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_diferirFirmaAnalistaModal" class="errors"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacionAnalista">Motivo</label>
                           <select class="form-control observacionAnalista" id="observacionAnalista"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optPendienteEntregar">Pendiente Por Entregar</option>
                             <option class="optPendienteSustituir">Billete Devuelto Pendiente por Sustituir</option>
                           </select>
                           <span id="error_observacionAnalistaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalDiferidoAnalista">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalDiferidoAnalista d-none" disabled="" >enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<?php endif; ?>
<!-- 
  fa-calendar-times-o
  fa-calendar-check-o
-->
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=Pagos";
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

  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });

    $(".btnFichaDetalle").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'?<?=$menu?>&route=Pagos',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        // alert(response);
        var json = JSON.parse(response);
        var data = json['pedido'];
        var banco = {};
        if(json['exec_banco']){
          banco = json['banco'];
        }
        console.log(data);
        if(data['fotoPerfil']==""||data['fotoPerfil']==null){
          var foto = "";
          if(data['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data['fotoPerfil']);
        }
        $(".nameUserPago").html(data['primer_nombre']+" "+data['primer_apellido']);

        var estado = "Reportado";
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,0,165,.65);");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(165,0,0,.65);");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style","text-align:right;padding-right:25px;background:rgba(0,165,0,.65);");
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
        }



        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);
        $(".ficha_detalle_fecha").html("<i><b>Fecha: </b></i>"+dia+"/"+mes+"/"+year);
        if(data['tasa_pago']!=null){
          $(".ficha_detalle_tasa").html("<i><b>Tasa: </b></i>Bs. "+data['tasa_pago']);
        }else{
          $(".ficha_detalle_tasa").html("");          
        }
        $(".ficha_detalle_forma").html(data['forma_pago']);
        if(json['exec_banco']){
          $(".ficha_detalle_banco").html("Banco "+banco['nombre_banco']+" <small>("+banco['nombre_propietario']+")</small>");
        }else{
          $(".ficha_detalle_banco").html("");
        }
        if(data['referencia_pago']!=null){
          $(".ficha_detalle_referencia").html("<i><b>Ref.</b></i> "+data['referencia_pago']);
        }else{
          $(".ficha_detalle_referencia").html("");          
        }
        $(".ficha_detalle_concepto").html("<i><b>Concepto: </b></i>"+data['tipo_pago']);
        if(data['monto_pago']!=null){
          $.ajax({
            url:'',
            type:"POST",
            data:{
              val: data['monto_pago'],
              formatNumber: true, 
            },
            success: function(monto){
              $(".ficha_detalle_monto").html("<i><b>Monto = </b></i> Bs. "+monto);
            }
          });
        }else{
          $(".ficha_detalle_monto").html("");          
        }
        if(data['equivalente_pago']!=null){
          $.ajax({
            url:'',
            type:"POST",
            data:{
              val: data['equivalente_pago'],
              formatNumber: true, 
            },
            success: function(equivalente){
              // $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> $"+data['equivalente_pago']);
              if(data['forma_pago']=="Divisas Euros"){
                $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> €"+equivalente);
              }else{
                $(".ficha_detalle_equivalente").html("<i><b>Eqv = </b></i> $"+equivalente);
              }
            }
          });
        }else{
          $(".ficha_detalle_equivalente").html("");          
        }

        $(".box-modalFichaDetalle").fadeIn(500);
      }
    });
  });
  $(".cerrarModalFichaDetalle").click(function(){
    $(".box-modalFichaDetalle").fadeOut(500);
  });
  
  $(".diferirPagoBtnConciliadores").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var data = JSON.parse(response);
        console.log(data);
        if(data[0]['fotoPerfil']==""||data[0]['fotoPerfil']==null){
          var foto = "";
          if(data[0]['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data[0]['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data[0]['fotoPerfil']);
        }
        $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
        var year = data[0]['fecha_pago'].substr(0, 4);
        var mes = data[0]['fecha_pago'].substr(5, 2);
        var dia = data[0]['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".diferirFirmaModal").val(data[0]['firma']);
        if(data[0]['observacion']=="Repetido"){
          $(".optRepetido").attr("selected","selected");
        }
        if(data[0]['observacion']=="Se solicita comprobante"){
          $(".optComprobante").attr("selected","selected");
        }
        if(data[0]['observacion']=="No realizado a la empresa"){
          $(".optOtraEmpresa").attr("selected","selected");
        }




      }
    });
    $(".box-modalDiferirConcialiador").fadeIn(500);
  });
  $(".enviarModalDiferidoConciliadores").click(function(){
    var exec = false;
    $("#error_diferirFirmaModal").html("");
    $("#error_observacionModal").html("");
    // alert($(".diferirFirmaModal").val());
    // alert($(".observacion").val());
    if($(".diferirFirmaModal").val()=="" || $(".observacion").val()==""){
      if($(".diferirFirmaModal").val()==""){
        $("#error_diferirFirmaModal").html("Debe dejar su firma");
      }
      if($(".observacion").val()==""){
        $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
      }
    }else{
      exec=true;
    }
    // alert(exec);
    if(exec==true){ 
      $(".btn-enviar-modalDiferidoConciliadores").removeAttr("disabled","");
      $(".btn-enviar-modalDiferidoConciliadores").click();
    }
  });
  $(".cerrarModalDiferirConciliadores").click(function(){
    $(".box-modalDiferirConcialiador").fadeOut(500);
  });

  $(".diferirPagoBtnAnalista").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var data = JSON.parse(response);
        console.log(data);
        if(data[0]['fotoPerfil']==""||data[0]['fotoPerfil']==null){
          var foto = "";
          if(data[0]['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data[0]['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data[0]['fotoPerfil']);
        }
        $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
        var year = data[0]['fecha_pago'].substr(0, 4);
        var mes = data[0]['fecha_pago'].substr(5, 2);
        var dia = data[0]['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".diferirFirmaAnalistaModal").val(data[0]['firma']);
        if(data[0]['observacion']=="Pendiente Por Entregar"){
          $(".optPendienteEntregar").attr("selected","selected");
        }
        if(data[0]['observacion']=="Billete Devuelto Pendiente por Sustituir"){
          $(".optPendienteSustituir").attr("selected","selected");
        }
        
      }
    });
    $(".box-modalDiferirAnalista").fadeIn(500);
  });
  $(".enviarModalDiferidoAnalista").click(function(){
    var exec = false;
    $("#error_diferirFirmaAnalistaModal").html("");
    $("#error_observacionModal").html("");
    // alert($(".diferirFirmaAnalistaModal").val());
    // alert($(".observacion").val());
    if($(".diferirFirmaAnalistaModal").val()=="" || $(".observacion").val()==""){
      if($(".diferirFirmaAnalistaModal").val()==""){
        $("#error_diferirFirmaAnalistaModal").html("Debe dejar su firma");
      }
      if($(".observacion").val()==""){
        $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
      }
    }else{
      exec=true;
    }
    // alert(exec);
    if(exec==true){ 
      $(".btn-enviar-modalDiferidoAnalista").removeAttr("disabled","");
      $(".btn-enviar-modalDiferidoAnalista").click();
    }
  });
  $(".cerrarModalDiferirAnalista").click(function(){
    $(".box-modalDiferirAnalista").fadeOut(500);
  });

  
  $(".aprobarPagoBtnConciliadores").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var data = JSON.parse(response);
        console.log(data);
        if(data[0]['fotoPerfil']==""||data[0]['fotoPerfil']==null){
          var foto = "";
          if(data[0]['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data[0]['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data[0]['fotoPerfil']);
        }
        $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
        var year = data[0]['fecha_pago'].substr(0, 4);
        var mes = data[0]['fecha_pago'].substr(5, 2);
        var dia = data[0]['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".firmaModal").val(data[0]['firma']);
        $(".leyendaModal").val(data[0]['leyenda']);




      }
    });
    $(".box-modalAprobarConcialiador").fadeIn(500);
  });
  $(".enviarModalAprobadoConciliadores").click(function(){
    var exec = false;
    $("#error_firmaModal").html("");
    $("#error_leyendaModal").html("");

    if($(".firmaModal").val()=="" || $(".leyendaModal").val()==""){
      if($(".firmaModal").val()==""){
        $("#error_firmaModal").html("Debe dejar su firma");
      }
      if($(".leyendaModal").val()==""){
        $("#error_leyendaModal").html("Debe agregar la leyenda del pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){ 
      $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
      $(".btn-enviar-modalAprobadoConciliadores").click();
    }
  });
  $(".cerrarModalAprobarConciliadores").click(function(){
    $(".box-modalAprobarConcialiador").fadeOut(500);
  });

  $(".aprobarPagoBtnAnalista").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        var data = JSON.parse(response);
        console.log(data);
        if(data[0]['fotoPerfil']==""||data[0]['fotoPerfil']==null){
          var foto = "";
          if(data[0]['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data[0]['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data[0]['fotoPerfil']);
        }
        $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
        var year = data[0]['fecha_pago'].substr(0, 4);
        var mes = data[0]['fecha_pago'].substr(5, 2);
        var dia = data[0]['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".firmaAnalistaModal").val(data[0]['firma']);
        $(".leyendaAnalistaModal").val(data[0]['leyenda']);
      }
    });
    $(".box-modalAprobarAnalista").fadeIn(500);
  });
  $(".enviarModalAprobadoAnalista").click(function(){
    var exec = false;
    $("#error_firmaAnalistaModal").html("");
    $("#error_leyendaAnalistaModal").html("");

    if($(".firmaAnalistaModal").val()=="" || $(".leyendaAnalistaModal").val()==""){
      if($(".firmaAnalistaModal").val()==""){
        $("#error_firmaAnalistaModal").html("Debe dejar su firma");
      }
      if($(".leyendaAnalistaModal").val()==""){
        $("#error_leyendaAnalistaModal").html("Debe agregar la leyenda del pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){ 
      $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
      $(".btn-enviar-modalAprobadoAnalista").click();
    }
  });
  $(".cerrarModalAprobarAnalista").click(function(){
    $(".box-modalAprobarAnalista").fadeOut(500);
  });

  $(".cerrarModal").click(function(){
    $(".box-modalEditar").fadeOut(500);
  });
  $(".enviarModal").click(function(){
    var exec = false;
    $("#error_tipoPagoModal").html("");
    $("#error_tasaModal").html("");

    if($(".tipo_pago").val()=="" || $(".tasaModal").val()==""){
      if($(".tipo_pago").val()==""){
        $("#error_tipoPagoModal").html("Debe seleccionar un concepto de pago");
      }
      if($(".tasaModal").val()==""){
        $("#error_tasaModal").html("Debe agregar la tasa del dolar");
      }
    }else{
      exec=true;
    }

    if(exec==true){ 
      $(".btn-enviar-modal").removeAttr("disabled","");
      $(".btn-enviar-modal").click();
    }
  });
  $(".editarPagoBtn").click(function(){
    var id = $(this).val();
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        // alert(response);
        var data = JSON.parse(response);
        console.log(data);
        if(data[0]['fotoPerfil']==""||data[0]['fotoPerfil']==null){
          var foto = "";
          if(data[0]['sexo']=="Femenino"){
            foto = "public/assets/img/profile/Femenino.png";
          }
          if(data[0]['sexo']=="Masculino"){
            foto = "public/assets/img/profile/Masculino.png";
          }
          $(".modal-img").attr("src",foto);   
        }else{
          $(".modal-img").attr("src",data[0]['fotoPerfil']);
        }
        $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);

        var year = data[0]['fecha_pago'].substr(0, 4);
        var mes = data[0]['fecha_pago'].substr(5, 2);
        var dia = data[0]['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
          // alert(data[0]['tasa_pago']);
        $(".id_pago_modal").val(id);
        if(data[0]['tasa_pago']!=null){
          $(".tasaModal").attr("value",data[0]['tasa_pago']);
        }else{
          $(".tasaModal").attr("placeholder","0.00");
        }
        if(data[0]['tipo_pago']=="Inicial"){
          $(".optIncial").attr("selected","selected");
        }
        if(data[0]['tipo_pago']=="Primer Pago"){
          $(".optPrimer").attr("selected","selected");
        }
        if(data[0]['tipo_pago']=="Cierre"){
          $(".optCierre").attr("selected","selected");
        }
        $(".box-modalEditar").fadeIn(500);
      }
    });
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

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea restaurar los datos?",
          text: "Se restauraran los datos escogidos, ¿desea continuar?",
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
                    title: "¿Esta seguro de restaurar los datos?",
                    text: "Se restauraran los datos ¿desea continuar?",
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
