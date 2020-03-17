<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){

		parent::__construct();
		
		$this->load->model('Broadcast_model');
		
		$this->load->helper(array('form', 'url', 'terbilang_helper','tanggal_helper'));
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Bangkok");

	}	


	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Broadcast';
			
			$username = $_SESSION['username'];
			$data->sendto = $this->User_model->select_user(array('amgr','asst','mgr'), $_SESSION['username'])->result();
			$data->list_all = $this->Broadcast_model->get_broadcast('all')->result();
			$this->load->view('header', $data);
			$this->load->view('broadcast');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
		
	}

	

	public function send_broadcast()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

				$nama = $this->input->post('nama');
				$msg = $this->input->post('msg');
				$sends = $this->input->post('sendto');
				$sendto = (in_array('all', $sends) == true ? 'all' : '');
				$time = date('Y-m-d H:i:s');
				$gambar = $this->input->post('gambar');
				

				if($this->Broadcast_model->send_broadcast($nama, $msg, $sendto, $time)){
					$data['nama'] = $nama;
					$data['msg'] = $msg;
					$data['sendto'] = $sendto;
					$data['gambar'] = $gambar;
					$data['time'] = $time;
					$data['status'] = 'success';
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));		
				}else{
					$data['status'] = 'error';
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
				}
			

		}
	}

	
}