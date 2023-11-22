<?php 
	// set_time_limit(320);
	session_start();
	ini_set('date.timezone', 'america/caracas');
	// ini_set('date.timezone', 'europe/madrid');
	require_once 'sources/control/App.php';
	$app = new App();
	if(isset($_GET['admin'])){
		require_once'sources/view/admin.php';
	}else {
		$app->run();
		// echo "<script>location.href=''</script>";
	}
?>