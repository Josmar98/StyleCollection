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
			if(empty($_POST)){
				if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
					$d = $_GET['rangoI'];
					$h = $_GET['rangoF'];
					$bitacora = $lider->consultarQuery("SELECT * FROM bitacora, usuarios, clientes WHERE bitacora.id_usuario = usuarios.id_usuario and usuarios.id_cliente = clientes.id_cliente and bitacora.fecha BETWEEN '{$d}' and '{$h}'");
				}else{
					$bitacora = $lider->consultarQuery("SELECT * FROM bitacora, usuarios, clientes WHERE bitacora.id_usuario = usuarios.id_usuario and usuarios.id_cliente = clientes.id_cliente");
				}
				
				if($bitacora['ejecucion']==1){
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