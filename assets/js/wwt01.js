let titleA = "pH-102";
let site_url = $('#site_url').val();
let dataPoints1A = [];
let dataPoints2A = [];
let dataPoints3A = [];
let tglObjAOut;
let optionsA = [];
let dataA = [];
let dataLength = 10;
let chartA = [];
let legendHigh = "";
let legendValue = "";
let legendLow = "";
let updateInterval = 2000;
let totalData = 0;

Date.prototype.addHours = function (h) {
	this.setTime(this.getTime() + (h * 60 * 60 * 1000));
	return this;
}


// INIT DATA TODAY
$.ajax({
	url: `${site_url}get_ph102/today`,
	method: 'get',
	dataType: 'json',
	beforeSend: function () {
		//
	}
}).always(function (e) {
	//
}).fail(function (e) {
	e.responseText;
}).done(function (res) {

	//
	if (res.data.length > 0) {
		$.each(res.data, function (i, k) {
			let tglObjA = new Date(k.created_at);
			tglObjAOut = tglObjA;

			dataPoints1A.push({
				x: tglObjA.getTime(),
				y: parseFloat(k.high_data),
			});
			dataPoints2A.push({
				x: tglObjA.getTime(),
				y: parseFloat(k.value_data),
			});
			dataPoints3A.push({
				x: tglObjA.getTime(),
				y: parseFloat(k.low_data),
			});

			legendHigh = k.high_data;
			legendValue = k.value_data;
			legendLow = k.low_data;
		});
	}

	optionsA = {
		data: [{
			type: "spline",
			color: "red",
			showInLegend: true,
			indexLabelFontSize: 20,
			xValueType: "dateTime",
			xValueFormatString: "hh:mm TT",
			yValueFormatString: "###.00",
			name: "High",
			dataPoints: dataPoints1A,
		}, {
			type: "spline",
			color: "green",
			showInLegend: true,
			indexLabelFontSize: 22,
			xValueType: "dateTime",
			xValueFormatString: "hh:mm TT",
			yValueFormatString: "###.00",
			name: "Value",
			dataPoints: dataPoints2A,
		}, {
			type: "spline",
			color: "grey",
			showInLegend: true,
			xValueType: "dateTime",
			xValueFormatString: "hh:mm TT",
			yValueFormatString: "###.00",
			name: "Low",
			dataPoints: dataPoints3A,
		}],
		theme: "light2",
		zoomEnabled: true,
		title: {
			text: titleA,
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
			labelAutoFit: true,
			labelMaxWidth: 85,
			labelWrap: true,
			labelAngle: 0,
			maximum: null,
			crosshair: {
				enabled: true,
				snapToDataPoint: true
			}
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
				let content = "<div style=\"width: 100%; font-weight: bold; text-align: right;\">" + CanvasJS.formatDate(e.entries[0].dataPoint.x, "DD-MMM-YYYY hh:mm TT") + "</div><table>";
				for (let i = 0; i < e.entries.length; i++) {
					content += "<tr><td>";
					content += "<span style=\"color: " + e.entries[i].dataSeries.color + ";\">&#9632;</span> " + e.entries[i].dataSeries.name + " ";
					content += "</td><td style=\"text-align: right; padding-left: 5px;\">";
					content += "<strong>" + e.entries[i].dataPoint.y + "</strong>";
					content += "</td></tr>";
				}
				content += "</table></div><p id='xdataA' style='display:none;'>" + e.entries[0].dataPoint.x + "</p>";
				return content;
			},
		},
		legend: {
			cursor: "pointer",
			verticalAlign: "bottom",
			horizontalAlign: "center",
			fontSize: 22,
			itemclick: toggleDataSeriesA
		},
	};

	optionsA.data[0].legendText = "High : " + legendHigh + "";
	optionsA.data[1].legendText = "Value : " + legendValue + "";
	optionsA.data[2].legendText = "Low : " + legendLow + "";

	if (res.data.length > 0) {
		optionsA.axisX.maximum = tglObjAOut.addHours(0.01).getTime();
	}

	if (optionsA.data[0].dataPoints.length > dataLength) {
		xReduce = Math.abs(dataLength - optionsA.data[0].dataPoints.length);
		console.log(xReduce + "aa");
		for (i = 0; i < xReduce; i++) {
			optionsA.data[0].dataPoints.shift();
			optionsA.data[1].dataPoints.shift();
			optionsA.data[2].dataPoints.shift();
		}
	}

	totalData = optionsA.data[0].dataPoints.length;
	console.log(totalData + "bb")

	chartA = new CanvasJS.Chart("chartContainerA", optionsA);
	chartA.render();
});

function toggleDataSeriesA(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	chartA.render();
}


window.onload = function () {
	updateChartA();
	setInterval(function () {
		updateChartA()
	}, updateInterval);
}

function updateChartA() {
	$.ajax({
		url: `${site_url}get_ph102/latest`,
		method: 'get',
		dataType: 'json',
		beforeSend: function () {
			// blockui
		}
	}).always(function (e) {
		// unblockui
	}).fail(function (e) {
		e.responseText;
	}).done(function (res) {

		if (res.data.length > 0) {
			$.each(res.data, function (i, k) {
				let tglObjA = new Date(k.created_at);
				tglObjAOut = tglObjA;

				chartA.options.data[0].dataPoints.push({
					x: tglObjA.getTime(),
					y: parseFloat(k.high_data),
				});
				chartA.options.data[1].dataPoints.push({
					x: tglObjA.getTime(),
					y: parseFloat(k.value_data),
				});
				chartA.options.data[2].dataPoints.push({
					x: tglObjA.getTime(),
					y: parseFloat(k.low_data),
				});

				legendHigh = k.high_data;
				legendValue = k.value_data;
				legendLow = k.low_data;

				totalData++;
			});

		}

		console.log(chartA.options.data[0].dataPoints.length);
		console.log(totalData);

		if (totalData > dataLength) {
			xReduce = totalData - dataLength;
			totalData = dataLength;
			console.log(xReduce);
			for (i = 0; i < xReduce; i++) {
				chartA.options.data[0].dataPoints.shift();
				chartA.options.data[1].dataPoints.shift();
				chartA.options.data[2].dataPoints.shift();
			}

			chartA.options.axisX.maximum = tglObjAOut.addHours(0.01).getTime();
		}

		console.log(totalData);

		// console.log(chartA.options.data[0].dataPoints.length)

		chartA.options.data[0].legendText = "High : " + legendHigh + "";
		chartA.options.data[1].legendText = "Value : " + legendValue + "";
		chartA.options.data[2].legendText = "Low : " + legendLow + "";

		chartA.render();

	});
}
