<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" style="height:10px;">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo "Calendario"; ?>
        <small><?php echo "Ver Calendario"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Calendario"; ?></a></li>
        <li class="active"><?php echo "Calendario"; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
                
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Calendario ".$year; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"|| $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                <div style="text-align:right;display:block;">                
                  <button class="btn enviar modificarBtn" value="?route=Calendario&action=Registrar">Agregar Festividad</button>
                </div>
                <?php } ?>
                <table class="table table-responsive">
                  <thead>
                  <tr>
                    <?php foreach ($semana as $data): ?>
                        <!-- <th><?=$data?></th> -->
                    <?php endforeach; ?>
                  </tr>
                  </thead>
                  <tbody>
                      <tr style="text-align:center;padding:0">
                        <td colspan="7">
                          <label for="meses" style="text-align:left;display:block;padding-left:1%;">Mes</label>
                          <select class="mesSeleccionado meses form-control" style="margin:0;border-radius:10px;padding-left:30px;padding-right:30px;font-size:1.3em">
                            <option <?php if($mesActual=="Enero"){echo "selected";} ?>>Enero</option>
                            <option <?php if($mesActual=="Febrero"){echo "selected";} ?>>Febrero</option>
                            <option <?php if($mesActual=="Marzo"){echo "selected";} ?>>Marzo</option>
                            <option <?php if($mesActual=="Abril"){echo "selected";} ?>>Abril</option>
                            <option <?php if($mesActual=="Mayo"){echo "selected";} ?>>Mayo</option>
                            <option <?php if($mesActual=="Junio"){echo "selected";} ?>>Junio</option>
                            <option <?php if($mesActual=="Julio"){echo "selected";} ?>>Julio</option>
                            <option <?php if($mesActual=="Agosto"){echo "selected";} ?>>Agosto</option>
                            <option <?php if($mesActual=="Septiembre"){echo "selected";} ?>>Septiembre</option>
                            <option <?php if($mesActual=="Octubre"){echo "selected";} ?>>Octubre</option>
                            <option <?php if($mesActual=="Noviembre"){echo "selected";} ?>>Noviembre</option>
                            <option <?php if($mesActual=="Diciembre"){echo "selected";} ?>>Diciembre</option>
                          </select>
                        </td>
                      </tr>

                      <?php foreach ($calendarios as $calendar): ?>
                        <?php $messs = $calendar['mess']; ?>
                        <tr style='display:none;padding:0' class="boxtr box<?=$messs?>">
                        <?php foreach ($semana as $data): ?>
                          <?php $wid = 100/7; ?>
                          <td style="padding:0.5%;width:<?=$wid?>% !important">
                              <?php foreach ($calendar['calendar'] as $data2): 
                                if (!empty($data2['fecha_calendario'])): 
                                  if ($data2['diaSemana']==$data): 
                                            $nnf = 0;
                                            $nFest = []; 
                                            foreach ($festividades as $fest): if(!empty($fest['id_festividad'])):
                                              // $nFest[$nnf] = 0;
                                              $nFest[$nnf]['num'] = 0;
                                                $nFest[$nnf]['fest'] = "";
                                              if ($fest['fecha_festividad']==$data2['fecha_calendario']):
                                                // $nFest[$nnf] = 1;
                                                $nFest[$nnf]['num'] = 1;
                                                $nFest[$nnf]['fest'] = $fest['nombre_festividad'];
                                              endif;
                                              $nnf++;
                                            endif; endforeach;
                                            $nm = 0;
                                            $nameF = "";
                                            foreach ($nFest as $kk) {
                                              $nm += $kk['num'];
                                              if($kk['num']==1){
                                                $nameF = $kk['fest'];
                                              }
                                            }
                                            if($nm>0){
                                            //   // echo "<b style='position:absolute;margin-top:-1.5%;margin-left:-1.5%;'>Festivo</b>";
                                              // echo "<b>Fes-".$nameF."</b>";
                                            }else{
                                              // echo $mostrarFechaCalendario;
                                            }

                                      // $mostrar = $data2['fecha_calendario'];
                                      $resul = $lider->formatFecha($data2['fecha_calendario']);

                                      if($resul=="00-00-0000"){
                                        $style1="box-sizing:border-box;margin:10px 0%;box-shadow:0px 0px 1px #00000000;border:1px solid #CCCCCC00;border-radius:10%;text-align:center;";
                                        $style2="background:#DDDDDD00;border-radius:5px 5px 0% 0%;";
                                        $mostrarTitulo = "<span style='color:#00000000'>".$data."<span>";
                                        $mostrarDia = "<span style='color:#00000000'>".$data2['dia_calendario']."<span>";
                                        $mostrarFechaCalendario = "<span style='color:#00000000'>".$resul."<span>";
                                      }else{
                                        if($nm>0){
                                          $style1="background:#2E6FEF;color:#FFF;box-sizing:border-box;margin:10px 0%;box-shadow:0px 0px 1px #000;border:1px solid #CCC;border-radius:10%;text-align:center;";
                                        }else{
                                          $style1="box-sizing:border-box;margin:10px 0%;box-shadow:0px 0px 1px #000;border:1px solid #CCC;border-radius:10%;text-align:center;";
                                            if($data=='Domingo' || $data=='Sabado'){
                                              $style1="background:#BBBBBBCC;box-sizing:border-box;margin:10px 0%;box-shadow:0px 0px 1px #000;border:1px solid #CCC;border-radius:10%;text-align:center;";
                                            }
                                        }
                                        // $style1="margin:15% 0%;box-shadow:0px 0px 1px #000;border:1px solid #CCC;border-radius:10%;text-align:center;";
                                        $style2="background:#ED2A77;color:#FFF !important;border-radius:5px 5px 0% 0%;";
                                        $mostrarTitulo = $data;
                                        $mostrarDia = $data2['dia_calendario'];
                                        $mostrarFechaCalendario = $resul;
                                      }
                                      ?>
                                      <div class="boxcalendar b<?=$mostrarFechaCalendario?>" style="<?=$style1?>">
                                        <input type="hidden" class="input<?=$mostrarFechaCalendario?>" value="<?=$mostrarFechaCalendario?>">
                                        <div style="<?=$style2?>">
                                            <b style="font-size:.9em;">
                                              <?=$mostrarTitulo?>
                                            </b>
                                        </div>
                                        <h3 style="padding:0;margin:15%;font-size:2em">
                                          <b>
                                            <?=$mostrarDia?>
                                          </b>
                                        </h3>
                                        <div>
                                          <!-- <?=$mostrarFechaCalendario;?> -->
                                          
                                        </div>
                                      </div>
                                  <?php endif; 
                                endif;
                              endforeach; ?>
                          </td>
                        <?php endforeach; ?>
                      </tr>
                      <?php endforeach; ?>

                  </tbody>
                </table>
                <!-- <input type="color" name=""> -->


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

  <div class="box-modalCalendario" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModal" style="background:#CCC"><b>X</b></span></div>
                      <br>
                      <h3 style="font-size:1.5em;" class="box-title"><b>Fecha: </b> <span class="fecha_modal_modal"></span></h3>
                  </div>

                  <div class="box-body">
                    <div class="row box-tasas">
                      <div class="col-xs-12">
                        <h3>
                          <div style="margin-top:10px;margin-bottom:10px;">
                            EL precio de la tasa del <b>Dolar</b> es
                          <span style="margin-top:10px;margin-bottom:10px;color:#0B0;"><b>Bs. <span class="tasaDolar"></span></b></span>
                            el <span class="diaTasa"></span> de <span class="mesTasa"></span> del <span class="yearTasa"></span>
                          </div>
                            
                        </h3>               
                      </div>
                    </div>

                    <div class="row box-festividad">
                      <div class="col-xs-12">
                        <h3>
                          <!-- <div style="margin-top:10px;margin-bottom:10px;">
                            El <?=$festividad['dia_calendario']?> de <?=$mes?> del <?=$festividad['year_calendario']?>
                          </div> -->
                          <div style="margin-top:10px;margin-bottom:10px;">
                            Cae Dia <span class="diaSemana"></span> <span class="tipoFestividad"></span>
                              "<i><b><span class="nombreFestividad"></span></b></i>"
                          </div>
                            
                        </h3>               
                      </div>
                    </div>
                  </div>
                  
                  <br>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>


  <?php require_once 'public/views/assets/footered.php'; ?>
<input type="hidden" class="fechaActual" value="<?=date('d-m-Y')?>">
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<style>
.grad{
  /*background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, red), color-stop(1, blue));*/
  /*background:-moz-linear-gradient( center top, #05CDFF 5%, #007BE6 100% );*/
  /*filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#05CDFF', endColorstr='#007BE6');*/
  /*background-color:#05CDFF; */
  /*color:#FFFFFF; */
  /*font-size: 14px;*/
  /*font-weight: bold;*/
  /*border-left: 0px solid #0076A8;*/
  /*background:red !important;*/
}
</style>
<script>
$(document).ready(function(){ 
  var fechaActual = $(".fechaActual").val();
  // var fechaActual = "14-02-2022";
  var styleB = $(".b"+fechaActual).attr("style");

  if(styleB[0]=="b"&&styleB[1]=="a"&&styleB[2]=="c"&&styleB[3]=="k"&&styleB[4]=="g"&&styleB[5]=="r"&&styleB[6]=="o"&&styleB[7]=="u"&&styleB[8]=="n"&&styleB[9]=="d"&&styleB[10]==":"&&styleB[11]=="#"&&styleB[12]=="2"&&styleB[13]=="E"&&styleB[14]=="6"&&styleB[15]=="F"&&styleB[16]=="E"&&styleB[17]=="F"){
  // if(styleB[0]=="b"&&styleB[1]=="a"&&styleB[2]=="c"&&styleB[3]=="k"&&styleB[4]=="g"&&styleB[5]=="r"&&styleB[6]=="o"&&styleB[7]=="u"&&styleB[8]=="n"&&styleB[9]=="d"&&styleB[10]==":"&&styleB[11]=="#"&&styleB[12]=="2"&&styleB[13]=="8"&&styleB[14]=="C"&&styleB[15]=="3"&&styleB[16]=="D"&&styleB[17]=="7"){
    
    $(".b"+fechaActual).attr("style",styleB+ "background:-webkit-gradient( linear, left bottom, right top, color-stop(0.4, #ED2A77), color-stop(0.6, #2E6FEF));color:#FFF;box-shadow:0.25em 0.25em 0.5em #0A0;border-radius:10px;");
    // 28C3D7
    // 2E6FEF

  }else if(styleB[0]=="b"&&styleB[1]=="a"&&styleB[2]=="c"&&styleB[3]=="k"&&styleB[4]=="g"&&styleB[5]=="r"&&styleB[6]=="o"&&styleB[7]=="u"&&styleB[8]=="n"&&styleB[9]=="d"&&styleB[10]==":"&&styleB[11]=="#"&&styleB[12]=="B"&&styleB[13]=="B"&&styleB[14]=="B"&&styleB[15]=="B"&&styleB[16]=="B"&&styleB[17]=="B"){
      $(".b"+fechaActual).attr("style",styleB+ "background:-webkit-gradient( linear, left bottom, right top, color-stop(0.4, #ED2A77), color-stop(0.6, #BBBBBBCC));color:#000;box-shadow:0.25em 0.25em 0.5em #0A0;border-radius:10px;");
  }else{
    
    $(".b"+fechaActual).attr("style",styleB+"background:#ED2A77;color:#000;box-shadow:0.25em 0.25em 0.5em #0A0;border-radius:10px;");
  
  }

  $(".boxcalendar").click(function(){
    var v = $(this).attr("class");
    var x='';
    for (var i = 13; i < 23; i++) {
      x+=v[i];
    }
    var input = $(".input"+x).val();
    $.ajax({
      url: "",
      type: "POST",
      data: {
        fechaFestiva: "asd",
        input: input,
      },
      success: function(response){
        // alert(response);
        var data = JSON.parse(response);
        // alert(data['estatus']);
        if(data['estatus']=="1"){
          // location.href="?route=Calendario&action=Detalles&id="+input;
          var dia = "";
          var mes = "";
          var year = "";
          if(data['execFestividad']=="1"){
            dia = data['festividad']['evento']['dia_calendario'];
            mes = data['festividad']['mes'];
            year = data['festividad']['evento']['year_calendario'];

            $(".diaSemana").html(data['festividad']['evento']['diaSemana']);
            $(".tipoFestividad").html(data['festividad']['evento']['tipo_festividad']);
            $(".nombreFestividad").html(data['festividad']['evento']['nombre_festividad']);
          }else{
              $(".box-festividad").hide();
          }
          if(data['execTasa']=="1"){
            dia = data['tasa']['dia'];
            mes = data['tasa']['mes'];
            year = data['tasa']['year'];
            $(".tasaDolar").html(data['tasa']['evento']['monto_tasa']);
            $(".diaTasa").html(dia);
            $(".mesTasa").html(mes);
            $(".yearTasa").html(year);
            $(".box-tasas").show();
          }else{
              $(".box-tasas").hide();
          }
          $(".fecha_modal_modal").html(dia+" de "+mes+" del "+year);
          $(".box-modalCalendario").fadeIn(300);
        }
        if(data['estatus']=="2"){

        }
      }
    });

  });
  $(".cerrarModal").click(function(){
    $(".box-modalCalendario").fadeOut(500);
  });

  var mesS = $(".mesSeleccionado").val();
  $(".boxtr").hide();
  $(".box"+mesS).show();

  $(".mesSeleccionado").change(function(){
    var mesS = $(".mesSeleccionado").val();
    $(".boxtr").hide();
    $(".box"+mesS).show();
  });


  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Calendario";
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
          title: "¿Desea agregar un evento?",
          text: "Se podran agregar, dias festivos o dias bancarios",
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
