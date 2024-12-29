<?php 


if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

  
  
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE desperfectos SET estatus = 0 WHERE id_desperfecto = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";

	        if(!empty($modulo) && !empty($accion)){
	          $fecha = date('Y-m-d');
	          $hora = date('H:i:a');
	          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Desperfectos', 'Borrar', '{$fecha}', '{$hora}')";
	          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	        }
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}

	}




	if(empty($_POST)){
		$desperfectosUnid = $lider->consultarQuery("SELECT DISTINCT desperfectos.id_desperfecto, id_campana, fecha_inicio_desperfecto, fecha_fin_desperfecto, pedidos.id_pedido, id_despacho, cantidad_pedido, fecha_pedido, hora_pedido, cantidad_aprobado, fecha_aprobado, hora_aprobado, cantidad_total, id_lc, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cod_cedula, cedula, sexo, fecha_nacimiento, telefono, correo, cod_rif, rif, direccion, id_lider FROM desperfectos, notificar_desperfectos, pedidos, clientes WHERE pedidos.id_pedido = notificar_desperfectos.id_pedido and clientes.id_cliente = pedidos.id_cliente and desperfectos.id_desperfecto = notificar_desperfectos.id_desperfecto and desperfectos.id_campana = {$id_campana}");
		if($desperfectosUnid['ejecucion']==1){
			$desperfectos = $lider->consultarQuery("SELECT DISTINCT * FROM desperfectos, notificar_desperfectos, productos WHERE desperfectos.id_desperfecto = notificar_desperfectos.id_desperfecto and productos.id_producto = notificar_desperfectos.id_producto and desperfectos.id_campana = {$id_campana}");
			$desperf = $lider->consultarQuery("SELECT * FROM desperfectos, campanas WHERE desperfectos.id_campana = campanas.id_campana and desperfectos.estatus = 1 and desperfectos.id_campana = {$id_campana}");
			if(Count($desperf)>1){
				$desperf = $desperf[0];
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

		}else{
		    require_once 'public/views/error404.php';
		}
	}

}else{
  require_once 'public/views/error404.php';
}

?>