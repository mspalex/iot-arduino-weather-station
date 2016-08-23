<?php

	include("connect.php");

	$link=Connection();

	$result=mysql_query("SELECT `timeStamp`, `temperature`, `humidity`
		FROM `tempLog`
		WHERE DATE(`timeStamp`) = CURDATE() + '" . $_SESSION['dateOPR'] . "' order by `timeStamp` ASC",$link);

	if ( ! $result ) {
		echo mysql_error();
		die;
	}

	mysql_close($link);

	$data = array();

	for ($x = 0; $x < mysql_num_rows($result); $x++) {
		$data[] = mysql_fetch_assoc($result);
	}

?>
