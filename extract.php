<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Warehouse | EXTRACT</title>
</head>
<body>
	<h4>Data Warehouse | EXTRACT</h4>

	<?php
		// HRIS DATABASE CONNECTION
		$hris_csvs = "./hris-csv";

		$db_host = 'localhost';
		$db_username = 'root';
		$db_passwd = 'root';

		$db_name = 'datawarehouse_hris';

		$conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

		$db_name = 'datawarehouse';

		$conn_dw = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		// HRIS CUBE!!!

		$hris_payroll = array();
		$existing = array();
		$tax_range_ids = array();
		$tax_ids = array();

		$sql = "SELECT `id` FROM `hris_payroll`";

		if($result = mysqli_query($conn_dw, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					array_push($existing, $row['id']);
				}
			}
		}

		$file = fopen("$hris_csvs/payroll.csv", "r");

		$peyrol = array(
				'table_name' => '',
				'fields' => array()
			);

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt <= 1){
				if($line[0] === 'table_name'){
					$peyrol['table_name'] = "`" . $line[1] . "`";
				} else{
					for($i = 1; $i < count($line); $i++){
						array_push($peyrol['fields'], "`" . $line[$i] . "`");
					}
				}
			}			

			$cnt += 1;
		}

		$sql = sqlSelect($peyrol, '1');

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					if(!in_array($row['py_id'], $existing)){
						array_push($hris_payroll, [
								'id' => $row['py_id'],
								'basic_salary' => $row['current_basic_salary'],
								'date' => $row['pay_date']
							]);

						array_push($tax_range_ids, $row['tax_range_id']);
					}
				}
			}
		}

		fclose($file);

		$peyrol = array(
				'table_name' => '',
				'fields' => array()
			);

		$file = fopen("$hris_csvs/payroll.csv", "r");

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt >= 2 && $cnt <= 3){
				if($line[0] === 'table_name'){
					$peyrol['table_name'] = "`" . $line[1] . "`";
				} else{
					for ($i = 1; $i < count($line); $i++) { 
						array_push($peyrol['fields'], "`" . $line[$i] . "`");
					}
				}
			}

			$cnt += 1;
		}

		$cnt = 0;

		foreach($tax_range_ids as $id){
			$sql = sqlSelect($peyrol, "`tax_range_id`='$id'");

			if($result = mysqli_query($conn, $sql)){
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
						$hris_payroll[$cnt]['percent'] = $row['percent'];

						array_push($tax_ids, $row['tax_id']);
					}
				}
			}

			$cnt += 1;
		}

		fclose($file);

		$peyrol = array(
				'table_name' => '',
				'fields' => array()
			);

		$file = fopen("$hris_csvs/payroll.csv", "r");

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt >= 4){
				if($line[0] === 'table_name'){
					$peyrol['table_name'] = "`" . $line[1] . "`";
				} else{
					for ($i = 1; $i < count($line); $i++) { 
						array_push($peyrol['fields'], "`" . $line[$i] . "`");
					}
				}
			}

			$cnt += 1;
		}

		$cnt = 0;

		foreach($tax_ids as $id){
			$sql = sqlSelect($peyrol, "`tax_id`='$id'");

			if($result = mysqli_query($conn, $sql)){
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
						$hris_payroll[$cnt]['civil_status'] = $row['civil_status'];
						$hris_payroll[$cnt]['dependent_number'] = $row['dependent_number'];
					}
				}
			}

			$cnt += 1;
		}

		fclose($file);


		//////////////////// PAYROLL DEDUCTIONS
		$hris_payroll_deduction = array();
		$existing = array();
		$deduction_ids = array();

		$sql = "SELECT `id` FROM `hris_payroll_deduction`";

		if($result = mysqli_query($conn_dw, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					array_push($existing, $row['id']);
				}
			}
		}

		$file = fopen("$hris_csvs/payroll_deduction.csv", "r");

		$peyrol_dedaksyon = array(
				'table_name' => '',
				'fields' => array()
			);

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt <= 1){
				if($line[0] === 'table_name'){
					$peyrol_dedaksyon['table_name'] = "`" . $line[1] . "`";
				} else{
					for($i = 1; $i < count($line); $i++){
						array_push($peyrol_dedaksyon['fields'], "`" . $line[$i] . "`");
					}
				}				
			}

			$cnt += 1;
		}

		$sql = sqlSelect($peyrol_dedaksyon, '1');

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					if(!in_array($row['py_deduction_id'], $existing)){
						array_push($hris_payroll_deduction, [
								'id' => $row['py_deduction_id'],
								'payroll_id' => $row['py_id'],
							]);

						array_push($deduction_ids, $row['deduction_id']);
					}
				}
			}
		}

		fclose($file);

		$peyrol_dedaksyon = array(
				'table_name' => '',
				'fields' => array()
			);

		$file = fopen("$hris_csvs/payroll_deduction.csv", "r");

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt >= 2){
				if($line[0] === 'table_name'){
					$peyrol_dedaksyon['table_name'] = "`" . $line[1] . "`";
				} else{
					for ($i = 1; $i < count($line); $i++) { 
						array_push($peyrol_dedaksyon['fields'], "`" . $line[$i] . "`");
					}
				}
			}

			$cnt += 1;
		}

		$cnt = 0;

		foreach($deduction_ids as $id){
			$sql = sqlSelect($peyrol_dedaksyon, "`deduction_id`='$id'");

			if($result = mysqli_query($conn, $sql)){
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
						$hris_payroll_deduction[$cnt]['deduction_amount_total'] = $row['deduction_amount_total'];
					}
				}
			}

			$cnt += 1;
		}

		fclose($file);



		//////////////////// PAYROLL BONUS
		$hris_payroll_bonus = array();
		$existing = array();
		$bonus_ids = array();

		$sql = "SELECT `id` FROM `hris_payroll_bonus`";

		if($result = mysqli_query($conn_dw, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					array_push($existing, $row['id']);
				}
			}
		}

		$file = fopen("$hris_csvs/payroll_bonus.csv", "r");

		$peyrol_bownus = array(
				'table_name' => '',
				'fields' => array()
			);

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt <= 1){
				if($line[0] === 'table_name'){
					$peyrol_bownus['table_name'] = "`" . $line[1] . "`";
				} else{
					for($i = 1; $i < count($line); $i++){
						array_push($peyrol_bownus['fields'], "`" . $line[$i] . "`");
					}
				}				
			}

			$cnt += 1;
		}

		$sql = sqlSelect($peyrol_bownus, '1');

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					if(!in_array($row['py_bonus_id'], $existing)){
						array_push($hris_payroll_bonus, [
								'id' => $row['py_bonus_id'],
								'payroll_id' => $row['py_id'],
							]);

						array_push($bonus_ids, $row['bonus_id']);
					}
				}
			}
		}

		fclose($file);

		$peyrol_bownus = array(
				'table_name' => '',
				'fields' => array()
			);

		$file = fopen("$hris_csvs/payroll_bonus.csv", "r");

		$cnt = 0;

		while(!feof($file)){
			$line = fgetcsv($file);

			if($cnt >= 2){
				if($line[0] === 'table_name'){
					$peyrol_bownus['table_name'] = "`" . $line[1] . "`";
				} else{
					for ($i = 1; $i < count($line); $i++) { 
						array_push($peyrol_bownus['fields'], "`" . $line[$i] . "`");
					}
				}
			}

			$cnt += 1;
		}

		$cnt = 0;

		foreach($bonus_ids as $id){
			$sql = sqlSelect($peyrol_bownus, "`bonus_id`='$id'");

			if($result = mysqli_query($conn, $sql)){
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_array($result)){
						$hris_payroll_bonus[$cnt]['bonus_amount'] = $row['bonus_amount'];
					}
				}
			}

			$cnt += 1;
		}

		fclose($file);

		session_start();

		$_SESSION['hris_payroll'] = $hris_payroll;
		$_SESSION['hris_payroll_deduction'] = $hris_payroll_deduction;
		$_SESSION['hris_payroll_bonus'] = $hris_payroll_bonus;

		echo "Data EXTRACTION Successful!";
	?>

	<?php
		function sqlSelect($dimension, $condition){
			return "SELECT " . join($dimension['fields'], ', ') . " FROM " . $dimension['table_name'] . " WHERE $condition";
		}
	?>

	<div>
		<button type="button" onclick="window.location.href='/pmis/datawarehouse/transform.php'" style="margin-top:15px;">TRANSFORM DATA</button>
	</div>
</body>
</html>