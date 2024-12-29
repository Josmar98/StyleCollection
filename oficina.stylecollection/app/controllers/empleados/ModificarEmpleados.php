<?php 

$amEmpleados = 0;
$amEmpleadosR = 0;
$amEmpleadosC = 0;
$amEmpleadosE = 0;
$amEmpleadosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Empleados"){
      $amEmpleados = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amEmpleadosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amEmpleadosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amEmpleadosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amEmpleadosB = 1;
      }

    }
  }
}
if($amEmpleadosE == 1){

    if(!empty($_POST['validarData'])){
      $cedula = $_POST['cedula'];
      $correo = $_POST['correo'];
      $query = "SELECT * FROM empleados WHERE cedula = '$cedula'";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          $response = "1";
          // $correolen1 = strlen($correo) - 4;
          // $correolen2 = strlen($correo);
          // $correoterminator = substr($correo, $correolen1, $correolen2);
          // if($correoterminator == ".com"){
          //   $response = "1";
          // }else{
          //   $response = "4";
          // }
        }else{
          $response = "9"; //echo "Registro ya guardado.";
        }
      }else{
        $response = "5"; // echo 'Error en la conexion con la bd';
      }
      echo $response;
    }


    if(!empty($_POST['nombre1']) && !empty($_POST['cedula'])){

      // print_r($_POST);

      $nombre1 = ucwords(mb_strtolower($_POST['nombre1']));
      $nombre2 = ucwords(mb_strtolower($_POST['nombre2']));
      $apellido1 = ucwords(mb_strtolower($_POST['apellido1']));
      $apellido2 = ucwords(mb_strtolower($_POST['apellido2']));
      $cedula = $_POST['cedula'];
      $fechaNacimiento = $_POST['fechaNacimiento'];
      $cod_rif = $_POST['cod_rif'];
      $rif = $_POST['rif'];

      $cod_tlfn = $_POST['cod_tlfn'];
      $numtelefono = $_POST['telefono'];
      $telefono = $cod_tlfn.$numtelefono;


      $cod_tlfn2 = $_POST['cod_tlfn2'];
      $numtelefono2 = $_POST['telefono2'];
      $telefono2 = $cod_tlfn2.$numtelefono2;

      $correo = $_POST['correo'];
      $sexo = ucwords(mb_strtolower($_POST['sexo']));
      $direccion = ucwords(mb_strtolower($_POST['direccion']));
      
      $correolen1 = strlen($correo) - 4;
      $correolen2 = strlen($correo);
      $correoterminator = substr($correo, $correolen1, $correolen2);

      // $dirCatalogo = "public/assets/img/profile/";
      // $actualizarFoto = false;
      // if(!empty($_FILES['fotos'])){
      //   $imgCatalogo = $_FILES['fotos'];

      //   $nameImg = $imgCatalogo['name'];
      //   if(isset($nameImg) && $nameImg!=""){
      //     $actualizarFoto = true;

      //     $usuario = [];
      //     $usuarios = $lider->consultarQuery("SELECT * FROM usuarios WHERE estatus=1 and usuarios.id_cliente={$id}");
      //     $usuario = $usuarios[0];


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
      //         $final = $dirCatalogo."perfil".$id.'.'.$extImg;
      //         if($errorImg=="0"){
      //           if(move_uploaded_file($tempImg, $final)){
      //             $responseImg = "1";
      //             $imagen = $final;
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

      $campAnt = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado = $id");
      $query = "UPDATE empleados SET primer_nombre = '$nombre1', segundo_nombre = '$nombre2', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', cedula = '$cedula', sexo = '$sexo', fecha_nacimiento = '$fechaNacimiento', telefono = '$telefono', telefono2 = '$telefono2', correo = '$correo', cod_rif = '$cod_rif', rif = '$rif', direccion = '$direccion', estatus = 1 WHERE id_empleado = $id";
      // echo $query;
      // die();
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";
          // if($actualizarFoto==true){
          //   $query2 = $lider->modificar("UPDATE usuarios SET fotoPerfil='{$imagen}' WHERE usuarios.id_cliente={$id}");
          // }
          if(!empty($modulo) && !empty($accion)){
            $campAnt = $campAnt[0];
            $elementos = array(
              "Nombres"=> [0=>"Id", 1=>ucwords("Primer Nombre"), 2=> ucwords("Segundo Nombre"), 3=> ucwords("Primer Apellido"), 4=>ucwords("Segundo Apellido"), 5=>ucwords("Codigo de Cedula"), 6=>ucwords("Cedula"), 7=> ucwords("Sexo"), 8=>ucwords("Fecha de Nacimiento"), 9=>ucwords("Primer Telefono"), 10=>ucwords("Segundo Telefono"), 11=>ucwords("Correo electronico"), 12=>ucwords("Codigo de Rif"), 13=>ucwords("Rif"), 14=>ucwords("Direccion"), 15=>ucwords("Estatus")],
              "Anterior"=> [ 0=> $id, 1=> $campAnt['primer_nombre'], 2=> $campAnt['segundo_nombre'] , 3=>$campAnt['primer_apellido'], 4=>$campAnt['segundo_apellido'], 5=>$campAnt['cod_cedula'], 6=>$campAnt['cedula'], 7=>$campAnt['sexo'], 8=>$lider->formatFecha($campAnt['fecha_nacimiento']), 9=>$campAnt['telefono'], 10=>$campAnt['telefono2'], 11=>$campAnt['correo'], 12=>$campAnt['cod_rif'], 13=>$campAnt['rif'], 14=>$campAnt['direccion'], 15=>$campAnt['estatus']],
              "Actual"=> [ 0=> $id, 1=> $nombre1, 2=> $nombre2 , 3=>$apellido1, 4=>$apellido2, 5=>$campAnt['cod_cedula'], 6=>$cedula, 7=>$sexo, 8=>$lider->formatFecha($fechaNacimiento), 9=>$telefono, 10=>$telefono2, 11=>$correo, 12=>$cod_rif, 13=>$rif, 14=>$direccion, 15=>"1"]
            );
            $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);

            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Empleados', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
      }else{
        $response = "2";
      }
          


      $query = "SELECT * FROM empleados WHERE estatus = 1 and id_empleado = $id";
      $empleados=$lider->consultarQuery($query);
      $datas = $empleados[0];
      $cod_tlfn = substr($datas['telefono'], 0, 4);
      $numtelefono = substr($datas['telefono'], 4, strlen($datas['telefono']) );


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

      $query = "SELECT * FROM empleados WHERE id_empleado = $id";
      $empleados=$lider->consultarQuery($query);
      $lideress = $lider->consultar("empleados");
      if(Count($empleados)>1){
          $datas = $empleados[0];
          $usuario = [];
          // $usuarios = $lider->consultarQuery("SELECT * FROM usuarios WHERE estatus=1 and usuarios.id_empleado={$datas['id_empleado']}");
          // $usuario = $usuarios[0];

          $cod_tlfn = substr($datas['telefono'], 0, 4);
          $numtelefono = substr($datas['telefono'], 4, strlen($datas['telefono']) );
          $cod_tlfn2 = substr($datas['telefono2'], 0, 4);
          $numtelefono2 = substr($datas['telefono2'], 4, strlen($datas['telefono2']) );
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
      }else{
              require_once 'public/views/error404.php';   
      }
    }
}else{
    require_once 'public/views/error404.php';
}

?>