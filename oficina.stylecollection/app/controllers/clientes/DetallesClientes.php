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
if($amClientesC == 1){

	$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
	$accesoBloqueo = "0";
	$superAnalistaBloqueo="1";
	$analistaBloqueo="1";
	foreach ($configuraciones as $config) {
		if(!empty($config['id_configuracion'])){
			if($config['clausula']=='Analistabloqueolideres'){
				$analistaBloqueo = $config['valor'];
			}
			if($config['clausula']=='Superanalistabloqueolideres'){
				$superAnalistaBloqueo = $config['valor'];
			}
		}
	}
	if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
	if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

	if($accesoBloqueo=="0"){
	// echo "Acceso Abierto";
	}
	if($accesoBloqueo=="1"){
	// echo "Acceso Restringido";
	$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
	}

	// echo " - ID: ".$id." - ";
	$permitir = "1";
	if($accesoBloqueo=="1"){
		$permitir = "0";
		if(!empty($accesosEstructuras)){
			foreach ($accesosEstructuras as $struct) {
				if(!empty($struct['id_cliente'])){
					// echo "<br> Struct: ".$struct['id_cliente']." | Id: ".$id." | ";
					if($struct['id_cliente']==$id){
						$permitir = "1";
					}
				}
			}
		}
	}
	// echo "<br>";
	// echo "Permitir: ";
	// echo $permitir;
	if($permitir=="1"){
		$id = intval($id);
		$cliente=$lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = '$id'");
		$userCliente=$lider->consultarQuery("SELECT * FROM usuarios,roles WHERE usuarios.id_rol = roles.id_rol and usuarios.id_cliente = '$id'");

		if(!empty($_POST['selectedPedido'])){
			$id_despacho = $_POST['selectedPedido'];
			// $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
			// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = $id_despacho");
			$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and pedidos.id_despacho = {$id_despacho}");
		}

		if(count($cliente)>1){
			$cliente = $cliente[0];
			$liderCliente = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_cliente = {$cliente['id_lider']}");
			if(count($liderCliente)>1){
				$liderCliente = $liderCliente[0];
			}else{
				$liderCliente['primer_nombre'] = "Ningun(a)";
				$liderCliente['primer_apellido'] = "Lider";
			}
			if(count($userCliente)>1){
				$userCliente = $userCliente[0];
				if($userCliente['fotoPerfil'] == ""){
			      $fotoPerfilCliente = "public/assets/img/profile/";
			      if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
			      if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";} 

			    }else{
			      $fotoPerfilCliente = $userCliente['fotoPerfil'];
			    }

			    if($userCliente['fotoPortada'] == ""){
			      $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
			    }else{
			      $fotoPortadaCliente = $userCliente['fotoPortada'];
			    }
			    
			    $fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.jpg";

			    $rrollCliente = $userCliente['nombre_rol'];
		        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
		        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
		        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
			}else{
				$fotoPerfilCliente = "public/assets/img/profile/";
			    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
			    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
			    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
			    
			    $fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.jpg";

			    $rrollCliente = "Agente";
			}
			$fotoPortada = "public/assets/img/profile/PortadaGeneral.jpg";


			if(!empty($action)){
				if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}else{
				if (is_file('public/views/'.$url.'.php')) {
					require_once 'public/views/'.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}
		}else{
			require_once 'public/views/error404.php';		
		}
	}else{
	    require_once 'public/views/error404.php';
	}
}else{
    require_once 'public/views/error404.php';
}


?>