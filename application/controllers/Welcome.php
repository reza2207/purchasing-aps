<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){

		parent::__construct();
		
		$this->load->model('User_model');
		$this->load->model('Pks_model');
		$this->load->model('Pengadaan_model');
		$this->load->model('Register_masuk_model');

	}	
	public function index()
	{
		$this->load->helper('form');
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->pks = $this->Pks_model->list_reminder(180);
			$year = date('Y');
			$data->role = $_SESSION['role'];
			$data->year = $year;
			$data->pengadaan = $this->Pengadaan_model->list_pengadaan($year);
			$data->register_masuk = $this->Register_masuk_model->list_register_masuk($year);
			$this->load->view('header', $data);
			$this->load->view('index');
		
		}else{
		
			$this->load->view('login');
		
		}

	}

}
