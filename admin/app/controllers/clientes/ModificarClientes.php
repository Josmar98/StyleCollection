<?php 


    if(!empty($_POST['validarData'])){
      $cedula = $_POST['cedula'];
      $correo = $_POST['correo'];
      $query = "SELECT * FROM clientes WHERE cedula = '$cedula'";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          $correolen1 = strlen($correo) - 4;
          $correolen2 = strlen($correo);
          $correoterminator = substr($correo, $correolen1, $correolen2);
          if($correoterminator == ".com"){
            $response = "1";
          }else{
            $response = "4";
          }
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
      $id_lider = $_POST['lider'];
      $sexo = ucwords(mb_strtolower($_POST['sexo']));
      $direccion = ucwords(mb_strtolower($_POST['direccion']));
      
      $correolen1 = strlen($correo) - 4;
      $correolen2 = strlen($correo);
      $correoterminator = substr($correo, $correolen1, $correolen2);
      $campAnt = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id");
      $query = "UPDATE clientes SET primer_nombre = '$nombre1', segundo_nombre = '$nombre2', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', cedula = '$cedula', sexo = '$sexo', fecha_nacimiento = '$fechaNacimiento', telefono = '$telefono', telefono2 = '$telefono2', correo = '$correo', cod_rif = '$cod_rif', rif = '$rif', direccion = '$direccion', id_lider = $id_lider, estatus = 1 WHERE id_cliente = $id";


      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";
      }else{
        $response = "2";
      }
          


      $query = "SELECT * FROM clientes WHERE estatus = 1 and id_cliente = $id";
      $clientes=$lider->consultarQuery($query);
      $datas = $clientes[0];
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

      $query = "SELECT * FROM clientes WHERE id_cliente = $id";
      $clientes=$lider->consultarQuery($query);
      $lideress = $lider->consultar("clientes");
      if(Count($clientes)>1){
          $datas = $clientes[0];
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


?>