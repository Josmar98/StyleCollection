<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Leer código de barras con JavaScript by parzibyte</title>
    <style type="text/css">
      #contenedor video{
        max-width: 100%;
        width: 100%;
      }
      #contenedor{
        max-width: 100%;
        position:relative;
      }
      canvas{
        max-width: 100%;
      }
      canvas.drawingBuffer{
        position:absolute;
        top:0;
        left:0;
      }
    </style>
  </head>
  <body>

    <div style="width:100%;text-align:center;">
		  Código: <span id="resultado">N/A</span>
      <br>
      <input type="text" name="barcode" style='width:80%;height:35px;border-radius:5px;border:1px solid #CCC;padding:3px 2px;' id="inputbarcode">
      <br>
      <button style="display:none;" id="volverEscanear">Escanear Código</button>
    </div>
		<!-- <p>A continuación, el contenedor: </p> -->
    <br>
    <br>

    <div style="width:100%;height:100vh;text-align:center;">
  		<div id="contenedor" style="width:85%;height:80vh;margin-left:7.5%;margin-right:7.5%;"></div>
    </div>
		<!-- Cargamos Quagga y luego nuestro script -->
		<script src="https://unpkg.com/quagga@0.12.1/dist/quagga.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
//  document.addEventListener("DOMContentLoaded", () => {
//   const $resultados = document.querySelector("#resultado");
//   Quagga.init({
//     inputStream: {
//       constraints: {
//         width: 1920,
//         height: 1080,
//       },
//       name: "Live",
//       type: "LiveStream",
//       target: document.querySelector('#contenedor'), // Pasar el elemento del DOM
//     },
//     decoder: {
//       readers: ["ean_reader"]
//     }
//   }, function (err) {
//     if (err) {
//       console.log(err);
//       return
//     }
//     console.log("Iniciado correctamente");
//     Quagga.start();
//   });

//   Quagga.onDetected((data) => {
//     $resultados.textContent = data.codeResult.code;
//     // Imprimimos todo el data para que puedas depurar
//     console.log(data);
//   });
// }); 
document.addEventListener("DOMContentLoaded", () => {
  const $resultados = document.querySelector("#resultado");
  // 1920 , 1080
  Quagga.init({
    inputStream: {
      constraints: {
        width: 1280,
        height: 720,
      },
      name: "Live",
      type: "LiveStream",
      target: document.querySelector('#contenedor'), // Pasar el elemento del DOM
    },
    decoder: {
      readers: ["ean_reader"]
    }
  }, function (err) {
    if (err) {
      console.log(err);
      return
    }
    console.log("Iniciado correctamente");
    Quagga.start();
  });

  Quagga.onDetected((data) => {
    // $resultados.textContent = data.codeResult.code;
    $("#resultado").val(data.codeResult.code);
    $("#inputbarcode").val(data.codeResult.code);
    $("#volverEscanear").show();
    Quagga.pause();


    // Imprimimos todo el data para que puedas depurar
    console.log(data);
  });

  Quagga.onProcessed(function (result) {
    var drawingCtx = Quagga.canvas.ctx.overlay,
      drawingCanvas = Quagga.canvas.dom.overlay;

    if (result) {
      if (result.boxes) {
        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
        result.boxes.filter(function (box) {
          return box !== result.box;
        }).forEach(function (box) {
          Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
        });
      }

      if (result.box) {
        Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
      }

      if (result.codeResult && result.codeResult.code) {
        Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
      }
    }
  });
});

$("#volverEscanear").click(function(){
  $("#resultado").html("N/A");
  $("#inputbarcode").val("");
  $("#volverEscanear").hide();
  Quagga.start();
});
</script>
  </body>
</html>