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
            <img src="<?=$fotoPortadaCliente?>" class="row imgPortada" style="z-index:0;height:100%;"><input type="hidden" class="imgPortadaRuta" value="<?=$fotoPortadaCliente?>">
                        <!-- position:absolute;left:10%;top:65%; -->
                        <!-- position:relative;top:-30%;left:10%; -->
            <div class="col-xs-12 boxboxfondobox" style="background:#FFF;">
              <div class="row">
                
              </div>
                <div class="RealImage image col-xs-12 col-sm-3 col-md-3" style="padding:0;margin:0;">
                  <img src="<?=$fotoPerfilCliente?>" class="imgPerfil imageImage" style="z-index:1000;"><input type="hidden" class="imgPerfilRuta" value="<?=$fotoPerfilCliente?>">

                  <!-- <img src="public/assets/img/profile/perfil.jpg" style="background:#fff;height:100%;width:100%" class='profile-user-img img-responsive img-circle' alt="User Image"> -->
                </div>              
                <h4 style="" class="col-xs-12 col-md-9 textPerfil">
                  <b style="color:<?=$fucsia?>">
                    
                  <?php echo $cliente['primer_nombre']; ?>
                  <?php echo $cliente['primer_apellido']; ?>   
                  </b>
                </h4>
                <h4 style="margin-top:-1%;" class="col-xs-12 col-md-9 textPerfil">
                  <small style="font-size:.6em;"> 
                    <?=$rrollCliente?> de Style Home
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
        Detalles del Cliente
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="?route=Perfil">Perfil</a></li>
        <li class="active">Mi Perfil</li>
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
              <?php if(!empty($id_ciclo)){ ?>
                  <li ><a href="#infos" data-toggle="tab">Informaciones</a></li>
                  <li class="active"><a href="#struct" data-toggle="tab">Estructura</a></li>
              <?php }else{?>
                  <li class="active"><a href="#infos" data-toggle="tab">Informaciones</a></li>
                  <li><a href="#struct" data-toggle="tab">Estructura</a></li>
              <?php } ?>
                <!-- <li><a href="#activity" data-toggle="tab">Actividad</a></li> -->

              <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
            </ul>
            <div class="tab-content">
              <?php if(!empty($id_ciclo)){ ?>
                  <div class="tab-pane" id="infos">
              <?php }else{?>
                  <div class="active tab-pane" id="infos">
              <?php } ?>


                <!-- <form> -->
                <div class="form-horizontal">

                  <div class="form-group">
                    
                    <label for="inputName" class="col-sm-2 control-label">
                      <span style='color:#000'>Name</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" value="<?php echo $cliente['primer_nombre']." ".$cliente['segundo_nombre']." ".$cliente['primer_apellido']." ".$cliente['segundo_apellido'] ?>" placeholder="Name" readonly="">
                    </div>

                  </div>



                  <div class="form-group">
                    
                    <label for="inputCedula" class="col-sm-2 control-label">
                      <span style='color:#000'>Cedula</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputCedula" value="<?php echo number_format($cliente['cedula'],0,'','.'); ?>" placeholder="Cedula" readonly="">
                    </div>

                  </div>
                  


                  <div class="form-group">

                    <label for="inputFechaNacimiento" class="col-sm-2 control-label">
                      <span style='color:#000'>Fecha de Nacimiento</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputFechaNacimiento" value="<?php echo $lider->formatFecha($cliente['fecha_nacimiento']) ?>" placeholder="Fecha de Nacimiento" readonly="">
                    </div>

                  </div>



                  <div class="form-group">
                    
                    <label for="inputEmail" class="col-sm-2 control-label">
                      <span style='color:#000'>Email</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" value="<?php echo $cliente['correo'] ?>" placeholder="Email" readonly="">
                    </div>

                  </div>
                  



                  <div class="form-group">
                    <label for="inputTlfn" class="col-sm-2 control-label">
                      <span style='color:#000'>Telefono</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputTlfn" value="<?php echo $cliente['telefono']." / ".$cliente['telefono2'] ?>" placeholder="Telefono" readonly="">
                    </div>

                  </div>




                  <div class="form-group">
                    <label for="inputDireccion" class="col-sm-2 control-label">
                      <span style='color:#000'>Direccion</span>
                    </label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="inputDireccion" placeholder="Direccion" readonly="" style="max-width:100%;min-width:100%;min-height:50px;max-height:50px;"><?php echo $cliente['direccion'] ?></textarea>
                    </div>

                  </div>

                  <div class="form-group">
                    <label for="inputLider" class="col-sm-2 control-label">
                      <span style='color:#000'>Lider</span>
                    </label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputLider" value="<?php echo $liderCliente['primer_nombre']." ".$liderCliente['primer_apellido'] ?>" placeholder="Lider" readonly="">
                    </div>

                  </div>




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
                  <?php if ($accesoPerfilM==1): ?>
                    <div class="form-group">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-10">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar">
                            <span class="fa fa-wrench"><u> Editar Líder</u></span>
                          </button>
                      </div>
                    </div>
                  <?php endif ?>


                </div>
                  
                <!-- </form> -->

              </div>
              <?php if(!empty($id_ciclo)){ ?>
                  <div class="active tab-pane" id="struct">
              <?php }else{?>
                  <div class="tab-pane" id="struct">
              <?php } ?>
                <?php 
                  $ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus=1 ORDER BY ciclos.id_ciclo DESC;"); 
                  $redired = "route=".$_GET['route'];
                ?>

                <form action="?<?=$redired?>" method="POST" class="formPedidosSelected">
                  <label for="select"><b style="color:#000;">Seleccionar Ciclo</b></label>
                  <select id="select" name="selectedCiclo" class="form-control select2" style="width:100%;">
                      <option></option>
                      <?php if(count($ciclos)>1){ foreach ($ciclos as $key){ if(!empty($key['id_ciclo'])){ ?>
                        <option value="<?=$key['id_ciclo']?>" <?php if(!empty($id_ciclo)){if($key['id_ciclo']==$id_ciclo){echo "selected='1'";}} ?>>
                          <?php echo "Ciclo ".$key['numero_ciclo']."/".$key['ano_ciclo'].""; ?>
                        </option>
                      <?php } } } ?>
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

                  <div class="alert" style="background:#ccc">
                    <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cliente['id_cliente']?> buttonBoxdown buttonBoxdown<?=$cliente['id_cliente']?> " value="<?=$cliente['id_cliente']?>"><span class="fa fa-caret-square-o-down"></span></button>&nbsp
                    <button style="margin-left:-10px;" class="btn buttonBox buttonBox<?=$cliente['id_cliente']?> buttonBoxup buttonBoxup<?=$cliente['id_cliente']?> d-none" value="<?=$cliente['id_cliente']?>"><span class="fa fa-caret-square-o-up"></span></button>&nbsp
                    <!-- <button class="buttonBox buttonBox<?=$nx?> buttonBoxdown buttonBoxdown<?=$nx?> " value="<?=$nx?>"><span class="fa fa-caret-square-o-down"></span></button>
                    <button class="buttonBox buttonBox<?=$nx?> buttonBoxup buttonBoxup<?=$nx?> d-none" value="<?=$nx?>"><span class="fa fa-caret-square-o-up"></span></button> -->
                      <?php $cliente['op'] = 0; ?>
                      <?php 
                      if($cliente['fotoPerfil']==""){ 
                        $fotoPCliente = "public/assets/img/profile/";
                        if($cliente['sexo']=="Femenino"){$fotoPCliente .= "Femenino.png";}
                        if($cliente['sexo']=="Masculino"){$fotoPCliente .= "Masculino.png";} 

                      }else{
                        $fotoPCliente = $cliente['fotoPerfil'];
                      }
                      ?>
                    <?php if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
                            foreach ($pedidosClientes as $key2) {
                              if(!empty($key2['id_cliente'])){
                                if($key2['id_cliente']==$cliente['id_cliente']){
                                    $cliente['op'] += 1; 
                                    if($key2['cantidad_aprobada']>0){
                                      $ruta = "c=".$key2['id_ciclo']."&n=".$key2['numero_ciclo']."&y=".$key2['ano_ciclo']."&route=Estados&id=".$key2['id_pedido'];
                                      ?>
                                       <a href="?<?=$ruta?>" style='color:<?=$colorPrimaryAll; ?>'> 
                                          <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                        <?php 
                                        echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                      ?> </a> 
                                      <?php echo " - Solicitado: $".$key2['cantidad_solicitada']." - Aprobado: $".$key2['cantidad_aprobada']."";
                                    }else{ ?>
                                          <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                    <?php 
                                      echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                      echo " - Solicitado: $".$key2['cantidad_solicitada']." colecciones - Aprobado: $".$key2['cantidad_aprobada']."";
                                    }
                                }
                              }
                            }
                            if($cliente['op']==0){?>
                              <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                            <?php 
                              echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido'];
                            }

                    }else{?>
                                          <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                    <?php 
                      echo $cliente['primer_nombre']." ".$cliente['primer_apellido'];
                    } ?>
                  </div>
                  <?php 
                    $query = "SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.id_lider = {$cliente['id_cliente']}";
                    $clientesss = $lider->consultarQuery($query);
                    foreach ($clientesss as $datas) {
                      if(!empty($datas['id_cliente'])){
                        if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
                          Imprimir($cliente['id_cliente'], $colorPrimaryAll, $datas, $lider, "0", $pedidosClientes);
                        }else{
                          Imprimir($cliente['id_cliente'], $colorPrimaryAll, $datas, $lider, "0");                          
                        }
                      }
                    }

                  ?>
              </div>
<?php 

function Imprimir($nx, $colorPrimaryAll, $cliente, $lider, $px, $pedidosClientes=[]){
  $px2 = $px + 8;
  // print_r($cliente);
  // echo "<br><br>";
   ?>
  <?php 
    $aprob = 0;
  foreach ($pedidosClientes as $keyx) {
    if(!empty($keyx['id_cliente'])){
      if($keyx['id_cliente']==$cliente['id_cliente']){ 
        if($keyx['cantidad_aprobada']>0){
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

  // $iddss = $cliente['id_lider'];
  ?> <!-- <input type="" value="<?=$iddss?>"> --> <?php 
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
                                if($key2['cantidad_aprobada']>0){
                                  $ruta = "c=".$key2['id_ciclo']."&n=".$key2['numero_ciclo']."&y=".$key2['ano_ciclo']."&route=Estados&id=".$key2['id_pedido'];
                                  ?> 
                                      <a href="?<?=$ruta?>" style='color:<?=$colorPrimaryAll; ?>'> 

                                    <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                  <?php 
                                    echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                  ?> </a> 
                                  <?php echo " - Solicitado: $".$key2['cantidad_solicitada']." - Aprobado: $".$key2['cantidad_aprobada']."";
                                }else{ ?>
                                    <img style="width:35px;background:#fff;border-radius:50%;border:1px solid #444;" src="<?=$fotoPCliente?>">
                                <?php 
                                  echo " ".$cliente['primer_nombre']." ".$cliente['primer_apellido']; 
                                  echo " - Solicitado: $".$key2['cantidad_solicitada']." - Aprobado: $".$key2['cantidad_aprobada']."";
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
  $query = "SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.id_lider = {$cliente['id_cliente']}";
  $clientes = $lider->consultarQuery($query);
  foreach ($clientes as $datas) {
    if(!empty($datas['id_cliente'])){
      if (!empty($pedidosClientes) && Count($pedidosClientes)>1){
        Imprimir($cliente['id_cliente'], $colorPrimaryAll, $datas, $lider, $px2, $pedidosClientes);
      }else{
        Imprimir($cliente['id_cliente'], $colorPrimaryAll, $datas, $lider, $px2);                          
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
      <img src="<?=$fotoPerfilCliente?>" class="imgMostrarGrandeFoto col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4" style="margin-top:10vh;margin-bottom:10vh;">
        <!-- background:#fff; -->
      <button style="position:fixed;top:1vh;right:2vh;" class="btn cerrarboxImgGrandeFoto">X</button>
    </div>

  </div>
  <div style="background:#000000DD;position:fixed;top:0;left:0;width:100%;height:100vh;z-index:9000100;" class="boxImgGrandePortada d-none">
    <div class="row">
      <img src="<?=$fotoPortadaCliente?>" class="imgMostrarGrandePortada col-xs-12 col-md-8 col-md-offset-2" style="margin-top:10vh;margin-bottom:10vh;">
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
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="idLider" value="<?=$_GET['id']?>">
<?php endif; ?>

<script>

$(document).ready(function(){

  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                   confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });
  });

  $("#select").change(function(){
    $(".formPedidosSelected").submit();
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
    var h1 = parseInt($(".boxImgGrandeFoto").height());
    var h2 = parseInt($(".imgPerfil").height());
    var h3 = h1-h2;
    var h4 = h3/4;
    var style = $(".imgMostrarGrandeFoto").attr("style");
    style += "margin-top:"+h4+"px;";
    $(".imgMostrarGrandeFoto").attr("style", style);
  
  
    $(".boxImgGrandeFoto").show();
  });

  $(".boxImgGrandePortada").hide();
  $(".boxImgGrandePortada").removeClass("d-none");

  $(".imgPortada").click(function(){
    var h1 = parseInt($(".boxImgGrandePortada").height());
    var h2 = parseInt($(".imgPortada").height());
    var h3 = h1-h2;
    var h4 = h3/4;

    var style = $(".boxImgGrandePortada").attr("style");
    style += "margin-top:"+h4+"px;";
    $(".imgGrandePortada").attr("style", style);
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
