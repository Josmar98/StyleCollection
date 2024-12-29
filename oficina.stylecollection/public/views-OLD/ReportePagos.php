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
        <?php echo "Pagos"; ?>
        <small><?php echo "Ver Reporte de pagos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pagos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "Reporte de pagos";} ?></li>
      </ol>
    </section>
              <br>
    <!-- Main content -->
    <section class="content">
      <div class="row">

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

        
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box"> 

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "Reporte de Pagos"; ?></a></h3>
            </div>
            <!-- /.box-header -->
            <?php
              $mes = date("m");
              switch ($mes) {
                case '01':
                  $mes = "Enero";
                  break;
                case '02':
                  $mes = "Febrero";
                  break;
                case '03':
                  $mes = "Marzo";
                  break;
                case '04':
                  $mes = "Abril";
                  break;
                case '05':
                  $mes = "Mayo";
                  break;
                case '06':
                  $mes = "Junio";
                  break;
                case '07':
                  $mes = "Julio";
                  break;
                case '08':
                  $mes = "Agosto";
                  break;
                case '09':
                  $mes = "Septiembre";
                  break;
                case '10':
                  $mes = "Octubre";
                  break;
                case '11':
                  $mes = "Noviembre";
                  break;
                case '12':
                  $mes = "Diciembre";
                  break;
              }
            ?>  

            <style>
              .text-xs {
                font-size:1.2em;
              }
              .text-xs2{
                position:absolute;display:block;width:100%;text-align:center;
              }
              .text-xs1 {
                font-size:1.2em;
              }
            @media (max-width: 768px) {
              .text-xs {
                font-size:1em;
              }
              .text-xs1 {
                font-size:1.2em;
              }
              .text-xs2{
                position:inline-block;display:block;width:100%;text-align:left;margin-left:5%;
              }
            }
            @media (max-width: 308px) {
              .text-xs3{
                margin-top:15%;
              }

            }
          </style>

            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-md-12" style="text-align:right;">
                      <form action="" method="get" target="_blank">
                        <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                        <input type="hidden" value="<?=$numero_campana;?>" name="n">
                        <input type="hidden" value="<?=$anio_campana;?>" name="y">
                        <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                        <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                        <input type="hidden" value="ExportarReportePagos" name="route">
                        <!-- <input type="hidden" value="Exportar" name="action"> -->
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
                        <?php if(!empty($_GET['Banco'])){ ?>
                        <input type="hidden" value="<?=$_GET['Banco']?>" name="Banco">
                        <?php } ?>
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>
                        <button class="btn btn-success"><b>Exportar a Excel  
                          <span class="fa fa-file-excel-o" style="color:#FFF;margin-left:5px;"></span>
                        </b></button>
                          <!-- <img src="public/assets/img/excel_icon.png" style="width:20px;"> -->
                      </form>
                    </div>


                    <div class="col-xs-12 col-sm-12" style="text-align:left;">
                      <h3 style="margin-left:2%;">Reporte de Pagos Campaña <?=$numero_campana?>/<?=$anio_campana?></h3>
                    </div>
                  </div>

                
                <br>
                <br>

              <?php $reporteGeneral = $opcionesPagos[0]; ?>

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-12" style="font-size:1.2em;padding:5px 0px;background:#CCC;border:1px solid #ccc">
                  <b class="text-xs" style="float:left;margin-left:5%;">
                    <?php echo mb_strtoupper("Reporte de Conciliacion"); ?>
                  </b>
                  <b class="text-xs" style="float:right;margin-right:5%;">
                    <?php echo "Al ".date('d').'-'.$mes." ".date("h:i a"); ?>
                  </b>
                  <div style="clear:both;"></div>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <b style="color:#000 !important">Reportado<br>General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 class='text-xs' style="color:#0000FF !important"><b>$<?=number_format($reporteGeneral['reportado'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <b style="color:#000 !important">Diferido<br>General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 class='text-xs' style="color:#FF0000 !important"><b>$<?=number_format($reporteGeneral['diferido'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Abonado<br>General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 class='text-xs' style="color:#00FF00 !important"><b>$<?=number_format($reporteGeneral['abonado'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-12 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Pendiente Por Coinciliar<br>General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 class='text-xs1' style="color:rgba(0,0,255,.6); !important"><b>$<?=number_format($reporteGeneral['pendiente'], 2, ",", ".")?></b></h4>
                </div>
              </div>

              <hr style="border:1px solid #ccc">



              <?php foreach ($opcionesPagos as $report): ?>
                <?php if ($report['condicion']!=""): ?>
                  <?php if ($report['reportado']>0): ?>
                  
              <div class="row text-center" style="padding:10px 20px;">
                <div style="border:1px solid #767676;">
                  
                  <div class="col-xs-12" style="font-size:1.1em;padding:5px 0px;background:#CCC;border:1px solid #ccc">
                    <b class="text-xs2" style="">
                    <!-- <b style="float:left;margin-left:5%;"> -->
                      <?php echo mb_strtoupper("Reporte"); ?>
                    </b>
                    <b class="text-xs3" style="float:right;margin-right:5%;">
                      <?php echo "Al ".date('d').'-'.$mes." ".date("h:i a"); ?>
                    </b>
                  </div>
                  <div class="col-xs-12" style="font-size:1.1em;padding:5px 0px;background:;border:1px solid #ccc">
                    <b style="text-align:center;">
                      <?php echo mb_strtoupper($report['titulo']); ?>
                    </b>
                  </div>
                  <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Reportado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                      <h4 class='text-xs' style="color:#0000FF !important"><b>$<?=number_format($report['reportado'], 2, ",", ".")?></b></h4>
                  </div>
                  <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Diferido</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                      <h4 class='text-xs' style="color:#FF0000 !important"><b>$<?=number_format($report['diferido'], 2, ",", ".")?></b></h4>
                  </div>
                  <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                        <b style="color:#000 !important">Abonado</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 class='text-xs' style="color:#00FF00 !important"><b>$<?=number_format($report['abonado'], 2, ",", ".")?></b></h4>
                  </div>
                  <div class="col-xs-12 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                        <b style="color:#000 !important">Pendiente por Coinciliar</b>
                        <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                        <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                        <h4 class='text-xs1' style="color:rgba(0,0,255,.6); !important"><b>$<?=number_format($report['pendiente'], 2, ",", ".")?></b></h4>
                  </div>
                  <div style="clear:both;"></div>

                </div>
              </div>
              <br>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endforeach; ?>



              <hr style="border:1px solid #ccc">

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-12" style="font-size:1.2em;padding:5px 0px;background:#CCC;border:1px solid #ccc">
                  <b class="text-xs" style="float:left;margin-left:5%;">
                    <?php echo mb_strtoupper("Reporte de Conciliacion"); ?>
                  </b>
                  <b class="text-xs" style="float:right;margin-right:5%;">
                    <?php echo "Al ".date('d').'-'.$mes." ".date("h:i a"); ?>
                  </b>
                  <div style="clear:both;"></div>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <b style="color:#000 !important">Reportado<br>General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 class='text-xs' style="color:#0000FF !important;"><b>$<?=number_format($reporteGeneral['reportado'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                    <b style="color:#000 !important">Diferido<br>General</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 class='text-xs' style="color:#FF0000 !important;"><b>$<?=number_format($reporteGeneral['diferido'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-4 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Abonado<br>General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 class='text-xs' style="color:#00FF00 !important;"><b>$<?=number_format($reporteGeneral['abonado'], 2, ",", ".")?></b></h4>
                </div>
                <div class="col-xs-12 col-md-3" style="padding:10px 0px;background:;border:1px solid #ccc">
                      <b style="color:#000 !important">Pendiente Por Coinciliar<br>General</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 class='text-xs1' style="color:rgba(0,0,255,.6) !important;"><b>$<?=number_format($reporteGeneral['pendiente'], 2, ",", ".")?></b></h4>
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
                      <!-- <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3> -->
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
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" id="rol" name="rol" value="Analistas">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tipo_pago">Concepto de pago</label>
                           <select class="form-control tipo_pago" id="tipo_pago"  name="tipo_pago" style="width:100%;z-index:91000">
                             <option></option>
                             <option class="optContado">Contado</option>
                             <option class="optInicial">Inicial</option>
                             <option class="optPrimer">Primer Pago</option>
                             <option class="optCierre">Segundo Pago</option>
                           </select>
                           <span id="error_tipoPagoModal" class="errors"></span>
                        </div>
                        <input type="hidden" id="id_pago_modal" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tasa">Tasa del dolar</label>
                           <input type="number" class="form-control tasaModal" value="" step="0.01" min="<?=$limiteFechaMinimo?>" name="tasa" id="tasa" max="<?=date('Y-m-d')?>">
                           <span id="error_tasaModal" class="errors"></span>
                        </div>
                    </div>
                  </div>
                  <div>
                    <div class="form-group col-xs-12" style="text-align:right;">
                      <span class="name_conciliador"></span>
                      <span class="name_leyenda"></span>
                      <span class="name_observ"></span>
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

  <div class="box-modalEditarConciliador" style="display:none;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalConciliador" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilCliente?>" alt="user image">
                      <span class="username">
                        <h4><span class="nameUserPago"></span></h4>
                      </span>
                    </div>
                      <br>
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>
                  <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>
                

                  <div>
                    <div class="form-group col-xs-12" style="text-align:right;font-size:1.2em;">
                      <span class="name_conciliador"></span>
                      <span class="name_leyenda"></span>
                      <span class="name_observ"></span>
                    </div>
                  </div>
                  <div class="box-footer">
                    <!-- <span type="submit" class="btn enviar enviarModal">Enviar</span> -->
                    <!-- <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>"> -->
                    <!-- <button class="btn-enviar-modal d-none" disabled="" >enviar</button> -->
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
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php
                          $primer_nombre = $_SESSION['cuenta']['primer_nombre']; 
                          $primer_apellido = $_SESSION['cuenta']['primer_apellido'];
                        ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firma">Firma</label>
                           <input type="hidden" value="<?=$primer_nombre." ".$primer_apellido?>" class="newFirma" name="newFirma">
                           <input type="text" class="form-control firmaModal firma" step="0.01" value="<?=$primer_nombre." ".$primer_apellido?>" name="firma" id="firma" readonly>
                           <span id="error_firmaModal" class="errors"></span>
                            <span class="name_conciliador"></span>
                        </div>
                        <!-- <div> -->
                          <!-- <div class="form-group col-xs-12" style="text-align:right;"> -->
                          <!-- </div> -->
                        <!-- </div> -->
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="leyenda">Leyenda</label>
                           <input type="text" class="form-control leyendaModal leyenda" step="0.01" min="<?=$limiteFechaMinimo?>" name="leyenda" id="leyenda" max="<?=date('Y-m-d')?>">
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
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <?php
                          $primer_nombre = $_SESSION['cuenta']['primer_nombre']; 
                          $primer_apellido = $_SESSION['cuenta']['primer_apellido'];
                        ?>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirma">Firma</label>
                           <input type="hidden" value="<?=$primer_nombre." ".$primer_apellido?>" class="newFirma" name="newFirma">
                           <input type="text" class="form-control diferirFirmaModal firma" step="0.01" value="<?=$primer_nombre." ".$primer_apellido?>" name="firma" id="diferirFirma" readonly>
                           <span id="error_diferirFirmaModal" class="errors"></span>
                            <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacion">Motivo</label>
                           <select class="form-control observacion" id="observacion"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optComprobante">Se solicita comprobante</option>
                             <option class="optActFecha">Actualizar fecha</option>
                             <option class="optActBanco">Actualizar banco</option>
                             <option class="optActReferencia">Actualizar referencia</option>
                             <option class="optActMonto">Actualizar monto</option>
                             <option class="optRepetido">Repetido</option>
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
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estadoAnalistaModal" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optAprobar">Abonado</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="firmaAnalista">Firma</label>
                           <input type="text" class="form-control firmaAnalistaModal" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="firmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_firmaAnalistaModal" class="errors"></span>
                           <span class="name_conciliador"></span>
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
                      <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="estado">Estado de Pago</label>
                           <select class="form-control estado select2 estado" id="estado"  name="estado" style="width:100%;z-index:91000">
                             <option class="optDiferir">Diferido</option>
                           </select>
                           <span id="error_estadoModal" class="errors"></span>
                        </div>
                        <input type="hidden" class="id_pago_modal" name="id_pago_modal">
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="diferirFirmaAnalista">Firma</label>
                           <input type="text" class="form-control diferirFirmaAnalistaModal firma" step="0.01" min="<?=$limiteFechaMinimo?>" name="firma" id="diferirFirmaAnalista" max="<?=date('Y-m-d')?>">
                           <span id="error_diferirFirmaAnalistaModal" class="errors"></span>
                           <span class="name_conciliador"></span>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12">
                           <label for="observacionAnalista">Motivo</label>
                           <select class="form-control observacionAnalista observacion" id="observacionAnalista"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optPendienteEntregar">Pendiente Por Entregar</option>
                             <option class="optPendienteSustituir">Billete Devuelto Pendiente por Sustituir</option>
                             <option class="optMalEstado">En mal estado, sustituido por deposito - Dolares</option>
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
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid=<?=$_GET['dpid']?>&dp=<?=$_GET['dp']?>&route=Pagoss";
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
    
  $("#buscar_table_contado").keyup(function(){
    var complement = "contado";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);

    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_inicial").keyup(function(){
    var complement = "inicial";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_primer").keyup(function(){
    var complement = "primer";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });
  $("#buscar_table_cierre").keyup(function(){
    var complement = "cierre";
    $(".table_"+complement+" tbody tr").show();
    $(".table_"+complement+" tbody tr td").show();
    var select = $(".select_busqueda_"+complement).val();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    
    var regEx = new RegExp($.map($(this).val().trim().split(' '), function(v) { return '(?=.*?' + v + ')'; }).join(''), 'i');
    $(".table_"+complement+" tbody tr").hide().filter(function() { return regEx.exec($(this).text()); }).show();


    // if($.trim(buscar) != ""){
    //   $(".table_"+complement+" tbody tr:not(:contains('"+buscar+"'))").hide();
    // }
  });


  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".selectbanco").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_banco").submit();
    }
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
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        // alert(data['firma']);
        if(data['firma'] == ""){
        }else if(data['firma'] == null){
        }else{
          // $(".diferirFirmaModal").val(data['firma']);
        }

        if(data['observacion']=="Repetido"){
          $(".optRepetido").attr("selected","selected");
        }
        if(data['observacion']=="Se solicita comprobante"){
          $(".optComprobante").attr("selected","selected");
        }
        if(data['observacion']=="No realizado a la empresa"){
          $(".optOtraEmpresa").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar fecha"){
          $(".optActFecha").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar banco"){
          $(".optActBanco").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar referencia"){
          $(".optActReferencia").attr("selected","selected");
        }
        if(data['observacion']=="Actualizar monto"){
          $(".optActMonto").attr("selected","selected");
        }

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
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

    if(exec==true){ 
      var estado = $(".box-modalDiferirConcialiador .estado").val();
      var firma = $(".box-modalDiferirConcialiador .firma").val();
      var newFirma = $(".box-modalDiferirConcialiador .newFirma").val();
      var observacion = $(".box-modalDiferirConcialiador .observacion").val();
      var id_pago_modal = $(".box-modalDiferirConcialiador .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoConciliadores").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            newFirma: newFirma,
            observacion: observacion,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
              // $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
              // $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
              // $(".tr"+id_pago_modal+" .modificarBtn").hide();
              // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirConciliadores").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirConciliadores").click();
              });
            }
          }
        });
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
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".diferirFirmaAnalistaModal").val(data['firma']);
        if(data['observacion']=="Pendiente Por Entregar"){
          $(".optPendienteEntregar").attr("selected","selected");
        }
        if(data['observacion']=="Billete Devuelto Pendiente por Sustituir"){
          $(".optPendienteSustituir").attr("selected","selected");
        }
        if(data['observacion']=="En mal estado, sustituido por deposito - Dolares"){
          $(".optMalEstado").attr("selected","selected");
        }
        

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
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
    if(exec==true){ 
      var estado = $(".box-modalDiferirAnalista .estado").val();
      var firma = $(".box-modalDiferirAnalista .firma").val();
      var observacion = $(".box-modalDiferirAnalista .observacion").val();
      var id_pago_modal = $(".box-modalDiferirAnalista .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoAnalista").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            observacion: observacion,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(210,0,0,.5);");
              // $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
              // $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
              // $(".tr"+id_pago_modal+" .modificarBtn").hide();
              // $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirAnalista").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalDiferirAnalista").click();
              });
            }
          }
        });
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
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        // $(".firmaModal").val(data['firma']);
        if(data['firma'] == ""){
        }else if(data['firma'] == null){
        }else{
          // $(".firmaModal").val(data['firma']);
        }
        $(".leyendaModal").val(data['leyenda']);
        
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


      }
    });
    $(".box-modalAprobarConcialiador").fadeIn(500);
  });
  $(".enviarModalAprobadoConciliadores").click(function(){
    var exec = false;
    $("#error_firmaModal").html("");
    $("#error_leyendaModal").html("");

    // if($(".firmaModal").val()=="" || $(".leyendaModal").val()==""){
    if($(".firmaModal").val()==""){
      if($(".firmaModal").val()==""){
        $("#error_firmaModal").html("Debe dejar su firma");
      }
      // if($(".leyendaModal").val()==""){
      //   $("#error_leyendaModal").html("Debe agregar la leyenda del pago");
      // }
    }else{
      exec=true;
    }

    if(exec==true){ 
      var estado = $(".box-modalAprobarConcialiador .estado").val();
      var firma = $(".box-modalAprobarConcialiador .firma").val();
      var newFirma = $(".box-modalAprobarConcialiador .newFirma").val();
      var leyenda = $(".box-modalAprobarConcialiador .leyenda").val();
      var id_pago_modal = $(".box-modalAprobarConcialiador .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoConciliadores").click();


        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            newFirma: newFirma,
            leyenda: leyenda,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
              $(".tr"+id_pago_modal+" .diferirPagoBtnConciliadores").hide();
              $(".tr"+id_pago_modal+" .aprobarPagoBtnConciliadores").hide();
              $(".tr"+id_pago_modal+" .modificarBtn").hide();
              $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarConciliadores").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarConciliadores").click();
              });
            }
          }
        });
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
        var json = JSON.parse(response);
        var data = json['pedido'];
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
        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);


        // alert(data['fecha_pago']);
        // $(".fecha_pago_modal2").val(data['fecha_pago']);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
        $(".id_pago_modal").val(id);

        $(".firmaAnalistaModal").val(data['firma']);
        $(".leyendaAnalistaModal").val(data['leyenda']);
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }
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
      var estado = $(".box-modalAprobarAnalista .estadoAnalistaModal").val();
      var firma = $(".box-modalAprobarAnalista .firmaAnalistaModal").val();
      var leyenda = $(".box-modalAprobarAnalista .leyendaAnalistaModal").val();
      var id_pago_modal = $(".box-modalAprobarAnalista .id_pago_modal").val();
      // $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
      // $(".btn-enviar-modalAprobadoAnalista").click();

        $.ajax({
          url:'',
          type:"POST",
          data:{
            estado: estado,
            firma: firma,
            leyenda: leyenda,
            id_pago_modal: id_pago_modal,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            if(respuesta=="1"){
              $(".tr"+id_pago_modal).attr("style","background:rgba(0,210,0,.5);");
              $(".tr"+id_pago_modal+" .diferirPagoBtnAnalista").hide();
              $(".tr"+id_pago_modal+" .aprobarPagoBtnAnalista").hide();
              $(".tr"+id_pago_modal+" .modificarBtn").hide();
              $(".tr"+id_pago_modal+" .eliminarBtn").hide();

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarAnalista").click();
              });
            }
            if(respuesta=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModalAprobarAnalista").click();
              });
            }
          }
        });
    }
  });
  $(".cerrarModalAprobarAnalista").click(function(){
    $(".box-modalAprobarAnalista").fadeOut(500);
  });


  $(".cerrarModalConciliador").click(function(){
    $(".box-modalEditarConciliador").fadeOut(500);
  });
  $(".editarPagoBtnConciliador").click(function(){
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
        var json = JSON.parse(response);
        var data = json['pedido'];
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

        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);

        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


        var estado = "Reportado";
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(0,0,165,.65);");
          // rgba(0,0,160,.6)
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(165,0,0,.65);");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(0,165,0,.65);"); 
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
        }


        $(".box-modalEditarConciliador").fadeIn(500);
      }
    });
  });


  $(".btnFichaDetalle").click(function(){
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
          $(".linear_estado").attr("style",style+"background:rgba(0,0,165,.65)");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(165,0,0,.65);"); 
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(0,165,0,.65);");
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



  $(".cerrarModal").click(function(){
    $(".box-modalEditar").fadeOut(500);
  });
  $(".enviarModal").click(function(){
    var exec = false;
    $("#error_tipoPagoModal").html("");
    $("#error_tasaModal").html("");
    $("#error_fechaPagoModal2").html("");

    // alert($(".fecha_pago_modal2").val());

    // if($(".tipo_pago").val()=="" || $(".tasaModal").val()=="" || $(".fecha_pago_modal2").val()==""){
    if($(".tipo_pago").val()=="" || $(".fecha_pago_modal2").val()==""){
      if($(".tipo_pago").val()==""){
        $("#error_tipoPagoModal").html("Debe seleccionar un concepto de pago");
      }
      // if($(".tasaModal").val()==""){
      //   $("#error_tasaModal").html("Debe agregar la tasa del dolar");
      // }
      if($(".fecha_pago_modal2").val()==""){
        $("#error_fechaPagoModal2").html("Debe agregar la fecha del pago");
      }
    }else{
      exec=true;
    }

    if(exec==true){
      var fecha_pago = $("#fecha_pago").val(); 
      var rol = $("#rol").val(); 
      var tipo_pago = $("#tipo_pago").val(); 
      var id_pago_modal = $("#id_pago_modal").val(); 
      var tasa = $("#tasa").val(); 
        $.ajax({
          url:'',
          type:"POST",
          data:{
            fecha_pago: fecha_pago,
            rol: rol,
            tipo_pago: tipo_pago,
            id_pago_modal: id_pago_modal,
            tasa: tasa,
          },
          success: function(respuesta){
            // alert(respuesta);
            // console.log(respuesta);
            var data = JSON.parse(respuesta);
            if(data['exec']=="1"){
              var pago = data['pago'];
              var despacho = data['despacho'];
              // $(".tr"+id_pago_modal+" .contenido_forma_pago").html(pago['contenido_forma_pago']);
              // $(".tr"+id_pago_modal+" .contenido_banco").html(pago['fecha_pago_format']);
              // $(".tr"+id_pago_modal+" .contenido_referencia").html(pago['referencia_pago_format']);
              // $(".tr"+id_pago_modal+" .contenido_monto").html(pago['monto_pago_format']);
              var restriccion = "";
              var temporalidad = "";
              if(pago['tipo_pago']=="Contado"){
                restriccion = despacho['fecha_inicial'];
              }
              if(pago['tipo_pago']=="Inicial"){
                restriccion = despacho['fecha_inicial'];
              }
              if(pago['tipo_pago']=="Primer Pago"){
                restriccion = despacho['fecha_primera_senior'];
              }
              if(pago['tipo_pago']=="Segundo Pago"){
                restriccion = despacho['fecha_segunda_senior'];
              }

              if(pago['fecha_pago'] <= restriccion){
                temporalidad = "Puntual";
              }else{
                temporalidad = "Impuntual";
              }
              

              $(".tr"+id_pago_modal+" .contenido_fecha_pago").html(pago['fecha_pago_format']);
              $(".tr"+id_pago_modal+" .contenido_temporalidad").html(temporalidad);
              if(pago['tasa_pago']!=null){
                $(".tr"+id_pago_modal+" .contenido_tasa").html(pago['tasa_pago_format']);
              }else{
                $(".tr"+id_pago_modal+" .contenido_tasa").html("");
              }
              var signo = "";
              if(pago['forma_pago']=="Divisas Euros"){
                signo = "€";
              }else{
                signo = "$";
              }
              $(".tr"+id_pago_modal+" .contenido_equivalente").html(signo+pago['equivalente_pago_format']);
              $(".tr"+id_pago_modal+" .contenido_tipo_pago").html(pago['tipo_pago']);
              if(pago['estado']!="Abonado"){
                $(".tr"+id_pago_modal).attr("style","background:;");
              }

              swal.fire({
                type: 'success',
                  title: '¡Datos guardados correctamente!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModal").click();
              });
            }
            if(data['exec']=="2"){
              swal.fire({
                  type: 'error',
                  title: '¡Error al realizar la operacion!',
                  confirmButtonColor: "#ED2A77",
              }).then(function(){
                $(".cerrarModal").click();
              });
            }
            // alert(id_pago_modal);

            // $(".tr"+id_pago_modal).attr();
            // $(".tr"+id_pago_modal).attr("style","background:purple");
            

            // $("#fecha_pago").val(fecha_pago); 
            // $("#tipo_pago").val(tipo_pago); 
            // $("#tasa").val(tasa); 
          }
          });



      // $(".btn-enviar-modal").removeAttr("disabled","");
      // $(".btn-enviar-modal").click();
    }
  });
  $(".editarPagoBtn").click(function(){
    var id = $(this).val();
    // alert(id);
    $.ajax({
      url:'',
      type:"POST",
      data:{
        ajax:"ajax",
        id_pago:id,
      },
      success: function(response){
        // alert(response);
        var json = JSON.parse(response);
        var data = json['pedido'];
        // console.log(data);
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

        var year = data['fecha_pago'].substr(0, 4);
        var mes = data['fecha_pago'].substr(5, 2);
        var dia = data['fecha_pago'].substr(8, 2);

        // alert(data['fecha_pago']);
        $(".fecha_pago_modal2").val(data['fecha_pago']);

        $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
          // alert(data['tasa_pago']);
        $(".id_pago_modal").val(id);
        if(data['tasa_pago']!=null){
          $(".tasaModal").attr("value",data['tasa_pago']);
        }else{
          $(".tasaModal").attr("value","");
          $(".tasaModal").attr("placeholder","0.00");
        }
        if(data['tipo_pago']=="Contado"){
          $(".optContado").attr("selected","selected");
        }
        if(data['tipo_pago']=="Inicial"){
          $(".optInicial").attr("selected","selected");
        }
        if(data['tipo_pago']=="Primer Pago"){
          $(".optPrimer").attr("selected","selected");
        }
        if(data['tipo_pago']=="Segundo Pago"){
          $(".optCierre").attr("selected","selected");
        }
        $(".name_conciliador").html("");
        $(".name_observ").html("");
        $(".name_leyenda").html("");
        if(data['estado']=="Diferido"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Firmado por: "+data['firma']);
            // $(".name_observacion").html(" "+data['observacion']);
          }
        }
        if(data['estado']=="Abonado"){
          if(data['firma'] != null){
            $(".name_conciliador").html("Conciliado por: "+data['firma']);
            if(data['leyenda']!=null){
              $(".name_leyenda").html("<br>"+data['leyenda']);
            }
          }
        }


        var estado = "Reportado";
        $(".name_estado").html("");
        $(".name_observacion").html("");
        if(data['estado']=="Reportado" || data['estado']==null){
          estado = "Reportado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(0,0,165,.65)");
          $(".name_estado").html(estado);
        }
        if(data['estado']=="Diferido"){
          estado = "Diferido";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(165,0,0,.65);");
          $(".name_estado").html(estado);
          $(".name_observacion").html(data['observacion']);
        }
        if(data['estado']=="Abonado"){
          estado = "Abonado";
          var style = $(".linear_estado").attr("style");
          $(".linear_estado").attr("style",style+"background:rgba(0,165,0,.65);");
          $(".name_estado").html(estado);
          // $(".name_observacion").html(data['leyenda']);
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
