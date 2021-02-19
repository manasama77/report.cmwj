<script>
    let updateInterval = 2000;

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

    let titleC = "pH-302";
    let initLengthC = 0;
    let latestLengthC = 0;
    let dataPoints1C = [];
    let dataPoints2C = [];
    let dataPoints3C = [];
    let legendHighC = [];
    let legendValueC;
    let legendLowC;
    let optionsC = [];

    let titleD = "pH-307";
    let initLengthD = 0;
    let latestLengthD = 0;
    let dataPoints1D = [];
    let dataPoints2D = [];
    let dataPoints3D = [];
    let legendHighD = [];
    let legendValueD;
    let legendLowD;
    let optionsD = [];

    let titleE = "FIQ-101A";
    let initLengthE = 0;
    let latestLengthE = 0;
    let dataPoints1E = [];
    let dataPoints2E = [];
    let dataPoints3E = [];
    let legendHighE = [];
    let legendValueE;
    let legendLowE;
    let optionsE = [];

    let titleF = "CIA-1";
    let initLengthF = 0;
    let latestLengthF = 0;
    let dataPoints1F = [];
    let dataPoints2F = [];
    let dataPoints3F = [];
    let legendHighF = [];
    let legendValueF;
    let legendLowF;
    let optionsF = [];

    let titleG = "CIA-A";
    let initLengthG = 0;
    let latestLengthG = 0;
    let dataPoints1G = [];
    let dataPoints2G = [];
    let dataPoints3G = [];
    let legendHighG = [];
    let legendValueG;
    let legendLowG;
    let optionsG = [];

    let titleH = "CIA-B";
    let initLengthH = 0;
    let latestLengthH = 0;
    let dataPoints1H = [];
    let dataPoints2H = [];
    let dataPoints3H = [];
    let legendHighH = [];
    let legendValueH;
    let legendLowH;
    let optionsH = [];

    $(document).ready(() => {
        initDataA();
        initDataB();
        initDataC();
        initDataD();
        initDataE();
        initDataF();
        initDataG();
        initDataH();
        setInterval(() => {
            latestDataA();
            latestDataB();
            latestDataC();
            latestDataD();
            latestDataE();
            latestDataF();
            latestDataG();
            latestDataH();
        }, updateInterval);

        $('#wwt01').on('shown.bs.tab', (e) => {
            initDataA();
            initDataB();
        });

        $('#wwt02').on('shown.bs.tab', (e) => {
            initDataC();
            initDataD();
            initDataE();
        });

        $('#mixbed').on('shown.bs.tab', (e) => {
            initDataF();
        });

        $('#diro').on('shown.bs.tab', (e) => {
            initDataG();
            initDataH();
        });
    });

    function initDataA() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph102',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1A = [];
                dataPoints2A = [];
                dataPoints3A = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
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

    function latestDataA() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph102',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1A = [];
                dataPoints2A = [];
                dataPoints3A = [];
                optionsA = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthA = e.data.length;

            if (latestLengthA > 0) {
                if (latestLengthA > initLengthA) {
                    $.blockUI();
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

                    (new CanvasJS.Chart("chartContainerA", optionsA)).render();
                    $.unblockUI();
                    // chartA.render();
                    initLengthA = latestLengthA;
                } else if (initLengthA > latestLengthA) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataB() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph103',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1B = [];
                dataPoints2B = [];
                dataPoints3B = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
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

    function latestDataB() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph103',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1B = [];
                dataPoints2B = [];
                dataPoints3B = [];
                optionsB = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            console.log("aa");
            console.log(e);
            latestLengthB = e.data.length;

            if (latestLengthB > 0) {
                if (latestLengthB > initLengthB) {
                    $.blockUI();
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

                    (new CanvasJS.Chart("chartContainerB", optionsB)).render();
                    $.unblockUI();
                    // chartA.render();
                    initLengthB = latestLengthB;
                } else if (initLengthB > latestLengthB) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataC() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph302',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1C = [];
                dataPoints2C = [];
                dataPoints3C = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthC = e.data.length;

            if (initLengthC > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjC = new Date(k.created_at);

                    dataPoints1C.push({
                        x: tglObjC.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2C.push({
                        x: tglObjC.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3C.push({
                        x: tglObjC.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighC = k.high_data;
                    legendValueC = k.value_data;
                    legendLowC = k.low_data;
                });
            }

            optionsC = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1C,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2C,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3C,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleC,
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
                    itemclick: toggleDataSeriesC
                },
            };

            optionsC.data[0].legendText = "High : " + legendHighC + "";
            optionsC.data[1].legendText = "Value : " + legendValueC + "";
            optionsC.data[2].legendText = "Low : " + legendLowC + "";

            chartC = new CanvasJS.Chart("chartContainerC", optionsC);
            chartC.render();
        });
    }

    function latestDataC() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph302',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1C = [];
                dataPoints2C = [];
                dataPoints3C = [];
                optionsC = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthC = e.data.length;

            if (latestLengthC > 0) {
                if (latestLengthC > initLengthC) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjC = new Date(k.created_at);

                        dataPoints1C.push({
                            x: tglObjC.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2C.push({
                            x: tglObjC.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3C.push({
                            x: tglObjC.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighC = k.high_data;
                        legendValueC = k.value_data;
                        legendLowC = k.low_data;
                    });

                    optionsC = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1C,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2C,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3C,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleC,
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
                            itemclick: toggleDataSeriesC
                        },
                    };

                    optionsC.data[0].legendText = "High : " + legendHighC + "";
                    optionsC.data[1].legendText = "Value : " + legendValueC + "";
                    optionsC.data[2].legendText = "Low : " + legendLowC + "";

                    (new CanvasJS.Chart("chartContainerC", optionsC)).render();
                    $.unblockUI();
                    // chartC.render();
                    initLengthC = latestLengthC;
                } else if (initLengthC > latestLengthC) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataD() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph307',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1D = [];
                dataPoints2D = [];
                dataPoints3D = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthD = e.data.length;

            if (initLengthD > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjD = new Date(k.created_at);

                    dataPoints1D.push({
                        x: tglObjD.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2D.push({
                        x: tglObjD.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3D.push({
                        x: tglObjD.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighD = k.high_data;
                    legendValueD = k.value_data;
                    legendLowD = k.low_data;
                });
            }

            optionsD = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1D,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2D,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3D,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleD,
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
                    itemclick: toggleDataSeriesD
                },
            };

            optionsD.data[0].legendText = "High : " + legendHighD + "";
            optionsD.data[1].legendText = "Value : " + legendValueD + "";
            optionsD.data[2].legendText = "Low : " + legendLowD + "";

            chartD = new CanvasJS.Chart("chartContainerD", optionsD);
            chartD.render();
        });
    }

    function latestDataD() {
        $.ajax({
            url: '<?= site_url(); ?>get_ph307',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1D = [];
                dataPoints2D = [];
                dataPoints3D = [];
                optionsD = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthD = e.data.length;

            if (latestLengthD > 0) {
                if (latestLengthD > initLengthD) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjD = new Date(k.created_at);

                        dataPoints1D.push({
                            x: tglObjD.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2D.push({
                            x: tglObjD.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3D.push({
                            x: tglObjD.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighD = k.high_data;
                        legendValueD = k.value_data;
                        legendLowD = k.low_data;
                    });

                    optionsD = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1D,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2D,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3D,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleD,
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
                            itemclick: toggleDataSeriesC
                        },
                    };

                    optionsD.data[0].legendText = "High : " + legendHighD + "";
                    optionsD.data[1].legendText = "Value : " + legendValueD + "";
                    optionsD.data[2].legendText = "Low : " + legendLowD + "";

                    (new CanvasJS.Chart("chartContainerD", optionsD)).render();
                    $.unblockUI();
                    // chartD.render();
                    initLengthD = latestLengthD;
                } else if (initLengthD > latestLengthD) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataE() {
        $.ajax({
            url: '<?= site_url(); ?>get_fiq101a',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1E = [];
                dataPoints2E = [];
                dataPoints3E = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthE = e.data.length;

            if (initLengthE > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjE = new Date(k.created_at);

                    dataPoints1E.push({
                        x: tglObjE.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2E.push({
                        x: tglObjE.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3E.push({
                        x: tglObjE.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighE = k.high_data;
                    legendValueE = k.value_data;
                    legendLowE = k.low_data;
                });
            }

            optionsE = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1E,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2E,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3E,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleE,
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
                    itemclick: toggleDataSeriesE
                },
            };

            optionsE.data[0].legendText = "High : " + legendHighE + "";
            optionsE.data[1].legendText = "Value : " + legendValueE + "";
            optionsE.data[2].legendText = "Low : " + legendLowE + "";

            chartE = new CanvasJS.Chart("chartContainerE", optionsE);
            chartE.render();
        });
    }

    function latestDataE() {
        $.ajax({
            url: '<?= site_url(); ?>get_fiq101a',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1E = [];
                dataPoints2E = [];
                dataPoints3E = [];
                optionsE = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthE = e.data.length;

            if (latestLengthE > 0) {
                if (latestLengthE > initLengthE) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjE = new Date(k.created_at);

                        dataPoints1E.push({
                            x: tglObjE.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2E.push({
                            x: tglObjE.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3E.push({
                            x: tglObjE.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighE = k.high_data;
                        legendValueE = k.value_data;
                        legendLowE = k.low_data;
                    });

                    optionsE = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1E,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2E,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3E,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleE,
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
                            itemclick: toggleDataSeriesE
                        },
                    };

                    optionsE.data[0].legendText = "High : " + legendHighE + "";
                    optionsE.data[1].legendText = "Value : " + legendValueE + "";
                    optionsE.data[2].legendText = "Low : " + legendLowE + "";

                    (new CanvasJS.Chart("chartContainerE", optionsE)).render();
                    $.unblockUI();
                    // chartE.render();
                    initLengthE = latestLengthE;
                } else if (initLengthE > latestLengthE) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataF() {
        $.ajax({
            url: '<?= site_url(); ?>get_cia1',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1F = [];
                dataPoints2F = [];
                dataPoints3F = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthF = e.data.length;

            if (initLengthF > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjF = new Date(k.created_at);

                    dataPoints1F.push({
                        x: tglObjF.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2F.push({
                        x: tglObjF.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3F.push({
                        x: tglObjF.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighF = k.high_data;
                    legendValueF = k.value_data;
                    legendLowF = k.low_data;
                });
            }

            optionsF = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1F,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2F,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3F,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleF,
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
                    itemclick: toggleDataSeriesF
                },
            };

            optionsF.data[0].legendText = "High : " + legendHighF + "";
            optionsF.data[1].legendText = "Value : " + legendValueF + "";
            optionsF.data[2].legendText = "Low : " + legendLowF + "";

            chartF = new CanvasJS.Chart("chartContainerF", optionsF);
            chartF.render();
        });
    }

    function latestDataF() {
        $.ajax({
            url: '<?= site_url(); ?>get_cia1',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1F = [];
                dataPoints2F = [];
                dataPoints3F = [];
                optionsF = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthF = e.data.length;

            if (latestLengthF > 0) {
                if (latestLengthF > initLengthF) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjF = new Date(k.created_at);

                        dataPoints1F.push({
                            x: tglObjF.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2F.push({
                            x: tglObjF.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3F.push({
                            x: tglObjF.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighF = k.high_data;
                        legendValueF = k.value_data;
                        legendLowF = k.low_data;
                    });

                    optionsF = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1F,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2F,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3F,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleF,
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
                            itemclick: toggleDataSeriesF
                        },
                    };

                    optionsF.data[0].legendText = "High : " + legendHighF + "";
                    optionsF.data[1].legendText = "Value : " + legendValueF + "";
                    optionsF.data[2].legendText = "Low : " + legendLowF + "";

                    (new CanvasJS.Chart("chartContainerF", optionsF)).render();
                    $.unblockUI();
                    // chartF.render();
                    initLengthF = latestLengthF;
                } else if (initLengthF > latestLengthF) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataG() {
        $.ajax({
            url: '<?= site_url(); ?>get_ciaa',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1G = [];
                dataPoints2G = [];
                dataPoints3G = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthG = e.data.length;

            if (initLengthG > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjG = new Date(k.created_at);

                    dataPoints1G.push({
                        x: tglObjG.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2G.push({
                        x: tglObjG.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3G.push({
                        x: tglObjG.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighG = k.high_data;
                    legendValueG = k.value_data;
                    legendLowG = k.low_data;
                });
            }

            optionsG = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1G,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2G,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3G,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleG,
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
                    itemclick: toggleDataSeriesG
                },
            };

            optionsG.data[0].legendText = "High : " + legendHighG + "";
            optionsG.data[1].legendText = "Value : " + legendValueG + "";
            optionsG.data[2].legendText = "Low : " + legendLowG + "";

            chartG = new CanvasJS.Chart("chartContainerG", optionsG);
            chartG.render();
        });
    }

    function latestDataG() {
        $.ajax({
            url: '<?= site_url(); ?>get_ciaa',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1G = [];
                dataPoints2G = [];
                dataPoints3G = [];
                optionsG = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthG = e.data.length;

            if (latestLengthG > 0) {
                if (latestLengthG > initLengthG) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjG = new Date(k.created_at);

                        dataPoints1G.push({
                            x: tglObjG.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2G.push({
                            x: tglObjG.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3G.push({
                            x: tglObjG.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighG = k.high_data;
                        legendValueG = k.value_data;
                        legendLowG = k.low_data;
                    });

                    optionsG = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1G,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2G,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3G,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleG,
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
                            itemclick: toggleDataSeriesG
                        },
                    };

                    optionsG.data[0].legendText = "High : " + legendHighG + "";
                    optionsG.data[1].legendText = "Value : " + legendValueG + "";
                    optionsG.data[2].legendText = "Low : " + legendLowG + "";

                    (new CanvasJS.Chart("chartContainerG", optionsG)).render();
                    $.unblockUI();
                    // chartG.render();
                    initLengthG = latestLengthG;
                } else if (initLengthG > latestLengthG) {
                    window.location.reload();
                }

            }
        });
    }

    function initDataH() {
        $.ajax({
            url: '<?= site_url(); ?>get_ciab',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                $.blockUI();
                dataPoints1H = [];
                dataPoints2H = [];
                dataPoints3H = [];
            }
        }).always((e) => {
            $.unblockUI();
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            initLengthH = e.data.length;

            if (initLengthH > 0) {
                $.each(e.data, (i, k) => {
                    let tglObjH = new Date(k.created_at);

                    dataPoints1H.push({
                        x: tglObjH.getTime(),
                        y: parseFloat(k.high_data),
                    });

                    dataPoints2H.push({
                        x: tglObjH.getTime(),
                        y: parseFloat(k.value_data),
                    });

                    dataPoints3H.push({
                        x: tglObjH.getTime(),
                        y: parseFloat(k.low_data),
                    });

                    legendHighH = k.high_data;
                    legendValueH = k.value_data;
                    legendLowH = k.low_data;
                });
            }

            optionsH = {
                data: [{
                    type: "spline",
                    color: "red",
                    showInLegend: true,
                    indexLabelFontSize: 20,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "High",
                    dataPoints: dataPoints1H,
                }, {
                    type: "spline",
                    color: "green",
                    showInLegend: true,
                    indexLabelFontSize: 22,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Value",
                    dataPoints: dataPoints2H,
                }, {
                    type: "spline",
                    color: "grey",
                    showInLegend: true,
                    xValueType: "dateTime",
                    xValueFormatString: "hh:mm TT",
                    yValueFormatString: "###.00",
                    name: "Low",
                    dataPoints: dataPoints3H,
                }],
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: titleH,
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
                    itemclick: toggleDataSeriesH
                },
            };

            optionsH.data[0].legendText = "High : " + legendHighH + "";
            optionsH.data[1].legendText = "Value : " + legendValueH + "";
            optionsH.data[2].legendText = "Low : " + legendLowH + "";

            chartH = new CanvasJS.Chart("chartContainerH", optionsH);
            chartH.render();
        });
    }

    function latestDataH() {
        $.ajax({
            url: '<?= site_url(); ?>get_ciab',
            method: 'get',
            dataType: 'json',
            beforeSend: () => {
                dataPoints1H = [];
                dataPoints2H = [];
                dataPoints3H = [];
                optionsH = [];
            }
        }).always((e) => {
            //
        }).fail((e) => {
            console.log(e);
        }).done((e) => {
            latestLengthH = e.data.length;

            if (latestLengthH > 0) {
                if (latestLengthH > initLengthH) {
                    $.blockUI();
                    $.each(e.data, (i, k) => {
                        let tglObjH = new Date(k.created_at);

                        dataPoints1H.push({
                            x: tglObjH.getTime(),
                            y: parseFloat(k.high_data),
                        });

                        dataPoints2H.push({
                            x: tglObjH.getTime(),
                            y: parseFloat(k.value_data),
                        });

                        dataPoints3H.push({
                            x: tglObjH.getTime(),
                            y: parseFloat(k.low_data),
                        });

                        legendHighH = k.high_data;
                        legendValueH = k.value_data;
                        legendLowH = k.low_data;
                    });

                    optionsH = {
                        data: [{
                            type: "spline",
                            color: "red",
                            showInLegend: true,
                            indexLabelFontSize: 20,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "High",
                            dataPoints: dataPoints1H,
                        }, {
                            type: "spline",
                            color: "green",
                            showInLegend: true,
                            indexLabelFontSize: 22,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Value",
                            dataPoints: dataPoints2H,
                        }, {
                            type: "spline",
                            color: "grey",
                            showInLegend: true,
                            xValueType: "dateTime",
                            xValueFormatString: "hh:mm TT",
                            yValueFormatString: "###.00",
                            name: "Low",
                            dataPoints: dataPoints3H,
                        }],
                        theme: "light2",
                        zoomEnabled: true,
                        title: {
                            text: titleH,
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
                            itemclick: toggleDataSeriesH
                        },
                    };

                    optionsH.data[0].legendText = "High : " + legendHighH + "";
                    optionsH.data[1].legendText = "Value : " + legendValueH + "";
                    optionsH.data[2].legendText = "Low : " + legendLowH + "";

                    (new CanvasJS.Chart("chartContainerH", optionsH)).render();
                    $.unblockUI();
                    // chartH.render();
                    initLengthH = latestLengthH;
                } else if (initLengthH > latestLengthH) {
                    window.location.reload();
                }

            }
        });
    }


    //////////////////////////////////////////////////////////////////////////////////////////////
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

    function toggleDataSeriesC(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartC.render();
    }

    function toggleDataSeriesD(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartD.render();
    }

    function toggleDataSeriesE(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartE.render();
    }

    function toggleDataSeriesF(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartF.render();
    }

    function toggleDataSeriesG(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartF.render();
    }

    function toggleDataSeriesH(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartF.render();
    }
</script>