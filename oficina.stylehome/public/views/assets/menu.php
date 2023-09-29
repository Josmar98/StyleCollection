<!-- <aside class="main-header" style="position:fixed;min-height:100vh;max-height:100vh;width:18.3%;overflow:auto;top:0%;z-index:0"> -->
<aside class="main-sidebar">
	<!-- <div class="main-header">
		<a href="./" class="logo">
			<span class="logo-mini color-completo"><b class="color-corto">S</b>tyle</span>
			<span class="logo-lg color-completo"><b class="color-corto">Style</b>Collection</span>
		</a>
	</div> -->

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
					<?php echo $cuenta['primer_nombre']; ?>
					<?php echo $cuenta['primer_apellido']; ?>
				</p>
				<a href="#"><i class="fa fa-circle text-success"></i> En linea</a>
			</div>
		</div>


		<ul class="sidebar-menu" data-widget="tree">
			<?php
				$dentroCiclo = false;
				if(!empty($_GET['c']) && !empty($_GET['n']) && !empty($_GET['y'])){
					$dentroCiclo = true;
				}
			?>
			<?php if($dentroCiclo==false){ ?>
				<!-- ======================================================================================================================= -->
					<!--	NAVEGACION PRINCIPAL	-->
				<!-- ======================================================================================================================= -->

					<li class="header">NAVEGACION PRINCIPAL</li>

					<!-- ======================================================================================================================= -->
						<!--	HOME	-->
					<!-- ======================================================================================================================= -->
						<?php
							$cHome="";
							if($url == "Home"){
								$cHome="active";
							}
						?>
						<li class="<?=$cHome; ?>">
							<a href="?route=Home">
								<i class="fa fa-home"></i> <span>Inicio</span>
								<span class="pull-right-container">
									<!-- <small class="label pull-right bg-green">new</small> -->
								</span>
							</a>
						</li>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	CLIENTES	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoClientes = false;
							$accesoClientesR = false;
							$accesoClientesC = false;
							$accesoClientesM = false;
							$accesoClientesE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Clientes")){
										$accesoClientes = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoClientesR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoClientesC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoClientesM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoClientesE=true; }
									}
								}
							}
							$cClientes = "";
							if($url=="Clientes"){
								$cClientes = "active";
							}
						?>
						<?php if($accesoClientes){ ?>
						<li class="<?=$cClientes; ?> treeview">
							<a href="#">
								<i class="fa fa-users"></i> <span>Lideres</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cClientesR = "";
									$cClientesC = "";
									$cClientesB = "";
									if($url=="Clientes" && !empty($action) && $action == "Registrar"){
										$cClientesR = "active";
									}
									if($url=="Clientes" && !empty($action) && $action == "Consultar"){
										$cClientesC = "active";
									}
									if($url=="Clientes" && !empty($action) && $action == "Borrados"){
										$cClientesB = "active";
									}
								?>
								<?php if($accesoClientesR){ ?>
									<li class="<?=$cClientesR; ?>"><a href="?route=Clientes&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Lider</a></li>
								<?php } ?>
								<?php if($accesoClientesC){ ?>
									<li class="<?=$cClientesC; ?>"><a href="?route=Clientes"><i class="fa fa-user"></i> Ver Lideres</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cClientesB; ?>"><a href="?route=Clientes&action=Borrados"><i class="fa fa-user"></i> Ver Lideres Suspendidos</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	ESTRUCTURAS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoEstructuras = false;
							$accesoEstructurasR = false;
							$accesoEstructurasC = false;
							$accesoEstructurasM = false;
							$accesoEstructurasE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Estructuras")){
										$accesoEstructuras = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoEstructurasR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoEstructurasC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoEstructurasM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoEstructurasE=true; }
									}
								}
							}
							$Estructuras = "";
							if($url=="Estructuras"){
								$Estructuras = "active";
							}
						?>
						<?php if($accesoEstructuras){ ?>
						<li class="<?=$Estructuras; ?> treeview">
							<a href="#">
								<i class="fa fa-users"></i> <span>Estructuras de Lideres</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$EstructurasR = "";
									$EstructurasC = "";
									$EstructurasB = "";
									if($url=="Estructuras" && !empty($action) && $action == "Registrar"){
										$EstructurasR = "active";
									}
									if($url=="Estructuras" && !empty($action) && $action == "Consultar"){
										$EstructurasC = "active";
									}
									if($url=="Estructuras" && !empty($action) && $action == "Borrados"){
										$EstructurasB = "active";
									}
								?>
								<?php if($accesoEstructurasR){ ?>
									<li class="<?=$EstructurasR; ?>"><a href="?route=Estructuras&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Estructura de Lideres</a></li>
								<?php } ?>
								<?php if($accesoEstructurasC){ ?>
									<li class="<?=$EstructurasC; ?>"><a href="?route=Estructuras"><i class="fa fa-user"></i> Ver Estructuras de Lideres</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$EstructurasB; ?>"><a href="?route=Estructuras&action=Borrados"><i class="fa fa-user"></i> Ver Estructuras Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	CICLOS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoCiclos = false;
							$accesoCiclosR = false;
							$accesoCiclosC = false;
							$accesoCiclosM = false;
							$accesoCiclosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Ciclos")){
										$accesoCiclos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoCiclosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoCiclosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoCiclosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoCiclosE=true; }
									}
								}
							}
							$cCiclos = "";
							if($url=="Ciclos"){
								$cCiclos = "active";
							}
						?>
						<?php if($accesoCiclos){ ?>
						<li class="<?=$cCiclos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Ciclos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cCiclosR = "";
									$cCiclosC = "";
									$cCiclosB = "";
									$cCiclosP = "";
									if($url=="Ciclos" && !empty($action) && $action == "Registrar"){
										$cCiclosR = "active";
									}
									if($url=="Ciclos" && !empty($action) && $action == "Consultar"){
										$cCiclosC = "active";
									}
									if($url=="Ciclos" && !empty($action) && $action == "Borrados"){
										$cCiclosB = "active";
									}
									if($url=="Ciclos" && !empty($action) && $action == "Personalizar"){
										$cCiclosP = "active";
									}
								?>
								<?php if($accesoCiclosR){ ?>
									<li class="<?=$cCiclosR; ?>"><a href="?route=Ciclos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Ciclo</a></li>
								<?php } ?>
								<?php if($accesoCiclosC){ ?>
									<li class="<?=$cCiclosC; ?>"><a href="?route=Ciclos"><i class="fa fa-puzzle-piece"></i> Ver Ciclos</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cCiclosB; ?>"><a href="?route=Ciclos&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Ciclos Borrados</a></li>
								<?php } ?>
								<?php if($accesoCiclosR){ ?>
									<li class="<?=$cCiclosP; ?>"><a href="?route=Ciclos&action=Personalizar"><i class="fa fa-puzzle-piece"></i> Personalizar Ciclo</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	INVENTARIO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoInventarios = false;
							$accesoInventariosR = false;
							$accesoInventariosC = false;
							$accesoInventariosM = false;
							$accesoInventariosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Inventarios")){
										$accesoInventarios = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoInventariosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoInventariosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoInventariosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoInventariosE=true; }
									}
								}
							}
							$cInventario = "";
							if($url=="Inventario"){
								$cInventario = "active";
							}
						?>
						<?php if($accesoInventarios){ ?>
						<li class="<?=$cInventario; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Inventario</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cInventarioR = "";
									$cInventarioC = "";
									$cInventarioB = "";
									$cInventarioF = "";
									if($url=="Inventario" && !empty($action) && $action == "Registrar"){
										$cInventarioR = "active";
									}
									if($url=="Inventario" && !empty($action) && $action == "Consultar"){
										$cInventarioC = "active";
									}
									if($url=="Inventario" && !empty($action) && $action == "Borrados"){
										$cInventarioB = "active";
									}
									if($url=="Inventario" && !empty($action) && $action == "Fechas"){
										$cInventarioF = "active";
									}
								?>
								<?php if($accesoInventariosR){ ?>
									<li class="<?=$cInventarioR; ?>"><a href="?route=Inventario&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Inventario</a></li>
								<?php } ?>
								<?php if($accesoInventariosC){ ?>
									<li class="<?=$cInventarioC; ?>"><a href="?route=Inventario"><i class="fa fa-puzzle-piece"></i> Ver Inventarios</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cInventarioB; ?>"><a href="?route=Inventario&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Inventarios Borrados</a></li>
								<?php } ?>
								<?php if($accesoInventariosR){ ?>
									<li class="<?=$cInventarioF; ?>"><a href="?route=Inventario&action=Fechas"><i class="fa fa-puzzle-piece"></i> Fechas de Inventario</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	EXISTENCIA DE PREMIOS DE INVENTARIO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoExistencias = false;
							$accesoExistenciasR = false;
							$accesoExistenciasC = false;
							$accesoExistenciasM = false;
							$accesoExistenciasE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Existencias")){
										$accesoExistencias = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoExistenciasR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoExistenciasC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoExistenciasM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoExistenciasE=true; }
									}
								}
							}
							$cExistencias = "";
							if($url=="Existencias"){
								$cExistencias = "active";
							}
						?>
						<?php if($accesoExistencias){ ?>
						<li class="<?=$cExistencias; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Existencias</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cExistenciasR = "";
									$cExistenciasC = "";
									$cExistenciasB = "";
									if($url=="Existencias" && !empty($action) && $action == "Registrar"){
										$cExistenciasR = "active";
									}
									if($url=="Existencias" && !empty($action) && $action == "Consultar"){
										$cExistenciasC = "active";
									}
									if($url=="Existencias" && !empty($action) && $action == "Borrados"){
										$cExistenciasB = "active";
									}
								?>
								<?php if($accesoExistenciasR){ ?>
									<li class="<?=$cExistenciasR; ?>"><a href="?route=Existencias&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Existencias</a></li>
								<?php } ?>
								<?php if($accesoExistenciasC){ ?>
									<li class="<?=$cExistenciasC; ?>"><a href="?route=Existencias"><i class="fa fa-puzzle-piece"></i> Ver Existencias</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cExistenciasB; ?>"><a href="?route=Existencias&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Existencias Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	LIDERAZGOS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoCatalogos = false;
							$accesoCatalogosR = false;
							$accesoCatalogosC = false;
							$accesoCatalogosM = false;
							$accesoCatalogosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Catalogos")){
										$accesoCatalogos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoCatalogosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoCatalogosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoCatalogosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoCatalogosE=true; }
									}
								}
							}
							$cCatalogos = "";
							if($url=="Catalogos"){
								$cCatalogos = "active";
							}
						?>
						<?php if($accesoCatalogos){ ?>
						<li class="<?=$cCatalogos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Canjeos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cCatalogosR = "";
									$cCatalogosC = "";
									$cCatalogosB = "";
									if($url=="Catalogos" && !empty($action) && $action == "Registrar"){
										$cCatalogosR = "active";
									}
									if($url=="Catalogos" && !empty($action) && $action == "Canjeos"){
										$cCatalogosC = "active";
									}
									if($url=="Catalogos" && !empty($action) && $action == "Borrados"){
										$cCatalogosB = "active";
									}
								?>
								<?php if($accesoCatalogosR){ ?>
									<!-- <li class="<?=$cCatalogosR; ?>"><a href="?route=Catalogos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Liderazgo</a></li> -->
								<?php } ?>
								<?php if($accesoCatalogosC){ ?>
									<li class="<?=$cCatalogosC; ?>"><a href="?route=Catalogos&action=Canjeos&op=1"><i class="fa fa-puzzle-piece"></i> Ver Canjeos</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	NOTAS DE ENTREGA EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoNotas = false;
							$accesoNotasR = false;
							$accesoNotasC = false;
							$accesoNotasM = false;
							$accesoNotasE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Notas")){
										$accesoNotas = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoNotasR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoNotasC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoNotasM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoNotasE=true; }
									}
								}
							}
							// $accesoNotasAutorizados = false;
							// $accesoNotasAutorizadosR = false;
							// $accesoNotasAutorizadosC = false;
							// $accesoNotasAutorizadosM = false;
							// $accesoNotasAutorizadosE = false;
							// foreach ($_SESSION['home']['accesos'] as $acc) {
							// 	if(!empty($acc['id_rol'])){
							// 		if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Notas Autorizados")){
							// 			$accesoNotasAutorizados = true;
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoNotasAutorizadosR=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoNotasAutorizadosC=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoNotasAutorizadosM=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoNotasAutorizadosE=true; }
							// 		}
							// 	}
							// }
							$cNotas = "";
							// $cNotasAutorizados = "";
							if($url=="Notass"){
								$cNotas = "active";
								// $cNotasAutorizados = "active";
							}
						?>
						<?php if($accesoNotasR && $accesoNotasC){ ?>
						<li class="<?=$cNotas; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Notas de entrega</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cNotasRC = "";
									if($url=="Notass" && !empty($action) && $action == "Registrar"){
										$cNotasRC = "active";
									}
									if($url=="Notass" && !empty($action) && $action == "Consultar"){
										$cNotasRC = "active";
									}
								?>
								<?php if($accesoNotasR && $accesoNotasC){ ?>
									<li class="<?=$cNotasRC; ?>"><a href="?route=Notass&action=Redirigir"><i class="fa fa-puzzle-piece"></i> Ir a Crear Notas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	LIDERAZGOS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoLiderazgos = false;
							$accesoLiderazgosR = false;
							$accesoLiderazgosC = false;
							$accesoLiderazgosM = false;
							$accesoLiderazgosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos")){
										$accesoLiderazgos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoLiderazgosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoLiderazgosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoLiderazgosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoLiderazgosE=true; }
									}
								}
							}
							$cLiderazgos = "";
							if($url=="Liderazgos"){
								$cLiderazgos = "active";
							}
						?>
						<?php if($accesoLiderazgos){ ?>
						<li class="<?=$cLiderazgos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Liderazgos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cLiderazgosR = "";
									$cLiderazgosC = "";
									$cLiderazgosB = "";
									if($url=="Liderazgos" && !empty($action) && $action == "Registrar"){
										$cLiderazgosR = "active";
									}
									if($url=="Liderazgos" && !empty($action) && $action == "Consultar"){
										$cLiderazgosC = "active";
									}
									if($url=="Liderazgos" && !empty($action) && $action == "Borrados"){
										$cLiderazgosB = "active";
									}
								?>
								<?php if($accesoLiderazgosR){ ?>
									<li class="<?=$cLiderazgosR; ?>"><a href="?route=Liderazgos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Liderazgo</a></li>
								<?php } ?>
								<?php if($accesoLiderazgosC){ ?>
									<li class="<?=$cLiderazgosC; ?>"><a href="?route=Liderazgos"><i class="fa fa-puzzle-piece"></i> Ver Liderazgos</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cLiderazgosB; ?>"><a href="?route=Liderazgos&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Liderazgos Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	USUARIOS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoUsuarios = false;
							$accesoUsuariosR = false;
							$accesoUsuariosC = false;
							$accesoUsuariosM = false;
							$accesoUsuariosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Usuarios")){
										$accesoUsuarios = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoUsuariosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoUsuariosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoUsuariosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoUsuariosE=true; }
									}
								}
							}
							$cUsuarios = "";
							if($url=="Usuarios"){
								$cUsuarios = "active";
							}
						?>
						<?php if($accesoUsuarios){ ?>
						<li class="<?=$cUsuarios; ?> treeview">
							<a href="#">
								<i class="fa fa-users"></i> <span>Usuarios</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cUsuariosR = "";
									$cUsuariosC = "";
									$cUsuariosB = "";
									if($url=="Usuarios" && !empty($action) && $action == "Registrar"){
										$cUsuariosR = "active";
									}
									if($url=="Usuarios" && !empty($action) && $action == "Consultar"){
										$cUsuariosC = "active";
									}
									if($url=="Usuarios" && !empty($action) && $action == "Borrados"){
										$cUsuariosB = "active";
									}
								?>
								<?php if($accesoUsuariosR){ ?>
									<li class="<?=$cUsuariosR; ?>"><a href="?route=Usuarios&action=Registrar"><i class="fa fa-user-plus"></i> Registrar Usuario</a></li>
								<?php } ?>
								<?php if($accesoUsuariosC){ ?>
									<li class="<?=$cUsuariosC; ?>"><a href="?route=Usuarios"><i class="fa fa-user"></i> Ver Usuarios</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cUsuariosB; ?>"><a href="?route=Usuarios&action=Borrados"><i class="fa fa-user"></i> Ver Usuarios Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	Reportes	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoReportes = false;
							$accesoReportesC = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Reportes")){
										$accesoReportes = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoReportesC=true; }
									}
								}
							}
							$cReportes = "";
							if($url=="Reportes"){
								$cReportes = "active";
							}
						?>
						<?php if($accesoReportes){ ?>
						<li class="<?=$cReportes; ?> treeview">
							<a href="#">
								<i class="fa fa-file"></i> <span>Reportes</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cReportesSolicitados = "";
									$cReportesAprobados = "";
									$cReportesProcentajeProductos = "";
									if($url=="Reportes" && !empty($action) && $action == "ProductosSolicitados"){
										$cReportesSolicitados = "active";
									}
									if($url=="Reportes" && !empty($action) && $action == "ProductosAprobados"){
										$cReportesAprobados = "active";
									}
									if($url=="Reportes" && !empty($action) && $action == "PorcentajeProductos"){
										$cReportesProcentajeProductos = "active";
									}
								?>
								<?php if($accesoReportesC){ ?>
									<li class="<?=$cReportesSolicitados; ?>"><a href="?route=Reportes&action=ProductosSolicitados"><i class="fa fa-file-pdf-o"></i> Productos solicitados</a></li>
									<li class="<?=$cReportesAprobados; ?>"><a href="?route=Reportes&action=ProductosAprobados"><i class="fa fa-file-pdf-o"></i> Productos aprobados</a></li>
									<li class="<?=$cReportesProcentajeProductos; ?>"><a href="?route=Reportes&action=PorcentajeProductos"><i class="fa fa-file-pdf-o"></i> Porcentaje de Productos</a></li>
									<!-- <li class="treeview <?=$cReportesSolicitados." ".$cReportesAprobados." ".$cReportesProcentajeProductos; ?>">
										<a href="?route=Reportes">
											<i class="fa fa-file-pdf-o" style="background:;"></i> <span>Porcentajes</span>
											<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
										</a>
										<ul class="treeview-menu">
											<li class="<?=$cReportesSolicitados; ?>"><a href="?route=Reportes&action=ProductosSolicitados"><i class="fa fa-file-pdf-o"></i> Productos solicitados</a></li>
											<li class="<?=$cReportesAprobados; ?>"><a href="?route=Reportes&action=ProductosAprobados"><i class="fa fa-file-pdf-o"></i> Productos aprobados</a></li>
										</ul>
									</li> -->
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	SEGURIDAD	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoBitacora = false;
							$accesoBitacoraR = false;
							$accesoBitacoraC = false;
							$accesoBitacoraM = false;
							$accesoBitacoraE = false;

							$accesoPermisos = false;
							$accesoPermisosR = false;
							$accesoPermisosC = false;
							$accesoPermisosM = false;
							$accesoPermisosE = false;

							$accesoModulos = false;
							$accesoModulosR = false;
							$accesoModulosC = false;
							$accesoModulosM = false;
							$accesoModulosE = false;

							$accesoRoles = false;
							$accesoRolesR = false;
							$accesoRolesC = false;
							$accesoRolesM = false;
							$accesoRolesE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Bitacora")){
										$accesoBitacora = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoBitacoraR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoBitacoraC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoBitacoraM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoBitacoraE=true; }
									}
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Permisos")){
										$accesoPermisos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPermisosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPermisosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPermisosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPermisosE=true; }
									}
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Modulos")){
										$accesoModulos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoModulosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoModulosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoModulosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoModulosE=true; }
									}
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Roles")){
										$accesoRoles = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoRolesR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoRolesC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoRolesM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoRolesE=true; }
									}
								}
							}
							$cSeguridad = "";
							if($url=="Bitácora" || $url=="Permisos" || $url=="Modulos" || $url=="Roles"){
								$cSeguridad = "active";
							}
						?>
						<?php if($accesoBitacora && $accesoPermisos && $accesoModulos && $accesoRoles){ ?>
						<li class="header">SEGURIDAD</li>
						<li class="<?=$cSeguridad; ?> treeview">
							<a href="#">
								<i class="fa fa-cogs"></i> <span>Seguridad</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu treeview-menu2">
								<!-- ======================================================================================================== -->
									<!--	SEGURIDAD	-->
								<!-- ======================================================================================================== -->
									<?php
									$cBitacora = "";
									if($url=="Bitácora"){
										$cBitacora = "active";
									}
								?>
								<?php if($accesoBitacora){ ?>
								<li class="<?=$cBitacora; ?>">
									<a href="?route=Bitacora">
										<i class="fa fa-home"></i> <span>Bitacora</span>
										<span class="pull-right-container">
										</span>
									</a>
								</li>
								<?php } ?>
								<!-- ======================================================================================================== -->

								<!-- ======================================================================================================== -->
									<!--	PERMISOS	-->
								<!-- ======================================================================================================== -->

								<?php
									$cPermisos = "";
									if($url=="Permisos"){
										$cPermisos = "active";
									}
								?>
								<?php if($accesoPermisos){ ?>
								<li class="<?=$cPermisos; ?> treeview">
									<a href="#">
										<i class="fa fa-cogs"></i> <span>Permisos</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu treeview-menu3">
										<?php
											$cPermisosR = "";
											$cPermisosC = "";
											$cPermisosB = "";
											if($url=="Permisos" && !empty($action) && $action == "Registrar"){
												$cPermisosR = "active";
											}
											if($url=="Permisos" && !empty($action) && $action == "Consultar"){
												$cPermisosC = "active";
											}
											if($url=="Permisos" && !empty($action) && $action == "Borrados"){
												$cPermisosB = "active";
											}
										?>
										<?php if($accesoPermisosR){ ?>
											<li class="<?=$cPermisosR; ?>"><a href="?route=Permisos&action=Registrar"><i class="fa fa-cog"></i> Registrar Permiso</a></li>
										<?php } ?>
										<?php if($accesoPermisosC){ ?>
											<li class="<?=$cPermisosC; ?>"><a href="?route=Permisos&action=Consultar"><i class="fa fa-cog"></i> Ver Permisos</a></li>
										<?php } ?>
										<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
											<li class="<?=$cPermisosB; ?>"><a href="?route=Permisos&action=Borrados"><i class="fa fa-cog"></i> Ver Permisos Borrados</a></li>
										<?php } ?>
									</ul>
								</li>
								<?php } ?>
								<!-- ======================================================================================================== -->


								<!-- ======================================================================================================== -->
									<!--	MODULOS	-->
								<!-- ======================================================================================================== -->

								<?php
									$cModulos = "";
									if($url=="Modulos"){
										$cModulos = "active";
									}
								?>
								<?php if($accesoModulos){ ?>
								<li class="<?=$cModulos; ?> treeview">
									<a href="#">
										<i class="fa fa-cogs"></i> <span>Modulos</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu treeview-menu3">
										<?php
											$cModulosR = "";
											$cModulosC = "";
											$cModulosB = "";
											if($url=="Modulos" && !empty($action) && $action == "Registrar"){
												$cModulosR = "active";
											}
											if($url=="Modulos" && !empty($action) && $action == "Consultar"){
												$cModulosC = "active";
											}
											if($url=="Modulos" && !empty($action) && $action == "Borrados"){
												$cModulosB = "active";
											}
										?>
										<?php if($accesoModulosR){ ?>
											<li class="<?=$cModulosR; ?>"><a href="?route=Modulos&action=Registrar"><i class="fa fa-cog"></i> Registrar Modulo</a></li>
										<?php } ?>
										<?php if($accesoModulosC){ ?>
											<li class="<?=$cModulosC; ?>"><a href="?route=Modulos&action=Consultar"><i class="fa fa-cog"></i> Ver Modulos</a></li>
										<?php } ?>
										<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
											<li class="<?=$cModulosB; ?>"><a href="?route=Modulos&action=Borrados"><i class="fa fa-cog"></i> Ver Modulos Borrados</a></li>
										<?php } ?>
									</ul>
								</li>
								<?php } ?>
								<!-- ======================================================================================================== -->

								<!-- ======================================================================================================== -->
									<!--	ROLES	-->
								<!-- ======================================================================================================== -->

								<?php
									$cRoles = "";
									if($url=="Roles"){
										$cRoles = "active";
									}
								?>
								<?php if($accesoRoles){ ?>
								<li class="<?=$cRoles; ?> treeview">
									<a href="#">
										<i class="fa fa-cogs"></i> <span>Roles</span>
										<span class="pull-right-container">
											<i class="fa fa-angle-left pull-right"></i>
										</span>
									</a>
									<ul class="treeview-menu treeview-menu3">
										<?php
											$cRolesR = "";
											$cRolesC = "";
											$cRolesB = "";
											if($url=="Roles" && !empty($action) && $action == "Registrar"){
												$cRolesR = "active";
											}
											if($url=="Roles" && !empty($action) && $action == "Consultar"){
												$cRolesC = "active";
											}
											if($url=="Roles" && !empty($action) && $action == "Borrados"){
												$cRolesB = "active";
											}
										?>
										<?php if($accesoRolesR){ ?>
											<li class="<?=$cRolesR; ?>"><a href="?route=Roles&action=Registrar"><i class="fa fa-cog"></i> Registrar Rol</a></li>
										<?php } ?>
										<?php if($accesoRolesC){ ?>
											<li class="<?=$cRolesC; ?>"><a href="?route=Roles&action=Consultar"><i class="fa fa-cog"></i> Ver Roles</a></li>
										<?php } ?>
										<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
											<li class="<?=$cRolesB; ?>"><a href="?route=Roles&action=Borrados"><i class="fa fa-cog"></i> Ver Roles Borrados</a></li>
										<?php } ?>
									</ul>
								</li>
								<?php } ?>
								<!-- ======================================================================================================== -->
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->
				
				<!-- ======================================================================================================================= -->
			<?php } ?>
			<?php if($dentroCiclo==true){ ?>
				<!-- ======================================================================================================================= -->
					<!--	NAVEGACION DENTRO DEL CICLO	-->
				<!-- ======================================================================================================================= -->
				<style>
					/*.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #906;} 
					.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#a17;}
					.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #805;}
					.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #a17;}
					.skin-blue .sidebar-menu > li.active > a {  border-left-color: #805;}*/
					
					.skin-blue .wrapper,.skin-blue .main-sidebar,.skin-blue .left-side {  background-color: #232323;} 
					.skin-blue .sidebar-menu > li:hover > a,.skin-blue .sidebar-menu > li.active > a,.skin-blue .sidebar-menu > li.menu-open > a {  color: #DDD;  background:#323232;}
					.skin-blue .sidebar-menu > li > .treeview-menu {  margin: 0 1px;  background: #434343;}
					.skin-blue .sidebar-menu > li.header {  color: #ddd;  background: #323232;}
					.skin-blue .sidebar-menu > li.active > a {  border-left-color: #101010;}

					/*.color-corto{  color:#EA018C;}
					.color-completo{  color:#FFF;}*/
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
					<li class="header">NAVEGACION EN CICLO <?=$num_ciclo."/".$ano_ciclo; ?></li>

					<!-- ======================================================================================================================= -->
						<!--	CHOME	-->
					<!-- ======================================================================================================================= -->
						<?php
							$cHome="";
							if($url == "CHome" && empty($_GET['action'])){
								$cHome="active";
							}
						?>
						<li class="<?=$cHome; ?>">
							<a href="?<?=$menu; ?>&route=CHome">
								<i class="fa fa-home"></i> <span>Ciclo <?=$num_ciclo."/".$ano_ciclo; ?></span>
								<span class="pull-right-container">
									<!-- <small class="label pull-right bg-green">new</small> -->
								</span>
							</a>
						</li>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	LIDERAZGOS DE CICLOS	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoLiderazgosCiclos = false;
							$accesoLiderazgosCiclosR = false;
							$accesoLiderazgosCiclosC = false;
							$accesoLiderazgosCiclosM = false;
							$accesoLiderazgosCiclosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Liderazgos De Ciclos")){
										$accesoLiderazgosCiclos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoLiderazgosCiclosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoLiderazgosCiclosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoLiderazgosCiclosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoLiderazgosCiclosE=true; }
									}
								}
							}
							$cLiderazgosCiclos = "";
							if($url=="LiderazgosCiclos"){
								$cLiderazgosCiclos = "active";
							}
						?>
						<?php if($accesoLiderazgosCiclos){ ?>
						<li class="<?=$cLiderazgosCiclos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Liderazgos de Ciclos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cLiderazgosCiclosR = "";
									$cLiderazgosCiclosC = "";
									$cLiderazgosCiclosB = "";
									if($url=="LiderazgosCiclos" && !empty($action) && $action == "Registrar"){
										$cLiderazgosCiclosR = "active";
									}
									if($url=="LiderazgosCiclos" && !empty($action) && $action == "Consultar"){
										$cLiderazgosCiclosC = "active";
									}
									if($url=="LiderazgosCiclos" && !empty($action) && $action == "Borrados"){
										$cLiderazgosCiclosB = "active";
									}
								?>
								<?php if($accesoLiderazgosCiclosR){ ?>
									<li class="<?=$cLiderazgosCiclosR; ?>"><a href="?<?=$menu; ?>&route=LiderazgosCiclos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Liderazgos</a></li>
								<?php } ?>
								<?php if($accesoLiderazgosCiclosC){ ?>
									<li class="<?=$cLiderazgosCiclosC; ?>"><a href="?<?=$menu; ?>&route=LiderazgosCiclos"><i class="fa fa-puzzle-piece"></i> Ver Liderazgos de Ciclos</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cLiderazgosCiclosB; ?>"><a href="?<?=$menu; ?>&route=LiderazgosCiclos&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Liderazgos Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	PUNTOS DE LIDERES EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoPuntos = false;
							$accesoPuntosR = false;
							$accesoPuntosC = false;
							$accesoPuntosM = false;
							$accesoPuntosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Puntos")){
										$accesoPuntos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPuntosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPuntosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPuntosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPuntosE=true; }
									}
								}
							}
							$cPuntos = "";
							if($url=="Puntos"){
								$cPuntos = "active";
							}
							$accesoPuntosR = false;
						?>
						<?php if($accesoPuntos){ ?>
						<li class="<?=$cPuntos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Puntos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cPuntosR = "";
									$cPuntosC = "";
									$cPuntosB = "";
									if($url=="Puntos" && !empty($action) && $action == "Registrar"){
										$cPuntosR = "active";
									}
									if($url=="Puntos" && !empty($action) && $action == "Consultar"){
										$cPuntosC = "active";
									}
									if($url=="Puntos" && !empty($action) && $action == "Borrados"){
										$cPuntosB = "active";
									}
								?>
								<?php if($accesoPuntosR){ ?>
									<li class="<?=$cPuntosR; ?>"><a href="?<?=$menu; ?>&route=Puntos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Puntos</a></li>
								<?php } ?>
								<?php if($accesoPuntosC){ ?>
									<li class="<?=$cPuntosC; ?>"><a href="?<?=$menu; ?>&route=Puntos"><i class="fa fa-puzzle-piece"></i> Ver Puntos</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cPuntosB; ?>"><a href="?<?=$menu; ?>&route=Puntos&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Puntos Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	PUNTOS DE LIDERES EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoPuntosAutorizados = false;
							$accesoPuntosAutorizadosR = false;
							$accesoPuntosAutorizadosC = false;
							$accesoPuntosAutorizadosM = false;
							$accesoPuntosAutorizadosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Puntos Autorizados")){
										$accesoPuntosAutorizados = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPuntosAutorizadosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPuntosAutorizadosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPuntosAutorizadosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPuntosAutorizadosE=true; }
									}
								}
							}
							$cPuntosAutorizados = "";
							if($url=="PuntosAutorizados"){
								$cPuntosAutorizados = "active";
							}
						?>
						<?php if($accesoPuntosAutorizados){ ?>
						<li class="<?=$cPuntosAutorizados; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Puntos Autorizados</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cPuntosAutorizadosR = "";
									$cPuntosAutorizadosC = "";
									$cPuntosAutorizadosB = "";
									if($url=="PuntosAutorizados" && !empty($action) && $action == "Registrar"){
										$cPuntosAutorizadosR = "active";
									}
									if($url=="PuntosAutorizados" && !empty($action) && $action == "Consultar"){
										$cPuntosAutorizadosC = "active";
									}
									if($url=="PuntosAutorizados" && !empty($action) && $action == "Borrados"){
										$cPuntosAutorizadosB = "active";
									}
								?>
								<?php if($accesoPuntosAutorizadosR){ ?>
									<li class="<?=$cPuntosAutorizadosR; ?>"><a href="?<?=$menu; ?>&route=PuntosAutorizados&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Puntos Autorizados</a></li>
								<?php } ?>
								<?php if($accesoPuntosAutorizadosC){ ?>
									<li class="<?=$cPuntosAutorizadosC; ?>"><a href="?<?=$menu; ?>&route=PuntosAutorizados"><i class="fa fa-puzzle-piece"></i> Ver Puntos Autorizados</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cPuntosAutorizadosB; ?>"><a href="?<?=$menu; ?>&route=PuntosAutorizados&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Puntos Autorizados Borradas</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	FACTURACION DE PEDIDOS EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoFacturacion = false;
							$accesoFacturacionR = false;
							$accesoFacturacionC = false;
							$accesoFacturacionM = false;
							$accesoFacturacionE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Facturacion")){
										$accesoFacturacion = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoFacturacionR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoFacturacionC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoFacturacionM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoFacturacionE=true; }
									}
								}
							}
							$cFacturacion = "";
							if($url=="Facturacion"){
								$cFacturacion = "active";
							}
						?>
						<?php if($accesoFacturacion && $_SESSION['home']['nombre_rol']=="Superusuario"){ ?>
						<li class="<?=$cFacturacion; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Facturacion de pedidos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cFacturacionF = "";
									$cFacturacionR = "";
									$cFacturacionC = "";
									$cFacturacionB = "";
									if($url=="Facturacion" && !empty($action) && $action == "Fiscal"){
										$cFacturacionF = "active";
									}
									if($url=="Facturacion" && !empty($action) && $action == "Registrar"){
										$cFacturacionR = "active";
									}
									if($url=="Facturacion" && !empty($action) && $action == "Consultar"){
										$cFacturacionC = "active";
									}
									if($url=="Facturacion" && !empty($action) && $action == "Borrados"){
										$cFacturacionB = "active";
									}
								?>
								<?php if($accesoFacturacionR){ ?>
									<li class="<?=$cFacturacionR; ?>"><a href="?<?=$menu; ?>&route=Facturacion&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Facturacion</a></li>
								<?php } ?>
								<?php if($accesoFacturacionC){ ?>
									<li class="<?=$cFacturacionC; ?>"><a href="?<?=$menu; ?>&route=Facturacion"><i class="fa fa-puzzle-piece"></i> Ver Facturacion</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cFacturacionB; ?>"><a href="?<?=$menu; ?>&route=Facturacion&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Facturacion Borrados</a></li>
								<?php } ?>
								<?php if($accesoFacturacionR){ ?>
									<li class="<?=$cFacturacionF; ?>"><a href="?<?=$menu; ?>&route=Facturacion&action=Fiscal"><i class="fa fa-puzzle-piece"></i> Registrar Precio Fiscal</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					<!-- ======================================================================================================================= -->
						<!--	PAGOS EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoPagos = false;
							$accesoPagosR = false;
							$accesoPagosC = false;
							$accesoPagosM = false;
							$accesoPagosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos")){
										$accesoPagos = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosE=true; }
									}
								}
							}
							$accesoPagosAutorizados = false;
							$accesoPagosAutorizadosR = false;
							$accesoPagosAutorizadosC = false;
							$accesoPagosAutorizadosM = false;
							$accesoPagosAutorizadosE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Pagos Autorizados")){
										$accesoPagosAutorizados = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoPagosAutorizadosR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoPagosAutorizadosC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoPagosAutorizadosM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoPagosAutorizadosE=true; }
									}
								}
							}
							$cPagos = "";
							$cPagosAutorizados = "";
							if($url=="Pagos"){
								$cPagos = "active";
								$cPagosAutorizados = "active";
							}
						?>
						<?php if($accesoPagos || $accesoPagosAutorizados){ ?>
						<li class="<?=$cPagos; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Pagos</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cPagosR = "";
									$cPagosC = "";
									$cPagosF = "";
									$cPagosB = "";
									if($url=="Pagos" && !empty($action) && $action == "Registrar"){
										$cPagosR = "active";
									}
									if($url=="Pagos" && !empty($action) && $action == "Consultar"){
										$cPagosC = "active";
									}
									if($url=="Pagos" && !empty($action) && $action == "Filtrar"){
										$cPagosF = "active";
									}
									if($url=="Pagos" && !empty($action) && $action == "Borrados"){
										$cPagosB = "active";
									}
									$cPagosAutorizadosR = "";
									$cPagosAutorizadosC = "";
									$cPagosAutorizadosB = "";
									if($url=="Pagos" && !empty($action) && $action == "RegistrarAutorizados"){
										$cPagosAutorizadosR = "active";
									}
									if($url=="Pagos" && !empty($action) && $action == "ConsultarAutorizados"){
										$cPagosAutorizadosC = "active";
									}
									if($url=="Pagos" && !empty($action) && $action == "BorradosAutorizados"){
										$cPagosAutorizadosB = "active";
									}
									$pedidosActivos = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos.id_ciclo = {$id_ciclo} and pedidos.id_cliente={$id_cliente}");
									$facturaPedidoAp = 0;
									if(count($pedidosActivos)>1){
										foreach ($pedidosActivos as $key) { if(!empty($key['id_pedido'])){
											$facturaPedidoAp += $key['cantidad_aprobada'];
										} }
									}
								?>
								<?php if($accesoPagosAutorizadosR){ ?>
									<li class="<?=$cPagosAutorizadosR; ?>"><a href="?<?=$menu; ?>&route=Pagos&action=RegistrarAutorizados"><i class="fa fa-puzzle-piece"></i> Registrar Pagos Autorizados</a></li>
								<?php } ?>
								<?php if($accesoPagosR){ ?>
									<?php if ( (!$personalAdmin && $facturaPedidoAp>0) || ($personalAdmin) ){ ?>
									<li class="<?=$cPagosR; ?>"><a href="?<?=$menu; ?>&route=Pagos&action=Registrar"><i class="fa fa-puzzle-piece"></i> Registrar Pagos</a></li>
									<?php } ?>
								<?php } ?>
								<?php if($accesoPagosC){ ?>
									<li class="<?=$cPagosC; ?>"><a href="?<?=$menu; ?>&route=Pagos&rangoI=<?=date('Y-m-d', time()-(((60*60)*24)*7)); ?>&rangoF=<?=date('Y-m-d'); ?>"><i class="fa fa-puzzle-piece"></i> Ver Pagos</a></li>
								<?php } ?>
								<?php if($personalInterno){ ?>
									<li class="<?=$cPagosF; ?>"><a href="?<?=$menu; ?>&route=Pagos&action=Filtrar"><i class="fa fa-puzzle-piece"></i> Filtro de Pagos</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cPagosB; ?>"><a href="?<?=$menu; ?>&route=Pagos&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Pagos Borrados</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->


					<!-- ======================================================================================================================= -->
						<!--	NOTAS DE ENTREGA EN EL CICLO	-->
					<!-- ======================================================================================================================= -->
						<?php
							$accesoNotas = false;
							$accesoNotasR = false;
							$accesoNotasC = false;
							$accesoNotasM = false;
							$accesoNotasE = false;
							foreach ($_SESSION['home']['accesos'] as $acc) {
								if(!empty($acc['id_rol'])){
									if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Notas")){
										$accesoNotas = true;
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoNotasR=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoNotasC=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoNotasM=true; }
										if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoNotasE=true; }
									}
								}
							}
							// $accesoNotasAutorizados = false;
							// $accesoNotasAutorizadosR = false;
							// $accesoNotasAutorizadosC = false;
							// $accesoNotasAutorizadosM = false;
							// $accesoNotasAutorizadosE = false;
							// foreach ($_SESSION['home']['accesos'] as $acc) {
							// 	if(!empty($acc['id_rol'])){
							// 		if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Notas Autorizados")){
							// 			$accesoNotasAutorizados = true;
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PRegistrar)){ $accesoNotasAutorizadosR=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoNotasAutorizadosC=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PModificar)){ $accesoNotasAutorizadosM=true; }
							// 			if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PEliminar)){ $accesoNotasAutorizadosE=true; }
							// 		}
							// 	}
							// }
							$cNotas = "";
							// $cNotasAutorizados = "";
							if($url=="Notas"){
								$cNotas = "active";
								// $cNotasAutorizados = "active";
							}
						?>
						<?php if($accesoNotas){ ?>
						<li class="<?=$cNotas; ?> treeview">
							<a href="#">
								<i class="fa fa-object-group"></i> <span>Notas de entrega</span>
								<span class="pull-right-container">
									<i class="fa fa-angle-left pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu">
								<?php
									$cNotasR = "";
									$cNotasC = "";
									$cNotasF = "";
									$cNotasB = "";
									if($url=="Notas" && !empty($action) && $action == "Registrar"){
										$cNotasR = "active";
									}
									if($url=="Notas" && !empty($action) && $action == "Consultar"){
										$cNotasC = "active";
									}
									if($url=="Notas" && !empty($action) && $action == "Filtrar"){
										$cNotasF = "active";
									}
									if($url=="Notas" && !empty($action) && $action == "Borrados"){
										$cNotasB = "active";
									}
								?>
								<?php if($accesoNotasR){ ?>
									<?php if ( (!$personalAdmin && $facturaPedidoAp>0) || ($personalAdmin) ){ ?>
									<li class="<?=$cNotasR; ?>"><a href="?<?=$menu; ?>&route=Notas&action=Registrar"><i class="fa fa-puzzle-piece"></i> Crear Notas de entrega</a></li>
									<?php } ?>
								<?php } ?>
								<?php if($accesoNotasC){ ?>
									<li class="<?=$cNotasC; ?>"><a href="?<?=$menu; ?>&route=Notas"><i class="fa fa-puzzle-piece"></i> Ver Notas de entrega</a></li>
								<?php } ?>
								<?php
									if(
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Superusuario") || 
										mb_strtolower($_SESSION['home']['nombre_rol'])==mb_strtolower("Administrador2")
									){ 
								?>
									<li class="<?=$cNotasB; ?>"><a href="?<?=$menu; ?>&route=Notas&action=Borrados"><i class="fa fa-puzzle-piece"></i> Ver Notas Borrados</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
					<!-- ======================================================================================================================= -->



					

					<!-- ======================================================================================================================= -->
						<!--	SALIDA DEL CICLO	-->
					<!-- ======================================================================================================================= -->
					<li>
						<a href="?route=Home">
							<i class="fa fa-reply"></i> <span>Salir del Ciclo</span>
							<span class="pull-right-container">
								<!-- <small class="label pull-right bg-green">new</small> -->
							</span>
						</a>
					</li>
					<!-- <li class="header">PAGOS</li> -->
					<!-- <li class="header">SEGURIDAD</li> -->
				<!-- ======================================================================================================================= -->
			<?php } ?>

		</ul>

	</section>
</aside>