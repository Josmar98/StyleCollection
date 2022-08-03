<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

      if(!empty($_POST['validarData'])){
        $nombre = ucwords(mb_strtolower($_POST['nombre']));
        $codigo = mb_strtoupper($_POST['codigo']);
        $cantidad = $_POST['cantidad'];

        $query = "SELECT * FROM catalogos WHERE nombre_catalogo = '$nombre' and cantidad_gemas='$cantidad' and estatus = 1";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            if($res1[0]['id_catalogo']==$id){
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

        $catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 and id_catalogo = $id");
        $catalogo=$catalogos[0];
        $imagen = $catalogo['imagen_catalogo'];

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
                    if($nombre!=$catalogo['nombre_catalogo'] || $codigo!=$catalogo['codigo_catalogo']){
                      unlink($dirCatalogo.$catalogo['nombre_catalogo'].$catalogo['codigo_catalogo'].'.'.$extImg);
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
        // echo "cantidad: '".$cantidad."'<br>";
        // echo "imagen: '".$imagen."'<br>";

        $query = "UPDATE catalogos SET nombre_catalogo='$nombre', codigo_catalogo='$codigo', marca_catalogo='$marca', color_catalogo='$color', voltaje_catalogo='$voltaje', caracteristicas_catalogo='$caracteristicas', puestos_catalogo='$puestos', otros_catalogo='$otros', cantidad_gemas='$cantidad', imagen_catalogo='$imagen', estatus=1 WHERE id_catalogo = $id";

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
        $catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 and id_catalogo = $id");
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

}else{
    require_once 'public/views/error404.php';
}


?>