window.onload = function(){
	var x_interval = null;
	var x_interval_type = null;
	var x_angle = null

	switch(view) {
    case 'monthly':
    	x_interval = 1;
    	x_interval_type = 'month';
    	x_angle = -90;
      break;
    case 'quarterly':
    	x_interval = 4;
    	x_interval_type = 'month';
    	x_angle = -60;
      break;
    case 'semiannually':
    	x_interval = 6;
    	x_interval_type = 'month';
    	x_angle = -30;
      break;
    case 'annually':
    	x_interval = 1;
    	x_interval_type = 'year';
    	x_angle = 0;
      break;
    default:
    	x_interval = 1;
    	x_interval_type = 'year';
    	x_angle = 0;
      break;
	}

	var total_salary = new Object();
	var total_bonus = new Object();
	var total_benefit = new Object();
	var total_income = new Object();
	var total_deduction = new Object();
	var total_tax = new Object();

	for(var i = 0; i < datum['dates'].length; i++){
		var date = new Date(datum['dates'][i]);
		var date_str = formatDate(date);

		salari = isNaN(datum['salary'][i]) ? 0 : parseFloat(datum['salary'][i]);

		if(total_salary[date_str] === undefined){
			total_salary[date_str] = salari;
		} else{
			total_salary[date_str] += salari;
		}

		var taks = isNaN(datum['tax'][i]) ? 0 : parseFloat(datum['tax'][i]);

		if(total_tax[date_str] === undefined){
			total_tax[date_str] = taks;
		} else{
			total_tax[date_str] += taks;
		}

		var bownus = isNaN(datum['bonus'][i]) ? 0 : parseFloat(datum['bonus'][i]);

		if(total_bonus[date_str] === undefined){
			total_bonus[date_str] = bownus;
		} else{
			total_bonus[date_str] += bownus;
		}

		var dedaksyon = isNaN(datum['deduction'][i]) ? 0 : parseFloat(datum['deduction'][i]);

		if(total_deduction[date_str] === undefined){
			total_deduction[date_str] = dedaksyon;
		} else{
			total_deduction[date_str] += dedaksyon;
		}

		var benepit = isNaN(datum['benefit'][i]) ? 0 : parseFloat(datum['benefit'][i]);

		if(total_benefit[date_str] === undefined){
			total_benefit[date_str] = benepit;
		} else{
			total_benefit[date_str] += benepit;
		}

		console.log("===> " + datum['income'][i]);

		var inkam = isNaN(datum['income'][i]) ? 0 : parseFloat(datum['income'][i]);

		if(total_income[date_str] === undefined){
			total_income[date_str] = inkam;
		} else{
			total_income[date_str] += inkam;
		}
	}
	
	var salary_points = [];
	var bonus_points = [];
	var benefit_points = [];
	var deduction_points = [];
	var tax_points = [];
	var income_points = [];

	for(var i = 0; i < datum['dates'].length; i++){
		var date = new Date(datum['dates'][i]);
		var date_str = formatDate(date);

		var salary = {
			x: date, 
			y: total_salary[date_str]
		};

		var tax = {
			x: date, 
			y: total_tax[date_str]
		};

		var bonus = {
			x: date, 
			y: total_bonus[date_str]
		};

		var deduction = {
			x: date, 
			y: total_deduction[date_str]
		};

		var benefit = {
			x: date, 
			y: total_benefit[date_str]
		};

		var income = {
			x: date, 
			y: total_income[date_str]
		};

		salary_points.push(salary);
		tax_points.push(tax);
		bonus_points.push(bonus);
		deduction_points.push(deduction);
		benefit_points.push(benefit);
		income_points.push(income);
	}

	var hris_chart_title = 'Payroll - Data Warehouse';
	var chart_type = 'column';
	var axis_y_interval = 50000;

	var HRISChart = new CanvasJS.Chart("hris-chart-container", {
		title:{
			text: hris_chart_title,
			horizontalAlign: "center"
		},

		axisX:{
			tickThickness: 10,
			interval: x_interval,
			intervalType: x_interval_type,
			labelAngle: x_angle
		},

		animationEnabled: true,

		toolTip: {
			shared: true
		},

		axisY:{
			title: "",
			lineThickness: 0,
			tickThickness: 10,
			interval: axis_y_interval
		},

		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},

		data:[
		 	{
				name: "Income",
				showInLegend: true,
				type: chart_type,
				color: "#0000FF",
				dataPoints: income_points
			}, {
				name: "Salary",
				showInLegend: true,
				type: chart_type, 
				color: "#629b45",
				dataPoints: salary_points
			}, {
				name: "Benefits",
				showInLegend: true,
				type: chart_type,
				color: "#23c44b",
				dataPoints: benefit_points
			}, {
				name: "Bonus",
				showInLegend: true,
				type: chart_type,
				color: "#12ea5a",
				dataPoints: bonus_points
			}, {
				name: "Deductions",
				showInLegend: true,
				type: chart_type,
				color: "#8e4747",
				dataPoints: deduction_points
			}, {
				name: "Tax",
				showInLegend: true,
				type: chart_type,
				color: "#FF0000",
				dataPoints: tax_points
			}
		]
	});













	var LGUChart = new CanvasJS.Chart("lgu-chart-container", {
		title:{
			text: "Local Government Unit - Data Warehouse",
			horizontalAlign: "center"
		},

		axisX:{
			tickThickness: 0,
			interval: 1,
			intervalType: "year"
		},

		animationEnabled: true,

		toolTip: {
			shared: false
		},

		axisY:{
			title: "",
			lineThickness: 0,
			tickThickness: 0,
			interval: 300000
		},

		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},

		data:[
			{
				// name: "Real-Time",
				// showInLegend: true,
				type: chart_type, 
				color: "#004B8D ",
				dataPoints: [
				{x: new Date('2016-04-14',0), y: 30000},
				{x: new Date(2009,0), y: 30},
				{x: new Date(2010,0), y: 40},
				{x: new Date(2011,0), y: 50},
				{x: new Date(2012,0), y: 60}
				]
			}
		]
	});

	HRISChart.render();
	// LGUChart.render();
}

function formatDate(date){
	var month = '' + (date.getMonth() + 1);
	var day = '' + date.getDate();
	var year = date.getFullYear();

	if(month.length < 2) month = '0' + month;
	if(day.length < 2) day = '0' + day;

	return [year, month, day].join('-');
}