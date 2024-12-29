<style type="text/css">
.element-Message{
  background:#ccc !important;
  color:red !important;
}
.d-none{
  display:none;
}
      /*.navbar .navbar-static-top{
        box-sizing:border-box;
        height:10vh;
        background:red;
      }
      .navbar-custom-menu{
        background:red;
        width:50%;
        position:relative;
        left:-45vh;
      }*/
</style>
  <header class="main-header">
    <!-- Logo -->
    <a href="./" class="logo" style="background:red;">
      <!-- <span class="logo-mini color-completo"><b class="color-corto">Style</b></span> -->
      <!-- <span class="logo-lg color-completo"><b class="color-corto">Style Collection</b></span> -->
      <span class="logo-mini color-completo">
        <img src="public/assets/img/icon.png" style="width:50%;">
      </span>
      <span class="logo-lg color-completo">
        <img src="public/assets/img/logo5B.png" style="height:50px;">
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
            
      <!-- Sidebar toggle button-->
      <!-- <style type="text/css">.sidebar-toggle:hover{background: red}</style> -->
      <a href="#" class="sidebar-toggle text-center" data-toggle="push-menu" role="button" style="font-size:;">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu"  style="box-sizing:border-box;">
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
          <li class="dropdown notifications-menu" style="font-size:;">
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
          <li class="dropdown tasks-menu" style="font-size:;">
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

          <!-- <li style=""> -->
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
          <!-- </li> -->
            





          <?php
            $gemasCanjeadas = 0;
            $canjeoGemasCliente = 0;
            $gemasAdquiridasNombramiento = 0;
            $gemasObsequiosAdquirido = 0;

            $gemasAdquiridasBloqueadas = 0;
            $gemasAdquiridasDisponibles = 0;
            $gemasAdquiridasFactura = 0;
            $gemasAdquiridasFacturaBloqueadas = 0;
            $gemasAdquiridasFacturaDisponibles = 0;
            $gemasAdquiridasBonos = 0;
            $gemasBonos = 0;

            $gemasLiquidadas = 0;
            $id_cliente_personal = $_SESSION['id_cliente'];
            

            $canjeosPersonales = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_cliente_personal} and canjeos.estatus = 1");
            foreach ($canjeosPersonales as $canje) {
              if(!empty($canje['cantidad_gemas'])){
                // $gemasCanjeadas += $canje['cantidad_gemas'];
                $gemasCanjeadas += ($canje['unidades'] * $canje['cantidad_gemas']);
              }
            }

            $canjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_cliente = {$id_cliente_personal} and canjeos_gemas.estatus = 1");
            foreach ($canjeosGemasCliente as $canje) {
              if(!empty($canje['cantidad'])){
                $canjeoGemasCliente += $canje['cantidad'];
              }
            }

            $nombramientoAdquirido = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente_personal} and estatus = 1");
            foreach ($nombramientoAdquirido as $data) {
              if(!empty($data['id_nombramiento'])){
                $gemasAdquiridasNombramiento += $data['cantidad_gemas'];
              }
            }

            $obsequiosAdquirido = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE id_cliente = {$id_cliente_personal} and estatus = 1");
            foreach ($obsequiosAdquirido as $data) {
              if(!empty($data['id_obsequio_gema'])){
                $gemasObsequiosAdquirido += $data['cantidad_gemas'];
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

            $gemas_liquidadas = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente_personal}");
            foreach ($gemas_liquidadas as $data) {
              if(!empty($data['id_descuento_gema'])){
                $gemasLiquidadas += $data['cantidad_descuento_gemas'];
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
            $gemasAdquiridasDisponibles += $gemasObsequiosAdquirido;
            
            $gemasAdquiridasDisponibles -= $gemasCanjeadas;
            $gemasAdquiridasDisponibles -= $gemasLiquidadas;
            $gemasAdquiridasDisponibles -= $canjeoGemasCliente;
            ?> 

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:17px;padding-right:17px">
                <!-- <i class="fa fa-envelope-o" ></i> -->
                <div style="background:#FFF;border-radius:100px;margin-bottom:-5px;margin-top:-6px;margin-right:-10px;height:30px;">
                  <img style="width:40px;padding:0;margin:0;position:relative;left:-12px;top:-4px;" src="<?=$fotoGema?>">
                  <span style="color:<?=$fucsia?>;position:relative;top:-3px;left:-12px">
                    <b style="font-size:.9em">
                    <?php 
                      // $gemasAdquiridasDisponibles = 99999.50;
                      // $gemasAdquiridasBloqueadas = 5150;
                      echo number_format($gemasAdquiridasDisponibles,2,',','.'); 
                      // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                    ?>
                    </b>
                  </span>
                </div>
             

                
              </a>
              <ul class="dropdown-menu" style="box-shadow:0px 0px 2px #000">
                <?php
                  $fondoImg = "1";
                  $fondoBoxImageGema = "background:#AAA";
                  if($fondoImg=="1"){
                    $fondoBoxImageGema = "background:url('public/assets/img/gemas/fondos/fondo.jpg')";
                  }
                ?>
                <!-- <style>.box{ <?=$fondoBoxImageGema;?>;background-size:100% 100%; }</style> -->
                <!-- width:280px;height:175px; -->
                <li class="user-header " style="<?=$fondoBoxImageGema?>;background-size:100% 100%;">
                      <!-- <img src="<?=$fotoPerfil?>" style='background:#fff' class="img-circle" alt="User Image"> -->
                      <!-- <img style="width:100px;" src="<?=$fotoGema?>"> -->

                      <?php 
                        // $colorTextGemas = "color:".$fucsia.";text-shadow:0px 0px 3px #000;";
                        // $colorTextGemas = "color:#000;text-shadow:0px 0px 3px #FFF;";
                        // $colorTextGemas = "color:#777;text-shadow:0px 0px 0px #000;";
                        $colorTextGemas = "color:#FFF;text-shadow:1px 1px 3px #000000;";
                      ?>
                      <p style="<?=$colorTextGemas; ?>margin:0;padding:0">
                        <span style="margin:0;padding:0;;"><b><u>Gemas</u></b></span>
                      </p>
                <span style="position:relative;top:-5px;right:35px;text-align:left;">
                  <span style="<?=$colorTextGemas; ?>;margin-right:50px;"><small><b>Disponibles</b></small></span>
                  <br>
                  <div class="" style="background:#FFF;border-radius:100px;display:inline-block;rotate:50;box-shadow:0px 0px 5px #DDD">
                    <img style="width:65px;padding:0;margin:0;position:relative;left:-10px;top:0px;" src="<?=$fotoGema?>">
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
                
                <span style="position:relative;top:-20px;left:50px;text-align:right;">
                  <span style="<?=$colorTextGemas; ?>margin-left:30px"><small><b>Bloqueadas</b></small></span>
                  <br>
                  <div class="" style="background:#FFF;border-radius:100px;display:inline-block;">
                    <img style="width:35px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>">
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

                      
                        
                    
                <!-- </li> -->
                <!-- <li> -->
                  
                </li>
                <li class="user-footer">
                  <div class="text-center" style="padding:0;margin:0;">
                    
                      <!-- <span style="color:#000;background:red;width:100%;display:block;z-index:100;"> -->
                      <p style="color:#fff;position:absolute;width:100%;display:block;margin:0;margin-top:-30px;">
                        <small><a style="color:#FFF;text-shadow:0px 0px 3px #000;" href="?route=Gemas&action=Historial"><b><u>Historial de gemas</u></b></a></small>
                      </p>
                  </div>
                  <div class="text-center">
                    <?php if ($catalagomenusuperior=="1"): ?>
                      <!-- <?php
                        $buscar = $lider->consultarQuery("SELECT * FROM fechas_catalogo WHERE id_fecha_catalogo = 1");
                        $apertura = "";
                        $cierre = "";
                        if(count($buscar)>1){
                          $apertura = $buscar[0]['fecha_apertura_catalogo'];
                          $cierre = $buscar[0]['fecha_cierre_catalogo'];
                        }
                        // echo $apertura;
                        // $hoy = "2022-08-09";
                        // echo $cierre;
                        $hoy = date('Y-m-d');
                      ?>
                      <?php if($apertura != "" && $cierre != ""){ ?>
                          <?php if(($hoy >= $apertura) && $hoy <= $cierre){ ?>
                            <a href="?route=Catalogo&action=Ver" class="btn enviar2 btn-flat col-xs-12">Ver catálogo</a>
                          <?php }else{ ?>
                            <a style="color:#FFF;background:#999" class="btn btn-flat col-xs-12">Ver catálogo</a>
                          <?php } ?>
                      <?php }else{ ?>
                        <a style="color:#FFF;background:#999" class="btn btn-flat col-xs-12">Ver catálogo</a>
                      <?php } ?>  -->

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
                  $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                  // $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                }else{
                  $fotoPortada = $cuentaUsuario['fotoPortada'];
                }
                
                $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                // $fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";
                
                // echo $fotoPerfil;
                $_SESSION['fotoPerfil']=$fotoPerfil;
                $_SESSION['fotoPortada']=$fotoPortada;
                // $fotoPortada = "public/assets/img/images/img53.jpg";
                // $fotoPerfil = "public/assets/img/profile/perfil.jpg";
              ?>
                
                <style>
                  @media screen and (max-width: 690px){
                    .txtNombre{float:right;margin-top:-10px; }
                  }
                </style>
                <img src="<?=$fotoPerfil?>" style='background:#fff;margin-right:4px;font-size:.9em' class="user-image" alt="User Image">
                <span class="txtNombre" style="font-size:.8em;">
                  <?php echo $cuenta['primer_nombre']; ?>
                  <span class="hidden-md hidden-sm hidden-lg"><br></span>
                  <?php echo $cuenta['primer_apellido']; ?>
                </span>
              <!-- <span class="hidden-xs"> -->
                <!-- Alexander Pierce -->
              <!-- </span> -->
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