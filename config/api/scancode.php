<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Dynamsoft JavaScript Barcode Scanner</title>
        <script src="https://cdn.jsdelivr.net/npm/dynamsoft-javascript-barcode@9.0.0/dist/dbr.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
<body>
    <div style="width:100%;text-align:center;">
        Codigo de Barra: <a id='result'>N/A</a>
        <br>
        <input type="text" name="barcode" style='width:80%;height:35px;border-radius:5px;border:1px solid #CCC;padding:3px 2px;' id="inputbarcode">
    </div>
    <br>
    <br>
    <button style="display:none;" id="volverEscanear" value="0">Escanear Código</button>
    <div id="barcodeScanner" style="height:;width:;">
        <span id='loading-status' style='font-size:x-large;'>Cargando Scaner...</span>
    </div>
    <script>
        window.onload = async function () {
            try {
                Dynamsoft.DBR.BarcodeReader.license = "DLS2eyJoYW5kc2hha2VDb2RlIjoiMjAwMDAxLTE2NDk4Mjk3OTI2MzUiLCJvcmdhbml6YXRpb25JRCI6IjIwMDAwMSIsInNlc3Npb25QYXNzd29yZCI6IndTcGR6Vm05WDJrcEQ5YUoifQ==";
                // await Dynamsoft.DBR.BarcodeScanner.loadWasm();
                await initBarcodeScanner();
            } catch (ex) {
                alert(ex.message);
                throw ex;
            }
        };
        let scanner = null;
        async function initBarcodeScanner() {
            scanner = await Dynamsoft.DBR.BarcodeScanner.createInstance();

            // scanner.onFrameRead = results => {console.log(results);};
            scanner.onFrameRead = results => {
                console.log(results);
                for (let result of results) {
                    if(result.barcodeText!=""){
                        var html = result.barcodeFormatString + ", " + result.barcodeText;
                        var textbar = result.barcodeText;
                        $("#result").html(html);
                        $("#inputbarcode").val(textbar);
                        $("#volverEscanear").show();
                        $(".dce-btn-close").click();
                    }
                    // document.getElementById('result').innerHTML = result.barcodeFormatString + ", " + result.barcodeText;
                    // document.getElementById('inputbarcode').value = result.barcodeText;
                }
            };

            scanner.onUnduplicatedRead = (txt, result) => {};
            document.getElementById('barcodeScanner').appendChild(scanner.getUIElement());
            document.getElementById('loading-status').hidden = true;

            // $(".dce-sel-camera").hide();
            // $(".dce-sel-resolution").hide();
            $(".dce-btn-close").hide();
            
            await scanner.show();
        }
        $("#volverEscanear").click(function(){
            window.location.reload();
        });
    </script>

<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #barcodeScanner {
        text-align: center;
        font-size: medium;
        height: 75vh;
        width: 85vw;
    }
</style>
</body>
</html>