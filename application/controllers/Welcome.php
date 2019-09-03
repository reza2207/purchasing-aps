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

	public function get_announcement()
	{
		$data = new stdClass();
		$data->sort_by = $sort_by;
		$data->role = $_SESSION['role'];
		 //konfigurasi pagination
        $config['base_url'] = base_url('pks/page/'); //site url
        $config['total_rows'] = $this->db->count_all('pks'); //total row
        $config['per_page'] = 5;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 		$config['use_page_numbers'] = TRUE;
 		$config['attributes']['rel'] = FALSE;
 		$config['reuse_query_string'] = TRUE;
 		//$config['suffix'] = '/sort_by/'.$sort_by;
 		$config['first_url'] = base_url('pks');
        // Membuat Style pagination untuk Materialize
      	$config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="col push-l3 l9 s12 center"><ul class="pagination">';
        $config['full_tag_close']   = '</li></ul></div>';
        $config['num_tag_open']     = '<li class="waves-effect">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active"><a>';
        $config['cur_tag_close']    = '</a></li>';
        $config['next_tag_open']    = '<li class="waves-effect">';
        $config['next_tagl_close']  = '&raquo;</li>';
        $config['prev_tag_open']    = '<li class="waves-effect">';
        $config['prev_tagl_close']  = 'Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
 
        $this->pagination->initialize($config);
        $data->page = ($this->uri->segment(3)) ? ($this->uri->segment(3)-1)*$config['per_page'] : 0;
 
        //panggil function list_perusahaan di model. 
        $data->data = $this->Pengumuman_model->list_pks($config["per_page"], $data->page, $sort_by);           
 
        $data->pagination = $this->pagination->create_links();
			
	}

}
