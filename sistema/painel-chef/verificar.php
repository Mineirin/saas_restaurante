<?php 
@session_start();

if(@$_SESSION['nivel'] != 'Chef'){
	echo "<script language='javascript'> window.location='../' </script>";

	exit();
}
 ?>
