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
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $modulo ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      <?php 
        // $ciclo['pago_inicio'] = "2023-08-28";
        // $pagosT['abonado'] = 33.11;
        // echo $fechaActual."<br>";
        // echo $ciclo['pago_inicio']."<br>";
        // echo $pagosT['abonado']."<br>"; 
        // echo $pedido['precio_cuotas']."<br>";
        $operar = 0;
        if($personalExterno){
          if($fechaActual<=$ciclo['pago_inicio']){
            $operar=1;
          }else{
            if($pagosT['abonado']>=$pedido['precio_cuotas']){
              $operar=1;
            }else{
              $operar=0;
            }
          }
        }else{
          $operar=1;
        }
      ?>
      <div class="row">

        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $modulo; ?></h3>
            </div>
            <div class="box-body">
              <?php if($_SESSION['home']['nombre_rol']!="Vendedor"){ ?>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <button style="background:<?=$fucsia; ?>;color:#FFF;" class="btn btn-sm col-xs-12 guardarDatosPrueba">Guardar Datos Temporales</button>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <button style="background:#999;color:#FFF;" class="btn btn-sm col-xs-12 borrarDatosPrueba">Borrar Datos Temporales</button>
                  </div>
                  <hr>
                  <hr>
                </div>
              <?php } ?>
              <?php
                if($accesoPagosAdminR){
                  if (empty($_GET['admin'])){ ?>
                    <div style="width:100%;margin:0;padding:0;text-align:right;">
                      <a class="btn" style="color:#FFF;background:<?=$color_btn_sweetalert; ?>" href="?<?=$menu; ?>&route=Pagos&action=Registrar&admin=1&select=0"><b>Realizar pago por Lider</b></a>
                    </div>
                  <?php }
                }
              ?>
              <?php if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                    <div class="form-group col-xs-12">
                      <label for="lider">Seleccione al Lider</label>
                      <input type="hidden" name="c" value="<?=$id_ciclo; ?>" >
                      <input type="hidden" name="n" value="<?=$num_ciclo; ?>" >
                      <input type="hidden" name="y" value="<?=$ano_ciclo; ?>">
                      <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                      <input type="hidden" name="action" value="Registrar">
                      <input type="hidden" value="1" name="admin">
                      <input type="hidden" value="1" name="select">
                      <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                        <option></option>
                          <?php 
                            foreach ($lideres as $data){ if (!empty($data['id_cliente'])){
                              $permitido = 0;
                              if(!empty($accesosEstructuras)){
                                if(count($accesosEstructuras)>1){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$lid['id_cliente']){
                                        if($data['cantidad_aprobada']>0){
                                          $permitido = 1;
                                        }
                                      }
                                    }
                                  }
                                }else if($personalInterno){
                                  if($data['cantidad_aprobada']>0){
                                    $permitido = 1;
                                  }
                                }
                              }
                              if($permitido){ ?>
                                <?php
                                  $mostrarTXT = $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']." ".
                                              "($".number_format($data['cantidad_aprobada'],2,',','.').")";
                                ?>
                                <option <?php if (!empty($_GET['lider'])){ if($data['id_cliente']==$_GET['lider']){ echo 'selected="selected"'; } } ?> value="<?=$data['id_cliente']; ?>"><?=$mostrarTXT; ?></option>
                              <?php }
                            } }
                          ?>
                      </select>
                    </div>
                  </form>
                </div>
              <?php } ?>

              <div class="row">
                <div class="form-group col-xs-12 col-sm-6">
                   <label for="forma">Forma de pago</label>
                   <select class="form-control select2" id="forma" name="forma" style="width:100%;">
                      <option></option>
                      <?php
                        foreach ($formasPago as $fpagos){ ?>
                          <option 
                            <?php 
                              if(!empty($_SESSION['home']['dataRegistroTemp']) && $_SESSION['home']['dataRegistroTemp']['formaPago']==$fpagos['name']){ 
                                echo "selected";
                              }
                            ?> 
                          ><?=$fpagos['name']; ?></option>
                          <!-- if ($limitefechasPagos==1){
                            echo "<option ";
                            if(!empty($_SESSION['home']['dataRegistroTemp'])){
                              if($_SESSION['home']['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                echo "selected";
                              }
                            }
                            echo ">".$fpagos['name']."</option>";
                          }else{
                            if ($fpagos['type']=="banco"){
                              echo "<option ";
                              if(!empty($_SESSION['home']['dataRegistroTemp'])){
                                if($_SESSION['home']['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                  echo "selected";
                                }
                              }
                              echo ">".$fpagos['name']."</option>";
                            }
                            if ($fpagos['type']=="fisico"){
                              if($mostrarPagosFisicos==1){
                                echo "<option ";
                                if($_SESSION['home']['dataRegistroTemp']['formaPago']==$fpagos['name']){
                                  echo "selected";
                                }
                                echo ">".$fpagos['name']."</option>";
                              }
                            }
                          } -->

                        <?php }
                      ?>
                    </select>
                   <span id="error_forma" class="errors"></span>
                </div>

                <div class="form-group col-xs-12 col-sm-6">
                  
                   <label for="bancoPago">Bancos</label>
                   <!-- <?=$_SESSION['home']['dataRegistroTemp']['bancos'] ?> -->
                   <input type="hidden" class="bancosBoxSeleccionada" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ echo $_SESSION['home']['dataRegistroTemp']['bancosBox']; } ?>">
                   <input type="hidden" class="bancosListaSeleccionada" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ echo $_SESSION['home']['dataRegistroTemp']['bancos']; } ?>">
                   <input type="hidden" class="boxBancosListaSeleccionada" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ echo $_SESSION['home']['dataRegistroTemp']['box']; } ?>">

                    <div class="bancosVacio ">
                       <select class="form-control select2 bancoPago bancoPagoV" style="width:100%" name="bancoPago">
                          <option value=""></option>
                       </select>
                    </div>

                    <div style='display:none' class="bancosSelect bancosT">
                       <select class="form-control select2 bancoPago bancoPagoT" style="width:100%" name="bancoPago">
                          <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Transferencia" || $data['opcion_pago']=="Ambos"){  ?>
                            <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['home']['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                              <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                            </option>
                          <?php } } } ?>
                       </select>
                    </div>

                    <div style='display:none' class="bancosSelect bancosPM">
                       <select class="form-control select2 bancoPago bancoPagoPM" style="width:100%" name="bancoPago">
                          <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['opcion_pago']=="Pago Movil" || $data['opcion_pago']=="Ambos"){  ?>
                            <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['home']['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> 
                            <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                              <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                            </option>
                          <?php } } } ?>
                       </select>
                    </div>

                    <div style='display:none' class="bancosSelect bancosAll">
                       <select class="form-control select2 bancoPago bancoPagoAll" style="width:100%" name="bancoPago">
                          <option value=""></option>
                          <?php foreach ($bancos as $data) { if(!empty($data['id_banco'])){ if($data['tipo_cuenta']!="Divisas"){  ?>
                            <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['home']['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                              <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                            </option>
                          <?php } } } ?>
                       </select>
                    </div>

                    <div style='display:none' class="bancosSelect bancosDivisas">
                       <select class="form-control select2 bancoPago bancoPagoD" style="width:100%" name="bancoPago">
                          <option value=""></option>
                          <?php  foreach ($bancos as $data) { if(!empty($data['nombre_banco'])){ if($data['tipo_cuenta']=="Divisas"){  ?>
                            <option value="<?php echo $data['id_banco'].'-'.$data['nombre_banco'] ?>" <?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ if($data['id_banco']==$_SESSION['home']['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> <?php //foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> > <!-- Aqui cierra el Option de apertura  -->
                              <?php echo $data['nombre_banco']." - ".$data['nombre_propietario']. " ".str_replace(" ", "-", $data['cedula_cuenta'])." (Cuenta ".$data['tipo_cuenta'].")"; ?>
                            </option>
                          <?php } } } ?>
                       </select>
                    </div>

                    <div style='display:none'  class="bancosEfectivo ">
                       <select class="form-control select2 bancoPago bancoPagoE" style="width:100%" name="bancoPago">
                          <option value="0-Efectivo" <?php if(!empty($_SESSION['home']['dataRegistroTemp'])){ if("0"==$_SESSION['home']['dataRegistroTemp']['bancosSelect']){ echo "selected"; } } ?> >Efectivo</option>
                       </select>
                    </div>
                   <span id="error_bancoPago" class="errors"></span>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <?php if($operar==1){ ?>
              <span type="submit" class="btn btn-default enviar2 color-button-sweetalert" style='background:<?=$colorPrimaryAll; ?>;color:#fff'>Cargar</span>
              <?php } ?>
              <!-- <span type="submit" class="btn enviar">Enviar</span> -->
              <!-- <button class="btn-enviar d-none" disabled="" >enviar</button> -->
            </div>

            <!-- FORMULARIOS -->
              <div class="boxForm boxFormTransferencia" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>" id="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                         <label for="referencia">Referencia del movimiento</label>
                         <input type="text" class="form-control" id="referencia" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" name="referencia" minlength="6" maxlength="6" placeholder="00000001">
                         <span id="error_referencia" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="monto">Monto</label>
                           <div class="input-group">
                             <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                             <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){ echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                           </div>
                           <span id="error_monto" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="equivalente">Equivalente</label>
                          <div class="input-group">
                           <span class="input-group-addon" style="background:#EEE">$</span> 
                           <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
                          </div>
                           <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                           <span id="error_equivalente" class="errors"></span>
                        </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormTransferencia">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormTransferencia d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormTransferenciaProvincial" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>"  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>"  id="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="cedula">Cedula</label>
                        <div class="row">
                          <div class="col-xs-12">
                          <select class="form-control" style="width:20%;float:left;" id="tipo_cedula" name="tipo_cedula">
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                          </select> 
                          <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['cedula'])){  echo $_SESSION['home']['dataRegistroTemp']['cedula']; } ?>" minlength="7" maxlength="9"  id="cedula" name="cedula">
                          </div>
                        </div>
                        <div style="clear:both;"></div>
                        <span id="error_cedula" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="monto">Monto</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                            <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                          </div>
                          <span id="error_monto" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                          <label for="equivalente">Equivalente</label>
                          <div class="input-group">
                            <span class="input-group-addon" style="background:#EEE">$</span> 
                            <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
                          </div>
                          <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                          <span id="error_equivalente" class="errors"></span>
                        </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormTransferenciaProvincial">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormTransferenciaProvincial d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormPagoMovil" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>"  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>"  id="tasa" class="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="referencia">Numero de movimiento</label>
                        <input type="text" class="form-control" id="referencia" name="referencia" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" minlength="6" maxlength="6">
                        <span id="error_referencia" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovil">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormPagoMovil d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormPagoMovilProvincial1" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                          <label for="fechaPago">Fecha de Pago</label>
                          <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>"  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                          <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>"  id="tasa" class="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="cedula">Cedula <small>(Pago Movil)</small></label>
                        <div class="row">
                          <div class="col-xs-12">
                            <select class="form-control" style="width:20%;float:left;" id="tipo_cedula" name="tipo_cedula">
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                            </select> 
                            <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['cedula'])){  echo $_SESSION['home']['dataRegistroTemp']['cedula']; } ?>" minlength="7" id="cedula" minlength="7" maxlength="9"  name="cedula">
                          </div>
                        </div>
                        <div style="clear:both;"></div>
                        <span id="error_cedula" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovilProvincial1">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormPagoMovilProvincial1 d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormPagoMovilProvincial2" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>"  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>"  id="tasa" class="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="telefono">Telefono <small>(Pago Movil)</small></label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['telefono'])){  echo $_SESSION['home']['dataRegistroTemp']['telefono']; } ?>" minlength="11" maxlength="11" >
                        <span id="error_telefono" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente" id="equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" class="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" class="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormPagoMovilProvincial2">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormPagoMovilProvincial2 d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormDepositoDivisas" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="serial">Referencia del deposito</label>
                        <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" name="serial" max="10">
                        <span id="error_serial" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
                        </div>
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoDivisas">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDepositoDivisas d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormDepositoBolivaresProvincial" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>" id="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="cedula">Cedula</label>
                        <div class="row">
                          <div class="col-xs-12">
                          <select class="form-control" style="width:20%;float:left;"  id="tipo_cedula" name="tipo_cedula">
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("V"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >V</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("J"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >J</option>
                            <option <?php if(!empty($_SESSION['home']['dataRegistroTemp']['tipo_cedula'])){ if("E"==$_SESSION['home']['dataRegistroTemp']['tipo_cedula']){ echo " selected "; } } ?> >E</option>
                          </select> 
                          <input type="text" class="form-control" style="width:80%;float:left;" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['cedula'])){  echo $_SESSION['home']['dataRegistroTemp']['cedula']; } ?>" id="cedula" name="cedula">
                          </div>
                        </div>
                        <div style="clear:both;"></div>
                        <span id="error_cedula" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoBolivaresProvincial">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDepositoBolivaresProvincial d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormDepositoBolivares" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <div style="width:100%;text-align:center;padding:0;margin:0"><span class="infoData" style="color:red;"></span></div>
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['fecha2'])){  echo $_SESSION['home']['dataRegistroTemp']['fecha2']; } ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" class="form-control tasa" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>" id="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="referencia">Referencia del movimiento</label>
                        <input type="text" class="form-control" id="referencia" name="referencia" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" maxlength="35" placeholder="00000001">
                        <span id="error_referencia" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                         <input type="number"  step="0.01" class="form-control monto montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number"  step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDepositoBolivares">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDepositoBolivares d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormEfectivoBolivares" style="display:none">
                <center>
                  <span><i>El pago del efectivo en bolivares, se tomara a la fecha en que se esta reportando, la fecha <?=$lider->formatFecha(date('Y-m-d'))?></i></span>
                </center>
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <!-- <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" readonly name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>"> -->
                        <span id="error_fechaPago" class="errors"></span>
                      </div>

                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="tasa">Tasa</label>
                        <input type="number" step="0.01" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['tasa'])){  echo $_SESSION['home']['dataRegistroTemp']['tasa']; } ?>" class="form-control tasabs" id="tasa" name="tasa" readonly="">
                        <span id="error_tasa" class="errors"></span>
                      </div>
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="monto">Monto</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">Bs.D</span> 
                          <input type="number" step="0.01" class="form-control montobs montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['monto'])){  echo $_SESSION['home']['dataRegistroTemp']['monto']; }else{ echo "0.00"; } ?>" id="monto" placeholder="0,00" name="monto">
                        </div>
                        <span id="error_monto" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number"  step="0.01" class="form-control equivalente" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" name="equivalente" readonly="">
                        </div>
                        <input type="number" value="0.00" step="0.01" class="form-control equivalente2 d-none" id="equivalente2" name="equivalente2" readonly="">
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormEfectivoBolivares">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormEfectivoBolivares d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormDivisasDolares" style="display:none">
                <center>
                  <span>
                    <i>
                      El pago de divisas en dolares, se tomara a la fecha en que se esta reportando, la fecha <?=$lider->formatFecha(date('Y-m-d'))?>
                    </i>
                  </span>
                </center>
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>" value="<?=date('Y-m-d')?>" readonly name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="serial">Serial de billete en dolar</label>
                        <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" name="serial">
                        <span id="error_serial" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">$</span> 
                          <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
                        </div>
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>
                    
                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDivisasDolares">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDivisasDolares d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>

              <div class="boxForm boxFormDivisasEuros" style="display:none">
                <form action="" method="post" role="form" class="form_register">
                  <input type="hidden" name="valForma" class="valForma">
                  <input type="hidden" name="valBanco" class="valBanco">
                  <div class="box-body">
                    <hr>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="fechaPago">Fecha de Pago</label>
                        <input type="date" class="form-control fechaPago" min="<?=$limiteFechaMinimo?>"  value="<?=date('Y-m-d')?>"  name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                        <span id="error_fechaPago" class="errors"></span>
                      </div>
                    </div>
                   
                    <div class="row">
                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="serial">Serial de billete euro</label>
                        <input type="text" class="form-control" id="serial" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['referencia'])){  echo $_SESSION['home']['dataRegistroTemp']['referencia']; } ?>" name="serial">
                        <span id="error_serial" class="errors"></span>
                      </div>

                      <div class="form-group col-xs-12 col-sm-6 col-md-6">
                        <label for="equivalente">Equivalente</label>
                        <div class="input-group">
                          <span class="input-group-addon" style="background:#EEE">€</span> 
                          <input type="number" step="0.01" class="form-control equivalente montoDinero" value="<?php if(!empty($_SESSION['home']['dataRegistroTemp']['equivalente'])){  echo $_SESSION['home']['dataRegistroTemp']['equivalente']; }else{ echo "0.00"; } ?>" id="equivalente" class="equivalente" name="equivalente">
                        </div>
                        <span id="error_equivalente" class="errors"></span>
                      </div>
                    </div>
                  </div>

                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" id="boxFormDivisasEuros">Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar btn-enviar-boxFormDivisasEuros d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>
            <!-- FORMULARIOS -->

          </div>
        </div>        
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
<input type="hidden" class="guardarDatosTemporalmente" value="<?=$_SESSION['home']['dataRegistroTemp']['guardarDatosTemporalmente']; ?>">
<input type="hidden" class="bancosSelectTemporalmente" value="<?=$_SESSION['home']['dataRegistroTemp']['bancosBox']; ?>">
<input type="hidden" class="guardarDatosTemporalmente" value="<?=$_SESSION['home']['dataRegistroTemp']['guardarDatosTemporalmente']; ?>">

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
  if(response==undefined){}
  else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
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
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro Repetido!',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "912"){
      swal.fire({
          type: 'warning',
          title: '¡Registro No Encontrado, puede haber ingresado mal algun dato!',
          text: 'Verifique los datos con su comprobante de pago o comuniquese con su Analista.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "911"){
      swal.fire({
          type: 'warning',
          title: '¡Registro No Encontrado, puede haber ingresado mal algun dato!',
          text: 'Verifique los datos con su comprobante de pago o comuniquese con su Analista.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "910"){
      swal.fire({
          type: 'error',
          title: '¡Registro No Encontrado, Informe al tecnico de inmediato!',
          text: 'Comuniquese con su Analista e informe de esta alerta',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    if(response == "92"){
      swal.fire({
          type: 'warning',
          title: '¡Los Registros Bancarios <br>no han sido cargados!<br>Espere al siguiente dia habil.',
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    <?php if(!empty($response) && $response=="951"){ ?>
    if(response == "951"){
      var sistema = '<?=$dataEncontrado['sistema'];?>';
      var sexo = '<?=$dataEncontrado['sexo'];?>';
      var nombre = '<?=$dataEncontrado['primer_nombre'].' '.$dataEncontrado['primer_apellido']; ?>';
      var dataCiclo = 'Ciclo <?=$dataEncontrado['numero_ciclo'].'/'.$dataEncontrado['ano_ciclo']; ?>';
      var pedi=' el';
      var lid = 'lider';
      if(sexo=='Femenino'){
        lid = 'la lider';
      }
      if(sexo=='Masculino'){
        lid = 'el lider';
      }
      swal.fire({
          type: 'warning',
          title: '¡Registro de pago repetido<br> cargado en '+sistema+' a la factura de <br> '+lid+' '+nombre+'<br> En '+pedi+' '+dataCiclo,
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    <?php } ?>
    <?php if(!empty($response) && $response=="952"){ ?>
    if(response == "952"){
      var sistema = '<?=$dataEncontrado['sistema'];?>';
      var sexo = '<?=$dataEncontrado['sexo'];?>';
      var nombre = '<?=$dataEncontrado['primer_nombre'].' '.$dataEncontrado['primer_apellido']; ?>';
      var dataCampana = 'Campaña <?=$dataEncontrado['numero_campana'].'/'.$dataEncontrado['anio_campana']; ?>';
      var despacho = '<?=$dataEncontrado['numero_despacho']; ?>';
      var pedi=' la';
      if(despacho>1){
        var numdesp = '';
        if(despacho==2){ numdesp = '2do'; 
        }else if(despacho==3){ numdesp = '3er'; 
        }else if(despacho==4){ numdesp = '4to'; 
        }else if(despacho==5){ numdesp = '5to'; 
        }else if(despacho==6){ numdesp = '6to'; 
        }else if(despacho==7){ numdesp = '7mo'; 
        }else if(despacho==8){ numdesp = '8vo'; 
        }else if(despacho==9){ numdesp = '9no';
        }else{ numdesp=''; }
        pedi = ' el '+numdesp+' Pedido de la ';
      }
      var lid = 'lider';
      if(sexo=='Femenino'){
        lid = 'la lider';
      }
      if(sexo=='Masculino'){
        lid = 'el lider';
      }
      swal.fire({
          type: 'warning',
          title: '¡Registro de pago repetido<br> cargado en '+sistema+' a la factura de <br> '+lid+' '+nombre+'<br> En '+pedi+' '+dataCampana,
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        window.location = "?<?=$menu; ?>&route=<?=$url; ?>";
      });
    }
    <?php } ?>
  }

  
  if($(".guardarDatosTemporalmente").val() == "true"){
    $(".bancosVacio").hide();
    var banca = $(".bancosSelectTemporalmente").val();
    $("."+banca).show();
  }
  $(".guardarDatosPrueba").click(function(){
    var fecha = $(".fechaPagar").val();
    var formaPago = $("#forma").val();
    if(formaPago!=""){
      var opcionTasaDisponible = $("#opcionTasaDisponible").val();
      var bancosBox = $(".bancosBoxSeleccionada").val();
      var bancos = $(".bancosListaSeleccionada").val();
      var bancosSelect = $("."+bancos).val();
      var posicion = bancosSelect.indexOf("Provincial");
      var poss = bancosSelect.indexOf("-");
      bancosSelect = bancosSelect.slice(0, poss);
      var box = $(".boxBancosListaSeleccionada").val();

      var fecha2 = $(box+" #fechaPago").val();
      var tasa = $(box+" #tasa").val();
      var tipoPago = $(box+" #tipoPago").val();
      if(posicion == -1){
        if(formaPago=="Deposito En Dolares"){
          var referencia = $(box+" #serial").val();
        }else if(formaPago=="Divisas Dolares"){
          var referencia = $(box+" #serial").val();
        }else if(formaPago=="Divisas Euros"){
          var referencia = $(box+" #serial").val();
        }else {
          var referencia = $(box+" #referencia").val();
        }
      }else{
        if(formaPago=="Pago Movil de Otros Bancos"){
          // alert("asdasd");
          var telefono = $(box+" #telefono").val();
        }else{
          var tipo_cedula = $(box+" #tipo_cedula").val();
          var cedula = $(box+" #cedula").val();
        }
      }

      var monto = $(box+" #monto").val();
      var equivalente = $(box+" #equivalente").val();
      if(posicion == -1){
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            guardarDatosTemporalmente: true,
            fecha: fecha,
            formaPago: formaPago,
            opcionTasaDisponible: opcionTasaDisponible,
            bancosBox: bancosBox,
            bancos: bancos,
            box: box,
            bancosSelect: bancosSelect,
            posicion: posicion,
            fecha2: fecha2,
            tasa: tasa,
            tipoPago: tipoPago,
            referencia: referencia,
            monto: monto,
            equivalente: equivalente,
          },
          success: function(respuesta){
            swal.fire({
              type: 'success',
              title: '¡Datos guardados temporalmente!',
              confirmButtonText: "¡Aceptar!",
              confirmButtonColor: "<?=$colorPrimaryAll; ?>"
            });
          }
        });
      }
      else{
        if(formaPago=="Pago Movil de Otros Bancos"){
          $.ajax({
            url: '',
            type: 'POST',
            data: {
              guardarDatosTemporalmente: true,
              fecha: fecha,
              formaPago: formaPago,
              opcionTasaDisponible: opcionTasaDisponible,
              bancosBox: bancosBox,
              bancos: bancos,
              box: box,
              bancosSelect: bancosSelect,
              posicion: posicion,
              fecha2: fecha2,
              tasa: tasa,
              tipoPago: tipoPago,
              telefono: telefono,
              monto: monto,
              equivalente: equivalente,
            },
            success: function(respuesta){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados temporalmente!',
                confirmButtonText: "¡Aceptar!",
                confirmButtonColor: "<?=$colorPrimaryAll; ?>"
              });
            }
          });
        }
        else{
          $.ajax({
            url: '',
            type: 'POST',
            data: {
              guardarDatosTemporalmente: true,
              fecha: fecha,
              formaPago: formaPago,
              opcionTasaDisponible: opcionTasaDisponible,
              bancosBox: bancosBox,
              bancos: bancos,
              box: box,
              bancosSelect: bancosSelect,
              posicion: posicion,
              fecha2: fecha2,
              tasa: tasa,
              tipoPago: tipoPago,
              tipo_cedula: tipo_cedula,
              cedula: cedula,
              monto: monto,
              equivalente: equivalente,
            },
            success: function(respuesta){
              swal.fire({
                type: 'success',
                title: '¡Datos guardados temporalmente!',
                confirmButtonText: "¡Aceptar!",
                confirmButtonColor: "<?=$colorPrimaryAll; ?>"
              });
            }
          });
        }
        
      }
      
    }
  });

  $(".borrarDatosPrueba").click(function(){
    $.ajax({
      url: '',
      type: 'POST',
      data: {
        borrarDatosTemporalmente: true,
      },
      success: function(respuesta){
        if(respuesta=="1"){
          swal.fire({
            type: 'success',
            title: '¡Datos temporales borrados!',
            confirmButtonText: "¡Aceptar!",
            confirmButtonColor: "<?=$colorPrimaryAll; ?>"
          });
        }
      }
    });
  });

  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      $(".form_select_lider").submit();
    }
  });
  $(".bancosSelect").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");
  });

  $("#forma").change(function(){
    $(".boxForm").hide();
    $(".errors").html("");
    var opcionTasaDisponible = $("#opcionTasaDisponible").val();
    $(".SiPagar").hide();
    $(".SiPagar").attr("style","display:;");

    var forma = $("#forma").val();
    $(".bancosVacio").show();
    $(".bancosPM").hide();
    $(".bancosAll").hide();
    $(".bancosT").hide();
    $(".bancosDivisas").hide();
    $(".bancosEfectivo").hide();
    $(".bancosListaSeleccionada").val("bancosVacio");
    if(forma=="Transferencia Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosT");
      $(".bancosListaSeleccionada").val("bancoPagoT");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Transferencia de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").show();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosT");
      $(".bancosListaSeleccionada").val("bancoPagoT");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Pago Movil Banco a Banco"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosPM");
      $(".bancosListaSeleccionada").val("bancoPagoPM");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Pago Movil de Otros Bancos"){
      $(".bancosVacio").hide();
      $(".bancosPM").show();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosEfectivo").hide();
      $(".bancosDivisas").hide();
      $(".bancosBoxSeleccionada").val("bancosPM");
      $(".bancosListaSeleccionada").val("bancoPagoPM");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Efectivo Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Divisas Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      $(".NoPagar").hide();
      $(".SiPagar").show();
    }
    if(forma=="Deposito En Dolares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").show();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosDivisas");
      $(".bancosListaSeleccionada").val("bancoPagoD");

      $(".NoPagar").hide();
      $(".SiPagar").show();
    }
    if(forma=="Deposito En Bolivares"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").show();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").hide();
      $(".bancosBoxSeleccionada").val("bancosAll");
      $(".bancosListaSeleccionada").val("bancoPagoAll");

      if(opcionTasaDisponible=="0"){
        $(".SiPagar").hide();
        $(".NoPagar").show();
      }
      if(opcionTasaDisponible=="1"){
        $(".SiPagar").show();
        $(".NoPagar").hide();
      }
    }
    if(forma=="Divisas Euros"){
      $(".bancosVacio").hide();
      $(".bancosPM").hide();
      $(".bancosAll").hide();
      $(".bancosT").hide();
      $(".bancosDivisas").hide();
      $(".bancosEfectivo").show();
      $(".bancosBoxSeleccionada").val("bancosEfectivo");
      $(".bancosListaSeleccionada").val("bancoPagoE");

      $(".NoPagar").hide();
      $(".SiPagar").show();
    }
  });

  $(".enviar2").click(function(){
    var formaPago = $("#forma").val();
    var bancoPago = "";
    $(".boxForm").hide();
    var $var = "";
    if(formaPago=="Transferencia Banco a Banco"){
      bancoPago = $(".bancoPagoT").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormTransferenciaProvincial").show();
          $var = ".boxFormTransferenciaProvincial";
        }else{
          $(".boxFormTransferencia").show();
          $var = ".boxFormTransferencia";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Transferencia de Otros Bancos"){
      bancoPago = $(".bancoPagoT").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormTransferenciaProvincial").show();
          $var = ".boxFormTransferenciaProvincial";
        }else{
          $(".boxFormTransferencia").show();
          $var = ".boxFormTransferencia";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Pago Movil Banco a Banco"){
      bancoPago = $(".bancoPagoPM").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormPagoMovilProvincial1").show();
          $var = ".boxFormPagoMovilProvincial1";
          // $(".boxFormPagoMovil").show();
        }else{
          $(".boxFormPagoMovil").show();
          $var = ".boxFormPagoMovil";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Pago Movil de Otros Bancos"){
      bancoPago = $(".bancoPagoPM").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormPagoMovilProvincial2").show();
          $var = ".boxFormPagoMovilProvincial2";
          // $(".boxFormPagoMovil").show();
        }else{
          $(".boxFormPagoMovil").show();
          $var = ".boxFormPagoMovil";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
    }
    if(formaPago=="Deposito En Dolares"){
      // bancoPago = $(".bancoPagoE").val();
      bancoPago = $(".bancoPagoD").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormDepositoDivisas").show();
          $var = ".boxFormDepositoDivisas";
        }else{
          $(".boxFormDepositoDivisas").show();
          $var = ".boxFormDepositoDivisas";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
      // $(".boxFormDepositoDivisas").show();
    }
    if(formaPago=="Deposito En Bolivares"){
      // bancoPago = $(".bancoPagoE").val();
      bancoPago = $(".bancoPagoAll").val();
      // alert(bancoPago);
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      if(bancoPago!=""){
        if(bancoPago=="Provincial"){
          $(".boxFormDepositoBolivaresProvincial").show();
          $var = ".boxFormDepositoBolivaresProvincial";
          // $(".boxFormDepositoBolivares").show();
        }else{
          $(".boxFormDepositoBolivares").show();
          $var = ".boxFormDepositoBolivares";
        }
        $.ajax({
            url: '',
            type: 'POST',
            data: {
              buscarFechaMovimientos: true,
              idBanco: idBanco,
            },
            success: function(respuesta){
              // alert(respuesta);
              var data =JSON.parse(respuesta);
              if(data['ejecucion']==true){
                if(data['elementos']=="1"){
                  $($var+" #fechaPago").removeAttr("disabled", "0");
                  data = data[0];
                  $($var+" #fechaPago").attr("max", data[0]);
                  $($var+" .infoData").html("");
                }
                if(data['elementos']=="0"){
                  $($var+" #fechaPago").attr("disabled", "1");
                  $($var+" .infoData").html("<br>No hay movimientos cargados del banco seleccionado.");
                }
              }
            }
        });
      }
      // $(".boxFormDepositoDivisas").show();
    }
    if(formaPago=="Efectivo Bolivares"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormEfectivoBolivares").show();
      $var = ".boxFormEfectivoBolivares";
    }
    if(formaPago=="Divisas Dolares"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasDolares").show();
      $var = ".boxFormDivisasDolares";
    }
    if(formaPago=="Divisas Euros"){
      bancoPago = $(".bancoPagoE").val();
      var index = bancoPago.indexOf("-");
      idBanco = bancoPago.substr(0,index);
      bancoPago = bancoPago.substr(index+1);
      $(".boxFormDivisasEuros").show();
      $var = ".boxFormDivisasEuros";
    }
    $(".boxBancosListaSeleccionada").val($var);
    $(".valForma").val(formaPago);
    $(".valBanco").val(idBanco);
  });
  
  $(".fechaPago").change(function(){
    var fecha = $(this).val();
    $(".fechaPago").val(fecha);
    // var limiInicial = $(".fecha_inicial_senior").val();
    // //alert(fecha);
    // // alert(limiInicial);
    // if(fecha > limiInicial){
    //   // alert($("option.opcionInicialReport").html());
    //   $("option.opcionInicialReport").hide();
    // }else{
    //   // alert($("option.opcionInicialReport").html());
    //   $("option.opcionInicialReport").show();
    // }
    $.ajax({
        url: '',
        type: 'POST',
        data: {
          encontrarTasa: true,
          fecha: fecha,
        },
        success: function(respuesta){
          // alert(respuesta);
          var data =JSON.parse(respuesta);
          if(data['ejecucion']==true){
            if(data['elementos']=="1"){
              data = data[0];
              $(".tasa").val(data['monto_tasa']);
              $(".monto").val("");
              // $(".monto").removeAttr("readonly","0");
            }else{
              $(".tasa").val("");
              $(".monto").val("0.00");
              // $(".monto").attr("readonly","1");
            }
          }
        }
    });
  });

  $(".montoDinero").focusin(function(){
    $(this).val("");
  });
  $(".montoDinero").focusout(function(){
    var x = $(this).val();
    if(x==""){
      $(this).val("0.00");
    }
    else if(x==0){
      $(this).val("0.00");
    }else {
      // alert('asd');
    }
  });
  $(".monto").keyup(function(){
    var monto = parseFloat($(this).val());
    var tasa = parseFloat($(".tasa").val());
    // alert("Todo menos BS: "+tasa);
    var eqv2 = monto / tasa;
    var eqv = eqv2.toFixed(2);
    if(eqv=='NaN'){eqv = 0; eqv = eqv.toFixed(2); eqv2 = 0;  eqv2 = eqv2.toFixed(2);}
    $(".equivalente").val(eqv);
    $(".equivalente2").val(eqv2);
  });
  $(".montobs").keyup(function(){
    var monto = parseFloat($(this).val());
    var tasa = parseFloat($(".tasabs").val());
    // alert(tasa);
    var eqv2 = monto / tasa;
    var eqv = eqv2.toFixed(2);
    if(eqv=='NaN'){eqv = 0; eqv = eqv.toFixed(2); eqv2 = 0;  eqv2 = eqv2.toFixed(2);}
    $(".equivalente").val(eqv);
    $(".equivalente2").val(eqv2);
  });

  $(".enviar").click(function(){
    var response = false;
    var id = $(this).attr("id");
    if(id=="boxFormTransferencia"){
      response = validarFromTransferencia(id);
    }
    if(id=="boxFormTransferenciaProvincial"){
      response = validarFormTransferenciaProvincial(id);
    }
    if(id=="boxFormPagoMovil"){
      response = validarFormPagoMovil(id);
    }
    if(id=="boxFormPagoMovilProvincial1"){
      response = validarFormPagoMovilProvincial1(id);
    }
    if(id=="boxFormPagoMovilProvincial2"){
      response = validarFormPagoMovilProvincial2(id);
    }
    if(id=="boxFormEfectivoBolivares"){
      response = validarFormEfectivoBolivares(id);
    }
    if(id=="boxFormDivisasDolares"){
      response = validarFormDivisasDolares(id);
    }
    if(id=="boxFormDepositoDivisas"){
      response = validarFormDepositoDivisasDolares(id);
    }
    if(id=="boxFormDepositoBolivares"){
      response = validarFromDepositoBolivares(id);
    }
    if(id=="boxFormDepositoBolivaresProvincial"){
      response = validarFromDepositoBolivaresProvincial(id);
    }
    if(id=="boxFormDivisasEuros"){
      response = validarFormDivisasEuros(id);
    }
    var btn = "btn-enviar-"+id;
    if(response == true){
      $(".btn-enviar").attr("disabled");

       swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){      



        // var formaPago = $("#forma").val();
        // var bancoPago = "";
        // var btn = "";
        // if(formaPago=="Transferencia Banco a Banco"){
        //   bancoPago = $(".bancoPagoT").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormTransferenciaProvincial";
        //     }else{
        //       btn = "btn-enviar-boxFormTransferencia";
        //     }
        //   }
        // }
        // if(formaPago=="Transferencia de Otros Bancos"){
        //   bancoPago = $(".bancoPagoT").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormTransferenciaProvincial";
        //     }else{
        //       btn = "btn-enviar-boxFormTransferencia";
        //     }
        //   }
        // }
        // if(formaPago=="Pago Movil Banco a Banco"){
        //   bancoPago = $(".bancoPagoPM").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormPagoMovilProvincial1";
        //       // $(".boxFormPagoMovil").show();
        //     }else{
        //       btn = "btn-enviar-boxFormPagoMovil";
        //     }
        //   }
        // }
        // if(formaPago=="Pago Movil de Otros Bancos"){
        //   bancoPago = $(".bancoPagoPM").val();
        //   if(bancoPago!=""){
        //     if(bancoPago=="Provincial"){
        //       btn = "btn-enviar-boxFormPagoMovilProvincial2";
        //       // $(".boxFormPagoMovil").show();
        //     }else{
        //       btn = "btn-enviar-boxFormPagoMovil";
        //     }
        //   }
        // }
        // if(formaPago=="Efectivo Bolivares"){
        //   btn = "btn-enviar-boxFormEfectivoBolivares";
        // }
        // if(formaPago=="Divisas Dolares"){
        //   btn = "btn-enviar-boxFormDivisasDolares";
        // }
        // if(formaPago=="Divisas Euros"){
        //   btn = "btn-enviar-boxFormDivisasEuros";
        // }




           
        $("."+btn).removeAttr("disabled");
        $("."+btn).click();
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });

    }
  });


});
function validarFromTransferencia(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del pago");      
    }
  }else{
      if(referencia.length > 6 || referencia.length < 6){
        $("."+id+" #error_referencia").html("La referencia debe contener 6 digitos");
        rreferencia = false;
      }else{
        $("."+id+" #error_referencia").html("");
        rreferencia = true;
      }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/


  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormTransferenciaProvincial(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovil(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del pago");      
    }
  }else{
      if(referencia.length > 6 || referencia.length < 6){
        $("."+id+" #error_referencia").html("La referencia debe contener 6 digitos");
        rreferencia = false;
      }else{
        $("."+id+" #error_referencia").html("");
        rreferencia = true;
      }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/


  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovilProvincial1(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del pago movil");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }else if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormPagoMovilProvincial2(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var telefono = $("."+id+" #telefono").val();
  var rtelefono = checkInput(telefono, numberPattern);
  if( rtelefono == false ){
    if(telefono.length != 0){
      $("."+id+" #error_telefono").html("El telefono solo acepta numeros");
    }else{
      $("."+id+" #error_telefono").html("Debe llenar telefono del pago movil");      
    }
  }else{
    $("."+id+" #error_telefono").html("");
    if(telefono.length >= 11 && telefono.length <= 13){
      $("."+id+" #error_telefono").html("");
      rtelefono = true;      
    }else{
      $("."+id+" #error_telefono").html("El telefono debe tener entre 11");
      rtelefono = false;      
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtelefono==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormEfectivoBolivares(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del pago");
    rmonto = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDivisasDolares(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del billete solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar el serial del billete");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del billete");
    requivalente = false;
  }
  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rserial==true && requivalente==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDepositoDivisasDolares(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del vauche solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar la referencia del deposito");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del deposito");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rserial==true && requivalente==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFromDepositoBolivares(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var referencia = $("."+id+" #referencia").val();
  var rreferencia = checkInput(referencia, numberPattern);
  if( rreferencia == false ){
    if(referencia.length != 0){
      $("."+id+" #error_referencia").html("La referencia solo acepta numeros");
    }else{
      $("."+id+" #error_referencia").html("Debe llenar la referencia del deposito");      
    }
  }else{
    $("."+id+" #error_referencia").html("");
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del deposito");
    rmonto = false;
  }
  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rreferencia==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFromDepositoBolivaresProvincial(id){
  // alert(id);

  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del deposito");
  }

  var cedula = $("."+id+" #cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
      $("."+id+" #error_cedula").html("La cedula solo acepta numeros");
    }else{
      $("."+id+" #error_cedula").html("Debe llenar la cedula del deposito");      
    }
  }else{
    var tipoced = $("."+id+" #tipo_cedula").val();
    if(tipoced=="V"){
      if(cedula.length >= 7 && cedula.length <= 8){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    if(tipoced=="J"){
      if(cedula.length >= 8 && cedula.length <= 9){
        $("."+id+" #error_cedula").html("");
        rcedula = true;      
      }else{
        $("."+id+" #error_cedula").html("La cedula debe tener entre 7 y 8 digitos");
        rcedula = false;      
      }
    }
    else{
        $("."+id+" #error_cedula").html("");
        rcedula = true;
    }
  }

  var monto = $("."+id+" #monto").val();
  monto = parseFloat(monto);
  var rmonto = false;
  if(monto > 0){
    $("."+id+" #error_monto").html("");
    rmonto = true;
  }else{
    $("."+id+" #error_monto").html("Debe cargar el monto del deposito");
    rmonto = false;
  }
  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rcedula==true && rmonto==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
function validarFormDivisasEuros(id){
  // alert(id);
  $("."+id+" .btn-enviar").attr("disabled");
  /*===================================================================*/
  var fechaPago = $("."+id+" #fechaPago").val();
  var rfechaPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( fechaPago.length != 0 ){
    $("."+id+" #error_fechaPago").html("");
    rfechaPago = true;
  }else{
    rfechaPago = false;
    $("."+id+" #error_fechaPago").html("Debe seleccionar la fecha de la emision del pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("El serial del billete solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar el serial del billete");      
    }
  }else{
    $("."+id+" #error_serial").html("");
  }

  var equivalente = $("."+id+" #equivalente").val();
  equivalente = parseFloat(equivalente);
  var requivalente = false;
  if(equivalente > 0){
    $("."+id+" #error_equivalente").html("");
    requivalente = true;
  }else{
    $("."+id+" #error_equivalente").html("Debe cargar monto del billete");
    requivalente = false;
  }
  // /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rserial==true && requivalente==true){
    result = true;
  }else{
    result = false;
  }

  /*===================================================================*/
  return result;
}
</script>
</body>
</html>
