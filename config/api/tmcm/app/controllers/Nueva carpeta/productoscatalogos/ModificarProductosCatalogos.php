<?php 

// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

      if(!empty($_POST['validarData'])){
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $codigo = mb_strtoupper($_POST['codigo']);

        $query = "SELECT * FROM catalogos WHERE codigo_producto_catalogo = '{$codigo}' and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            if($res1[0]['codigo_producto_catalogo']==$id){
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
        $codigo = "";
        $nombre = "";
        $imagen = "";
        $ficha = "";

        $codigo = mb_strtoupper($_POST['codigo']);
        $nombre = ucwords(mb_strtolower($_POST['nombre']));

        $catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 and codigo_producto_catalogo = '{$id}'");
        $catalogo=$catalogos[0];
        $imagen = $catalogo['imagen_producto_catalogo'];
        $ficha = $catalogo['ficha_producto_catalogo'];

        $dirCatalogo = "public/assets/img/catalogo/";
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
                $final = $dirCatalogo.$codigo.'.'.$extImg;
                if($errorImg=="0"){
                  if(move_uploaded_file($tempImg, $final)){
                    $responseImg = "1";
                    $imagen = $final;
                    if($codigo!=$catalogo['codigo_producto_catalogo']){
                      unlink($dirCatalogo.$catalogo['codigo_producto_catalogo'].'.'.$extImg);
                    }
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

        if(!empty($_FILES['ficha'])){
          $imgFichaCatalogo = $_FILES['ficha'];

          $nameImg = $imgFichaCatalogo['name'];
          if(isset($nameImg) && $nameImg!=""){
            $tipoImg = $imgFichaCatalogo['type'];
            $extPos = strpos($tipoImg, "/");
            $extImg = substr($tipoImg, $extPos+1);
            $sizeImg = $imgFichaCatalogo['size'];
            $tempImg = $imgFichaCatalogo['tmp_name'];
            $errorImg = $imgFichaCatalogo['error'];
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
                $final = $dirCatalogo."ficha_".$codigo.'.'.$extImg;
                if($errorImg=="0"){
                  if(move_uploaded_file($tempImg, $final)){
                    $responseImg = "1";
                    $ficha = $final;
                    if($codigo!=$catalogo['codigo_producto_catalogo']){
                      unlink($dirCatalogo."ficha_".$catalogo['codigo_producto_catalogo'].'.'.$extImg);
                    }
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

        // echo "Nombre: '".$nombre."'<br>";
        // echo "codigo: '".$codigo."'<br>";
        // echo "imagen: '".$imagen."'<br>";
        // echo "Ficha: '".$ficha."'<br>";

        $query = "UPDATE catalogos SET codigo_producto_catalogo='{$codigo}', nombre_producto_catalogo='{$nombre}', imagen_producto_catalogo='{$imagen}', ficha_producto_catalogo='{$ficha}', estatus=1 WHERE codigo_producto_catalogo = '{$id}'";

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
        $catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 and codigo_producto_catalogo = '{$id}'");
        if(count($catalogos)>1){
          $catalogo = $catalogos[0];
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