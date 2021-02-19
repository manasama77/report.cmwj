<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('TemplateAdmin', NULL, 'app');
    }


    public function wwt01()
    {
        $data['title_web']   = "APP NAME | Chart WWT-01";
        $data['content_web'] = "dashboard/main";
        $data['vitamin_web'] = "dashboard/main_vitamin";
        $this->app->template($data);
    }

    public function get_ph102()
    {
        $code = 500;
        $data = [];


        if ($this->input->get('from_date') && $this->input->get('from_date')) {
            $where['DATE(Time_Stamp) >='] = $this->input->get('from_date');
            $where['DATE(Time_Stamp) <='] = $this->input->get('to_date');
        } else {
            $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        }

        $exec = $this->mcore->get('trend001', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq' => $lq,
        ]);
    }

    public function get_ph103()
    {
        $code = 500;
        $data = [];

        if ($this->input->get('from_date') && $this->input->get('from_date')) {
            $where['DATE(Time_Stamp) >='] = $this->input->get('from_date');
            $where['DATE(Time_Stamp) <='] = $this->input->get('to_date');
        } else {
            $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        }

        $exec = $this->mcore->get('trend002', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_ph302()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend003', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_ph307()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend004', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_fiq101a()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend005', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_cia1()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend006', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_ciaa()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend007', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }

    public function get_ciab()
    {
        $code = 500;
        $data = [];

        $where['Time_Stamp >='] = date('Y-m-d') . " 00:00:00";
        $exec = $this->mcore->get('trend008', '*', $where);
        $lq   = $this->db->last_query();

        if ($exec) {
            $code = 200;
            if ($exec->num_rows() > 0) {
                foreach ($exec->result() as $key) {
                    $value_data = $key->LOLO;
                    $low_data   = $key->LILI;
                    $high_data  = $key->LALA;
                    $created_at = $key->Time_Stamp;
                    $tgl_obj    = new DateTime($created_at);
                    $tanggal    = $tgl_obj->format('d-m-Y');
                    $jam        = $tgl_obj->format('H: i A');
                    $mili       = $tgl_obj->format('YmdHisv');

                    $nested = [
                        'value_data' => $value_data,
                        'low_data'   => $low_data,
                        'high_data'  => $high_data,
                        'created_at' => $created_at,
                        'tanggal'    => $tanggal,
                        'jam'        => $jam,
                        'mili'       => $mili,
                    ];

                    array_push($data, $nested);
                }
            }
        }

        echo json_encode([
            'code' => $code,
            'data' => $data,
            'lq'   => $lq,
        ]);
    }
}
        
    /* End of file  LoginController.php */
