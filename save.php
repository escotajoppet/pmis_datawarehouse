<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Warehouse | SAVE</title>
</head>
<body>
	<h4>Data Warehouse | SAVE</h4>

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

		$success = false;

		foreach ($_SESSION['hris_benefits'] as $benefit) {
			$sql = "INSERT INTO `hris_benefits` (`id`, `name`, `amount`) VALUES('" . $benefit['id'] . "', '" . $benefit['name'] . "', " . $benefit['amount'] . ")";

			echo "BENEFITS: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "BENEFITS Success...";
		} else{
			echo "BENEFITS failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_benefits_bonus'] as $bonus) {
			$sql = "INSERT INTO `hris_benefits_bonus` (`id`, `name`, `amount`) VALUES('" . $bonus['id'] . "', '" . $bonus['name'] . "', " . $bonus['amount'] . ")";

			echo "BENEFITS BONUS: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "BENEFITS BONUS Success...";
		} else{
			echo "BENEFITS BONUS failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_benefits_leave'] as $leave) {
			$sql = "INSERT INTO `hris_benefits_leave` (`id`, `start_date`, `end_date`, `leave_type`, `name`, `leave_type_convert`) VALUES('" . $leave['id'] . "', '" . $leave['start_date'] . "', '" . $leave['end_date'] . "', '" . $leave['leave_type'] . "', '" . $leave['name'] . "', '" . $leave['leave_type_convert'] . "')";

			echo "BENEFITS LEAVE: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "BENEFITS LEAVE Success...";
		} else{
			echo "BENEFITS LEAVE failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_benefits_loan'] as $loan) {
			$sql = "INSERT INTO `hris_benefits_loan` (`id`, `total`) VALUES('" . $loan['id'] . "', " . $loan['total'] . ")";

			echo "BENEFITS LOAN: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "BENEFITS LOAN Success...";
		} else{
			echo "BENEFITS LOAN failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_deductions'] as $deduction) {
			$sql = "INSERT INTO `hris_deductions` (`id`, `name`, `amount`) VALUES('" . $deduction['id'] . "', '" . $deduction['name'] . "', " . $deduction['total_amount'] . ")";

			echo "DEDUCTIONS: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "DEDUCTIONS Success...";
		} else{
			echo "DEDUCTIONS failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_deductions_loans'] as $loan) {
			$sql = "INSERT INTO `hris_deductions_loan` (`id`, `total`) VALUES('" . $loan['id'] . "', " . $loan['total'] . ")";

			echo "DEDUCTIONS LOAN: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "DEDUCTIONS LOAN Success...";
		} else{
			echo "DEDUCTIONS LOAN failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_deductions_taxes'] as $tax) {
			$sql = "INSERT INTO `hris_deductions_tax` (`id`, `civil_status`, `dependent_number`, `range_salary_start`, `range_salary_end`, `range_percent`, `range_plus`) VALUES('" . $tax['id'] . "', '" . $tax['civil_status'] . "', " . $tax['dependent_number'] . ", " . $tax['range_salary_start'] . ", " . $tax['range_salary_end'] . ", " . $tax['range_percent'] . ", " . $tax['range_plus'] . ")";

			echo "DEDUCTIONS TAX: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "DEDUCTIONS TAX Success...";
		} else{
			echo "DEDUCTIONS TAX failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_employees'] as $employee) {
			$sql = "INSERT INTO `hris_employees` (`id`, `contract_start`, `contract_end`, `employee_type`) VALUES('" . $employee['id'] . "', '" . $employee['contract_start'] . "', '" . $employee['contract_end'] . "', '" . $employee['employee_type'] . "')";

			echo "EMPLOYEES: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "EMPLOYEES Success...";
		} else{
			echo "EMPLOYEES failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_income'] as $income) {
			$sql = "INSERT INTO `hris_income` (`id`, `name`, `amount`) VALUES('" . $income['id'] . "', '" . $income['name'] . "', " . $income['amount'] . ")";

			echo "INCOME: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "INCOME Success...";
		} else{
			echo "INCOME failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_income_overtime'] as $overtime) {
			$sql = "INSERT INTO `hris_income_overtime` (`id`, `date_time`) VALUES('" . $overtime['id'] . "', '" . $overtime['date_time'] . "')";

			echo "INCOME OVERTIME: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "INCOME OVERTIME Success...";
		} else{
			echo "INCOME OVERTIME failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_income_salary_grade'] as $salary) {
			$sql = "INSERT INTO `hris_income_salary_grade` (`id`, `name`, `basic_salary`) VALUES('" . $salary['id'] . "', '" . $salary['name'] . "', " . $salary['basic_salary'] . ")";

			echo "INCOME BASIC SALARY: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "INCOME BASIC SALARY Success...";
		} else{
			echo "INCOME BASIC SALARY failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		mysqli_close($conn);

		echo "Data SAVING Successful!";
	?>

	<div>
		<button type="button" onclick="window.location.href='/pmis/datawarehouse/load.php'" style="margin-top:15px;">LOAD DASHBOARD</button>
	</div>
</body>
</html>