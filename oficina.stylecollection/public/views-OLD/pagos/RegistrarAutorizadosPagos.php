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
        <?php echo "".$url; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "".$url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." ".$url;}else{echo "".$url;} ?></li>
      </ol>
    </section>
          <br>
              <?php if($_SESSION['nombre_rol']!="Vendedor"){$rut = "Pagos";}else{$rut="MisPagos";} ?>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $rut ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$url?></a></div>
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
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>

        
        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "".$url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                  <div class="form-group col-xs-12">
                    <label for="lider">Seleccione al Lider</label>
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="Pagos" name="route">
                    <input type="hidden" value="RegistrarAutorizados" name="action">
                    <input type="hidden" value="1" name="admin">
                    <input type="hidden" value="1" name="select">
                    <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                      <option></option>
                        <?php foreach ($lideres as $data): ?>
                          <?php if (!empty($data['id_cliente'])): ?>
                          
                      <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?>
                          selected="selected"
                      <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                          <?php endif ?>
                        <?php endforeach ?>
                    </select>
                  </div>
                  </form>
                </div>
                <?php } ?>
            </div>
            
            <?php //if( (empty($_GET['admin']) && !isset($_GET['select'])) || (!empty($_GET['admin']) && isset($_GET['select']) && $_GET['select']==1) ){ ?>
            <!-- <div class="box-footer">
              <span type="submit" class="btn btn-default enviar2 color-button-sweetalert" style='background:#ED2A77;color:#fff'>Cargar</span>
              <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
            </div> -->
            <?php //} ?>
                  
            <?php 
              $configs = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
              $diasAdicionales = 0;
              foreach ($configs as $cf) {
                if(!empty($cf['id_configuracion'])){
                  if($cf['clausula']=="Diasaddpagounotres"){
                    if($cf['valor']>0){
                      $diasAdicionales=3;
                    }
                  }
                  if($cf['clausula']=="Diasaddpagounocinco"){
                    if($cf['valor']>0){
                      $diasAdicionales=5;
                    }
                  }
                }
              }
              // echo $diasAdicionales;
              $actualDate = date('Y-m-d');
              $days = ((60*60)*24)*$diasAdicionales;
              $newFecha = date('Y-m-d', time()-$days);
              // echo $actualDate."<br>";
              // echo $days."<br>";
              // echo $newFecha."<br>";

              // echo "<br>".$days;
              $abonos = 0;
              $primerPago = 1;
              if(!empty($pagos) && count($pagos)>1){
                foreach ($pagos as $pag) {
                  if(!empty($pag['equivalente_pago'])){
                    if($pag['estado']=="Abonado"){
                      if($pag['tipo_pago']=="Primer Pago"){
                        $abonos += $pag['equivalente_pago'];
                      }                  
                    }
                  }
                }
              }
              if(!empty($pedido) && count($pedido)>1){
                $primerPago = $pedido['cantidad_aprobado'] * $pedido['primer_precio_coleccion'];
              }
              // echo $abonos."<br>";
              $limiteDefinitivo = "";
              if($despachos[0]['limite_pedido'] < $limiteFechaMinimo){
                $limiteDefinitivo = $despachos[0]['limite_pedido'];
              }else{
                $limiteDefinitivo = $limiteFechaMinimo;
              }
              // echo "Limte será: <b>".$limiteDefinitivo."</b>";
            ?>
            <?php if (!empty($_GET['lider'])):  ?>
              <div class="boxForm boxFormDivisasDolares" style="display:">
                <form action="" method="post" role="form" class="form_register">
                  <div class="box-body">
                    <div class="row">

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="fechaPago">Fecha de Pago</label>
                           <input type="date" class="form-control fechaPago" min="<?=$limiteDefinitivo; ?>" name="fechaPago" id="fechaPago" max="<?=date('Y-m-d')?>">
                           <span id="error_fechaPago" class="errors"></span>
                        </div>

                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="tipoPago">Tipo de pago <small>Ej. (Inicial / Primer Pago, etc.)</small></label>
                           <select class="form-control select2" id="tipoPago" name="tipoPago" style="width:100%;">
                              <option></option>
                              <option>Contado</option>
                              <option>Inicial</option>
                              <?php foreach ($cantidadPagosDespachosFild as $cvPagos): ?>
                              <option><?=$cvPagos['name']; ?></option>
                              <?php endforeach ?>
                              <!-- <option>Primer Pago</option> -->
                              <!-- <option>Segundo Pago</option> -->
                              <?php 
                                foreach ($promociones as $promoPagos) {
                                  if(!empty($promoPagos['id_promocion'])){
                                    if($promoPagos['cantidad_aprobada_promocion']>0){
                                      echo "<option>".$promoPagos['nombre_promocion']."</option>";
                                    }
                                  }
                                }
                              ?>
                           </select>
                           <span id="error_tipoPago" class="errors"></span>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="equivalente">Equivalente</label>
                          <div class="input-group">
                           <span class="input-group-addon" style="background:#EEE">$</span> 
                           <input type="number" value="0.00" step="0.01" class="form-control equivalente montoDinero" id="equivalente" class="equivalente" name="equivalente">
                          </div>
                           <span id="error_equivalente" class="errors"></span>
                        </div>


                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                           <label for="serial">Observacion Pago Autorizado</label>
                           <input type="text" class="form-control" id="serial" name="serial">
                           <span id="error_serial" class="errors"></span>
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
            <?php endif; ?>


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
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
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
  if(response==undefined){
  }else{    if(response == "1"){
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
        var menu = "";
        <?php if(!empty($_GET['admin'])&&!empty($_GET['lider'])){ ?>
          menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&admin="+<?=$_GET['admin']?>+"&lider="+<?=$_GET['lider']?>;
        <?php }else{ ?>
          menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=MisPagos";
        <?php } ?>
        window.location.href=menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Registro Repetido!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Pagos&action=Registrar";
        window.location.href=menu;
      });
    }
  }
  
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


  $(".fechaPago").change(function(){
    var fecha = $(this).val();
    $(".fechaPago").val(fecha);
    var campaing = $(".campaing").val();
    var n = $(".n").val();
    var y = $(".y").val();
    var dpid = $(".dpid").val();
    var dp = $(".dp").val();
    $.ajax({
        url: '?campaing='+campaing+'&n='+n+'&y='+y+'&dpid='+dpid+'&dp='+dp+'&route=Pagos&action=Registrar',
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

  $(".monto").keyup(function(){
    var monto = parseFloat($(this).val());
    var tasa = parseFloat($(".tasa").val());
    var eqv2 = monto / tasa;
    var eqv = eqv2.toFixed(2);
    if(eqv=='NaN'){eqv = 0; eqv = eqv.toFixed(2); eqv2 = 0;  eqv2 = eqv2.toFixed(2);}
    $(".equivalente").val(eqv);
    $(".equivalente2").val(eqv2);
  });

  $("#descuento_coleccion").keyup(function(){
    var max = parseFloat($(".max_total_descuento").val());
    var descuento = parseFloat($(this).val());
    var total = (max+descuento).toFixed(2);
    $("#total_descuento").val(total);
  });

  $(".enviar").click(function(){
    var response = false;
    var id = $(this).attr("id");

    if(id=="boxFormDivisasDolares"){
      response = validarFormDivisasDolares(id);
    }

    var btn = "btn-enviar-"+id;

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

        $("."+btn).removeAttr("disabled");
        $("."+btn).click();
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });

    }


    
  });




});

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

  var tipoPago = $("."+id+" #tipoPago").val();
  var rtipoPago = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  if( tipoPago.length != 0 ){
    $("."+id+" #error_tipoPago").html("");
    rtipoPago = true;
  }else{
    rtipoPago = false;
    $("."+id+" #error_tipoPago").html("Debe seleccionar el tipo de pago");
  }

  var serial = $("."+id+" #serial").val();
  var rserial = checkInput(serial, alfanumericPattern);
  if( rserial == false ){
    if(serial.length != 0){
      $("."+id+" #error_serial").html("La observacion del pago solo acepta numero y Letras");
    }else{
      $("."+id+" #error_serial").html("Debe llenar el campo de Observacion");      
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
    $("."+id+" #error_equivalente").html("Debe cargar monto equivalente al pago");
    requivalente = false;
  }

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/

  // /*===================================================================*/



  // /*===================================================================*/
  var result = false;
  if( rfechaPago==true && rtipoPago==true && rserial==true && requivalente==true){
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
