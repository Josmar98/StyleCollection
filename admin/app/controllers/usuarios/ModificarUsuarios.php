<?php 

$amUsuarios = 0;
$amUsuariosR = 0;
$amUsuariosC = 0;
$amUsuariosE = 0;
$amUsuariosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Usuarios"){
      $amUsuarios = 1;
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
if($amUsuariosE == 1){

    if(!empty($_POST['validarData'])){
      $query = "SELECT * FROM usuarios WHERE id_usuario = $id";
      $res1 = $lider->consultarQuery($query);
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

    if(!empty($_POST['nombre_usuario']) && !empty($_POST['password'])){

      // print_r($_POST);
      $nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
      $password = $_POST['password'];
      $id_rol = $_POST['rol'];
      $id_cliente = $_POST['cliente'];
      $campAnt = $lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario = $id");
      $query = "UPDATE usuarios SET id_rol=$id_rol, id_cliente=$id_cliente, nombre_usuario='$nombre_usuario', password='$password', estatus = 1 WHERE id_usuario = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";

            if(!empty($modulo) && !empty($accion)){
                $campAnt = $campAnt[0];
                $elementos = array(
                  "Nombres"=> [0=>"Id", 1=>ucwords("Id Rol"), 2=> ucwords("Id Cliente"), 3=> ucwords("Nombre de usuario"), 4=>ucwords("Contraseña"), 5=>ucwords("Estatus")],
                  "Anterior"=> [ 0=> $id, 1=> $campAnt['id_rol'], 2=> $campAnt['id_cliente'] , 3=>$campAnt['nombre_usuario'], 4=>$campAnt['password'], 5=>$campAnt['estatus']],
                  "Actual"=> [ 0=> $id, 1=> $id_rol, 2=> $id_cliente , 3=>$nombre_usuario, 4=>$password, 5=>"1"]
                );
                $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);

                  $fecha = date('Y-m-d');
                  $hora = date('H:i:a');
                  $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Usuarios', 'Editar', '{$fecha}', '{$hora}', '{$elementosJson}')";
                  $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                }
      }else{
        $response = "2";
      }

      $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
      $roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 ORDER BY nombre_rol desc;");
      $usuarios = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
      $usuario = $usuarios[0];
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
      $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
      $usuarios = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
      if($_SESSION['nombre_rol']=="Superusuario"){
        $roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 ORDER BY nombre_rol desc;");
      }else if($_SESSION['nombre_rol']=="Administrador"){
        $roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 and nombre_rol != 'Superusuario' ORDER BY nombre_rol desc;");
      }else if($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){
        $roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 and nombre_rol != 'Superusuario' and nombre_rol != 'Administrador' ORDER BY nombre_rol desc;");
      }else{
        $roles = [];
        // $roles = $lider->consultarQuery("SELECT * FROM roles WHERE estatus = 1 ORDER BY nombre_rol desc;");
      }
      if(Count($usuarios)>1){
          $usuario = $usuarios[0];
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