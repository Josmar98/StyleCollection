<?php 

// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){
$cantidadLimiteDeImagenes=24;
      if(!empty($_POST['validarData'])){
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $codigo = mb_strtoupper($_POST['codigo']);

        $query = "SELECT * FROM ccatalogos WHERE codigo_catalogo = '{$codigo}' and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            if($res1[0]['codigo_catalogo']==$id){
              $response = "1";
            }else{
              $response = "9"; //echo "Registro ya guardado.";
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

        $codigo = mb_strtoupper($_POST['codigo']);
        $nombre = ucwords(mb_strtolower($_POST['nombre']));

        $catalogos=$lider->consultarQuery("SELECT * FROM ccatalogos WHERE estatus = 1 and codigo_catalogo = '{$id}'");
        $catalogo=$catalogos[0];
        $video = $catalogo['video_catalogo'];
        $indexes = [];
        $imagenes = [];
        foreach($catalogo as $name => $val){
          $posIC = "";
          $posIC = strpos($name, 'magen_');
          if($posIC>0){
            if($val!=""){
              $index = substr($name, strlen('imagen_catalogo'));
              if(!empty($catalogo['imagen_catalogo'.$index])){
                $indexes[count($indexes)]=$index;
              }
            }
          }
        }
        $cantidadPaginas = (!empty($_GET['paginas'])) ? $_GET['paginas'] : $index;
        // echo $index." == ".$cantidadPaginas;
        // for ($i=1; $i <= $index; $i++) { 
        //   $imagenes[count($imagenes)]=$catalogo['imagen_catalogo'.$i];
        // }
        // $imagen = $catalogo['imagen_producto_catalogo'];
        // $ficha = $catalogo['ficha_producto_catalogo'];

        $dirCatalogo = "public/assets/img/ccatalogo/";
        // if(!empty($_FILES['imagen'])){
        //   $imgCatalogo = $_FILES['imagen'];

        //   $nameImg = $imgCatalogo['name'];
        //   if(isset($nameImg) && $nameImg!=""){
        //     $tipoImg = $imgCatalogo['type'];
        //     $extPos = strpos($tipoImg, "/");
        //     $extImg = substr($tipoImg, $extPos+1);
        //     $sizeImg = $imgCatalogo['size'];
        //     $tempImg = $imgCatalogo['tmp_name'];
        //     $errorImg = $imgCatalogo['error'];
        //     // echo "<br><br>";
        //     // echo "Tipo IMG: ".$tipoImg."<br>";
        //     // echo "Extension IMG: ".$extImg."<br>";
        //     // echo "Tamanio IMG: ".($sizeImg/1000000)." MB<br>";
        //     // echo "archivo temp IMG: ".$tempImg."<br>";
        //     // echo "Error IMG: ".$errorImg."<br>";

        //     if(!( strpos($tipoImg, 'jpeg') || strpos($tipoImg, 'jpg') || strpos($tipoImg, 'png') || strpos($tipoImg, 'JPEG') || strpos($tipoImg, 'JPG') || strpos($tipoImg, 'PNG') )){
        //       $responseImg = "73";  // Formato error
        //     }else{
        //       if(!( $sizeImg < 10000000 )){ // 10 MB - 10000 KB - 10000000 Bytes
        //         $responseImg = "74";   // tam limite Superado error
        //       }else{
        //         if($extImg=="jpeg"||$extImg=="jpg"||$extImg=="JPEG"||$extImg=="JPG"){$extImg = "jpg";}
        //         if($extImg=="png"||$extImg=="PNG"){ $extImg = "png";}
        //         $final = $dirCatalogo.$codigo.'.'.$extImg;
        //         if($errorImg=="0"){
        //           if(move_uploaded_file($tempImg, $final)){
        //             $responseImg = "1";
        //             $imagen = $final;
        //             if($codigo!=$catalogo['codigo_producto_catalogo']){
        //               unlink($dirCatalogo.$catalogo['codigo_producto_catalogo'].'.'.$extImg);
        //             }
        //           }else{
        //             $responseImg = "72";  // Error al cargar
        //           }
        //         }else{
        //           $responseImg = "75"; // Error error
        //         }
        //       }
        //     }
        //   }
        // }
          // print_r($_FILES);
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
            else{
              $imagenes[count($imagenes)]=$catalogo['imagen_catalogo'.$i];
            }
          }
        }
        // echo json_encode($imagenes);

        
        // echo "Nombre: '".$nombre."'<br>";
        // echo "codigo: '".$codigo."'<br>";
        // echo "imagen: '".$imagen."'<br>";
        // echo "Ficha: '".$ficha."'<br>";

        // $query = "UPDATE catalogos SET codigo_producto_catalogo='{$codigo}', nombre_producto_catalogo='{$nombre}', imagen_producto_catalogo='{$imagen}', ficha_producto_catalogo='{$ficha}', ficha_producto_catalogo2='{$ficha2}', ficha_producto_catalogo3='{$ficha3}', ficha_producto_catalogo4='{$ficha4}', video_producto_catalogo='{$video}', estatus=1 WHERE codigo_producto_catalogo = '{$id}'";
        $query = "";
        $query .= "UPDATE ccatalogos SET codigo_catalogo='{$codigo}', nombre_catalogo='{$nombre}', video_catalogo='{$video}'";
        for ($i=0; $i < $cantidadPaginas; $i++){
          $query .= ", imagen_catalogo".($i+1)."='{$imagenes[$i]}'";
        }
        $query .= ", estatus=1 WHERE codigo_catalogo='{$id}'";
        // echo $query;

        $exec = $lider->modificar($query);
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
        $catalogos=$lider->consultarQuery("SELECT * FROM ccatalogos WHERE estatus = 1 and codigo_catalogo = '{$id}'");
        if(count($catalogos)>1){
          $catalogo = $catalogos[0];
          $indexes = [];
          foreach($catalogo as $name => $val){
            $posIC = "";
            $posIC = strpos($name, 'magen_');
            if($posIC>0){
              if($val!=""){
                $index = substr($name, strlen('imagen_catalogo'));
                if(!empty($catalogo['imagen_catalogo'.$index])){
                  $indexes[count($indexes)]=$index;
                }
              }
            }
          }
          // echo $index;
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
      }

// }else{
//     require_once 'public/views/error404.php';
// }


?>