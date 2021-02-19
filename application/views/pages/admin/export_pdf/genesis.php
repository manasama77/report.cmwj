<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Export PDF</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    <style>
        #content {
            background-color: #fff;
        }

        .white_block {
            position: absolute;
            top: 385px;
            width: 57px;
            background-color: #fff;

        }

        .white_block2 {
            position: absolute;
            top: 725px;
            width: 57px;
            background-color: #fff;

        }

        .white_block3 {
            position: absolute;
            top: 996px;
            width: 57px;
            background-color: #fff;

        }

        .canvasjs-chart-tooltip {
            box-shadow: none !important;
        }

        .canvasjs-chart-credit {
            display: none;
        }
    </style>
</head>

<body>
    <div id="content">
        <h2 class="text-center"><?= $nama; ?><br><small><?= $from_date; ?> - <?= $to_date; ?></small></h2>
        <div id="chartContainerA" style="height: 300px; width: 100%;"></div>
        <div class="white_block">
            &nbsp;
        </div>
        <hr>
        <div id="chartContainerB" style="height: 300px; width: 100%;"></div>
        <div class="white_block2">
            &nbsp;
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/canvasjs.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/html2canvas.js"></script>
    <!-- <script src="<?= base_url(); ?>assets/vendor/jspdf/jspdf.umd.js"></script> -->
    <script src="<?= base_url(); ?>assets/js/jspdf.debug.js"></script>
    <!-- <script src="<?= base_url(); ?>assets/vendor/jspdf/jspdf.debug.js"></script> -->

    <script>
        let from_date = '<?= $from_date; ?>';
        let to_date = '<?= $to_date; ?>';

        let titleA = "pH-102";
        let initLengthA = 0;
        let latestLengthA = 0;
        let dataPoints1A = [];
        let dataPoints2A = [];
        let dataPoints3A = [];
        let legendHighA = [];
        let legendValueA;
        let legendLowA;
        let optionsA = [];

        let titleB = "pH-107";
        let initLengthB = 0;
        let latestLengthB = 0;
        let dataPoints1B = [];
        let dataPoints2B = [];
        let dataPoints3B = [];
        let legendHighB = [];
        let legendValueB;
        let legendLowB;
        let optionsB = [];

        $(document).ready(() => {
            if (<?= $id_area; ?> == 1) {
                let initUrl1 = `<?= site_url(); ?>get_ph102`;
                let initUrl2 = `<?= site_url(); ?>get_ph103`;

                initDataA(initUrl1);
                initDataB(initUrl2);
            }

            setTimeout(() => {
                let w = document.getElementById("content").offsetWidth;
                let h = document.getElementById("content").offsetHeight;

                html2canvas(document.getElementById("content"), {
                    dpi: 300, // Set to 300 DPI
                    scale: 1, // Adjusts your resolution
                    onrendered: function(canvas) {
                        let img = canvas.toDataURL("image/png", 1);
                        let doc = new jsPDF('l', 'mm', 'a4', 420, 297);
                        doc.addImage(img, 'PNG', 10, 10, 280, 150);
                        doc.save('sample-file.pdf');
                    }
                });
            }, 1500);
        });

        function initDataA(urlnya) {

            $.ajax({
                url: urlnya,
                method: 'get',
                dataType: 'json',
                data: {
                    from_date: from_date,
                    to_date: to_date,
                },
                beforeSend: () => {
                    dataPoints1A = [];
                    dataPoints2A = [];
                    dataPoints3A = [];
                }
            }).always((e) => {}).fail((e) => {
                console.log(e);
            }).done((e) => {
                initLengthA = e.data.length;

                if (initLengthA > 0) {
                    $.each(e.data, (i, k) => {
                        let tglObjA = new Date(k.created_at);

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

                        legendHighA = k.high_data;
                        legendValueA = k.value_data;
                        legendLowA = k.low_data;
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
                        contentFormatter: function(e) {
                            let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "DD-MMM-YYYY hh:mm TT")}</div><table>`;
                            for (let i = 0; i < e.entries.length; i++) {
                                content += `<tr><td>`;
                                content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                                content += `</td><td style="text-align: right; padding-left: 5px;">`;
                                content += `<strong> ${e.entries[i].dataPoint.y}</strong>`;
                                content += `</td></tr >`;
                            }
                            content += `</table></div><p id="xdataA" style='display:none;'> ${e.entries[0].dataPoint.x}< /p>`;
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

                optionsA.data[0].legendText = "High : " + legendHighA + "";
                optionsA.data[1].legendText = "Value : " + legendValueA + "";
                optionsA.data[2].legendText = "Low : " + legendLowA + "";

                chartA = new CanvasJS.Chart("chartContainerA", optionsA);
                chartA.render();
            });
        }

        function initDataB(urlnya) {

            $.ajax({
                url: urlnya,
                method: 'get',
                dataType: 'json',
                data: {
                    from_date: from_date,
                    to_date: to_date,
                },
                beforeSend: () => {
                    dataPoints1B = [];
                    dataPoints2B = [];
                    dataPoints3B = [];
                }
            }).always((e) => {}).fail((e) => {
                console.log(e);
            }).done((e) => {
                initLengthB = e.data.length;

                if (initLengthB > 0) {
                    $.each(e.data, (i, k) => {
                        let tglObjB = new Date(k.created_at);

                        dataPoints1B.push({
                            x: tglObjB.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2B.push({
                            x: tglObjB.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3B.push({
                            x: tglObjB.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighB = k.high_data;
                        legendValueB = k.value_data;
                        legendLowB = k.low_data;
                    });
                }

                optionsB = {
                    data: [{
                        type: "spline",
                        color: "red",
                        showInLegend: true,
                        indexLabelFontSize: 20,
                        xValueType: "dateTime",
                        xValueFormatString: "hh:mm TT",
                        yValueFormatString: "###.00",
                        name: "High",
                        dataPoints: dataPoints1B,
                    }, {
                        type: "spline",
                        color: "green",
                        showInLegend: true,
                        indexLabelFontSize: 22,
                        xValueType: "dateTime",
                        xValueFormatString: "hh:mm TT",
                        yValueFormatString: "###.00",
                        name: "Value",
                        dataPoints: dataPoints2B,
                    }, {
                        type: "spline",
                        color: "grey",
                        showInLegend: true,
                        xValueType: "dateTime",
                        xValueFormatString: "hh:mm TT",
                        yValueFormatString: "###.00",
                        name: "Low",
                        dataPoints: dataPoints3B,
                    }],
                    theme: "light2",
                    zoomEnabled: true,
                    title: {
                        text: titleB,
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
                        contentFormatter: function(e) {
                            let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "DD-MMM-YYYY hh:mm TT")}</div><table>`;
                            for (let i = 0; i < e.entries.length; i++) {
                                content += `<tr><td>`;
                                content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                                content += `</td><td style="text-align: right; padding-left: 5px;">`;
                                content += `<strong> ${e.entries[i].dataPoint.y}</strong>`;
                                content += `</td></tr >`;
                            }
                            content += `</table></div><p id="xdataA" style='display:none;'> ${e.entries[0].dataPoint.x}< /p>`;
                            return content;
                        },
                    },
                    legend: {
                        cursor: "pointer",
                        verticalAlign: "bottom",
                        horizontalAlign: "center",
                        fontSize: 22,
                        itemclick: toggleDataSeriesB
                    },
                };

                optionsB.data[0].legendText = "High : " + legendHighB + "";
                optionsB.data[1].legendText = "Value : " + legendValueB + "";
                optionsB.data[2].legendText = "Low : " + legendLowB + "";

                chartB = new CanvasJS.Chart("chartContainerB", optionsB);
                chartB.render();
            });
        }

        function toggleDataSeriesA(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chartA.render();
        }

        function toggleDataSeriesB(e) {
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chartB.render();
        }
    </script>
</body>

</html>