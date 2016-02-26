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


	// dimension 1.1 (overtime)
	$hris_income_overtime = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income_overtime`";

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


	// dimension 1.2 (salary grade)
	$hris_income_salary_grade = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_income_salary_grade`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `salary_id`, `salary_name`, `basic_salary` FROM `tm_salary_grade`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 2.1 (leave)
	$hris_benefits_leave = array();
	$leave_type_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_leave`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `leave_id`, `leave_name`, `start_date`, `end_date`, `leave_type_id` FROM `py_leave`";

	if($result = mysqli_query($mysql_conn, $sql)){
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

	$cnt = 0;

	foreach($leave_type_ids as $id){
		$sql = "SELECT `leave_type_name`, `leave_type_convert` FROM `py_leave_type` WHERE `leave_type_id`='$id'";

		if($result = mysqli_query($mysql_conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_benefits_leave[$cnt]['leave_type'] = $row['leave_type_name'];
					$hris_benefits_leave[$cnt]['leave_type_convert'] = $row['leave_type_convert'];
				}
			}
		}

		$cnt += 1;
	}


	// dimension 2.2 (loan)
	$hris_benefits_loan = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_loan`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `loan_id`, `loan_name`, `loan_total` FROM `py_loan`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 2.3 (bonus)
	$hris_benefits_bonus = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_benefits_bonus`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `bonus_id`, `bonus_name`, `bonus_amount` FROM `py_bonus`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 3 (deductions)
	$hris_deductions = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `deduction_id`, `deduction_name`, `deduction_total_amount` FROM `py_deductions`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 3.1 (taxes)
	$hris_deductions_taxes = array();
	$tax_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions_tax`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `tax_range_id`, `sal_start`, `sal_end`, `percent`, `plus` FROM `py_tax_range`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 3.2 (loans)
	$hris_deductions_loans = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_deductions_loan`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `loan_id`, `loan_name`, `loan_total` FROM `py_loan`";

	if($result = mysqli_query($mysql_conn, $sql)){
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


	// dimension 4 (employees)
	$hris_employees = array();
	$employee_ids = array();
	$existing = array();

	$sql = "SELECT `id` FROM `hris_employees`";

	if($result = mysqli_query($mysql_conn_dw, $sql)){
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_array($result)){
				array_push($existing, $row['id']);
			}
		}
	}

	$sql = "SELECT `emp_id`, `contract_start`, `contract_end`, `emp_type_id` FROM `py_loan`";

	if($result = mysqli_query($mysql_conn, $sql)){
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

	$cnt = 0;

	foreach($employee_ids as $id){
		$sql = "SELECT `emp_type_name` FROM `tm_employee_type` WHERE `emp_type_id`='$id'";

		if($result = mysqli_query($mysql_conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$hris_deductions_taxes[$cnt]['employee_type'] = $row['emp_type_name'];
				}
			}
		}

		$cnt += 1;
	}


	mysqli_close($mysql_conn);



	// insert na ng values

	$db_name = 'datawarehouse';

	$mysql_conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);


	// Check connection
	if ($mysql_conn->connect_error) {
	    die("Connection failed: " . $mysql_conn->connect_error);
	}

	foreach ($hris_benefits as $benefit) {
		$sql = "INSERT INTO `hris_benefits` (`id`, `name`, `amount`) VALUES('" . $benefit['id'] . "', '" . $benefit['name'] . "', " . $benefit['amount'] . ")";

		echo "BENEFITS: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits success";
		} else{
			echo "benefits failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_benefits_bonus as $bonus) {
		$sql = "INSERT INTO `hris_benefits_bonus` (`id`, `name`, `amount`) VALUES('" . $bonus['id'] . "', '" . $bonus['name'] . "', " . $bonus['amount'] . ")";

		echo "BENEFITS BONUS: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits bonus success";
		} else{
			echo "benefits bonus failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_benefits_leave as $leave) {
		$sql = "INSERT INTO `hris_benefits_leave` (`id`, `start_date`, `end_date`, `leave_type`, `name`, `leave_type_convert`) VALUES('" . $leave['id'] . "', '" . $leave['start_date'] . "', '" . $leave['end_date'] . "', '" . $leave['leave_type'] . "', '" . $leave['name'] . "', '" . $leave['leave_type_convert'] . "')";

		echo "BENEFITS LEAVE: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits leave success";
		} else{
			echo "benefits leave failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_benefits_loan as $loan) {
		$sql = "INSERT INTO `hris_benefits_loan` (`id`, `name`, `total`) VALUES('" . $loan['id'] . "', '" . $loan['name'] . "', " . $loan['total'] . ")";

		echo "BENEFITS LOAN: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits loan success";
		} else{
			echo "benefits loan failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_deductions as $deduction) {
		$sql = "INSERT INTO `hris_benefits_deductions` (`id`, `name`, `amount`) VALUES('" . $deduction['id'] . "', '" . $deduction['name'] . "', " . $deduction['amount'] . ")";

		echo "DEDUCTIONS: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "deductions success";
		} else{
			echo "deductions failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_benefits_bonus as $bonus) {
		$sql = "INSERT INTO `hris_benefits_bonus` (`id`, `name`, `amount`) VALUES('" . $bonus['id'] . "', '" . $bonus['name'] . "', " . $bonus['amount'] . ")";

		echo "BENEFITS BONUS: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "benefits bonus success";
		} else{
			echo "benefits bonus failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_deductions_loans as $loan) {
		$sql = "INSERT INTO `hris_deductions_loan` (`id`, `name`, `total`) VALUES('" . $loan['id'] . "', '" . $loan['name'] . "', " . $loan['total'] . ")";

		echo "DEDUCTIONS LOAN: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "deductions loan success";
		} else{
			echo "deductions loan failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_deductions_taxes as $tax) {
		$sql = "INSERT INTO `hris_deductions_tax` (`id`, `civil_status`, `dependent_number`, `range_salary_start`, `range_salary_end`, `range_percent`, `range_plus`) VALUES('" . $tax['id'] . "', '" . $tax['civil_status'] . "', " . $tax['dependent_number'] . ", " . $tax['range_salary_start'] . ", " . $tax['range_salary_end'] . ", " . $tax['range_percent'] . ", " . $tax['range_plus'] . ")";

		echo "employees: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "deductions taxes success";
		} else{
			echo "deductions taxes failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_employees as $employee) {
		$sql = "INSERT INTO `hris_employees` (`id`, `start_contract`, `end_contract`, `employee_type`) VALUES('" . $employee['id'] . "', '" . $employee['start_contract'] . "', '" . $employee['end_contract'] . "', '" . $employee['employee_type'] . "')";

		echo "EMPLOYEES: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "employees success";
		} else{
			echo "employees failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_income as $income) {
		$sql = "INSERT INTO `hris_income` (`id`, `name`, `amount`) VALUES('" . $income['id'] . "', '" . $income['name'] . "', " . $income['amount'] . ")";

		echo "INCOME: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "income success";
		} else{
			echo "income failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_income_overtime as $overtime) {
		$sql = "INSERT INTO `hris_income_overtime` (`id`, `date_time`) VALUES('" . $overtime['id'] . "', '" . $overtime['date_time'] . ")";

		echo "INCOME OVERTIME: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "income overtime success";
		} else{
			echo "income overtime failed: " . mysqli_error($mysql_conn);
		}
	}

	foreach ($hris_income_salary_grade as $salary) {
		$sql = "INSERT INTO `hris_income_salary_grade` (`id`, `name`, `basic_salary`) VALUES('" . $salary['id'] . "', '" . $salary['name'] . "', " . $salary['basic_salary'] . ")";

		echo "INCOME BASIC SALARY: $sql\n\n";

		if(mysqli_query($mysql_conn, $sql)){
			echo "income basic salary success";
		} else{
			echo "income basic salary failed: " . mysqli_error($mysql_conn);
		}
	}

	mysqli_close($mysql_conn);
?>



<?php
	// MS ACCESS DATABASE CONNECTION
	// $access_conn = odbc_connect('datawarehouse_lgu', 'admin', 'admin') or die('Error in ms access connection');

	// $sql = 'SELECT * FROM `bpls_r_application`';
	// $rs = odbc_exec($access_conn, $sql);
	// odbc_close($access_conn);
?>