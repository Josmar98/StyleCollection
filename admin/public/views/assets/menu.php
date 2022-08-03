  <!-- <aside class="main-header" style="position:fixed;min-height:100vh;max-height:100vh;width:18.3%;overflow:auto;top:0%;z-index:0"> -->
  <aside class="main-sidebar">
      
    <!-- <div class="main-header">
    <a href="./" class="logo">
      <span class="logo-mini color-completo"><b class="color-corto">S</b>tyle</span>
      <span class="logo-lg color-completo"><b class="color-corto">Style</b>Collection</span>
    </a>
    </div> -->
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- style="min-height:93vh;max-height:93vh;overflow:auto" -->
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image ReadlImage2 img-circle" style="background:#fff;padding:0;margin:0;">
          <!-- <?php echo $fotoPerfil; ?> -->
          <img src="<?=$fotoPerfil?>" style="background:#fff;" class="img-circle imageImage2" >
        </div>
        <div class="pull-left info">
          <p>
            <!-- Alexander Pierce -->
            
                <?php echo $cuenta['primer_nombre']; ?>
                <?php echo $cuenta['primer_apellido']; ?>
          </p>
          <a href="#"><i class="fa fa-circle text-success"></i> En linea</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">




      <li class="header">NAVEGACION PRINCIPAL</li>

<!-- ======================================================================================================================= -->
              <!--  HOME   -->
<!-- ======================================================================================================================= -->
      <?php if($url == "Home"){ ?>
        <li class="active">
      <?php }else{ ?>
        <li>
      <?php } ?>
          <a href="?route=Home">
            <i class="fa fa-home"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>

<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  CLIENTES   -->
<!-- ======================================================================================================================= -->
    

                            <?php if($url=="Clientes"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-users"></i> <span>Lideres</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                            <?php if($url=="Clientes" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Lider</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Lider</a></li>
                            <?php } ?>


                            <?php if($url=="Clientes" && empty($action)){ ?>
            <li class="active"><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Lideres</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Lideres</a></li>
                            <?php } ?>

                            <?php if($url=="ClientesBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=ClientesBorrados"><i class="fa fa-user"></i> Ver Lideres Suspendidos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ClientesBorrados"><i class="fa fa-user"></i> Ver Lideres Suspendidos</a></li>
                            <?php } ?>


          </ul>
        </li>


<!-- ======================================================================================================================= -->






<!-- ======================================================================================================================= -->
              <!--  CAMPANAS   -->
<!-- ======================================================================================================================= -->
          

                            <?php if($url=="Campanas" || $url=="CampanasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Campañas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                            <?php if($url=="Campanas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Campanas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Campaña</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Campanas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Campaña</a></li>
                            <?php } ?>

                            <?php if($url=="Campanas" && empty($action)){ ?>
            <li class="active"><a href="?route=Campanas"><i class="fa fa-puzzle-piece"></i> Ver Campañas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Campanas"><i class="fa fa-puzzle-piece"></i> Ver Campañas</a></li>
                            <?php } ?>

                            <?php if($url=="CampanasBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=CampanasBorradas"><i class="fa fa-puzzle-piece"></i> Ver Campañas Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=CampanasBorradas"><i class="fa fa-puzzle-piece"></i> Ver Campañas Borradas</a></li>
                            <?php } ?>

          </ul>
        </li> 


<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  PRODUCTOS   -->
<!-- ======================================================================================================================= -->
     
                            <?php if($url=="Productos" || $url=="ProductosBorrados" || $url=="Fragancias"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-inbox"></i> <span>Productos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                            <?php if($url=="Productos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Productos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Productos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto</a></li>
                            <?php } ?>


                            <?php if($url=="Productos" && empty($action)){ ?>
            <li class="active"><a href="?route=Productos"><i class="fa fa-archive"></i> Ver Productos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Productos"><i class="fa fa-archive"></i> Ver Productos</a></li>
                            <?php } ?>

                            <?php if($url=="ProductosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=ProductosBorrados"><i class="fa fa-archive"></i> Ver Productos Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ProductosBorrados"><i class="fa fa-archive"></i> Ver Productos Borrados</a></li>
                            <?php } ?>


                            <?php if($url=="Fragancias" && empty($action)){ ?>
            <li class="active"><a href="?route=Fragancias"><i class="fa fa-eyedropper"></i> Fragancias</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Fragancias"><i class="fa fa-eyedropper"></i> Ver Fragancias</a></li>
                            <?php } ?>
          </ul>
        </li>

<!-- ======================================================================================================================= -->






<!-- ======================================================================================================================= -->
              <!--  Movimientos   -->
<!-- ======================================================================================================================= -->
 
                            <?php if($url=="Colecciones" || $url=="Coleccioness"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Colecciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
<!-- ======================================================================================================================= -->

                            <?php if($url=="Colecciones" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Colecciones&action=Registrar"><i class="fa fa-file-text"></i> Registrar Colección</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Colecciones&action=Registrar"><i class="fa fa-file-text"></i> Registrar Colección</a></li>
                            <?php } ?>
                
                               <?php if($url=="Coleccioness" && empty($action)){ ?>
            <li class="active"><a href="?route=Coleccioness"><i class="fa fa-list-alt"></i> Filtrar Colecciones</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Coleccioness"><i class="fa fa-list-alt"></i> Filtrar Colecciones</a></li>
                            <?php } ?>

                            <?php if($url=="Colecciones" && empty($action)){ ?>
            <li class="active"><a href="?route=Colecciones"><i class="fa fa-list-alt"></i> Ver Colecciones</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Colecciones"><i class="fa fa-list-alt"></i> Ver Colecciones</a></li>
                            <?php } ?>


          </ul>
        </li>

<!-- ======================================================================================================================= -->








<!-- ======================================================================================================================= -->
              <!--  PLANES   -->
<!-- ======================================================================================================================= -->
      
<!--                             <?php if($url=="Planes" || $url=="PlanesBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-star"></i> <span>Planes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">



                            <?php if($url=="Planes" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Planes&action=Registrar"><i class="fa fa-star-o"></i> Registrar Plan</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Planes&action=Registrar"><i class="fa fa-star-o"></i> Registrar Plan</a></li>
                            <?php } ?>


                              <?php if($url=="Planes" && empty($action)){ ?>
            <li class="active"><a href="?route=Planes"><i class="fa fa-star-o"></i> Ver Planes</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Planes"><i class="fa fa-star-o"></i> Ver Planes</a></li>
                            <?php } ?>

                            <?php if($url=="PlanesBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=PlanesBorrados"><i class="fa fa-star-o"></i> Ver Planes Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=PlanesBorrados"><i class="fa fa-star-o"></i> Ver Planes Borrados</a></li>
                            <?php } ?>
                            
          </ul>
        </li> -->

<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  Premios   -->
<!-- ======================================================================================================================= -->


<!--                             <?php if($url=="Premios" || $url=="PremiosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-rocket"></i> <span>Premios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            

                            <?php if($url=="Premios" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Premios&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Premio</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Premios&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Premio</a></li>
                            <?php } ?>
                

                              <?php if($url=="Premios" && empty($action)){ ?>
            <li class="active"><a href="?route=Premios"><i class="fa fa-fighter-jet"></i> Ver Premios</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Premios"><i class="fa fa-fighter-jet"></i> Ver Premios</a></li>
                            <?php } ?>

                            <?php if($url=="PremiosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=PremiosBorrados"><i class="fa fa-fighter-jet"></i> Ver Premios Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=PremiosBorrados"><i class="fa fa-fighter-jet"></i> Ver Premios Borrados</a></li>
                            <?php } ?>

                            
          </ul>
        </li> -->

<!-- ======================================================================================================================= -->







<!-- ======================================================================================================================= -->
              <!--  LIDERAZGOS   -->
<!-- ======================================================================================================================= -->
  
<!-- 
                            <?php if($url=="Liderazgos" || $url=="LiderazgosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-bookmark"></i> <span>Liderazgos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            

                            <?php if($url=="Liderazgos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php } ?>
                


                              <?php if($url=="Liderazgos" && empty($action)){ ?>
            <li class="active"><a href="?route=Liderazgos"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Liderazgos"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php } ?>
                            <?php if($url=="LiderazgosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=LiderazgosBorrados"><i class="fa fa-bookmark-o"></i> Ver Liderazgos Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=LiderazgosBorrados"><i class="fa fa-bookmark-o"></i> Ver Liderazgos Borrados</a></li>
                            <?php } ?>

                            
          </ul>
        </li>


 -->





<!-- ======================================================================================================================= -->
  




<!-- ======================================================================================================================= -->
              <!--  BANCOS   -->
<!-- ======================================================================================================================= -->
       
   <!--                          <?php if($url=="Bancos"){ ?>
        <li class="active">
                            <?php }else{ ?>
        <li class="">
                            <?php } ?>
          <a href="?route=Bancos">
            <i class="fa fa-bank"></i> <span>Bancos</span>
          </a>
        </li>
                  -->

<!--  ================================================================================================================x -->
        <!-- CALENDARIO -->
<!--  ================================================================================================================x -->


  <!--                         <?php if($url=="Calendario"){ ?>
        <li class="active">
                            <?php }else{ ?>
        <li class="">
                            <?php } ?>
          <a href="?route=Calendario">
            <i class="fa fa-calendar"></i> <span>Calendario</span>
          </a>
        </li> -->

<!--  ================================================================================================================x -->
        <!-- RUTAS -->
<!--  ================================================================================================================x -->
<!-- 
                            <?php if($url=="Rutas" || $url=="RutasLideres" || $url=="RutasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-truck"></i> <span>Rutas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            

                            <?php if($url=="Rutas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Rutas&action=Registrar"><i class="fa fa-truck"></i> Registrar Ruta</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Rutas&action=Registrar"><i class="fa fa-truck"></i> Registrar Ruta</a></li>
                            <?php } ?>
                


                              <?php if($url=="Rutas" && empty($action)){ ?>
            <li class="active"><a href="?route=Rutas"><i class="fa fa-truck"></i> Ver Rutas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Rutas"><i class="fa fa-truck"></i> Ver Rutas</a></li>
                            <?php } ?>

                            <?php if($url=="RutasBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=RutasBorradas"><i class="fa fa-truck"></i> Ver Rutas Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=RutasBorradas"><i class="fa fa-truck"></i> Ver Rutas Borradas</a></li>
                            <?php } ?>


                            <?php if($url=="RutasLideres" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=RutasLideres&action=Registrar"><i class="fa fa-truck"></i> Agregar Ruta de Lideres</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=RutasLideres&action=Registrar"><i class="fa fa-truck"></i> Agregar Ruta de Lideres</a></li>
                            <?php } ?>


                              <?php if($url=="RutasLideres" && empty($action)){ ?>
            <li class="active"><a href="?route=RutasLideres"><i class="fa fa-truck"></i> Ver Rutas de Lideres</a></li>
                            <?php }else{ ?>
            <li><a href="?route=RutasLideres"><i class="fa fa-truck"></i> Ver Rutas de Lideres</a></li>
                            <?php } ?>


                            
          </ul>
        </li> -->
<!--  ================================================================================================================x -->






<!--  ================================================================================================================x -->
        <!-- RUTAS -->
<!--  ================================================================================================================x -->

<!--                             <?php if($url=="Canjeados" || $url=="" || $url==""){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-truck"></i> <span>Premios Canjeados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                              <?php if($url=="Canjeados" && empty($action)){ ?>
            <li class="active"><a href="?route=Canjeados"><i class="fa fa-truck"></i> Ver Premios Canjeados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Canjeados"><i class="fa fa-truck"></i> Ver Premios Canjeados</a></li>
                            <?php } ?>
                            
          </ul>
        </li> -->
<!--  ================================================================================================================x -->







<!-- ======================================================================================================================= -->

<!--                             <?php if($url=="Catalogos" || $url=="CatalogosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Catalogos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            

                            <?php if($url=="Catalogos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Catalogos&action=Registrar"><i class="fa fa-object-ungroup"></i> Registrar Catalogo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Catalogos&action=Registrar"><i class="fa fa-object-ungroup"></i> Registrar Catalogo</a></li>
                            <?php } ?>
                


                              <?php if($url=="Catalogos" && empty($action)){ ?>
            <li class="active"><a href="?route=Catalogos"><i class="fa fa-object-ungroup"></i> Ver Catalogos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Catalogos"><i class="fa fa-object-ungroup"></i> Ver Catalogos</a></li>
                            <?php } ?>

                            <?php if($url=="CatalogosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=CatalogosBorrados"><i class="fa fa-object-ungroup"></i> Ver Catalogos Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=CatalogosBorrados"><i class="fa fa-object-ungroup"></i> Ver Catalogos Borrados</a></li>
                            <?php } ?>

                            
          </ul>
        </li> -->

<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
        <?php //if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>

<!--                             <?php if($url=="Configuraciones" || $url=="ConfiguracionesBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Configuraciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">



                            <?php if($url=="Configuraciones" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Configuraciones&action=Registrar"><i class="fa fa-cog"></i> Agregar Configuracion</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Configuraciones&action=Registrar"><i class="fa fa-cog"></i> Agregar Configuracion</a></li>
                            <?php } ?>



                            <?php if($url=="Configuraciones" && empty($action)){ ?>
            <li class="active"><a href="?route=Configuraciones"><i class="fa fa-cog"></i> Ver Configuraciones</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Configuraciones"><i class="fa fa-cog"></i> Ver Configuraciones</a></li>
                            <?php } ?>

                        <?php if($url=="ConfiguracionesBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfiguracionesBorradas"><i class="fa fa-cog"></i> Ver Configuraciones <br>&nbsp&nbsp Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfiguracionesBorradas"><i class="fa fa-cog"></i> Ver Configuraciones <br>&nbsp&nbsp Borradas</a></li>
                            <?php } ?>
                            
          </ul>
        </li>
 -->




<!-- ======================================================================================================================= -->
              <!--  USUARIOS   -->
<!-- ======================================================================================================================= -->
 
                            <?php if($url=="Usuarios" || $url=="UsuariosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-users"></i> <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">



                            <?php if($url=="Usuarios" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Usuarios&action=Registrar"><i class="fa  fa-user-plus"></i> Registrar Usuario</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Usuarios&action=Registrar"><i class="fa  fa-user-plus"></i> Registrar Usuario</a></li>
                            <?php } ?>



                            <?php if($url=="Usuarios" && empty($action)){ ?>
            <li class="active"><a href="?route=Usuarios"><i class="fa fa-user"></i> Ver Usuarios</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Usuarios"><i class="fa fa-user"></i> Ver Usuarios</a></li>
                            <?php } ?>


                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                            <?php if($url=="UsuariosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=UsuariosBorrados"><i class="fa fa-user"></i> Ver Usuarios <br>&nbsp&nbsp Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=UsuariosBorrados"><i class="fa fa-user"></i> Ver Usuarios <br>&nbsp&nbsp Borrados</a></li>
                            <?php } ?>
                    <?php } ?>




                            <?php if($url=="Usuarios" && !empty($action) && $action == "Accesos"){ ?>
            <li class="active"><a href="?route=Usuarios&action=Accesos"><i class="fa  fa-user-secret"></i> Acceso de Usuario</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Usuarios&action=Accesos"><i class="fa  fa-user-secret"></i> Acceso de Usuario</a></li>
                            <?php } ?>

                            
          </ul>
        </li>
<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
  
<!--
        <li class="header">SEGURIDAD</li>


            
                             <?php if($url=="Bitácora" || $url=="Permisos" || $url=="Modulos" || $url=="Roles"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Seguridad</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu treeview-menu2">

 
                  <?php if($url == "Bitacora"){ ?>
                    <li class="active">
                  <?php }else{ ?>
                    <li>
                  <?php } ?>
                      <a href="?route=Bitacora">
                        <i class="fa fa-home"></i> <span>Bitacora</span>
                        <span class="pull-right-container">
                        </span>
                      </a>
                    </li>

              

                                        <?php if($url=="Permisos"){ ?>
                    <li class="active treeview">
                                        <?php }else{ ?>
                    <li class="treeview">
                                        <?php } ?>
                      <a href="#">
                        <i class="fa fa-cogs"></i> <span>Permisos</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu treeview-menu3">
                            


                                        <?php if($url=="Permisos" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Permisos&action=Registrar"><i class="fa fa-cog"></i> Registrar Permiso</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Permisos&action=Registrar"><i class="fa fa-cog"></i> Registrar Permiso</a></li>
                                        <?php } ?>


                                        <?php if($url=="Permisos" && empty($action)){ ?>
                        <li class="active"><a href="?route=Permisos"><i class="fa fa-cog"></i> Ver Permisos</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Permisos"><i class="fa fa-cog"></i> Ver Permisos</a></li>
                                        <?php } ?>
                            
                      </ul>
                    </li>
    

                                        <?php if($url=="Modulos"){ ?>
                    <li class="active treeview">
                                        <?php }else{ ?>
                    <li class="treeview">
                                        <?php } ?>
                      <a href="#">
                        <i class="fa fa-cogs"></i> <span>Modulos</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu treeview-menu3">
                            

                                        <?php if($url=="Modulos" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Modulos&action=Registrar"><i class="fa fa-cog"></i> Registrar Modulo</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Modulos&action=Registrar"><i class="fa fa-cog"></i> Registrar Modulo</a></li>
                                        <?php } ?>


                                        <?php if($url=="Modulos" && empty($action)){ ?>
                        <li class="active"><a href="?route=Modulos"><i class="fa fa-cog"></i> Ver Modulos</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Modulos"><i class="fa fa-cog"></i> Ver Modulos</a></li>
                                        <?php } ?>

                      </ul>
                    </li>




             

                                        <?php if($url=="Roles"){ ?>
                    <li class="active treeview">
                                        <?php }else{ ?>
                    <li class="treeview">
                                        <?php } ?>
                      <a href="#">
                        <i class="fa fa-cogs"></i> <span>Roles</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu treeview-menu3">


                                        <?php if($url=="Roles" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Roles&action=Registrar"><i class="fa fa-cog"></i> Registrar Rol</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Roles&action=Registrar"><i class="fa fa-cog"></i> Registrar Rol</a></li>
                                        <?php } ?>


                                        <?php if($url=="Roles" && empty($action)){ ?>
                        <li class="active"><a href="?route=Roles"><i class="fa fa-cog"></i> Ver Roles</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Roles"><i class="fa fa-cog"></i> Ver Roles</a></li>
                                        <?php } ?>

                      </ul>
                    </li>


          </ul>
        </li>
 -->
<!-- ======================================================================================================================= -->







     
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>