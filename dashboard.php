<?php

session_start();
ob_start();
if (isset($_SESSION['username'])) {
	include 'init.php';	
	



	include $templates_path.'footer.php';
}else{
	header('Location:index.php');
}







ob_end_flush();
?>