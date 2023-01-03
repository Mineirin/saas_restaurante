<?php 
@session_start();

if(@$_SESSION['nivel'] != 'Administrador'){
	echo "<script language='javascript'> window.location='../' </script>";

	exit();
}
 ?>
