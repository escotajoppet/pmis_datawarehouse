<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Warehouse | TRANSFORM</title>
</head>
<body>
	<h4>Data Warehouse | TRANSFORM</h4>

	<?php
		foreach ($_SESSION as $key => $val) {
			$i = 0;

			foreach ($val as $v) {
				foreach ($v as $w => $x) {
					$old_val = $_SESSION[$key][$i][$w];

					if($w === 'name'){
						echo "Titleizing '$old_val'... <br>";
						$_SESSION[$key][$i][$w] = ucwords($old_val);
					} elseif(strpos($w, 'date') !== false || strpos($w, 'contract') !== false) {
				    $date = new DateTime($old_val);
						echo "Converting date into 'Y-m-d format'... <br>";
				    $_SESSION[$key][$i][$w] = date_format($date, 'Y-m-d');
					} elseif(strpos($w, 'amount') !== false || strpos($w, 'salary') !== false){

						$tmp_x = $old_val;

						if(is_string($old_val)){
							$tmp_x = null;
							$tmp_x = floatval($old_val);
						}

						echo "Standardizing salary/amount '$old_val' with 2 decimal places <br>";
						$new_x = number_format($tmp_x, 2, '.', '');
						$_SESSION[$key][$i][$w] = $new_x;
					} elseif(strpos($w, 'percent') !== false){
						$salary = floatval($_SESSION[$key][$i]['basic_salary']);
						$percent = floatval($x) * 0.01;
						$prod = $salary * $percent;

						echo "Computing pecentage of $salary by $x% <br>";
						$_SESSION[$key][$i][$w] = $prod;
					} else{
						echo "Standardizing '$old_val' <br>";
						$_SESSION[$key][$i][$w] = ucfirst($old_val);
					}
				}

				$i += 1;
			}
		}

		echo '<br><br>';

		echo "<strong>Data TRANSFORMATION Successful!</strong>";
	?>

	<div>
		<button type="button" onclick="window.location.href='/pmis/datawarehouse/save.php'" style="margin-top:15px;">SAVE DATA</button>
	</div>
</body>
</html>