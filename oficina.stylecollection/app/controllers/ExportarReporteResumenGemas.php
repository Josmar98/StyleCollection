<?php 
	set_time_limit(320);
	
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer;
    use PhpOffice\PhpSpreadsheet\Reader;

    if(is_file('app/models/excel.php')){
      require_once'app/models/excel.php';
    }
    if(is_file('../app/models/excel.php')){
      require_once'../app/models/excel.php';
    }

	$file = "./config/temp/pagos.xlsx";

    $resumenCuentas=$_SESSION['resumenCuentas'];
    // print_r($resumenCuentas);
	// $filas = ['filI'=> '1', 'filF' => ''];
	$colum = ['colI'=> 'A', 'colF' => 'I'];
	$typeResponse = 1;

	$libro = new Excel($file, "Xlsx");
	$dat['resumenCuentas'] = $resumenCuentas;
    if(!empty($_GET['mes'])){
        $dat['mes']=$_GET['mes'];
    }
	// print_r($dat['movimientos']);
	$libro->exportarResumenGemas($dat, $lider);
?>