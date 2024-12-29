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
    <div class="row boxboxtop" >
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body box-profile text-center boxPortada" style="padding:0;background:#000;">
            <!-- <img src="public/assets/img/images/img53.jpg" class="row col-sm-10 col-sm-offset-1" style=";height:100%;"> -->
            <img src="<?=$fotoPortada?>" class="row" style="z-index:0;height:100%;">
                        <!-- position:absolute;left:10%;top:65%; -->
                        <!-- position:relative;top:-30%;left:10%; -->
            <div class="col-xs-12 boxboxfondobox" style="background:#FFF;">
              <div class="row">
                
              </div>
                <div class="RealImage image col-xs-12 col-sm-3 col-md-3" style="padding:0;margin:0;">
                  <img src="<?=$fotoPerfil?>" class="imgPerfil imageImage">
                  <!-- <img src="public/assets/img/profile/perfil.jpg" style="background:#fff;height:100%;width:100%" class='profile-user-img img-responsive img-circle' alt="User Image"> -->
                </div>              
                <h4 style="" class="col-xs-12 col-sm-9 col-md-9 textPerfil textPerfil1">
                  <b style="color:<?=$fucsia?>">
                    
                  <?php echo $cuenta['primer_nombre']; ?>
                  <?php echo $cuenta['primer_apellido']; ?>   
                  </b>
                </h4>
                <h4 style="margin-top:-1%;" class="col-xs-12 col-md-9 textPerfil textPerfil2">
                  <small style="font-size:.6em;"> 
                    <?php echo $rroll ?> de StyleCollection
                  </small> 
                  <!-- JAJAJAJA -->
                </h4>
                <!-- <br><br>
                <h4 style="" class="col-xs-12 col-md-9 textPerfil">
                  JAJAJAJA
                </h4> -->


            </div>
            <div class="box-body row box-image-foto">
              <!-- <div class="col-xs-12" style="border-radius:100% 100% 100% 100%;background:#444;padding:3px"> -->
              <div class="col-xs-12">
                  
              </div>
              <!-- <div class="col-xs-12" style="position:relative;width:100%"> -->
              <!-- </div> -->
            </div>

          </div>
          
        </div>
      </div>
    </div>
    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-top:">
      <h1>
        Perfil de usuario
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="?route=Perfil">Perfil</a></li>
        <li class="active">Perfil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- <div class="col-md-3">
          <div class="box">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center"><?=$cliente['primer_nombre']." ".$cliente['primer_apellido']?></h3>

              <p class="text-muted text-center"><?=$rrollCliente?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn enviar btn-block"><b>Follow</b></a>
            </div>
          </div>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            /.box-header
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
          </div>
        </div> -->





        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#infos" data-toggle="tab">Informaciones</a></li>
              <!-- <li><a href="#activity" data-toggle="tab">Actividad</a></li> -->

              <!-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
              <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="infos">

                <!-- <form> -->
                <?php if($editarPerfilDisponible==1){?>
                <div class="alert" style="background:#ccc;padding-top:5px;padding-bottom:5px;">
                  <button style="margin-left:-10px;" class="btn buttonEditCuentaDown d-none" ><span class="fa fa-caret-square-o-down"></span></button>&nbsp
                  <button style="margin-left:-10px;" class="btn buttonEditCuentaUp"><span class="fa fa-caret-square-o-up"></span></button>
                  <span style="font-size:1.4em;position:relative;top:4px;left:5%;"><u>Editar Perfil</u></span>
                </div>
                <?php
                  $editarFotos=0;
                  $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
                  foreach ($configuraciones as $config) {
                    if(!empty($config['id_configuracion'])){
                      if($config['clausula']=="Editar Fotos"){
                        $editarFotos = $config['valor'];
                      }
                    }
                  }
                ?>
                <form action="" method="POST" class="form-horizontal formCuenta"  <?php if($editarFotos==1){ ?> enctype="multipart/form-data" <?php } ?>  >
                    <div class="form-group">
                      <label for="nombre1" class="col-sm-2 control-label">
                        <span style='color:#000'>Primer Nombre</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre1" name="nombre1" maxlength="30" value="<?php echo $cuenta['primer_nombre'] ?>" placeholder="Primer Nombre">
                       <span id="error_nombre1" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="nombre2" class="col-sm-2 control-label">
                        <span style='color:#000'>Segundo Nombre</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre2" name="nombre2" maxlength="30" value="<?php echo $cuenta['segundo_nombre'] ?>" placeholder="Segundo Nombre">
                       <span id="error_nombre2" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="apellido1" class="col-sm-2 control-label">
                        <span style='color:#000'>Primer Apellido</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="apellido1" name="apellido1" maxlength="30" value="<?php echo $cuenta['primer_apellido'] ?>" placeholder="Primer Apellido">
                       <span id="error_apellido1" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="apellido2" class="col-sm-2 control-label">
                        <span style='color:#000'>Segundo Apellido</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="apellido2" name="apellido2" maxlength="30" value="<?php echo $cuenta['segundo_apellido'] ?>" placeholder="Segundo Apellido">
                       <span id="error_apellido2" class="errors"></span>
                      </div>
                    </div>



                    <div class="form-group">
                      <label for="cedula" class="col-sm-2 control-label">
                        <span style='color:#000'>Cedula</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="cedula" name="cedula" maxlength="9" value="<?php echo $cuenta['cedula']; ?>" placeholder="Cedula">
                      <span id="error_cedula" class="errors"></span>
                      </div>
                    </div>
                  


                    <div class="form-group">
                      <label for="fechaNacimiento" class="col-sm-2 control-label">
                        <span style='color:#000'>Fecha de Nacimiento</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="date" max="<?php echo date("Y-m-d") ?>" value="<?php echo $cuenta['fecha_nacimiento'] ?>" class="form-control" id="fechaNacimiento" name="fechaNacimiento">
                      <span id="error_fechaNacimiento" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="rif" class="col-sm-2 control-label">
                        <span style='color:#000'>Rif</span>
                      </label>
                      <div class="col-sm-10">
                        <div class="input-group" style="width:100%;">
                            <select id="cod_rif" name="cod_rif" class="form-control input-group-addon" style="width:25%">
                              <option <?php if($cuenta['cod_rif'] == "V"){ echo "selected=''";} ?>>V</option>
                              <option <?php if($cuenta['cod_rif'] == "J"){ echo "selected=''";} ?>>J</option>
                              <option <?php if($cuenta['cod_rif'] == "G"){ echo "selected=''";} ?>>G</option>
                              <option <?php if($cuenta['cod_rif'] == "E"){ echo "selected=''";} ?>>E</option>
                            </select>  
                            <input type="text" style="width:75%" class="form-control" value="<?php echo $cuenta['rif']; ?>" id="rif" maxlength="12" name="rif" placeholder="Numero Rif">
                      <span id="error_rif" class="errors"></span>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="telefono" class="col-sm-2 control-label">
                        <span style='color:#000'>Telefono</span>
                      </label>
                      <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="inputTlfn" value="<?php echo $cuenta['telefono'] ?>" placeholder="Name"> -->
                            <div class="input-group col-xs-12">
                              <select id="cod_tlfn" name="cod_tlfn" class="form-control input-group-addon" style="width:25%">
                                  <option <?php if($cod_tlfn == "0412"){ echo "selected=''";} ?>>0412</option>
                                  <option <?php if($cod_tlfn == "0414"){ echo "selected=''";} ?>>0414</option>
                                  <option <?php if($cod_tlfn == "0424"){ echo "selected=''";} ?>>0424</option>
                                  <option <?php if($cod_tlfn == "0416"){ echo "selected=''";} ?>>0416</option>
                                  <option <?php if($cod_tlfn == "0426"){ echo "selected=''";} ?>>0426</option>
                                  <option <?php if($cod_tlfn == "0251"){ echo "selected=''";} ?>>0251</option>
                                </select>  
                              <input type="text" style="width:75%" maxlength="7" value="<?php echo $numtelefono; ?>" minlength="7" class="form-control" id="telefono" name="telefono" maxlength="9" placeholder="Numero de telefono">
                      <span id="error_telefono" class="errors"></span>
                          </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <label for="telefono2" class="col-sm-2 control-label">
                        <span style='color:#000'>Telefono 2</span>
                      </label>
                      <div class="col-sm-10">
                        <!-- <input type="text" class="form-control" id="inputTlfn" value="<?php echo $cuenta['telefono'] ?>" placeholder="Name"> -->
                            <div class="input-group col-xs-12">
                              <select id="cod_tlfn2" name="cod_tlfn2" class="form-control input-group-addon" style="width:25%">
                                  <option <?php if($cod_tlfn2 == "0412"){ echo "selected=''";} ?>>0412</option>
                                  <option <?php if($cod_tlfn2 == "0414"){ echo "selected=''";} ?>>0414</option>
                                  <option <?php if($cod_tlfn2 == "0424"){ echo "selected=''";} ?>>0424</option>
                                  <option <?php if($cod_tlfn2 == "0416"){ echo "selected=''";} ?>>0416</option>
                                  <option <?php if($cod_tlfn2 == "0426"){ echo "selected=''";} ?>>0426</option>
                                  <option <?php if($cod_tlfn2 == "0251"){ echo "selected=''";} ?>>0251</option>
                                </select>  
                              <input type="text" style="width:75%" maxlength="7" value="<?php echo $numtelefono2; ?>" minlength="7" class="form-control" id="telefono2" name="telefono2" maxlength="9" placeholder="Numero de telefono">
                          </div>
                      </div>
                    </div>



                    <div class="form-group">
                      <label for="correo" class="col-sm-2 control-label">
                        <span style='color:#000'>Email</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="correo" name="correo"  value="<?php echo $cuenta['correo'] ?>" placeholder="Email">
                      <span id="error_correo" class="errors"></span>
                      </div>
                    </div>
                  


                    <div class="form-group">
                      <label for="direccion" class="col-sm-2 control-label">
                        <span style='color:#000'>Direccion</span>
                      </label>
                      <div class="col-sm-10">
                        <textarea class="form-control"  id="direccion" name="direccion" maxlength="200" placeholder="Direccion" style="max-width:100%;min-width:100%;min-height:50px;max-height:50px;"><?php echo $cuenta['direccion'] ?></textarea>
                      <span id="error_direccion" class="errors"></span>
                      </div>
                    </div>

                    <?php if($editarFotos==1){ ?>
                    <div class="form-group">
                      <label for="fotos" class="col-sm-2 control-label">
                        <span style='color:#000'>Foto de perfil</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" id="fotos" name="fotos">
                        <span id="error_fotos" class="errors"><b>Nota: </b> Si desea dejar la misma foto de perfil, <b>No</b> seleccione una foto nueva</span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="fotos" class="col-sm-2 control-label">
                        <span style='color:#000'></span>
                      </label>
                      <div class="col-xs-10 col-sm-4 col-md-3">
                        <img style="width:100%;" src="<?=$usuario['fotoPerfil']; ?>">
                      </div>
                    </div>
                    <?php } ?>


                    <div class="box-footer">                    
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                          <span type="submit" class="btn enviar">Enviar</span>
                          <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                          <button class="btn-enviar d-none" disabled="" ></button>
                          <a href="?route=Perfil" style="margin-left:5%;" class="btn btn-default">Cancelar</a>

                      </div>
                    </div>


                </form>
                <hr>
                <?php } ?>

                <?php if($editarNombreUsuarioDisponible==1){?>
                <div class="alert" style="background:#ccc;padding-top:5px;padding-bottom:5px;">
                  <button style="margin-left:-10px;" class="btn buttonEditUserDown" ><span class="fa fa-caret-square-o-down"></span></button>&nbsp
                  <button style="margin-left:-10px;" class="btn buttonEditUserUp d-none"><span class="fa fa-caret-square-o-up"></span></button>
                  <span style="font-size:1.4em;position:relative;top:4px;left:5%;"><u>Editar Nombre de Usuario</u></span>
                </div>
                <form action="" method="POST" class="form-horizontal formUser d-none">
                    <div class="form-group">
                      <label for="username" class="col-sm-2 control-label">
                        <span style='color:#000'>Nombre de Usuario</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" maxlength="50" value="<?php echo $_SESSION['username'] ?>" placeholder="Primer Nombre">
                       <span id="error_username" class="errors"></span>
                      </div>
                    </div>


                    <div class="box-footer">                    
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                          <span type="submit" class="btn enviar2">Enviar</span>
                          <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                          <button class="btn-enviar2 d-none" disabled="" ></button>
                          <a href="?route=Perfil" style="margin-left:5%;" class="btn btn-default">Cancelar</a>

                      </div>
                    </div>


                </form>
                <hr>
                <?php } ?>

                <?php if($editarClaveUsuarioDisponible==1){?>
                  <div class="alert" style="background:#ccc;padding-top:5px;padding-bottom:5px;">
                  <button style="margin-left:-10px;" class="btn buttonEditPassDown" ><span class="fa fa-caret-square-o-down"></span></button>&nbsp
                  <button style="margin-left:-10px;" class="btn buttonEditPassUp d-none"><span class="fa fa-caret-square-o-up"></span></button>
                  <span style="font-size:1.4em;position:relative;top:4px;left:5%;"><u>Editar Contraseña</u></span>
                </div>
                <form action="" method="POST" class="form-horizontal formPass d-none">
                    <div class="form-group">
                      <label for="pass" class="col-sm-2 control-label">
                        <span style='color:#000'>Contraseña Actual</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="pass" name="pass" maxlength="50" placeholder="Escriba su actual contraseña">
                       <span id="error_pass" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="newPass" class="col-sm-2 control-label">
                        <span style='color:#000'>Nueva Contraseña</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="newPass" name="newPass" maxlength="50" placeholder="Escriba su nueva contraseña" readonly="">
                        <span id="info_password" class="info"></span>
                       <span id="error_newPass" class="errors"></span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="newPass2" class="col-sm-2 control-label">
                        <span style='color:#000'>Confirmar Contraseña</span>
                      </label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="newPass2" name="newPass2" maxlength="50" placeholder="Confirmar su nueva contraseña" readonly="">
                        <span id="info_password2" class="info"></span>
                       <span id="error_newPass2" class="errors"></span>
                      </div>
                    </div>

                    <div class="box-footer">                    
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                          <span type="submit" class="btn enviar3">Enviar</span>
                          <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                          <button class="btn-enviar3 d-none" disabled="" ></button>
                          <a href="?route=Perfil" style="margin-left:5%;" class="btn btn-default">Cancelar</a>

                      </div>
                    </div>


                </form>
                <?php } ?>

              </div>



            </div>
          </div>
          <!-- /.nav-tabs-custom -->
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
<input type="hidden" class="passActual" value="<?php echo $_SESSION['pass']; ?>">

<!-- jQuery 3 -->
  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>

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

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Perfil";
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
  $(".buttonEditCuentaDown").click(function(){
    $(".formCuenta").slideDown(500);
    $(".buttonEditCuentaDown").hide();
    $(".buttonEditCuentaUp").show();
  });
  $(".buttonEditCuentaUp").click(function(){
    $(".formCuenta").slideUp(500);
    $(".buttonEditCuentaUp").hide();
    $(".buttonEditCuentaDown").show();
  });
  $(".formUser").hide();
  $(".formUser").removeClass("d-none");
  $(".buttonEditUserDown").click(function(){
    $(".formUser").slideDown(500);
    $(".buttonEditUserDown").hide();
    $(".buttonEditUserUp").show();
  });
  $(".buttonEditUserUp").click(function(){
    $(".formUser").slideUp(500);
    $(".buttonEditUserUp").hide();
    $(".buttonEditUserDown").show();
  });

  $(".formPass").hide();
  $(".formPass").removeClass("d-none");
  $(".buttonEditPassDown").click(function(){
    $(".formPass").slideDown(500);
    $(".buttonEditPassDown").hide();
    $(".buttonEditPassUp").show();
  });
  $(".buttonEditPassUp").click(function(){
    $(".formPass").slideUp(500);
    $(".buttonEditPassUp").hide();
    $(".buttonEditPassDown").show();
  });

  $(".enviar").click(function(){
    var response = validar();

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
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
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

    $(".enviar2").click(function(){
    var response = validarUser();

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
                          $(".btn-enviar2").removeAttr("disabled");
                          $(".btn-enviar2").click();
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

  $(".enviar3").click(function(){
    var response = validarPass();

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
                          $(".btn-enviar3").removeAttr("disabled");
                          $(".btn-enviar3").click();
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
  $("#pass").keyup(function(){
    var pass = $(this).val();
    var passx = $(".passActual").val();
    if(pass==passx){
      $("#newPass").removeAttr("readonly");
      $("#newPass2").removeAttr("readonly");
    }else{
      $("#newPass").val("");
      $("#newPass2").val("");
      $("#newPass").attr("readonly","1");
      $("#newPass2").attr("readonly","1");
      $("#info_password2").html("");
    }

  });
  $("#newPass2").keyup(function(){
    $("#error_newPass2").html("");
    var p1 = $("#newPass").val();
    var p2 = $(this).val();
    if(p1 == p2){
      $("#info_password2").attr("style","color:green;");
      $("#info_password2").html("Las contraseñas coinciden");
    }else{
      $("#info_password2").attr("style","color:red;");
      $("#info_password2").html("Las contraseñas no coinciden");
    }
  });


});

function validarUser(){
  $(".btn-enviar").attr("disabled");
    var username = $("#username").val();
  var rusername = checkInput(username, alfanumericPattern3);
  if( rusername == false ){
    if(username.length != 0){
      rusername=false;
      $("#error_username").html("El nombre de usuario solo acepta algunos caracteres especiales");
    }else{
      rusername=false;
      $("#error_username").html("Debe llenar el campo con un nombre de usuario");      
    }
  }else{
      rusername=true;
    $("#error_username").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if(rusername == true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}

function validarPass(){
  $(".btn-enviar").attr("disabled");
    /*===================================================================*/
  var atpassword = $("#pass").val();
  var ratpassword = checkInput(atpassword, alfanumericPattern3);
  if( ratpassword == false ){
    if(atpassword.length != 0){
      $("#error_pass").html("La contraseña solo acepta algunos caracteres especiales");
    }else{
    // alert('falso');
      $("#error_pass").html("Debe escribir una contraseña para la seguridad de la cuenta");      
    }
  }else{
    $("#error_pass").html("");
  }

  var password = $("#newPass").val();
  var rpassword = checkInput(password, alfanumericPattern3);
  if( rpassword == false ){
    if(password.length != 0){
      $("#error_newPass").html("La contraseña solo acepta algunos caracteres especiales");
    }else{
      $("#error_newPass").html("Debe escribir una nueva contraseña para la seguridad de la cuenta");      
    }
  }else{
    $("#error_newPass").html("");
  }
  /*==================================================================

  /*===================================================================*/
  var password2 = $("#newPass2").val();
  var rpassword2 = checkInput(password2, alfanumericPattern3);
  if( rpassword2 == false ){
    if(password2.length != 0){
      $("#error_newPass2").html("La contraseña solo acepta algunos caracteres especiales");
    }else{
      $("#error_newPass2").html("Debe confirmar la nueva contraseña para la seguridad de la cuenta");      
    }
  }else{
    $("#error_newPass2").html("");
  }

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if(rpassword==true && rpassword2==true && password==password2){
  // if(rusername == true){
    result = true;
  }else{
    result = false;
  }
  // alert(result);
  /*===================================================================*/
  return result;
}

function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre1 = $("#nombre1").val();
  var rnombre1 = checkInput(nombre1, textPattern2);
  if( rnombre1 == false ){
    if(nombre1.length != 0){
      rnombre1=false;
      $("#error_nombre1").html("El primer nombre no debe contener numeros o caracteres especiales");
    }else{
      rnombre1=false;
      $("#error_nombre1").html("Debe llenar el campo de primer nombre");      
    }
  }else{
      rnombre1=true;
    $("#error_nombre1").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var nombre2 = $("#nombre2").val();
  var rnombre2 = checkInput(nombre2, textPattern2);
  if( rnombre2 == false ){
    if(nombre2.length != 0){
      rnombre2=false;
      $("#error_nombre2").html("El segundo nombre no debe contener numeros o caracteres especiales");
    }else{
      rnombre2=false;
      $("#error_nombre2").html("Debe llenar el campo de segundo nombre");      
    }
  }else{
      rnombre2=true;
    $("#error_nombre2").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var apellido1 = $("#apellido1").val();
  var rapellido1 = checkInput(apellido1, textPattern2);
  if( rapellido1 == false ){
    if(apellido1.length != 0){
      $("#error_apellido1").html("El primer apellido no debe contener numeros o caracteres especiales");
      rapellido1=false;
    }else{
      rapellido1=false;
      $("#error_apellido1").html("Debe llenar el campo de primer apellido");      
    }
  }else{
      rapellido1=true;
    $("#error_apellido1").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var apellido2 = $("#apellido2").val();
  var rapellido2 = checkInput(apellido2, textPattern2);
  if( rapellido2 == false ){
    if(apellido2.length != 0){
      $("#error_apellido2").html("El segundo apellido no debe contener numeros o caracteres especiales");
      rapellido2=false;
    }else{
      $("#error_apellido2").html("Debe llenar el campo de segundo apellido");      
      rapellido2=false;
    }
  }else{
      rapellido2=true;
    $("#error_apellido2").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var cedula = $("#cedula").val();
  var rcedula = checkInput(cedula, numberPattern);
  if( rcedula == false ){
    if(cedula.length != 0){
        $("#error_cedula").html("La cedula debe tener minimo 7 caracteres y solo de tipo numerico");
        rcedula=false;
    }else{
      $("#error_cedula").html("Debe llenar el campo de la cedula");      
        rcedula=false;
    }
  }else{
      if(cedula.length >= 7){
        $("#error_cedula").html("");
        rcedula=true;
      }else{
        rcedula=false;
        $("#error_cedula").html("La cedula debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }
  /*===================================================================*/

  /*===================================================================*/
  var fechaNacimiento = $("#fechaNacimiento").val();
  var rfechaNacimiento = false;
  if(fechaNacimiento.length != 0){
    $("#error_fechaNacimiento").html("");
    rfechaNacimiento = true;
  }else{
    rfechaNacimiento=false;
    $("#error_fechaNacimiento").html("Debe llenar el campo de Fecha de Nacimiento");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var rif = $("#rif").val();
  var rrif = checkInput(rif, numberPattern);
  if( rrif == false ){
    if(rif.length != 0){
      rrif=false;
        $("#error_rif").html("El Rif debe tener minimo 7 caracteres y solo de tipo numerico");
    }else{
      rrif=false;
      $("#error_rif").html("Debe llenar el campo del Rif");      
    }
  }else{
      if(rif.length >= 7){
        rrif=true;
        $("#error_rif").html("");
      }else{
        rrif=false;
        $("#error_rif").html("El Rif debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }
  /*===================================================================*/

  /*===================================================================*/
  var telefono = $("#telefono").val();
  var rtelefono = checkInput(telefono, numberPattern);
  if( rtelefono == false ){
    if(telefono.length != 0){
        rtelefono=false;
        $("#error_telefono").html("El telefono debe tener minimo 7 caracteres y solo de tipo numerico");
    }else{
        rtelefono=false;
      $("#error_telefono").html("Debe llenar el campo del telefono");      
    }
  }else{
      if(telefono.length >= 7){
        $("#error_telefono").html("");
        rtelefono=true;
      }else{
        rtelefono=false;
        $("#error_telefono").html("El telefono debe tener minimo 7 caracteres y solo de tipo numerico");
      }
  }


  //emailPattern
  /*===================================================================*/
  var correo = $("#correo").val();
  var rcorreo = checkInput(correo, emailPattern);
  $(".correoOp").val("");
  if( rcorreo == false ){
    if(correo.length != 0){
      rcorreo=false;
      $("#error_correo").html("Ingrese una direccion de correo electronico valida");
    }else{
      rcorreo=false;
      $("#error_correo").html("Debe llenar el campo del correo electronico");      
    }
  }else{
    if($(".correoOp").val() == "error"){
      rcorreo = false;
    }else{
      rcorreo = true;
      $("#error_correo").html("");
    }
  }

  /*===================================================================*/

  /*===================================================================*/
  var direccion = $("#direccion").val();
  var rdireccion = checkInput(direccion, alfanumericPattern2);
  if( rdireccion == false ){
    if(direccion.length != 0){
      rdireccion=false;
      $("#error_direccion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
    }else{
      rdireccion=false;
      $("#error_direccion").html("Debe llenar la direccion de vivienda - misma direccion del documento RIF");      
    }
  }else{
      rdireccion=true;
    $("#error_direccion").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre1==true && rnombre2==true && rapellido1==true && rapellido2==true && rcedula==true && rfechaNacimiento==true && rrif == true && rtelefono == true && rcorreo == true && rdireccion == true){
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
