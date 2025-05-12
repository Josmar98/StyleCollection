 <?php 

$fecha_operacion = date('Y-m-d H:i:s');
$productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
$mercancias = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
$operacionesUnicasPr = $lider->consultarQuery("SELECT DISTINCT tipo_inventario, id_inventario FROM operaciones WHERE tipo_inventario='Productos' ORDER BY id_inventario ASC;");
$operacionesUnicasMe = $lider->consultarQuery("SELECT DISTINCT tipo_inventario, id_inventario FROM operaciones WHERE tipo_inventario='Mercancia' ORDER BY id_inventario ASC;");

$arrayProductos = [
    [
        'id'=>141,
        'codigo'=>'GM0016',
        'costo'=>9,
    ]
];

echo "=========================================================================================<br>";
echo "<br>PRODUCTOS<br>";
echo "=========================================================================================<br>";
echo "<table style='width:80%;margin-left:5%;' border='1'>";
echo "<tr>";
    echo "<td>Tipo de Inventario</td>";
    echo "<td>ID</td>";
    echo "<td>Codigo</td>";
    echo "<td>Nombre</td>";
    echo "<td>Costo</td>";
echo "</tr>";
foreach ($operacionesUnicasPr as $ops) {
    if(!empty($ops['id_inventario'])){
        foreach ($productos as $pr) {
            if(!empty($pr['id_producto'])){
                if($pr['id_producto']==$ops['id_inventario']){
                    $operacionCosto = $lider->consultarQuery("SELECT * FROM operaciones WHERE tipo_inventario='{$ops['tipo_inventario']}' and id_inventario={$ops['id_inventario']} and total_operacion > 0 ORDER BY id_operacion ASC LIMIT 1");
                    echo "<tr>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $ops['tipo_inventario'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $ops['id_inventario'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $pr['codigo_producto'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $pr['producto'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            $costo = 0;
                            foreach ($arrayProductos as $arr) {
                                if($arr['id']==$ops['id_inventario']){
                                    // print_r($arr);
                                    $costo = $arr['costo'];
                                }
                            }
                            foreach ($operacionCosto as $costos) {
                                if(!empty($costos['id_operacion'])){
                                    if($costo==0){
                                        $stock = $costos['stock_operacion'];
                                        $total = (float) number_format($costos['total_operacion'],2,'.','');
                                        $costo = (float) number_format(($total/$stock),2,'.','');
                                    }
                                }
                            }
                            echo number_format($costo,2,',','.');
                            // echo "(".$costo.")";
                            $queryCosto = "INSERT INTO cartelera_costos (id_cartelera_costo, tipo_inventario, id_inventario, fecha_operacion, costo_historico, costo_promedio, estatus) VALUES (DEFAULT, '{$ops['tipo_inventario']}', {$ops['id_inventario']}, '{$fecha_operacion}', {$costo}, {$costo}, 1)";
                            
                            $queryOperaciones = "UPDATE operaciones SET total_operacion=(stock_operacion * {$costo}) and total_operacion_almacen=(stock_operacion_almacen * {$costo})  and total_operacion_total=(stock_operacion_total * {$costo}) WHERE tipo_inventario='{$ops['tipo_inventario']}' and id_inventario={$ops['id_inventario']}";


                        echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }
}
echo "</table>";


echo "<br><br>";
echo "<br><br>";


$arrayMercancia = [
    [
        'id'=>1111,
        'codigo'=>'GM0016',
        'costo'=>9,
    ]
];

echo "=========================================================================================<br>";
echo "<br>MERCANCIAS<br>";
echo "=========================================================================================<br>";
echo "<table style='width:80%;margin-left:5%;' border='1'>";
echo "<tr>";
    echo "<td>Tipo de Inventario</td>";
    echo "<td>ID</td>";
    echo "<td>Codigo</td>";
    echo "<td>Nombre</td>";
    echo "<td>Costo</td>";
echo "</tr>";
foreach ($operacionesUnicasMe as $ops) {
    if(!empty($ops['id_inventario'])){
        foreach ($mercancias as $mr) {
            if(!empty($mr['id_mercancia'])){
                if($mr['id_mercancia']==$ops['id_inventario']){
                    $operacionCosto = $lider->consultarQuery("SELECT * FROM operaciones WHERE tipo_inventario='{$ops['tipo_inventario']}' and id_inventario={$ops['id_inventario']} and total_operacion > 0 ORDER BY id_operacion ASC LIMIT 1");
                    echo "<tr>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $ops['tipo_inventario'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $ops['id_inventario'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $mr['codigo_mercancia'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            echo $mr['mercancia'];
                        echo "</td>";
                        echo "<td style='padding:2px 5px;'>";
                            $costo = 0;
                            foreach ($arrayMercancia as $arr) {
                                if($arr['id']==$ops['id_inventario']){
                                    // print_r($arr);
                                    $costo = $arr['costo'];
                                }
                            }
                            foreach ($operacionCosto as $costos) {
                                if(!empty($costos['id_operacion'])){
                                    if($costo==0){
                                        $stock = $costos['stock_operacion'];
                                        $total = (float) number_format($costos['total_operacion'],2,'.','');
                                        $costo = (float) number_format(($total/$stock),2,'.','');
                                    }
                                }
                            }
                            echo number_format($costo,2,',','.');
                            $queryCosto = "INSERT INTO cartelera_costos (id_cartelera_costo, tipo_inventario, id_inventario, fecha_operacion, costo_historico, costo_promedio, estatus) VALUES (DEFAULT, '{$ops['tipo_inventario']}', {$ops['id_inventario']}, '{$fecha_operacion}', {$costo}, {$costo}, 1)";
                            
                            $queryOperaciones = "UPDATE operaciones SET total_operacion=(stock_operacion * {$costo}) and total_operacion_almacen=(stock_operacion_almacen * {$costo})  and total_operacion_total=(stock_operacion_total * {$costo}) WHERE tipo_inventario='{$ops['tipo_inventario']}' and id_inventario={$ops['id_inventario']}";


                            // echo "(".$costo.")";
                        echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }
}
echo "</table>";

echo "<br><br><br>";

?>