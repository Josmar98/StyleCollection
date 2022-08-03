  <aside class="main-sidebar" style="width:100%">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="public/vendor/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            Alexander Pierce
            
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
        <li class="header">CAMPAÑA <?php echo $n."-".$y ?> DESPACHO <?php echo $dp ?></li>
        <li class="active">
          <a href="?<?php echo $menu ?>&route=Homing2">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>

      <!-- ======================================================================================================================= -->
                    <!--  PREMIOS   -->
      <!-- ======================================================================================================================= -->
        <?php 
              $amReportes = 0;
              $amReportesR = 0;
              $amReportesC = 0;
              $amReportesE = 0;
              $amReportesB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Reportes"){
                    $amReportes = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amReportesR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amReportesC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amReportesE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amReportesB = 1;
                    }
                  }
                }
              }
              if($amReportes == 1){
          ?>

                            <?php if($url=="Reportes"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-pdf-o"></i> <span>Facturacion de Despacho</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
                            <?php if($url=="Reportes" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaDespacho&action=Registrar"><i class="fa fa-tag"></i> Realizar Factura</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=FacturaDespacho&action=Registrar"><i class="fa fa-tag"></i> Registrar Factura</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaDespacho"><i class="fa fa-tag"></i> Ver Facturas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=FacturaDespacho"><i class="fa fa-tag"></i> Ver Facturas</a></li>
                            <?php } ?>
          </ul>

        </li>
        <?php } ?>

      <!-- ======================================================================================================================= -->





        <li>
          <a href="?<?php echo $menu2 ?>&route=homing">
            <i class="fa fa-reply"></i> <span>Salir de despacho <?php echo $dp ?></span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>


      <!-- ======================================================================================================================= -->

        <li class="header">NAVEGACION EN CAMPAÑA <?php echo $n."-".$y ?> </li>
    

      <?php if($url == "homing"){ ?>
        <li class="active">
      <?php }else{ ?>
        <li>
      <?php } ?>
          <a href="?<?php echo $menu ?>&route=homing">
            <i class="fa fa-dashboard"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>


      <!-- ======================================================================================================================= -->
                    <!--  PLANES   -->
      <!-- ======================================================================================================================= -->
        <?php 
              $amPlanesCamp = 0;
              $amPlanesCampR = 0;
              $amPlanesCampC = 0;
              $amPlanesCampE = 0;
              $amPlanesCampB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Planes De Campaña"){
                    $amPlanesCamp = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amPlanesCampR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amPlanesCampC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amPlanesCampE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amPlanesCampB = 1;
                    }
                  }
                }
              }
              if($amPlanesCamp == 1){
          ?>
                            <?php if($url=="PlanesCamp"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="?<?php echo $menu ?>&route=PlanesCamp">
            <i class="fa fa-tags"></i> <span>Planes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                
                <?php  if($amPlanesCampR == 1){ ?>
                
                            <?php if($url=="PlanesCamp" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PlanesCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Plan</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PlanesCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Plan</a></li>
                            <?php } ?>

                <?php } ?>
                <?php  if($amPlanesCampC == 1){ ?>


                            <?php if($url=="PlanesCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PlanesCamp"><i class="fa fa-tag"></i> Ver Planes</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PlanesCamp"><i class="fa fa-tag"></i> Ver Planes</a></li>
                            <?php } ?>
                
                <?php } ?>

          </ul>
        </li>
          <?php } ?>

      <!-- ======================================================================================================================= -->






      <!-- ======================================================================================================================= -->
                    <!--  PREMIOS   -->
      <!-- ======================================================================================================================= -->
            <?php 
              $amPremioscamp = 0;
              $amPremioscampR = 0;
              $amPremioscampC = 0;
              $amPremioscampE = 0;
              $amPremioscampB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Premios De Campaña"){
                    $amPremioscamp = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amPremioscampR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amPremioscampC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amPremioscampE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amPremioscampB = 1;
                    }
                  }
                }
              }
              if($amPremioscamp == 1){
          ?>
                            <?php if($url=="PremiosCamp"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="?<?php echo $menu ?>&route=PremiosCamp">
            <i class="fa fa-tags"></i> <span>Premios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                
                <?php  if($amPremioscampR == 1){ ?>
                
                            <?php if($url=="PremiosCamp" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Premio</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PremiosCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Premio</a></li>
                            <?php } ?>

                <?php } ?>
                <?php  if($amPremioscampC == 1){ ?>


                            <?php if($url=="PremiosCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosCamp"><i class="fa fa-tag"></i> Ver Premios</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PremiosCamp"><i class="fa fa-tag"></i> Ver Premios</a></li>
                            <?php } ?>
                
                <?php } ?>

          </ul>
        </li>
          <?php } ?>

      <!-- ======================================================================================================================= -->





      <!-- ======================================================================================================================= -->
                    <!--  LIDERAZGOS   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amLiderazgosCamp = 0;
              $amLiderazgosCampR = 0;
              $amLiderazgosCampC = 0;
              $amLiderazgosCampE = 0;
              $amLiderazgosCampB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Liderazgos De Campaña"){
                    $amLiderazgosCamp = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amLiderazgosCampR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amLiderazgosCampC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amLiderazgosCampE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amLiderazgosCampB = 1;
                    }
                  }
                }
              }
              if($amLiderazgosCamp == 1){
          ?>

                            <?php if($url=="LiderazgosCamp"){ ?>
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

                <?php if($amLiderazgosCampR==1){ ?>
            

                            <?php if($url=="LiderazgosCamp" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=LiderazgosCamp&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=LiderazgosCamp&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php if($amLiderazgosCampC==1){ ?>


                              <?php if($url=="LiderazgosCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=LiderazgosCamp"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=LiderazgosCamp"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php } ?>

                            
               <?php } ?>
          </ul>
        </li>
            <?php } ?>

      <!-- ======================================================================================================================= -->




      <!-- ======================================================================================================================= -->
                    <!--  DESPACHOS   -->
      <!-- ======================================================================================================================= -->

                            <?php if($url=="Despachos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Despachos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                            <?php if($url=="Despachos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Despachos&action=Registrar"><i class="fa fa-tag"></i> Registrar Despacho</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Despachos&action=Registrar"><i class="fa fa-tag"></i> Registrar Despacho</a></li>
                            <?php } ?>

                            <?php if($url=="Despachos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Despachos"><i class="fa fa-tag"></i> Ver Despachos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Despachos"><i class="fa fa-tag"></i> Ver Despachos</a></li>
                            <?php } ?>
          </ul>
        </li>

      <!-- ======================================================================================================================= -->





      <!-- ======================================================================================================================= -->
                    <!--  Movimientos   -->
      <!-- ======================================================================================================================= -->
        <?php 
              $amMovimientos = 0;
              $amMovimientosR = 0;
              $amMovimientosC = 0;
              $amMovimientosE = 0;
              $amMovimientosB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Movimientos Bancarios"){
                    $amMovimientos = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amMovimientosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amMovimientosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amMovimientosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amMovimientosB = 1;
                    }
                  }
                }
              }
              if($amMovimientos == 1){
          ?>
                            <?php if($url=="Movimientos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Movimientos Bancarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
      <!-- ======================================================================================================================= -->
                 <?php if($amMovimientosR==1){ ?>


                            <?php if($url=="Movimientos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Movimientos&action=Registrar"><i class="fa fa-file-text"></i> Registrar Movimiento</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Movimientos&action=Registrar"><i class="fa fa-file-text"></i> Registrar Movimiento</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php if($amMovimientosC==1){ ?>

                               <?php if($url=="Movimientos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Movimientos"><i class="fa fa-list-alt"></i> Ver Movimientos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Movimientos"><i class="fa fa-list-alt"></i> Ver Movimientos</a></li>
                            <?php } ?>


                   <?php } ?>
          </ul>
        </li>
            <?php } ?>

      <!-- ======================================================================================================================= -->



        <li>
          <a href="?route=home">
            <i class="fa fa-reply"></i> <span>Salir de campaña</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>


      <!-- ======================================================================================================================= -->



      <!-- ======================================================================================================================= -->



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
        <?php 
              $amClientes = 0;
              $amClientesR = 0;
              $amClientesC = 0;
              $amClientesE = 0;
              $amClientesB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Clientes"){
                    $amClientes = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amClientesR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amClientesC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amClientesE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amClientesB = 1;
                    }

                  }
                }
              }
              if($amClientes == 1){
          ?>

                            <?php if($url=="Clientes"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-users"></i> <span>Clientes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <?php if($amClientesR==1){ ?>
                            <?php if($url=="Clientes" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Cliente</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Cliente</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amClientesC==1){ ?>

                            <?php if($url=="Clientes" && empty($action)){ ?>
            <li class="active"><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Clientes</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Clientes</a></li>
                            <?php } ?>
                <?php } ?>
          </ul>
        </li>


            <?php } ?>
      <!-- ======================================================================================================================= -->








      <!-- ======================================================================================================================= -->
                    <!--  Tasa Dolar   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amTasas = 0;
              $amTasasR = 0;
              $amTasasC = 0;
              $amTasasE = 0;
              $amTasasB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Tasas"){
                    $amTasas = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amTasasR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amTasasC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amTasasE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amTasasB = 1;
                    }
                  }
                }
              }
              if($amTasas == 1){
          ?>
                            <?php if($url=="Tasas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-rocket"></i> <span>Tasas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <?php if($amTasasR==1){ ?>


                            <?php if($url=="Tasas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Tasas&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Tasa</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Tasas&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Tasa</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amTasasC==1){ ?>


                              <?php if($url=="Tasas" && empty($action)){ ?>
            <li class="active"><a href="?route=Tasas"><i class="fa fa-fighter-jet"></i> Ver Tasas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Tasas"><i class="fa fa-fighter-jet"></i> Ver Tasas</a></li>
                            <?php } ?>

                <?php } ?>
                            
          </ul>
        </li>
         <?php } ?>
    
      <!-- ======================================================================================================================= -->











      <!-- ======================================================================================================================= -->
                    <!--  CAMPANAS   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amCampanas = 0;
              $amCampanasR = 0;
              $amCampanasC = 0;
              $amCampanasE = 0;
              $amCampanasB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Campañas"){
                    $amCampanas = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amCampanasR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amCampanasC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amCampanasE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amCampanasB = 1;
                    }
                  }
                }
              }
              if($amCampanas == 1){
          ?>

                            <?php if($url=="Campanas"){ ?>
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
                <?php if($amCampanasR==1){ ?>

                            <?php if($url=="Campanas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Campanas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Campaña</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Campanas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Campaña</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amCampanasC==1){ ?>


                            <?php if($url=="Campanas" && empty($action)){ ?>
            <li class="active"><a href="?route=Campanas"><i class="fa fa-puzzle-piece"></i> Ver Campañas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Campanas"><i class="fa fa-puzzle-piece"></i> Ver Campañas</a></li>
                            <?php } ?>

                <?php } ?>
          </ul>
        </li> 

            <?php } ?>


        <!-- ======================================================================================================================= -->





        <!-- ======================================================================================================================= -->
                      <!--  PRODUCTOS   -->
        <!-- ======================================================================================================================= -->
          <?php 
              $amProductos = 0;
              $amProductosR = 0;
              $amProductosC = 0;
              $amProductosE = 0;
              $amProductosB = 0;
              $amFragancias = 0;
              $amFraganciasR = 0;
              $amFraganciasC = 0;
              $amFraganciasE = 0;
              $amFraganciasB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Productos"){
                    $amProductos = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amProductosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amProductosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amProductosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amProductosB = 1;
                    }
                  }
                  if($access['nombre_modulo'] == "Fragancias"){
                    $amFragancias = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amFraganciasR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amFraganciasC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amFraganciasE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amFraganciasB = 1;
                    }
                  }
                }
              }
              if($amProductos == 1){
          ?>
                            <?php if($url=="Productos" || $url=="Fragancias"){ ?>
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

                <?php if($amProductosR==1){ ?>

                            <?php if($url=="Productos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Productos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Productos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amProductosC==1){ ?>

                            <?php if($url=="Productos" && empty($action)){ ?>
            <li class="active"><a href="?route=Productos"><i class="fa fa-archive"></i> Ver Productos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Productos"><i class="fa fa-archive"></i> Ver Productos</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amFraganciasC==1){ ?>

                            <?php if($url=="Fragancias" && empty($action)){ ?>
            <li class="active"><a href="?route=Fragancias"><i class="fa fa-diamond"></i> Fragancias</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Fragancias"><i class="fa fa-diamond"></i> Ver Fragancias</a></li>
                            <?php } ?>
                <?php } ?>
          </ul>
        </li>
            <?php } ?>

      <!-- ======================================================================================================================= -->





      <!-- ======================================================================================================================= -->
                    <!--  PLANES   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amPlanes = 0;
              $amPlanesR = 0;
              $amPlanesC = 0;
              $amPlanesE = 0;
              $amPlanesB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Planes"){
                    $amPlanes = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amPlanesR = 1;
                    }
                    if
                      ($access['nombre_permiso'] == "Ver"){
                      $amPlanesC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amPlanesE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amPlanesB = 1;
                    }
                  }
                }
              }
              if($amPlanes == 1){
          ?>
                            <?php if($url=="Planes"){ ?>
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

                <?php if($amProductosR==1){ ?>


                            <?php if($url=="Planes" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Planes&action=Registrar"><i class="fa fa-star-o"></i> Registrar Plan</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Planes&action=Registrar"><i class="fa fa-star-o"></i> Registrar Plan</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amProductosC==1){ ?>


                              <?php if($url=="Planes" && empty($action)){ ?>
            <li class="active"><a href="?route=Planes"><i class="fa fa-star-o"></i> Ver Planes</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Planes"><i class="fa fa-star-o"></i> Ver Planes</a></li>
                            <?php } ?>

                <?php } ?>
                            
          </ul>
        </li>
            <?php } ?>

        <!-- ======================================================================================================================= -->





        <!-- ======================================================================================================================= -->
                      <!--  Premios   -->
        <!-- ======================================================================================================================= -->
          <?php 
              $amPremios = 0;
              $amPremiosR = 0;
              $amPremiosC = 0;
              $amPremiosE = 0;
              $amPremiosB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Premios"){
                    $amPremios = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amPremiosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amPremiosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amPremiosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amPremiosB = 1;
                    }
                  }
                }
              }
              if($amPremios == 1){
          ?>

                            <?php if($url=="Premios"){ ?>
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

                <?php if($amPremiosR==1){ ?>
            

                            <?php if($url=="Premios" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Premios&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Premio</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Premios&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Premio</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php if($amPremiosC==1){ ?>


                              <?php if($url=="Premios" && empty($action)){ ?>
            <li class="active"><a href="?route=Premios"><i class="fa fa-fighter-jet"></i> Ver Premios</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Premios"><i class="fa fa-fighter-jet"></i> Ver Premios</a></li>
                            <?php } ?>

                            
               <?php } ?>
          </ul>
        </li>
            <?php } ?>

      <!-- ======================================================================================================================= -->







      <!-- ======================================================================================================================= -->
                    <!--  LIDERAZGOS   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amLiderazgos = 0;
              $amLiderazgosR = 0;
              $amLiderazgosC = 0;
              $amLiderazgosE = 0;
              $amLiderazgosB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Liderazgos"){
                    $amLiderazgos = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amLiderazgosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amLiderazgosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amLiderazgosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amLiderazgosB = 1;
                    }
                  }
                }
              }
              if($amLiderazgos == 1){
          ?>

                            <?php if($url=="Liderazgos"){ ?>
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

                <?php if($amLiderazgosR==1){ ?>
            

                            <?php if($url=="Liderazgos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php if($amLiderazgosC==1){ ?>


                              <?php if($url=="Liderazgos" && empty($action)){ ?>
            <li class="active"><a href="?route=Liderazgos"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Liderazgos"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                            <?php } ?>

                            
               <?php } ?>
          </ul>
        </li>
            <?php } ?>

      <!-- ======================================================================================================================= -->





      <!-- ======================================================================================================================= -->
                    <!--  BANCOS   -->
      <!-- ======================================================================================================================= -->
        <?php 
              $amBancos = 0;
              $amBancosR = 0;
              $amBancosC = 0;
              $amBancosE = 0;
              $amBancosB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Bancos"){
                    $amBancos = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amBancosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amBancosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amBancosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amBancosB = 1;
                    }
                  }
                }
              }
              if($amBancosC == 1){
          ?>
                            <?php if($url=="Bancos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="">
                            <?php } ?>
          <a href="?route=Bancos">
            <i class="fa fa-bank"></i> <span>Bancos</span>
          </a>
        </li>
                 
            <?php } ?>

      <!-- ======================================================================================================================= -->






      <!-- ======================================================================================================================= -->
                    <!--  USUARIOS   -->
      <!-- ======================================================================================================================= -->
          <?php 
              $amUsuarios = 0;
              $amUsuariosR = 0;
              $amUsuariosC = 0;
              $amUsuariosE = 0;
              $amUsuariosB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Usuarios"){
                    $amUsuarios = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amUsuariosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amUsuariosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amUsuariosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amUsuariosB = 1;
                    }
                  }
                }
              }
              if($amUsuarios == 1){
          ?>
                            <?php if($url=="Usuarios"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <?php if($amUsuariosR==1){ ?>


                            <?php if($url=="Usuarios" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Usuarios&action=Registrar"><i class="fa fa-cog"></i> Registrar Usuario</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Usuarios&action=Registrar"><i class="fa fa-cog"></i> Registrar Usuario</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amUsuariosC==1){ ?>


                            <?php if($url=="Usuarios" && empty($action)){ ?>
            <li class="active"><a href="?route=Usuarios"><i class="fa fa-cog"></i> Ver Usuarios</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Usuarios"><i class="fa fa-cog"></i> Ver Usuarios</a></li>
                            <?php } ?>
                <?php } ?>
                            
          </ul>
        </li>
         <?php } ?>
      <!-- ======================================================================================================================= -->




      <!-- ======================================================================================================================= -->
                    <!--  REPORTES   -->
      <!-- ======================================================================================================================= -->
            <?php 
              $amReportes = 0;
              $amReportesC = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Reportes"){
                    $amReportes = 1;
                    if($access['nombre_permiso'] == "Ver"){
                      $amReportesC = 1;
                    }
                  }
                }
              }
              if($amReportesC == 1){
          ?>
                  <?php if($url == "Reportes"){ ?>
                    <li class="active">
                  <?php }else{ ?>
                    <li>
                  <?php } ?>
                      <a href="?route=Reportes">
                        <i class="fa fa-home"></i> <span>Reportes</span>
                        <span class="pull-right-container">
                          <!-- <small class="label pull-right bg-green">new</small> -->
                        </span>
                      </a>
                    </li>
                <?php } ?>

      <!-- ======================================================================================================================= -->




      <!-- ======================================================================================================================= -->
  
  
        <?php 
              $amSeguridad = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Bitácora" || $access['nombre_modulo'] == "Roles" || $access['nombre_modulo'] == "Modulos" || $access['nombre_modulo'] == "Permisos"){
                    $amSeguridad = 1;
                    
                  }
                }
              }
              if($amSeguridad == 1){
          ?>    
        <li class="header">SEGURIDAD</li>


      <!-- ======================================================================================================================= -->
                    <!--  PERMISOS   -->
      <!-- ======================================================================================================================= -->
            
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

            <!-- ======================================================================================================================= -->
                          <!--  BIRACORA   -->
            <!-- ======================================================================================================================= -->
            <?php 
              $amBitacora = 0;
              $amBitacoraC = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Bitácora"){
                    $amBitacora = 1;
                    if($access['nombre_permiso'] == "Ver"){
                      $amBitacoraC = 1;
                    }
                  }
                }
              }
              if($amBitacoraC == 1){
          ?>
                  <?php if($url == "Bitacora"){ ?>
                    <li class="active">
                  <?php }else{ ?>
                    <li>
                  <?php } ?>
                      <a href="?route=Bitacora">
                        <i class="fa fa-home"></i> <span>Bitacora</span>
                        <span class="pull-right-container">
                          <!-- <small class="label pull-right bg-green">new</small> -->
                        </span>
                      </a>
                    </li>
                <?php } ?>

            <!-- ======================================================================================================================= -->



            <!-- ======================================================================================================================= -->
                          <!--  PERMISOS   -->
            <!-- ======================================================================================================================= -->
                        <?php 
                          $amPermisos = 0;
                          $amPermisosR = 0;
                          $amPermisosC = 0;
                          $amPermisosE = 0;
                          $amPermisosB = 0;
                          foreach ($accesos as $access) {
                            if(!empty($access['id_acceso'])){
                              if($access['nombre_modulo'] == "Permisos"){
                                $amPermisos = 1;
                                if($access['nombre_permiso'] == "Registrar"){
                                  $amPermisosR = 1;
                                }
                                if($access['nombre_permiso'] == "Ver"){
                                  $amPermisosC = 1;
                                }
                                if($access['nombre_permiso'] == "Editar"){
                                  $amPermisosE = 1;
                                }
                                if($access['nombre_permiso'] == "Borrar"){
                                  $amPermisosB = 1;
                                }
                              }
                            }
                          }
                          if($amPermisos == 1){
                      ?>

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
                            
                            <?php if($amPermisosR==1){ ?>


                                        <?php if($url=="Permisos" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Permisos&action=Registrar"><i class="fa fa-cog"></i> Registrar Permiso</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Permisos&action=Registrar"><i class="fa fa-cog"></i> Registrar Permiso</a></li>
                                        <?php } ?>

                            <?php } ?>
                            <?php if($amPermisosC==1){ ?>

                                        <?php if($url=="Permisos" && empty($action)){ ?>
                        <li class="active"><a href="?route=Permisos"><i class="fa fa-cog"></i> Ver Permisos</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Permisos"><i class="fa fa-cog"></i> Ver Permisos</a></li>
                                        <?php } ?>
                            <?php } ?>
                            
                      </ul>
                    </li>
                     <?php } ?>
            <!-- ======================================================================================================================= -->



            <!-- ======================================================================================================================= -->
                          <!--  MODULOS   -->
            <!-- ======================================================================================================================= -->
                        <?php 
                          $amModulos = 0;
                          $amModulosR = 0;
                          $amModulosC = 0;
                          $amModulosE = 0;
                          $amModulosB = 0;
                          foreach ($accesos as $access) {
                            if(!empty($access['id_acceso'])){
                              if($access['nombre_modulo'] == "Modulos"){
                                $amModulos = 1;
                                if($access['nombre_permiso'] == "Registrar"){
                                  $amModulosR = 1;
                                }
                                if($access['nombre_permiso'] == "Ver"){
                                  $amModulosC = 1;
                                }
                                if($access['nombre_permiso'] == "Editar"){
                                  $amModulosE = 1;
                                }
                                if($access['nombre_permiso'] == "Borrar"){
                                  $amModulosB = 1;
                                }
                              }
                            }
                          }
                          if($amModulos == 1){
                      ?>

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
                            
                            <?php if($amModulosR==1){ ?>

                                        <?php if($url=="Modulos" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Modulos&action=Registrar"><i class="fa fa-cog"></i> Registrar Modulo</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Modulos&action=Registrar"><i class="fa fa-cog"></i> Registrar Modulo</a></li>
                                        <?php } ?>
                            <?php } ?>
                            <?php if($amModulosC==1){ ?>

                                        <?php if($url=="Modulos" && empty($action)){ ?>
                        <li class="active"><a href="?route=Modulos"><i class="fa fa-cog"></i> Ver Modulos</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Modulos"><i class="fa fa-cog"></i> Ver Modulos</a></li>
                                        <?php } ?>
                            <?php } ?>

                      </ul>
                    </li>
                      <?php } ?>
            <!-- ======================================================================================================================= -->






            <!-- ======================================================================================================================= -->
                          <!--  ROLES   -->
            <!-- ======================================================================================================================= -->
                        <?php 
                          $amRoles = 0;
                          $amRolesR = 0;
                          $amRolesC = 0;
                          $amRolesE = 0;
                          $amRolesB = 0;
                          foreach ($accesos as $access) {
                            if(!empty($access['id_acceso'])){
                              if($access['nombre_modulo'] == "Modulos"){
                                $amRoles = 1;
                                if($access['nombre_permiso'] == "Registrar"){
                                  $amRolesR = 1;
                                }
                                if($access['nombre_permiso'] == "Ver"){
                                  $amRolesC = 1;
                                }
                                if($access['nombre_permiso'] == "Editar"){
                                  $amRolesE = 1;
                                }
                                if($access['nombre_permiso'] == "Borrar"){
                                  $amRolesB = 1;
                                }
                              }
                            }
                          }
                          if($amRoles == 1){
                      ?>

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

                            <?php if($amRolesR == 1){ ?>


                                        <?php if($url=="Roles" && !empty($action) && $action == "Registrar"){ ?>
                        <li class="active"><a href="?route=Roles&action=Registrar"><i class="fa fa-cog"></i> Registrar Rol</a></li>
                                        <?php }else{ ?>
                        <li class=""><a href="?route=Roles&action=Registrar"><i class="fa fa-cog"></i> Registrar Rol</a></li>
                                        <?php } ?>

                            <?php } ?>
                            <?php if($amRolesC == 1){ ?>


                                        <?php if($url=="Roles" && empty($action)){ ?>
                        <li class="active"><a href="?route=Roles"><i class="fa fa-cog"></i> Ver Roles</a></li>
                                        <?php }else{ ?>
                        <li><a href="?route=Roles"><i class="fa fa-cog"></i> Ver Roles</a></li>
                                        <?php } ?>

                            <?php } ?>
                      </ul>
                    </li>
                      <?php } ?>
            <!-- ======================================================================================================================= -->
              <?php } ?>


          </ul>
        </li>

      <!-- ======================================================================================================================= -->









             
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>