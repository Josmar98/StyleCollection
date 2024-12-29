<?php 
$amCatalogos = 0;
$amCatalogosR = 0;
$amCatalogosC = 0;
$amCatalogosE = 0;
$amCatalogosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Catalogos"){
      $amCatalogos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amCatalogosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amCatalogosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amCatalogosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amCatalogosB = 1;
      }
    }
  }
}
if($amCatalogosR == 1){
  $limiteElementos=10;
  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $codigo = mb_strtoupper($_POST['codigo']);
    $cantidad = $_POST['cantidad'];

    $query = "SELECT * FROM catalogos WHERE nombre_catalogo = '$nombre' and cantidad_gemas='$cantidad' and estatus = 1";
    $res1 = $lider->consultarQuery($query);
    // print_r($res1);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
          // $response = "9"; //echo "Registro ya guardado.";
        $res2 = $lider->consultarQuery("SELECT * FROM catalogos WHERE nombre_catalogo = '$nombre' and cantidad_gemas='$cantidad' and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE catalogos SET estatus = 1 WHERE nombre_catalogo = '$nombre' and cantidad_gemas='$cantidad'");
            if($res3['ejecucion']==true){
              $response = "1";
            }
          }else{
            $response = "9"; //echo "Registro ya guardado.";
          }
        }


      }else{
          $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(empty($_POST['validarData']) && isset($_POST['nombre']) && isset($_POST['codigo']) && isset($_POST['cantidad'])){
    $nombre = "";
    $codigo = "";
    $marca = "";
    $color = "";
    $voltaje = "";
    $caracteristicas = "";
    $puestos = "";
    $otros = "";

    $cantidad = "";
    $imagen = "";

    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $codigo = mb_strtoupper($_POST['codigo']);
    $marca = ucwords(mb_strtolower($_POST['marca']));
    $color = ucwords(mb_strtolower($_POST['color']));
    $voltaje = ucwords(mb_strtolower($_POST['voltaje']));
    $caracteristicas = ucwords(mb_strtolower($_POST['caracteristicas']));
    $puestos = ucwords(mb_strtolower($_POST['puestos']));
    $otros = ucwords(mb_strtolower($_POST['otros']));
    $cantidad = $_POST['cantidad'];

    $cantidad_elementos = $_POST['cantidad_elementos'];
    $stocks = $_POST['stock'];
    $inventarios = $_POST["inventario"];
    $tipos_inventarios = $_POST["tipos"];

    // print_r($_POST);
    // die();
    $dirCatalogo = "public/assets/img/catalogo/";
    // print_r($_FILES);
    if(!empty($_FILES['imagen'])){
      $imgCatalogo = $_FILES['imagen'];

      $nameImg = $imgCatalogo['name'];
      if(isset($nameImg) && $nameImg!=""){
        $tipoImg = $imgCatalogo['type'];
        $extPos = strpos($tipoImg, "/");
        $extImg = substr($tipoImg, $extPos+1);
        $sizeImg = $imgCatalogo['size'];
        $tempImg = $imgCatalogo['tmp_name'];
        $errorImg = $imgCatalogo['error'];
        // echo "<br><br>";
        // echo "Tipo IMG: ".$tipoImg."<br>";
        // echo "Extension IMG: ".$extImg."<br>";
        // echo "Tamanio IMG: ".($sizeImg/1000000)." MB<br>";
        // echo "archivo temp IMG: ".$tempImg."<br>";
        // echo "Error IMG: ".$errorImg."<br>";

        if(!( strpos($tipoImg, 'jpeg') || strpos($tipoImg, 'jpg') || strpos($tipoImg, 'png') || strpos($tipoImg, 'JPEG') || strpos($tipoImg, 'JPG') || strpos($tipoImg, 'PNG') )){
          $responseImg = "73";  // Formato error
        }else{
          if(!( $sizeImg < 10000000 )){ // 10 MB - 10000 KB - 10000000 Bytes
            $responseImg = "74";   // tam limite Superado error
          }else{
            if($extImg=="jpeg"||$extImg=="jpg"||$extImg=="JPEG"||$extImg=="JPG"){$extImg = "jpg";}
            if($extImg=="png"||$extImg=="PNG"){ $extImg = "png";}
            $final = $dirCatalogo.$nombre.$cantidad.'.'.$extImg;
            if($errorImg=="0"){
              if(move_uploaded_file($tempImg, $final)){
                $responseImg = "1";
                $imagen = $final;
              }else{
                $responseImg = "72";  // Error al cargar
              }
            }else{
              $responseImg = "75"; // Error error
            }
          }
        }
      }
    }
    $errores=0;
    $nombre_premio = $nombre;
    $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
    // echo "<br><br>".$query."<br><br>"; $execPremio=['ejecucion'=>true, 'id'=>10005];
    $execPremio = $lider->registrar($query, "premios", "id_premio");
    if($execPremio['ejecucion']==true){
      $id_premio = $execPremio['id'];
      for ($z=0; $z < $cantidad_elementos; $z++){
        $unidad = $stocks[$z];
        $id_inventario = $inventarios[$z];
        $tipo = $tipos_inventarios[$z];
        $posMercancia = strpos($id_inventario,'m');
        if(strlen($posMercancia)==0){
          $id_element = $id_inventario;
        }else{
          $id_element = preg_replace("/[^0-9]/", "", $id_inventario);
        }
        $query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidad}, '{$tipo}', 1)";
        // echo "<br><br>".$query."<br><br>"; $execPI=['ejecucion'=>true, 'id'=>10005];
        $execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
        if($execPI['ejecucion']==true){
        }else{
          $errores++;
        }
      }
      $query = "INSERT INTO catalogos (id_catalogo, id_premio, nombre_catalogo, codigo_catalogo, marca_catalogo, color_catalogo, voltaje_catalogo, caracteristicas_catalogo, puestos_catalogo, otros_catalogo, cantidad_gemas, imagen_catalogo, estatus) VALUES (DEFAULT, {$id_premio}, '{$nombre}', '{$codigo}', '{$marca}', '{$color}', '{$voltaje}', '{$caracteristicas}', '{$puestos}', '{$otros}', '{$cantidad}', '{$imagen}', 1)";
      // echo "<br><br>".$query."<br><br>"; $exec=['ejecucion'=>true, 'id'=>10005];
      $exec = $lider->registrar($query, "catalogos", "id_catalogo");
      if($exec['ejecucion']==true){
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
    $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
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


  if(empty($_POST)){
    $productos = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercancia = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
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