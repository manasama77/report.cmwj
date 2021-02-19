<?php
if ($from_human == $to_human) {
    echo '<p style="font-size: 30px;">Alarm History ' . $from_human . '</p>';
} else {
    echo '<p style="font-size: 30px;">Alarm History ' . $from_human . ' - ' . $to_human . '</p>';
}
?>
<table class="table table-bordered table-striped" style="font-size: 30px;">
    <thead>
        <tr>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">#</td>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">Area</td>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">Alarm</td>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">Start</td>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">Stop</td>
            <td class="text-center" style="vertical-align: middle; font-weight: bold; background-color: #ccc;">Duration</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($arr->num_rows() == 0) {
        ?>
            <tr>
                <td colspan="6" class="text-center">- Empty Data -</td>
            </tr>
        <?php
        } elseif ($arr->num_rows() > 0) {
        ?>
            <?php
            $no = 1;
            foreach ($arr->result() as $key) {
                $area       = "";
                $start_date = "";
                $start_time = "";
                $stop_time = "";

                if ($key->Al_Group == "1") {
                    $area = "WWT-01";
                } elseif ($key->Al_Group == "2") {
                    $area = "WWT-02";
                } elseif ($key->Al_Group == "3") {
                    $area = "PUMP ROOM";
                } elseif ($key->Al_Group == "4") {
                    $area = "MIXBED";
                } elseif ($key->Al_Group == "5") {
                    $area = "DI-RO";
                }


                if ($key->starttime) {
                    $start_obj = new DateTime($key->starttime);
                    $stop_obj = new DateTime($key->stoptime);

                    $start_date = $start_obj->format('d-M-y');
                    $start_time = $start_obj->format('H:i');

                    $stop_date = $stop_obj->format('d-M-y');
                    $stop_time = $stop_obj->format('H:i');
                }
            ?>
                <tr>
                    <td class="text-center"><?= $no; ?></td>
                    <td class="text-center"><?= $area; ?></td>
                    <td class="text-center"><?= $key->Al_Message; ?></td>
                    <td class="text-center"><?= $start_date; ?> <?= $start_time; ?></td>
                    <td class="text-center"><?= $stop_date; ?> <?= $stop_time; ?></td>
                    <td class="text-center"><?= round($key->durasi / 60); ?> Minute</td>
                </tr>
            <?php
                $no++;
            }
            ?>
        <?php
        }
        ?>
    </tbody>

</table>
<!-- jQuery -->
<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="<?= base_url(); ?>assets/js/bootstrap3.3.7.min.js"></script>