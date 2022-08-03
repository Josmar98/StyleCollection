<?php 


$amDespachos = 0;
$amDespachosR = 0;
$amDespachosC = 0;
$amDespachosE = 0;
$amDespachosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Despachos"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amDespachosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amDespachosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amDespachosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amDespachosB = 1;
      }
    }
  }
}
if($amDespachosE == 1){

    $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];


    if(!empty($_POST['validarData'])){
      $numero_despacho = $_POST['numero_despacho'];
      // echo 'Numero: '.$numero_despacho;
      // echo 'Id: '.$id_campana;
      $query = "SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana";
      $res1 = $lider->consultarQuery($query);
      // print_r($res1);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
            $response = "1";
        }else{
          $response = "9"; //echo "Registro ya guardado.";
        }
      }else{
        $response = "5"; // echo 'Error en la conexion con la bd';
      }
      echo $response;
    }


    if(!empty($_POST['numero_despacho']) && empty($_POST['validarData'])){
      // print_r($_POST);
      $numero_despacho = $_POST['numero_despacho'];
      $fecha_inicial = $_POST['inicial'];
      $primer_pago = $_POST['primer_pago'];
      $segundo_pago = $_POST['segundo_pago'];
      $limite_pedido = $_POST['limite_pedido'];
      $limite_seleccion_plan = $_POST['limite_seleccion_plan'];

      $fecha_inicial_senior = $_POST['inicial_senior'];
      $primer_pago_senior = $_POST['primer_pago_senior'];
      $segundo_pago_senior = $_POST['segundo_pago_senior'];
      
      
      $query = "UPDATE despachos SET numero_despacho=$numero_despacho, fecha_inicial='$fecha_inicial', fecha_primera='$primer_pago', fecha_segunda='$segundo_pago', limite_pedido = '$limite_pedido', limite_seleccion_plan = '$limite_seleccion_plan', fecha_inicial_senior = '{$fecha_inicial_senior}', fecha_primera_senior='{$primer_pago_senior}', fecha_segunda_senior='{$segundo_pago_senior}', estatus = 1 WHERE id_despacho = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion'] == true){
        $response = "1";
      }else{
        $response = "2";
      }

      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      $despacho = $despachos[0];
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
      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      if(Count($despachos)>1){
          $despacho = $despachos[0];
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