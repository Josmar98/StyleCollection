<?php 

$amUsuarios = 0;
$amUsuariosR = 0;
$amUsuariosC = 0;
$amUsuariosE = 0;
$amUsuariosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Usuarios"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amUsuariosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amUsuariosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amUsuariosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amUsuariosB = 1;
      }
    }
  }
}
if($amUsuariosR == 1){

  if(!empty($_POST['clientes'])){
    $accLider = $_POST['accLider'];
    $clientes = $_POST['clientes'];
    $i = 0;
    // print_r($accLider);
    // echo "<br><br>";
    // print_r($clientes);
    // echo "<br><br>";
    foreach ($accLider as $data) {

      $buscar = $lider->consultarQuery("SELECT * FROM accesosUsuarios WHERE id_cliente = {$clientes[$i]}");
      if(Count($buscar)>1){
        $query = "UPDATE accesosUsuarios SET permiso_accesos='{$data}' WHERE id_cliente = {$clientes[$i]}";
        $exec = $lider->modificar($query);
        if($exec['ejecucion']==true){
          $response = "1";
          // $execss = "1";
        }else{
          $response = "2";
          // $execss = "2";          
        }
      }else{
        $query = "INSERT INTO accesosUsuarios (id_accesousuario, id_cliente, permiso_accesos) VALUES (DEFAULT, {$clientes[$i]}, '{$data}')";
        $exec = $lider->registrar($query, "accesosUsuarios", "id_accesousuario");
        if($exec['ejecucion']==true){
          $response = "1";
          // $execss = "1";
        }else{
          $response = "2";
          // $execss = "2";          
        }
      }

      $i++;
    }


    // if($execss=="1"){
    //   $response = "1";
    // }else{
    //   $response = "2";
    // }


    /*-----------------------------------------------------------*/
    $clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE clientes.id_cliente = usuarios.id_cliente and roles.id_rol = usuarios.id_rol and clientes.estatus = 1 and roles.nombre_rol != 'Administrador' ORDER BY clientes.id_cliente ASC");
    $accesosUsuarios = $lider->consultarQuery("SELECT * FROM accesosUsuarios");
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
    // $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    // $despachosActual = Count($despachosActual)-1;
    $clientes = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE clientes.id_cliente = usuarios.id_cliente and roles.id_rol = usuarios.id_rol and clientes.estatus = 1 and roles.nombre_rol != 'Administrador' ORDER BY clientes.id_cliente ASC");

    $accesosUsuarios = $lider->consultarQuery("SELECT * FROM accesosUsuarios");
    
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