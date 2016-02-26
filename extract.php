<?php
	// MYSQL DATABASE CONNECTION
	$db_host = 'localhost';
	$db_username = 'root';
	$db_passwd = 'root';

	$db_name = 'datawarehouse_hris';

	$mysql_conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

	$db_name = 'datawarehouse';

	$mysql_conn_dw = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

	// Check connection
	if ($mysql_conn->connect_error) {
	    die("Connection failed: " . $mysql_conn->connect_error);
	}

	// CUBES!!!

	// dimension 1 (income)
	$hris_income = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `income_id`, `income_name`, `income_amount` FROM `py_income`";
	
	if($result = mysqli_query($mysql_conn, $sql)){
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

	// echo 'income: ';
	// var_dump($hris_income);


	// dimension 1.1 (overtime)
	$hris_income_overtime = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_overtime`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `overtime_id`, `overtime_dates` FROM `py_overtime_dates`";

	if($result = mysqli_query($mysql_conn, $sql)){
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

	//////////////////////////////////////////////////

	// echo 'overtime: ';
	// var_dump($hris_income_overtime);


	// dimension 1.2 (salary grade)
	$hris_income_salary_grade = array();

	$sql = "SELECT `salary_id`, `salary_name`, `basic_salary` FROM `tm_salary_grade`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_income_salary_grade, [
						'id' => $row['salary_id'],
						'name' => $row['salary_name'],
						'basic_salary' => $row['basic_salary']
					]);
			}
		}
	}

	// echo 'salary grade:';
	// var_dump($hris_income_salary_grade);


	// dimension 2 (benefits)
	$hris_benefits = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `benefits_id`, `benefits_name`, `benefits_amount` FROM `tm_benefits`";

	if($result = mysqli_query($mysql_conn, $sql)){
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

	// echo 'benefits: ';
	// var_dump($hris_benefits);


	// dimension 2.1 (leave)
	$hris_benefits_leave = array();
	$leave_type_ids = array();

	$sql = "SELECT `leave_id`, `leave_name`, `start_date`, `end_date`, `leave_type_id` FROM `py_leave`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_benefits_leave, [
						'id' => $row['leave_id'],
						'name' => $row['leave_name'],
						'sdate' => $row['start_date'],
						'edate' => $row['end_date']
					]);

				array_push($leave_type_ids, $row['leave_type_id']);
			}
		}
	}

	$cnt = 0;

	foreach($leave_type_ids as $id){
		$sql = "SELECT `leave_type_name`, `leave_type_convert` FROM `py_leave_type` WHERE `leave_type_id`='$id'";

		if($result = mysqli_query($mysql_conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_benefits_leave[$cnt]['leave_type_name'] = $row['leave_type_name'];
					$hris_benefits_leave[$cnt]['leave_type_convert'] = $row['leave_type_convert'];
				}
			}
		}

		$cnt += 1;
	}

	// echo 'leave: ';
	// var_dump($hris_benefits_leave);


	// dimension 2.2 (loan)
	$hris_benefits_loan = array();

	$sql = "SELECT `loan_id`, `loan_name`, `loan_total` FROM `py_loan`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_benefits_loan, [
						'id' => $row['loan_id'],
						'name' => $row['loan_name'],
						'total' => $row['loan_total']
					]);
			}
		}
	}

	// echo 'loan: ';
	// var_dump($hris_benefits_loan);


	// dimension 2.3 (bonus)
	$hris_benefits_bonus = array();

	$sql = "SELECT `bonus_id`, `bonus_name`, `bonus_amount` FROM `py_bonus`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_benefits_bonus, [
						'id' => $row['bonus_id'],
						'name' => $row['bonus_name'],
						'amount' => $row['bonus_amount']
					]);
			}
		}
	}

	// echo 'bonus: ';
	// var_dump($hris_benefits_bonus);


	// dimension 3 (deductions)
	$hris_deductions = array();

	$sql = "SELECT `deduction_id`, `deduction_name`, `deduction_total_amount` FROM `py_deductions`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_deductions, [
						'id' => $row['deduction_id'],
						'name' => $row['deduction_name'],
						'total_amount' => $row['deduction_total_amount']
					]);
			}
		}
	}

	// echo 'deductions: ';
	// var_dump($hris_deductions);


	// dimension 3 (taxes)
	$hris_deductions_taxes = array();
	$tax_ids = array();

	$sql = "SELECT `tax_range_id`, `sal_start`, `sal_end`, `percent`, `plus` FROM `py_tax_range`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_deductions_taxes, [
						'id' => $row['tax_range_id'],
						'salary_start' => $row['sal_start'],
						'salary_end' => $row['sal_end'],
						'percent' => $row['percent'],
						'plus' => $row['plus']
					]);

				array_push($tax_ids, $row['tax_range_id']);
			}
		}
	}

	$cnt = 0;

	foreach($tax_ids as $id){
		$sql = "SELECT `civil_status`, `dependent_number` FROM `py_tax` WHERE `tax_id`='$id'";

		if($result = mysqli_query($mysql_conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_deductions_taxes[$cnt]['civil_status'] = $row['civil_status'];
					$hris_deductions_taxes[$cnt]['dependent_number'] = $row['dependent_number'];
				}
			}
		}

		$cnt += 1;
	}


	// echo 'taxes: ';
	// var_dump($hris_deductions_taxes);


	// dimension 3 (loans)
	$hris_deductions_loan = array();

	$sql = "SELECT `loan_id`, `loan_name`, `loan_total` FROM `py_loan`";

	if($result = mysqli_query($mysql_conn, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($hris_deductions_loan, [
						'id' => $row['loan_id'],
						'name' => $row['loan_name'],
						'total' => $row['loan_total']
					]);
			}
		}
	}

	// echo 'loan: ';
	// var_dump($hris_deductions_loan);

	mysqli_close($mysql_conn);

	$db_name = 'datawarehouse';

	$mysql_conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);


	// Check connection
	if ($mysql_conn->connect_error) {
	    die("Connection failed: " . $mysql_conn->connect_error);
	}

	foreach ($hris_benefits as $benefit) {
		$sql = "INSERT INTO `hris_benefits` (`id`, `name`, `amount`) VALUES('" . $benefit['id'] . "', '" . $benefit['name'] . "', " . $benefit['amount'] . ")";

		echo "===>$sql";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits success";
		} else{
			echo "benefits failed: " . mysqli_error($mysql_conn);
		}
	}

	mysqli_close($mysql_conn);

	// $hris_income;
	// $hris_income_overtime;
	// $hris_income_salary_grade;
	// $hris_benefits_leave;
	// $hris_benefits_loan;
	// $hris_benefits_bonus;
	// $hris_deductions;
	// $hris_deductions_taxes;
	// $hris_deductions_loan;
?>



<?php
	// MS ACCESS DATABASE CONNECTION
	$access_conn = odbc_connect('datawarehouse_lgu', 'admin', 'admin') or die('Error in ms access connection');

	$sql = 'SELECT * FROM `bpls_r_application`';
	$rs = odbc_exec($access_conn, $sql);
	odbc_close($access_conn);
?>