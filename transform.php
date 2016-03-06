<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Data Warehouse | TRANSFORM</title>
</head>
<body>
	<h4>Data Warehouse | TRANSFORM</h4>

	<?php
		session_start();

		foreach ($_SESSION as $key => $val) {
			$i = 0;

			foreach ($val as $v) {
				foreach ($v as $w => $x) {
					$old_val = $_SESSION[$key][$i][$w];

					if($w === 'name'){
						$_SESSION[$key][$i][$w] = ucwords($old_val);
					} elseif(strpos($w, 'date') !== false || strpos($w, 'contract') !== false) {
				    $date = new DateTime($old_val);
				    $_SESSION[$key][$i][$w] = date_format($date, 'Y-m-d');
					} elseif(strpos($w, 'amount') !== false || strpos($w, 'salary') !== false){

						$tmp_x = $old_val;

						if(is_string($old_val)){
							$tmp_x = null;
							$tmp_x = floatval($old_val);
						}

						$new_x = number_format($tmp_x, 2, '.', '');
						$_SESSION[$key][$i][$w] = $new_x;
					} else{
						$_SESSION[$key][$i][$w] = ucfirst($old_val);
					}
				}

				$i += 1;
			}
		}

		echo "Data TRANSFORMATION Successful!";
	?>

	<div>
		<button type="button" onclick="window.location.href='/pmis/datawarehouse/save.php'" style="margin-top:15px;">SAVE DATA</button>
	</div>
</body>
</html>

<!-- income ==> id,name,amount <br>
overtime ==> id,datetime <br>
salarygrade ==> id,name,basicsalary <br>
benefits ==> id,name,amount <br>
leave ==> id,name,startdate,enddate,leavetype,leavetypeconvert <br>
loan ==> id,name,total <br>
bonus ==> id,name,amount <br>
deductions ==> id,name,totalamount <br>
tax ==> id,rangesalarystart,rangesalaryend,rangepercent,rangeplus,civilstatus,dependentnumber <br>
employees ==> id,contractstart,contractend,employeetype <br> -->