<?php 
$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
if(!empty($access['id_acceso'])){
  if($access['nombre_modulo'] == "Reportes"){
    $amReportes = 1;
    if($access['nombre_permiso'] == "Ver"){
      $amReportesC = 1;
    }
  }
}
}
if($amReportesC == 1){

  if(isset($_GET['C']) || isset($_GET['ID'])){


    $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
    $accesoBloqueo = "0";
    $superAnalistaBloqueo="1";
    $analistaBloqueo="1";
    foreach ($configuraciones as $config) {
      if(!empty($config['id_configuracion'])){
        if($config['clausula']=='Analistabloqueolideres'){
          $analistaBloqueo = $config['valor'];
        }
        if($config['clausula']=='Superanalistabloqueolideres'){
          $superAnalistaBloqueo = $config['valor'];
        }
      }
    }
    if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
    if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

    if($accesoBloqueo=="0"){
      // echo "Acceso Abierto";
    }
    if($accesoBloqueo=="1"){
      // echo "Acceso Restringido";
      $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
    }



    $lideres = $lider->consultarQuery("SELECT clientes.id_cliente, clientes.cedula, clientes.primer_nombre, clientes.primer_apellido FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC;");
    $catalogo = $lider->consultarQuery("SELECT * FROM catalogos ORDER BY id_catalogo ASC;");
    $newDataAcum = [];
    // $index = 0;
    foreach ($catalogo as $key) {
      if(!empty($key['id_catalogo'])){
        $index = $key['id_catalogo'];
        $newDataAcum[$index]['cantidad'] = 0;
        $newDataAcum[$index]['id'] = $key['id_catalogo'];
        $newDataAcum[$index]['gemas'] = $key['cantidad_gemas'];
        $newDataAcum[$index]['nombre'] = $key['nombre_catalogo'];
        $newDataAcum[$index]['marca'] = $key['marca_catalogo'];
        $index++;
      }
    }



    if(isset($_GET['C'])){
      if($_GET['C'] == 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL");
      }
      if($_GET['C'] > 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL and catalogos.cantidad_gemas = {$_GET['C']}");
      }
    }
    if(isset($_GET['ID'])){
      if($_GET['ID'] == 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL");
      }
      if($_GET['ID'] > 0){
        $listado = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and canjeos.estatus = 1 and canjeos.estado_canjeo IS NOT NULL and catalogos.id_catalogo = {$_GET['ID']}");
      }
      
    }

    
    $newData2 = [];
    foreach ($lideres as $data): if(!empty($data['id_cliente'])):
      $permitido = "0";
      if($accesoBloqueo=="1"){
        if(!empty($accesosEstructuras)){
          foreach ($accesosEstructuras as $struct) {
            if(!empty($struct['id_cliente'])){
              if($struct['id_cliente']==$data['id_cliente']){
                $permitido = "1";
              }
            }
          }
        }
      }else if($accesoBloqueo=="0"){
        $permitido = "1";
      }
      if($permitido=="1"):
        $indx = 0;
        foreach ($listado as $elemento) {
          if(!empty($elemento['id_cliente'])){
            if($elemento['id_cliente']==$data['id_cliente']){
              if(empty($newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo'])){
                $newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo']=0;
              }
              $newData2[$data['id_cliente']]['id_cliente'] = $data['id_cliente'];
              $newData2[$data['id_cliente']][$elemento['id_catalogo']]['cantidad_canjeo']++;
              // $newDataAcum[$elemento['id_catalogo']]['cantidad']++;
              $indx++;
            }
          }
        }  

      endif;

    endif; endforeach;

  }

  $gemasCatalogo = $lider->consultarQuery("SELECT DISTINCT cantidad_gemas FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas ASC;");
  $elementosCatalogo = $lider->consultarQuery("SELECT * FROM catalogos ORDER BY nombre_catalogo ASC;");
  // echo "Registros: ".count($newData);
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
?>