<div width="100%">
    <?php
    if ($from_human == $to_human) {
        echo '<p style="font-size: 10px;">Alarm History ' . $from_human . '</p>';
    } else {
        echo '<p style="font-size: 10px;">Alarm History ' . $from_human . ' - ' . $to_human . '</p>';
    }
    ?>
    <?php
    $arr_exp_id_area = explode(",", $id_area);
    for ($i = 0; $i < count($arr_exp_id_area); $i++) {
        if ($arr_exp_id_area[$i] == '1') {
    ?>
            <img src="<?= $canvash_wwt1; ?>" style="width: 100%;" />
            <br>
        <?php
        }

        if ($arr_exp_id_area[$i] == '2') {
        ?>
            <img src="<?= $canvash_wwt2; ?>" style="width: 100%;" />
            <br>
        <?php
        }

        if ($arr_exp_id_area[$i] == '4') {
        ?>
            <img src="<?= $canvash_mixbed; ?>" style="width: 100%;" />
            <br>
        <?php
        }

        if ($arr_exp_id_area[$i] == '5') {
        ?>
            <img src="<?= $canvash_diro; ?>" style="width: 100%;" />
            <br>
    <?php
        }
    }
    ?>
</div>