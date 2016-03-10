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

		foreach ($_SESSION['hris_payroll'] as $payroll) {
			$sql = "INSERT INTO `hris_payroll` (`id`, `basic_salary`, `tax`, `civil_status`, `dependent_number`, `date`) VALUES('" . $payroll['id'] . "', " . $payroll['basic_salary'] . ", " . $payroll['percent'] . ", '" . $payroll['civil_status'] . "', " . $payroll['dependent_number'] . ", '" . $payroll['date'] . "')";

			echo "PAYROLL: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "PAYROLL Success...";
		} else{
			echo "PAYROLL failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_payroll_deduction'] as $deduction) {
			$sql = "INSERT INTO `hris_payroll_deduction` (`id`, `deduction_amount_total`, `payroll_id`) VALUES('" . $deduction['id'] . "', " . $deduction['deduction_amount_total'] . ", '" . $deduction['payroll_id'] . "')";

			echo "PAYROLL DEDUCTION: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "PAYROLL DEDUCTION Success...";
		} else{
			echo "PAYROLL DEDUCTION failed: " . mysqli_error($conn);
		}

		echo "<br><br><br><br><br>";

		$success = false;

		foreach ($_SESSION['hris_payroll_bonus'] as $bonus) {
			$sql = "INSERT INTO `hris_payroll_bonus` (`id`, `bonus_amount`, `payroll_id`) VALUES('" . $bonus['id'] . "', " . $bonus['bonus_amount'] . ", '" . $bonus['payroll_id'] . "')";

			echo "PAYROLL BONUS: $sql <br><br>";

			if(mysqli_query($conn, $sql)){
				$success = true;
			}
		}

		if($success){
			echo "PAYROLL BONUS Success...";
		} else{
			echo "PAYROLL BONUS failed: " . mysqli_error($conn);
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