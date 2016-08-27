<?php

  include("../includes/connect.php");

  $link = Connection();

  $query = "SELECT `timeStamp`, MAX(`temperature`) as temperature, `humidity`
    FROM `tempLog`
    group by DATE(`timeStamp`)";

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
