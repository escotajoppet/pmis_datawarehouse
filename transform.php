<?php
	session_start();

	foreach ($_SESSION as $key => $val) {
		foreach ($val as $k => $v) {
			if($k === 'name'){
				$val[$k] = ucwords($v);
			} elseif(strpos($k, 'date') !== false || strpos($k, 'contract') !== false) {
		    $date = new DateTime($v);
		    $val[$k] = date_format($date, 'Y-m-d');
			} elseif(strpos($k, 'amount') !== false || strpos($k, 'salary') !== false){
				$new_v = number_format($v, 2, '.', ',');
				$val[$k] = $new_v;
			} else{
				$val[$k] = ucfirst($v);
			}			
		}
	}

	echo "Data TRANSFORMATION Successful!";
?>

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

<div>
	<button type="button" onclick="window.location.href='/pmis/datawarehouse/save.php'" style="margin-top:15px;">SAVE DATA</button>
</div>