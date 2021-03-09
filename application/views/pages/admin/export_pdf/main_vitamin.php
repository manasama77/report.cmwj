<script>
    const monthNamesLong = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const monthNamesShort = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    $(document).ready(function() {

        $('#jenis_data').on('click', () => {
            if ($('#jenis_data').val() == "chart") {
                $('#id_area_3').attr('disabled', true).prop('checked', false);
            } else {
                $('#id_area_3').attr('disabled', false);
            }
        });

        $('#form_filter').on('submit', (e) => {
            e.preventDefault();
            if ($('div.form-check :checkbox:checked').length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silahkan pilih area minimal 1 area',
                })
            } else if ($('div.form-check :checkbox:checked').length > 0) {
                filterData();
            }
        });

        $('#btn_export_pdf_alarm_history').on('click', function() {
            let id_area = [];
            let area = "";

            id_area = $('.carea:checkbox:checked').map((_, el) => {
                return $(el).val();
            }).get().sort();

            $.each(id_area, function(i, k) {
                area += k;
            });

            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            window.open(`<?= site_url(); ?>export_pdf_alarm_history/${area}/${from_date}/${to_date}`, '_blank');
        });

        $('#btn_export_pdf_chart_history').on('click', function() {
            let id_area = [];
            let area = "";

            id_area = $('.carea:checkbox:checked').map((_, el) => {
                return $(el).val();
            }).get().sort();
            let id_area_kirim = id_area;

            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            window.scrollTo(0, 0);
            // window.document.getElementById('canvas_all').scrollIntoView();

            $.each(id_area, function(i, k) {
                area += k;

                if (k == 1) {
                    var element1 = window.document.getElementById("group_wwt1");
                    html2canvas(element1, {
                        scrollX: 0,
                        scrollY: 0,
                        scale: 4,
                    }).then(function(canvas) {
                        var img1 = canvas.toDataURL();
                        $('#canvash_wwt1').val(img1);
                    });
                }

                if (k == 2) {
                    var element2 = window.document.getElementById("group_wwt2");
                    html2canvas(element2, {
                        scrollX: 0,
                        scrollY: 0,
                        scale: 4,
                    }).then(function(canvas) {
                        var img2 = canvas.toDataURL();
                        $('#canvash_wwt2').val(img2);
                    });
                }

                if (k == 4) {
                    var element3 = window.document.getElementById("group_mixbed");
                    html2canvas(element3, {
                        scrollX: 0,
                        scrollY: 0,
                        scale: 4,
                    }).then(function(canvas) {
                        var img3 = canvas.toDataURL();
                        $('#canvash_mixbed').val(img3);
                    });
                }

                if (k == 5) {
                    var element4 = window.document.getElementById("group_diro");
                    html2canvas(element4, {
                        scrollX: 0,
                        scrollY: 0,
                        scale: 4,
                    }).then(function(canvas) {
                        var img4 = canvas.toDataURL();
                        $('#canvash_diro').val(img4);
                    });
                }
            });

            $('#areah').val(id_area_kirim);
            $('#from_dateh').val(from_date);
            $('#to_dateh').val(to_date);

            setTimeout(function() {
                $('#invisible_form').trigger('submit');
            }, 2000);

        });
    });

    function filterData() {
        let id_area = [];
        id_area = $('.carea:checkbox:checked').map((_, el) => {
            return $(el).val();
        }).get();

        let jenis_data = $('#jenis_data').val();
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let data = {
            id_area: id_area,
            jenis_data: jenis_data,
            from_date: from_date,
            to_date: to_date
        }

        if (jenis_data == "alarm") {
            $.ajax({
                url: '<?= site_url(); ?>alarmhistory/show',
                method: 'post',
                dataType: 'json',
                data: data,
                beforeSend: function() {
                    $.blockUI();
                    $('#collapse_alarm').collapse('hide');
                    $('#collapse_chart').collapse('hide');
                }
            }).always(function() {
                $.unblockUI();
            }).fail(function(e) {
                console.log(e);
            }).done(function(e) {
                let htmlnya = '';
                let no = 1;
                let datetimeFrom = new Date($('#from_date').val());
                let datetimeTo = new Date($('#to_date').val());

                fromDay = datetimeFrom.getDate();
                fromMonth = monthNamesShort[datetimeFrom.getMonth()];
                fromYear = datetimeFrom.getFullYear();
                fromHour = datetimeFrom.getHours();
                fromMinute = datetimeFrom.getMinutes();
                fromDate = fromDay + "-" + fromMonth + "-" + fromYear + " " + fromHour + ":" + fromMinute;

                toDay = datetimeTo.getDate();
                toMonth = monthNamesShort[datetimeTo.getMonth()];
                toYear = datetimeTo.getFullYear();
                toHour = datetimeTo.getHours();
                toMinute = datetimeTo.getMinutes();
                toDate = toDay + "-" + toMonth + "-" + toYear + " " + toHour + ":" + toMinute;

                $('#current_datetime').html(fromDate + " - " + toDate);

                if (e.data.length > 0) {
                    if (e.data.length > 0) {
                        $.each(e.data, function(i, k) {
                            let color = "";
                            let area = "";

                            if (k.group == "1") {
                                area = "WWT-01";
                            } else if (k.group == "2") {
                                area = "WWT-02";
                            } else if (k.group == "3") {
                                area = "PUMP ROOM";
                            } else if (k.group == "4") {
                                area = "MIXBED";
                            } else if (k.group == "5") {
                                area = "DI-RO";
                            }
                            htmlnya += `
                            <tr>
                                <td class="${color} text-center">${no}</td>
                                <td class="${color} text-center">${area}</td>
                                <td class="${color} text-center">${k.message}</td>
                                <td class="${color} text-center">${k.start_date} ${k.start_time}</td>
                                <td class="${color} text-center">${k.stop_date} ${k.stop_time}</td>
                                <td class="${color} text-center">${k.durasi} Minute</td>
                            </tr>
                            `;

                            no++;
                        });
                    }
                } else {
                    htmlnya = `
                        <tr>
                            <td colspan="6" class="text-center">Data Not Found</td>
                        </tr>
                        `;
                }

                $('#vresult').html(htmlnya);
                setTimeout(() => {
                    $('#collapse_alarm').collapse('show');
                    setTimeout(() => {
                        window.scrollTo(0, document.querySelector("body").scrollHeight);
                    }, 300)
                }, 500);

                console.log("colapse show")
            });
        } else if (jenis_data == "chart") {
            let tglObjFX = new Date(from_date);
            let yearFX = tglObjFX.getFullYear();
            let monthFX = tglObjFX.toLocaleString('default', {
                month: 'long'
            });
            let dayFX = tglObjFX.getDate();
            let hoursFX = tglObjFX.getHours();
            let minutesFX = tglObjFX.getMinutes();
            let FXISO = dayFX + "-" + monthFX + "-" + yearFX + " " + hoursFX + ":" + minutesFX;

            let tglObjTX = new Date(to_date);
            let yearTX = tglObjTX.getFullYear();
            let monthTX = tglObjTX.toLocaleString('default', {
                month: 'long'
            });
            let dayTX = tglObjTX.getDate();
            let hoursTX = tglObjTX.getHours();
            let minutesTX = tglObjTX.getMinutes();
            let TXISO = dayTX + "-" + monthTX + "-" + yearTX + " " + hoursTX + ":" + minutesTX;

            $('#chart_title').html(`${FXISO} - ${TXISO}`);

            $('#collapse_alarm').collapse('hide');
            $('#collapse_chart').collapse('hide');

            $('#group_wwt1').hide();
            $('#group_wwt2').hide();
            $('#group_mixbed').hide();
            $('#group_diro').hide();

            $.each(id_area, function(i, k) {
                if (k == 1) {
                    runChartWWT1(data);
                }

                if (k == 2) {
                    runChartWWT2(data);
                }

                if (k == 4) {
                    runChartMixbed(data);
                }

                if (k == 5) {
                    runChartDIRO(data);
                }
            });

        }
    }

    function runChartWWT1(data) {
        $.ajax({
            url: '<?= site_url(); ?>chart/show_chart_wwt1',
            method: 'post',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $.blockUI();
                $('#group_wwt1').hide();
            }
        }).fail(function(e) {
            console.log(e);
            $.unblockUI();
        }).done(function(e) {
            initDataA(e);
            setTimeout(function() {
                $('#group_wwt1').show();
                $('#collapse_chart').collapse('show');
                setTimeout(function() {
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    $.unblockUI();
                }, 200);
            }, 300);
        });
    }

    function initDataA(e) {
        let updateInterval = 2000;

        let titleA = "pH-102";
        let initLengthA = 0;
        let latestLengthA = 0;
        let dataPoints1A = [];
        let dataPoints2A = [];
        let dataPoints3A = [];
        let dataPoints4A = [];
        let dataPoints5A = [];
        let legendHighA = [];
        let legendValueA;
        let legendLowA;
        let legendHHA;
        let legendLLA;
        let optionsA = [];

        let titleB = "pH-107";
        let initLengthB = 0;
        let latestLengthB = 0;
        let dataPoints1B = [];
        let dataPoints2B = [];
        let dataPoints3B = [];
        let dataPoints4B = [];
        let dataPoints5B = [];
        let legendHighB = [];
        let legendValueB;
        let legendLowB;
        let legendHHB;
        let legendLLB;
        let optionsB = [];

        ////////////////////////////////////////////
        initLengthA = e.data1.length;
        if (initLengthA > 0) {
            $.each(e.data1, (i, k) => {
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

                dataPoints4A.push({
                    x: tglObjA.getTime(),
                    y: parseFloat(k.hh_data),
                });

                dataPoints5A.push({
                    x: tglObjA.getTime(),
                    y: parseFloat(k.ll_data),
                });

                legendHighA = k.high_data;
                legendValueA = k.value_data;
                legendLowA = k.low_data;
                legendHHA = k.hh_data;
                legendLLA = k.ll_data;
            });
        }

        optionsA = {
            data: [{
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                indexLabelFontSize: 20,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "High",
                dataPoints: dataPoints1A,
            }, {
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints2A,
            }, {
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Low",
                dataPoints: dataPoints3A,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "HH",
                dataPoints: dataPoints4A,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "LL",
                dataPoints: dataPoints5A,
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
                valueFormatString: "D-M-YY HH:mm",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                suffix: "",
                lineColor: "rgba(105,105,105,.8)",
                gridColor: "rgba(105,105,105,.8)",
                minimum: 4,
                maximum: 12,
            },
            toolTip: {
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
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
        optionsA.data[3].legendText = "HH : " + legendHHA + "";
        optionsA.data[4].legendText = "LL : " + legendLLA + "";

        chartA = new CanvasJS.Chart("chartContainerA", optionsA);
        ////////////////////////////////////////////

        ////////////////////////////////////////////
        initLengthB = e.data2.length;
        if (initLengthB > 0) {
            $.each(e.data2, (i, k) => {
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

                dataPoints4B.push({
                    x: tglObjB.getTime(),
                    y: parseFloat(k.hh_data),
                });

                dataPoints5B.push({
                    x: tglObjB.getTime(),
                    y: parseFloat(k.ll_data),
                });

                legendHighB = k.high_data;
                legendValueB = k.value_data;
                legendLowB = k.low_data;
                legendHHB = k.hh_data;
                legendLLB = k.ll_data;
            });
        }

        optionsB = {
            data: [{
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                indexLabelFontSize: 20,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "High",
                dataPoints: dataPoints1B,
            }, {
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints2B,
            }, {
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Low",
                dataPoints: dataPoints3B,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "HH",
                dataPoints: dataPoints4B,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "LL",
                dataPoints: dataPoints5B,
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
                valueFormatString: "D-M-YY HH:mm",
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
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
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
        optionsB.data[3].legendText = "HH : " + legendHHB + "";
        optionsB.data[4].legendText = "LL : " + legendLLB + "";

        chartB = new CanvasJS.Chart("chartContainerB", optionsB);
        ////////////////////////////////////////////

        setTimeout(function() {
            chartA.render();
            chartB.render();
        }, 800);
    }

    function runChartWWT2(data) {
        $.ajax({
            url: '<?= site_url(); ?>chart/show_chart_wwt2',
            method: 'post',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $.blockUI();
                $('#group_wwt2').hide();
            }
        }).fail(function(e) {
            console.log(e);
            $.unblockUI();
        }).done(function(e) {
            initDataB(e);
            setTimeout(function() {
                $('#group_wwt2').show();
                $('#collapse_chart').collapse('show');
                setTimeout(function() {
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    $.unblockUI();
                }, 200);
            }, 300);
        });
    }

    function initDataB(e) {
        let updateInterval = 2000;

        let titleC = "pH-302";
        let initLengthC = 0;
        let latestLengthC = 0;
        let dataPoints1C = [];
        let dataPoints2C = [];
        let dataPoints3C = [];
        let dataPoints4C = [];
        let dataPoints5C = [];
        let legendHighC = [];
        let legendValueC;
        let legendLowC;
        let legendHHC;
        let legendLLC;
        let optionsC = [];

        let titleD = "pH-307";
        let initLengthD = 0;
        let latestLengthD = 0;
        let dataPoints1D = [];
        let dataPoints2D = [];
        let dataPoints3D = [];
        let dataPoints4D = [];
        let dataPoints5D = [];
        let legendHighD = [];
        let legendValueD;
        let legendLowD;
        let legendHHD;
        let legendLLD;
        let optionsD = [];

        let titleE = "FIQ-101A";
        let initLengthE = 0;
        let latestLengthE = 0;
        let dataPoints1E = [];
        let legendValueE;
        let optionsE = [];

        ////////////////////////////////////////////
        initLengthC = e.data1.length;
        if (initLengthC > 0) {
            $.each(e.data1, (i, k) => {
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

                dataPoints4C.push({
                    x: tglObjC.getTime(),
                    y: parseFloat(k.hh_data),
                });

                dataPoints5C.push({
                    x: tglObjC.getTime(),
                    y: parseFloat(k.ll_data),
                });

                legendHighC = k.high_data;
                legendValueC = k.value_data;
                legendLowC = k.low_data;
                legendHHC = k.hh_data;
                legendLLC = k.ll_data;
            });
        }

        optionsC = {
            data: [{
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                indexLabelFontSize: 20,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "High",
                dataPoints: dataPoints1C,
            }, {
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints2C,
            }, {
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Low",
                dataPoints: dataPoints3C,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "HH",
                dataPoints: dataPoints4C,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "LL",
                dataPoints: dataPoints5C,
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
                valueFormatString: "D-M-YY HH:mm",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                suffix: "",
                lineColor: "rgba(105,105,105,.8)",
                gridColor: "rgba(105,105,105,.8)",
                minimum: 4,
                maximum: 12,
            },
            toolTip: {
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
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
        optionsC.data[3].legendText = "HH : " + legendHHC + "";
        optionsC.data[4].legendText = "LL : " + legendLLC + "";

        chartC = new CanvasJS.Chart("chartContainerC", optionsC);
        ////////////////////////////////////////////

        ////////////////////////////////////////////
        initLengthD = e.data2.length;
        if (initLengthD > 0) {
            $.each(e.data2, (i, k) => {
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

                dataPoints4D.push({
                    x: tglObjD.getTime(),
                    y: parseFloat(k.hh_data),
                });

                dataPoints5D.push({
                    x: tglObjD.getTime(),
                    y: parseFloat(k.ll_data),
                });

                legendHighD = k.high_data;
                legendValueD = k.value_data;
                legendLowD = k.low_data;
                legendHHD = k.hh_data;
                legendLLD = k.ll_data;
            });
        }

        optionsD = {
            data: [{
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                indexLabelFontSize: 20,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "High",
                dataPoints: dataPoints1D,
            }, {
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints2D,
            }, {
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Low",
                dataPoints: dataPoints3D,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "HH",
                dataPoints: dataPoints4D,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "LL",
                dataPoints: dataPoints5D,
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
                valueFormatString: "D-M-YY HH:mm",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                suffix: "",
                lineColor: "rgba(105,105,105,.8)",
                gridColor: "rgba(105,105,105,.8)",
                minimum: 4,
                maximum: 12,
            },
            toolTip: {
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
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
        optionsD.data[3].legendText = "HH : " + legendHHD + "";
        optionsD.data[4].legendText = "LL : " + legendLLD + "";

        chartD = new CanvasJS.Chart("chartContainerD", optionsD);
        ////////////////////////////////////////////

        ////////////////////////////////////////////
        initLengthE = e.data2.length;
        if (initLengthE > 0) {
            $.each(e.data3, (i, k) => {
                let tglObjE = new Date(k.created_at);

                dataPoints1E.push({
                    x: tglObjE.getTime(),
                    y: parseFloat(k.value_data),
                });

                legendValueE = k.value_data;
            });
        }

        optionsE = {
            data: [{
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints1E,
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
                valueFormatString: "HH:mm",
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
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
                    for (let i = 0; i < e.entries.length; i++) {
                        content += `<tr><td>`;
                        content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                        content += `</td><td style="text-align: right; padding-left: 5px;">`;
                        content += `<strong> ${e.entries[i].dataPoint.y} m³/h</strong>`;
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

        optionsE.data[0].legendText = "Value : " + legendValueE + " m³/h";

        chartE = new CanvasJS.Chart("chartContainerE", optionsE);
        ////////////////////////////////////////////

        setTimeout(function() {
            chartC.render();
            chartD.render();
            chartE.render();
        }, 800);
    }

    function runChartMixbed(data) {
        $.ajax({
            url: '<?= site_url(); ?>chart/show_chart_mixbed',
            method: 'post',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $.blockUI();
                $('#group_mixbed').hide();
            }
        }).fail(function(e) {
            console.log(e);
            $.unblockUI();
        }).done(function(e) {
            initDataC(e);
            setTimeout(function() {
                $('#group_mixbed').show();
                $('#collapse_chart').collapse('show');
                setTimeout(function() {
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    $.unblockUI();
                }, 200);
            }, 300);
        });
    }

    function initDataC(e) {
        let updateInterval = 2000;

        let titleF = "CIA-1";
        let initLengthF = 0;
        let latestLengthF = 0;
        let dataPoints1F = [];
        let dataPoints2F = [];
        let dataPoints3F = [];
        let dataPoints4F = [];
        let dataPoints5F = [];
        let legendHighF = [];
        let legendValueF;
        let legendLowF;
        let legendHHF;
        let legendLLF;
        let optionsF = [];

        ////////////////////////////////////////////
        initLengthF = e.data1.length;
        if (initLengthF > 0) {
            $.each(e.data1, (i, k) => {
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

                dataPoints4F.push({
                    x: tglObjF.getTime(),
                    y: parseFloat(k.hh_data),
                });

                dataPoints5F.push({
                    x: tglObjF.getTime(),
                    y: parseFloat(k.ll_data),
                });

                legendHighF = k.high_data;
                legendValueF = k.value_data;
                legendLowF = k.low_data;
                legendHHF = k.hh_data;
                legendLLF = k.ll_data;
            });
        }

        optionsF = {
            data: [{
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                indexLabelFontSize: 20,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "High",
                dataPoints: dataPoints1F,
            }, {
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints2F,
            }, {
                type: "spline",
                lineDashType: "dash",
                color: "blue",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Low",
                dataPoints: dataPoints3F,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "HH",
                dataPoints: dataPoints4F,
            }, {
                type: "spline",
                color: "red",
                showInLegend: true,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "LL",
                dataPoints: dataPoints5F,
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
                valueFormatString: "HH:mm",
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
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
                    for (let i = 0; i < e.entries.length; i++) {
                        content += `<tr><td>`;
                        content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                        content += `</td><td style="text-align: right; padding-left: 5px;">`;
                        content += `<strong> ${e.entries[i].dataPoint.y} uS/cm</strong>`;
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

        optionsF.data[0].legendText = "High : " + legendHighF + " uS/cm";
        optionsF.data[1].legendText = "Value : " + legendValueF + " uS/cm";
        optionsF.data[2].legendText = "Low : " + legendLowF + " uS/cm";
        optionsF.data[3].legendText = "HH : " + legendHHF + " uS/cm";
        optionsF.data[4].legendText = "LL : " + legendLLF + " uS/cm";

        chartF = new CanvasJS.Chart("chartContainerF", optionsF);
        ////////////////////////////////////////////

        setTimeout(function() {
            chartF.render();
        }, 800);
    }

    function runChartDIRO(data) {
        $.ajax({
            url: '<?= site_url(); ?>chart/show_chart_diro',
            method: 'post',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $.blockUI();
                $('#group_diro').hide();
            }
        }).fail(function(e) {
            console.log(e);
            $.unblockUI();
        }).done(function(e) {
            initDataD(e);
            setTimeout(function() {
                $('#group_diro').show();
                $('#collapse_chart').collapse('show');
                setTimeout(function() {
                    window.scrollTo(0, document.querySelector("body").scrollHeight);
                    $.unblockUI();
                }, 300);
            }, 300);
        });
    }

    function initDataD(e) {
        let updateInterval = 2000;

        let titleG = "CIA-DI";
        let initLengthG = 0;
        let latestLengthG = 0;
        let dataPoints1G = [];
        let legendValueG;
        let optionsG = [];

        let titleH = "CIA-RO";
        let initLengthH = 0;
        let latestLengthH = 0;
        let dataPoints1H = [];
        let legendValueH;
        let optionsH = [];

        ////////////////////////////////////////////
        initLengthG = e.data1.length;
        if (initLengthG > 0) {
            $.each(e.data1, (i, k) => {
                let tglObjG = new Date(k.created_at);

                dataPoints1G.push({
                    x: tglObjG.getTime(),
                    y: parseFloat(k.value_data),
                });

                legendValueG = k.value_data;
            });
        }

        optionsG = {
            data: [{
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints1G,
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
                valueFormatString: "HH:mm",
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
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
                    for (let i = 0; i < e.entries.length; i++) {
                        content += `<tr><td>`;
                        content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                        content += `</td><td style="text-align: right; padding-left: 5px;">`;
                        content += `<strong> ${e.entries[i].dataPoint.y} uS/cm</strong>`;
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

        optionsG.data[0].legendText = "Value : " + legendValueG + " uS/cm";

        chartG = new CanvasJS.Chart("chartContainerG", optionsG);
        ////////////////////////////////////////////

        ////////////////////////////////////////////
        initLengthH = e.data2.length;
        if (initLengthH > 0) {
            $.each(e.data2, (i, k) => {
                let tglObjH = new Date(k.created_at);

                dataPoints1H.push({
                    x: tglObjH.getTime(),
                    y: parseFloat(k.value_data),
                });

                legendValueH = k.value_data;
            });
        }

        optionsH = {
            data: [{
                type: "spline",
                color: "black",
                showInLegend: true,
                indexLabelFontSize: 22,
                xValueType: "dateTime",
                xValueFormatString: "D-M-YY HH:mm",
                yValueFormatString: "###.00",
                name: "Value",
                dataPoints: dataPoints1H,
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
                valueFormatString: "HH:mm",
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
                enabled: true,
                shared: true,
                labelFontFamily: "Arial",
                fontStyle: "normal",
                labelFontSize: 10,
                borderThickness: 1,
                cornerRadius: 5,
                borderColor: "#666",
                contentFormatter: function(e) {
                    let content = `<div style="width: 100%; font-weight: bold; text-align: right;">${CanvasJS.formatDate(e.entries[0].dataPoint.x, "D-M-YY HH:mm")}</div><table>`;
                    for (let i = 0; i < e.entries.length; i++) {
                        content += `<tr><td>`;
                        content += `<span style="color: ${e.entries[i].dataSeries.color};">&#9632;</span> ${e.entries[i].dataSeries.name}`;
                        content += `</td><td style="text-align: right; padding-left: 5px;">`;
                        content += `<strong> ${e.entries[i].dataPoint.y} uS/cm</strong>`;
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

        optionsH.data[0].legendText = "Value : " + legendValueH + " uS/cm";

        chartH = new CanvasJS.Chart("chartContainerH", optionsH);
        ////////////////////////////////////////////

        setTimeout(function() {
            chartG.render();
            chartH.render();
        }, 800);
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
        chartG.render();
    }

    function toggleDataSeriesH(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        } else {
            e.dataSeries.visible = true;
        }
        chartH.render();
    }
</script>