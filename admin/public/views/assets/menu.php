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
    

                            <?php if($url=="Clientes" || $url=="ClientesBorrados"){ ?>
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
              <!--  LINEAS   -->
<!-- ======================================================================================================================= -->
          

                            <?php if($url=="Lineas" || $url=="LineasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Líneas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                            <?php if($url=="Lineas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Lineas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Línea</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Lineas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Línea</a></li>
                            <?php } ?>

                            <?php if($url=="Lineas" && empty($action)){ ?>
            <li class="active"><a href="?route=Lineas"><i class="fa fa-puzzle-piece"></i> Ver Líneas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Lineas"><i class="fa fa-puzzle-piece"></i> Ver Líneas</a></li>
                            <?php } ?>

                            <?php if($url=="LineasBorradas" && empty($action)){ ?>
            <!-- <li class="active"><a href="?route=LineasBorradas"><i class="fa fa-puzzle-piece"></i> Ver Líneas Borradas</a></li> -->
                            <?php }else{ ?>
            <!-- <li><a href="?route=LineasBorradas"><i class="fa fa-puzzle-piece"></i> Ver Líneas Borradas</a></li> -->
                            <?php } ?>

          </ul>
        </li> 

<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  PRODUCTOS CATALOGOS  -->
<!-- ======================================================================================================================= -->
     
                            <?php if($url=="ProductosCatalogos" || $url=="ProductosCatalogosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-inbox"></i> <span>Productos Catalogos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                            <?php if($url=="ProductosCatalogos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=ProductosCatalogos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto catalogo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=ProductosCatalogos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto catalogo</a></li>
                            <?php } ?>


                            <?php if($url=="ProductosCatalogos" && empty($action)){ ?>
            <li class="active"><a href="?route=ProductosCatalogos"><i class="fa fa-archive"></i> Ver Productos catalogo</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ProductosCatalogos"><i class="fa fa-archive"></i> Ver Productos catalogo</a></li>
                            <?php } ?>

                            <?php if($url=="ProductosCatalogosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=ProductosCatalogosBorrados"><i class="fa fa-archive"></i> Ver Productos catalogo Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ProductosCatalogosBorrados"><i class="fa fa-archive"></i> Ver Productos catalogo Borrados</a></li>
                            <?php } ?>

<!-- 
                            <?php if($url=="EstructuraProductos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=EstructuraProductos&action=Registrar"><i class="fa fa-archive"></i> Registrar Estructura de <br> Producto catalogo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=EstructuraProductos&action=Registrar"><i class="fa fa-archive"></i> Registrar Estructura de <br>Producto catalogo</a></li>
                            <?php } ?>


                            <?php if($url=="EstructuraProductos" && empty($action)){ ?>
            <li class="active"><a href="?route=EstructuraProductos"><i class="fa fa-archive"></i> Estructura de <br> Producto catalogo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=EstructuraProductos"><i class="fa fa-archive"></i> Estructura de <br>Producto catalogo</a></li>
                            <?php } ?> -->

          </ul>
        </li>

<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  LINEAS   -->
<!-- ======================================================================================================================= -->
          

                            <?php if($url=="LineasProductos" || $url=="LineasProductosBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-object-group"></i> <span>Lineas de Productos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                            <?php if($url=="LineasProductos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=LineasProductos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Linea de Productos</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=LineasProductos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Linea de Productos</a></li>
                            <?php } ?>

                            <?php if($url=="LineasProductos" && empty($action)){ ?>
            <li class="active"><a href="?route=LineasProductos"><i class="fa fa-puzzle-piece"></i> Ver Lineas de Productos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=LineasProductos"><i class="fa fa-puzzle-piece"></i> Ver Lineas de Productos</a></li>
                            <?php } ?>

                                        <?php if($url=="LineasProductos" && !empty($action) && $action == "Posicion"){ ?>
            <li class="active"><a href="?route=LineasProductos&action=Posicion"><i class="fa fa-puzzle-piece"></i> Posiciónar Linea de Productos</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=LineasProductos&action=Posicion"><i class="fa fa-puzzle-piece"></i> Posiciónar Linea de Productos</a></li>
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


                            <?php if($url=="UsuariosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=UsuariosBorrados"><i class="fa fa-user"></i> Ver Usuarios <br>&nbsp&nbsp Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=UsuariosBorrados"><i class="fa fa-user"></i> Ver Usuarios <br>&nbsp&nbsp Borrados</a></li>
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