<?php 

// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){
  $cantidadLimiteDeImagenes=24;
      if(!empty($_POST['validarData'])){
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $codigo = mb_strtoupper($_POST['codigo']);

        $query = "SELECT * FROM ccatalogos WHERE codigo_catalogo = '{$codigo}' and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
             // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM ccatalogos WHERE codigo_catalogo = '{$codigo}' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE ccatalogos SET estatus = 1 WHERE codigo_catalogo = '{$codigo}'");
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

      if(empty($_POST['validarData']) && isset($_POST['nombre']) && isset($_POST['codigo'])){
        $codigo = "";
        $nombre = "";
        $video = "";
        $imagenes = [];

        $codigo = mb_strtoupper($_POST['codigo']);
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $dirCatalogo = "public/assets/img/ccatalogo/";

        $cantidadPaginas = (!empty($_GET['paginas'])) ? $_GET['paginas'] : 1;

        for ($i=1; $i <= $cantidadPaginas; $i++) { 
          // echo $i." | ";
          if(!empty($_FILES['imagen'.$i])){
            $imgCatalogo = $_FILES['imagen'.$i];

            $nameImg = $imgCatalogo['name'];
            if(isset($nameImg) && $nameImg!=""){
              $tipoImg = $imgCatalogo['type'];
              $extPos = strpos($tipoImg, "/");
              $extImg = substr($tipoImg, $extPos+1);
              $sizeImg = $imgCatalogo['size'];
              $tempImg = $imgCatalogo['tmp_name'];
              $errorImg = $imgCatalogo['error'];

              if(!( strpos($tipoImg, 'jpeg') || strpos($tipoImg, 'jpg') || strpos($tipoImg, 'png') || strpos($tipoImg, 'JPEG') || strpos($tipoImg, 'JPG') || strpos($tipoImg, 'PNG') )){
                $responseImg = "73";  // Formato error
              }else{
                if(!( $sizeImg < 10000000 )){ // 10 MB - 10000 KB - 10000000 Bytes
                  $responseImg = "74";   // tam limite Superado error
                }else{
                  if($extImg=="jpeg"||$extImg=="jpg"||$extImg=="JPEG"||$extImg=="JPG"){$extImg = "jpg";}
                  if($extImg=="png"||$extImg=="PNG"){ $extImg = "png";}
                  $final = $dirCatalogo.$codigo.$i.'.'.$extImg;
                  if($errorImg=="0"){
                    if(move_uploaded_file($tempImg, $final)){
                      $responseImg = "1";
                      $imagenes[count($imagenes)] = $final;
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
        }


        // $query = "INSERT INTO ccatalogos (codigo_catalogo, nombre_catalogo, video_catalogo, imagen_catalogo, ficha_catalogo, ficha_catalogo2, ficha_catalogo3, ficha_catalogo4, estatus) VALUES ('{$codigo}', '{$nombre}', '{$video}', '{$imagen}', '{$ficha}', '{$ficha2}', '{$ficha3}', '{$ficha4}', 1)";

        // echo "Cod: ".$codigo."<br>";
        // echo "Nombre: ".$nombre."<br>";
        // echo "Imagenes: <br>";
        // print_r($imagenes);
        // echo "Imagen: ".$imagen."<br>";
        // echo "Ficha: ".$ficha."<br>";
        // echo "<br>";
        // echo $query."<br>";
        $query = "";
        $query .= "INSERT INTO ccatalogos (codigo_catalogo, nombre_catalogo, video_catalogo";
        for ($i=1; $i <= $cantidadPaginas; $i++){
          $query .= ", imagen_catalogo".$i;
        }
        $query .= ", estatus) VALUES ('{$codigo}', '{$nombre}', '{$video}'";
        for ($i=0; $i < $cantidadPaginas; $i++){
          $query .= ", '{$imagenes[$i]}'";
        }
        $query .= ", 1)";
        // echo $query;



        $exec = $lider->registrar($query, "ccatalogos", "codigo_catalogo");
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

// }else{
//     require_once 'public/views/error404.php';
// }


?>