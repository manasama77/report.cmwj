<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ExportController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('TemplateAdmin', NULL, 'app');
        $this->load->model('M_alarm');
    }


    public function index()
    {
        $data['title_web']   = "CMWJ | Export PDF";
        $data['content_web'] = "export_pdf/main";
        $data['vitamin_web'] = "export_pdf/main_vitamin";

        $this->app->template($data);
    }

    public function show_alarm()
    {
        $id_area    = $this->input->post('id_area');
        $from_date  = $this->input->post('from_date');
        $to_date    = $this->input->post('to_date');
        $data       = [];

        $arr = $this->M_alarm->get($id_area, $from_date, $to_date);

        $no = 1;
        foreach ($arr->result() as $key) {
            $start_time_obj = new DateTime($key->starttime);

            if ($key->starttime != NULL) {
                $start_time_obj = new DateTime($key->starttime);
                $start_date_val = $start_time_obj->format('d-M-y');
                $start_time_val = $start_time_obj->format('H:i');
            } else {
                $stop_date_val = "";
                $stop_time_val = "";
            }

            if ($key->stoptime != NULL) {
                $stop_time_obj = new DateTime($key->stoptime);
                $stop_date_val = $stop_time_obj->format('d-M-y');
                $stop_time_val = $stop_time_obj->format('H:i');
            } else {
                $stop_date_val = "";
                $stop_time_val = "";
            }

            $nested['no']         = $no;
            $nested['group']      = $key->Al_Group;
            $nested['message']    = $key->Al_Message;
            $nested['active']     = $key->Al_Active;
            $nested['start_date'] = $start_date_val;
            $nested['start_time'] = $start_time_val;
            $nested['stop_date']  = $stop_date_val;
            $nested['stop_time']  = $stop_time_val;
            $nested['durasi']     = round($key->durasi / 60);

            $no++;
            array_push($data, $nested);
        }

        echo json_encode(['data' => $data, 'LQ' => $this->db->last_query()]);
    }

    public function show_chart_wwt1()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $code      = 500;

        $from_obj = new DateTime($from_date);
        $to_obj   = new DateTime($to_date);

        $data1 = [];
        $data2 = [];

        $where['Time_Stamp >='] = $from_obj->format('Y-m-d H:i:s');
        $where['Time_Stamp <='] = $to_obj->format('Y-m-d H:i:s');

        $exec1 = $this->mcore->get('trend001', '*', $where);
        $exec2 = $this->mcore->get('trend002', '*', $where);

        if ($exec1 && $exec2) {
            $code = 200;
            if ($exec1->num_rows() > 0) {
                foreach ($exec1->result() as $key) {
                    $value_data = $key->WT1_VALUE_pH_102;
                    $hh_data    = $key->WT1_VALUE_pH_102_HH_LEVEL;
                    $high_data  = $key->WT1_VALUE_pH_102_H_LEVEL;
                    $low_data   = $key->WT1_VALUE_pH_102_L_LEVEL;
                    $ll_data    = $key->WT1_VALUE_pH_102_LL_LEVEL;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'hh_data'    => $hh_data,
                        'high_data'  => $high_data,
                        'low_data'   => $low_data,
                        'll_data'    => $ll_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];
                    array_push($data1, $nested);
                }
            }

            if ($exec2->num_rows() > 0) {
                foreach ($exec2->result() as $key) {
                    $value_data = $key->WT1_VALUE_pH_107;
                    $hh_data    = $key->WT1_VALUE_pH_107_HH_LEVEL;
                    $high_data  = $key->WT1_VALUE_pH_107_H_LEVEL;
                    $low_data   = $key->WT1_VALUE_pH_107_L_LEVEL;
                    $ll_data    = $key->WT1_VALUE_pH_107_LL_LEVEL;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'hh_data'    => $hh_data,
                        'high_data'  => $high_data,
                        'low_data'   => $low_data,
                        'll_data'    => $ll_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data2, $nested);
                }
            }

            echo json_encode([
                'code'  => $code,
                'data1' => $data1,
                'data2' => $data2,
            ]);
        }
    }

    public function show_chart_wwt2()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $code      = 500;

        $from_obj = new DateTime($from_date);
        $to_obj   = new DateTime($to_date);

        $data1 = [];
        $data2 = [];
        $data3 = [];

        $where['Time_Stamp >='] = $from_obj->format('Y-m-d H:i:s');
        $where['Time_Stamp <='] = $to_obj->format('Y-m-d H:i:s');

        $exec1 = $this->mcore->get('trend004', '*', $where);
        $exec2 = $this->mcore->get('trend005', '*', $where);
        $exec3 = $this->mcore->get('trend003', '*', $where);

        if ($exec1 && $exec2 && $exec3) {
            $code = 200;
            if ($exec1->num_rows() > 0) {
                foreach ($exec1->result() as $key) {
                    $value_data = $key->WT2_VALUE_pH_302;
                    $hh_data    = $key->WT2_VALUE_pH_302_HH_LEVEL;
                    $high_data  = $key->WT2_VALUE_pH_302_H_LEVEL;
                    $low_data   = $key->WT2_VALUE_pH_302_L_LEVEL;
                    $ll_data    = $key->WT2_VALUE_pH_302_LL_LEVEL;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'hh_data'    => $hh_data,
                        'high_data'  => $high_data,
                        'low_data'   => $low_data,
                        'll_data'    => $ll_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];
                    array_push($data1, $nested);
                }
            }

            if ($exec2->num_rows() > 0) {
                foreach ($exec2->result() as $key) {
                    $value_data = $key->WT2_VALUE_pH_307;
                    $hh_data    = $key->WT2_VALUE_pH_307_HH_LEVEL;
                    $high_data  = $key->WT2_VALUE_pH_307_H_LEVEL;
                    $low_data   = $key->WT2_VALUE_pH_307_L_LEVEL;
                    $ll_data    = $key->WT2_VALUE_pH_307_LL_LEVEL;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'hh_data'    => $hh_data,
                        'high_data'  => $high_data,
                        'low_data'   => $low_data,
                        'll_data'    => $ll_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data2, $nested);
                }
            }

            if ($exec3->num_rows() > 0) {
                foreach ($exec3->result() as $key) {
                    $value_data = $key->WT2_VALUE_FIQ_101A;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data3, $nested);
                }
            }

            echo json_encode([
                'code'  => $code,
                'data1' => $data1,
                'data2' => $data2,
                'data3' => $data3,
            ]);
        }
    }

    public function show_chart_mixbed()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $code      = 500;

        $from_obj = new DateTime($from_date);
        $to_obj   = new DateTime($to_date);

        $data1 = [];

        $where['Time_Stamp >='] = $from_obj->format('Y-m-d H:i:s');
        $where['Time_Stamp <='] = $to_obj->format('Y-m-d H:i:s');

        $exec1 = $this->mcore->get('trend006', '*', $where);

        if ($exec1) {
            $code = 200;
            if ($exec1->num_rows() > 0) {
                foreach ($exec1->result() as $key) {
                    $value_data = $key->MB_VALUE_CIA1_CONDUCTIVITY;
                    $hh_data    = $key->MB_VALUE_CIA1_HH_LEVEL;
                    $high_data  = $key->MB_VALUE_CIA1_H_LEVEL;
                    $low_data   = $key->MB_VALUE_CIA1_L_LEVEL;
                    $ll_data    = $key->MB_VALUE_CIA1_LL_LEVEL;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'hh_data'    => $hh_data,
                        'high_data'  => $high_data,
                        'low_data'   => $low_data,
                        'll_data'    => $ll_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];
                    array_push($data1, $nested);
                }
            }

            echo json_encode([
                'code'  => $code,
                'data1' => $data1,
            ]);
        }
    }

    public function show_chart_diro()
    {
        $from_date = $this->input->post('from_date');
        $to_date   = $this->input->post('to_date');
        $code      = 500;

        $from_obj = new DateTime($from_date);
        $to_obj   = new DateTime($to_date);

        $data1 = [];
        $data2 = [];

        $where['Time_Stamp >='] = $from_obj->format('Y-m-d H:i:s');
        $where['Time_Stamp <='] = $to_obj->format('Y-m-d H:i:s');

        $exec1 = $this->mcore->get('trend007', '*', $where);
        $exec2 = $this->mcore->get('trend008', '*', $where);

        if ($exec1 && $exec2) {
            $code = 200;
            if ($exec1->num_rows() > 0) {
                foreach ($exec1->result() as $key) {
                    $value_data = $key->DR_VALUE_CIA_A;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];
                    array_push($data1, $nested);
                }
            }

            if ($exec2->num_rows() > 0) {
                foreach ($exec2->result() as $key) {
                    $value_data = $key->DR_VALUE_CIA_B;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H:i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data2, $nested);
                }
            }

            echo json_encode([
                'code'  => $code,
                'data1' => $data1,
                'data2' => $data2,
            ]);
        }
    }

    public function export_pdf_alarm_history($id_area, $from_date, $to_date)
    {
        if ($id_area == NULL && $from_date == NULL && $to_date == NULL) {
            show_404();
        } else {

            $from_obj = new DateTime($from_date);
            $from_obj->createFromFormat('Y-m-d H:i', $from_date);
            $from_human = $from_obj->format('d-M-Y H:i');

            $to_obj = new DateTime($to_date);
            $to_obj->createFromFormat('Y-m-d H:i', $to_date);
            $to_human = $to_obj->format('d-M-Y  H:i');

            $mpdf = new \Mpdf\Mpdf([
                'margin_header'  => 5,
                'margin_top'     => 20,
                'autoPageBreak ' => true,
                'img_dpi'        => 300,
                'dpi'            => 300
            ]);
            // $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetTitle('Alarm History ' . $from_human . "-" . $to_human);

            $mpdf->SetHTMLHeader('<img src="' . base_url('assets/img/header_alarm_history.png') . '" style="100%;">');

            $arr['from_human'] = $from_human;
            $arr['to_human']   = $to_human;

            $exp_id_area = str_split($id_area);

            $arr['arr'] = $this->M_alarm->get($exp_id_area, $from_obj->format('Y-m-d H:i:s'), $to_obj->format('Y-m-d H:i:s'));


            $data = $this->load->view('export_pdf_alarm_history', $arr, TRUE);
            // $this->load->view('hasilPrint', $arr, FALSE);
            $stylesheet = file_get_contents(base_url() . 'assets/css/mpdfcss.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($data, 2);
            $mpdf->Output();
        }
    }

    public function export_pdf_chart_history()
    {
        ini_set("pcre.backtrack_limit", "5000000");

        $canvash_wwt1   = $this->input->post('canvash_wwt1');
        $canvash_wwt2   = $this->input->post('canvash_wwt2');
        $canvash_mixbed = $this->input->post('canvash_mixbed');
        $canvash_diro   = $this->input->post('canvash_diro');
        $id_area        = $this->input->post('id_area');
        $from_date      = $this->input->post('from_date');
        $to_date        = $this->input->post('to_date');

        if ($id_area == NULL && $from_date == NULL && $to_date == NULL) {
            show_404();
        } else {

            $from_obj = new DateTime($from_date);
            $from_obj->createFromFormat('Y-m-d H:i', $from_date);
            $from_human = $from_obj->format('d-M-Y H:i');

            $to_obj = new DateTime($to_date);
            $to_obj->createFromFormat('Y-m-d H:i', $to_date);
            $to_human = $to_obj->format('d-M-Y  H:i');

            $mpdf = new \Mpdf\Mpdf([
                'margin_header'  => 5,
                'margin_top'     => 20,
                'autoPageBreak ' => true
            ]);
            // $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetTitle('Chart History ' . $from_human . "-" . $to_human);

            $mpdf->SetHTMLHeader('<img src="' . base_url('assets/img/header_chart_history.png') . '" style="100%;">');

            $arr['id_area']    = $id_area;
            $arr['from_human'] = $from_human;
            $arr['to_human']   = $to_human;

            $arr_exp_id_area = explode(',', $id_area);

            for ($i = 0; $i < count($arr_exp_id_area); $i++) {
                if ($arr_exp_id_area[$i] == '1') {
                    $arr['canvash_wwt1'] = $canvash_wwt1;
                }

                if ($arr_exp_id_area[$i] == '2') {
                    $arr['canvash_wwt2'] = $canvash_wwt2;
                }

                if ($arr_exp_id_area[$i] == '4') {
                    $arr['canvash_mixbed'] = $canvash_mixbed;
                }

                if ($arr_exp_id_area[$i] == '5') {
                    $arr['canvash_diro'] = $canvash_diro;
                }
            }

            $data = $this->load->view('export_pdf_chart_history', $arr, TRUE);
            // $this->load->view('hasilPrint', $arr, FALSE);
            // $stylesheet = file_get_contents(base_url() . 'assets/css/mpdfcss.css');
            // $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($data);
            $mpdf->Output();
        }
    }
}
        
    /* End of file  TableController.php */
