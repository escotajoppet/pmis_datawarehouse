<?php
	// MS ACCESS DATABASE CONNECTION
	$access_conn = odbc_connect('MSAccessDatabase', 'admin', 'admin') or die('Error in ms access connection');
	$sql = 'SELECT * FROM `bpls_r_application`';
	$rs = odbc_exec($access_conn, $sql);
	odbc_close($access_conn);


	// MYSQL DATABASE CONNECTIOn
	$db_host = 'localhost';
	$db_username = 'root';
	$db_passwd = 'root';
	$db_name = 'datawarehouse_hris';

	$mysql_conn = mysql_connect("$db_host", "$db_username", "$db_passwd") or die('Error in mysql connection');
	$db = mysql_select_db("$db_name") or die('Database not found');

	echo "naknang patatas";
?>