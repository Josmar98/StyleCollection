<?php 
	session_start();
	ini_set('date.timezone', 'america/caracas');
	require_once 'sources/control/App.php';
	$app = new App();
	if(isset($_GET['admin'])){
		require_once'sources/view/admin.php';
	}else {
		$app->run(1);
		// echo "<script>location.href=''</script>";
		// header("refresh:1,url=./");
	}
?>