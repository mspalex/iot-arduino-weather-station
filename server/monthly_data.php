<?php

  include("connect.php");
  $link=Connection();

  $result=mysql_query("
  SELECT `timeStamp`, MAX(`temperature`) as temperature, `humidity`
  FROM `tempLog`
  group by DATE(`timeStamp`)",$link);

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
