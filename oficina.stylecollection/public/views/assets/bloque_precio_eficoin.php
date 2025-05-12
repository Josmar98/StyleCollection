<?php 
          $tasaeficoin="";
          $fecha = date('Y-m-d');
          $fechaActual=date("Y-m-d");
          $horaActual=date("H:i:s");
          // $horaActual="14:00:00";
          $turno=0;
          $proceder=false;
          $diasHabiles=5;
          if($horaActual>="07:00:00" && $horaActual<="13:59:00"){
            $turno=1;
            $proceder=true;
            $nameCampo="monto_tasa";
            $mensajeTasa="mañana";
            $horaLimiteTasa="La 01:59PM";
          }
          if($horaActual>="14:00:00" && $horaActual<="23:59:00"){
            $turno=0;
            $proceder=true;
            $nameCampo="monto_tasa_tarde";
            $mensajeTasa="tarde";
            $horaLimiteTasa="Las 11:59PM";
          }
          $eficoinssssssss = $lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 and fecha_tasa = '$fecha'");
          if(count($eficoinssssssss)>1){ $eficoinsss = $eficoinssssssss[0];
            if($eficoinsss[$nameCampo]!=0){
              ?>
              <div class="col-xs-12 col-md-6">
                <div class="box">
                  <div class="box-header">
                      <h3 class="box-title" style="margin-left:15%"><u><b>Precio Eficoin</b></u></h3>
                      <?php 
                        
                          $tasaeficoin = $eficoinsss[$nameCampo];
                          $fechaHoy = $lider->formatFecha($eficoinsss['fecha_tasa']); 
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

                          $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                          $diaHoy = $dias[date('w')];

                      ?>
                      <h4 style="font-size:1.2em;"><?php echo "El precio del <b>EfiCoin</b> es <b style='font-size:1.4em;color:#0B0;'>Bs. ".number_format($tasaeficoin,4,',','.')."</b> al ".$dd." de ".strtolower($mm)." del ".$yy; ?></h4>
                      <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                      <details>
                          <summary class="verocultarsummary">Ver / Ocultar Tabulador</summary>
                          <div class='text-content-eficoin'>
                              <?php
                                  $mensajeEficoin = "🌟 Estimado líder,\nHoy compramos tu Eficoin a Bs. ".number_format($tasaeficoin,4,',','.').".\n¡Tasa de la {$mensajeTasa} válida solo por hoy, ".$diaHoy." ".$dd." de ".strtolower($mm)." de ".$yy." Hasta {$horaLimiteTasa}!\n\n💰 Tabulador: \n- 1 Eficoin: Bs. ".number_format(($tasaeficoin*1),4,',','.')."\n- 5 Eficoin: Bs. ".number_format(($tasaeficoin*5),4,',','.')."\n- 10 Eficoin: Bs. ".number_format(($tasaeficoin*10),4,',','.')."\n- 20 Eficoin: Bs. ".number_format(($tasaeficoin*20),4,',','.')."\n- 50 Eficoin: Bs. ".number_format(($tasaeficoin*50),4,',','.')."\n- 100 Eficoin: Bs. ".number_format(($tasaeficoin*100),4,',','.')."\n📅 Nota: Para conciliar los abonos en tu factura por concepto de Eficoin debes entregarlos personalmente, tienes {$diasHabiles} días hábiles. ¡Te esperamos! 🎉";
                              ?>
                              <?php if($_SESSION['nombre_rol']!="Analista"){ ?>
                              <button class="col-xs-12 btn enviar2" onclick="copiarTextoEficoin()">Copiar Mensaje</button>
                              <br>
                              <?php } ?>
                              <textarea id="text-msj" style='min-width:100%;max-width:100%;min-height:300px;max-height:300px;' readonly><?=$mensajeEficoin; ?></textarea>
                          </div>
                      </details>
                      <?php } ?>
                  </div>
                </div>
              </div>
              <?php
            }
          }
        ?>
<style>
.verocultarsummary{

}
.verocultarsummary:hover{
    cursor:pointer;
    text-decoration:underline;
}
</style>    
<script>
function copiarTextoEficoin() {
  var texto = document.getElementById("text-msj");
  texto.select();
  document.execCommand("copy");
  $(".verocultarsummary").click();
}
</script>
