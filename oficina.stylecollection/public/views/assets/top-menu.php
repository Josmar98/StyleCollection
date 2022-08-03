<style type="text/css">
.element-Message{
  background:#ccc !important;
  color:red !important;
}
.d-none{
  display:none;
}
</style>
  <header class="main-header">
    <!-- Logo -->
    <a href="./" class="logo">
      <span class="logo-mini color-completo"><b class="color-corto">S</b>tyle</span>
      <span class="logo-lg color-completo"><b class="color-corto">Style</b>Collection</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" >
      
      <!-- Sidebar toggle button-->
      <!-- <style type="text/css">.sidebar-toggle:hover{background: red}</style> -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <!-- <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="public/vendor/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="public/vendor/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="public/vendor/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="public/vendor/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>

                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="public/vendor/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li> -->


          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle box_notificaciones" data-toggle="dropdown">
              <i class="fa fa-bell-o" style="font-size:1.2em"></i>
              <span class="label cantidad_notificaciones d-none">10</span>
            </a>
            <ul class="dropdown-menu" class="notification" ><!-- style="width:320px" -->
              <li class="header"><b>Tiene <span class="cantidadNoVista"></span> <span class="tipoNovista"></span></b></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu menu_notificaciones" ><!-- style="width:400px" -->

                  <!-- <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li> -->

                </ul>
              </li>
              <li class="footer"><a href="?route=Notificaciones">Ver Todas</a></li>
                <?php 
                  // if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
                ?>
                <?php
                  // }else{
                ?>
              <!-- <li class="footer"><a>_</a></li> -->
                <?php                    
                  // }
                ?>

            </ul>
          </li>




          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
              <i class="fa fa-flag-o" ></i>
              <span class="label Informaciones d-none">#</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><b>Informaciones</b></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu menu_informaciones">
                  
                  <!-- Task item -->
                  <!-- <li>
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li> -->
                  <!-- end task item -->


                

                </ul>
              </li>
              <li class="footer">
                <a href="#">_</a>
              </li>
            </ul>
          </li>

          <li>
              <!-- <i class="fa fa-gears"></i> -->
              <!-- <i class="fa fa-envelope" ></i> -->
            <?php 
              $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones");
              $editarPerfilDisponible = 1;
              $editarNombreUsuarioDisponible = 0;
              $editarClaveUsuarioDisponible = 0;
              $verFotosDisponible = 0;
              $catalagomenusuperior = 0;
              $panelLateralDisponible = 1;
              if(Count($configuraciones)>1){
                foreach ($configuraciones as $keys) {
                  if(!empty($keys['id_configuracion'])){
                    if($keys['clausula']=="Editar Perfil"){
                      $editarPerfilDisponible = $keys['valor'];
                    }
                    if($keys['clausula']=="Editar Usuario"){
                      $editarNombreUsuarioDisponible = $keys['valor'];
                    }
                    if($keys['clausula']=="Editar Clave"){
                      $editarClaveUsuarioDisponible = $keys['valor'];
                    }
                    if($keys['clausula']=="Ver Fotos"){
                      $verFotosDisponible = $keys['valor'];
                    }
                    if($keys['clausula']=="Panel Lateral"){
                      $panelLateralDisponible = $keys['valor'];
                    }
                    if($keys['clausula']=="Catalagomenusuperior"){
                      $catalagomenusuperior = $keys['valor'];
                    }
                  }
                }
              }
            if($panelLateralDisponible==1){ ?>
              <!-- <a href="#" data-toggle="control-sidebar">
                <i class="fa fa-envelope-o" ></i>
              </a> -->
            <?php } else { ?>
              <!-- <a >
                <i class="fa fa-envelope-o" ></i>
              </a> -->
            <?php } ?>
          </li>
            





          <?php
            $gemasCanjeadas = 0;

            $gemasAdquiridasNombramiento = 0;
            $gemasAdquiridasBloqueadas = 0;
            $gemasAdquiridasDisponibles = 0;
            $gemasAdquiridasFactura = 0;
            $gemasAdquiridasFacturaBloqueadas = 0;
            $gemasAdquiridasFacturaDisponibles = 0;
            $gemasAdquiridasBonos = 0;
            $gemasBonos = 0;
            $id_cliente_personal = $_SESSION['id_cliente'];

            $canjeosPersonales = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_cliente_personal} and canjeos.estatus = 1");
            foreach ($canjeosPersonales as $canje) {
              if(!empty($canje['cantidad_gemas'])){
                $gemasCanjeadas += $canje['cantidad_gemas'];
              }
            }

            $nombramientoAdquirido = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente_personal} and estatus = 1");
            foreach ($nombramientoAdquirido as $data) {
              if(!empty($data['id_nombramiento'])){
                $gemasAdquiridasNombramiento += $data['cantidad_gemas'];
              }
            }
            $gemasAdquiridas = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_cliente = {$id_cliente_personal} and gemas.estatus = 1");
            foreach ($gemasAdquiridas as $data) {
              if(!empty($data['id_gema'])){
                $gemasBonos += $data['cantidad_gemas'];
                if($data['estado']=="Bloqueado"){
                  $gemasAdquiridasBloqueadas += $data['cantidad_gemas'];
                }
                if($data['estado']=="Disponible"){
                  $gemasAdquiridasDisponibles += $data['activas'];
                }


                if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
                  $gemasAdquiridasFactura += $data['cantidad_gemas'];
                  if($data['estado']=="Bloqueado"){
                    $gemasAdquiridasFacturaBloqueadas += $data['cantidad_gemas'];
                  }
                  if($data['estado']=="Disponible"){
                    $gemasAdquiridasFacturaDisponibles += $data['cantidad_gemas'];
                  }
                }
                if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
                  $gemasAdquiridasBonos += $data['cantidad_gemas'];
                }
              }
            }

            // echo "gemasAdquiridasNombramiento: ".$gemasAdquiridasNombramiento."<br>";
            // echo "gemasAdquiridasBloqueadas: ".$gemasAdquiridasBloqueadas."<br>";
            // echo "gemasAdquiridasDisponibles: ".$gemasAdquiridasDisponibles."<br>";
            // echo "gemasAdquiridasFactura: ".$gemasAdquiridasFactura."<br>";
            // echo "gemasAdquiridasFacturaBloqueadas: ".$gemasAdquiridasFacturaBloqueadas."<br>";
            // echo "gemasAdquiridasFacturaDisponibles: ".$gemasAdquiridasFacturaDisponibles."<br>";
            // echo "gemasAdquiridasBonos: ".$gemasAdquiridasBonos."<br>";
            // echo "gemasBonos: ".$gemasBonos."<br>";

          //if($gemasAdquiridasDisponibles+$gemasAdquiridasBloqueadas==$gemasBonos){ 
            $fotoGema = "public/assets/img/gemas/gema1.1.png";
            $fotoGemaBloqueadas = "public/assets/img/gemas/gema1.2.png";
            $gemasAdquiridasDisponibles += $gemasAdquiridasNombramiento;
            $gemasAdquiridasDisponibles -= $gemasCanjeadas;
            ?> 

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:17px;padding-right:17px">
                <!-- <i class="fa fa-envelope-o" ></i> -->
                <div style="background:#FFF;border-radius:100%;margin-bottom:-5px;margin-top:-6px;margin-right:-10px;height:30px;">
                  <img style="width:30px;padding:0;margin:0;position:relative;left:-10px;top:3px;" src="<?=$fotoGema?>">
                  <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px">
                    <b style="font-size:.9em">
                    <?php 
                      echo number_format($gemasAdquiridasDisponibles,2,',','.'); 
                      // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                    ?>
                    </b>
                  </span>
                </div>
             

                
              </a>
              <ul class="dropdown-menu" style="box-shadow:0px 0px 2px #000">
                <li class="user-header " style="background:#AAA;background-size:100% 100%;">
                      <!-- <img src="<?=$fotoPerfil?>" style='background:#fff' class="img-circle" alt="User Image"> -->
                      <!-- <img style="width:100px;" src="<?=$fotoGema?>"> -->


                      <p style="color:#fff;text-shadow:0px 0px 3px #000;margin:0;padding:0">
                        <span style="margin:0;padding:0">Gemas</span>
                      </p>
                <span style="position:relative;top:10px;right:50px;text-align:left;">
                  <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-right:50px;"><small>Disponibles</small></span>
                  <br>
                  <div class="" style="background:#FFF;border-radius:100%;display:inline-block;rotate:50;">
                    <img style="width:70px;padding:0;margin:0;position:relative;left:-10px;top:3px;" src="<?=$fotoGema?>">
                    <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px">
                      <b style="font-size:1.5em">
                      <?php 
                        echo number_format($gemasAdquiridasDisponibles,2,',','.'); 
                        // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                      ?>
                      </b>
                    </span>
                  </div>
                </span>

                <br>
                
                <span style="position:relative;top:-30px;left:55px;text-align:right;">
                  <span style="color:#FFF;text-shadow:0px 0px 3px #000;margin-left:30px"><small>Bloqueadas</small></span>
                  <br>
                  <div class="" style="background:#FFF;border-radius:100%;display:inline-block;">
                    <img style="width:30px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>">
                    <span style="color:#00000055;position:relative;top:3px;left:-12px">
                      <b style="font-size:1em">
                      <?php 
                        echo number_format($gemasAdquiridasBloqueadas,2,',','.'); 
                        // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                      ?>
                      </b>
                    </span>
                  </div>
                </span>

                      
                        
                      <p style="color:#fff;">
                        <small><a style="color:#fff;" href="?route=Gemas&action=Historial"><b><u>Historial de gemas</u></b></a></small>
                      </p>
                    
                </li>
                <li class="user-footer">
                  <div class="text-center">
                    <?php if ($catalagomenusuperior=="1"): ?>
                      <a href="?route=Catalogo&action=Ver" class="btn enviar2 btn-flat col-xs-12">Ver catálogo</a>
                    <?php elseif ($catalagomenusuperior=="0"): ?>
                      <a style="color:#FFF;background:#999" class="btn btn-flat col-xs-12">Ver catálogo</a>
                    <?php endif; ?>
                  </div>
                </li>
              </ul>
            </li>
          <?php //} ?>








          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:7px;padding-right:7px">
              <?php 
                $cuentaUsuario = $_SESSION['cuentaUsuario'];
                // echo $cuentaUsuario['fotoPerfil'];
                if($cuentaUsuario['fotoPerfil'] == ""){
                  $fotoPerfil = "public/assets/img/profile/";
                  if($_SESSION['cuenta']['sexo']=="Femenino"){$fotoPerfil .= "Femenino.png";}
                  if($_SESSION['cuenta']['sexo']=="Masculino"){$fotoPerfil .= "Masculino.png";} 

                }else{
                  $fotoPerfil = $cuentaUsuario['fotoPerfil'];
                }
                if($cuentaUsuario['fotoPortada'] == ""){
                  $fotoPortada = "public/assets/img/profile/portadaGeneral.png";
                  // $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                }else{
                  $fotoPortada = $cuentaUsuario['fotoPortada'];
                }
                
                $fotoPortada = "public/assets/img/profile/PortadaGeneral.png";
                // $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                
                // echo $fotoPerfil;
                $_SESSION['fotoPerfil']=$fotoPerfil;
                $_SESSION['fotoPortada']=$fotoPortada;
                // $fotoPortada = "public/assets/img/images/img53.jpg";
                // $fotoPerfil = "public/assets/img/profile/perfil.jpg";
              ?>
              <img src="<?=$fotoPerfil?>" style='background:#fff;margin-right:4px' class="user-image" alt="User Image">
              <span style="font-size:.9em;">
                <?php echo $cuenta['primer_nombre']; ?>
                <?php echo $cuenta['primer_apellido']; ?>
              </span>
              <span class="hidden-xs">
                <!-- Alexander Pierce -->
              </span>
            </a>
            <ul class="dropdown-menu" style="box-shadow:0px 0px 2px #000">
              <!-- User image --><!-- bg-fucsia -->
              <li class="user-header " style="background:url(<?=$fotoPortada?>);background-size:100% 100%;">
                    <img src="<?=$fotoPerfil?>" style='background:#fff' class="img-circle" alt="User Image">
                    
                    <p style="color:#fff;text-shadow:0px 0px 3px #000">
                      <b>
                        <?php echo $cuenta['primer_nombre']; ?>
                        <?php echo $cuenta['primer_apellido']; ?>
                      </b>
                      <!-- - Web Developer -->
                      <?php $rroll = $_SESSION['nombre_rol']; ?>
                      <?php if($_SESSION['nombre_rol']=="Vendedor"){if($_SESSION['cuenta']['sexo']=="Femenino" || $_SESSION['cuenta']['sexo']=="Masculino"){$rroll="Lider";} } ?>
                      <?php if($_SESSION['nombre_rol']=="Administrador"){if($_SESSION['cuenta']['sexo']=="Femenino"){$rroll="Administradora";} } ?>
                      <?php if($_SESSION['nombre_rol']=="Conciliador"){if($_SESSION['cuenta']['sexo']=="Femenino"){$rroll="Conciliadora";} } ?>
                      <small><?php echo $rroll ?> de StyleCollection</small>
                    </p>
                  
              </li>
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="?route=Perfil" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="?route=logout" class="btn btn-default btn-flat">Cerrar Sesion</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar">
              <i class="fa fa-gears"></i>
              <i class="fa fa-envelope" ></i>

            </a>
          </li> -->
        </ul>
      </div>
      <?php $rol = $_SESSION['nombre_rol']; ?>
      <input type="hidden" class="rolhidden" value="<?php echo $rol; ?>">
    </nav>
  </header>