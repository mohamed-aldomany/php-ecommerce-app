<?php
session_start();
if (isset($_SESSION['username'])) {
	
	include 'init.php';
	












		


}else{
	header('Location:index.php');
}




?>