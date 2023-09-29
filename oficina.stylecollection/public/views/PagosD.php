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
        <small><?php echo "Ver Pagos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Pagos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Pagos"; ?></li>
      </ol>
    </section>
            
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box"> 

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><?php echo "Ver Pagos"; ?></h3>
                <br>
                <br>

                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                  <div class="form-group col-xs-12">
                    <label for="lider">Seleccione la Campaña </label>
                    <!-- <input type="hidden" value="<?=$id_campana;?>" name="campaing"> -->
                    <!-- <input type="hidden" value="<?=$numero_campana;?>" name="n"> -->
                    <!-- <input type="hidden" value="<?=$anio_campana;?>" name="y"> -->
                    <!-- <input type="hidden" value="<?=$id_despacho;?>" name="dpid"> -->
                    <!-- <input type="hidden" value="<?=$num_despacho;?>" name="dp"> -->
                    <!-- <input type="hidden" value="Pagos" name="route"> -->
                    <!-- <input type="hidden" value="Registrar" name="action"> -->
                    <!-- <input type="hidden" value="1" name="admin"> -->
                    <!-- <input type="hidden" value="1" name="select"> -->
                    <select class="form-control select2 selectLider" id="lider" style="width:100%;">
                      <option></option>
                      

                      <?php foreach ($campanas as $data): if(!empty($data['id_campana'])): ?>
                        <option value="?campaing=<?=$data['id_campana']?>&n=<?=$data['numero_campana']?>&y=<?=$data['anio_campana']?>&dpid=<?=$data['id_despacho']?>&dp=<?=$data['numero_despacho']?>&route=Pagoss">
                            Pedido <?php if($data['numero_despacho']!="1"){ echo $data['numero_despacho']; } ?> de Campaña <?=$data['numero_campana']."/".$data['anio_campana']."-".$data['nombre_campana']?>
                            
                        </option>
                      <?php endif; endforeach; ?>
                    </select>
                  </div>
                  </form>
                </div>
                <?php //} ?>
            </div>
            <!-- /.box-header -->


            <br>
            <br>
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


<!--   <div class="box-modalEditar" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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
                           <select class="form-control tipo_pago select2" id="tipo_pago"  name="tipo_pago" style="width:100%;z-index:91000">
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


  <div class="box-modalAprobarConcialiador" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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

  <div class="box-modalDiferirConcialiador" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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
                           <select class="form-control observacion select2" id="observacion"  name="observacion" style="width:100%;z-index:91000">
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

    <div class="box-modalAprobarAnalista" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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

  <div class="box-modalDiferirAnalista" style="display:none;background:#00000099;position:fixed;top:0;left:0;z-index:1050;width:100%;height:100vh;padding-top:50px;">
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
                           <select class="form-control observacionAnalista select2" id="observacionAnalista"  name="observacion" style="width:100%;z-index:91000">
                             <option class="optRepetido">Repetido</option>
                             <option class="optComprobante">Se solicita comprobante</option>
                             <option class="optOtraEmpresa">No realizado a la empresa</option>
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
  </div> -->

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
<!-- <input type="hidden" class="responses" value="<?php echo $response ?>"> -->
<?php endif; ?>

<script>
$(document).ready(function(){ 

  $(".selectLider").change(function(){
    var select = $(this).val();
    if(select!=""){
      location.href=select;
      // $(".form_select_lider").submit();
    }
  });
  
  // $(".diferirPagoBtnConciliadores").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var data = JSON.parse(response);
  //       console.log(data);
  //       if(data[0]['fotoPerfil']!=""){
  //         $(".modal-img").attr("src",data[0]['fotoPerfil']);
  //       }else{
  //         var foto = "";
  //         if(data[0]['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data[0]['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);          
  //       }
  //       $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
  //       var year = data[0]['fecha_pago'].substr(0, 4);
  //       var mes = data[0]['fecha_pago'].substr(5, 2);
  //       var dia = data[0]['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".diferirFirmaModal").val(data[0]['firma']);
  //       if(data[0]['observacion']=="Repetido"){
  //         $(".optRepetido").attr("selected","selected");
  //       }
  //       if(data[0]['observacion']=="Se solicita comprobante"){
  //         $(".optComprobante").attr("selected","selected");
  //       }
  //       if(data[0]['observacion']=="No realizado a la empresa"){
  //         $(".optOtraEmpresa").attr("selected","selected");
  //       }




  //     }
  //   });
  //   $(".box-modalDiferirConcialiador").fadeIn(500);
  // });
  // $(".enviarModalDiferidoConciliadores").click(function(){
  //   var exec = false;
  //   $("#error_diferirFirmaModal").html("");
  //   $("#error_observacionModal").html("");
  //   // alert($(".diferirFirmaModal").val());
  //   // alert($(".observacion").val());
  //   if($(".diferirFirmaModal").val()=="" || $(".observacion").val()==""){
  //     if($(".diferirFirmaModal").val()==""){
  //       $("#error_diferirFirmaModal").html("Debe dejar su firma");
  //     }
  //     if($(".observacion").val()==""){
  //       $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
  //     }
  //   }else{
  //     exec=true;
  //   }
  //   // alert(exec);
  //   if(exec==true){ 
  //     $(".btn-enviar-modalDiferidoConciliadores").removeAttr("disabled","");
  //     $(".btn-enviar-modalDiferidoConciliadores").click();
  //   }
  // });
  // $(".cerrarModalDiferirConciliadores").click(function(){
  //   $(".box-modalDiferirConcialiador").fadeOut(500);
  // });

  // $(".diferirPagoBtnAnalista").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var data = JSON.parse(response);
  //       console.log(data);
  //       if(data[0]['fotoPerfil']!=""){
  //         $(".modal-img").attr("src",data[0]['fotoPerfil']);
  //       }else{
  //         var foto = "";
  //         if(data[0]['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data[0]['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);          
  //       }
  //       $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
  //       var year = data[0]['fecha_pago'].substr(0, 4);
  //       var mes = data[0]['fecha_pago'].substr(5, 2);
  //       var dia = data[0]['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".diferirFirmaAnalistaModal").val(data[0]['firma']);
  //       if(data[0]['observacion']=="Repetido"){
  //         $(".optRepetido").attr("selected","selected");
  //       }
  //       if(data[0]['observacion']=="Se solicita comprobante"){
  //         $(".optComprobante").attr("selected","selected");
  //       }
  //       if(data[0]['observacion']=="No realizado a la empresa"){
  //         $(".optOtraEmpresa").attr("selected","selected");
  //       }
        
  //     }
  //   });
  //   $(".box-modalDiferirAnalista").fadeIn(500);
  // });
  // $(".enviarModalDiferidoAnalista").click(function(){
  //   var exec = false;
  //   $("#error_diferirFirmaAnalistaModal").html("");
  //   $("#error_observacionModal").html("");
  //   // alert($(".diferirFirmaAnalistaModal").val());
  //   // alert($(".observacion").val());
  //   if($(".diferirFirmaAnalistaModal").val()=="" || $(".observacion").val()==""){
  //     if($(".diferirFirmaAnalistaModal").val()==""){
  //       $("#error_diferirFirmaAnalistaModal").html("Debe dejar su firma");
  //     }
  //     if($(".observacion").val()==""){
  //       $("#error_observacionModal").html("Debe seleccionar un motivo para Diferir el pago");
  //     }
  //   }else{
  //     exec=true;
  //   }
  //   // alert(exec);
  //   if(exec==true){ 
  //     $(".btn-enviar-modalDiferidoAnalista").removeAttr("disabled","");
  //     $(".btn-enviar-modalDiferidoAnalista").click();
  //   }
  // });
  // $(".cerrarModalDiferirAnalista").click(function(){
  //   $(".box-modalDiferirAnalista").fadeOut(500);
  // });

  
  // $(".aprobarPagoBtnConciliadores").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var data = JSON.parse(response);
  //       console.log(data);
  //       if(data[0]['fotoPerfil']!=""){
  //         $(".modal-img").attr("src",data[0]['fotoPerfil']);
  //       }else{
  //         var foto = "";
  //         if(data[0]['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data[0]['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);          
  //       }
  //       $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
  //       var year = data[0]['fecha_pago'].substr(0, 4);
  //       var mes = data[0]['fecha_pago'].substr(5, 2);
  //       var dia = data[0]['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".firmaModal").val(data[0]['firma']);
  //       $(".leyendaModal").val(data[0]['leyenda']);




  //     }
  //   });
  //   $(".box-modalAprobarConcialiador").fadeIn(500);
  // });
  // $(".enviarModalAprobadoConciliadores").click(function(){
  //   var exec = false;
  //   $("#error_firmaModal").html("");
  //   $("#error_leyendaModal").html("");

  //   if($(".firmaModal").val()=="" || $(".leyendaModal").val()==""){
  //     if($(".firmaModal").val()==""){
  //       $("#error_firmaModal").html("Debe dejar su firma");
  //     }
  //     if($(".leyendaModal").val()==""){
  //       $("#error_leyendaModal").html("Debe agregar la leyenda del pago");
  //     }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     $(".btn-enviar-modalAprobadoConciliadores").removeAttr("disabled","");
  //     $(".btn-enviar-modalAprobadoConciliadores").click();
  //   }
  // });
  // $(".cerrarModalAprobarConciliadores").click(function(){
  //   $(".box-modalAprobarConcialiador").fadeOut(500);
  // });

  // $(".aprobarPagoBtnAnalista").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       var data = JSON.parse(response);
  //       console.log(data);
  //       if(data[0]['fotoPerfil']!=""){
  //         $(".modal-img").attr("src",data[0]['fotoPerfil']);
  //       }else{
  //         var foto = "";
  //         if(data[0]['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data[0]['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);          
  //       }
  //       $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);
  //       var year = data[0]['fecha_pago'].substr(0, 4);
  //       var mes = data[0]['fecha_pago'].substr(5, 2);
  //       var dia = data[0]['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //       $(".id_pago_modal").val(id);

  //       $(".firmaAnalistaModal").val(data[0]['firma']);
  //       $(".leyendaAnalistaModal").val(data[0]['leyenda']);
  //     }
  //   });
  //   $(".box-modalAprobarAnalista").fadeIn(500);
  // });
  // $(".enviarModalAprobadoAnalista").click(function(){
  //   var exec = false;
  //   $("#error_firmaAnalistaModal").html("");
  //   $("#error_leyendaAnalistaModal").html("");

  //   if($(".firmaAnalistaModal").val()=="" || $(".leyendaAnalistaModal").val()==""){
  //     if($(".firmaAnalistaModal").val()==""){
  //       $("#error_firmaAnalistaModal").html("Debe dejar su firma");
  //     }
  //     if($(".leyendaAnalistaModal").val()==""){
  //       $("#error_leyendaAnalistaModal").html("Debe agregar la leyenda del pago");
  //     }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     $(".btn-enviar-modalAprobadoAnalista").removeAttr("disabled","");
  //     $(".btn-enviar-modalAprobadoAnalista").click();
  //   }
  // });
  // $(".cerrarModalAprobarAnalista").click(function(){
  //   $(".box-modalAprobarAnalista").fadeOut(500);
  // });

  // $(".cerrarModal").click(function(){
  //   $(".box-modalEditar").fadeOut(500);
  // });
  // $(".enviarModal").click(function(){
  //   var exec = false;
  //   $("#error_tipoPagoModal").html("");
  //   $("#error_tasaModal").html("");

  //   if($(".tipo_pago").val()=="" || $(".tasaModal").val()==""){
  //     if($(".tipo_pago").val()==""){
  //       $("#error_tipoPagoModal").html("Debe seleccionar un concepto de pago");
  //     }
  //     if($(".tasaModal").val()==""){
  //       $("#error_tasaModal").html("Debe agregar la tasa del dolar");
  //     }
  //   }else{
  //     exec=true;
  //   }

  //   if(exec==true){ 
  //     $(".btn-enviar-modal").removeAttr("disabled","");
  //     $(".btn-enviar-modal").click();
  //   }
  // });
  // $(".editarPagoBtn").click(function(){
  //   var id = $(this).val();
  //   $.ajax({
  //     url:'',
  //     type:"POST",
  //     data:{
  //       ajax:"ajax",
  //       id_pago:id,
  //     },
  //     success: function(response){
  //       // alert(response);
  //       var data = JSON.parse(response);
  //       console.log(data);
  //       if(data[0]['fotoPerfil']!=""){
  //         $(".modal-img").attr("src",data[0]['fotoPerfil']);
  //       }else{
  //         var foto = "";
  //         if(data[0]['sexo']=="Femenino"){
  //           foto = "public/assets/img/profile/Femenino.png";
  //         }
  //         if(data[0]['sexo']=="Masculino"){
  //           foto = "public/assets/img/profile/Masculino.png";
  //         }
  //         $(".modal-img").attr("src",foto);          
  //       }
  //       $(".nameUserPago").html(data[0]['primer_nombre']+" "+data[0]['primer_apellido']);

  //       var year = data[0]['fecha_pago'].substr(0, 4);
  //       var mes = data[0]['fecha_pago'].substr(5, 2);
  //       var dia = data[0]['fecha_pago'].substr(8, 2);

  //       $(".fecha_pago_modal").html(dia+"/"+mes+"/"+year);
  //         // alert(data[0]['tasa_pago']);
  //       $(".id_pago_modal").val(id);
  //       if(data[0]['tasa_pago']!=null){
  //         $(".tasaModal").attr("value",data[0]['tasa_pago']);
  //       }else{
  //         $(".tasaModal").attr("placeholder","0.00");
  //       }
  //       if(data[0]['tipo_pago']=="Inicial"){
  //         $(".optIncial").attr("selected","selected");
  //       }
  //       if(data[0]['tipo_pago']=="Primer Pago"){
  //         $(".optPrimer").attr("selected","selected");
  //       }
  //       if(data[0]['tipo_pago']=="Cierre"){
  //         $(".optCierre").attr("selected","selected");
  //       }
  //       $(".box-modalEditar").fadeIn(500);
  //     }
  //   });
  // });

  // $(".modificarBtn").click(function(){
  //   swal.fire({ 
  //         title: "¿Desea modificar los datos?",
  //         text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
  //         type: "question",
  //         showCancelButton: true,
  //         confirmButtonColor: "#ED2A77",
  //         confirmButtonText: "¡Si!",
  //         cancelButtonText: "No", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //     }).then((isConfirm) => {
  //         if (isConfirm.value){            
  //           window.location = $(this).val();
  //         }else { 
  //             swal.fire({
  //                 type: 'error',
  //                 title: '¡Proceso cancelado!',
  //                 confirmButtonColor: "#ED2A77",
  //             });
  //         } 
  //     });
  // });

  // $(".eliminarBtn").click(function(){
  //     swal.fire({ 
  //         title: "¿Desea borrar los datos?",
  //         text: "Se borraran los datos escogidos, ¿desea continuar?",
  //         type: "error",
  //         showCancelButton: true,
  //         confirmButtonColor: "#ED2A77",
  //         confirmButtonText: "¡Si!",
  //         cancelButtonText: "No", 
  //         closeOnConfirm: false,
  //         closeOnCancel: false 
  //     }).then((isConfirm) => {
  //         if (isConfirm.value){            
      
  //               swal.fire({ 
  //                   title: "¿Esta seguro de borrar los datos?",
  //                   text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
  //                   type: "error",
  //                   showCancelButton: true,
  //                   confirmButtonColor: "#ED2A77",
  //                   confirmButtonText: "¡Si!",
  //                   cancelButtonText: "No", 
  //                   closeOnConfirm: false,
  //                   closeOnCancel: false 
  //               }).then((isConfirm) => {
  //                   if (isConfirm.value){                      
  //                       window.location = $(this).val();
  //                   }else { 
  //                       swal.fire({
  //                           type: 'error',
  //                           title: '¡Proceso cancelado!',
  //                           confirmButtonColor: "#ED2A77",
  //                       });
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
  // });
});  
</script>
</body>
</html>
