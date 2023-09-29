<?php 

	$cliente=$lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = '$id'");
	$userCliente=$lider->consultarQuery("SELECT * FROM usuarios WHERE usuarios.id_cliente = '$id'");

	if(!empty($_POST['selectedPedido'])){
		$id_despacho = $_POST['selectedPedido'];
		// $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
		// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_despacho = $id_despacho");
		$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");

	}
		print_r($cliente);

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
		    
		    $fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.png";

		    $rrollCliente = $userCliente['nombre_rol'];
	        if($userCliente['nombre_rol']=="Vendedor"){if($cliente['sexo']=="Femenino" || $cliente['sexo']=="Masculino"){$rrollCliente="Lider";} }
	        if($userCliente['nombre_rol']=="Administrador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Administradora";} }
	        if($userCliente['nombre_rol']=="Conciliador"){if($cliente['sexo']=="Femenino"){$rrollCliente="Conciliadora";} }
		}else{
			$fotoPerfilCliente = "public/assets/img/profile/";
		    if($cliente['sexo']=="Femenino"){$fotoPerfilCliente .= "Femenino.png";}
		    if($cliente['sexo']=="Masculino"){$fotoPerfilCliente .= "Masculino.png";}
		    $fotoPortadaCliente = "public/assets/img/profile/portadaGeneral.jpg";
		    
		    $fotoPortadaCliente = "public/assets/img/profile/PortadaGeneral.png";

		    $rrollCliente = "Agente";
		}
		$fotoPortada = "public/assets/img/profile/PortadaGeneral.png";


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



?>