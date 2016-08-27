<?php

	include("includes/connect.php");

	$link = Connection();

	$query = "SELECT `timeStamp`, `temperature`, `humidity`
		FROM `tempLog`
		WHERE DATE(`timeStamp`) = CURDATE() + '" . $_SESSION['dateOPR'] . "' order by `timeStamp` ASC";

	$result = mysqli_query($link, $query);

	if ( ! $result ) {
		echo mysqli_error($link);
		die;
	}

	mysqli_close($link);

	$data = array();

	for ($x = 0; $x < mysqli_num_rows($result); $x++) {
		$data[] = mysqli_fetch_assoc($result);
	}

?>
