<?php 

$amClientes = 0;
$amClientesR = 0;
$amClientesC = 0;
$amClientesE = 0;
$amClientesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Clientes"){
      $amClientes = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amClientesR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amClientesC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amClientesE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amClientesB = 1;
      }

    }
  }
}
if($amClientesR == 1){

    if(!empty($_POST['validarData'])){
      $cedula = $_POST['cedula'];
      $correo = $_POST['correo'];
      $query = "SELECT * FROM clientes WHERE cedula = '$cedula'";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
          $res2 = $lider->consultarQuery("SELECT * FROM clientes WHERE cedula = '$cedula' and estatus = 0");
          if($res2['ejecucion']==true){
            if(Count($res2)>1){
              $res3 = $lider->modificar("UPDATE clientes SET estatus = 1 WHERE cedula = '$cedula'");
              if($res3['ejecucion']==true){
                $response = "1";
              }
            }else{
              $response = "9"; //echo "Registro ya guardado.";
            }
          }

        }else{
          $correolen1 = strlen($correo) - 4;
          $correolen2 = strlen($correo);
          $correoterminator = substr($correo, $correolen1, $correolen2);
          if($correoterminator == ".com"){
            $response = "1";
          }else{
            $response = "4";
          }
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
      $cod_cedula = $_POST['cod_cedula'];
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
      $id_lider = $_POST['lider'];
      $direccion = ucwords(mb_strtolower($_POST['direccion']));
      
      $correolen1 = strlen($correo) - 4;
      $correolen2 = strlen($correo);
      $correoterminator = substr($correo, $correolen1, $correolen2);

      $query = "INSERT INTO clientes (id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cod_cedula, cedula, sexo, fecha_nacimiento, telefono, telefono2, correo, cod_rif, rif, direccion, id_lider, estatus) VALUES (DEFAULT, '$nombre1', '$nombre2', '$apellido1', '$apellido2', '$cod_cedula', '$cedula', '$sexo', '$fechaNacimiento', '$telefono', '$telefono2', '$correo', '$cod_rif', '$rif', '$direccion', $id_lider, 1)";

      $exec = $lider->registrar($query, "clientes", "id_cliente");
      if($exec['ejecucion']==true){
        $response = "1";
          if(!empty($modulo) && !empty($accion)){
            $id = $exec['id'];
            $elementos = array(
              "Nombres"=> [0=>"Id", 1=>ucwords("Primer Nombre"), 2=> ucwords("Segundo Nombre"), 3=> ucwords("Primer Apellido"), 4=>ucwords("Segundo Apellido"), 5=>ucwords("Codigo de Cedula"), 6=>ucwords("Cedula"), 7=> ucwords("Sexo"), 8=>ucwords("Fecha de Nacimiento"), 9=>ucwords("Primer Telefono"), 10=>ucwords("Segundo Telefono"), 11=>ucwords("Correo electronico"), 12=>ucwords("Codigo de Rif"), 13=>ucwords("Rif"), 14=>ucwords("Direccion"), 15=>ucwords("Id del Lider"), 16=>ucwords("Estatus")],
              "Anterior"=> "",
              "Actual"=> [ 0=> $id, 1=> $nombre1, 2=> $nombre2 , 3=>$apellido1, 4=>$apellido2, 5=>$cod_cedula, 6=>$cedula, 7=>$sexo, 8=>$lider->formatFecha($fechaNacimiento), 9=>$telefono, 10=>$telefono2, 11=>$correo, 12=>$cod_rif, 13=>$rif, 14=>$direccion, 15=>$id_lider, 16=>"1"]
            );
            $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);

            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Clientes', 'Registrar', '{$fecha}', '{$hora}', '{$elementosJson}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }

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
      $clientes = $lider->consultar("clientes");

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