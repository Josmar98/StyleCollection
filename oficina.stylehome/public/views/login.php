<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="image/k-icon" href="public/assets/img/iconFondo.png" class="img-circle">

    <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="public/vendor/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="public/vendor/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/vendor/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="public/vendor/dist/css/skins/_all-skins.css"> -->
  <link rel="stylesheet" href="public/vendor/dist/css/skins/_all-skins_style.css">
  <!-- <link rel="stylesheet" href="public/vendor/dist/css/skins/skin-purple.css"> -->
  <!-- Morris chart -->
  <!-- <link rel="stylesheet" href="public/vendor/bower_components/morris.js/morris.css"> -->
  <!-- jvectormap -->
  <link rel="stylesheet" href="public/vendor/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <!-- <link rel="stylesheet" href="public/vendor/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"> -->
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="public/vendor/bower_components/bootstrap-daterangepicker/daterangepicker.css"> -->
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="public/vendor/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="public/vendor/plugins/sweetalert/sweetalert.css">
  <link rel="stylesheet" href="public/vendor/plugins/select2/css/select2.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" type="text/css" href="public/vendor/plugins/DataTables/DataTables/css/dataTables.bootstrap.css">

<body class="bg-inicio">
<div class="" style="">
 

  <!-- Left side column. contains the logo and sidebar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content">

    <!-- Main content -->
    <section class="content" style="width:100%;">
      <div class="row" style="width:100%;margin:auto;margin-top:4%;">
      
        <div class="col-md-4"></div>
        <div class="col-xs-12 col-md-4">
          <!-- /.box -->
          <div class="box">
            <div class="box-body">
              <img src="public/assets/img/logo5.png" style="width:100%;">
              <h4 class="box-title" style="font-size:1.25em;margin-bottom:-5px;text-align:center;"><b><i>Inicio de sesión</i></b></h4>
              <form action="" method="post" role="form" class="form_register">
                <div class="box-body">
                      
                    <div class="row">
                      <div class="form-group col-sm-12">
                         <label for="username">Nombre de usuario</label>
                         <div class="input-group form-control" style="padding:0">

                           <span class="input-group-addon fa fa-user buttonvisibility" style="float:left;"></span>
                           
                           <input style="border:none; width:80%;padding-left:3px;" type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario">

                         </div>
                         <span id="error_username" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-sm-12">
                         <label for="pass">Contraseña</label>
                         <div class="input-group form-control" style="padding:0;width:100%">
                           <span class="input-group-addon fa fa-unlock-alt buttonvisibility" style="float:left;"></span>
                           
                           <input style="border:none;width:80%;padding-left:3px;" type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">

                           <span id="texto-oculto" class="buttonvisibility input-group-addon fa fa-eye" style="float:right;"></span>
                           <span id="texto-visible" class="buttonvisibility d-none input-group-addon fa fa-eye-slash" style="float:right;"></span>
                         </div>
                         <span id="error_pass" class="errors"></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-sm-12">
                        <label for="recuerdame">Recuerdame</label>
                        <input type="checkbox" style="margin-left:2%" name="recuerdame" id="recuerdame">
                        <input type="hidden" id="recuerdamebox" name="recuerdamebox">
                      </div>
                    </div>
                        
                    
                    
                    <span id="error_acceso" class="errors"></span>
                  
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  
                  <span type="submit" class="btn btn-default enviar color-button-sweetalert form-control" >Enviar</span>

                  <button class="btn-enviar d-none" disabled="" style="background:none;border:none;"></button>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4"></div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  

</div>

<!-- ./wrapper -->


  <?php require_once 'public/views/assets/footered.php'; ?>

<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<style>
.buttonvisibility{color:#444444AA;width:10%;padding:10px;text-align:center;border:none;}
.buttonvisibility:hover{color:#444444DD;}
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
  $("#texto-oculto").click(function(){
    $("#texto-visible").removeClass("d-none");
    $("#texto-oculto").addClass("d-none");
    $("#pass").attr("type","text");
  });
  $("#texto-visible").click(function(){
    $("#texto-oculto").removeClass("d-none");
    $("#texto-visible").addClass("d-none");
    $("#pass").attr("type","password");
  });
  
  $("#recuerdamebox").val("0");
  $("#recuerdame").click(function(){
    if($(this).prop('checked')){
      $("#recuerdamebox").val("1");
    }else{
      $("#recuerdamebox").val("0");
    }
  });

  $(".enviar").click(function(){
    var response = validarLogin();

    if(response == true){
      // $(".btn-enviar").attr("disabled");
        $.ajax({
          url: '?route=login',
          type: 'POST',
          data: {
            validarData: true,
            username: $("#username").val().trim(),
            pass: $("#pass").val().trim(),
            recuerdame: $("#recuerdamebox").val(),
          },
          success: function(respuesta){
            // alert(respuesta);
            if (respuesta == "1"){
                window.location.href="./";
            }
            if (respuesta == "9"){
              $("#error_acceso").html("<b>Nombre de usuario o Contraseña invalidos<b>");
            }
            if(respuesta == "2"){
              $("#error_acceso").html("<b>Accesos Restringido Temporalmente. Por favor intente mas tarde<b>");
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
    }
  });

  // $(".form-control").keypress(function(e){
  //   var code = (e.keyCode ? e.keyCode : e.which);
  //   if(code==13){
  //     $(".enviar").click();
  //   }
  // });

  $("#username").keypress(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
      $(".enviar").click();
    }
  });

  $("#pass").keypress(function(e){
    var code = (e.keyCode ? e.keyCode : e.which);
    if(code==13){
      $(".enviar").click();
    }
  });
  // $("#username").keypress(function(e){
  //   if(e.which==13){
  //     alert("asd");
  //     $(".enviar").click();
  //   }
  // });




});
function validarLogin(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var username = $("#username").val();
  var rusername = false;
  if(username!=""){
    rusername = true;
    $("#error_username").html("");
  }else{
    rusername = false;
    $("#error_username").html("<b>Ingresar el nombre de usuario</b>");
  }

  var pass = $("#pass").val();
  var rpass = false;
  if(pass!=""){
    rpass = true;
    $("#error_pass").html("");
  }else{
    rpass = false;
    $("#error_pass").html("<b>Ingrese la contraseña</b>");
  }
  /*===================================================================*/


  var result = false;
  if( rusername==true && rpass==true){
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
