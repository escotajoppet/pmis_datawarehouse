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

	$datum = array();

	/////////////////////////////////////////////////////////
	// dimension 1 (income)
	$hris_income = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}
	
	$file = fopen("$hris_csvs/income.csv", "r");

	$inkam = array(
			'table_name' => '',
			'fields' => array()
		);
	
	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$inkam['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($inkam['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($inkam, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['income_id'], $existing)){
					array_push($hris_income, [
						'id' => $row['income_id'],
						'name' => $row['income_name'],
						'amount' => $row['income_amount']
					]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 1.1 (overtime)
	$hris_income_overtime = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income_overtime`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/income_overtime.csv", "r");

	$obertaym = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$obertaym['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 0; $i < count($line); $i++) {
				array_push($obertaym['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($obertaym, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['overtime_id'], $existing)){
					array_push($hris_income_overtime, [
							'id' => $row['overtime_id'],
							'date_time' => $row['overtime_dates']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 1.2 (salary grade)
	$hris_income_salary_grade = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income_salary_grade`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/income_salary_grade.csv", "r");

	$salari = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$salari['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($salari['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($salari, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['salary_id'], $existing)){
					array_push($hris_income_salary_grade, [
							'id' => $row['salary_id'],
							'name' => $row['salary_name'],
							'basic_salary' => $row['basic_salary']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 2 (benefits)
	$hris_benefits = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/benefits.csv", "r");

	$benepits = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$benepits['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 0; $i < count($line); $i++) {
				array_push($benepits['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($benepits, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['benefits_id'], $existing)){
					array_push($hris_benefits, [
							'id' => $row['benefits_id'],
							'name' => $row['benefits_name'],
							'amount' => $row['benefits_amount']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 2.1 (leave)
	$hris_benefits_leave = array();
	$leave_type_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_leave`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/benefits_leave.csv", "r");

	$lib = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt < 2){
			if($line[0] === 'table_name'){
				$lib['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($lib['fields'], "`" . $line[$i] . "`");
				}
			}
		}		

		$cnt += 1;
	}

	$sql = sqlSelect($lib, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['leave_id'], $existing)){
					array_push($hris_benefits_leave, [
							'id' => $row['leave_id'],
							'name' => $row['leave_name'],
							'start_date' => $row['start_date'],
							'end_date' => $row['end_date']
						]);

					array_push($leave_type_ids, $row['leave_type_id']);
				}
			}
		}
	}

	$lib = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt >= 2){
			if($line[0] === 'table_name'){
				$lib['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($lib['fields'], "`" . $line[$i] . "`");
				}
			}
		}		

		$cnt += 1;
	}

	$cnt = 0;

	foreach($leave_type_ids as $id){
		$sql = sqlSelect($lib, "`leave_type_id`='$id'");

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_benefits_leave[$cnt]['leave_type'] = $row['leave_type_name'];
					$hris_benefits_leave[$cnt]['leave_type_convert'] = $row['leave_type_convert'];
				}
			}
		}

		$cnt += 1;
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 2.2 (loan)
	$hris_benefits_loan = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_loan`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/benefits_loan.csv", "r");

	$lown = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$lown['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($lown['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($lown, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['loan_id'], $existing)){
					array_push($hris_benefits_loan, [
							'id' => $row['loan_id'],
							'name' => $row['loan_name'],
							'total' => $row['loan_total']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 2.3 (bonus)
	$hris_benefits_bonus = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_bonus`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/benefits_bonus.csv", "r");

	$bownus = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$bownus['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($bownus['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($bownus, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['bonus_id'], $existing)){
					array_push($hris_benefits_bonus, [
							'id' => $row['bonus_id'],
							'name' => $row['bonus_name'],
							'amount' => $row['bonus_amount']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 3 (deductions)
	$hris_deductions = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/deductions.csv", "r");

	$dedaksyons = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$dedaksyons['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($dedaksyons['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($dedaksyons, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['deduction_id'], $existing)){
					array_push($hris_deductions, [
							'id' => $row['deduction_id'],
							'name' => $row['deduction_name'],
							'total_amount' => $row['deduction_total_amount']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 3.1 (taxes)
	$hris_deductions_taxes = array();
	$tax_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions_tax`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/deductions_tax.csv", "r");

	$takses = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt < 2){
			if($line[0] === 'table_name'){
				$takses['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($takses['fields'], "`" . $line[$i] . "`");
				}
			}			
		}

		$cnt += 1;
	}

	$sql = sqlSelect($takses, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['tax_range_id'], $existing)){
					array_push($hris_deductions_taxes, [
							'id' => $row['tax_range_id'],
							'range_salary_start' => $row['sal_start'],
							'range_salary_end' => $row['sal_end'],
							'range_percent' => $row['percent'],
							'range_plus' => $row['plus']
						]);

					array_push($tax_ids, $row['tax_range_id']);
				}
			}
		}
	}

	$takses = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt >= 2){
			if($line[0] === 'table_name'){
				$takses['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($takses['fields'], "`" . $line[$i] . "`");
				}
			}
		}

		$cnt += 1;
	}

	$cnt = 0;

	foreach($tax_ids as $id){
		$sql = sqlSelect($takses, "`tax_id`='$id'");

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_deductions_taxes[$cnt]['civil_status'] = $row['civil_status'];
					$hris_deductions_taxes[$cnt]['dependent_number'] = $row['dependent_number'];
				}
			}
		}

		$cnt += 1;
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 3.2 (loans)
	$hris_deductions_loans = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions_loan`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/deductions_loan.csv", "r");

	$lown = array(
			'table_name' => '',
			'fields' => array()
		);

	while(!feof($file)){
		$line = fgetcsv($file);

		if($line[0] === 'table_name'){
			$lown['table_name'] = "`" . $line[1] . "`";
		} else{
			for ($i = 1; $i < count($line); $i++) { 
				array_push($lown['fields'], "`" . $line[$i] . "`");
			}
		}
	}

	$sql = sqlSelect($lown, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['loan_id'], $existing)){
					array_push($hris_deductions_loans, [
							'id' => $row['loan_id'],
							'name' => $row['loan_name'],
							'total' => $row['loan_total']
						]);
				}
			}
		}
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	/////////////////////////////////////////////////////////
	// dimension 4 (employees)
	$hris_employees = array();
	$employee_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_employees`";

	if($result = mysqli_query($conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$file = fopen("$hris_csvs/employees.csv", "r");

	$employis = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt < 2){
			if($line[0] === 'table_name'){
				$employis['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($employis['fields'], "`" . $line[$i] . "`");
				}
			}
		}

		$cnt += 1;
	}

	$sql = sqlSelect($employis, '1');

	if($result = mysqli_query($conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				if(!in_array($row['emp_id'], $existing)){
					array_push($hris_deductions_loans, [
							'id' => $row['emp_id'],
							'contract_start' => $row['contract_start'],
							'contract_end' => $row['contract_end']
						]);

					array_push($employee_ids, $row['emp_id']);
				}
			}
		}
	}

	$employis = array(
			'table_name' => '',
			'fields' => array()
		);

	$cnt = 0;

	while(!feof($file)){
		$line = fgetcsv($file);

		if($cnt >= 2){
			if($line[0] === 'table_name'){
				$inkam['table_name'] = "`" . $line[1] . "`";
			} else{
				for ($i = 1; $i < count($line); $i++) { 
					array_push($inkam['fields'], "`" . $line[$i] . "`");
				}
			}
		}

		$cnt += 1;
	}

	$cnt = 0;

	foreach($employee_ids as $id){
		$sql = sqlSelect($employis, "`emp_type_id`='$id'");

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_deductions_taxes[$cnt]['employee_type'] = $row['emp_type_name'];
				}
			}
		}

		$cnt += 1;
	}

	fclose($file);
	/////////////////////////////////////////////////////////


	mysqli_close($conn);

	// save sa session lahat ng na extract na data

	session_start();

	$_SESSION['hris_benefits'] = $hris_benefits;
	$_SESSION['hris_benefits_bonus'] = $hris_benefits_bonus;
	$_SESSION['hris_benefits_leave'] = $hris_benefits_leave;
	$_SESSION['hris_benefits_loan'] = $hris_benefits_loan;
	$_SESSION['hris_deductions'] = $hris_deductions;
	$_SESSION['hris_benefits_bonus'] = $hris_benefits_bonus;
	$_SESSION['hris_deductions_loans'] = $hris_deductions_loans;
	$_SESSION['hris_deductions_taxes'] = $hris_deductions_taxes;
	$_SESSION['hris_employees'] = $hris_employees;
	$_SESSION['hris_income'] = $hris_income;
	$_SESSION['hris_income_overtime'] = $hris_income_overtime;
	$_SESSION['hris_income_salary_grade'] = $hris_income_salary_grade;

	// end extraction

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