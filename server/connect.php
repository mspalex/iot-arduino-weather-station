<?php

	session_start();

	if (!isset($_SESSION['dateOPR'])){
		$_SESSION['dateOPR']=0;
	}

	function Connection(){

		// your database server credentials
		//
		$server="*****";
		$user="*****";
		$pass="*****";
		$db="*****";

		$connection = mysql_connect($server, $user, $pass);

		if (!$connection) {
		    die('MySQL ERROR: ' . mysql_error());
		}

		mysql_select_db($db) or die( 'MySQL ERROR: '. mysql_error() );

		return $connection;
	}

?>
