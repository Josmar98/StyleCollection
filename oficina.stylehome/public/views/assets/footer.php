<?php
  if(isset($_GET['c']) && isset($_GET['n']) && isset($_GET['y'])){
    $newY = substr($_GET['y'], 2);
    $globito="";
    // if(isset($_GET['dpid']) && isset($_GET['dp'])){
    //   $globito .= mb_strtoupper($ndp)." P ";
    // }
    $globito .= "C".$_GET['n']."/".$newY;
    ?>
  <span class="btn enviar2" style="position:fixed;bottom:1vh;right:0;z-index:1000000;width:130px;">
    <?=$globito?>
  </span>
    <?php } ?>
<footer class="main-footer">

    <div class="pull-right hidden-xs string">

      <b>Version</b> 1.0.0

    </div>

    <strong class="string">Copyright &copy; 2023-2024 <a href="https://stylecollection.org">Style Collection</a>.</strong> <span class="string">Todos los derechos reservados.</span>

  </footer>