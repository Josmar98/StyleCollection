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
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Home </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevos <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php if(empty($responseForm1)): ?>
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register form1" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                       <label for="bancos">Banco</label>
                       <select id="bancos" name="bancos" class="select2 form-control">
                          <option value=""></option>
                        <?php foreach ($bancos as $bank){ if(!empty($bank['id_banco'])){?> 
                          <option value="<?php echo $bank['id_banco'] ?>"><?php echo $bank['nombre_banco']." (<smal>".$bank['nombre_propietario']." "."</small>) <small>Cuenta ".$bank['tipo_cuenta']."</small>" ?></option>
                        <?php } } ?>
                       </select>
                       <span id="error_bancos" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-6">
                       <label for="archivo">Archivo Excel</label>
                       <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Seleccione el archivo con movimientos del banco" >
                       <span id="error_archivo" class="errors"></span>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <span type="submit" class="btn enviar enviar1">Cargar</span>
                <button class="btn-enviar1 d-none" disabled="" >enviar</button>
              </div>
            </form>
         <!--    form stop    -->
            <?php endif; ?>



          <?php if(!empty($responseForm1)): ?>
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register form1" enctype="multipart/form-data">
              <div class="box-body">
                <div class="row">
                    <!-- <div class="form-group col-sm-6">
                       <label for="bancos">Banco</label>
                       <select id="bancos" name="bancos" class="select2 form-control">
                          <option value=""></option>
                        <?php foreach ($bancos as $bank){ if(!empty($bank['id_banco'])){?> 
                          <option><?php echo $bank['nombre_banco'] ?></option>
                        <?php } } ?>
                       </select>
                       <span id="error_bancos" class="errors"></span>
                    </div>
                    <div class="form-group col-sm-6">
                       <label for="archivo">Archivo Excel</label>
                       <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Seleccione el archivo con movimientos del banco" >
                       <span id="error_archivo" class="errors"></span>
                    </div> -->
                    <div class="col-sm-6">
                        <label for="banco">Banco</label>
                        <input type="text" name="banco" id="banco" class="form-control" value="<?php echo $nombre_banco; ?>" readonly="">
                        <input type="hidden" name="id_banco" id="id_banco" class="form-control" value="<?php echo $id_banco; ?>" readonly="">
                    </div>

                    <table class="table table-bordered table-striped" style="width:99%;margin:auto;">  
                        <tr>
                          <td>
                            <select id="optcol1" name="optcol1" style="width:100%" class="form-control">
                              <!-- <option value=""></option> -->
                              <option value="1" id='fecha1' selected="">Fecha</option>
                              <!-- <option value="2" id='referencia1'>Referencia</option> -->
                              <!-- <option value="3" id='monto1'>Monto</option> -->
                            </select>
                            <span id="error_col1" class="errors"></span>
                          </td>
                          <td>
                            <select id="optcol2" name="optcol2" style="width:100%" class="form-control">
                              <option value=""></option>
                              <!-- <option value="1" id='fecha2' disabled="">Fecha</option> -->
                              <option value="2" id='referencia2'>Referencia</option>
                              <option value="3" id='monto2'>Monto</option>
                            </select>
                            <span id="error_col2" class="errors"></span>
                          </td>
                          <td>
                            <select id="optcol3" name="optcol3" style="width:100%" class="form-control">
                              <option value=""></option>
                              <!-- <option value="1" id='fecha3' disabled="">Fecha</option> -->
                              <option value="2" id='referencia3'>Referencia</option>
                              <option value="3" id='monto3'>Monto</option>
                            </select>
                            <span id="error_col3" class="errors"></span>
                          </td>
                        </tr>
                      <?php foreach ($dataExcel as $key): ?>
                        <tr>
                        <?php if(!empty($key["A"])): ?>
                          <td>
                            <?php 
                              // $excelDate = $key['A'];
                              // $unixDate = ($excelDate - 25569) * 86400;
                              // $excelDate = 25569 + ($unixDate / 86400);
                              // $unixDate = ($excelDate - 25569) * 86400;
                              // $dateActual = gmdate('d-m-Y', $unixDate);
                              if(gettype($key['A']) == "integer"){
                            ?>
                            <input type="text" value="<?php echo $lider->formatDateExcel($key['A']); ?>" style='background:none;border:none;' name="col1[]" readonly>
                            <?php
                            }
                              if(gettype($key['A']) == "string"){
                                $keyA = substr($key['A'], 0, 10);
                                $dia = substr($key['A'], 0, 2);
                                $mes = substr($key['A'], 3, 2);
                                $ann = substr($key['A'], 6, 4);
                                $keyA = $dia."-".$mes."-".$ann;
                            ?>
                            <input type="text" value="<?php echo $keyA; ?>" style='background:none;border:none;' name="col1[]" readonly>
                            <?php } ?>
                          </td>
                          <td>
                            <input type="text" value="<?php echo $key["B"]; ?>" style='background:none;border:none;' name="col2[]" readonly>
                          </td>
                          <td>
                            <input type="text" value="<?php echo $key["C"]; ?>" style='background:none;border:none;' name="col3[]" readonly>
                          </td>
                        <?php endif; ?>
                        </tr>
                      <?php endforeach; ?>
                    </table>
                </div>
              </div>
              <div class="box-footer">
                <span type="submit" class="btn enviar enviar2">Enviar</span>
                <button class="btn-enviar2 d-none" disabled="" >enviar</button>

                <a style="margin-left:5%" href="?route=<?php echo $url; if(!empty($_GET['action'])){echo "&action=".$_GET['action'];} ?>" class="btn btn-default">Cancelar</a>
              </div>
            </form>
         <!--    form stop    -->

            <?php endif; ?>

            <?php 

        
             echo "<table style='width:90%;margin:auto;'>";
        echo "</table>";

             ?>







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
<?php endif; ?>
<?php if(!empty($responseForm1)): ?>
<input type="hidden" class="responses1" value="<?php echo $responseForm1 ?>">
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
option[disabled]{
  /*color:red;*/
  background:#ccc;
}
option{
  padding:5%;
  font-size:1.2em;
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
        window.location = "?route=Movimientoss";
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


  var response1 = $(".responses1").val();
  if(response1==undefined){

  }else{
    if(response1 == "1"){
      // swal.fire({
      //     type: 'success',
      //     title: '¡Datos guardados correctamente!',
      //     confirmButtonColor: "#ED2A77",
      // }).then(function(){
      //   window.location = "?route=Movimientos";
      // });
    }
    if(response1 == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response1 == "7"){
      swal.fire({
          type: 'error',
          title: '¡Formato del archivo no soportado!',
          confirmButtonColor: "#ED2A77",
      });
    }
  }


  $("#optcol1").change(function(){

    $("#fecha1").removeAttr("disabled");
    $("#fecha2").removeAttr("disabled");
    $("#fecha3").removeAttr("disabled");
    $("#referencia1").removeAttr("disabled");
    $("#referencia2").removeAttr("disabled");
    $("#referencia3").removeAttr("disabled");
    $("#monto1").removeAttr("disabled");
    $("#monto2").removeAttr("disabled");
    $("#monto3").removeAttr("disabled");

    var val1 = $("#optcol1").val();    
    var val2 = $("#optcol2").val();    
    var val3 = $("#optcol3").val();   

    if(val1 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");  }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");  }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");  $("#monto2").attr("disabled","1"); }
      $("#fecha2").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val1 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }
      $("#referencia2").attr("disabled","1");  
      $("#referencia3").attr("disabled","1");  
    } else if(val1 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia2").attr("disabled","1");   }
      $("#monto2").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val2 == "1"){  
      if(val1 == "2"){$("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");   $("#monto3").attr("disabled","1");   }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");   $("#monto2").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val2 == "2"){
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");  $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }      
      $("#referencia1").attr("disabled","1");  
      $("#referencia3").attr("disabled","1"); 
    } else if(val2 == "3"){  
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){  $("#fecha3").removeAttr("disabled");  $("#fecha1").attr("disabled","1");  $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val3 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1"); 
      $("#fecha2").attr("disabled","1");  
    } else if(val3 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val1 == "1"){  $("#fecha1").removeAttr("disabled");  $("#fecha2").attr("disabled","1");  $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto1").attr("disabled","1"); }
      $("#referencia1").attr("disabled","1"); 
      $("#referencia2").attr("disabled","1");  
    } else if(val3 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");
      $("#monto2").attr("disabled","1");  
    }

  });

  $("#optcol2").change(function(){

    $("#fecha1").removeAttr("disabled");
    $("#fecha2").removeAttr("disabled");
    $("#fecha3").removeAttr("disabled");
    $("#referencia1").removeAttr("disabled");
    $("#referencia2").removeAttr("disabled");
    $("#referencia3").removeAttr("disabled");
    $("#monto1").removeAttr("disabled");
    $("#monto2").removeAttr("disabled");
    $("#monto3").removeAttr("disabled");

    var val1 = $("#optcol1").val();    
    var val2 = $("#optcol2").val();    
    var val3 = $("#optcol3").val();   

    if(val1 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");  }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");  }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");  $("#monto2").attr("disabled","1"); }
      $("#fecha2").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val1 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }
      $("#referencia2").attr("disabled","1");  
      $("#referencia3").attr("disabled","1");  
    } else if(val1 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia2").attr("disabled","1");   }
      $("#monto2").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val2 == "1"){  
      if(val1 == "2"){$("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");   $("#monto3").attr("disabled","1");   }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");   $("#monto2").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val2 == "2"){
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");  $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }      
      $("#referencia1").attr("disabled","1");  
      $("#referencia3").attr("disabled","1"); 
    } else if(val2 == "3"){  
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){  $("#fecha3").removeAttr("disabled");  $("#fecha1").attr("disabled","1");  $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val3 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1"); 
      $("#fecha2").attr("disabled","1");  
    } else if(val3 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val1 == "1"){  $("#fecha1").removeAttr("disabled");  $("#fecha2").attr("disabled","1");  $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto1").attr("disabled","1"); }
      $("#referencia1").attr("disabled","1"); 
      $("#referencia2").attr("disabled","1");  
    } else if(val3 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");
      $("#monto2").attr("disabled","1");  
    }

  });

  $("#optcol3").change(function(){

    $("#fecha1").removeAttr("disabled");
    $("#fecha2").removeAttr("disabled");
    $("#fecha3").removeAttr("disabled");
    $("#referencia1").removeAttr("disabled");
    $("#referencia2").removeAttr("disabled");
    $("#referencia3").removeAttr("disabled");
    $("#monto1").removeAttr("disabled");
    $("#monto2").removeAttr("disabled");
    $("#monto3").removeAttr("disabled");

    var val1 = $("#optcol1").val();    
    var val2 = $("#optcol2").val();    
    var val3 = $("#optcol3").val();   


    if(val1 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");  }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");  }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");  $("#monto2").attr("disabled","1"); }
      $("#fecha2").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val1 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }
      $("#referencia2").attr("disabled","1");  
      $("#referencia3").attr("disabled","1");  
    } else if(val1 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia2").attr("disabled","1");   }
      $("#monto2").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val2 == "1"){  
      if(val1 == "2"){$("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");  $("#referencia3").attr("disabled","1");  }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");   $("#monto3").attr("disabled","1");   }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1");   $("#monto2").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1");  
      $("#fecha3").attr("disabled","1"); 
    } else if(val2 == "2"){
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1");  $("#monto3").attr("disabled","1"); }
      if(val3 == "1"){ $("#fecha3").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha2").attr("disabled","1"); }
      if(val3 == "3"){ $("#monto3").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto2").attr("disabled","1"); }      
      $("#referencia1").attr("disabled","1");  
      $("#referencia3").attr("disabled","1"); 
    } else if(val2 == "3"){  
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1");   $("#referencia3").attr("disabled","1");   }
      if(val3 == "1"){  $("#fecha3").removeAttr("disabled");  $("#fecha1").attr("disabled","1");  $("#fecha2").attr("disabled","1"); }
      if(val3 == "2"){ $("#referencia3").removeAttr("disabled"); $("#referencia1").attr("disabled","1");   $("#referencia2").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");  
      $("#monto3").attr("disabled","1");
    }

    if(val3 == "1"){  
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto3").attr("disabled","1");   }
      $("#fecha1").attr("disabled","1"); 
      $("#fecha2").attr("disabled","1");  
    } else if(val3 == "2"){
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "3"){ $("#monto2").removeAttr("disabled"); $("#monto1").attr("disabled","1"); $("#monto3").attr("disabled","1"); }
      if(val1 == "1"){  $("#fecha1").removeAttr("disabled");  $("#fecha2").attr("disabled","1");  $("#fecha3").attr("disabled","1"); }
      if(val1 == "3"){ $("#monto1").removeAttr("disabled"); $("#monto2").attr("disabled","1"); $("#monto1").attr("disabled","1"); }
      $("#referencia1").attr("disabled","1"); 
      $("#referencia2").attr("disabled","1");  
    } else if(val3 == "3"){  
      if(val2 == "1"){ $("#fecha2").removeAttr("disabled"); $("#fecha1").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val2 == "2"){ $("#referencia2").removeAttr("disabled"); $("#referencia1").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      if(val1 == "1"){ $("#fecha1").removeAttr("disabled"); $("#fecha2").attr("disabled","1"); $("#fecha3").attr("disabled","1"); }
      if(val1 == "2"){ $("#referencia1").removeAttr("disabled"); $("#referencia2").attr("disabled","1"); $("#referencia3").attr("disabled","1");   }
      $("#monto1").attr("disabled","1");
      $("#monto2").attr("disabled","1");  
    }
  });



    
  $(".enviar1").click(function(){
    var response = validarForm1();

    if(response == true){
      $(".btn-enviar1").attr("disabled");

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
            $(".btn-enviar1").removeAttr("disabled");
            $(".btn-enviar1").click();   
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
    var response = validarForm2();

    if(response == true){
      $(".btn-enviar2").attr("disabled");

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

  });

  // $(".enviar1").click(function(){
  //   var response = validarForm1();

  //   if(response == true){
  //     $(".btn-enviar").attr("disabled");

  //     swal.fire({ 
  //         title: "¿Desea guardar los datos?",
  //         text: "Se guardaran los datos ingresados, ¿desea continuar?",
  //         type: "question",
  //         showCancelButton: true,
  //         confirmButtonColor: "#ED2A77",
  //         confirmButtonText: "¡Guardar!",
  //         cancelButtonText: "Cancelar", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //       }).then((isConfirm) => {
  //         if (isConfirm.value){
  //             $.ajax({
  //                   url: '',
  //                   type: 'POST',
  //                   data: {
  //                     validarData: true,
  //                     // nombre_producto: $("#nombre_producto").val(),
  //                   },
  //                   success: function(respuesta){
  //                     // alert(respuesta);
  //                     if (respuesta == "1"){
  //                         $(".btn-enviar").removeAttr("disabled");
  //                         $(".btn-enviar").click();
  //                     }
  //                     if (respuesta == "9"){
  //                       swal.fire({
  //                           type: 'error',
  //                           title: '¡Los datos ingresados estan repetidos!',
  //                           confirmButtonColor: "#ED2A77",
  //                       });
  //                     }
  //                     if (respuesta == "5"){ 
  //                       swal.fire({
  //                           type: 'error',
  //                           title: '¡Error de conexion con la base de datos, contacte con el soporte!',
  //                           confirmButtonColor: "#ED2A77",
  //                       });
  //                     }
  //                   }
  //               });
              
  //         }else { 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Proceso cancelado!',
  //                 confirmButtonColor: "#ED2A77",
  //             });
  //         } 
  //     });

  //   } //Fin condicion
  // }); // Fin Evento

  // $("body").hide(500);


});
function validarForm1(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var bancos = $("#bancos").val();
  var rbancos = false;
  if(bancos == ""){
    rbancos = false;
    $("#error_bancos").html("Debe seleccionar el banco al que se asocian los movimientos del banco");
  }else{
    rbancos = true;
    $("#error_bancos").html("");
  }

  var archivo = $("#archivo").val();
  var rarchivo = false;
  if(archivo == ""){
    rarchivo = false;
    $("#error_archivo").html("Debe seleccionar el archivo excel para cargar los movimientos del banco");
  }else{
    rarchivo = true;
    $("#error_archivo").html("");
  }

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rbancos==true && rarchivo==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}

function validarForm2(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var col1 = $("#optcol1").val();
  var rcol1 = false;
  if(col1 == ""){
    rcol1 = false;
    $("#error_col1").html("Debe identificar el tipo dato segun la columna");
  }else{
    rcol1 = true;
    $("#error_col1").html("");
  }

  var col2 = $("#optcol2").val();
  var rcol2 = false;
  if(col2 == ""){
    rcol2 = false;
    $("#error_col2").html("Debe identificar el tipo dato segun la columna");
  }else{
    rcol2 = true;
    $("#error_col2").html("");
  }

  var col3 = $("#optcol3").val();
  var rcol3 = false;
  if(col3 == ""){
    rcol3 = false;
    $("#error_col3").html("Debe identificar el tipo dato segun la columna");
  }else{
    rcol3 = true;
    $("#error_col3").html("");
  }



  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rcol1==true && rcol2 == true && rcol3==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}


// function validar(){
//   $(".btn-enviar").attr("disabled");
//   /*===================================================================*/
//   var nombre_producto = $("#nombre_producto").val();
//   var rnombre_producto = checkInput(nombre_producto, textPattern2);
//   if( rnombre_producto == false ){
//     if(nombre_producto.length != 0){
//       $("#error_nombre_producto").html("El nombre del producto no debe contener numeros o caracteres especiales");
//     }else{
//       $("#error_nombre_producto").html("Debe llenar el campo de nombre del producto ");      
//     }
//   }else{
//     $("#error_nombre_producto").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var cantidad = $("#cantidad").val();
//   var rcantidad = checkInput(cantidad, alfanumericPattern);
//   if( rcantidad == false ){
//     if(cantidad.length != 0){
//       $("#error_cantidad").html("La cantidad de producto no debe contener caracteres especiales");
//     }else{
//       $("#error_cantidad").html("Debe llenar una cantidad para el producto");      
//     }
//   }else{
//     $("#error_cantidad").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var precio = $("#precio").val();
//   var rprecio = checkInput(precio, numberPattern2);
//   if( rprecio == false ){
//     if(precio.length != 0){
//       $("#error_precio").html("El precio no debe contener caracteres especiales. solo permite {, .}");
//     }else{
//       $("#error_precio").html("Debe llenar el campo de precio para el producto");      
//     }
//   }else{
//     $("#error_precio").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var descripcion = $("#descripcion").val();
//   var rdescripcion = checkInput(descripcion, alfanumericPattern2);
//   if( rdescripcion == false ){
//     if(descripcion.length != 0){
//       $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
//     }else{
//       $("#error_descripcion").html("Debe llenar la descripcion del producto");      
//     }
//   }else{
//     $("#error_descripcion").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var fragancias = $("#fragancias").val();
//   var rfragancias = false;
//   if(fragancias == ""){
//     rfragancias = false;
//     $("#error_fragancias").html("Debe seleccionar las fragancias para el producto");
//   }else{
//     rfragancias = true;
//     $("#error_fragancias").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var result = false;
//   if( rnombre_producto==true && rcantidad==true && rprecio==true && rdescripcion==true && rfragancias==true){
//     result = true;
//   }else{
//     result = false;
//   }
//   /*===================================================================*/
//   // alert(result);
//   return result;
// }

</script>
</body>
</html>
