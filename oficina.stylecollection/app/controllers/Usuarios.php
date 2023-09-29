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
if($amUsuariosC == 1){
	$usuarios=$lider->consultarQuery("SELECT * FROM usuarios WHERE estatus = 1 ORDER BY nombre_usuario asc;");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amUsuariosB == 1){

			$query = "UPDATE usuarios SET estatus = 0 WHERE id_usuario = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Usuarios', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		}else{
		    require_once 'public/views/error404.php';
		}
	}
	if(empty($_POST)){
		$usuarios = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1");
		if($usuarios['ejecucion']==1){
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
	}
}else{
    require_once 'public/views/error404.php';
}

?>