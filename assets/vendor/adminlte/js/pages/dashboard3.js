let prevxdata = null;
// window.onload = function () {

var dataPoints1 = [];
var dataPoints2 = [];
var dataPoints3 = [];

var options = {
	theme: "light2",
	zoomEnabled: true,
	title: {
		text: "Alarm",
		padding: {
			top: 8
		}
	},
	axisX: {
		title: "",
		gridColor: "rgba(105,105,105,.8)",
		lineThickness: 1,
		gridThickness: 1,
		tickThickness: 0,
		lineColor: "#ddd",
		gridColor: "#ddd",
		labelFontFamily: "Arial",
		labelFontSize: 10,
		labelAutoFit: false,
		labelMaxWidth: 85,
		labelWrap: true,
		labelAngle: 0,
	},
	axisY: {
		suffix: "",
		lineColor: "rgba(105,105,105,.8)",
		gridColor: "rgba(105,105,105,.8)",
	},
	toolTip: {
		shared: true,
		labelFontFamily: "Arial",
		fontStyle: "normal",
		labelFontSize: 10,
		borderThickness: 1,
		cornerRadius: 5,
		borderColor: "#666",
		contentFormatter: function (e) {
			var content = "<div style=\"width: 100%; font-weight: bold; text-align: right;\">" + CanvasJS.formatDate(e.entries[0].dataPoint.x, "DD-MM-YYYY HH:mm TT") + "</div><table>";
			for (var i = 0; i < e.entries.length; i++) {
				content += "<tr><td>";
				content += "<span style=\"color: " + e.entries[i].dataSeries.color + ";\">&#9632;</span> " + e.entries[i].dataSeries.name + " ";
				content += "</td><td style=\"text-align: right; padding-left: 5px;\">";
				content += "<strong>" + e.entries[i].dataPoint.y + "</strong>";
				content += "</td></tr>";
			}
			content += "</table></div><p id='xdata' style='display:none;'>" + e.entries[0].dataPoint.x + "</p>";
			// console.log(e.entries[0].dataPoint.x);
			return content;
		},
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "bottom",
		horizontalAlign: "center",
		fontSize: 22,
		itemclick: toggleDataSeries
	},
	data: [{
		type: "line",
		color: "red",
		showInLegend: true,
		indexLabelFontSize: 22,
		xValueType: "dateTime",
		xValueFormatString: "hh:mm TT",
		yValueFormatString: "###.00",
		name: "High",
		dataPoints: dataPoints2,
	}, {
		type: "line",
		color: "green",
		showInLegend: true,
		indexLabelFontSize: 22,
		xValueType: "dateTime",
		xValueFormatString: "hh:mm TT",
		yValueFormatString: "###.00",
		name: "Value",
		dataPoints: dataPoints1,
	}, {
		type: "line",
		color: "grey",
		showInLegend: true,
		xValueType: "dateTime",
		xValueFormatString: "hh:mm TT",
		yValueFormatString: "###.00",
		name: "Low",
		dataPoints: dataPoints3,
	}]
};

var chart = new CanvasJS.Chart("chartContainer", options);

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

var updateInterval = 2000;
// initial value
var yValue1 = 800;
var yValue2 = 810;
var yValue3 = 780;

var time = new Date;
// starting at 10.00 am
time.setHours(10);
time.setMinutes(00);
time.setSeconds(00);
time.setMilliseconds(00);

function updateChart(count) {
	count = count || 1;
	var deltaY1, deltaY2, deltaY3;
	for (var i = 0; i < count; i++) {
		time.setTime(time.getTime() + updateInterval);
		deltaY1 = -1 + Math.random() * (1 + 1);
		deltaY2 = -1 + Math.random() * (1 + 1);
		deltaY3 = -1 + Math.random() * (1 + 1);

		// adding random value and rounding it to two digits. 
		yValue1 = Math.round((yValue1 + deltaY1) * 100) / 100;
		yValue2 = Math.round((yValue2 + deltaY2) * 100) / 100;
		yValue3 = Math.round((yValue3 + deltaY3) * 100) / 100;

		// pushing the new values
		dataPoints1.push({
			x: time.getTime(),
			y: yValue1,
		});
		dataPoints2.push({
			x: time.getTime(),
			y: yValue2,
		});
		dataPoints3.push({
			x: time.getTime(),
			y: yValue3,
		});
	}

	// updating legend text with  updated with y Value 
	options.data[0].legendText = "High : " + yValue2 + "";
	options.data[1].legendText = "Value : " + yValue1 + "";
	options.data[2].legendText = "Low : " + yValue3 + "";
	chart.render();

	function stripLineHandler(position) {
		console.log("strip");
		if (!chart.options.axisX) {
			chart.options.axisX = {};
		}
		if (!chart.options.axisX.stripLines) {
			chart.options.axisX.stripLines = [];
		}
		chart.options.axisX.stripLines[0] = {
			value: position,
			thickness: 1,
			showOnTop: true
		}
		chart.render();
	}

	document.getElementById("chartContainer").onmousemove = function () {
		if (document.getElementById("xdata")) {
			var currentxdata = new Date(parseInt(document.getElementById("xdata").innerHTML));
			if (prevxdata != currentxdata.getTime()) {
				stripLineHandler(currentxdata.getTime());
				prevxdata = currentxdata.getTime();
			}
		}
	}

}
// generates first set of dataPoints 
updateChart(100);
// setInterval(function () {
// 	updateChart()
// }, updateInterval);

//}
