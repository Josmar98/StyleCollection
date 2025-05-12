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
        <small><?php if(!empty($action)){echo "";} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo "";} echo " ".$modulo; ?></li>
      </ol>
    </section>

          <?php if($amInventarioC==1){ ?>
            <br>
            <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$modulo; ?></a></div>
          <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Actualizar <?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get" class="form_tipo_inventario">
              <div class="box-body">
              <input type="hidden" name="campaing" value="<?=$_GET['campaing']; ?>">
              <input type="hidden" name="n" value="<?=$_GET['n']; ?>">
              <input type="hidden" name="y" value="<?=$_GET['y']; ?>">
              <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
              <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
              <div class="row">
                  <div class="form-group col-xs-12 col-sm-12">
                    <label for="tipo_premio">Seleccione el tipo de premios</label>
                    <select class="form-control select2 tipo_premio" id="tipo_premio" name="tipo_premio" style="width:100%">
                      <option value=""></option>
                      <?php foreach($optionsss as $opt){ ?>
                        <option value="<?=$opt['id']; ?>" <?php  if(!empty($_GET['tipo_premio'])){  if($_GET['tipo_premio']==$opt['id']){  echo "selected";  } } ?>><?=$opt['name'];?></option>
                      <?php } ?>
                    </select>
                      <!-- <input type="number" class="form-control tipo_premio" name="tipo_premio" id="tipo_premio"> -->
                    <span id="error_tipo_premio" class="errors"></span>
                  </div>

                  <!-- <div class="form-group col-xs-12 col-sm-12">
                      <label for="precio">Precio de Gema</label>
                      <input type="number" class="form-control precio" name="precio" id="precio">
                      <span id="error_precio" class="errors"></span>
                  </div> -->
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviarTipo enviar2">Enviar</span>
              </div>
            </form>
            

            <?php if(!empty($_GET['tipo_premio'])){ ?>
              <form action="" method="post" class="form-update-prices">
                <div class="box-body">
                  <?php
                    if($_GET['tipo_premio']=='planes'){
                      foreach($titulos as $ti){
                        ?>
                        <div class="row">
                          <div class="col-xs-12" style="">
                            <div style="border:1px solid #ccc;margin-top:5px;margin-bottom:5px;">
                              <label for="" style="background:#434343;color:#FFF;display:block;padding:3px 10px;">
                                <?=$ti['name']; ?>
                                <span class="enviar2 expandOrNOt" id="<?=$ti['id_conector']; ?>" style="float:right;padding:0px 5px;border-radius:5px;">
                                  <i class="fa fa-caret-square-o-up etq<?=$ti['id_conector']; ?>"></i>
                                </span>
                                <div style="clear:both;"></div>
                              </label>
                              <div style="padding:5px 10px;margin-top:-10px;" class="box-expandOrNOt<?=$ti['id_conector']; ?>">
                                <?php 
                                  foreach($adicional as $ad){ 
                                    if($ad['id_conector']==$ti['id_conector']){
                                      ?>
                                      <label for="" style="background:#767676;color:#FFF;display:block;padding:3px 10px;"><?=$ad['informacion']; ?></label>
                                      <div style="padding:5px 10px;">
                                        <?php
                                          foreach($adicionalTipos as $tp){
                                            if(!empty($tp['tipo_premio'])){
                                              ?>
                                                <label for="" style="background:#BBBBBB;display:block;padding:3px 10px;margin-top:-10px;"><?=$tp['tipo_premio']; ?></label>
                                                <?php
                                                $numeroOpcion = 1;
                                              foreach($premios as $pr){
                                                if($ti['id_conector']==$pr['id_conector']){
                                                  if($ad['id_conectorTwo']==$pr['id_conectorTwo']){
                                                    if($tp['tipo_premio']==$pr['tipo_premio']){
                                                      ?>
                                                        <div style="padding:5px 10px;">
                                                          <label for="" style="background:#DDDDDD;display:block;padding:3px 10px;margin-top:-10px;">Opcion #<?=$numeroOpcion.": ".$pr['nombre_premio']; ?></label>
                                                          <div style="padding:5px 10px;margin-top:-10px;border:1px solid #ccc">
                                                            <?php
                                                              $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$pr['id_premio']}");
                                                              for ($i=0; $i < count($prinv)-1; $i++) { 
                                                                if($prinv[$i]['tipo_inventario']=="Productos"){
                                                                  $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                                }
                                                                if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                                  $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                                }
                                                                foreach ($inventario as $key) {
                                                                  if(!empty($key['elemento'])){
                                                                    $prinv[$i]['elemento']=$key['elemento'];
                                                                  }
                                                                }
                                                              }
                                                              ?>
                                                              <label for="" style="width:10%;float:left;">Unidades</label>
                                                              <label for="" style="width:70%;float:left;">Elemento de inventario</label>
                                                              <label for="" style="width:20%;float:left;">Precio Unitario</label>
                                                              <div style="clear:both"></div>
                                                              <?php
                                                              foreach($prinv as $inv){
                                                                if(!empty($inv['id_premio_inventario'])){
                                                                  ?>
                                                                  <input type="hidden" value="<?=$inv['id_premio_inventario']; ?>" name="id_premio_inventario[]">
                                                                  <input style="width:10%;float:left;" type="text" class="form-control" value="<?=$inv['unidades_inventario']; ?>" name="unidades_inventario[]" readonly>
                                                                  <input style="width:70%;float:left;" type="text" class="form-control" value="<?=$inv['elemento']; ?>" name="elementos[]" readonly>
                                                                  <input style="width:20%;float:left;" type="number" class="form-control" value="<?=$inv['precio_notas']; ?>" name="precios_inventario[]">
                                                                  <div style="clear:both;"></div>
                                                                  <?php
                                                                }
                                                              }
                                                            ?>
                                                          </div>
                                                        </div>
                                                        <br>
                                                      <?php 
                                                      $numeroOpcion++;
                                                    }
                                                  }
                                                }
                                              }
                                            }
                                          }
                                        ?>
                                      </div>
                                      <?php 
                                    } 
                                  } 
                                ?>
                              </div>
                            </div>

                          </div>
                        </div>
                        <?php
                      }
                    }
                    if($_GET['tipo_premio']=='retos'){
                      foreach($titulos as $ti){
                        ?>
                        <div class="row">
                          <div class="col-xs-12" style="">
                            <div style="border:1px solid #ccc;margin-top:5px;margin-bottom:5px;">
                              <label for="" style="background:#434343;color:#FFF;display:block;padding:3px 10px;">
                                <?=$ti['name']; ?>
                                <span class="enviar2 expandOrNOt" id="<?=$ti['id_conector']; ?>" style="float:right;padding:0px 5px;border-radius:5px;">
                                  <i class="fa fa-caret-square-o-up etq<?=$ti['id_conector']; ?>"></i>
                                </span>
                                <div style="clear:both;"></div>
                              </label>
                                <?php 
                                  $numeroOpcion = 1;
                                  foreach($premios as $pr){
                                    if($ti['id_conector']==$pr['id_conector']){
                                          ?>
                                            <div style="padding:5px 10px;" class="box-expandOrNOt<?=$ti['id_conector']; ?>">
                                              <label for="" style="background:#DDDDDD;display:block;padding:3px 10px;margin-top:-10px;">Opcion #<?=$numeroOpcion.": ".$pr['nombre_premio']; ?></label>
                                              <div style="padding:5px 10px;margin-top:-10px;border:1px solid #ccc">
                                                <?php
                                                  $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$pr['id_premio']} ORDER BY id_premio_inventario ASC");
                                                  for ($i=0; $i < count($prinv)-1; $i++) { 
                                                    if($prinv[$i]['tipo_inventario']=="Productos"){
                                                      $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                    }
                                                    if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                      $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                    }
                                                    foreach ($inventario as $key) {
                                                      if(!empty($key['elemento'])){
                                                        $prinv[$i]['elemento']=$key['elemento'];
                                                      }
                                                    }
                                                  }
                                                  ?>
                                                  <label for="" style="width:10%;float:left;">Unidades</label>
                                                  <label for="" style="width:70%;float:left;">Elemento de inventario</label>
                                                  <label for="" style="width:20%;float:left;">Precio Unitario</label>
                                                  <div style="clear:both"></div>
                                                  <?php
                                                  foreach($prinv as $inv){
                                                    if(!empty($inv['id_premio_inventario'])){
                                                      ?>
                                                      <input type="hidden" value="<?=$inv['id_premio_inventario']; ?>" name="id_premio_inventario[]">
                                                      <input style="width:10%;float:left;" type="text" class="form-control" value="<?=$inv['unidades_inventario']; ?>" name="unidades_inventario[]" readonly>
                                                      <input style="width:70%;float:left;" type="text" class="form-control" value="<?=$inv['elemento']; ?>" name="elementos[]" readonly>
                                                      <input style="width:20%;float:left;" type="number" class="form-control" value="<?=$inv['precio_notas']; ?>" name="precios_inventario[]">
                                                      <div style="clear:both;"></div>
                                                      <?php
                                                    }
                                                  }
                                                ?>
                                              </div>
                                            </div>
                                            <br>
                                          <?php 
                                          $numeroOpcion++;
                                    }
                                  }
                                ?>
                            </div>

                          </div>
                        </div>
                        <?php
                      }
                    }
                    if($_GET['tipo_premio']=='catalogo'){
                      foreach($titulos as $ti){
                        ?>
                        <div class="row">
                          <div class="col-xs-12" style="">
                            <div style="border:1px solid #ccc;margin-top:5px;margin-bottom:5px;">
                              <label for="" style="background:#434343;color:#FFF;display:block;padding:3px 10px;">
                                <?=$ti['name']; ?>
                                <span class="enviar2 expandOrNOt" id="<?=$ti['numero']; ?>" style="float:right;padding:0px 5px;border-radius:5px;">
                                  <i class="fa fa-caret-square-o-up etq<?=$ti['numero']; ?>"></i>
                                </span>
                                <div style="clear:both;"></div>
                              </label>
                              <div style="padding:5px 10px;margin-top:-10px;" class="box-expandOrNOt<?=$ti['numero']; ?>">
                                <?php 
                                  $numeroOpcion = 1;
                                  foreach($premios as $pr){
                                    if($ti['id_conector']==$pr['id_conector']){
                                      ?>
                                        <label for="" style="background:#767676;color:#FFF;display:block;padding:3px 10px;"><?=$pr['name']; ?></label>
                                        <div style="padding:5px 10px;">
                                          <label for="" style="background:#DDDDDD;display:block;padding:3px 10px;margin-top:-10px;">Opcion #<?=$numeroOpcion.": ".$pr['nombre_premio']; ?></label>
                                          <div style="padding:5px 10px;margin-top:-10px;border:1px solid #ccc">
                                            <?php
                                              $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$pr['id_premio']} ORDER BY id_premio_inventario ASC");
                                              for ($i=0; $i < count($prinv)-1; $i++) { 
                                                if($prinv[$i]['tipo_inventario']=="Productos"){
                                                  $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                }
                                                if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                  $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                }
                                                foreach ($inventario as $key) {
                                                  if(!empty($key['elemento'])){
                                                    $prinv[$i]['elemento']=$key['elemento'];
                                                  }
                                                }
                                              }
                                              ?>
                                              <label for="" style="width:10%;float:left;">Unidades</label>
                                              <label for="" style="width:70%;float:left;">Elemento de inventario</label>
                                              <label for="" style="width:20%;float:left;">Precio Unitario</label>
                                              <div style="clear:both"></div>
                                              <?php
                                              foreach($prinv as $inv){
                                                if(!empty($inv['id_premio_inventario'])){
                                                  ?>
                                                  <input type="hidden" value="<?=$inv['id_premio_inventario']; ?>" name="id_premio_inventario[]">
                                                  <input style="width:10%;float:left;" type="text" class="form-control" value="<?=$inv['unidades_inventario']; ?>" name="unidades_inventario[]" readonly>
                                                  <input style="width:70%;float:left;" type="text" class="form-control" value="<?=$inv['elemento']; ?>" name="elementos[]" readonly>
                                                  <input style="width:20%;float:left;" type="number" class="form-control" value="<?=$inv['precio_notas']; ?>" name="precios_inventario[]">
                                                  <div style="clear:both;"></div>
                                                  <?php
                                                }
                                              }
                                            ?>
                                          </div>
                                        </div>
                                        <br>
                                      <?php 
                                    $numeroOpcion++;
                                    }
                                  }
                                ?>
                              </div>
                            </div>

                          </div>
                        </div>
                        <?php
                      }
                    }
                    if($_GET['tipo_premio']=='promociones'){
                      foreach($titulos as $ti){
                        ?>
                        <div class="row">
                          <div class="col-xs-12" style="">
                            <div style="border:1px solid #ccc;margin-top:5px;margin-bottom:5px;">
                              <label for="" style="background:#434343;color:#FFF;display:block;padding:3px 10px;">
                                <?=$ti['name']; ?>
                                <span class="enviar2 expandOrNOt" id="<?=$ti['id_conector']; ?>" style="float:right;padding:0px 5px;border-radius:5px;">
                                  <i class="fa fa-caret-square-o-up etq<?=$ti['id_conector']; ?>"></i>
                                </span>
                                <div style="clear:both;"></div>
                              </label>
                                <?php 
                                  $numeroOpcion = 1;
                                  foreach($premios as $pr){
                                    if($ti['id_conector']==$pr['id_conector']){
                                          ?>
                                            <div style="padding:5px 10px;"  class="box-expandOrNOt<?=$ti['id_conector']; ?>">
                                              <label for="" style="background:#DDDDDD;display:block;padding:3px 10px;margin-top:-10px;">Opcion #<?=$numeroOpcion.": ".$pr['nombre_premio']; ?></label>
                                              <div style="padding:5px 10px;margin-top:-10px;border:1px solid #ccc">
                                                <?php
                                                  $prinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE id_premio={$pr['id_premio']} ORDER BY id_premio_inventario ASC");
                                                  for ($i=0; $i < count($prinv)-1; $i++) { 
                                                    if($prinv[$i]['tipo_inventario']=="Productos"){
                                                      $inventario = $lider->consultarQuery("SELECT *, producto as elemento FROM productos WHERE id_producto={$prinv[$i]['id_inventario']}");
                                                    }
                                                    if($prinv[$i]['tipo_inventario']=="Mercancia"){
                                                      $inventario = $lider->consultarQuery("SELECT *, mercancia as elemento FROM mercancia WHERE id_mercancia={$prinv[$i]['id_inventario']}");
                                                    }
                                                    foreach ($inventario as $key) {
                                                      if(!empty($key['elemento'])){
                                                        $prinv[$i]['elemento']=$key['elemento'];
                                                      }
                                                    }
                                                  }
                                                  ?>
                                                  <label for="" style="width:10%;float:left;">Unidades</label>
                                                  <label for="" style="width:70%;float:left;">Elemento de inventario</label>
                                                  <label for="" style="width:20%;float:left;">Precio Unitario</label>
                                                  <div style="clear:both"></div>
                                                  <?php
                                                  foreach($prinv as $inv){
                                                    if(!empty($inv['id_premio_inventario'])){
                                                      ?>
                                                      <input type="hidden" value="<?=$inv['id_premio_inventario']; ?>" name="id_premio_inventario[]">
                                                      <input style="width:10%;float:left;" type="text" class="form-control" value="<?=$inv['unidades_inventario']; ?>" name="unidades_inventario[]" readonly>
                                                      <input style="width:70%;float:left;" type="text" class="form-control" value="<?=$inv['elemento']; ?>" name="elementos[]" readonly>
                                                      <input style="width:20%;float:left;" type="number" class="form-control" value="<?=$inv['precio_notas']; ?>" name="precios_inventario[]" readonly>
                                                      <div style="clear:both;"></div>
                                                      <?php
                                                    }
                                                  }
                                                ?>
                                              </div>
                                            </div>
                                            <br>
                                          <?php 
                                          $numeroOpcion++;
                                    }
                                  }
                                ?>
                            </div>

                          </div>
                        </div>
                        <?php
                      }
                    }
                  ?>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  
                  <!-- <span type="submit" class="btn enviarTipo enviar2">Actualizar</span> -->
                  <span type="submit" class="btn enviar ">Actualizar</span>
                  <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                  <button class="btn-enviar d-none" disabled="" >enviar</button>
                </div>
              </form>
            <?php } ?>
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
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.expandOrNOt:hover{
  cursor:pointer;
}
.expandOrNOt{
  float:right;
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
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PreciosNotas";
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
  $(".expandOrNOt").click(function(){
    var id = $(this).attr('id');
    if($(".box-expandOrNOt"+id).is(":visible")){
      $(".box-expandOrNOt"+id).slideUp();
      $(".etq"+id).removeClass("fa-caret-square-o-up");
      $(".etq"+id).addClass("fa-caret-square-o-down");
      
      
    }else{
      $(".box-expandOrNOt"+id).slideDown();
      $(".etq"+id).removeClass("fa-caret-square-o-down");
      $(".etq"+id).addClass("fa-caret-square-o-up");
    }
  });
  $(".enviarTipo").click(function(){
    var tipo = $("#tipo_premio").val();
    var response = false;
    if(tipo==""){
      response = false;
      $("#error_tipo_premio").html("Debe seleccionar un tipo de premio");
    }else{
      response = true;
      $("#error_tipo_premio").html("");
    }
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
            $(".form_tipo_inventario").submit();
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
    
  $(".enviar").click(function(){
    var response = true;
    // var response = validar();

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
            $(".form-update-prices").submit();
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         nombre_plan: $("#nombre_plan").val(),
              //       },
              //       success: function(respuesta){
              //         alert(respuesta);
              //         if (respuesta == "1"){
              //             $(".btn-enviar").removeAttr("disabled");
              //             $(".btn-enviar").click();
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Los datos ingresados estan repetidos!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //       }
              //   });
              
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
  var precio = $("#precio").val();
  var rprecio = checkInput(precio, numberPattern2);
  if( rprecio == false ){
    if(precio.length != 0){
      $("#error_precio").html("EL precio no puede tener caracteres especiales");
    }else{
      $("#error_precio").html("Debe llenar la precio de la gema");      
    }
  }else{
    $("#error_precio").html("");
  }
  /*===================================================================*/


  /*===================================================================*/
  var result = false;
  if(rprecio==true){
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
