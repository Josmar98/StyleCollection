<?php

// print_r($_GET['factura']);
if(!empty($_GET['type'])){
	// echo "SI hay factura";
	if($_GET['type']=="SP1" || $_GET['type']=="SP2"){
		require_once 'GenerarFacturaPDFSP.php';
	}
	if($_GET['type']=="CP1" || $_GET['type']=="CP2"){
		require_once 'GenerarFacturaPDFCP.php';
	}
}else{
	require_once 'GenerarNotaPDF.php';
}


?>