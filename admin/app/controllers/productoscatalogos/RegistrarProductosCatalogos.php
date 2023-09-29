<?php 

// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

      if(!empty($_POST['validarData'])){
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $codigo = mb_strtoupper($_POST['codigo']);

        $query = "SELECT * FROM catalogos WHERE codigo_producto_catalogo = '{$codigo}' and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
             // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM catalogos WHERE codigo_producto_catalogo = '{$codigo}' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE catalogos SET estatus = 1 WHERE codigo_producto_catalogo = '{$codigo}'");
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
        $imagen = "";
        $ficha = "";
        $ficha2 = "";
        $ficha3 = "";
        $ficha4 = "";
        $video = "";

        $codigo = mb_strtoupper($_POST['codigo']);
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
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
                $final = $dirCatalogo.$codigo.'.'.$extImg;
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
        if(!empty($_FILES['ficha2'])){
          $imgFichaCatalogo = $_FILES['ficha2'];

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
                $final = $dirCatalogo."ficha2_".$codigo.'.'.$extImg;
                if($errorImg=="0"){
                  if(move_uploaded_file($tempImg, $final)){
                    $responseImg = "1";
                    $ficha2 = $final;
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
        if(!empty($_FILES['ficha3'])){
          $imgFichaCatalogo = $_FILES['ficha3'];

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
                $final = $dirCatalogo."ficha3_".$codigo.'.'.$extImg;
                if($errorImg=="0"){
                  if(move_uploaded_file($tempImg, $final)){
                    $responseImg = "1";
                    $ficha3 = $final;
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
        if(!empty($_FILES['ficha4'])){
          $imgFichaCatalogo = $_FILES['ficha4'];

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
                $final = $dirCatalogo."ficha4_".$codigo.'.'.$extImg;
                if($errorImg=="0"){
                  if(move_uploaded_file($tempImg, $final)){
                    $responseImg = "1";
                    $ficha4 = $final;
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

        $query = "INSERT INTO catalogos (codigo_producto_catalogo, nombre_producto_catalogo, imagen_producto_catalogo, ficha_producto_catalogo, ficha_producto_catalogo2, ficha_producto_catalogo3, ficha_producto_catalogo4, video_producto_catalogo, estatus) VALUES ('{$codigo}', '{$nombre}', '{$imagen}', '{$ficha}', '{$ficha2}', '{$ficha3}', '{$ficha4}', '{$video}', 1)";
        // echo "Cod: ".$codigo."<br>";
        // echo "Nombre: ".$nombre."<br>";
        // echo "Imagen: ".$imagen."<br>";
        // echo "Ficha: ".$ficha."<br>";
        // echo "<br>";
        // echo $query."<br>";



        $exec = $lider->registrar($query, "catalogos", "codigo_producto_catalogo");
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