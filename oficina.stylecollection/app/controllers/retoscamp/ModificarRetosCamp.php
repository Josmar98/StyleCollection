<?php 

$amPremioscamp = 0;
$amPremioscampR = 0;
$amPremioscampC = 0;
$amPremioscampE = 0;
$amPremioscampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Premios De Campaña"){
      $amPremioscamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPremioscampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPremioscampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPremioscampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPremioscampB = 1;
      }
    }
  }
}


if($amPremioscampE == 1){
  $limitesOpciones = 10;
  $limitesElementos = 10;
  $limiteMinimoOpciones=1;
  
  $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];

    if(!empty($_POST['reto']) && !empty($_POST['name_opcion'])){
      // print_r($_POST);
      $id_retoinv = $_POST['reto'];
      $nombre_premio = ucwords(mb_strtolower($_POST['name_opcion']));
      $elementos = $_POST['cantidad_elementos'];
      $unidades = [];
      $inventarios = [];
      $tipos = [];
      for ($i=0; $i <$elementos ; $i++) {
        $unidades[count($unidades)] = $_POST['unidades'][$i];
        $inventarios[count($inventarios)] = $_POST['inventarios'][$i];
        $tipos[count($tipos)] = $_POST['tipos'][$i];
      }

      $retosinv = $lider->consultarQuery("SELECT * FROM retosinv WHERE estatus=1 and id_retoinv={$id_retoinv}");
      $cantidad_colsreto = 0;
      foreach ($retosinv as $key) {
        if(!empty($key['num_coleccionesreto'])){
          $cantidad_colsreto=$key['num_coleccionesreto'];
        }
      }
      $retosinv = $lider->consultarQuery("SELECT * FROM retos_campana WHERE estatus=1 and id_retoinv={$id_retoinv}");
      $id_premioB = 0;
      foreach ($retosinv as $key) {
        if(!empty($key['id_premio'])){
          $id_premioB=$key['id_premio'];
        }
      }
      $errores = 0;
      
      $borrado = $lider->eliminar("DELETE FROM premios WHERE id_premio={$id_premioB}");
      $borradoxd = $lider->eliminar("DELETE FROM premios_inventario WHERE id_premio={$id_premioB}");
      if($borrado['ejecucion']==true){
        $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
        $execPremio = $lider->registrar($query, "premios", "id_premio");
        if($execPremio['ejecucion']==true){
          $id_premio = $execPremio['id'];
          for ($z=0; $z < $elementos; $z++){
            $unidad = $unidades[$z];
            $tipo = $tipos[$z];
            $id_inventario = $inventarios[$z];
            $posMercancia = strpos($id_inventario,'m');
            if(strlen($posMercancia)==0){
              $id_element = $id_inventario;
            }else{
              $id_element = preg_replace("/[^0-9]/", "", $id_inventario);
            }
            $query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidad}, '{$tipo}', 1)";
            $execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
            if($execPI['ejecucion']==true){
            }else{
              $errores++;
            }
          }
  
          // $query = "INSERT INTO retos_campana (id_reto_campana, id_retoinv, id_premio, id_campana, cantidad_coleccion, estatus) VALUES (DEFAULT, $id_retoinv, $id_premio, $id_campana, $cantidad_colsreto, 1)";
          $query = "UPDATE retos_campana SET id_premio={$id_premio}, estatus=1 WHERE id_reto_campana={$id}";
          $exec = $lider->modificar($query);
          if($exec['ejecucion']==true ){
          }else{
            $errores++;
          }
        }else{
          $errores++;
        }
      }else{
        $errores++;
      }
      
      if($errores==0){
        $response = "1";
      }else{
        $response = "2";
      }
      // die();
      // $id_reto = $_POST['premios'];
      // $cantidad = $_POST['cantidad'];      
      // $exec = $lider->registrar($query, "retos_campana", "id_reto_campana");
      // if($exec['ejecucion']==true ){
      //   $response = "1";
      // }else{
      //   $response = "2";
      // }

      // die();

      $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 ORDER BY producto asc;");
      $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 ORDER BY mercancia asc;");
      $retosInv = $lider->consultarQuery("SELECT * FROM retosinv WHERE estatus=1 ORDER BY num_coleccionesreto ASC");
      $rcp = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} and retos_campana.id_reto_campana = $id");
      $retos_campana = $lider->consultarQuery("SELECT * FROM retos_campana WHERE retos_campana.estatus=1 and retos_campana.id_campana = {$id_campana}");

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

      // $premios=$lider->consultar("premios");
      // $retos_campanaId = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} and retos_campana.id_reto_campana = $id");
      // $retos_campana = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana}");

      $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 ORDER BY producto asc;");
      $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 ORDER BY mercancia asc;");
      $retosInv = $lider->consultarQuery("SELECT * FROM retosinv WHERE estatus=1 ORDER BY num_coleccionesreto ASC");
      $rcp = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana} and retos_campana.id_reto_campana = $id");
      $retos_campana = $lider->consultarQuery("SELECT * FROM retos_campana WHERE retos_campana.estatus=1 and retos_campana.id_campana = {$id_campana}");

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