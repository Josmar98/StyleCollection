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

    if(!empty($_GET['P'])){
      $id_despacho = $_GET['P'];
      $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
      

      $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
    }

$currentDate = date('Y');
$lastDate = date('Y')-1;
$registroHistoricoGemas = $lider->consultarQuery("SELECT * FROM registro_gemas WHERE estatus=1 ORDER BY id_registro_gemas DESC");
$lastRegisterGemas = [];
if(!empty($registroHistoricoGemas[0])){
    $lastRegisterGemas=$registroHistoricoGemas[0];
}
$saldo_inicial = $lastRegisterGemas['sumatoria_saldo'];
if(!empty($_GET['mes'])){
    $currentMes = $_GET['mes'];
    $mesInicial = $currentMes;
    $mesFinal = $currentMes;
    $mesNum = (int) $currentMes;
    if($mesNum > 1){
        $mesNum--;
        $lastMes = (strlen($mesNum)==1) ? "0".$mesNum : $mesNum;
        // $firstCampAnt = 0;
        // $lastCampAnt = 0;
        // $campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE campanas.anio_campana='{$currentDate}' ORDER BY id_campana ASC");
        // if(!empty($campanas[0])){
        //     $firstCampAnt = $campanas[0]['id_campana'];
        // }
        // $campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE campanas.anio_campana='{$currentDate}' ORDER BY id_campana DESC");
        // if(!empty($campanas[0])){
        //     $lastCampAnt = $campanas[0]['id_campana'];
        // }
    
        // echo "Campana Inicial: ".$firstCampAnt."<br>";
        // echo "Campana Final: ".$lastCampAnt."<br>";
    
        $suma = [];
        $index = 0;
    
        $nombramientos = $lider->consultarQuery("SELECT SUM(nombramientos.cantidad_gemas) as cantidad FROM nombramientos WHERE nombramientos.estatus=1 and nombramientos.fecha_nombramiento BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($nombramientos['ejecucion']);
        foreach ($nombramientos as $key) {
            $suma[$index]['name']='Gemas por Nombramientos';
            if($key['cantidad']==""){
                $suma[$index]['cantidad']=0;
            }else{
                $suma[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        // $autorizadas = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE estatus=1 and fecha_obsequio BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
        // print_r($autorizadas);
        // echo "<br><br>";
        $autorizadas = $lider->consultarQuery("SELECT SUM(obsequiogemas.cantidad_gemas) as cantidad FROM obsequiogemas WHERE estatus=1 and fecha_obsequio BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        // print_r($autorizadas);
        // echo "<br><br>";
        unset($autorizadas['ejecucion']);
        foreach ($autorizadas as $key) {
            $suma[$index]['name']='Gemas Obsequiadas';
            if($key['cantidad']==""){
                $suma[$index]['cantidad']=0;
            }else{
                $suma[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        $nuevoLider = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas WHERE gemas.id_configgema=3 and gemas.estatus=1 and gemas.fecha_gemas BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($nuevoLider['ejecucion']);
        foreach ($nuevoLider as $key) {
            $suma[$index]['name']='Gemas por Líder Activo';
            if($key['cantidad']==""){
                $suma[$index]['cantidad']=0;
            }else{
                $suma[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        $liderActivo = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas WHERE gemas.id_configgema=2 and gemas.estatus=1 and gemas.fecha_gemas BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($liderActivo['ejecucion']);
        foreach ($liderActivo as $key) {
            $suma[$index]['name']='Gemas por Nuevo Líder';
            if($key['cantidad']==""){
                $suma[$index]['cantidad']=0;
            }else{
                $suma[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        $reclamadas = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas, pedidos WHERE gemas.id_pedido=pedidos.id_pedido and gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and pedidos.fecha_aprobado BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        // $reclamadas = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas WHERE gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and gemas.id_campana BETWEEN {$firstCampAnt} and {$lastCampAnt}");
        unset($reclamadas['ejecucion']);
        foreach ($liderActivo as $key) {
            $suma[$index]['name']='Gemas Reclamadas (Por colecciones)';
            if($key['cantidad']==""){
                $suma[$index]['cantidad']=0;
            }else{
                $suma[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        $generada = [];
        // $generadas = $lider->consultarQuery("SELECT SUM(gemas.cantidad_gemas) as cantidad FROM gemas WHERE gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and gemas.id_campana BETWEEN {$firstCampAnt} and {$lastCampAnt}");
        $generadas = $lider->consultarQuery("SELECT SUM(gemas.cantidad_gemas) as cantidad FROM gemas, pedidos WHERE gemas.id_pedido=pedidos.id_pedido and gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and pedidos.fecha_aprobado BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($generadas['ejecucion']);
        foreach ($generadas as $key) {
            $generada[0]['name']='Gemas Directas (Por colecciones)';
            if($key['cantidad']==""){
                $generada[0]['cantidad']=0;
            }else{
                $generada[0]['cantidad']=$key['cantidad'];
            }
        }
    
        $resta = [];
        $index = 0;
        $canjeadas = $lider->consultarQuery("SELECT SUM(catalogos.cantidad_gemas) as cantidad FROM canjeos, catalogos WHERE canjeos.id_catalogo=catalogos.id_catalogo and canjeos.estatus=1 and canjeos.fecha_canjeo BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($canjeadas['ejecucion']);
        foreach ($canjeadas as $key) {
            $resta[$index]['name']='Gemas Canjeadas';
            if($key['cantidad']==""){
                $resta[$index]['cantidad']=0;
            }else{
                $resta[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
        $descuentos = $lider->consultarQuery("SELECT SUM(descuentos_gemas.cantidad_descuento_gemas) as cantidad FROM descuentos_gemas WHERE descuentos_gemas.estatus=1 and descuentos_gemas.fecha_descuento_gema BETWEEN '{$currentDate}-01-01' and '{$currentDate}-{$lastMes}-31'");
        unset($descuentos['ejecucion']);
        foreach ($descuentos as $key) {
            $resta[$index]['name']='Gemas Liquidadas';
            if($key['cantidad']==""){
                $resta[$index]['cantidad']=0;
            }else{
                $resta[$index]['cantidad']=$key['cantidad'];
            }
            $index++;
        }
    
        $sumatoriaMesAnterior = 0;
        foreach ($suma as $key) {
            $sumatoriaMesAnterior+=$key['cantidad'];
        }
        $sumatoriaMesAnteriorR = 0;
        foreach ($resta as $key) {
            $sumatoriaMesAnteriorR+=$key['cantidad'];
        }
        // print_r($suma);
        // echo "saldo_inicial: ".$saldo_inicial."<br>";
        // echo "SumatoriaMesAnterior: ".$sumatoriaMesAnterior."<br>";
        // echo "SumatoriaMesAnteriorR: ".$sumatoriaMesAnteriorR."<br>";
        $saldo_inicial += $sumatoriaMesAnterior;
        $saldo_inicial -= $sumatoriaMesAnteriorR;
    }


}else{
    $mesInicial = "01";
    $mesFinal = "12";
}

// $firstCamp = 0;
// $lastCamp = 0;
// $campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE campanas.anio_campana='{$currentDate}' ORDER BY id_campana ASC");
// if(!empty($campanas[0])){
//     $firstCamp = $campanas[0]['id_campana'];
// }
// $campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE campanas.anio_campana='{$currentDate}' ORDER BY id_campana DESC");
// if(!empty($campanas[0])){
//     $lastCamp = $campanas[0]['id_campana'];
// }
$suma = [];
$index = 0;

$nombramientos = $lider->consultarQuery("SELECT SUM(nombramientos.cantidad_gemas) as cantidad FROM nombramientos WHERE nombramientos.estatus=1 and nombramientos.fecha_nombramiento BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($nombramientos['ejecucion']);
foreach ($nombramientos as $key) {
    $suma[$index]['name']='Gemas por Nombramientos';
    if($key['cantidad']==""){
        $suma[$index]['cantidad']=0;
    }else{
        $suma[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}

// $autorizadas = $lider->consultarQuery("SELECT * FROM obsequiogemas WHERE estatus=1 and fecha_obsequio BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
// print_r($autorizadas);
// echo "<br><br>";
$autorizadas = $lider->consultarQuery("SELECT SUM(obsequiogemas.cantidad_gemas) as cantidad FROM obsequiogemas WHERE estatus=1 and fecha_obsequio BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
// print_r($autorizadas);
// echo "<br><br>";
unset($autorizadas['ejecucion']);
foreach ($autorizadas as $key) {
    $suma[$index]['name']='Gemas Obsequiadas';
    if($key['cantidad']==""){
        $suma[$index]['cantidad']=0;
    }else{
        $suma[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}

$nuevoLider = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas WHERE gemas.id_configgema=3 and gemas.estatus=1 and gemas.fecha_gemas BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($nuevoLider['ejecucion']);
foreach ($nuevoLider as $key) {
    $suma[$index]['name']='Gemas por Líder Activo';
    if($key['cantidad']==""){
        $suma[$index]['cantidad']=0;
    }else{
        $suma[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}

$liderActivo = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas WHERE gemas.id_configgema=2 and gemas.estatus=1 and gemas.fecha_gemas BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($liderActivo['ejecucion']);
foreach ($liderActivo as $key) {
    $suma[$index]['name']='Gemas por Nuevo Líder';
    if($key['cantidad']==""){
        $suma[$index]['cantidad']=0;
    }else{
        $suma[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}

// $reclamadas = $lider->consultarQuery("SELECT sum(gemas.activas) as cantidad FROM gemas WHERE gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and gemas.id_campana BETWEEN {$firstCamp} and {$lastCamp}");
$reclamadas = $lider->consultarQuery("SELECT SUM(gemas.activas) as cantidad FROM gemas, pedidos WHERE gemas.id_pedido=pedidos.id_pedido and gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and pedidos.fecha_aprobado BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($reclamadas['ejecucion']);
foreach ($liderActivo as $key) {
    $suma[$index]['name']='Gemas Reclamadas (Por colecciones)';
    if($key['cantidad']==""){
        $suma[$index]['cantidad']=0;
    }else{
        $suma[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}

$generada = [];
// $generadas = $lider->consultarQuery("SELECT sum(gemas.cantidad_gemas) as cantidad FROM gemas WHERE gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and gemas.id_campana BETWEEN {$firstCamp} and {$lastCamp}");
$generadas = $lider->consultarQuery("SELECT SUM(gemas.cantidad_gemas) as cantidad FROM gemas, pedidos WHERE gemas.id_pedido=pedidos.id_pedido and gemas.estatus=1 and gemas.id_configgema=1 and gemas.estado='Disponible' and pedidos.fecha_aprobado BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($generadas['ejecucion']);
foreach ($generadas as $key) {
    $generada[0]['name']='Gemas Directas (Por colecciones)';
    if($key['cantidad']==""){
        $generada[0]['cantidad']=0;
    }else{
        $generada[0]['cantidad']=$key['cantidad'];
    }
}

$resta = [];
$index = 0;
$canjeadas = $lider->consultarQuery("SELECT SUM(catalogos.cantidad_gemas) as cantidad FROM canjeos, catalogos WHERE canjeos.id_catalogo=catalogos.id_catalogo and canjeos.estatus=1 and canjeos.fecha_canjeo BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($canjeadas['ejecucion']);
foreach ($canjeadas as $key) {
    $resta[$index]['name']='Gemas Canjeadas';
    if($key['cantidad']==""){
        $resta[$index]['cantidad']=0;
    }else{
        $resta[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}
$descuentos = $lider->consultarQuery("SELECT SUM(descuentos_gemas.cantidad_descuento_gemas) as cantidad FROM descuentos_gemas WHERE descuentos_gemas.estatus=1 and descuentos_gemas.fecha_descuento_gema BETWEEN '{$currentDate}-{$mesInicial}-01' and '{$currentDate}-{$mesFinal}-31'");
unset($descuentos['ejecucion']);
foreach ($descuentos as $key) {
    $resta[$index]['name']='Gemas Liquidadas';
    if($key['cantidad']==""){
        $resta[$index]['cantidad']=0;
    }else{
        $resta[$index]['cantidad']=$key['cantidad'];
    }
    $index++;
}


// print_r($lastRegisterGemas);
// echo "<br><br>";
// print_r($suma);
// echo "<br><br>";
// print_r($generada);
// echo "<br><br>";
// print_r($resta);

// print_r($lastRegisterGemas['sumatoria_saldo']);
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