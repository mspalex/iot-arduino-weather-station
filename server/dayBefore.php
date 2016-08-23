<?php

	session_start();
	$_SESSION['dateOPR']=$_SESSION['dateOPR']-1;
	header("Location: index.php");

?>
