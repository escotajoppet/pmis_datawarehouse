window.onload = function(){
	var salary_points = [];
	var tax_points = [];
	var bonus_points = [];
	var deduction_points = [];

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

	for(var i = 0; i < datum['dates'].length; i++){
		salari = isNaN(datum['salaries'][i]) ? 0 : parseFloat(datum['salaries'][i]);

		var salary = {
			x: new Date(datum['dates'][i]), 
			y: salari
		};

		taks = isNaN(datum['tax'][i]) ? 0 : parseFloat(datum['tax'][i]);

		var tax = {
			x: new Date(datum['dates'][i]), 
			y: taks
		};

		bownus = isNaN(datum['bonus'][i]) ? 0 : parseFloat(datum['bonus'][i]);

		var bonus = {
			x: new Date(datum['dates'][i]), 
			y: bownus
		};

		dedaksyon = isNaN(datum['deduction'][i]) ? 0 : parseFloat(datum['deduction'][i]);

		var deduction = {
			x: new Date(datum['dates'][i]), 
			y: dedaksyon
		};

		salary_points.push(salary);
		tax_points.push(tax);
		bonus_points.push(bonus);
		deduction_points.push(deduction);
	}

	var HRISChart = new CanvasJS.Chart("hris-chart-container", {
		title:{
			text: "Human Resource Information System - Data Warehouse",
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
			interval: 5000
		},

		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},

		data:[{
				name: "Salary",
				showInLegend: true,
				type: "column", 
				color: "#0000FF",
				dataPoints: salary_points
			}, {
				name: "Tax",
				showInLegend: true,
				type: "column",
				color: "#FF0000",
				dataPoints: tax_points
			}, {
				name: "Bonus",
				showInLegend: true,
				type: "column",
				color: "#00FFFF",
				dataPoints: bonus_points
			}, {
				name: "Deductions",
				showInLegend: true,
				type: "column",
				color: "#00FF00",
				dataPoints: deduction_points
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
			interval: 10000
		},

		legend:{
			verticalAlign: "bottom",
			horizontalAlign: "center"
		},

		data:[
			{
				// name: "Real-Time",
				// showInLegend: true,
				type: "column", 
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