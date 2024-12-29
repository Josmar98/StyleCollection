  <!-- <aside class="main-header" style="position:fixed;min-height:100vh;max-height:100vh;width:18.3%;overflow:auto;top:0%;z-index:0"> -->
  <aside class="main-sidebar" style="box-sizing:border-box;">
      
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
<?php 
if(!empty($_GET['campaing']) && !empty($_GET['n']) && !empty($_GET['y']) && !empty($_GET['dp'])){
  $campaing = $_GET['campaing'];
  $n = $_GET['n'];
  $y = $_GET['y'];
  $dp = $_GET['dp'];
  $dpid = $_GET['dpid'];
  $menu = "campaing=".$campaing."&n=".$n."&y=".$y."&dpid=".$dpid."&dp=".$dp;
  $menu2 = "campaing=".$campaing."&n=".$n."&y=".$y;

  $desp = $lider->consultarQuery("SELECT * FROM despachos WHERE estatus = 1 and id_despacho = {$dpid}");
  $desp = $desp[0];

  $pedd = $lider->consultarQuery("SELECT * FROM pedidos WHERE estatus = 1 and id_despacho = {$id_despacho} and id_cliente = {$_SESSION['id_cliente']}");

  $cols = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$dpid} and pedidos.id_cliente = {$_SESSION['id_cliente']}");
  $prems = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$dpid} and pedidos.id_cliente = {$_SESSION['id_cliente']}");


  $pppedi = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = {$_SESSION['id_cliente']}");

  if(count($pppedi)>1){$pppedi=$pppedi[0];}else{$pppedi['id_pedido']=0;}
  $ddeess = $lider->consultarQuery("SELECT * FROM notificar_desperfectos, productos, desperfectos WHERE notificar_desperfectos.id_producto = productos.id_producto and notificar_desperfectos.id_desperfecto = desperfectos.id_desperfecto and notificar_desperfectos.id_pedido = {$pppedi['id_pedido']}");
  $desperfectosss = $lider->consultarQuery("SELECT * FROM desperfectos WHERE id_campana = {$id_campana}");
  // print_r($desperfectosss);
  if(Count($desperfectosss)>1){$desperfectosss=$desperfectosss[0];}
  // print_r();
  // print_r($desp['limite_seleccion_plan']);
  $desperfectss = $lider->consultarQuery("SELECT * FROM desperfectos WHERE estatus = 1 and id_campana = {$id_campana}");
?>  
<style>
.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #024;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#135;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #357;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #135;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #359;}

/*
.main-header{background:#000}
.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #906;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#a17;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #805;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #a17;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #805;}*/

/*.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #000;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#111;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #333;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #111;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #333;}*/

.color-corto{  color:#EA018C;}
.color-completo{  color:#FFF;}
/*.logo{ background:rgba(255,255,255,.05) !important; }*/
.skin-blue .sidebar a {  color: #FFF;}
.skin-blue .user-panel > .info,.skin-blue .user-panel > .info > a {  color: #fff;}
.skin-blue .sidebar a:hover {  text-decoration: none;}
.skin-blue .sidebar-menu .treeview-menu > li.active > a,.skin-blue .sidebar-menu .treeview-menu > li > a:hover {  color: #FFF;}
.skin-blue .sidebar-menu .treeview-menu > li > a {  color: #aaa;}
.main-footer{background: #000;}
.main-footer .string{color:#FFF;}
.control-sidebar-dark, div.control-sidebar-bg, .control-sidebar-tabs li.active a{color:#FFF;background:#000 !important;}
.control-sidebar-tabs a{background:rgba(255,255,255,.05) !important;color:#ddd !important;}
.tab-pane li a:hover p, .tab-pane li a:hover h3, .tab-pane li a:hover h4, .tab-pane li a:hover label{color:#ddd !important;}
.tab-pane li a:hover{background:#111 !important; color:#FFF !important;}
.tab-content p, .tab-content h3, .tab-content h4, .tab-content label{color:#DDD !important;}
.skin-blue .sidebar-menu .treeview-menu2 > li > a{background:#212121 !important}
</style>
        <li class="header">PEDIDOS DE CAMPAÑA <?php echo $n."-".$y ?></li>
        <!-- <li class="header">CAMPAÑA <?php echo $n."-".$y ?> DESPACHO <?php echo $dp ?></li> -->
    

      <?php if($url == "Homing2"){ ?>
        <li class="active">
      <?php }else{ ?>
        <li>
      <?php } ?>
          <a href="?<?php echo $menu ?>&route=Homing2">
            <i class="fa fa-dashboard"></i> <span>Pedidos de Campaña</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>
        <?php
          $ndp = "";
          if($dp=="1"){ $ndp = "1er"; }
          if($dp=="2"){ $ndp = "2do"; }
          if($dp=="3"){ $ndp = "3er"; }
          if($dp=="4"){ $ndp = "4to"; }
          if($dp=="5"){ $ndp = "5to"; }
          if($dp=="6"){ $ndp = "6to"; }
          if($dp=="7"){ $ndp = "7mo"; }
          if($dp=="8"){ $ndp = "8vo"; }
          if($dp=="9"){ $ndp = "9no"; }
        ?>


<!-- ======================================================================================================================= -->
              <!--  COLECCIONES   -->
<!-- ======================================================================================================================= -->

        <?php 
              $amColecciones = 0;
              $amColeccionesR = 0;
              $amColeccionesC = 0;
              $amColeccionesE = 0;
              $amColeccionesB = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Despachos"){
                    $amColecciones = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amColeccionesR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amColeccionesC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amColeccionesE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amColeccionesB = 1;
                    }
                  }
                }
              }
              if($amColecciones == 1){
          ?>
                            <?php if($url=="Colecciones"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="?<?php echo $menu ?>&route=Colecciones">
            <i class="fa fa-folder"></i> <span>Colecciones Adicionales
             <!-- <?=$n?><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$ndp;?> Pedido -->
           </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                
                <?php  if($amColeccionesR == 1){ ?>
                
                            <?php if($url=="Colecciones" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Colecciones&action=Registrar"><i class="fa fa-folder-o"></i> Registrar Colección</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Colecciones&action=Registrar"><i class="fa fa-folder-o"></i> Registrar Colección</a></li>
                            <?php } ?>

                <?php } ?>
                <?php  if($amColeccionesC == 1){ ?>


                            <?php if($url=="Colecciones" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Colecciones"><i class="fa fa-folder-o"></i> Ver Colecciones</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Colecciones"><i class="fa fa-folder-o"></i> Ver Colecciones</a></li>
                            <?php } ?>
                
                <?php } ?>

          </ul>
        </li>
          <?php } ?>

<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  PROMOCIONES   -->
<!-- ======================================================================================================================= -->
    <?php 
      $promocionLimitadaPorPedidoAprobado=0;
      $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
      foreach ($configuraciones as $config) {
        if($config['clausula']=='Promocion Limitada Por Pedido Aprobado'){
          $promocionLimitadaPorPedidoAprobado = $config['valor'];
        }
      }

      $promos = $lider->consultarQuery("SELECT * FROM promocion WHERE estatus = 1 and id_campana = {$id_campana}");
      $mostrarMenuPromociones = false;
      if(count($promos)>1){
        $mostrarMenuPromociones = true;
      }else{
        $mostrarMenuPromociones = false;
      }
      if($mostrarMenuPromociones){
        $claseActivePromo = "";
        if($url == "Promociones"){
          $claseActivePromo = "active";
        }else{
          $claseActivePromo = "";
        }
        $mostrarOpcionPromociones = false;
        if($_SESSION['nombre_rol']!="Vendedor"){
          $mostrarOpcionPromociones = true;
        }else{
          if($_SESSION['nombre_rol']=="Conciliador"){
            $mostrarOpcionPromociones = false;
          }
          if($promocionLimitadaPorPedidoAprobado==1){
            if($pppedi['cantidad_aprobado']>0){
              $mostrarOpcionPromociones = true;
            }else{
              $mostrarOpcionPromociones = false;
            }
          }else{
            $mostrarOpcionPromociones = true;
          }
        }
        if($mostrarOpcionPromociones){
          ?>
          <li class="<?=$claseActivePromo; ?>">
            <a href="?<?php echo $menu ?>&route=Promociones">
              <i class="fa fa-dashboard"></i> <span>Promociones de Campaña</span>
              <span class="pull-right-container">
                <!-- <small class="label pull-right bg-green">new</small> -->
              </span>
            </a>
          </li>
            <?php
        } 
      } 
    ?>


<!-- ======================================================================================================================= -->



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
            <i class="fa fa-tags"></i> <span>Planes de Campaña <?=$n?><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$ndp;?> Pedido</span>
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
            <i class="fa fa-tags"></i> <span>Premios de Campaña <?=$n?><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$ndp;?> Pedido</span>
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
            <i class="fa fa-bookmark"></i> <span>Liderazgos de Campaña <?=$n?><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$ndp;?> Pedido</span>
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
              <!--  CONFIG. NOTA DE ENTREGA   -->
<!-- ======================================================================================================================= -->

      <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"): ?>

                            <?php if($url=="ConfigNota"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Config. Nota de Entrega <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <?=$ndp;?> Pedido</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
              <?php if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor2"): ?>
                
                            <?php if($url=="ConfigNota" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ConfigNota&action=Registrar"><i class="fa fa-tag"></i> Registrar Config. de Nota</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=ConfigNota&action=Registrar"><i class="fa fa-tag"></i> Registrar Config. de Nota</a></li>
                            <?php } ?>
              <?php endif; ?>

                            <?php if($url=="ConfigNota" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ConfigNota"><i class="fa fa-tag"></i> Ver Config. de Nota</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=ConfigNota"><i class="fa fa-tag"></i> Ver Config. de Nota</a></li>
                            <?php } ?>
          </ul>

        </li>

      <?php endif; ?>


<!-- ======================================================================================================================= -->




  




<!-- ======================================================================================================================= -->
       <!-- PLANES Y PREMIOS DE COLECCIONES    -->
<!-- ======================================================================================================================= -->
                           <?php if($url=="PlanCol" || $url=="PremioCol"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-th-large"></i> <span>Planes y Premios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                          <?php if(date('Y-m-d') >= $desp['apertura_seleccion_plan'] && date('Y-m-d') <= $desp['limite_seleccion_plan']){ $limittteee = "1"; }else{$limittteee = "0";} ?>
                <?php 
                  // echo "Apertura: ".$desp['apertura_seleccion_plan'];
                  // echo "<br>";
                  // echo "Limite: ".$desp['limite_seleccion_plan'];
                  // echo "<br>";
                  // echo "Limite: ".$limittteee;
                 ?>
                          <?php //if(date('Y-m-d') <= $desp['limite_seleccion_plan']): //IF PARA QUE SEA MENOR AL TIEMPO LIMITE ?>
                          <?php //endif; ?>
                            <?php if($url=="PlanCol" && !empty($action) && $action == "Registrar"){ ?>
              <li class="active" ><a <?php if(Count($cols)>1 || Count($pedd)<2 || $limittteee=="0"): ?>style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PlanCol&action=Registrar" <?php endif; ?> ><i class="fa fa-th"></i> Seleccionar Planes</a></li>
                            <?php }else{ ?>
            <li class="" ><a <?php if(Count($cols)>1 || Count($pedd)<2 || $limittteee=="0"): ?>style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PlanCol&action=Registrar" <?php endif; ?> ><i class="fa fa-th"></i> Seleccionar Planes</a></li>
                            <?php } ?>
                      

                            <?php if($url=="PlanCol" && empty($action)){ ?>
            <li class="active"><a <?php if(Count($cols)<2): ?>style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PlanCol" <?php endif; ?>><i class="fa fa-th"></i> Planes Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a <?php if(Count($cols)<2): ?>style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PlanCol" <?php endif; ?>><i class="fa fa-th"></i> Planes Seleccionados</a></li>
                            <?php } ?>

                      
                          <?php //if(date('Y-m-d') <= $desp['limite_seleccion_plan']): //IF PARA QUE SEA MENOR AL TIEMPO LIMITE ?>
                          <?php //endif; ?>
                            <?php if($url=="PremioCol" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a <?php if(Count($prems)>1 || Count($cols)<2 || $limittteee=="0"): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PremioCol&action=Registrar"<?php endif; ?> ><i class="fa fa-th"></i> Seleccionar Premios</a></li>
                            <?php }else{ ?>
            <li><a <?php if(Count($prems)>1 || Count($cols)<2 || $limittteee=="0"): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PremioCol&action=Registrar"<?php endif; ?> ><i class="fa fa-th"></i> Seleccionar  Premios</a></li>
                            <?php } ?>


                            <?php if($url=="PremioCol" && empty($action)){ ?>
            <li class="active"><a <?php if(Count($prems)<2): ?>  style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PremioCol" <?php endif; ?> ><i class="fa fa-th"></i> Premios Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a <?php if(Count($prems)<2): ?>  style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=PremioCol" <?php endif; ?> ><i class="fa fa-th"></i>Premios Seleccionados</a></li>
                            <?php } ?>

          </ul>

        </li>
<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  PREMIOS PERDIDOS   -->
<!-- ======================================================================================================================= -->
    <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>


                           <?php if($url=="PremiosPerdidos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-folder-o"></i> <span>Premios perdidos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                            <?php if($url=="PremiosPerdidos" && !empty($action) && $action == "Registrar"){ ?>
              <li class="active"><a href="?<?php echo $menu ?>&route=PremiosPerdidos&action=Registrar"  ><i class="fa fa-folder"></i> Seleccionar Premios <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp perdidos</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PremiosPerdidos&action=Registrar"  ><i class="fa fa-folder"></i> Seleccionar Premios <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp perdidos</a></li>
                            <?php } ?>
                      

                            <?php if($url=="PremiosPerdidos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosPerdidos" ><i class="fa fa-folder"></i> Premios perdidos <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PremiosPerdidos" ><i class="fa fa-folder"></i> Premios perdidos <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Seleccionados</a></li>
                            <?php } ?>

          </ul>

        </li>

    <?php } ?> 
    
<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  RETOS   -->
<!-- ======================================================================================================================= -->
  <?php 
    if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){
      $despss = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$_GET['dpid']}");
   ?>
        <?php if ($despss[0]['numero_despacho']=="1"): ?>
          
                           <?php if($url=="Retos" || $url=="MisRetos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-motorcycle"></i> <span>Retos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                            <?php if($url=="Retos" && !empty($action) && $action == "Registrar"){ ?>
              <li class="active"><a href="?<?php echo $menu ?>&route=Retos&action=Registrar"  ><i class="fa fa-motorcycle"></i> Seleccionar Reto</a></li>
                            <?php }else{ ?>
              <li class=""><a href="?<?php echo $menu ?>&route=Retos&action=Registrar"  ><i class="fa fa-motorcycle"></i> Seleccionar reto</a></li>
                            <?php } ?>
                      
            <?php if ($_SESSION['nombre_rol']!="Vendedor"): ?>
              
                            <?php if($url=="Retos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Retos" ><i class="fa fa-motorcycle"></i> Ver retos </a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Retos"><i class="fa fa-motorcycle"></i> Ver retos </a></li>
                            <?php } ?>
            <?php endif; ?>

            <?php if($_SESSION['cuenta']['estatus']=="1"){ ?>
                            <?php if($url=="MisRetos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=MisRetos" ><i class="fa fa-motorcycle"></i> Ver mis retos </a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=MisRetos"><i class="fa fa-motorcycle"></i> Ver mis retos </a></li>
                            <?php } ?>
            <?php } ?>

          </ul>

        </li>
        <?php endif; ?>
        
  <?php 
      }
  ?>
<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
              <!--  Notificar Desperfectos   -->
<!-- ======================================================================================================================= -->
                      
                      <?php 
                        if(count($desperfectss)>1){
                      $limteDesperfectos="0";
                      if((!empty($desperfectosss['fecha_inicio_desperfecto']) && date('Y-m-d') < $desperfectosss['fecha_inicio_desperfecto']) || (!empty($desperfectosss['fecha_fin_desperfecto']) && date('Y-m-d') > $desperfectosss['fecha_fin_desperfecto']) ){$limteDesperfectos="1";}else{$limteDesperfectos="0";} ?>
                            <?php if($url=="DesperfectosNotif"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Notificar Desperfectos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                            <?php if($url=="DesperfectosNotif" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a <?php if ((count($ddeess)>1) || Count($pedd)<2 || $limteDesperfectos=="1"): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=DesperfectosNotif&action=Registrar" <?php endif ?>><i class="fa fa-tag"></i> Notificar Desperfecto</a></li>
                            <?php }else{ ?>
            <li class=""><a <?php if ((count($ddeess)>1) || Count($pedd)<2 || $limteDesperfectos=="1"): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=DesperfectosNotif&action=Registrar" <?php endif ?>><i class="fa fa-tag"></i> Notificar Desperfecto</a></li>
                            <?php } ?>

                            <?php if($url=="DesperfectosNotif" && empty($action)){ ?>
            <li class="active"><a <?php if (count($ddeess)<2): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=DesperfectosNotif" <?php endif ?>><i class="fa fa-tag"></i> Ver Desperfectos</a></li>
                            <?php }else{ ?>
            <li><a <?php if (count($ddeess)<2): ?> style="color:#676767;cursor:default;" <?php else: ?> href="?<?php echo $menu ?>&route=DesperfectosNotif" <?php endif ?>><i class="fa fa-tag"></i> Ver Desperfectos</a></li>
                            <?php } ?>
          </ul>

        </li>
                  <?php } ?>
<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
      <!-- PAGOS -->
<!-- ======================================================================================================================= -->
    <?php 
      $optHabilitarPagos = "0";
      $camppagos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana=despachos.id_campana and campanas.visibilidad = '1' ORDER BY campanas.id_campana DESC");
      if(count($camppagos)>1){
        $camppago = $camppagos[0];
        $pedpagos = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_cliente = {$_SESSION['id_cliente']} and despachos.id_campana = {$camppago['id_campana']}");
        // $pedpagos = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_cliente = {$_SESSION['id_cliente']} and pedidos.id_despacho = {$camppago['id_despacho']}");
        // echo count($pedpagos);

        if(count($pedpagos)>1){
          $pedpago = $pedpagos[0];
          if($pedpago['cantidad_aprobado']>0){
            if($camppago['id_despacho'] == $id_despacho){
              $optHabilitarPagos = "1";
            }
            // echo $camppago['id_despacho'];
            // echo $id_despacho;
          }
          // echo $pedpago['cantidad_aprobado'];
          // print_r($pedpago);
        }
      }
      // echo $optHabilitarPagos;

    ?>
    
    <?php
      $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
      $estado_campana = $estado_campana2[0]['estado_campana'];
      // echo "<h1>".$estado_campana."</h1>";
    ?>

    <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador" || $_SESSION['nombre_rol']=="Vendedor"): ?>
      
                            <?php if($url=="Pagos" || $url=="PagosA" || $url=="Pagoss" || $url=="PagossA" || $url=="ReportePagos" || $url=="PagosBancarios" || $url=="PagosBolivares" || $url=="PagosDivisas" || $url=="PagosBorrados" || $url=="MisPagos" || $url=="MisPagosBancarios" || $url=="MisPagosBolivares" || $url=="MisPagosDivisas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-dollar"></i> <span>Pagos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php  ?>
          <ul class="treeview-menu">
            <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){ ?>
                              <?php if($url=="Pagos" && !empty($action) && $action == "RegistrarAutorizados"){ ?>
              <li class="active"><a href="?<?php echo $menu ?>&route=Pagos&action=RegistrarAutorizados&admin=1&select=0"><i class="fa fa-money"></i> Registrar Pagos Autorizados</a></li>
                              <?php }else{ ?>
              <li class=""><a href="?<?php echo $menu ?>&route=Pagos&action=RegistrarAutorizados&admin=1&select=0"><i class="fa fa-money"></i> Registrar Pagos Autorizados</a></li>
                              <?php } ?>
            <?php } ?>
            
            <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                              <?php if($url=="Pagos" && !empty($action) && $action == "Registrar"){ ?>
              <li class="active"><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar"><i class="fa fa-money"></i> Registrar Pagos</a></li>
                              <?php }else{ ?>
              <li class=""><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar"><i class="fa fa-money"></i> Registrar Pagos</a></li>
                              <?php } ?>
            <?php } else { ?>
                <?php if((Count($pedd)>1) && ($pedd[0]['cantidad_aprobado']>0)){  ?>
                      <?php //if($_SESSION['nombre_rol']=="Vendedor" && $optHabilitarPagos=="1"){ ?>
                      <?php if($_SESSION['nombre_rol']=="Vendedor" && $estado_campana=="1"){ ?>
                              <?php if($url=="Pagos" && !empty($action) && $action == "Registrar"){ ?>
              <li class="active"><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar"><i class="fa fa-money"></i> Registrar Pagos</a></li>
                              <?php }else{ ?>
              <li class=""><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar"><i class="fa fa-money"></i> Registrar Pagos</a></li>
                              <?php } ?>
                      <?php }else{ ?>
              <li class=""><a style="color:#676767;cursor:default;"><i class="fa fa-money"></i> Registrar Pagos</a></li>
                      <?php } ?>
                <?php } ?>
            <?php } ?>

                  <?php if($_SESSION['nombre_rol']!="Vendedor"): ?>
                    <?php $rangeMenorPagos = ((3600*24)*5); ?>
                            <?php if( ($url=="Pagos" || $url=="PagosBancarios" || $url=="PagosBolivares" || $url=="PagosDivisas") && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Pagos&rangoI=<?=date('Y-m-d',time()-$rangeMenorPagos); ?>&rangoF=<?=date('Y-m-d', time()); ?>"><i class="fa fa-money"></i> Ver Pagos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Pagos&rangoI=<?=date('Y-m-d',time()-$rangeMenorPagos); ?>&rangoF=<?=date('Y-m-d', time()); ?>"><i class="fa fa-money"></i> Ver Pagos</a></li>
                            <?php } ?>
                  <?php endif; ?>

                  <?php if($_SESSION['nombre_rol']!="Vendedor"): ?>
                            <?php if($url=="Pagoss" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Pagoss"><i class="fa fa-money"></i>Filtro de Pagos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Pagoss"><i class="fa fa-money"></i>Filtro de Pagos</a></li>
                            <?php } ?>
                  <?php endif; ?>


                  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                            <?php if( ($url=="PagosA") && empty($action)){ ?>
            <!-- <li class="active"><a href="?<?php echo $menu ?>&route=PagosA"><i class="fa fa-money"></i> Ver Pagos Alterados</a></li> -->
                            <?php }else{ ?>
            <!-- <li><a href="?<?php echo $menu ?>&route=PagosA"><i class="fa fa-money"></i> Ver Pagos Alterados</a></li> -->
                            <?php } ?>
                  <?php endif; ?>

                  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                            <?php if($url=="PagossA" && empty($action)){ ?>
            <!-- <li class="active"><a href="?<?php echo $menu ?>&route=PagossA"><i class="fa fa-money"></i>Filtro de Pagos Alterados</a></li> -->
                            <?php }else{ ?>
            <!-- <li><a href="?<?php echo $menu ?>&route=PagossA"><i class="fa fa-money"></i>Filtro de Pagos Alterados</a></li> -->
                            <?php } ?>
                  <?php endif; ?>

                  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Conciliador"): ?>
                            <?php if($url=="ReportePagos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ReportePagos"><i class="fa fa-money"></i>Reporte de Pagos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=ReportePagos"><i class="fa fa-money"></i>Reporte de Pagos</a></li>
                            <?php } ?>
                  <?php endif; ?>

                  <?php if($_SESSION['nombre_rol']=="Superusuario"): ?>
                            <?php if($url=="PagosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PagosBorrados"><i class="fa fa-money"></i> Ver Pagos Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PagosBorrados"><i class="fa fa-money"></i> Ver Pagos Borrados</a></li>
                            <?php } ?>
                  <?php endif; ?>

            <?php
              if($_SESSION['cuenta']['estatus']=="1"){  
            ?>
                <?php if((Count($pedd)>1) && ($pedd[0]['cantidad_aprobado']>0)){  ?>
                            <?php if(($url=="MisPagos" || $url=="MisPagosBancarios" || $url=="MisPagosBolivares" || $url=="MisPagosDivisas") && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=MisPagos"><i class="fa fa-money"></i> Ver Mis Pagos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=MisPagos"><i class="fa fa-money"></i> Ver Mis Pagos</a></li>
                            <?php } ?>
                <?php } ?>
            <?php
              }
            ?>
          </ul>

        </li>
    <?php endif; ?>


<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
      <!--  GEMAS   -->
<!-- ======================================================================================================================= -->
        

        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="Gemas" || $url=="GemasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Gemas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                      <?php if($_SESSION['nombre_rol']=="Superusuario"  || $_SESSION['nombre_rol']=="Administrador"  || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($url=="Gemas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Gemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Gema</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Gemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Gema</a></li>
                            <?php } ?>
                      <?php } ?>



                            <?php if($url=="Gemas" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Gemas"><i class="fa fa-diamond"></i> Ver Gemas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Gemas"><i class="fa fa-diamond"></i> Ver Gemas</a></li>
                            <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="GemasBorradas" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=GemasBorradas"><i class="fa fa-diamond"></i> Ver Gemas <br>&nbsp&nbsp Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=GemasBorradas"><i class="fa fa-diamond"></i> Ver Gemas <br>&nbsp&nbsp Borradas</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
      <!--  CANJEO GEMAS   -->
<!-- ======================================================================================================================= -->
        

        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>

                            <?php if($url=="CanjeosGemas" || $url=="CanjeosGemasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Canjeo de Gemas<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp A Fisico</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                            <?php if($url=="CanjeosGemas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=CanjeosGemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Canjeo de Gemas <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp A Fisico</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=CanjeosGemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Canjeo de Gemas <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp A Fisico</a></li>
                            <?php } ?>



                            <?php if($url=="CanjeosGemas" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=CanjeosGemas"><i class="fa fa-diamond"></i> Ver Canjeos de Gemas <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp A Fisico</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=CanjeosGemas"><i class="fa fa-diamond"></i> Ver Canjeos de Gemas <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp A Fisico</a></li>
                            <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
      <!--  OBSEQUIO DE GEMAS   -->
<!-- ======================================================================================================================= -->
        

        <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="ObsequiosGemas" || $url=="ObsequiosGemasBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Gemas autorizadas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                            <?php if($url=="ObsequiosGemas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ObsequiosGemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Gemas autorizadas</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=ObsequiosGemas&action=Registrar"><i class="fa fa-diamond"></i> Agregar Gemas autorizadas</a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista"){ ?>
                            <?php if($url=="ObsequiosGemas" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ObsequiosGemas"><i class="fa fa-diamond"></i> Ver Gemas autorizadas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=ObsequiosGemas"><i class="fa fa-diamond"></i> Ver Gemas autorizadas</a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="ObsequiosGemasBorrados" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ObsequiosGemasBorrados"><i class="fa fa-diamond"></i> Ver Gemas autorizadas Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=ObsequiosGemasBorrados"><i class="fa fa-diamond"></i> Ver Gemas autorizadas Borrados</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
      <!--  PREMIOS AUTORIZADOS   -->
<!-- ======================================================================================================================= -->
        

        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo2"){ ?>

                            <?php if($url=="PremiosAutorizados" || $url=="PremiosAutorizadosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-diamond"></i> <span>Premios Autorizados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                            <?php if($url=="PremiosAutorizados" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosAutorizados&action=Registrar"><i class="fa fa-diamond"></i> Agregar Premios Autorizados</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PremiosAutorizados&action=Registrar"><i class="fa fa-diamond"></i> Agregar Premios Autorizados</a></li>
                            <?php } ?>



                            <?php if($url=="PremiosAutorizados" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosAutorizados"><i class="fa fa-diamond"></i> Ver Premios Autorizados</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PremiosAutorizados"><i class="fa fa-diamond"></i> Ver Premios Autorizados</a></li>
                            <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="PremiosAutorizadosBorradas" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PremiosAutorizadosBorradas"><i class="fa fa-diamond"></i> Ver Premios Autorizados <br>&nbsp&nbsp Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PremiosAutorizadosBorrados"><i class="fa fa-diamond"></i> Ver Premios Autorizados <br>&nbsp&nbsp Borrados</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  Reportes   -->
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

                            <?php if($url=="Nota" || $url == "NotaPersonalizada"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Notas de entrega</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($url=="Nota" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Nota&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de entrega</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Nota&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de entrega</a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php  //if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista"){ ?>
                      <?php  if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                            <?php if($url=="Nota" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Nota"><i class="fa fa-file-text-o"></i> Ver  Notas de entrega</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Nota"><i class="fa fa-file-text-o"></i> Ver  Notas de entrega</a></li>
                            <?php } ?>
                      <?php } ?>


                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo2"){ ?>
                            <?php if($url=="NotaPersonalizada" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=NotaPersonalizada&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de entrega<br>&nbsp&nbsp&nbsp&nbsp Personalizadas </a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=NotaPersonalizada&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de entrega<br>&nbsp&nbsp&nbsp&nbsp Personalizadas </a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo2"){ ?>
                            <?php if($url=="NotaPersonalizada" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=NotaPersonalizada"><i class="fa fa-file-text-o"></i> Ver Notas de entrega<br>&nbsp&nbsp&nbsp&nbsp Personalizadas </a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=NotaPersonalizada"><i class="fa fa-file-text-o"></i> Ver Notas de entrega<br>&nbsp&nbsp&nbsp&nbsp Personalizadas </a></li>
                            <?php } ?>
                      <?php } ?>

          </ul>

        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  Reportes   -->
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

                            <?php if($url=="FacturaDespacho" || $url=="FacturaDespachoConfiguracion" || $url=="NotaDespacho"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Facturación de Pedidos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($url=="FacturaDespacho" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaDespacho&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Factura de Despacho</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=FacturaDespacho&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Factura de Despacho</a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php  //if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista"){ ?>
                      <?php  if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                            <?php if($url=="FacturaDespacho" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaDespacho"><i class="fa fa-file-text-o"></i> Ver Facturas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=FacturaDespacho"><i class="fa fa-file-text-o"></i> Ver Facturas</a></li>
                            <?php } ?>
                      <?php } ?>



                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
                            <?php if($url=="FacturaDespachoConfiguracion" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaDespachoConfiguracion"><i class="fa fa-tag"></i> Configuracion Factura</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=FacturaDespachoConfiguracion"><i class="fa fa-tag"></i> Configuracion Factura</a></li>
                            <?php } ?>
                      <?php } ?>


                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($url=="NotaDespacho" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=NotaDespacho&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de Despacho</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=NotaDespacho&action=Registrar"><i class="fa fa-file-text-o"></i> Realizar Nota de Despacho</a></li>
                            <?php } ?>
                      <?php } ?>


                      <?php  //if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista"){ ?>
                      <?php  if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                            <?php if($url=="NotaDespacho" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=NotaDespacho"><i class="fa fa-file-text-o"></i> Ver Nota de Despacho</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=NotaDespacho"><i class="fa fa-file-text-o"></i> Ver Nota de Despacho</a></li>
                            <?php } ?>
                      <?php } ?>


          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  Reportes   -->
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

                            <?php if($url=="FacturaPersonalizada" || $url=="FacturaPersonalizadaConfiguracion" || $url=="NotaDespacho"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-file-text"></i> <span>Facturación personalizada</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                      <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($url=="FacturaPersonalizada" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaPersonalizada&action=Registrar"><i class="fa fa-file-text-o"></i> Crear Factura personalizada</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=FacturaPersonalizada&action=Registrar"><i class="fa fa-file-text-o"></i> Crear Factura personalizada</a></li>
                            <?php } ?>
                      <?php } ?>

                      <?php  //if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista"){ ?>
                      <?php  if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                            <?php if($url=="FacturaPersonalizada" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=FacturaPersonalizada"><i class="fa fa-file-text-o"></i> Ver Facturas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=FacturaPersonalizada"><i class="fa fa-file-text-o"></i> Ver Facturas</a></li>
                            <?php } ?>
                      <?php } ?>


          </ul>
        </li>
        <?php } ?>

<!-- ======================================================================================================================= -->






        <li>
          <a href="?<?php echo $menu2 ?>&route=Homing">
            <i class="fa fa-reply"></i> <span>Salir del Pedido</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>


<!-- ======================================================================================================================= -->

<?php
} 
else if(!empty($_GET['campaing']) && !empty($_GET['n']) && !empty($_GET['y']) && empty($_GET['dp'])){
  $campaing = $_GET['campaing'];
  $n = $_GET['n'];
  $y = $_GET['y'];
  $menu = "campaing=".$campaing."&n=".$n."&y=".$y;
?>  
<?php 

  $desperfect =  $lider->consultarQuery("SELECT * FROM desperfectos WHERE id_campana = {$campaing}");
  

?>
<style>
/*.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #906;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#a17;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #805;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #a17;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #805;}*/
.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #014;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#125;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #348;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #125;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #347;}

.color-corto{  color:#EA018C;}
.color-completo{  color:#FFF;}
.logo{  background:rgba(255,255,255,.05) !important;}
.skin-blue .sidebar a {  color: #FFF;}
.skin-blue .user-panel > .info,.skin-blue .user-panel > .info > a {  color: #fff;}
.skin-blue .sidebar a:hover {  text-decoration: none;}
.skin-blue .sidebar-menu .treeview-menu > li.active > a,.skin-blue .sidebar-menu .treeview-menu > li > a:hover {  color: #FFF;}
.skin-blue .sidebar-menu .treeview-menu > li > a {  color: #aaa;}
.main-footer{background: #000;}
.main-footer .string{color:#FFF;}
.control-sidebar-dark, div.control-sidebar-bg, .control-sidebar-tabs li.active a{color:#FFF;background:#000 !important;}
.control-sidebar-tabs a{background:rgba(255,255,255,.05) !important;color:#ddd !important;}
.tab-pane li a:hover p, .tab-pane li a:hover h3, .tab-pane li a:hover h4, .tab-pane li a:hover label{color:#ddd !important;}
.tab-pane li a:hover{background:#111 !important; color:#FFF !important;}
.tab-content p, .tab-content h3, .tab-content h4, .tab-content label{color:#DDD !important;}
.skin-blue .sidebar-menu .treeview-menu2 > li > a{background:#212121 !important}
</style>
        <li class="header">NAVEGACION EN CAMPAÑA <?php echo $n."-".$y ?> </li>
    
<!-- ======================================================================================================================= -->

      <?php if($url == "Homing"){ ?>
        <li class="active">
      <?php }else{ ?>
        <li>
      <?php } ?>
          <a href="?<?php echo $menu ?>&route=Homing">
            <i class="fa fa-dashboard"></i> <span>Pedidos</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>

<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
    <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Contable"){ ?>
      <?php if($url == "EstadoCuentas"){ ?>
        <li class="active">
      <?php }else{ ?>
        <li>
      <?php } ?>
          <a href="?<?php echo $menu ?>&route=EstadoCuentas">
            <i class="fa fa-list-alt"></i> <span>Estado de Cuentas Global</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>
    <?php } ?>

<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
              <!--  RETOS   -->
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
                            <?php if($url=="RetosCamp" || $url=="RetosCampBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a>
            <i class="fa fa-tags"></i> <span>Retos de Campaña <?=$n?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                
                <?php  if($amPremioscampR == 1){ ?>
                
                            <?php if($url=="RetosCamp" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=RetosCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Reto</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=RetosCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Reto</a></li>
                            <?php } ?>

                <?php } ?>
                <?php  if($amPremioscampC == 1){ ?>


                            <?php if($url=="RetosCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=RetosCamp"><i class="fa fa-tag"></i> Ver Retos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=RetosCamp"><i class="fa fa-tag"></i> Ver Retos</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php  if($_SESSION['nombre_rol'] == "Superusuario"){ ?>


                            <?php if($url=="RetosCampBorrados" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=RetosCampBorrados"><i class="fa fa-tag"></i> Ver Retos Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=RetosCampBorrados"><i class="fa fa-tag"></i> Ver Retos Borrados</a></li>
                            <?php } ?>
                
                <?php } ?>
          </ul>
        </li>
          <?php } ?>
<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  EXISTENCIAS   -->
<!-- ======================================================================================================================= -->

        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"): ?>

                            <?php if($url=="Existencias"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Existencia de Premios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
                            <?php if($url=="Existencias" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Existencias&action=Registrar"><i class="fa fa-tag"></i> Registrar Existencia</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Existencias&action=Registrar"><i class="fa fa-tag"></i> Registrar Existencia</a></li>
                            <?php } ?>

                            <?php if($url=="Existencias" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Existencias"><i class="fa fa-tag"></i> Ver Existencias</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Existencias"><i class="fa fa-tag"></i> Ver Existencias</a></li>
                            <?php } ?>
          </ul>

        </li>

        <?php endif; ?>


<!-- ======================================================================================================================= -->






<!-- ======================================================================================================================= -->
              <!--  Precio de Gema   -->
<!-- ======================================================================================================================= -->
      <?php $precioGema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE estatus = 1 and id_campana = {$id_campana}"); ?>
        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" ||  $_SESSION['nombre_rol']=="Superusuario"): ?>

                            <?php if($url=="PreciosGema"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Precio de Gema</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
                <?php if(count($precioGema)<2){ ?>
                            <?php if($url=="PreciosGema" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PreciosGema&action=Registrar"><i class="fa fa-tag"></i> Registrar Precio de Gema</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PreciosGema&action=Registrar"><i class="fa fa-tag"></i> Registrar Precio de Gema</a></li>
                            <?php } ?>
                <?php } ?>

                            <?php if($url=="PreciosGema" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PreciosGema"><i class="fa fa-tag"></i> Ver Precios de Gema</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PreciosGema"><i class="fa fa-tag"></i> Ver Precios Gema</a></li>
                            <?php } ?>
          </ul>

        </li>

        <?php endif; ?>


<!-- ======================================================================================================================= -->











<!-- ======================================================================================================================= -->
              <!--  DESPERFECTOS   -->
<!-- ======================================================================================================================= -->



        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"): ?>

                            <?php if($url=="Desperfectos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Desperfectos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
                <?php if(count($desperfect)<2){ ?>

                            <?php if($url=="Desperfectos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Desperfectos&action=Registrar"><i class="fa fa-tag"></i> Registrar Desperfecto</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Desperfectos&action=Registrar"><i class="fa fa-tag"></i> Registrar Desperfecto</a></li>
                            <?php } ?>
                <?php } ?>

                            <?php if($url=="Desperfectos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Desperfectos"><i class="fa fa-tag"></i> Ver Desperfectos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Desperfectos"><i class="fa fa-tag"></i> Ver Desperfectos</a></li>
                            <?php } ?>
          </ul>

        </li>

        <?php endif; ?>

<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  PROMOCION   -->
<!-- ======================================================================================================================= -->



        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){ ?>

                            <?php if($url=="PromocionCamp" || $url=="PromocionFechasCamp"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Promicion de campaña</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">

                            <?php if($url=="PromocionCamp" && !empty($action) && $action == "RegistrarFechas"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PromocionCamp&action=RegistrarFechas"><i class="fa fa-tag"></i> Registrar fechas de<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Promicion de campaña</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PromocionCamp&action=RegistrarFechas"><i class="fa fa-tag"></i> Registrar fechas de<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Promicion de campaña</a></li>
                            <?php } ?>

                            <?php if($url=="PromocionFechasCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PromocionFechasCamp"><i class="fa fa-tag"></i> Ver fechas de Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campañas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PromocionFechasCamp"><i class="fa fa-tag"></i> Ver fechas de Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campañas</a></li>
                            <?php } ?>

                            <?php if($url=="PromocionCamp" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PromocionCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campaña</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=PromocionCamp&action=Registrar"><i class="fa fa-tag"></i> Registrar Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campaña</a></li>
                            <?php } ?>

                            <?php if($url=="PromocionCamp" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=PromocionCamp"><i class="fa fa-tag"></i> Ver Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campañas</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=PromocionCamp"><i class="fa fa-tag"></i> Ver Promicion<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de campañas</a></li>
                            <?php } ?>
          </ul>

        </li>

        <?php } ?>

<!-- ======================================================================================================================= -->



<!-- ======================================================================================================================= -->
              <!--  EXISTENCIAS DE PROMOCIONES  -->
<!-- ======================================================================================================================= -->

        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){ ?>

                            <?php if($url=="ExistenciasPromocion"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Existencias de promoción</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
                            <?php if($url=="ExistenciasPromocion" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ExistenciasPromocion&action=Registrar"><i class="fa fa-tag"></i> Registrar Existencia<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de promoción</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=ExistenciasPromocion&action=Registrar"><i class="fa fa-tag"></i> Registrar Existencia<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de promoción</a></li>
                            <?php } ?>

                            <?php if($url=="ExistenciasPromocion" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=ExistenciasPromocion"><i class="fa fa-tag"></i> Ver Existencias de promoción</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=ExistenciasPromocion"><i class="fa fa-tag"></i> Ver Existencias de promoción</a></li>
                            <?php } ?>
          </ul>

        </li>

        <?php } ?>


<!-- ======================================================================================================================= -->





<!-- ======================================================================================================================= -->
              <!--  DESPACHOS   -->
<!-- ======================================================================================================================= -->
            <?php 
              $amDespachos = 0;
              $amDespachosR = 0;
              $amDespachosC = 0;
              $amDespachosE = 0;
              $amDespachosB = 0;

            $desp = $lider->consultarQuery("SELECT * FROM despachos WHERE id_campana = {$id_campana} and estatus = 1");
          if($_SESSION['nombre_rol']!="Vendedor"){
          // if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor"){
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Despachos"){
                    $amDespachos = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amDespachosR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amDespachosC = 1;
                    }
                    if($access['nombre_permiso'] == "Editar"){
                      $amDespachosE = 1;
                    }
                    if($access['nombre_permiso'] == "Borrar"){
                      $amDespachosB = 1;
                    }
                  }
                }
              }
          }
              if($amDespachos == 1){
          ?>
    
                            <?php if($url=="Despachos"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-tags"></i> <span>Agregar y Editar Pedidos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <?php //if (Count($desp)<2): ?>
                    <?php if($amDespachosR==1): ?>
                            <?php if($url=="Despachos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Despachos&action=Registrar"><i class="fa fa-tag"></i> Registrar Pedidos</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?<?php echo $menu ?>&route=Despachos&action=Registrar"><i class="fa fa-tag"></i> Registrar Pedidos</a></li>
                            <?php } ?>
                    <?php endif; ?>
            <?php //endif; ?>



                    <?php if($amDespachosC==1): ?>
                            <?php if($url=="Despachos" && empty($action)){ ?>
            <li class="active"><a href="?<?php echo $menu ?>&route=Despachos"><i class="fa fa-tag"></i> Ver Pedidos</a></li>
                            <?php }else{ ?>
            <li><a href="?<?php echo $menu ?>&route=Despachos"><i class="fa fa-tag"></i> Ver Pedidos</a></li>
                            <?php } ?>
                    <?php endif; ?>
          </ul>
        </li>
              <?php } ?>

<!-- ======================================================================================================================= -->








        <li>
          <a href="?route=Home">
            <i class="fa fa-reply"></i> <span>Salir de campaña</span>
            <span class="pull-right-container">
              <!-- <small class="label pull-right bg-green">new</small> -->
            </span>
          </a>
        </li>


<!-- ======================================================================================================================= -->


<?php
}else{
?>  
<style>
.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #000;} 
.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#111;}
.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #333;}
.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #111;}
.skin-blue .sidebar-menu > li.active > a {  border-left-color: #333;}

.color-corto{  color:#EA018C;}
.color-completo{  color:#FFF;}
.logo{  background:rgba(255,255,255,.05) !important;}
.skin-blue .sidebar a {  color: #FFF;}
.skin-blue .user-panel > .info,.skin-blue .user-panel > .info > a {  color: #fff;}
.skin-blue .sidebar a:hover {  text-decoration: none;}
.skin-blue .sidebar-menu .treeview-menu > li.active > a,.skin-blue .sidebar-menu .treeview-menu > li > a:hover {  color: #FFF;}
.skin-blue .sidebar-menu .treeview-menu > li > a {  color: #aaa;}
.main-footer{background: #000;}
.main-footer .string{color:#FFF;}
.control-sidebar-dark, div.control-sidebar-bg, .control-sidebar-tabs li.active a{color:#FFF;background:#000 !important;}
.control-sidebar-tabs a{background:rgba(255,255,255,.05) !important;color:#ddd !important;}
.tab-pane li a:hover p, .tab-pane li a:hover h3, .tab-pane li a:hover h4, .tab-pane li a:hover label{color:#ddd !important;}
.tab-pane li a:hover{background:#111 !important; color:#FFF !important;}
.tab-content p, .tab-content h3, .tab-content h4, .tab-content label{color:#DDD !important;}
.skin-blue .sidebar-menu .treeview-menu2 > li > a{background:#212121 !important}
</style>

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
            <li class="<?php if($url=="Clientes" || $url=="ClientesBorrados"){ echo "active"; } ?> treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Líderes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if($amClientesR==1){ ?>
                  <li class="<?php if($url=="Clientes" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Líder</a></li>
                  <?php } ?>
                  <?php if($amClientesC==1){ ?>
                    <li class="<?php if($url=="Clientes" && empty($action)){ echo "active"; } ?>"><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Líderes</a></li>
                  <?php } ?>
                  <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                    <li class="<?php if($url=="ClientesBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=ClientesBorrados"><i class="fa fa-user"></i> Ver Líderes Suspendidos</a></li>
                  <?php } ?>
              </ul>
            </li>
          <?php } ?>
<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  ESTRUCTURAS   -->
<!-- ======================================================================================================================= -->
          <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
            <li class="<?php if($url=="Estructuras"){ echo "active"; } ?> treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Estructuras de Líderes</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?php if($url=="Estructuras" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Estructuras&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Estructuras</a></li>
                <li class="<?php if($url=="Estructuras" && empty($action)){ echo "active"; } ?>"><a href="?route=Estructuras"><i class="fa fa-user"></i> Ver Estructuras</a></li>
              </ul>
            </li>
          <?php } ?>
<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  EMPLEADOS   -->
<!-- ======================================================================================================================= -->
<?php
          $amEmpleados = 0;
          $amEmpleadosR = 0;
          $amEmpleadosC = 0;
          $amEmpleadosE = 0;
          $amEmpleadosB = 0;
          foreach ($accesos as $access) {
            if(!empty($access['id_acceso'])){
              if($access['nombre_modulo'] == "Empleados"){
                $amEmpleados = 1;
                if($access['nombre_permiso'] == "Registrar"){
                  $amEmpleadosR = 1;
                }
                if($access['nombre_permiso'] == "Ver"){
                  $amEmpleadosC = 1;
                }
                if($access['nombre_permiso'] == "Editar"){
                  $amEmpleadosE = 1;
                }
                if($access['nombre_permiso'] == "Borrar"){
                  $amEmpleadosB = 1;
                }
              }
            }
          }
          if($amEmpleados == 1){
            ?>
            <li class="<?php if($url=="Empleados" || $url=="EmpleadosBorrados"){ echo "active"; } ?> treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Empleados</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if($amEmpleadosR==1){ ?>
                  <li class="<?php if($url=="Empleados" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Empleados&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Empleado</a></li>
                  <?php } ?>
                  <?php if($amEmpleadosC==1){ ?>
                    <li class="<?php if($url=="Empleados" && empty($action)){ echo "active"; } ?>"><a href="?route=Empleados"><i class="fa fa-user"></i> Ver Empleados</a></li>
                  <?php } ?>
                  <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                    <li class="<?php if($url=="EmpleadosBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=EmpleadosBorrados"><i class="fa fa-user"></i> Ver Empleados Suspendidos</a></li>
                  <?php } ?>
              </ul>
            </li>
          <?php } ?>
<!-- ======================================================================================================================= -->




<!-- ======================================================================================================================= -->
              <!--  NOMBRAMIENTOS   -->
<!-- ======================================================================================================================= -->


        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista2"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            
        <li class="<?php if($url=="Nombramientos" || $url=="NombramientosBorrados"){ echo "active"; } ?> treeview">
          <a href="#">
            <i class="fa fa-graduation-cap"></i> <span>Nombramientos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" ){ ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor" ){ ?>
                            <?php if($url=="Nombramientos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Nombramientos&action=Registrar"><i class="fa fa-graduation-cap"></i> Agregar Nombramiento</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Nombramientos&action=Registrar"><i class="fa fa-graduation-cap"></i> Agregar Nombramiento</a></li>
                            <?php } ?>
                      <?php } ?>
                <?php } ?>


                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>

                            <?php if($url=="Nombramientos" && empty($action)){ ?>
            <li class="active"><a href="?route=Nombramientos"><i class="fa fa-graduation-cap"></i> Ver Nombramientos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Nombramientos"><i class="fa fa-graduation-cap"></i> Ver Nombramientos</a></li>
                            <?php } ?>

                      <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="NombramientosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=NombramientosBorrados"><i class="fa fa-graduation-cap"></i> Ver Nombramientos <br>&nbsp&nbsp Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=NombramientosBorrados"><i class="fa fa-graduation-cap"></i> Ver Nombramientos <br>&nbsp&nbsp Borrados</a></li>
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
            <i class="fa fa-thumb-tack"></i> <span>Tasas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <?php if($amTasasR==1){ ?>


                            <?php if($url=="Tasas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Tasas&action=Registrar"><i class="fa fa-thumb-tack"></i> Registrar Tasa</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Tasas&action=Registrar"><i class="fa fa-thumb-tack"></i> Registrar Tasa</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amTasasC==1){ ?>


                              <?php if($url=="Tasas" && empty($action)){ ?>
            <li class="active"><a href="?route=Tasas"><i class="fa fa-thumb-tack"></i> Ver Tasas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Tasas"><i class="fa fa-thumb-tack"></i> Ver Tasas</a></li>
                            <?php } ?>

                <?php } ?>
                            
          </ul>
        </li>
         <?php } ?>
    
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
                            <?php if($url=="Movimientos" || $url=="Movimientoss"){ ?>
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
                 <?php if($amMovimientosR==1){ ?>


                            <?php if($url=="Movimientos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Movimientos&action=Registrar"><i class="fa fa-file-text"></i> Registrar Movimiento</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Movimientos&action=Registrar"><i class="fa fa-file-text"></i> Registrar Movimiento</a></li>
                            <?php } ?>
                
                <?php } ?>
                <?php if($amMovimientosC==1){ ?>

                               <?php if($url=="Movimientoss" && empty($action)){ ?>
            <li class="active"><a href="?route=Movimientoss"><i class="fa fa-list-alt"></i> Filtrar Movimientos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Movimientoss"><i class="fa fa-list-alt"></i> Filtrar Movimientos</a></li>
                            <?php } ?>


                   <?php } ?>
                <?php if($amMovimientosC==1){ ?>
                  <?php $rangeMenor = ((3600*24)*5); ?>
                               <?php if($url=="Movimientos" && empty($action)){ ?>
            <li class="active"><a href="?route=Movimientos&rangoI=<?=date("Y-m-d", time()-$rangeMenor); ?>&rangoF=<?=date("Y-m-d", time()); ?>"><i class="fa fa-list-alt"></i> Ver Movimientos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Movimientos&rangoI=<?=date("Y-m-d", time()-$rangeMenor); ?>&rangoF=<?=date("Y-m-d", time()); ?>"><i class="fa fa-list-alt"></i> Ver Movimientos</a></li>
                            <?php } ?>


                   <?php } ?>
          </ul>
        </li>
            <?php } ?>

<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  INVENTARIO   -->
<!-- ======================================================================================================================= -->


        <li class="<?php if($url=="Entradas" || $url=="Salidas" || $url=="Traslados" || $url=="Almacenes" || $url=="Proveedoresinv" || $url=="Productos" || $url=="ProductosBorrados" || $url=="Mercancia" || $url=="MercanciaBorrada" || $url=="Catalogos"){ echo "active"; } ?> treeview">
          <a href="#">
            <i class="fa fa-folder-open"></i> <span>Inventarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu treeview-menu2">
            <!-- ========================================================================================== -->
                    <!--  OPERACIONES   -->
            <!-- ========================================================================================== -->
              <li class="<?php if($url=="Entradas" || $url=="Salidas" || $url=="Traslados"){ echo "active"; } ?> treeview">
                <a href="#">
                  <i class="fa fa-book"></i> <span>Operaciones</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <!-- ========================================================================================== -->
                          <!--  INVENTARIO   -->
                  <!-- ========================================================================================== -->
                    <?php 
                      $amInventario = 0;
                      $amInventarioR = 0;
                      $amInventarioC = 0;
                      $amInventarioE = 0;
                      $amInventarioB = 0;
                      foreach ($accesos as $access) {
                        if(!empty($access['id_acceso'])){
                          if($access['nombre_modulo'] == "Inventarios"){
                            $amInventario = 1;
                            if($access['nombre_permiso'] == "Registrar"){
                              $amInventarioR = 1;
                            }
                            if($access['nombre_permiso'] == "Ver"){
                              $amInventarioC = 1;
                            }
                            if($access['nombre_permiso'] == "Editar"){
                              $amInventarioE = 1;
                            }
                            if($access['nombre_permiso'] == "Borrar"){
                              $amInventarioB = 1;
                            }
                          }
                        }
                      }
                    ?>
                    <?php if($amInventario == 1){ ?>
                    
                    <!-- ========================================================================================== -->
                          <!--  ENTRADAS   -->
                    <!-- ========================================================================================== -->
                    <?php if($amInventarioC==1){ ?>
                      <li class="<?php if($url=="Operaciones" && !empty($action) && $action == "Ver"){ echo "active"; } ?>"><a href="?route=Operaciones&action=Ver"><i class="fa fa-book"></i>Ver Operaciones</a></li>
                    <?php } ?>  
                    <!-- ========================================================================================== -->

                    <!-- ========================================================================================== -->
                          <!--  ENTRADAS   -->
                    <!-- ========================================================================================== -->
                      <?php if($amInventarioR==1){ ?>
                        <li class="<?php if($url=="Entradas" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Entradas&action=Registrar"><i class="fa fa-book"></i>Registrar Entradas</a></li>
                      <?php } ?>
                      
                      
                      <!-- <li class="<?php if($url=="Entradas"){ echo "active"; } ?> treeview">
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Entradas</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
      
                          <?php if($amInventarioC==1){ ?>
                            <li class="<?php if($url=="Entradas" && empty($action)){ echo "active"; } ?>"><a href="?route=Entradas"><i class="fa fa-book"></i> Ver Entradas</a></li>
                          <?php } ?>
                        
                        </ul>
                      </li> -->
                    <!-- ========================================================================================== -->
      
                    <!-- ========================================================================================== -->
                          <!--  SALIDAS   -->
                    <!-- ========================================================================================== -->
                      <?php if($amInventarioR==1){ ?>
                        <li class="<?php if($url=="Salidas" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Salidas&action=Registrar"><i class="fa fa-book"></i>Registrar Salidas</a></li>
                      <?php } ?>
                      <?php if($amInventarioR==1){ ?>
                        <!-- <li class="<?php if($url=="Desincorporacion" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Desincorporacion&action=Registrar"><i class="fa fa-book"></i>Realizar Desincorporacion</a></li> -->
                      <?php } ?>
                      <!-- <li class="<?php if($url=="Salidas"){ echo "active"; } ?> treeview">
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Salidas</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <?php if($amInventarioR==1){ ?>
                            <li class="<?php if($url=="Salidas" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Salidas&action=Registrar"><i class="fa fa-book"></i> Registrar Salidas</a></li>
                          <?php } ?>
      
                          <?php if($amInventarioC==1){ ?>
                            <li class="<?php if($url=="Salidas" && empty($action)){ echo "active"; } ?>"><a href="?route=Salidas"><i class="fa fa-book"></i> Ver Salidas</a></li>
                          <?php } ?>
                        
                        </ul>
                      </li> -->
                    <!-- ========================================================================================== -->
      
                    <!-- ========================================================================================== -->
                          <!--  TRASLADOS   -->
                    <!-- ========================================================================================== -->
                      <?php if($amInventarioR==1){ ?>
                        <li class="<?php if($url=="Traslados" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Traslados&action=Registrar"><i class="fa fa-book"></i>Realizar Traslados</a></li>
                      <?php } ?>
                      <!-- <li class="<?php if($url=="Traslados"){ echo "active"; } ?> treeview">
                        <a href="#">
                          <i class="fa fa-book"></i> <span>Traslados</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <?php if($amInventarioR==1){ ?>
                            <li class="<?php if($url=="Traslados" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Traslados&action=Registrar"><i class="fa fa-book"></i> Registrar Traslados</a></li>
                          <?php } ?>
      
                          <?php if($amInventarioC==1){ ?>
                            <li class="<?php if($url=="Traslados" && empty($action)){ echo "active"; } ?>"><a href="?route=Traslados"><i class="fa fa-book"></i> Ver Traslados</a></li>
                          <?php } ?>
                        
                        </ul>
                      </li> -->
                    <!-- ========================================================================================== -->
                    <?php } ?>
                  <!-- ========================================================================================== -->
                </ul>
              </li> 
            <!-- ========================================================================================== -->

            
            <!-- ========================================================================================== -->
                    <!--  ALMACENES   -->
            <!-- ========================================================================================== -->
              <?php 
                if($amInventario == 1){
                  ?>
                  <li class="<?php if($url=="Almacenes"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-book"></i> <span>Almacenes</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amInventarioR==1){ ?>
                        <li class="<?php if($url=="Almacenes" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Almacenes&action=Registrar"><i class="fa fa-book"></i> Registrar Almacenes</a></li>
                      <?php } ?>
  
                      <?php if($amInventarioC==1){ ?>
                        <li class="<?php if($url=="Almacenes" && empty($action)){ echo "active"; } ?>"><a href="?route=Almacenes"><i class="fa fa-book"></i> Ver Almacenes</a></li>
                      <?php } ?>
                    
                    </ul>
                  </li>
                  <?php
                }
              ?>
            <!-- ========================================================================================== -->

            <!-- ========================================================================================== -->
                  <!--  PROVEEDORES DE INVENTARIO  -->
            <!-- ========================================================================================== -->
              <?php 
                if($amInventario == 1){
                  ?>
                  <li class="<?php if($url=="Proveedoresinv"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-book"></i> <span>Proveedores</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amInventarioR==1){ ?>
                        <li class="<?php if($url=="Proveedoresinv" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Proveedoresinv&action=Registrar"><i class="fa fa-book"></i> Registrar Proveedores</a></li>
                      <?php } ?>
                      
                      <?php if($amInventarioC==1){ ?>
                        <li class="<?php if($url=="Proveedoresinv" && empty($action)){ echo "active"; } ?>"><a href="?route=Proveedoresinv"><i class="fa fa-book"></i> Ver Proveedores</a></li>
                      <?php } ?>
                    
                    </ul>
                  </li> 
                  <?php
                }
              ?>
            <!-- ========================================================================================== -->

            <!-- ============================================================================= -->
                          <!--  PRODUCTOS   -->
            <!-- ============================================================================= -->
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
                  <li class="<?php if($url=="Productos" || $url=="ProductosBorrados" || $url=="Fragancias"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-inbox"></i> <span>Inventario de Productos</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amProductosR==1){ ?>
                        <li class="<?php if($url=="Productos" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Productos&action=Registrar"><i class="fa fa-archive"></i> Registrar Producto</a></li>
                      <?php } ?>
                      
                      <?php if($amProductosC==1){ ?>
                        <li class="<?php if($url=="Productos" && empty($action)){ echo "active"; }?>"><a href="?route=Productos"><i class="fa fa-archive"></i> Ver Productos</a></li>
                      <?php } ?>
          
                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <li class="<?php if($url=="ProductosBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=ProductosBorrados"><i class="fa fa-archive"></i> Ver Productos Borrados</a></li>
                      <?php } ?>
                                      
                      <?php if($amFraganciasC==1){ ?>
                        <!-- <li class="<?php if($url=="Fragancias" && empty($action)){ echo "active"; } ?>"><a href="?route=Fragancias"><i class="fa fa-eyedropper"></i> Fragancias</a></li> -->
                      <?php } ?>
          
                    </ul>
                  </li>
                  <?php
                }
              ?>
            <!-- ============================================================================= -->
            
            <!-- ============================================================================= -->
                          <!--  Premios   -->
            <!-- ============================================================================= -->
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
                  <li class="<?php if($url=="Mercancia" || $url=="MercanciaBorrada"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-rocket"></i> <span>Inventario de Mercancia</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amPremiosR==1){ ?>
                        <li class="<?php if($url=="Mercancia" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Mercancia&action=Registrar"><i class="fa fa-fighter-jet"></i> Registrar Mercancia</a></li>
                      <?php } ?>
                      <?php if($amPremiosC==1){ ?>
                        <li class="<?php if($url=="Mercancia" && empty($action)){ echo "active"; } ?>"><a href="?route=Mercancia"><i class="fa fa-fighter-jet"></i> Ver Mercancia</a></li>
                      <?php } ?>
                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <li class="<?php if($url=="MercanciaBorrada" && empty($action)){ echo "active"; } ?>"><a href="?route=MercanciaBorrada"><i class="fa fa-fighter-jet"></i> Ver Mercancia Borrada</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                  <?php 
                }
              ?>
            <!-- ============================================================================= -->
            
            <!-- ============================================================================= -->
                          <!--  Catalogos   -->
            <!-- ============================================================================= -->
              <?php 
                $amCatalogos = 0;
                $amCatalogosR = 0;
                $amCatalogosC = 0;
                $amCatalogosE = 0;
                $amCatalogosB = 0;
                foreach ($accesos as $access) {
                  if(!empty($access['id_acceso'])){
                    if($access['nombre_modulo'] == "Catalogos"){
                      $amCatalogos = 1;
                      if($access['nombre_permiso'] == "Registrar"){
                        $amCatalogosR = 1;
                      }
                      if($access['nombre_permiso'] == "Ver"){
                        $amCatalogosC = 1;
                      }
                      if($access['nombre_permiso'] == "Editar"){
                        $amCatalogosE = 1;
                      }
                      if($access['nombre_permiso'] == "Borrar"){
                        $amCatalogosB = 1;
                      }
                    }
                  }
                }
                if($amCatalogos == 1){
                  ?>
                  <li class="<?php if($url=="Catalogos" || $url=="CatalogosBorrados"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-object-group"></i> <span>Catalogo de Gemas</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amCatalogosR==1){ ?>
                        <li class="<?php if($url=="Catalogos" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Catalogos&action=Registrar"><i class="fa fa-object-ungroup"></i> Registrar Premio</a></li>
                      <?php } ?>
                      <?php if($amCatalogosC==1){ ?>
                        <li class="<?php if($url=="Catalogos" && empty($action)){ echo "active"; } ?>"><a href="?route=Catalogos"><i class="fa fa-object-ungroup"></i> Ver Catalogo</a></li>
                      <?php } ?>
                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <li class="<?php if($url=="CatalogosBorrados" && empty($action)){ echo "action"; } ?>"><a href="?route=CatalogosBorrados"><i class="fa fa-object-ungroup"></i> Ver Catalogo Deshabilitado</a></li>
                      <?php } ?>
                      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){ ?>
                        <li class="<?php if($url=="Catalogos" && !empty($action) && $action == "RegistrarFechas"){ echo "active"; } ?>"><a href="?route=Catalogos&action=RegistrarFechas"><i class="fa fa-object-ungroup"></i> Configurar fechas<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp del Catálogo</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                  <?php 
                }
              ?>
            <!-- ============================================================================= -->
            
          </ul>  
        </li>  
        
<!-- ======================================================================================================================= -->        
        

        
<!-- ======================================================================================================================= -->
              <!--  CONTABILIDAD   -->
<!-- ======================================================================================================================= -->

        <?php if($url=="Proveedores" || $url=="Libroiva" || $url=="ReporteReusmenGemas"){ ?>
          <li class="active treeview">
        <?php }else{ ?>
          <li class="treeview">
        <?php } ?>
          <a href="#">
            <i class="fa fa-folder-open"></i> <span>Contabilidad</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu treeview-menu2">
            <!-- ======================================================================================================================= -->
                          <!--  Contabilidad   -->
            <!-- ======================================================================================================================= -->
              <?php 
                $amContable = 0;
                $amContableR = 0;
                $amContableC = 0;
                $amContableE = 0;
                $amContableB = 0;
                foreach ($accesos as $access) {
                  if(!empty($access['id_acceso'])){
                    if($access['nombre_modulo'] == "Contabilidad"){
                      $amContable = 1;
                      if($access['nombre_permiso'] == "Registrar"){
                        $amContableR = 1;
                      }
                      if($access['nombre_permiso'] == "Ver"){
                        $amContableC = 1;
                      }
                      if($access['nombre_permiso'] == "Editar"){
                        $amContableE = 1;
                      }
                      if($access['nombre_permiso'] == "Borrar"){
                        $amContableB = 1;
                      }
                    }
                  }
                }
                if($amContable == 1){
                  ?>
                  
                  
                  <!-- ========================================================================================== -->
                        <!--  PROVEEDORES   -->
                  <!-- ========================================================================================== -->
                  <li class="<?php if($url=="Proveedores"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-book"></i> <span>Proveedores</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php 
                        $class="";
                        if($url=="Proveedores" && !empty($action) && $action == "Registrar"){
                          $class="active";
                        } 
                      ?>
                      <?php if($amContableR==1){ ?>
                        <li class="<?=$class; ?>"><a href="?route=Proveedores&action=Registrar"><i class="fa fa-book"></i> Registrar Proveedores</a></li>
                      <?php } ?>

                      <?php 
                        $class="";
                        if($url=="Proveedores" && empty($action)){
                          $class="active";
                        } 
                      ?>
                      <?php if($amContableC==1){ ?>
                        <li class="<?=$class; ?>"><a href="?route=Proveedores"><i class="fa fa-book"></i> Ver Proveedores</a></li>
                      <?php } ?>
                    
                    </ul>
                  </li> 
                  <!-- ========================================================================================== -->
                  
                  <!-- ========================================================================================== -->
                        <!--  LIBRO IVA   -->
                  <!-- ========================================================================================== -->
                  <li class="<?php if($url=="Libroiva"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-book"></i> <span>Libros de IVA</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php
                        if($amContableR==1){
                          $class="";
                          if($url=="Libroiva" && !empty($action) && $action == "RegistrarCompras"){ $class="active"; } 
                          ?>
                          <li class="<?=$class; ?>"><a href="?route=Libroiva&action=RegistrarCompras"><i class="fa fa-book"></i> Registrar Compras</a></li>
                          <?php
                        }
                      ?>

                      <?php 
                        if($amContableC==1){
                          $class="";
                          if($url=="Libroiva" && empty($action)){ $class="active"; } 
                          ?>
                          <li class="<?=$class; ?>"><a href="?route=Libroiva&action=VerCompras"><i class="fa fa-book"></i> Ver Compras</a></li>
                          <?php
                        }
                      ?>


                      <?php
                        if($amContableC==1 && $amContableR==1 && $amContableE==1){
                          $class="";
                          if($url=="Libroiva" && !empty($action) && $action == "ComprasVentas"){ $class="active"; } 
                          ?>
                            <li class="<?=$class; ?>"><a href="?route=Libroiva&action=ComprasVentas"><i class="fa fa-book"></i> Ver Libros de IVA <br> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp de Compras y Ventas</a></li>
                          <?php
                        } 
                      ?>
                    
                    </ul>
                  </li> 
                  <!-- ========================================================================================== -->
                  <?php
                }
              ?>
            <!-- ======================================================================================================================= -->


            <!-- ========================================================================================== -->
                  <!--  Reporte de Gemás   -->
            <!-- ========================================================================================== -->
              <?php
                if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Contable"){
                  ?>
                  <li class="<?php if($url=="ReporteReusmenGemas"){ echo "active"; } ?>">
                    <a href="?route=ReporteReusmenGemas">
                      <i class="fa fa-diamond"></i> <span>Reporte de Gemas</span>
                    </a>
                  </li>
                  <?php
                }
              ?>
            <!-- ========================================================================================== -->
            
            
            
          </ul>
        </li>
        
<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  COMPONENTES DE CAMPAÑAS   -->
<!-- ======================================================================================================================= -->

        <?php
          $claseComponenteCamp = "";
          if($url=="Campana" || $url=="Liderazgos" || $url=="Planes" || $url=="Retosinv" || $url=="RetosinvBorrados" || $url=="Promocionesinv" || $url=="PromocionesinvBorradas"){
            $claseComponenteCamp = "active";
          }
        ?>
        <li class="<?=$claseComponenteCamp; ?> treeview">
          <a href="#">
            <i class="fa fa-folder-open"></i> <span>Componentes de Campaña</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu treeview-menu2">
            <!-- ============================================================================= -->
                          <!--  CAMPANAS   -->
            <!-- ============================================================================= -->
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
                <li class="<?php if($url=="Campanas" || $url=="CampanasBorradas"){ echo "active"; } ?> treeview">
                  <a href="#">
                    <i class="fa fa-object-group"></i> <span>Campañas</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if($amCampanasR==1){ ?>
                      <li class="<?php if($url=="Campanas" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Campanas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Campaña</a></li>
                    <?php } ?>
                    
                    <?php if($amCampanasC==1){ ?>
                      <li class="<?php if($url=="Campanas" && empty($action)){ echo "active"; } ?>"><a href="?route=Campanas"><i class="fa fa-puzzle-piece"></i> Ver Campañas</a></li>
                    <?php } ?>
                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <li class="<?php if($url=="CampanasBorradas" && empty($action)){ echo "active"; } ?>"><a href="?route=CampanasBorradas"><i class="fa fa-puzzle-piece"></i> Ver Campañas Borradas</a></li>
                    <?php } ?>
                  </ul>
                </li>
              <?php } ?>
            <!-- ============================================================================= -->
                    
            <!-- ========================================================================================== -->
                          <!--  LIDERAZGOS   -->
            <!-- ========================================================================================== -->
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
                <li class="<?php if($url=="Liderazgos" || $url=="LiderazgosBorrados"){ echo "active"; } ?> treeview">
                  <a href="#">
                    <i class="fa fa-bookmark"></i> <span>Liderazgos</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if($amLiderazgosR==1){ ?>
                      <li class="<?php if($url=="Liderazgos" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-bookmark-o"></i> Registrar Liderazgo</a></li>
                    <?php } ?>
                    
                    <?php if($amLiderazgosC==1){ ?>
                      <li class="<?php if($url=="Liderazgos" && empty($action)){ echo "active"; } ?>"><a href="?route=Liderazgos"><i class="fa fa-bookmark-o"></i> Ver Liderazgos</a></li>
                    <?php } ?>
            
                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <li class="<?php if($url=="LiderazgosBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=LiderazgosBorrados"><i class="fa fa-bookmark-o"></i> Ver Liderazgos Borrados</a></li>
                    <?php } ?>
                                    
                  </ul>
                </li>
              <?php } ?>
            <!-- ========================================================================================== -->
            
            <!-- ========================================================================================== -->
                          <!--  PLANES   -->
            <!-- ========================================================================================== -->
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
                <li class="<?php if($url=="Planes" || $url=="PlanesBorrados"){ echo "active"; } ?> treeview">
                  <a href="#">
                    <i class="fa fa-star"></i> <span>Planes</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if($amProductosR==1){ ?>
                      <li class="<?php if($url=="Planes" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Planes&action=Registrar"><i class="fa fa-star-o"></i> Registrar Plan</a></li>
                    <?php } ?>
            
                    <?php if($amProductosC==1){ ?>
                      <li class="<?php if($url=="Planes" && empty($action)){ echo "active"; } ?>"><a href="?route=Planes"><i class="fa fa-star-o"></i> Ver Planes</a></li>
                    <?php } ?>
                    
                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <li class="<?php if($url=="PlanesBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=PlanesBorrados"><i class="fa fa-star-o"></i> Ver Planes Borrados</a></li>
                    <?php } ?>
                                    
                  </ul>
                </li>
              <?php } ?>
            
            <!-- ========================================================================================== -->
                    
            <!-- ============================================================================= -->
                          <!--  RETOS   -->
            <!-- ============================================================================= -->
              <?php 
                $amPromociones = 0;
                $amRetosR = 0;
                $amRetosC = 0;
                $amRetosE = 0;
                $amRetosB = 0;
                foreach ($accesos as $access) {
                  if(!empty($access['id_acceso'])){
                    if($access['nombre_modulo'] == "Retos"){
                      $amRetos = 1;
                      if($access['nombre_permiso'] == "Registrar"){
                        $amRetosR = 1;
                      }
                      if($access['nombre_permiso'] == "Ver"){
                        $amRetosC = 1;
                      }
                      if($access['nombre_permiso'] == "Editar"){
                        $amRetosE = 1;
                      }
                      if($access['nombre_permiso'] == "Borrar"){
                        $amRetosB = 1;
                      }
                    }
                  }
                }
                if($amRetos == 1){
                  ?>
                  <li class="<?php if($url=="Retosinv" || $url=="RetosinvBorrados"){ echo "active"; } ?> treeview">
                    <a href="#">
                      <i class="fa fa-object-group"></i> <span>Retos</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <?php if($amRetosR==1){ ?>
                        <li class="<?php if($url=="Retosinv" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Retosinv&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Retos</a></li>
                      <?php } ?>
          
                      <?php if($amRetosC==1){ ?>
                        <li class="<?php if($url=="Retosinv" && empty($action)){ echo "active"; } ?>"><a href="?route=Retosinv"><i class="fa fa-puzzle-piece"></i> Ver Retos</a></li>
                      <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <li class="<?php if($url=="RetosinvBorrados" && empty($action)){ echo "active"; } ?>"><a href="?route=RetosinvBorrados"><i class="fa fa-puzzle-piece"></i> Ver Retos Borradas</a></li>
                      <?php } ?>
                                      
                    </ul>
                  </li>
                  <?php
                }
              ?>
            <!-- ============================================================================= -->

            <!-- ============================================================================= -->
                          <!--  PROMOCIONES   -->
            <!-- ============================================================================= -->
              <?php 
                $amPromociones = 0;
                $amPromocionesR = 0;
                $amPromocionesC = 0;
                $amPromocionesE = 0;
                $amPromocionesB = 0;
                foreach ($accesos as $access) {
                  if(!empty($access['id_acceso'])){
                    if($access['nombre_modulo'] == "Promociones"){
                      $amPromociones = 1;
                      if($access['nombre_permiso'] == "Registrar"){
                        $amPromocionesR = 1;
                      }
                      if($access['nombre_permiso'] == "Ver"){
                        $amPromocionesC = 1;
                      }
                      if($access['nombre_permiso'] == "Editar"){
                        $amPromocionesE = 1;
                      }
                      if($access['nombre_permiso'] == "Borrar"){
                        $amPromocionesB = 1;
                      }
                    }
                  }
                }
                if($amPromociones == 1){
              ?>
                <li class="<?php if($url=="Promocionesinv" || $url=="PromocionesinvBorradas"){ echo "active"; } ?> treeview">
                  <a href="#">
                    <i class="fa fa-object-group"></i> <span>Promociones</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <?php if($amPromocionesR==1){ ?>
                      <li class="<?php if($url=="Promocionesinv" && !empty($action) && $action == "Registrar"){ echo "active"; } ?>"><a href="?route=Promocionesinv&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Promociones</a></li>
                    <?php } ?>
        
                    <?php if($amPromocionesC==1){ ?>
                      <li class="<?php if($url=="Promocionesinv" && empty($action)){ echo "active"; } ?>"><a href="?route=Promocionesinv"><i class="fa fa-puzzle-piece"></i> Ver Promociones</a></li>
                    <?php } ?>

                    <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                      <li class="<?php if($url=="PromocionesinvBorradas" && empty($action)){ echo "active"; } ?>"><a href="?route=PromocionesinvBorradas"><i class="fa fa-puzzle-piece"></i> Ver Promociones Borradas</a></li>
                    <?php } ?>
                                    
                  </ul>
                </li>
              <?php } ?>
            <!-- ============================================================================= -->

          </ul>  
        </li>  

<!-- ======================================================================================================================= -->        








<!-- ======================================================================================================================= -->
              <!--  ACCESO A PAGOS   -->
<!-- ======================================================================================================================= -->

      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Conciliador"){ ?>

                            
        <li class="<?php if($url=="Pagos" || $url=="PagosBorrados"){ echo "active"; } ?> treeview">
          <a href="#">
            <i class="fa fa-dollar"></i> <span>Pagos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                              <?php if($url=="Pagos" && empty($action)){ ?>
            <li class="active"><a href="?route=PagosD"><i class="fa fa-money"></i> Ver Pagos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=PagosD"><i class="fa fa-money"></i> Ver Pagos</a></li>
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
        <li class="<?php if($url=="Bancos"){ echo "active"; } ?>">
          <a href="?route=Bancos">
            <i class="fa fa-bank"></i> <span>Bancos</span>
          </a>
        </li>
      <?php } ?>
<!-- ======================================================================================================================= -->


<!-- ======================================================================================================================= -->
              <!--  CALENDARIO   -->
<!-- ======================================================================================================================= -->
        <li class="<?php if($url=="Calendario"){ echo "active"; } ?>">
          <a href="?route=Calendario">
            <i class="fa fa-calendar"></i> <span>Calendario</span>
          </a>
        </li>
<!--  ================================================================================================================x -->


<!--  ================================================================================================================x -->
        <!-- RUTAS   PROBABLEMENTE SE VA A BORRAR ESTA SECCION -->
<!--  ================================================================================================================x -->

  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
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

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                            <?php if($url=="RutasBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=RutasBorradas"><i class="fa fa-truck"></i> Ver Rutas Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=RutasBorradas"><i class="fa fa-truck"></i> Ver Rutas Borradas</a></li>
                            <?php } ?>
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
        </li>
            <?php } ?>
<!--  ================================================================================================================x -->






<!--  ================================================================================================================x -->
      <!-- PREMIOS CANJEADOS -->
<!--  ================================================================================================================x -->
  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
    <li class="<?php if($url=="Canjeados" || $url==""){ echo "active"; } ?> treeview">
      <a href="#">
        <i class="fa fa-truck"></i> <span>Premios Canjeados</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?php if($url=="Canjeados" && empty($action)){ echo "active"; } ?>"><a href="?route=Canjeados"><i class="fa fa-truck"></i> Ver Premios Canjeados</a></li>
      </ul>
    </li>
  <?php } ?>
<!--  ================================================================================================================x -->



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

                <?php if($amUsuariosR==1){ ?>


                            <?php if($url=="Usuarios" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Usuarios&action=Registrar"><i class="fa  fa-user-plus"></i> Registrar Usuario</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Usuarios&action=Registrar"><i class="fa  fa-user-plus"></i> Registrar Usuario</a></li>
                            <?php } ?>

                <?php } ?>
                <?php if($amUsuariosC==1){ ?>


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
                <?php } ?>


            <?php if($amUsuariosR==1){ ?>


                            <?php if($url=="Usuarios" && !empty($action) && $action == "Accesos"){ ?>
            <li class="active"><a href="?route=Usuarios&action=Accesos"><i class="fa  fa-user-secret"></i> Acceso de Usuario</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Usuarios&action=Accesos"><i class="fa  fa-user-secret"></i> Acceso de Usuario</a></li>
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

                                      <?php if($url=="Reportes"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-folder-open"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu treeview-menu2">

                  <?php if($url == "Reportes" && !empty($action) && ($action=="PedidosSolicitados" || $action=="PedidosAprobados")){ ?>
                    <li class="active treeview">
                  <?php  }else{ ?>
                    <li class="treeview">
                  <?php } ?>
                      <a href="?route=Reportes">
                        <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Pedidos</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                          <?php if($url=="Reportes" && !empty($action) && $action=="PedidosSolicitados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PedidosSolicitados"><i class="fa  fa-file-pdf-o"></i> Pedidos Solitados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PedidosSolicitados"><i class="fa  fa-file-pdf-o"></i> Pedidos Solitados</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PedidosAprobados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PedidosAprobados"><i class="fa  fa-file-pdf-o"></i> Pedidos Aprobados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PedidosAprobados"><i class="fa  fa-file-pdf-o"></i> Pedidos Aprobados</a></li>
                            <?php } ?>

                      </ul>
                    </li>



                  <?php if($url == "Reportes" && !empty($action) && ($action=="PlanesSeleccionados" || $action=="PorcentajePlanesSeleccionados"  || $action=="PorcentajePremiosSeleccionados")){ ?>
                    <li class="active treeview">
                  <?php  }else{ ?>
                    <li class="treeview">
                  <?php } ?>
                      <a href="?route=Reportes">
                        <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Porcentajes</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">

                            <?php if($url=="Reportes" && !empty($action) && $action=="PlanesSeleccionados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PlanesSeleccionados"><i class="fa  fa-file-pdf-o"></i> Planes Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PlanesSeleccionados"><i class="fa  fa-file-pdf-o"></i> Planes Seleccionados</a></li>
                            <?php } ?>

                             <?php if($url=="Reportes" && !empty($action) && $action=="PorcentajePlanesSeleccionados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PorcentajePlanesSeleccionados"><i class="fa  fa-file-pdf-o"></i> Porcentaje De Planes <br>Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PorcentajePlanesSeleccionados"><i class="fa  fa-file-pdf-o"></i> Porcentaje De Planes <br>Seleccionados</a></li>
                            <?php } ?>

                             <?php if($url=="Reportes" && !empty($action) && $action=="PorcentajePremiosSeleccionados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PorcentajePremiosSeleccionados"><i class="fa  fa-file-pdf-o"></i> Porcentaje De Premios <br>Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PorcentajePremiosSeleccionados"><i class="fa  fa-file-pdf-o"></i> Porcentaje De Premios <br>Seleccionados</a></li>
                            <?php } ?>                       

                      </ul>
                    </li>


                  <?php if($url == "Reportes" && !empty($action) && ($action=="PremiosSeleccionados" || $action=="PremiosEstructura" )){ ?>
                    <li class="active treeview">
                  <?php  }else{ ?>
                    <li class="treeview">
                  <?php } ?>
                      <a href="?route=Reportes">
                        <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Planes y Premios <br>&nbsp&nbsp&nbsp&nbsp&nbsp Seleccionados</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">                    

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosSeleccionados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosSeleccionados"><i class="fa  fa-file-pdf-o"></i> Planes Y Premios <br>&nbsp&nbsp Seleccionados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosSeleccionados"><i class="fa  fa-file-pdf-o"></i> Planes Y Premios <br>&nbsp&nbsp&nbsp&nbsp&nbsp Seleccionados</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosEstructura"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosEstructura"><i class="fa  fa-file-pdf-o"></i> Planes Y Premios <br>&nbsp&nbsp Por Estructura</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosEstructura"><i class="fa  fa-file-pdf-o"></i> Planes Y Premios <br>&nbsp&nbsp&nbsp&nbsp&nbsp Por Estructura</a></li>
                            <?php } ?>

                      </ul>
                    </li>

                  <?php if($url == "Reportes" && !empty($action) && ($action=="PremiosPerdidos" || $action=="PremiosAlcanzados"  || $action=="PremiosEstructuraAlcanzados" || $action=="PremiosAlcanzadosRutas"  || $action=="PremiosAlcanzadosLideres")){ ?>
                    <li class="active treeview">
                  <?php  }else{ ?>
                    <li class="treeview">
                  <?php } ?>
                      <a href="?route=Reportes">
                        <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Premios Perdidos <br>&nbsp&nbsp&nbsp&nbsp&nbsp y Alcanzados</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">                    


                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosPerdidos"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosPerdidos"><i class="fa  fa-file-pdf-o"></i> Premios Perdidos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosPerdidos"><i class="fa  fa-file-pdf-o"></i> Premios Perdidos</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosAlcanzados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosAlcanzados"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosAlcanzados"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosAlcanzadosLideres"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosAlcanzadosLideres"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Líderes</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosAlcanzadosLideres"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Líderes</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosEstructuraAlcanzados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosEstructuraAlcanzados"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Estructura</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosEstructuraAlcanzados"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Estructura</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosAlcanzadosRutas"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosAlcanzadosRutas"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Rutas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosAlcanzadosRutas"><i class="fa  fa-file-pdf-o"></i> Premios Alcanzados <br>&nbsp&nbsp&nbsp&nbsp Por Rutas</a></li>
                            <?php } ?>

                      </ul>
                    </li>



                  <?php if($url == "Reportes" && !empty($action) && ($action=="Gemas" || $action=="CanjeoGemas" || $action=="PremiosCanjeadosNoAsignados" || $action=="PremiosCanjeadosAsignados" || $action=="PremiosCanjeados" || $action=="PremiosCanjeadosGeneral")){ ?>
                    <li class="active treeview">
                  <?php  }else{ ?>
                    <li class="treeview">
                  <?php } ?>
                      <a href="?route=Reportes">
                        <!-- <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Gemas y Canjeos</span> -->
                        <i class="fa  fa-file-pdf-o" style="background:;"></i> <span>Gemas, Canjeos <br>&nbsp&nbsp&nbsp&nbsp&nbsp y Premios Canjeados</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">                    


                            <?php if($url=="Reportes" && !empty($action) && $action=="Gemas"){ ?>
            <li class="active "><a href="?route=Reportes&action=Gemas"><i class="fa  fa-file-pdf-o"></i> Gemas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=Gemas"><i class="fa  fa-file-pdf-o"></i> Gemas</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="CanjeoGemas"){ ?>
            <li class="active "><a href="?route=Reportes&action=CanjeoGemas"><i class="fa  fa-file-pdf-o"></i> Canjeo de Gemas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=CanjeoGemas"><i class="fa  fa-file-pdf-o"></i> Canjeo de Gemas</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosCanjeadosNoAsignados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosCanjeadosNoAsignados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp No Asignados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosCanjeadosNoAsignados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp No Asignados</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosCanjeadosAsignados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosCanjeadosAsignados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp Asignados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosCanjeadosAsignados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp Asignados</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosCanjeados"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosCanjeados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp Totales</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosCanjeados"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp Totales</a></li>
                            <?php } ?>

                            <?php if($url=="Reportes" && !empty($action) && $action=="PremiosCanjeadosGeneral"){ ?>
            <li class="active "><a href="?route=Reportes&action=PremiosCanjeadosGeneral"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp General</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Reportes&action=PremiosCanjeadosGeneral"><i class="fa  fa-file-pdf-o"></i> Premios Canjeados<br>&nbsp&nbsp&nbsp&nbsp&nbsp General</a></li>
                            <?php } ?>


                      </ul>
                    </li>





          <?php } ?>


          </ul>
        </li>
<!-- ======================================================================================================================= -->






<!-- ======================================================================================================================= -->
        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="Configuraciones" || $url=="ConfiguracionesBorradas"){ ?>
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


                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="Configuraciones" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=Configuraciones&action=Registrar"><i class="fa fa-cog"></i> Agregar Configuracion</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=Configuraciones&action=Registrar"><i class="fa fa-cog"></i> Agregar Configuracion</a></li>
                            <?php } ?>
                      <?php } ?>



                            <?php if($url=="Configuraciones" && empty($action)){ ?>
            <li class="active"><a href="?route=Configuraciones"><i class="fa fa-cog"></i> Ver Configuraciones</a></li>
                            <?php }else{ ?>
            <li><a href="?route=Configuraciones"><i class="fa fa-cog"></i> Ver Configuraciones</a></li>
                            <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="ConfiguracionesBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfiguracionesBorradas"><i class="fa fa-cog"></i> Ver Configuraciones <br>&nbsp&nbsp Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfiguracionesBorradas"><i class="fa fa-cog"></i> Ver Configuraciones <br>&nbsp&nbsp Borradas</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>






        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="ConfigGemas" || $url=="ConfigGemasBorradas"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Config Gemas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="ConfigGemas" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=ConfigGemas&action=Registrar"><i class="fa fa-cog"></i> Agregar Config <br>&nbsp&nbsp&nbsp&nbsp Gema</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=ConfigGemas&action=Registrar"><i class="fa fa-cog"></i> Agregar Config <br>&nbsp&nbsp&nbsp&nbsp Gema</a></li>
                            <?php } ?>
                      <?php } ?>



                            <?php if($url=="ConfigGemas" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfigGemas"><i class="fa fa-cog"></i> Ver Config Gemas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfigGemas"><i class="fa fa-cog"></i> Ver Config Gemas</a></li>
                            <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="ConfigGemasBorradas" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfigGemasBorradas"><i class="fa fa-cog"></i> Ver Config Gemas <br>&nbsp&nbsp Borradas</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfigGemasBorradas"><i class="fa fa-cog"></i> Ver Config Gemas <br>&nbsp&nbsp Borradas</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>


        


        <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
        <?php //if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="ConfigNombramientos" || $url=="ConfigNombramientosBorrados"){ ?>
        <li class="active treeview">
                            <?php }else{ ?>
        <li class="treeview">
                            <?php } ?>
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Config Nombramientos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>

                            <?php if($url=="ConfigNombramientos" && !empty($action) && $action == "Registrar"){ ?>
            <li class="active"><a href="?route=ConfigNombramientos&action=Registrar"><i class="fa fa-cog"></i> Agregar Config <br>&nbsp&nbsp&nbsp&nbsp Nombramiento</a></li>
                            <?php }else{ ?>
            <li class=""><a href="?route=ConfigNombramientos&action=Registrar"><i class="fa fa-cog"></i> Agregar Config <br>&nbsp&nbsp&nbsp&nbsp Nombramiento</a></li>
                            <?php } ?>
                      <?php } ?>



                            <?php if($url=="ConfigNombramientos" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfigNombramientos"><i class="fa fa-cog"></i> Ver Config Nombramientos</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfigNombramientos"><i class="fa fa-cog"></i> Ver Config Nombramientos</a></li>
                            <?php } ?>

                      <?php if($_SESSION['nombre_rol']=="Superusuario"){ ?>
                        <?php if($url=="ConfigNombramientosBorrados" && empty($action)){ ?>
            <li class="active"><a href="?route=ConfigNombramientosBorrados"><i class="fa fa-cog"></i> Ver Config Nombramientos <br>&nbsp&nbsp Borrados</a></li>
                            <?php }else{ ?>
            <li><a href="?route=ConfigNombramientosBorrados"><i class="fa fa-cog"></i> Ver Config Nombramientos <br>&nbsp&nbsp Borrados</a></li>
                            <?php } ?>
                      <?php } ?>
                            
          </ul>
        </li>
        <?php } ?>





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
                          <!--  BITACORA   -->
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
                $rangeMenorBitacora = ((3600*24)*1);
                ?>
                  <?php if($url == "Bitacora"){ ?>
                    <li class="active">
                  <?php }else{ ?>
                    <li>
                  <?php } ?>
                      <a href="?route=Bitacora&rangoI=<?=date("Y-m-d", time()-$rangeMenorBitacora); ?>&rangoF=<?=date("Y-m-d", time()); ?>">
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










<?php
}
?>
     
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>