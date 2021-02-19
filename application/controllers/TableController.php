<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TableController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('TemplateAdmin', NULL, 'app');
        $this->load->model('M_alarm');
    }


    public function index()
    {
        $data['title_web']   = "APP NAME | Table Alarm History";
        $data['content_web'] = "alarm_history/main";
        $data['vitamin_web'] = "alarm_history/main_vitamin";

        $this->app->template($data);
    }
}
        
    /* End of file  TableController.php */
