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










          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:7px;padding-right:7px">
              <?php 
                $cuentaUsuario = $_SESSION['cuentaUsuarioPage'];
                // echo $cuentaUsuario['fotoPerfil'];
                if($cuentaUsuario['fotoPerfil'] == ""){
                  $fotoPerfil = "public/assets/img/profile/";
                  if($_SESSION['cuentaPage']['sexo']=="Femenino"){$fotoPerfil .= "Femenino.png";}
                  if($_SESSION['cuentaPage']['sexo']=="Masculino"){$fotoPerfil .= "Masculino.png";} 

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
                $_SESSION['fotoPerfilPage']=$fotoPerfil;
                $_SESSION['fotoPortadaPage']=$fotoPortada;
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
                      <?php $rroll = "Desarrollador"; ?>

                      <small><?php echo $rroll ?> de la Pagina de StyleCollection</small>
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
      <input type="hidden" class="rolhidden" value="<?php echo $rol; ?>">
    </nav>
  </header>