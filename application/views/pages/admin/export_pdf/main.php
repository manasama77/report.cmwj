<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 mt-4 mb-2">
            <div class="card text-white bg-info mb-3 shadow p-3 mb-5">
                <div class="card-header">
                    <h5 class="card-title font-weight-bold">
                        <i class="fas fa-file fa-fw"></i> Report
                    </h5>
                </div>
                <div class="card-body">
                    <form id="form_filter" class="form">
                        <div class="form-group">
                            <label for="jenis_data">Data Selection</label>
                            <select class="form-control form-control-sm shadow" id="jenis_data" name="jenis_data" required>
                                <option value="alarm">Table Alarm History</option>
                                <option value="chart">Chart</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input carea" type="checkbox" value="1" id="id_area_1" name="id_area[]">
                                        <label class="form-check-label" for="id_area_1">
                                            WWT-01
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input carea" type="checkbox" value="2" id="id_area_2" name="id_area[]">
                                        <label class="form-check-label" for="id_area_2">
                                            WWT-02
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input carea" type="checkbox" value="3" id="id_area_3" name="id_area[]">
                                        <label class="form-check-label" for="id_area_3">
                                            PUMP ROOM
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input carea" type="checkbox" value="4" id="id_area_4" name="id_area[]">
                                        <label class="form-check-label" for="id_area_4">
                                            MIXBED
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input carea" type="checkbox" value="5" id="id_area_5" name="id_area[]">
                                        <label class="form-check-label" for="id_area_5">
                                            DI-RO
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="from_date">From</label>
                            <input type="datetime-local" class="form-control form-control-sm shadow" id="from_date" name="from_date" required>
                        </div>
                        <div class="form-group">
                            <label for="to_date">To</label>
                            <input type="datetime-local" class="form-control form-control-sm shadow" id="to_date" name="to_date" required>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block shadow">
                            <i class="fas fa-search fa-fw"></i> Show
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 mt-4 mb-2">

            <div class="collapse" id="collapse_alarm">
                <div class="card text-dark bg-white p-2 mb-3 shadow p-0 mb-5">
                    <div class="card-body" id="area_export_alarm_history">
                        <img src="<?= base_url(); ?>assets/img/header_alarm_history.png" style="width: 100%;" />
                        <!-- <h1>Alarm History</h1> -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <caption>Alarm History <span id="current_datetime"></span></caption>
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 70px !important;">#</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Alarm</th>
                                        <th class="text-center">Start</th>
                                        <th class="text-center">Stop</th>
                                        <th class="text-center">Duration</th>
                                    </tr>
                                </thead>
                                <tbody id="vresult">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-block" id="btn_export_pdf_alarm_history">Export PDF</button>
                    </div>
                </div>
            </div>

            <div class="collapse" id="collapse_chart">
                <div class="card text-dark bg-white p-2 mb-3 shadow p-0 mb-5">
                    <div class="card-body" id="area_export_chart_history">
                        <img src="<?= base_url(); ?>assets/img/header_chart_history.png" style="width: 100%;" />
                        <!-- <h1>Alarm History</h1> -->
                        <div id="canvas_all">
                            <h5 id="chart_title"></h5>
                            <div id="group_wwt1" style="display: none;" tabindex="-1">
                                <div id="chartContainerA" style="height: 300px; width: 100%;"></div>
                                <div class="white_block">&nbsp;</div>
                                <br>
                                <div id="chartContainerB" style="height: 300px; width: 100%;"></div>
                                <div class="white_block2">&nbsp;</div>
                                <br>
                            </div>
                            <div id="group_wwt2" style="display: none;">
                                <div id="chartContainerC" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block3">&nbsp;</div>
                                <br>
                                <div id="chartContainerD" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block4">&nbsp;</div>
                                <br>
                                <div id="chartContainerE" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block5">&nbsp;</div>
                                <br>
                            </div>
                            <div id="group_mixbed" style="display: none;">
                                <div id="chartContainerF" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block6">&nbsp;</div>
                                <br>
                            </div>
                            <div id="group_diro" style="display: none;">
                                <div id="chartContainerG" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block7">&nbsp;</div>
                                <br>
                                <div id="chartContainerH" style="height: 300px; width: 100%;" style="display: none;"></div>
                                <div class="white_block8">&nbsp;</div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-block" id="btn_export_pdf_chart_history">Export PDF</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="hform" style="display:none">
    <form id="invisible_form" action="<?= site_url(); ?>export_pdf_chart_history" method="post" target="_blank">
        <input id="canvash_wwt1" name="canvash_wwt1" type="hidden">
        <input id="canvash_wwt2" name="canvash_wwt2" type="hidden">
        <input id="canvash_mixbed" name="canvash_mixbed" type="hidden">
        <input id="canvash_diro" name="canvash_diro" type="hidden">
        <input id="areah" name="id_area" type="hidden">
        <input id="from_dateh" name="from_date" type="hidden">
        <input id="to_dateh" name="to_date" type="hidden">
    </form>
</div>