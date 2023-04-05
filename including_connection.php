<?php

$host = 'localhost';
$host_username = 'root';
$host_password = '';
$host_db = 'rc_sales_i_db';


$link = mysqli_connect($host, $host_username, $host_password, $host_db);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_set_charset($link,"utf8");



/*$link = mysql_connect('localhost', 'csadmin', 'abcd1234');
mysql_set_charset('utf8', $link);
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}

mysql_select_db("remit_ams", $link);*/

?>