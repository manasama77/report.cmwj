<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TemplateAdmin
{
	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('M_core', 'mcore');
		$this->ci->load->helper(['cookie', 'string']);
	}

	public function template($data)
	{
		// print_r($data);
		if (file_exists(APPPATH . 'views/pages/admin/' . $data['content_web'] . '.php')) {
			$this->ci->load->view('layouts/admin/main', $data, FALSE);
		} else {
			show_404();
		}
	}
}

/* End of file TemplateAdmin.php */
/* Location: ./application/libraries/TemplateAdmin.php */
