<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Warehouse | LOAD</title>
</head>
<body>
	<?php
		$db_host = 'localhost';
		$db_username = 'root';
		$db_passwd = 'root';
		$db_name = 'datawarehouse';

		$conn = mysqli_connect($db_host, $db_username, $db_passwd, $db_name);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$deduction_data = array();

		$sql = "SELECT `deduction_amount_total`, `payroll_id` FROM `hris_payroll_deduction`";

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$deduction_data[$row['payroll_id']] = array();
					array_push($deduction_data[$row['payroll_id']], $row['deduction_amount_total']);
				}
			}
		}

		$bonus_data = array();

		$sql = "SELECT `bonus_amount`, `payroll_id` FROM `hris_payroll_bonus`";

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					$deduction_data[$row['payroll_id']] = array();
					array_push($deduction_data[$row['payroll_id']], $row['bonus_amount']);
				}
			}
		}

		$salary_data = array(
				'salaries' => array(),
				'tax' => array(),
				'dates' => array(),
				'deduction' => array(),
				'bonus' => array()
			);

		$sql = "SELECT `id`, `basic_salary`, `date`, `tax` FROM `hris_payroll`";

		if($result = mysqli_query($conn, $sql)){
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_array($result)){
					array_push($salary_data['salaries'], $row['basic_salary']);
					array_push($salary_data['tax'], $row['tax']);
					array_push($salary_data['dates'], $row['date']);
					if(array_key_exists($row['id'], $deduction_data)){
						array_push($salary_data['deduction'], $deduction_data[$row['id']]);
					}
					if(array_key_exists($row['id'], $bonus_data)){
						array_push($salary_data['bonu'], $deduction_data[$row['id']]);
					}
				}
			}
		}
	?>

	<?php
		$view = null;

		if(isset($_POST['view'])){
			$view = htmlspecialchars($_POST['view']);
		}
	?>

	<form action="" id="data-view-form" method="post">
		<select name="view" id="data-view">
			<option value="monthly">Monthly</option>
			<option value="quarterly">Quarterly</option>
			<option value="semiannually">Semi-Annually</option>
			<option value="annually">Annually</option>
		</select>
		<input type="submit" name="submit" value="Set View">
	</form>

	<div id="hris-chart-container" style="height: 400px; width: 100%;"></div>

	<div id="lgu-chart-container" style="height: 300px; width: 100%; margin-top: 50px;"></div>
	
	<script type="text/javascript">
		var datum = <?php echo json_encode($salary_data); ?>;
		var view = <?php echo json_encode($view); ?>
	</script>
	<script type="text/javascript" src="./js/generate_chart.js"></script>
	<script type="text/javascript" src="./js/canvasjs.min.js"></script>
</body>
</html>