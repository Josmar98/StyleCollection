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
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
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

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="font-size:2em;"><?php if(!empty($action)){echo $action;} echo " ".$modulo ?></h3>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <br>
              <div class="row">
                <div class="col-xs-12">
                  <div class="container">
                    <div class="user-block">
                      <?php
                        $fotoPerfilActual = "public/assets/img/profile/";
                        if($pedido['sexo']=="Femenino"){$fotoPerfilActual .= "Femenino.png";}
                        if($pedido['sexo']=="Masculino"){$fotoPerfilActual .= "Masculino.png";} 
                        if($pedido['fotoPerfil']!=""){
                          $fotoPerfilActual = $pedido['fotoPerfil'];
                        }
                      ?>
                      <img class="img-circle img-bordered-sm" src="<?=$fotoPerfilActual; ?>" alt="user image">
                      <span class="username">
                        <?php 
                          $enviarPerfil="";
                          if($pedido['id_cliente']==$_SESSION['home']['id_cliente']){
                            $enviarPerfil="route=Perfil";
                          }else{
                            $enviarPerfil="route=Clientes&action=Detalles&id=".$pedido['id_cliente'];
                          }
                        ?>
                        <a href="?<?=$enviarPerfil; ?>">
                          <?php echo $pedido['primer_nombre']." ".$pedido['primer_apellido']; ?>  
                        </a>
                      </span>
                      <span class="description">
                        Pedido solicitado - <?=$lider->formatFecha($pedido['fecha_pedido']); ?> a las <?php echo $pedido['hora_pedido']; ?> | 
                        Pedido aprobado - <?=$lider->formatFecha($pedido['fecha_aprobado']); ?> a las <?php echo $pedido['hora_aprobado']; ?>
                        <br>
                      </span>
                    </div>
                  </div>
                  <br>
                </div>
              </div>

              <hr>
              <div class="row text-center" style="padding:10px 20px;">
                <?php
                  $ruta = "";
                  if($pedido['id_cliente']==$_SESSION['home']['id_cliente']){
                    $ruta = "Pagos";
                  }else{
                    $ruta = "Pagos&admin=1&lider=".$pedido['id_cliente'];
                  }
                ?>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
              </div>
              <div class="" style="background:<?=$nivelLider['color_liderazgo']; ?>33;border:1px solid #EFEFEF;color:#444;width:100%;padding:15px 30px 0px 30px;border-radius:5px">
                <?php if($accesoEstadosE){ ?>
                  <?php if($notaExistente==0){ ?>
                  <b style="float:left;"><button class="btnEliminar" style="background:none;border:none;color:<?=$colorPrimaryAll; ?>" value="?<?=$menu; ?>&route=Chome&action=Eliminar&id=<?=$pedido['id_pedido']; ?>&admin=1"><u><i>Eliminar Factura</i></u></button></b>
                  <?php } ?>
                <?php } ?>
                <?php if($accesoEstadosM){ ?>
                  <?php if($notaExistente==0){ ?>
                  <div class="hidden-md hidden-sm hidden-lg"><br><br></div>
                  <b style="float:right;"><button class="btnModificar" style="background:none;border:none;color:<?=$colorPrimaryAll; ?>" value="?<?=$menu; ?>&route=Chome&action=Modificar&id=<?=$pedido['id_pedido']; ?>"><u><i>Editar Factura</i></u></button></b>
                  <br>
                  <?php } ?>
                <?php } ?>


                <div class="box-header">
                  <div class="container" style="width:100%;margin-top:0px;">

                    <div class="row">
                      <div class="col-md-4 text-left">
                        <br>
                        <span style="font-size:1.2em;color:#000;"><b>Factura aprobada: </b></span>
                        <span style="font-size:1.4em;color:#0C0;"><b><?="$".number_format($pedido['cantidad_aprobada'],2,',','.'); ?></b></span>
                      </div>

                      <div class="col-md-4 text-left">
                        <!-- <span style="font-size:1.1em;color:#000;"><b>Colecciones aprobadas: </b></span> -->
                        <!-- <span style="font-size:1.3em;color:#7C4;"><b><?php echo $cantidad_aprobado ?></b></span> -->
                      </div>

                      <div class="col-md-4 text-right">
                        <br>
                        <span style="font-size:1.1em;color:#000;"><b>Factura acumulada: </b></span>
                        <span style="font-size:1.1em;color:;"><b><?="$".number_format($pedido['cantidad_facturaTotal'],2,',','.'); ?></b></span>
                        <br>
                      </div>
                    </div>

                    <br>
                    <div class="row" style="border-radius:50%;text-align:right;display:inline-block;float:right;padding:5px 20px 20px 20px;">
                      <div style="text-align:center;width:100%;color:#FFF;text-shadow:0px 0px 3px #000;font-size:1.2em;"><b>Puntos</b></div>
                      <div style="display:inline-block;">
                        <span style="text-align:left;">
                            <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-right:50px;font-size:1.1em;"><small><b>Disponibles</b></small></span>
                            <br>
                            <div class="" style="background:#FFF;border-radius:100px;display:inline-block;rotate:50;">
                              <!-- <img style="width:70px;padding:0;margin:0;position:relative;left:-10px;top:3px;" src="<?=$fotoGema?>"> -->
                              <!-- <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px"> -->
                              <span style="color:<?=$fucsia?>;padding:15px;">
                                <b style="font-size:1.5em"><?=number_format($puntosDisponiblesCliente,2,',','.'); ?></b> pts
                              </span>
                            </div>
                        </span>
                      </div>
                      <div style="display:inline-block;">
                        <span style="text-align:right;">
                            <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-left:30px;font-size:1.1em;"><small><b>Bloqueados</b></small></span>
                            <br>
                            <div class="" style="background:#FFF;border-radius:100px;display:inline-block;">
                              <!-- <img style="width:30px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>"> -->
                              <!-- <span style="color:#00000055;position:relative;top:3px;left:-12px"> -->
                              <span style="color:#00000055;padding:10px;">
                                <b style="font-size:1em"><?=number_format($puntosBloqueadosCliente,2,',','.'); ?></b> pts
                              </span>
                            </div>
                        </span>
                      </div>
                    </div>
                    <div style="clear:both;"></div>
                    <br>

                    <div class="box-body">
                      <div class="container text-center" style="width:100%;">

                        <div class="row">
                            <div class="col-md-4 ">
                              <span style="font-size:1.1em;color:#000;"><b>Líder</b></span>
                              <br>
                              <span style="font-size:1.5em;color:<?php echo $color_btn_sweetalert; ?>">
                                <b>
                                  <?php if(is_file("public/assets/img/liderazgos/{$nivelLider['nombre_liderazgo']}logo.png")){ ?>
                                    <img src="public/assets/img/liderazgos/<?=$nivelLider['nombre_liderazgo']; ?>logo.png" style="width:40px;">        
                                  <?php } ?>
                                  <?php if(is_file("public/assets/img/liderazgos/{$nivelLider['nombre_liderazgo']}txt.png")){ ?>
                                    <img src="public/assets/img/liderazgos/<?=$nivelLider['nombre_liderazgo']; ?>txt.png" style="width:40px;">        
                                  <?php } else { ?>
                                    <?=ucwords(mb_strtolower($nivelLider['nombre_liderazgo'])); ?>
                                  <?php } ?>
                                </b>
                              </span>
                            </div>

                            <div class="col-md-4">
                              <span style="font-size:1.1em;color:#000;"><b>Total Costo</b></span>    
                                <br>
                              <span style="font-size:1.5em;">
                                <u><b>$<?php echo number_format($pedido['cantidad_aprobada'],2,',','.') ?></b></u>
                              </span>
                            </div>

                            <div class="col-md-4">
                              <span style="font-size:1.1em;color:#000;"><b>Descuento por nivel de Liderazgo</b></span>    
                              <table class="col-xs-12" style="font-size:0.9em;">
                                <?php $total_descuento_distribucion=0; ?>
                                <?php foreach ($liderazgosAll as $data){ if (!empty($data['id_liderazgo'])){ ?>
                                  <?php if ($nivelLider['id_liderazgo'] >= $data['id_liderazgo']): ?>
                                    <tr>
                                      <td style="padding-right:10px">
                                        <b>
                                          <?php echo $data['nombre_liderazgo']; ?>
                                        </b>
                                      </td>
                                      <td>
                                        <b style="color:<?=$color_btn_sweetalert; ?>">
                                          <?php echo "$".number_format($pedido['cantidad_aprobada'],2,',','.'); ?>
                                        </b>
                                      </td>
                                      <td> <span style="padding-right:5px;padding-left:5px">x</span> </td>
                                      <td style="padding-left:10px;">
                                        <b>
                                          <?php echo number_format($data['descuento_liderazgos'],2)."%"; ?>
                                        </b> 
                                      </td>
                                      <td> <span style="padding-right:5px;padding-left:5px">=</span> </td>
                                      <td>
                                        <b style="color:#0c0;">
                                          <?php 
                                            $t = ($pedido['cantidad_aprobada']/100)*$data['descuento_liderazgos'];
                                            $total_descuento_distribucion+=$t;
                                            echo "$".number_format($t,2,',','.');
                                          ?>
                                        </b>
                                      </td>
                                    
                                    </tr>
                                  <?php endif ?>
                                <?php } } ?>
                                <tr>
                                  <td colspan="6" style="border-bottom:1px solid #777"></td>
                                </tr>
                                <tr>
                                  <td></td>
                                  <td colspan="3">
                                    <span style="font-size:1.2em">
                                      <b>Total</b>
                                    </span>
                                  </td>
                                  <td> 
                                    <span style="font-size:1.2em;padding-right:5px;padding-left:5px;">
                                      <b>=</b>
                                    </span> 
                                  </td>
                                  <td colspan="">
                                    <span style="font-size:1.5em;color:#0C0">
                                      <b>$<?php echo number_format($total_descuento_distribucion,2,',','.') ?></b>
                                    </span>
                                  </td>
                                </tr>
                              </table>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                          <div class="col-xs-12 col-md-8"  style="margin-bottom:20px;">
                            <table class="table table-stripped table_liderazgos_pedidos" style="text-align:center;font-size:.9em;margin-top:0;margin-top:-2%;">
                              <thead>
                                <tr>
                                  <th style="font-size:1em;background:#FFFFFF33">Liderazgo</th>
                                  <th style="font-size:1em;background:#DDDDDD33">Alcance</th>
                                  <th style="font-size:1em;background:#FFFFFF33">Descuento Individual</th>
                                  <th style="font-size:1em;background:#DDDDDD33">Descuento Acumulado</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                  $num = 1; 
                                  foreach ($liderazgosAll as $data){ if(!empty($data['id_liderazgo'])){ ?>
                                  <tr style="background:<?=$data['color_liderazgo']?>33;">
                                    <td style="width:25%;padding:5px 10px;">
                                      <span class="contenido2" >
                                        <b style="color:<?=$data['color_liderazgo']?>;text-shadow:0px 0px 1px <?=$data['color_liderazgo']?>">
                                          <?php if(is_file("public/assets/img/liderazgos/{$data['nombre_liderazgo']}txt.png")){ ?>
                                             <img src="public/assets/img/liderazgos/<?=$data['nombre_liderazgo']?>txt.png" style="width:70px">         
                                          <?php } else { ?>
                                             <?php echo $data['nombre_liderazgo']; ?> 
                                          <?php } ?>
                                        </b>
                                      </span>
                                    </td>
                                    <td style="width:40%">
                                      <span class="contenido2">
                                        <?php
                                          if($data['precio_maximo']==0){
                                            echo "$".number_format($data['precio_minimo'],2,',','.')." - "."$".number_format($data['precio_minimo'],2,',','.')."+"; 
                                          }else{
                                            echo "$".number_format($data['precio_minimo'],2,',','.')." - "."$".number_format($data['precio_maximo'],2,',','.'); 
                                          }
                                        ?>
                                      </span>
                                    </td>
                                    <td style="width:15%">
                                      <span class="contenido2"><?php echo number_format($data['descuento_liderazgos'],2)."%"; ?></span>
                                    </td>
                                    <td style="width:15%">
                                      <span class="contenido2"><?php echo number_format($data['descuento_total'],2)."%"; ?></span>
                                    </td>
                                  </tr>
                                    <?php $num++;  
                                 } } 
                                ?>

                              </tbody>
                              </table>
                          </div>
                          <div class="col-xs-12 col-md-4">
                            <br>
                            <?php  
                              $totalDescuentoFactura = 0;
                              $totalDescuentoFactura += $total_descuento_distribucion;
                            ?>
                            <span style="font-size:1.3em"><b>Total Descuento = </b><b style="color:#0c0"><?php  echo"$".number_format($totalDescuentoFactura,2,',','.'); ?></b></span>
                          </div>
                        </div>

                        <div class="row">
                          <?php
                            $total_responsabilidad = $pedido['cantidad_aprobada'];
                            $total_responsabilidad -= $totalDescuentoFactura;

                            $resto = $total_responsabilidad;
                            $resto -= $abonado;
                            $resto += $excedentesPagados;
                          ?>
                          <div class="col-md-4" style="background:;position:relative;top:5px">
                            <br>
                            <span style="font-size:1.3em;color:#222;"><b><u>Total a pagar</u></b></span>    
                            <br>

                            <span style="font-size:2em;color:#00C;">
                              <b>$<?php echo number_format($total_responsabilidad,2,',','.') ?></b>
                            </span>
                          </div>
                          <div class="col-md-4" style="background:;position:relative;top:5px">
                            <br>
                            <span style="font-size:1.3em;color:#222;"><b><u>Resta</u></b></span>    
                            <br>

                            <span style="font-size:2em;color:#C00;">
                              <b>$<?php echo number_format($resto,2,',','.') ?></b>
                            </span>
                          </div>
                          <div class="col-md-4" style="background:;position:relative;top:5px">
                            <br>
                            <span style="font-size:1.3em;color:#222;"><b><u>Abonado</u></b></span>    
                            <br>

                            <span style="font-size:2em;color:#0C0;">
                              <b>$<?php echo number_format($abonado,2,',','.') ?></b>
                            </span>
                          </div>

                        </div>


                        <!-- BLOQUE DE LOGICA UTILIZADO PARA GEMAS Y EXCEDENTES -->
                          <?php
                            $mensajeAbonosPuntuales = "Abonado hasta la fecha ".$lider->formatFecha($cuotaFinal['fecha_pago_cuota']).": $".number_format($abonadoPuntual,2,',','.');
                            $nAbonadoPuntual = 0;
                            $excedente = 0;
                            if($abonadoPuntual > $total_responsabilidad){
                              $excedente = $abonadoPuntual-$total_responsabilidad;
                              $nAbonadoPuntual = $total_responsabilidad;
                            }else{
                              $nAbonadoPuntual = $abonadoPuntual;
                            }
                            $porcentajeAbonadoPuntual = (($nAbonadoPuntual*100)/$total_responsabilidad);
                            $mensajeAbonosPuntuales .= " (".number_format($porcentajeAbonadoPuntual,2,',','.')."%)";
                            $excedente -= $excedentesPagados;

                            $porcentajePuntosReclamar = ($porcentajeAbonadoPuntual/100)*$puntosReclamarTotal;
                            $porcentajePuntosReclamar = $puntosBloqueadoParaDesbloquearID;
                          ?>
                        <!-- BLOQUE DE LOGICA UTILIZADO PARA GEMAS Y EXCEDENTES -->

                        <!-- BLOQUE QUE INFORMA EL PORCENTAJE DE ABONO PUNTUAL EN EL CICLO -->
                          <?php //if($cuotaFinal['fecha_pago_cuota'] <= $fechaActual){ ?>
                            <!-- <div class="row">
                              <div class="col-xs-12" style="text-align:right;">
                                <br>
                                <span>
                                  <small><?=$mensajeAbonosPuntuales; ?></small>
                                </span>
                              </div>
                            </div> -->
                          <?php //} ?>
                        <!-- BLOQUE QUE INFORMA EL PORCENTAJE DE ABONO PUNTUAL EN EL CICLO -->

                        <!-- MANEJO DE EXCEDENTES -->
                          <?php if($excedentesPagados>0){ ?>
                            <style>.modalDescripcionExcedente:hover{ text-decoration:underline;  }</style>
                            <span style="color:#000;" class="modalDescripcionExcedente">
                              <b>Excedente pagado $<?=number_format($excedentesPagados,2,',','.') ?></b>
                            </span>
                            <br><br>
                          <?php } ?>
                          <?php if($accesoExcedentesR){ ?>
                            <?php if($excedente>0){ ?>
                              <div class="row">
                                <div class="col-xs-12">
                                  <button class="btn btn-danger btnAbrirExcedentes PagarExcedente" value="<?=$excedente; ?>" style="background:red;">Pagar Excedente</button>
                                </div>
                              </div>
                            <?php } ?>
                          <?php } ?>
                        <!-- MANEJO DE EXCEDENTES -->

                        <!-- BOTON BLOQUE PARA RECLAMAR GEMAS -->
                          <?php //if($cuotaFinal['fecha_pago_cuota'] <= $fechaActual){  ?>
                          <?php if($abonado >= $total_responsabilidad){ ?>
                            <?php if($puntosReclamarBloq>0){ ?>
                              <br>
                              <div class="row">
                                <div class="col-xs-12" style="border:1px solid #CCC;">
                                    <div>
                                      <input type="hidden" id="cantidadPuntosLider" value="<?=number_format($puntosReclamarTotal,2,',','.')?>">
                                      <input type="hidden" id="porcentajePuntosObtenido" value="<?=number_format($porcentajePuntosReclamar,2,',','.')?>">

                                      <?php if($pedido['id_cliente']==$_SESSION['home']['id_cliente']){ ?>
                                        <button class="btn enviar2 reclamarGemasPorcentajeBtn col-xs-12" value="?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$id; ?>&puntos=<?=$puntosReclamarID;?>&reclamar=PorcentPuntos&porcentaje=<?=$porcentajePuntosReclamar;?>">
                                          <!-- <span class="fa fa-diamond"></span> -->
                                          Reclamar Puntos 
                                          <!-- <span class="fa fa-diamond"></span> -->
                                        </button>
                                      <?php } else { ?>
                                        <button class="btn col-xs-12" style="background:#CCC !important;">
                                          <!-- <span class="fa fa-diamond"></span> -->
                                          Reclamar Puntos 
                                          <!-- <span class="fa fa-diamond"></span> -->
                                        </button>
                                      <?php } ?>
                                    </div>
                                </div>
                              </div>
                              <br>
                            <?php } ?>
                          <?php } ?>
                        <!-- BOTON BLOQUE PARA RECLAMAR GEMAS -->
                        <br>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta;?>">
                    <b style="color:#000 !important">Reportado</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>">
                    <b style="color:#000 !important">Diferido</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  </a>
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>">
                      <b style="color:#000 !important">Abonado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  </a>
                  <?php  ?>
                </div>
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

  <div class="box-modalExcedente" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
    <div class="content">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <div class="container-fluid">
            <div class="box">
                <div class="box-header with-border">
                  <div style="text-align:right;"><span class="btn cerrarModalExcedente" style="background:#CCC"><b>X</b></span></div>
                  <div class="user-block">
                    <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilActual; ?>" alt="user image">
                    <span class="username">
                      <h4><?=$pedido['primer_nombre']." ".$pedido['primer_apellido']?></h4>
                    </span>
                  </div>
                    <br>
                    <h3 class="box-title">Pago de Excendente </h3>
                </div>

         
              <div action="" method="POST" class="form">
                  <div class="row">
                    <div class="col-xs-12" style="padding:1% 5%;font-size:1.3em;">
                        <?php 
                          $restoDisponiblePositivo = number_format($excedente,2,',','.');
                        ?>
                        Se va a realizar la devolución de excedentes a
                        líder <?=$pedido['primer_nombre']." ".$pedido['primer_apellido']?>
                        <br>
                        Por precio maximo de: 
                        <b>$<?=$restoDisponiblePositivo;?></b>
                    </div>
                    <input type="hidden" class="id_pedido_excedente" value="<?=$_GET['id']; ?>">
                    <input type="hidden" class="cantidad_excedente_max" value="<?=$excedente; ?>">
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label for="cantidad_excedente" style="width:95%;min-width:95%;max-width:95%;margin-left:5%;">Monto: </label>
                        <input type="number" id="cantidad_excedente" class="form-control cantidad_excedente" min="0" max="<?=$excedente; ?>" style="width:95%;min-width:95%;max-width:95%;margin:auto;" step="0.01" value="0">
                      </div>
                    </div>
                    <div class="col-xs-12">
                      <div class="form-group">
                        <label for="descripcion_excedente" style="width:95%;min-width:95%;max-width:95%;margin-left:5%;">Descripcion: </label>
                        <textarea id="descripcion_excedente" class="form-control descripcion_excedente" style="width:95%;min-width:95%;max-width:95%;margin:auto;height:5em;min-height:5em;max-height:5em;" maxlength="355"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalExcedente">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalExcedente d-none" disabled="" >enviar</button>
                  </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 
  <div class="box-modalDescripcionExcedente" style="display:none;background:#00000099;position:fixed;top:0;left:0;width:100%;height:100vh;padding-top:50px;z-index:1050">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalDescripcionExcedente" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilActual; ?>" alt="user image">
                      <span class="username">
                        <h4><?=$pedido['primer_nombre']." ".$pedido['primer_apellido']?></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Descripcion del pago de Excendente </h3>
                  </div>

           
                <div action="" method="POST" class="form">
                    <div class="row">
                      <div class="col-xs-12" style="padding:1% 5%;font-size:1.3em;">
                          Se realizo el pago de excedentes
                          lider <?=$pedido['primer_nombre']." ".$pedido['primer_apellido']?>
                          <br>
                          Por precio total de: 
                          <?php 
                            // $restopositivo = ($restaTotalResponsabilidad * (-1));
                            $excedenteDisponiblePositivo = number_format($excedentesPagados,2,',','.');
                            // echo $excedenteDisponiblePositivo;
                          ?>

                          <b>$<?=$excedenteDisponiblePositivo;?></b>
                        <div class="form-group">
                            <small><i>Detalle: </i></small>
                          <div class="" style="border:1px solid #DDD;padding:1%;font-size:.9em;">
                            <b>
                              <span class="contenido2">
                                <?php
                                  $limiteCantidadIntento = count($excedentes)-1;
                                  $intentosCantidad = 0;
                                  foreach ($excedentes as $exced){ if(!empty($exced['id_excedente'])){
                                    $intentosCantidad++;
                                    echo "Monto: $".number_format($exced['cantidad_excedente'],2,',','.')."<br>";
                                    echo "Descrición: ".$exced['descripcion_excedente']."<br>";
                                    if($intentosCantidad < $limiteCantidadIntento){
                                      echo "<div style='background:#CCC; width:102%; height:1px; padding:-1%; margin:1% -1%; '></div>";
                                    }
                                  } }
                                ?>
                              </span>
                            </b>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="box-footer">
                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
  </div>  


  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)){ ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php } ?>
<?php if(!empty($responsePts)){ ?>
<input type="hidden" class="responsePts" value="<?=$responsePts; ?>">
<input type="hidden" class="puntosdisponibles" value="<?=number_format($puntosDisponiblesCliente,2,',','.');?>">
<input type="hidden" class="puntosbloqueadas" value="<?=number_format($puntosBloqueadosCliente,2,',','.');?>">
<?php } ?>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
    var responsePts = $(".responsePts").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
        type: 'success',
        title: '¡Pedido aprobado correctamente!',
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        // window.location = "?<?=$menu; ?>&route=CHome";
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
  if(responsePts==undefined){
  }else{

    if(responsePts == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
    if(responsePts=="1"){
      var dispo = $(".puntosdisponibles").val();
      var bloqe = $(".puntosbloqueadas").val();
        swal.fire({
            type: 'success',
            title: "<p style='color:<?=$colorPrimaryAll; ?>'>Puntos Disponibles: "+dispo+"</p> <br> <p style='color:#C00'>Puntos Bloqueados: "+bloqe+"</p>",
            text: '¡Ya sus Puntos han sido reclamadas con exito!',
            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        }).then(function(){
          window.location = "?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$id;?>";
        });
    }
  }

  $(".btnModificar").click(function(){
    swal.fire({ 
      title: "¿Desea modificar la factura?",
      text: "Se movera a la interfaz para modificar los datos, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        });
      } 
    });
  });

  $(".btnEliminar").click(function(){
      swal.fire({ 
          title: "¿Desea eliminar la factura?",
          text: "Se Borraran todos los datos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de eliminar la factura?",
                    text: "Se borraran los datos de la factura, ¿desea continuar?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                        });
                    } 
                });

          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                            confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });


  $(".btnAbrirExcedentes").click(function(){
    $(".box-modalExcedente").fadeIn(500);
  });
  $(".cerrarModalExcedente").click(function(){
    $(".box-modalExcedente").fadeOut(500);
  });
  $(".cantidad_excedente").on("input", function(){
    var val = parseFloat($(this).val());
    var max = parseFloat($(".cantidad_excedente_max").val());
    if(val > max){
      $(this).val(max);
    }
    if(val < 0){
      $(this).val(0);
    }
  });
  $(".enviarModalExcedente").click(function(){
    var id = $(".id_pedido_excedente").val();
    var cantidad = $(".cantidad_excedente").val();
    var description = $(".descripcion_excedente").val();
    // alert(id);
    cantidad = parseFloat(cantidad)
    // alert(cantidad);  

    swal.fire({ 
      title: "¿Desea guardar la cantidad ("+cantidad.toFixed(2)+") como excedente pagado?<br>¿Desea continuar?",
      text: "Se guardaran estos cambios y se actualizará el excedente por pagar.",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      confirmButtonText: "¡Confirmar!",
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
              cerrarExcedenteLider: true,
              cantidad_excedente: cantidad,
              descripcion_excedente: description,
            },
            success: function(respuesta){
              // alert(respuesta);
              if (respuesta == "1"){
                swal.fire({
                  type: 'success',
                  title: '¡Excedente pagado correctamente!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                }).then(function(){
                  window.location = "?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$id ;?>";
                });
              }
              if (respuesta == "2"){
                swal.fire({
                  type: 'error',
                  title: '¡No se pudo guardar el cambio!',
                  text: 'Vuelva a intentar, si el error persiste comuniquese con el soporte',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                });
              }
              if (respuesta == "9"){
                swal.fire({
                  type: 'warning',
                  title: '¡El excedente ya fue pagado!',
                  text: 'Ya existe un excedente aplicado a esta factura',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                });
              }
              if (respuesta == "5"){ 
                swal.fire({
                  type: 'error',
                  title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                });
              }
            }
        });
          
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        });
      } 
    });
  });

  $(".modalDescripcionExcedente").click(function(){
    $(".box-modalDescripcionExcedente").fadeIn(500);
  });
  $(".cerrarModalDescripcionExcedente").click(function(){
    $(".box-modalDescripcionExcedente").fadeOut(500);
  });

  $(".reclamarGemasPorcentajeBtn").click(function(){
    var cantidadPuntos = $("#cantidadPuntosLider").val();
    var porcentajePuntos = $("#porcentajePuntosObtenido").val();
     swal.fire({ 
          title: "¿Desea reclamar sus puntos? <br> Puede reclamar "+porcentajePuntos+" pts de sus "+cantidadPuntos+" pts?",
          text: "Sus puntos reclamados pasarán a estar disponibles. ¿Desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Reclamar Gemas!",
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
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });

});  
</script>
</body>
</html>
