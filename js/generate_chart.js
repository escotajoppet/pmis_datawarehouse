window.onload = function(){
	var HRISChart = new CanvasJS.Chart("hris-chart-container", {
		title:{
			text: "Human Resource Information System - Data Warehouse",
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
			interval: 5
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
				{x: new Date(2008,0), y: 30},
				{x: new Date(2009,0), y: 30},
				{x: new Date(2010,0), y: 40},
				{x: new Date(2011,0), y: 50},
				{x: new Date(2012,0), y: 60},
				{x: new Date(2013,0), y: 70}
				]
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
			interval: 5
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
				{x: new Date(2008,0), y: 30},
				{x: new Date(2009,0), y: 30},
				{x: new Date(2010,0), y: 40},
				{x: new Date(2011,0), y: 50},
				{x: new Date(2012,0), y: 60}
				]
			}
		]
	});

	HRISChart.render();
	LGUChart.render();
}