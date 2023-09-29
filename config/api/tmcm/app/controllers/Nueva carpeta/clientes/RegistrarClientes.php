<?php 


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


?>