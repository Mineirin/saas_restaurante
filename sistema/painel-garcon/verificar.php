<?php 
@session_start();

if(@$_SESSION['nivel'] != 'Garçom'){
	echo "<script language='javascript'> window.location='../' </script>";

	exit();
}
 ?>
