<?php 

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer;
    use PhpOffice\PhpSpreadsheet\Reader;
$amMovimientos = 0;
$amMovimientosR = 0;
$amMovimientosC = 0;
$amMovimientosE = 0;
$amMovimientosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Movimientos Bancarios"){
      $amMovimientos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amMovimientosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amMovimientosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amMovimientosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amMovimientosB = 1;
      }
    }
  }
}
if($amMovimientosR == 1){

    if(is_file('app/models/excel.php')){
      require_once'app/models/excel.php';
    }
    if(is_file('../app/models/excel.php')){
      require_once'../app/models/excel.php';
    }

      

      if(!empty($_POST['optcol1']) && empty($_FILES)){
        // print_r($_POST);
        $banco = $_POST['banco'];
        $id_banco = $_POST['id_banco'];
        $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id_banco}");
        $banco = $bancos[0];

        $option1 = $_POST['optcol1'];
        $option2 = $_POST['optcol2'];
        $option3 = $_POST['optcol3'];

        $col1 = $_POST['col1'];
        $col2 = $_POST['col2'];
        $col3 = $_POST['col3'];

        if($option1=="1"){
          $fechas = $col1;
        }else if ($option1=="2"){
          $referencias = $col1;
        }else if ($option1=="3"){
          $montos = $col1;
        }

        if($option2=="1"){
          $fechas = $col2;
        }else if ($option2=="2"){
          $referencias = $col2;
        }else if ($option2=="3"){
          $montos = $col2;
        }

        if($option3=="1"){
          $fechas = $col3;
        }else if ($option3=="2"){
          $referencias = $col3;
        }else if ($option3=="3"){
          $montos = $col3;
        }

        // echo "<table><tr>";
        //   echo "<td> id_movimiento </td> <td> id_Banco </td> <td> Referencias </td> <td> Fechas </td> <td> Montos </td> <td> estatus </td>";
        // echo "</tr>";
        // for ($i=0; $i < Count($fechas); $i++) { 
        // echo "<tr>";
        //   echo "<td>".($i+1)."</td>";
        //   echo "<td>".$id_banco."</td>";
        //   echo "<td>".$referencias[$i]."</td>";
        //   echo "<td>".$fechas[$i]."</td>";
        //   echo "<td>".$montos[$i]."</td>";
        //   echo "<td>1</td>";
        // echo "</tr>";
        // }
        // echo "</table>";


        for ($i=0; $i < Count($fechas); $i++) {
          $fechaAct = $lider->formatFechaInver($fechas[$i]);
          $pos = null;
          $pos = strpos($montos[$i], ',');
          $montss = $montos[$i];
          if($pos != null){
            $parte1 = substr($montss, 0, $pos);
            $parte2 = substr($montss, $pos+1);
            $sepa = str_replace($montss[$pos], ',', '.');
            $montss = $parte1.$sepa.$parte2;
          }
          $montoActual = (Float) $montss;
          $referencias[$i] = trim($referencias[$i]);
          
          // echo " Actual: ".$montoActual." ====  Original: ".$montos[$i]."<br> ";


          // if($banco['nombre_banco']=="Provincial"){
            // $resp['ejecucion']=true;
          // }else{
            // // $query = "SELECT * FROM movimientos WHERE id_banco = $id_banco and num_movimiento = '{$referencias[$i]}' and  fecha_movimiento = '{$fechaAct}' and monto_movimiento = '{$montos[$i]}' and estatus = 1";
            
            $query = "SELECT * FROM movimientos WHERE id_banco = $id_banco and num_movimiento = '{$referencias[$i]}' and  fecha_movimiento = '{$fechaAct}' and monto_movimiento = '{$montoActual}' and estatus = 1";
            $resp = $lider->consultarQuery($query);
          // }

          $movID = "B".$id_banco."_".date('Y_m_d')."_M";
          $numss = $lider->consultarQuery("SELECT * FROM movimientos WHERE id_movimiento LIKE '%{$movID}%'");
          // print_r($numss);
          $numMax = 0;
          if(count($numss)>1){
            $len = strlen($movID);
            foreach ($numss as $key) {
              if(!empty($key['id_movimiento'])){
                $n = substr($key['id_movimiento'], $len);
                if($n > $numMax){
                  $numMax = $n;
                }
              }
            }
          }
          $numero_mov = $numMax+1;
          $movID .= $numero_mov;

          // print_r($resp);
          if($resp['ejecucion']==true){
            if(Count($resp)>1){
                  $response = "1";
            }else{
                // $query = "INSERT INTO movimientos (id_movimiento, id_banco, num_movimiento, fecha_movimiento, monto_movimiento, estado_movimiento, estatus) VALUES ('{$movID}', $id_banco, '$referencias[$i]', '$fechaAct', '{$montos[$i]}', '', 1)";
                
                $query = "INSERT INTO movimientos (id_movimiento, id_banco, num_movimiento, fecha_movimiento, monto_movimiento, estado_movimiento, estatus) VALUES ('{$movID}', $id_banco, '$referencias[$i]', '$fechaAct', '$montoActual', '', 1)";
                $exec = $lider->registrar($query, "movimientos", "id_movimiento");
                if($exec['ejecucion']==true ){
                  $response = "1";
                }else{
                  $response = "2";
                }
            }
          }else{
            $response = "2";
          }
        }
        if($response=="1"){
                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Movimientos Bancarios', 'Registrar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
        }

        $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado' ORDER BY nombre_banco ASC");
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


      if(!empty($_FILES['archivo']) && !empty($_POST['bancos'])){

        // print_r($_FILES);
        
        $file = "./config/temp/movimientos.xlsx";

        $id_banco = $_POST['bancos'];
        $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = $id_banco and estatus = 1");
        $nombre_banco = $bancos[0]['nombre_banco'];
        // print_r($bancos);

        $fichero = $_FILES['archivo'];
        $nombreArchivo = $fichero['name'];
        $rutaOrigen = $fichero['tmp_name'];
        $size = $fichero['size'];
        $type = $fichero['type'];

        $ruta = "./config/temp/";
        $nombre = "movimientos.xlsx";
        $destino = $ruta.$nombre;
        copy($rutaOrigen, $destino);

        $docx = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        $doc = "application/msword";
        $pdf = "application/pdf";
        $xml = "text/xml";
        $odt = "application/vnd.oasis.opendocument.text";
        $docm = "application/vnd.ms-word.document.macroEnabled.12";
        $dot = "application/msword";
        // de Aqui para abajo son en planillas excel
        $xlsx = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
        $xlsb = "application/vnd.ms-excel.sheet.binary.macroEnabled.12";
        $xls = "application/vnd.ms-excel";
        $xps = "application/vnd.ms-xpsdocument";
        $ods = "application/vnd.oasis.opendocument.spreadsheet";
        if($type==$xlsx || $type==$xlsb || $type==$xls || $type==$xps || $type==$ods){
          switch ($type) {
              case $xlsx:
                $tipo = "xlsx";
                break;
              case $xlsb:
                $tipo = "xlsb";
                break;
              case $xls:
                $tipo = "xls";
                break;
              case $xps:
                $tipo = "xps";
                break;
              case $ods:
                $tipo = "ods";
                break;
            }
          $namePage = null;
          $filas = ['filI'=> '1', 'filF' => ''];
          $colum = ['colI'=> 'A', 'colF' => 'C'];
          $typeResponse = 1;

          $libro = new Excel($file, "Xlsx");
          $dataExcel = $libro->LeerExcel($namePage, $filas, $colum, $typeResponse);

          // print_r($dataExcel);
          if($dataExcel['EstatusExecute']){
            $responseForm1 = "1";
             

          }
        }else{
          $responseForm1 = "7";
        }
        
        
        $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado' ORDER BY nombre_banco asc;");
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
        $bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1 and disponibilidad = 'Habilitado' ORDER BY nombre_banco asc;");
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

        
      

}else{
    require_once 'public/views/error404.php';
}


?>