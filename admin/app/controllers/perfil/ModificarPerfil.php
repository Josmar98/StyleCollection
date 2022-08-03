<?php 
$configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones");
              $editarPerfilDisponible = 1;
              $editarNombreUsuarioDisponible = 0;
              $editarClaveUsuarioDisponible = 0;
              $verFotosDisponible = 0;
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
                  }
                }
              }

if($editarPerfilDisponible==1||$editarNombreUsuarioDisponible==1||$editarClaveUsuarioDisponible==1){



    if(!empty($_POST['nombre1']) && !empty($_POST['cedula'])){

      // print_r($_POST);

      $nombre1 = ucwords(mb_strtolower($_POST['nombre1']));
      $nombre2 = ucwords(mb_strtolower($_POST['nombre2']));
      $apellido1 = ucwords(mb_strtolower($_POST['apellido1']));
      $apellido2 = ucwords(mb_strtolower($_POST['apellido2']));
      $cedula = $_POST['cedula'];
      $fechaNacimiento = $_POST['fechaNacimiento'];
      $cod_rif = $_POST['cod_rif'];
      $rif = $_POST['rif'];
      $cod_tlfn = $_POST['cod_tlfn'];
      $numtelefono = $_POST['telefono'];
      $telefono = $cod_tlfn.$numtelefono;

      $cod_tlfn2 = $_POST['cod_tlfn2'];
      $numtelefono2 = $_POST['telefono2'];
      $telefono2 = $cod_tlfn2.$numtelefono2;


      $correo = $_POST['correo'];
      $direccion = ucwords(mb_strtolower($_POST['direccion']));
      
      $correolen1 = strlen($correo) - 4;
      $correolen2 = strlen($correo);
      $correoterminator = substr($correo, $correolen1, $correolen2);


      $id_cliente = $_SESSION['cuenta']['id_cliente'];
      $campAnt = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
      $query = "UPDATE clientes SET primer_nombre = '$nombre1', segundo_nombre = '$nombre2', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', cedula = '$cedula', fecha_nacimiento = '$fechaNacimiento', telefono = '$telefono', telefono2 = '$telefono2', correo = '$correo', cod_rif = '$cod_rif', rif = '$rif', direccion = '$direccion', estatus = 1 WHERE id_cliente = $id_cliente";



      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";

          if(!empty($modulo) && !empty($accion)){
            $campAnt = $campAnt[0];
            $elementos = array(
              "Nombres"=> [0=>"Id", 1=>ucwords("Primer Nombre"), 2=> ucwords("Segundo Nombre"), 3=> ucwords("Primer Apellido"), 4=>ucwords("Segundo Apellido"), 5=>ucwords("Codigo de Cedula"), 6=>ucwords("Cedula"), 7=> ucwords("Sexo"), 8=>ucwords("Fecha de Nacimiento"), 9=>ucwords("Primer Telefono"), 10=>ucwords("Segundo Telefono"), 11=>ucwords("Correo electronico"), 12=>ucwords("Codigo de Rif"), 13=>ucwords("Rif"), 14=>ucwords("Direccion"), 15=>ucwords("Id del Lider"), 16=>ucwords("Estatus")],
              "Anterior"=> [ 0=> $id_cliente, 1=> $campAnt['primer_nombre'], 2=> $campAnt['segundo_nombre'] , 3=>$campAnt['primer_apellido'], 4=>$campAnt['segundo_apellido'], 5=>$campAnt['cod_cedula'], 6=>$campAnt['cedula'], 7=>$campAnt['sexo'], 8=>$lider->formatFecha($campAnt['fecha_nacimiento']), 9=>$campAnt['telefono'], 10=>$campAnt['telefono2'], 11=>$campAnt['correo'], 12=>$campAnt['cod_rif'], 13=>$campAnt['rif'], 14=>$campAnt['direccion'], 15=>$campAnt['id_lider'], 16=>$campAnt['estatus']],
              "Actual"=> [ 0=> $id_cliente, 1=> $nombre1, 2=> $nombre2 , 3=>$apellido1, 4=>$apellido2, 5=>$campAnt['cod_cedula'], 6=>$cedula, 7=>$campAnt['sexo'], 8=>$lider->formatFecha($fechaNacimiento), 9=>$telefono, 10=>$telefono2, 11=>$correo, 12=>$cod_rif, 13=>$rif, 14=>$direccion, 15=>$campAnt['id_lider'], 16=>"1"]
            );
            $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);

            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Perfil', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
      }else{
        $response = "2";
      }
          


      	$query = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
       	$res2 = $lider->consultarQuery($query);
      	$_SESSION['cuenta'] = $res2[0];
      	$cod_tlfn = substr($cuenta['telefono'], 0, 4);
      	$numtelefono = substr($cuenta['telefono'], 4, strlen($cuenta['telefono']) );

      	if(!empty($cuenta['telefono2'])){

      		$cod_tlfn2 = substr($cuenta['telefono2'], 0, 4);
      		$numtelefono2 = substr($cuenta['telefono2'], 4, strlen($cuenta['telefono2']) );
      	}


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
      // print_r($exec);
    }

    if(!empty($_POST['username'])){
      $user = $_POST['username'];

      $exec = $lider->modificar("UPDATE usuarios SET nombre_usuario = '{$user}' WHERE id_usuario = {$_SESSION['id_usuario']}");
      if($exec['ejecucion']==true){
        $response = "1";
        $_SESSION['username']=$user;
      }else{
        $response = "2";
      }

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
    }

    if(!empty($_POST['pass']) && !empty($_POST['newPass']) && !empty($_POST['newPass2'])){
      $pass = $_POST['pass'];
      $newPass = $_POST['newPass'];
      $newPass2 = $_POST['newPass2'];

      $exec = $lider->modificar("UPDATE usuarios SET password = '{$newPass}' WHERE id_usuario = {$_SESSION['id_usuario']}");
      if($exec['ejecucion']==true){
        $response = "1";
        $_SESSION['pass']=$newPass;
      }else{
        $response = "2";
      }

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

    }

    if(empty($_POST)){

    	if(!empty($action)){
    		    $cod_tlfn = substr($cuenta['telefono'], 0, 4);
          	$numtelefono = substr($cuenta['telefono'], 4, strlen($cuenta['telefono']) );

          	$cod_tlfn2 = substr($cuenta['telefono2'], 0, 4);
          	$numtelefono2 = substr($cuenta['telefono2'], 4, strlen($cuenta['telefono2']) );
          	
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
    }

}else{
  require_once 'public/views/error404.php';
}
?>