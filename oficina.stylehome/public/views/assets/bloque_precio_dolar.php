<?php 
  $fecha = date('Y-m-d');
  $tasas = $lid3r->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '{$fecha}'");
  if(Count($tasas)>1){ $tasa = $tasas[0];
    ?>
      <div class="col-xs-12 col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-left:15%"><u><b>Tasa del dia</b></u></h3>
            <?php $fechaHoy = $lider->formatFecha($tasa['fecha_tasa']); ?>
            <?php 
              $dd = substr($fechaHoy, 0, 2);
              $mm = substr($fechaHoy, 3, 2);
              $yy = substr($fechaHoy, 6, 4);
              if($mm=="01"){$mm="Enero";}
              if($mm=="02"){$mm="Febrero";}
              if($mm=="03"){$mm="Marzo";}
              if($mm=="04"){$mm="Abril";}
              if($mm=="05"){$mm="Mayo";}
              if($mm=="06"){$mm="Junio";}
              if($mm=="07"){$mm="Julio";}
              if($mm=="08"){$mm="Agosto";}
              if($mm=="09"){$mm="Septiembre";}
              if($mm=="10"){$mm="Octubre";}
              if($mm=="11"){$mm="Noviembre";}
              if($mm=="12"){$mm="Diciembre";}
            ?>
            <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>Bs. ".number_format($tasa['monto_tasa'],4,',','.')."</b> al ".$dd." de ".strtolower($mm)." del ".$yy; ?></h4>
            <!-- <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>$".number_format($tasa['monto_tasa'],4,',','.')."</b> a la fecha ".$fechaHoy; ?></h4> -->
          </div>
        </div>
      </div>
<?php } ?>