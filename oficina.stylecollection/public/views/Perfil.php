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
            <img src="<?=$fotoPortada?>" class="row imgPortada" style="z-index:0;height:100%;"><input type="hidden" class="imgPortadaRuta" value="<?=$fotoPortada?>">
                        <!-- position:absolute;left:10%;top:65%; -->
                        <!-- position:relative;top:-30%;left:10%; -->
            <div class="col-xs-12 boxboxfondobox" style="background:#FFF;">
              <div class="row">
                
              </div>
                <div class="RealImage image col-xs-12 col-sm-3 col-md-3" style="padding:0;margin:0;">
                  <img src="<?=$fotoPerfil?>" class="imgPerfil imageImage" style="z-index:1000;"><input type="hidden" class="imgPerfilRuta" value="<?=$fotoPerfil?>">
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
              <?php if(!empty($id_despacho)){ ?>
                  <li ><a href="#infos" data-toggle="tab">Informaciones</a></li>
                  <li class="active"><a href="#struct" data-toggle="tab">Estructura</a></li>
              <?php }else{?>
                  <li class="active"><a href="#infos" data-toggle="tab">Informaciones</a></li>
                  <li><a href="#struct" data-toggle="tab">Estructura</a></li>
              <?php } ?>
              <!-- <li><a href="#activity" data-toggle="tab">Actividad</a></li> -->

              <!-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li> -->
              <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
            </ul>
            <div class="tab-content">
              <?php if(!empty($id_despacho)){ ?>
                  <div class="tab-pane" id="infos">
              <?php }else{?>
                  <div class="active tab-pane" id="infos">
              <?php } ?>


                <!-- <form> -->
                <div class="form-horizontal">

                  <div class="form-group">
                    
                    <label for="inputName" class="col-sm-2 control-label">
                      <span style='color:#000'>Nombre</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" value="<?php echo $cuenta['primer_nombre']." ".$cuenta['segundo_nombre']." ".$cuenta['primer_apellido']." ".$cuenta['segundo_apellido'] ?>" placeholder="Name" readonly="">
                    </div>

                  </div>



                  <div class="form-group">
                    
                    <label for="inputCedula" class="col-sm-2 control-label">
                      <span style='color:#000'>Cedula</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputCedula" value="<?php echo number_format($cuenta['cedula'],0,'','.'); ?>" placeholder="Cedula" readonly="">
                    </div>

                  </div>
                  


                  <div class="form-group">

                    <label for="inputFechaNacimiento" class="col-sm-2 control-label">
                      <span style='color:#000'>Fecha de Nacimiento</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputFechaNacimiento" value="<?php echo $lider->formatFecha($cuenta['fecha_nacimiento']) ?>" placeholder="Fecha de Nacimiento" readonly="">
                    </div>

                  </div>



                  <div class="form-group">
                    
                    <label for="inputEmail" class="col-sm-2 control-label">
                      <span style='color:#000'>Email</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" value="<?php echo $cuenta['correo'] ?>" placeholder="Email" readonly="">
                    </div>

                  </div>
                  



                  <div class="form-group">
                    <label for="inputTlfn" class="col-sm-2 control-label">
                      <span style='color:#000'>Telefono</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputTlfn" value="<?php echo $cuenta['telefono']." / ".$cuenta['telefono2'] ?>" placeholder="Name" readonly="">
                    </div>

                  </div>




                  <div class="form-group">
                    <label for="inputDireccion" class="col-sm-2 control-label">
                      <span style='color:#000'>Direccion</span>
                    </label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputDireccion" placeholder="Direccion" readonly="" style="max-width:100%;min-width:100%;min-height:50px;max-height:50px;"><?php echo $cuenta['direccion'] ?></textarea>
                    </div>

                  </div>
                  <?php 
                    
                    if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar">
                            <u>Editar Perfil<span class="fa fa-wrench"></span></u>
                          </button>
                        </div>
                      </div>
                    
                    <?php }else{
                      if($editarPerfilDisponible==1){
                  ?>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"></label>
                          <div class="col-sm-10">
                            <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar">
                              <u>Editar Perfil<span class="fa fa-wrench"></span></u>
                            </button>
                          </div>
                        </div>
                    <?php } }?>



                  <!-- <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div> -->



                </div>
                  
                <!-- </form> -->

              </div>

              <?php if(!empty($id_despacho)){ ?>
                  <div class="active tab-pane" id="struct">
              <?php }else{?>
                  <div class="tab-pane" id="struct">
              <?php } ?>

                <?php 
                  $pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana ORDER BY campanas.id_campana DESC;"); 
                    // $redired = "route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id'];
                  ?>

                <form action="" method="POST" class="formPedidosSelected">
                  <label for="select"><b style="color:#000;">Seleccionar Pedido</b></label>
                  <select id="select" name="selectedPedido" class="form-control select2" style="width:100%;">
                      <option></option>
                <?php 
                  if(count($pedidos)>1){
                    foreach ($pedidos as $key) {
                      if(!empty($key['id_campana'])){                        
                        ?>
                        <option value="<?=$key['id_despacho']?>" <?php if(!empty($id_despacho)){if($key['id_despacho']==$id_despacho){echo "selected='1'";}} ?>>
                          <?php 
                            echo "Pedido "; 
                            if($key['numero_despacho']!="1"){
                              echo $key['numero_despacho'];
                            }
                            echo " de Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana'];
                          ?>
                        </option>
                        <?php 

                      }
                    }

                  }
                ?>
                  </select>
                </form>
                  <br>
                  <br>


  
                    
                  <div style="text-align:right;">
                        <button class="allexpand btn btn-success">
                          <span class="fa fa-caret-square-o-down">
                             &nbsp Todos
                          </span> 
                        </button>
                        
                        <button class="allcontrat d-none btn btn-success">
                          <span class="fa fa-caret-square-o-up">
                             &nbsp Todos
                          </span>
                        </button>
                  </div>

                  <div class="alert " style="background:#ccc">
                    <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cuenta['id_cliente']?> buttonBoxdown buttonBoxdown<?=$cuenta['id_cliente']?> " value="<?=$cuenta['id_cliente']?>"><span class="fa fa-caret-square-o-down"></span></button>&nbsp
                    <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cuenta['id_cliente']?> buttonBoxup buttonBoxup<?=$cuenta['id_cliente']?> d-none" value="<?=$cuenta['id_cliente']?>"><span class="fa fa-caret-square-o-up"></span></button> &nbsp
                     <?php $cuenta['op'] = 0; ?>
                     <?php
                     if($cuentaUsuario['fotoPerfil']==""){ 
                        $fotoPCliente = "public/assets/img/profile/";
                        if($cuenta['sexo']=="Femenino"){$fotoPCliente .= "Femenino.png";}
                        if($cuenta['sexo']=="Masculino"){$fotoPCliente .= "Masculino.png";} 

                      }else{
                        $fotoPCliente = $cuentaUsuario['fotoPerfil'];
                      }
                     ?>
                    <?php if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
                            foreach ($pedidosClientes as $key2) {
                              if(!empty($key2['id_cliente'])){
                                if($key2['id_cliente']==$cuenta['id_cliente']){
                                  $cuenta['op'] += 1; 
                                  if($key2['cantidad_aprobado']>0){
                                    $ruta = "campaing=".$key2['id_campana']."&n=".$key2['numero_campana']."&y=".$key2['anio_campana']."&dpid=".$key2['id_despacho']."&dp=".$key2['numero_despacho']."&route=Pedidos&id=".$key2['id_pedido'];
                                    ?> <a href="?<?=$ruta?>" style='color:#ED2A77'> 
                                        <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                    <?php
                                        echo " ".$cuenta['primer_nombre']." ".$cuenta['primer_apellido']; 
                                    ?> </a> 
                                    <?php echo " - Solicitadas: ".$key2['cantidad_pedido']." colecciones - Aprobadas: ".$key2['cantidad_aprobado']." colecciones";
                                  }else{?>
                                        <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                  <?php 
                                        echo " ".$cuenta['primer_nombre']." ".$cuenta['primer_apellido']; 
                                        echo " - Solicitadas: ".$key2['cantidad_pedido']." colecciones - Aprobadas: ".$key2['cantidad_aprobado']." colecciones";
                                  }
                                }
                              }
                            }
                            if($cuenta['op']==0){?>
                                        <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                            <?php 
                              echo " ".$cuenta['primer_nombre']." ".$cuenta['primer_apellido'];
                            }

                    }else{ ?>
                      <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                    <?php 
                      echo " ".$cuenta['primer_nombre']." ".$cuenta['primer_apellido'];
                    } ?>
                  </div>
                  <?php 
                    $query = "SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.id_lider = {$cuenta['id_cliente']} and clientes.estatus = 1 and usuarios.estatus = 1";
                    $clientesss = $lider->consultarQuery($query);
                    foreach ($clientesss as $datas) {
                      if(!empty($datas['id_cliente'])){
                        if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
                          Imprimir($cuenta['id_cliente'], $datas, $lider, "0", $pedidosClientes);
                        }else{
                          Imprimir($cuenta['id_cliente'], $datas, $lider, "0");                          
                        }
                      }
                    }

                  ?>
              </div>

<?php 

function Imprimir($nx, $cliente, $lider, $px, $pedidosClientes=[]){
  $px2 = $px + 8;
  // print_r($cliente);
  // echo "<br><br>";
   ?>
  <?php 
          $aprob = 0;
  foreach ($pedidosClientes as $keyx) {
    if(!empty($keyx['id_cliente'])){
      if($keyx['id_cliente']==$cliente['id_cliente']){ 
        if($keyx['cantidad_aprobado']>0){
          $aprob = 1;
        }
        ?> 
      <?php 
    }
  }}
  if($aprob==1){
   ?> 
  <div class="alert d-none boxingboxing boxbox<?=$nx?>" style="background:#ddd;margin-left:<?=$px2?>%;"> 
  <?php 
  } else{ 
   ?> 
  <div class="alert d-none boxingboxing boxbox<?=$nx?>" style="background:#ddd;margin-left:<?=$px2?>%;"> 
   <?php 
  }

  ?>
          <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cliente['id_cliente']?> buttonBoxdown buttonBoxdown<?=$cliente['id_cliente']?> " value="<?=$cliente['id_cliente']?>"><span class="fa fa-caret-square-o-down"></span></button>&nbsp
          <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cliente['id_cliente']?> buttonBoxup buttonBoxup<?=$cliente['id_cliente']?> d-none" value="<?=$cliente['id_cliente']?>"><span class="fa fa-caret-square-o-up"></span></button>&nbsp

<?php
    $cliente['op'] = 0;
                    if($cliente['fotoPerfil']==""){ 
                      $fotoPCliente = "public/assets/img/profile/";
                      if($cliente['sexo']=="Femenino"){$fotoPCliente .= "Femenino.png";}
                      if($cliente['sexo']=="Masculino"){$fotoPCliente .= "Masculino.png";} 

                    }else{
                      $fotoPCliente = $cliente['fotoPerfil'];
                    }
                    if (Count($pedidosClientes)>1){
                            foreach ($pedidosClientes as $key2) {
                              if(!empty($key2['id_cliente'])){
                                if($key2['id_cliente']==$cliente['id_cliente']){
                                    $cliente['op'] += 1; 
                                    if($key2['cantidad_aprobado']>0){
                                      $ruta = "campaing=".$key2['id_campana']."&n=".$key2['numero_campana']."&y=".$key2['anio_campana']."&dpid=".$key2['id_despacho']."&dp=".$key2['numero_despacho']."&route=Pedidos&id=".$key2['id_pedido'];
                                      ?>

                                      <!-- <span class="alert alert-success" style="background:;">  -->
                                        <a href="?<?=$ruta?>" style='color:#ED2A77'>
                                          <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                      <?php 
                                        echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                      ?> </a> 
                                      <?php echo " - Solicitadas: ".$key2['cantidad_pedido']." colecciones - Aprobadas: ".$key2['cantidad_aprobado']." colecciones";
                                      ?> <!-- </span> --> <?php 
                                    }else{ ?>
                                      <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                    <?php 
                                      echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                      echo " - Solicitadas: ".$key2['cantidad_pedido']." colecciones - Aprobadas: ".$key2['cantidad_aprobado']." colecciones";
                                    }
                                }
                              }
                            }
                            if($cliente['op']==0){ ?>
                              <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                            <?php 
                              echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido'];
                            }

                    }else{ ?>
                      <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                    <?php 
                      echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido'];
                    } 




  ?> </div> <?php
  $query = "SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.id_lider = {$cliente['id_cliente']} and clientes.estatus = 1 and usuarios.estatus = 1";
  $clientes = $lider->consultarQuery($query);
  foreach ($clientes as $datas) {
    if(!empty($datas['id_cliente'])){
      if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
        Imprimir($cliente['id_cliente'], $datas, $lider, $px2, $pedidosClientes);
      }else{
        Imprimir($cliente['id_cliente'], $datas, $lider, $px2);                          
      }
    }
  }
}

?>




              <!-- <div class=" tab-pane" id="activity">
                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="public/vendor/dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">Shared publicly - 7:30 PM today</span>
                  </div>
                  <p>
                    Lorem ipsum represents a long-held tradition for designers,
                    typographers and the like. Some people hate it and argue for
                    its demise, but others ignore the hate as they create awesome
                    tools to help create filler text for everyone from bacon lovers
                    to Charlie Sheen fans.
                  </p>
                  <ul class="list-inline">
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                    </li>
                    <li class="pull-right">
                      <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
                  </ul>

                  <input class="form-control input-sm" type="text" placeholder="Type a comment">
                </div>

                <div class="post clearfix">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="public/vendor/dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">Sent you a message - 3 days ago</span>
                  </div>
                  <p>
                    Lorem ipsum represents a long-held tradition for designers,
                    typographers and the like. Some people hate it and argue for
                    its demise, but others ignore the hate as they create awesome
                    tools to help create filler text for everyone from bacon lovers
                    to Charlie Sheen fans.
                  </p>

                  <form class="form-horizontal">
                    <div class="form-group margin-bottom-none">
                      <div class="col-sm-9">
                        <input class="form-control input-sm" placeholder="Response">
                      </div>
                      <div class="col-sm-3">
                        <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="public/vendor/dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">Posted 5 photos - 5 days ago</span>
                  </div>
                  <div class="row margin-bottom">
                    <div class="col-sm-6">
                      <img class="img-responsive" src="public/vendor/dist/img/photo1.png" alt="Photo">
                    </div>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-6">
                          <img class="img-responsive" src="public/vendor/dist/img/photo2.png" alt="Photo">
                          <br>
                          <img class="img-responsive" src="public/vendor/dist/img/photo3.jpg" alt="Photo">
                        </div>
                        <div class="col-sm-6">
                          <img class="img-responsive" src="public/vendor/dist/img/photo4.jpg" alt="Photo">
                          <br>
                          <img class="img-responsive" src="public/vendor/dist/img/photo1.png" alt="Photo">
                        </div>
                      </div>
                    </div>
                  </div>

                  <ul class="list-inline">
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Share</a></li>
                    <li><a href="#" class="link-black text-sm"><i class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                    </li>
                    <li class="pull-right">
                      <a href="#" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comments
                        (5)</a></li>
                  </ul>

                  <input class="form-control input-sm" type="text" placeholder="Type a comment">
                </div>
              </div> -->
              




              <!-- <div class="tab-pane" id="timeline">
                <ul class="timeline timeline-inverse">
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div> -->

              <!-- <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div> -->


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
<?php if($verFotosDisponible==1){ ?>
  <div style="background:#000000DD;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:9000100;" class="boxImgGrandeFoto d-none">
    <div class="row">
      <img src="<?=$fotoPerfil?>" class="imgMostrarGrandeFoto col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4" style="margin-top:10vh;margin-bottom:10vh;"> 
        <!-- background:#fff; -->
      <button style="position:fixed;top:1vh;right:2vh;" class="btn cerrarboxImgGrandeFoto">X</button>
    </div>

  </div>
  <div style="background:#000000DD;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:9000100;" class="boxImgGrandePortada d-none">
    <div class="row">
      <img src="<?=$fotoPortada?>" class="imgMostrarGrandePortada col-xs-12 col-md-8 col-md-offset-2" style="margin-top:10vh;margin-bottom:10vh;">
      <button style="position:fixed;top:1vh;right:2vh;" class="btn cerrarboxImgGrandePortada">X</button>
    </div>
  </div>
<?php } ?>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
  <?php require_once 'public/views/assets/footered.php'; ?>

<script>
$(document).ready(function(){

  $("#select").change(function(){
    $(".formPedidosSelected").submit();
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

  $(".buttonBoxup").click(function(){
    var val = parseInt($(this).val());
    $(this).hide();
    $(".buttonBoxdown"+val).show();
    $(".boxbox"+val).slideUp(500);


  });
  $(".buttonBoxdown").click(function(){
    var val = parseInt($(this).val());
    $(this).hide();
    $(".buttonBoxup"+val).show();
    $(".boxbox"+val).hide();
    $(".boxbox"+val).removeClass("d-none");
    $(".boxbox"+val).slideDown(500);
  });

  $(".allexpand").click(function(){
    $(".boxingboxing").slideDown(500);
    $(".allexpand").hide();
    $(".allcontrat").show();
    $(".buttonBoxdown").hide();
    $(".buttonBoxup").show();
  });
  $(".allcontrat").click(function(){
    $(".boxingboxing").slideUp(500);
    $(".allcontrat").hide();
    $(".allexpand").show();
    $(".buttonBoxup").hide();
    $(".buttonBoxdown").show();
  });


  $(".boxImgGrandeFoto").hide();
  $(".boxImgGrandeFoto").removeClass("d-none");
  
  $(".imgPerfil").click(function(){
    $(".boxImgGrandeFoto").show();
  });

  $(".boxImgGrandePortada").hide();
  $(".boxImgGrandePortada").removeClass("d-none");

  $(".imgPortada").click(function(){
    $(".boxImgGrandePortada").show();
  });
  $(".cerrarboxImgGrandeFoto").click(function(){
    $(".boxImgGrandeFoto").hide();
  });
  $(".cerrarboxImgGrandePortada").click(function(){
    $(".boxImgGrandePortada").hide();
  });
  


});
</script>
</body>
</html>
