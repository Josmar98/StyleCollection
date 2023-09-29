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
      <span class="logo-lg color-completo"><b class="color-corto">Style</b>Home</span>
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


          <?php if(!empty($_GET['c']) && !empty($_GET['n']) && !empty($_GET['y'])){ ?>
          <li class="dropdown notifications-menu" style="font-size:;margin-right:10px;">
            <a href="?<?=$menu; ?>&route=Cart<?=$addUrlAdmin; ?>" class="dropdown-toggle box_notificaciones" style="">
              <i class="glyphicon glyphicon-shopping-cart" style="font-size:1.2em"></i>
              <span class="label cantidad_carrito <?=$classHidden; ?>" style="background:#00000022;border-radius:10px;font-size:1.1em;position:relative;top:-10px;right:0px;"><?=$cantidadCarrito; ?></span>
            </a>
          </li>
          <?php } ?>



            <li class="dropdown user user-menu">
              <?php
                $fondoImg = "1";
                $fondoBoxImageGema = "background:#AAA";
                if($fondoImg=="1"){
                  $fondoBoxImageGema = "background:url('public/assets/img/gemas/fondos/fondo.jpg')";
                }
                //  ---- CHEQUEO DE PUNTOS -----  
                  $puntosDisponibles = 0;
                  $puntosBloqueados = 0;
                  $puntoscanjeados=0;
                  $puntosPersonales = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_cliente = {$_SESSION['home']['id_cliente']} and puntos.estatus=1");
                  foreach ($puntosPersonales as $point) { if(!empty($point['id_punto'])){
                    if($point['estado_puntos']==1){
                      $puntosDisponibles += $point['puntos_disponibles'];
                    }
                    if($point['estado_puntos']==0){
                      $puntosBloqueados += $point['puntos_bloqueados'];
                    }
                  } }

                  $puntssPerso = $lider->consultarQuery("SELECT * FROM puntos WHERE puntos.id_cliente = {$_SESSION['home']['id_cliente']} and puntos.estatus=1 and puntos.concepto='1'");
                  foreach ($puntssPerso as $ptssPerson) {
                    if(!empty($ptssPerson['id_punto'])){
                      $tid_ciclo = $ptssPerson['id_ciclo'];
                      $tid_pedido = $ptssPerson['id_pedido'];
                      if($ptssPerson['estado_puntos']==0){
                        $puntosBloqueados -= $ptssPerson['puntos_bloqueados'];
                        $pointsPerso = 0;
                        $tciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.id_ciclo={$tid_ciclo} and ciclos.estatus=1");
                        $tciclos = $tciclos[0];
                        $pointsPerso += $ptssPerson['puntos_bloqueados']/$tciclos['cantidad_cuotas'];
                        $nPointsPerso = 0;
                        $tpedidos = $lider->consultarQuery("SELECT SUM(pedidos_inventarios.cantidad_aprobada*inventarios.precio_inventario) as cantidad_aprobada FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and inventarios.estatus=1 and pedidos.id_pedido={$tid_pedido} and pedidos.estatus=1");
                        $tpedidos = $tpedidos[0];
                        $tcantidad_aprobada = $tpedidos['cantidad_aprobada'];
                        $cuotaPagarPerso = $tpedidos['cantidad_aprobada']/$tciclos['cantidad_cuotas'];
                        $cuotaAlcanzarPerso = 0;
                        $tpagosCiclosPerson = $lider->consultarQuery("SELECT * FROM pagos_ciclo WHERE pagos_ciclo.id_ciclo={$tid_ciclo} and pagos_ciclo.estatus=1");
                        foreach ($tpagosCiclosPerson as $pc){ if(!empty($pc['id_pago_ciclo'])){
                          if($fechaActual>= $pc['fecha_pago_cuota']){
                            $cuotaAlcanzarPerso += $cuotaPagarPerso;
                            $pagosCuotasPerso = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus=1 and pagos.id_pedido={$tid_pedido} and fecha_pago <= '{$pc['fecha_pago_cuota']}'");
                            $cuotaAbonadaPerso = 0;
                            foreach ($pagosCuotasPerso as $abCuota){ if(!empty($abCuota['id_pago'])){
                              if($abCuota['estado']=='Abonado'){
                                $cuotaAbonadaPerso += $abCuota['equivalente_pago'];
                              }
                            } }
                            if($cuotaAbonadaPerso >= $cuotaAlcanzarPerso){
                              $nPointsPerso += $pointsPerso;
                            }
                          }
                        } }
                        
                        $puntosBloqueados+=$nPointsPerso;

                      }
                    }
                  }

                  $canjeosPersonales = $lider->consultarQuery("SELECT * FROM canjeos, inventarios WHERE canjeos.cod_inventario=inventarios.cod_inventario and canjeos.id_cliente = {$_SESSION['home']['id_cliente']} and canjeos.estatus=1");
                  foreach ($canjeosPersonales as $canje) { if(!empty($canje['id_canjeo'])){
                    $puntoscanjeados += $canje['puntos_inventario'];
                  } }
                  $puntosDisponibles -= $puntoscanjeados;
                //  ---- CHEQUEO DE PUNTOS -----  

              ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:17px;padding-right:17px">
                <!-- <i class="fa fa-envelope-o" ></i> -->
                <div style="background:#FFF;border-radius:100px;margin-bottom:-5px;margin-top:-6px;margin-right:-10px;height:30px;">
                  <!-- <img style="width:40px;padding:0;margin:0;position:relative;left:-12px;top:-4px;" src="<?=$fotoGema?>"> -->
                  <!-- <span style="color:<?=$fucsia?>;position:relative;top:-3px;left:-12px"> -->
                  <span style="color:<?=$fucsia?>;padding:15px;">
                    <b style="font-size:1.2em">
                    <?php 
                      // $gemasAdquiridasDisponibles = 99999.50;
                      // $gemasAdquiridasBloqueadas = 5150;
                      echo number_format($puntosDisponibles,2,',','.'); 
                      // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                    ?>
                    </b>
                  </span>
                </div>
              </a>
              <ul class="dropdown-menu" style="box-shadow:0px 0px 2px #000">
                <li class="user-header " style="<?=$fondoBoxImageGema?>;background-size:100% 100%;">
                  <?php  $colorTextGemas = "color:#FFF;text-shadow:1px 1px 3px #000000;"; ?>
                  <p style="<?=$colorTextGemas; ?>margin:0;padding:0">
                    <span style="margin:0;padding:0;;"><b><u>Puntos</u></b></span>
                  </p>
                  <span style="position:relative;top:-5px;right:35px;text-align:left;">
                    <span style="<?=$colorTextGemas; ?>;margin-right:50px;"><small><b>Disponibles</b></small></span>
                    <br>
                    <div class="" style="background:#FFF;border-radius:100px;display:inline-block;rotate:50;box-shadow:0px 0px 5px #DDD">
                      <!-- <img style="width:65px;padding:0;margin:0;position:relative;left:-10px;top:0px;" src="<?=$fotoGema?>"> -->
                      <!-- <span style="color:<?=$fucsia?>;position:relative;top:4px;left:-12px"> -->
                      <span style="color:<?=$fucsia?>;padding:15px;">
                        <b style="font-size:1.5em">
                        <?php 
                          echo number_format($puntosDisponibles,2,',','.'); 
                          // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                        ?>
                        </b>
                      </span>
                    </div>
                  </span>

                  <br>
                
                  <span style="position:relative;top:-20px;left:50px;text-align:right;">
                    <span style="<?=$colorTextGemas; ?>margin-left:30px"><small><b>Bloqueados</b></small></span>
                    <br>
                    <div class="" style="background:#FFF;border-radius:100px;display:inline-block;">
                      <!-- <img style="width:35px;padding:0;margin:0;position:relative;left:-10px;top:2px;" src="<?=$fotoGemaBloqueadas?>"> -->
                      <!-- <span style="color:#00000055;position:relative;top:3px;left:-12px"> -->
                      <span style="color:#00000055;padding:10px;">
                        <b style="font-size:1em">
                        <?php 
                          echo number_format($puntosBloqueados,2,',','.'); 
                          // if($gemasAdquiridasDisponibles==1){ echo " Gema"; }else{ echo " Gemas"; } 
                        ?>
                        </b>
                      </span>
                    </div>
                  </span>
                </li>
                <li class="user-footer">
                  <div class="text-center" style="padding:0;margin:0;">
                    <p style="color:#fff;position:absolute;width:100%;display:block;margin:0;margin-top:-30px;">
                      <small><a style="color:#FFF;text-shadow:0px 0px 3px #000;" href="?route=Catalogos&action=Historial"><b><u>Historial de puntos</u></b></a></small>
                    </p>
                  </div>
                  <div class="text-center">
                    <a href="?route=Catalogos" class="btn enviar2 btn-flat col-xs-12">Ver catálogo</a>
                  </div>
                </li>
              </ul>
            </li>



          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:7px;padding-right:7px">
              <?php 
                $cuentaUsuario = $_SESSION['home']['cuentaUsuario'];
                // echo $cuentaUsuario['fotoPerfil'];
                if($cuentaUsuario['fotoPerfil'] == ""){
                  $fotoPerfil = "public/assets/img/profile/";
                  if($_SESSION['home']['cuenta']['sexo']=="Femenino"){$fotoPerfil .= "Femenino.png";}
                  if($_SESSION['home']['cuenta']['sexo']=="Masculino"){$fotoPerfil .= "Masculino.png";} 

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
                $_SESSION['home']['fotoPerfil']=$fotoPerfil;
                $_SESSION['home']['fotoPortada']=$fotoPortada;
                
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
                      <?php 
                        if($_SESSION['home']['nombre_rol']=="Superusuario"){ $rroll = "Desarrollador"; } 
                        else{ $rroll = $_SESSION['home']['nombre_rol']; }
                      ?>

                      <small><?php echo $rroll ?> de StyleHome</small>
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