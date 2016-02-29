<?php
	// LGU DATABASE CONNECTION
	$conn = odbc_connect('datawarehouse_lgu', 'admin', 'admin') or die('Error in ms access connection');

	$db_host = 'localhost';
	$db_username = 'root';
	$db_passwd = 'root';
	$db_name = 'datawarehouse';
	
	$conn_dw = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

	// LGU CUBES!!!

	// dimension 1 (vehicles)
	$lgu_vehicles = array();
	$existing = array();

	$sql = 'SELECT * FROM `lgu_vehicles`';
	$rs = odbc_exec($conn, $sql);
	odbc_close($conn);
?>