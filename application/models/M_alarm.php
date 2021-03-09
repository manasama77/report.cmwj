<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_alarm extends CI_Model
{

    public function get($id_area, $from_date, $to_date)
    {
        $id_area_where = "";
        for ($i = 0; $i < count($id_area); $i++) {
            $id_area_where .= $id_area[$i] . ',';
        }

        $id_area_where = rtrim($id_area_where, ',');

        $where_addon = "";
        if (count($id_area) == 1) {
            $where_addon = " AND a.Al_group = '" . $id_area[0] . "' ";
        } elseif (count($id_area) > 1) {
            $where_addon = " AND a.Al_group IN (" . $id_area_where . ") ";
        }
        $sql = "
            SELECT
                a.Al_Group,
                a.Al_Message,
                a.Al_Active,
                a.Al_Start_Time starttime,
                (
                    SELECT
                        b.Al_Norm_Time
                    FROM
                        alarmhistory b
                    WHERE
                        b.Al_Active = 0
                        AND b.Al_Norm_Time > a.Al_Start_Time
                        AND b.Al_Group = a.Al_Group
                    LIMIT 1
                ) stoptime,
                TIMESTAMPDIFF(SECOND, a.Al_Start_Time, ( SELECT b.Al_Norm_Time FROM alarmhistory b WHERE b.Al_Active = 0 AND b.Al_Norm_Time > a.Al_Start_Time AND b.Al_Group = a.Al_Group limit 1 )) durasi
            FROM
                alarmhistory a
            WHERE
                a.Al_Active = '1'
                AND a.Al_Event_Time >= '" . $from_date . "'
                AND a.Al_Event_Time <= '" . $to_date . "'
            " . $where_addon;
        return $this->db->query($sql);
    }
}
                        
/* End of file M_alarm.php */
