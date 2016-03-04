<?php
	// HRIS DATABASE CONNECTION
	$db_host = 'localhost';
	$db_username = 'root';
	$db_passwd = 'root';
	$db_name = 'datawarehouse';

	$conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);


	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	session_start();

	foreach ($_SESSION['hris_benefits'] as $benefit) {
		$sql = "INSERT INTO `hris_benefits` (`id`, `name`, `amount`) VALUES('" . $benefit['id'] . "', '" . $benefit['name'] . "', " . $benefit['amount'] . ")";

		echo "BENEFITS: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "benefits success";
		} else{
			echo "benefits failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_benefits_bonus'] as $bonus) {
		$sql = "INSERT INTO `hris_benefits_bonus` (`id`, `name`, `amount`) VALUES('" . $bonus['id'] . "', '" . $bonus['name'] . "', " . $bonus['amount'] . ")";

		echo "BENEFITS BONUS: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "benefits bonus success";
		} else{
			echo "benefits bonus failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_benefits_leave'] as $leave) {
		$sql = "INSERT INTO `hris_benefits_leave` (`id`, `start_date`, `end_date`, `leave_type`, `name`, `leave_type_convert`) VALUES('" . $leave['id'] . "', '" . $leave['start_date'] . "', '" . $leave['end_date'] . "', '" . $leave['leave_type'] . "', '" . $leave['name'] . "', '" . $leave['leave_type_convert'] . "')";

		echo "BENEFITS LEAVE: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "benefits leave success";
		} else{
			echo "benefits leave failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_benefits_loan'] as $loan) {
		$sql = "INSERT INTO `hris_benefits_loan` (`id`, `name`, `total`) VALUES('" . $loan['id'] . "', '" . $loan['name'] . "', " . $loan['total'] . ")";

		echo "BENEFITS LOAN: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "benefits loan success";
		} else{
			echo "benefits loan failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_deductions'] as $deduction) {
		$sql = "INSERT INTO `hris_benefits_deductions` (`id`, `name`, `amount`) VALUES('" . $deduction['id'] . "', '" . $deduction['name'] . "', " . $deduction['amount'] . ")";

		echo "DEDUCTIONS: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "deductions success";
		} else{
			echo "deductions failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_benefits_bonus'] as $bonus) {
		$sql = "INSERT INTO `hris_benefits_bonus` (`id`, `name`, `amount`) VALUES('" . $bonus['id'] . "', '" . $bonus['name'] . "', " . $bonus['amount'] . ")";

		echo "BENEFITS BONUS: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "benefits bonus success";
		} else{
			echo "benefits bonus failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_deductions_loans'] as $loan) {
		$sql = "INSERT INTO `hris_deductions_loan` (`id`, `name`, `total`) VALUES('" . $loan['id'] . "', '" . $loan['name'] . "', " . $loan['total'] . ")";

		echo "DEDUCTIONS LOAN: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "deductions loan success";
		} else{
			echo "deductions loan failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_deductions_taxes'] as $tax) {
		$sql = "INSERT INTO `hris_deductions_tax` (`id`, `civil_status`, `dependent_number`, `range_salary_start`, `range_salary_end`, `range_percent`, `range_plus`) VALUES('" . $tax['id'] . "', '" . $tax['civil_status'] . "', " . $tax['dependent_number'] . ", " . $tax['range_salary_start'] . ", " . $tax['range_salary_end'] . ", " . $tax['range_percent'] . ", " . $tax['range_plus'] . ")";

		echo "employees: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "deductions taxes success";
		} else{
			echo "deductions taxes failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_employees'] as $employee) {
		$sql = "INSERT INTO `hris_employees` (`id`, `start_contract`, `end_contract`, `employee_type`) VALUES('" . $employee['id'] . "', '" . $employee['start_contract'] . "', '" . $employee['end_contract'] . "', '" . $employee['employee_type'] . "')";

		echo "EMPLOYEES: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "employees success";
		} else{
			echo "employees failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_income'] as $income) {
		$sql = "INSERT INTO `hris_income` (`id`, `name`, `amount`) VALUES('" . $income['id'] . "', '" . $income['name'] . "', " . $income['amount'] . ")";

		echo "INCOME: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "income success";
		} else{
			echo "income failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_income_overtime'] as $overtime) {
		$sql = "INSERT INTO `hris_income_overtime` (`id`, `date_time`) VALUES('" . $overtime['id'] . "', '" . $overtime['date_time'] . ")";

		echo "INCOME OVERTIME: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "income overtime success";
		} else{
			echo "income overtime failed: " . mysqli_error($conn);
		}
	}

	foreach ($_SESSION['hris_income_salary_grade'] as $salary) {
		$sql = "INSERT INTO `hris_income_salary_grade` (`id`, `name`, `basic_salary`) VALUES('" . $salary['id'] . "', '" . $salary['name'] . "', " . $salary['basic_salary'] . ")";

		echo "INCOME BASIC SALARY: $sql\n\n";

		if(mysqli_query($conn, $sql)){
			echo "income basic salary success";
		} else{
			echo "income basic salary failed: " . mysqli_error($conn);
		}
	}

	mysqli_close($conn);

	echo "Data SAVING Successful!";
?>

<div>
	<button type="button" onclick="window.location.href='/pmis/datawarehouse/load.php'" style="margin-top:15px;">LOAD DASHBOARD</button>
</div>