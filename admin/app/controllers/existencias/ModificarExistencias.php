<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

  
      
      $id_campana = $_GET['campaing'];
      $numero_campana = $_GET['n'];
      $anio_campana = $_GET['y'];



    if(!empty($_POST['premios']) && !empty($_POST['cantidad_existencia']) ){
      $id_premio = $_POST['premios'];
      $existencia = $_POST['cantidad_existencia'];
      $id_existencia = $_POST['id_existencia'];

      $existencias2 = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = {$id_existencia}");
      $exitenciaActual = $existencias2[0]['cantidad_existencia'];
      $exitenciaActualReal = $existencias2[0]['cantidad_existencia_real'];
      $exxiss = $exitenciaActualReal-$exitenciaActual;

      //292 - 350 = 58;
      // print_r($existencias2);
      
      $exitenciaNueva = $existencia-$exxiss;
      $query = "UPDATE existencias SET id_premio={$id_premio}, id_campana={$id_campana}, cantidad_existencia={$exitenciaNueva}, cantidad_existencia_real={$existencia}, estatus=1 WHERE id_existencia = {$id_existencia}";
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true ){
        $response = "1";

        if(!empty($modulo) && !empty($accion)){
                  $fecha = date('Y-m-d');
                  $hora = date('H:i:a');
                  $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Existencias', 'Editar', '{$fecha}', '{$hora}')";
                  $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                }
      }else{
        $response = "2";
      }


      $premios_planes = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1"); 
      $existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
      $existencias2 = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = {$id}");
      
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

      $premios_planes = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1"); 
      // $premios_planes = $lider->consultarQuery("SELECT * FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and tipos_premios_planes_campana.tipo_premio_producto='Premios' and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes_campana.id_campana = {$id_campana}"); 
      $existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
      $existencias2 = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana} and existencias.id_existencia = {$id}");

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