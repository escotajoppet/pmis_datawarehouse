<?php session_start(); ?>

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

		$success = false;

		echo '<strong>SALARY and TAX:</strong> <br>';

		foreach ($_SESSION['hris_payroll'] as $payroll) {
			$sql = "INSERT INTO `hris_payroll` (`id`, `basic_salary`, `tax`, `civil_status`, `dependent_number`, `date`) VALUES('" . $payroll['id'] . "', " . $payroll['basic_salary'] . ", " . $payroll['percent'] . ", '" . $payroll['civil_status'] . "', " . $payroll['dependent_number'] . ", '" . $payroll['date'] . "')";

			echo "$sql <br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		echo "<br><br>";

		$success = false;

		echo '<strong>DEDUCTION:</strong> <br>';

		foreach ($_SESSION['hris_payroll_deduction'] as $deduction) {
			$sql = "INSERT INTO `hris_payroll_deduction` (`id`, `deduction_amount_total`, `payroll_id`) VALUES('" . $deduction['id'] . "', " . $deduction['deduction_amount_total'] . ", '" . $deduction['payroll_id'] . "')";

			echo "$sql <br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		echo "<br><br>";

		$success = false;

		echo '<strong>BONUS:</strong> <br>';

		foreach ($_SESSION['hris_payroll_bonus'] as $bonus) {
			$sql = "INSERT INTO `hris_payroll_bonus` (`id`, `bonus_amount`, `payroll_id`) VALUES('" . $bonus['id'] . "', " . $bonus['bonus_amount'] . ", '" . $bonus['payroll_id'] . "')";

			echo "$sql <br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		echo "<br><br>";

		$success = false;

		echo '<strong>BENEFIT:</strong> <br>';

		foreach ($_SESSION['hris_payroll_benefit'] as $benefit) {
			$sql = "INSERT INTO `hris_payroll_benefit` (`id`, `benefits_amount`, `payroll_id`) VALUES('" . $benefit['id'] . "', " . $benefit['benefits_amount'] . ", '" . $benefit['payroll_id'] . "')";

			echo "$sql <br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		echo "<br><br>";

		$success = false;

		echo '<strong>INCOME:</strong> <br>';

		foreach ($_SESSION['hris_payroll_income'] as $income) {
			$sql = "INSERT INTO `hris_payroll_income` (`id`, `income_amount`, `payroll_id`) VALUES('" . $income['id'] . "', " . $income['income_amount'] . ", '" . $income['payroll_id'] . "')";

			echo "$sql <br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		echo "<br><br>";

		mysqli_close($conn);

		echo "<strong>Data SAVING Successful!</strong>";
	?>

	<div>
		<button type="button" onclick="window.location.href='/pmis/datawarehouse/load.php'" style="margin-top:15px;">LOAD DASHBOARD</button>
	</div>
</body>
</html>