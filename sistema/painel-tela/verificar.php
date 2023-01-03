<?php 
@session_start();

if(@$_SESSION['nivel'] != 'Tela' and @$_SESSION['nivel'] != 'tela' and @$_SESSION['nivel'] != 'Administrador'){
	echo "<script language='javascript'> window.location='../' </script>";

	exit();
}

 ?>
