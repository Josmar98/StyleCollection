<?php 
    $cantidadCamps=4;
    $str="";
    $despachosId = [];
    $campanas = $lider->consultarQuery("SELECT id_campana, numero_campana, anio_campana FROM campanas WHERE estatus=1 ORDER BY id_campana DESC LIMIT {$cantidadCamps}");
    echo "<br>";
    foreach ($campanas as $camp) {
        if(!empty($camp['id_campana'])){
            $despachos = $lider->consultarQuery("SELECT id_campana, id_despacho, numero_despacho FROM despachos WHERE estatus=1 and id_campana={$camp['id_campana']} ORDER BY id_despacho ASC");
            foreach ($despachos as $desp) {
                if(!empty($desp['id_campana'])){
                    $despachosId[count($despachosId)]=$desp['id_despacho'];
                    echo "CAMPAÑA ".$camp['numero_campana']."/".$camp['anio_campana']." -> "."PEDIDO: ".$desp['numero_despacho'];
                    // print_r($desp);
                    echo "<br>";
                }
            }
        }    
    }
    $numMax = count($despachosId); 
    $index=1;
    foreach ($despachosId as $ids) {
        $str.=$ids;
        if($index<$numMax){
            $str.=", ";
        }
        $index++;
    }
    // echo "STR: ".$str."<br><br>";

    $pedidosCliente=$lider->consultarQuery("SELECT * FROM clientes, pedidos, despachos, campanas WHERE clientes.id_cliente=pedidos.id_cliente and pedidos.id_despacho IN ({$str}) and despachos.id_despacho=pedidos.id_despacho and campanas.id_campana=despachos.id_campana");
    echo "<br>";
    echo "RESULTADOS: ".count($pedidosCliente);
    echo "<br><br>";

	$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1 ORDER BY id_cliente ASC;");
    // print_r($clientes);
    echo "<br><b style='font-size:1.4em;'>LIDERES SIN PEDIDOS EN LAS ULTIMAS ".$cantidadCamps." CAMPAÑAS</b><br>";
    echo "<table style='width:80%;margin-left:10%;' border='1'>";
    $cantidadLideresSinPedidos=0;
    foreach ($clientes as $cl) {
        if(!empty($cl['id_cliente'])){
            $mostrarNo=false;
            foreach ($pedidosCliente as $ped) {
                if(!empty($ped['id_cliente'])){
                    if($ped['id_cliente']==$cl['id_cliente']){
                        $mostrarNo=true;
                    }
                }
            }
            if($mostrarNo==false){
                $cantidadLideresSinPedidos++;
                echo "<tr>";
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cantidadLideresSinPedidos;
                    echo "</td>";
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cl['id_cliente'];
                    echo "</td>";
    
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cl['cod_rif']."-".$cl['rif'];
                    echo "</td>";
    
                    
                    echo "<td style='padding:2px 5px;text-align:left;'>";
                        echo $cl['primer_nombre']." ".$cl['segundo_nombre']." ".$cl['primer_apellido'];
                    echo "</td>";
    
                    echo "<td style='padding:2px 5px;text-align:left;'>";
                        foreach ($pedidosCliente as $ped) {
                            if(!empty($ped['id_cliente'])){
                                if($ped['id_cliente']==$cl['id_cliente']){
                                    // echo $ped['id_pedido']." <br> ";
                                    echo "CAMPAÑA ".$ped['numero_campana']."/".$ped['anio_campana']." -> "."PEDIDO: ".$ped['numero_despacho'];
                                    echo "<br>";
                                }
                            }
                        }
                    echo "</td>";
                echo "</tr>";
            }
        }
    }
    echo "</table>";


    echo "<br><br><br>";
    
    echo "<br><b style='font-size:1.4em;'>LIDERES QUE SI TIENEN PEDIDOS EN LAS ULTIMAS ".$cantidadCamps." CAMPAÑAS</b><br>";
    echo "<table style='width:80%;margin-left:10%;' border='1'>";
    $cantidadLideresConPedidos=0;
    foreach ($clientes as $cl) {
        if(!empty($cl['id_cliente'])){
            $mostrarNo=false;
            foreach ($pedidosCliente as $ped) {
                if(!empty($ped['id_cliente'])){
                    if($ped['id_cliente']==$cl['id_cliente']){
                        $mostrarNo=true;
                    }
                }
            }
            if($mostrarNo==true){
                $cantidadLideresConPedidos++;
                echo "<tr>";
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cantidadLideresConPedidos;
                    echo "</td>";
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cl['id_cliente'];
                    echo "</td>";
    
                    echo "<td style='padding:2px 5px;text-align:center;'>";
                        echo $cl['cod_rif']."-".$cl['rif'];
                    echo "</td>";
    
                    
                    echo "<td style='padding:2px 5px;text-align:left;'>";
                        echo $cl['primer_nombre']." ".$cl['segundo_nombre']." ".$cl['primer_apellido'];
                    echo "</td>";
    
                    echo "<td style='padding:2px 5px;text-align:left;'>";
                        foreach ($pedidosCliente as $ped) {
                            if(!empty($ped['id_cliente'])){
                                if($ped['id_cliente']==$cl['id_cliente']){
                                    // echo $ped['id_pedido']." <br> ";
                                    echo "CAMPAÑA ".$ped['numero_campana']."/".$ped['anio_campana']." -> "."PEDIDO: ".$ped['numero_despacho']." ||| COLECCIONES: ".$ped['cantidad_aprobado'];
                                    echo "<br>";
                                }
                            }
                        }
                    echo "</td>";
                echo "</tr>";
            }
        }
    }
    echo "</table>";

?>