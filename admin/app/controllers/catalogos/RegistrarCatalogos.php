<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

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

        // print_r($_POST);


        // echo "nombre: ".$nombre."<br>";
        // echo "codigo: ".$codigo."<br>";
        // echo "marca: ".$marca."<br>";
        // echo "color: ".$color."<br>";
        // echo "voltaje: ".$voltaje."<br>";
        // echo "caracteristicas: ".$caracteristicas."<br>";
        // echo "puestos: ".$puestos."<br>";
        // echo "otros: ".$otros."<br>";


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
        $query = "INSERT INTO catalogos (id_catalogo, nombre_catalogo, codigo_catalogo, marca_catalogo, color_catalogo, voltaje_catalogo, caracteristicas_catalogo, puestos_catalogo, otros_catalogo, cantidad_gemas, imagen_catalogo, estatus) VALUES (DEFAULT, '$nombre', '$codigo', '$marca', '$color', '$voltaje', '$caracteristicas', '$puestos', '$otros', '$cantidad', '$imagen', 1)";
        $exec = $lider->registrar($query, "catalogos", "id_catalogo");
        if($exec['ejecucion']==true){
          $response = "1";
        }else{
          $response = "2";
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

        // print_r($exec);
      }


      if(empty($_POST)){
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