<?php 
   @session_start();
   require_once'../vendor/autoload.php';

   // $api = new Binance\API("<api key>","<secret>");
   
   $keyAPI = "w4c3DzFz5LhjHqxgJqF9eS1lHj3ttPXvNGwm5HSNFHUuJcPovu4WtP0ISbVqjnJo";
   $secretAPI = "jUvMBI2OMX1oR5PMiBSnTlKr65sYxipswJ9Qg0OPshctJM3Sstl5ZtIUM8hToAJ3";

   // BTCUSDT / Bitcoin
   // ETHUSDT / Ethereum
   $coins = ['BTCUSDT', 'ETHUSDT'];
   $api = new Binance\API($keyAPI,$secretAPI);

#================================================================================
   // $api = new Binance\RateLimiter($api);
   
   // $exchangeInfo = $api->exchangeInfo(); // Informacion Exchange Binance
   // echo json_encode($exchangeInfo);
   
   // $api->miniTicker(function($api, $ticker) {
      // print_r($ticker[0]);
   // });
#================================================================================

   $time=time();
   $price = $api->prices();  // Precios de los simbolos
   
   // echo "T Actual: ".$time;   
   // echo json_encode($price);

   // $json = ['time'=>$time];
   $json = [];
   $elCincoPorcen = 0;
   $i = 0;
   foreach ($coins as $co) {
      $priceCo = $price[$co];
      $elCincoPorcen = $priceCo/100*5;

      if($time>=$_SESSION['timeAct']){
         // $_SESSION['timeAct'] = $time+60;
         // $_SESSION['menor'] = $priceCo-5;
         $_SESSION['menor'.$co] = $priceCo-$elCincoPorcen;
         // $_SESSION['mayor'] = $priceCo+5;
         $_SESSION['mayor'.$co] = $priceCo+$elCincoPorcen;
         if($_SESSION['priceAnt'.$co]!=$priceCo){
            $_SESSION['priceAnt'.$co] = $priceCo;
         }
      }
      $menor = $_SESSION['menor'.$co];
      $mayor = $_SESSION['mayor'.$co];
      $anterior = $_SESSION['priceAnt'.$co];
      $cal = $priceCo-$anterior;
      $porcentaje = $cal/$anterior*100;
      
      // echo "<br><br>";
      // echo "Moneda: ".$co."<br>"; 
      // echo "Antes: ".$_SESSION['priceAnt'.$co]."<br>"; 
      // echo "Ahora: ".$priceCo."<br>"; 
      // echo "Porcentaje: ".$porcentaje."<br>";
      // echo "<br><br>";

      // $json += [$i=>['name'=>$co, $co=>$priceCo, '5porcen'=>$elCincoPorcen, 'menor'=>$menor, 'mayor'=>$mayor, 'anterior'=> $anterior, 'porcentaje'=>$porcentaje],];
      $json += [$i=>['name'=>$co, $co=>$priceCo,'anterior'=> $anterior, 'porcentaje'=>number_format($porcentaje,2,',','.')],];
      $i++;
   }
   if($time>=$_SESSION['timeAct']){
         $_SESSION['timeAct'] = $time+30;
   }
   
   // echo "<br>";
   // echo "T Esperado: ".$_SESSION['timeAct'];
   // echo "<br>";
   
   // print_r($json);
   if(file_exists('v1/data.json')){
      $file = 'v1/data.json';
      file_put_contents($file, json_encode($json));
   }
   echo json_encode($json);



   // echo "<br><br><br>Probando<br><br>";
   // $a = 5;
   // $n = 7;
   // $ne = $n-$a;

   // echo "Nuevo: ".$ne."<br>";

   // echo "result 1: ".($ne/$a*100)."<br>";
   // echo "result 2: ".($n*$a/100)."<br>";



?>
