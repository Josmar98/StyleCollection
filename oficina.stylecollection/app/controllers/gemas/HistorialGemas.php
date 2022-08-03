<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();


if(empty($_POST)){
	$id_perso = $_SESSION['id_cliente'];
	// $historialx = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and id_cliente = $id_perso");
	$historial1 = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_perso} and canjeos.estatus = 1");

	$historial2 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, pedidos, despachos, campanas WHERE pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana and  pedidos.id_pedido = gemas.id_pedido and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso} and gemas.estado = 'Disponible'");

	$historial3 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, campanas WHERE campanas.id_campana = gemas.id_campana and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema != 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso} and gemas.estado = 'Disponible'");

	$historial4 = $lider->consultarQuery("SELECT * FROM nombramientos, liderazgos, campanas WHERE campanas.id_campana = nombramientos.id_campana and nombramientos.id_liderazgo = liderazgos.id_liderazgo and nombramientos.estatus = 1 and nombramientos.id_cliente = {$id_perso}");
	$historialx = [];
	$num = 0;
	foreach ($historial1 as $data) {
		if(!empty($data['id_canjeo'])){
			$historialx[$num] = $data;
			$num++;
		}
	}
	foreach ($historial2 as $data) {
		if(!empty($data['id_gema'])){
			$historialx[$num] = $data;
			$num++;
		}
	}
	foreach ($historial3 as $data) {
		if(!empty($data['id_gema'])){
			$historialx[$num] = $data;
			$num++;
		}
	}

	foreach ($historial4 as $data) {
		if(!empty($data['id_nombramiento'])){
			$historialx[$num] = $data;
			$num++;
		}
	}
	// fecha_canjeo;
	// fecha_aprobado;
	// fecha_gemas;
	// fecha_canjeo;
	// $aux = [];
	// $aux2 = [];
	$nume = 0;
	$historialAux = [];
	foreach ($historialx as $data) {
		if(!empty($data['fecha_canjeo'])){
			$fechaMostrar = $data['fecha_canjeo'];
			$horaMostrar = $data['hora_canjeo'];
			$historialAux[$nume]['fecha'] = $fechaMostrar;
			$historialAux[$nume]['num'] = $nume;
			$historialAux[$nume]['hora'] = $horaMostrar;
		}else if(!empty($data['fecha_aprobado'])){
			$fechaMostrar = $lider->formatFechaInver($data['fecha_aprobado']);
			$horaMostrar = $data['hora_aprobado'];
			$historialAux[$nume]['fecha'] = $fechaMostrar;
			$historialAux[$nume]['num'] = $nume;
			$historialAux[$nume]['hora'] = $horaMostrar;
		}else if(!empty($data['fecha_gemas'])){
			$fechaMostrar = $data['fecha_gemas'];
			$horaMostrar = $data['hora_gemas'];
			$historialAux[$nume]['fecha'] = $fechaMostrar;
			$historialAux[$nume]['num'] = $nume;
			$historialAux[$nume]['hora'] = $horaMostrar;
		}else if(!empty($data['fecha_nombramiento'])){
			$fechaMostrar = $data['fecha_nombramiento'];
			$horaMostrar = $data['hora_nombramiento'];
			$historialAux[$nume]['fecha'] = $fechaMostrar;
			$historialAux[$nume]['num'] = $nume;
			$historialAux[$nume]['hora'] = $horaMostrar;
		}
		$nume++;
	}
	$a = ordenar($historialAux);
	$historial = [];
	$n=0;
	foreach ($a as $aux) {
		$historial[$n] = $historialx[$aux['num']];
		// print_r($historial[$n]);
		// echo "<br><br>";
		$n++;
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


function ordenar($a) {
    for ($i = 0; $i < count($a); $i++) {
        for ($j = 0; $j < count($a); $j++) {
            if ($a[$i]['fecha'] < $a[$j]['fecha']) {
                $temp = $a[$i];
                $a[$i] = $a[$j];
                $a[$j] = $temp;
            }
        }
    }
 
    return $a;
}
?>