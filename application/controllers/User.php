<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
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
		$this->load->model('user_model');
		$this->load->helper(array('form', 'url'));
		$this->load->model('Pks_model');
	}	


	public function index() {	

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->pks = $this->Pks_model->list_reminder(180);
			$this->load->view('header', $data);
			$this->load->view('index');

		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function add_user()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register';
			$data->pks = $this->Pks_model->list_reminder(180);
			$this->load->view('header', $data);
			$this->load->view('add_user');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}

	}
	public function profile()
	{
		$this->load->view('profile');

	}

	public function login() {
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$data = new stdClass();
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$this->load->view('header', $data);
			$this->load->view('index');
			
		}else{
			// create the data object
			$data = new stdClass();
			
			// load form helper and validation library
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			// set validation rules
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == false) {
				
				$errors = validation_errors();
	            $respons_ajax['status'] = 'error';
	            $respons_ajax['pesan'] = $errors;
	            echo json_encode($respons_ajax);
				
			} else {

				// set variables from the form
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				
				if ($this->user_model->resolve_user_login($username, $password)) {
					
					$user  = $this->user_model->get_user($username);
					
					// set session user datas
					$_SESSION['username']     = (string)$user->username;
					$_SESSION['logged_in']    = (bool)true;
					$_SESSION['role']     = $user->role;
					$_SESSION['nama'] = (string)$user->nama;
					$_SESSION['icon'] = $user->profil_pict == '' ? '/gambar/profile/user.png' : $user->profil_pict ;
					$_SESSION['jabatan'] = $user->jabatan;
					$respons_ajax['status'] = 'success';
					$respons_ajax['pesan'] = 'Welcome <b>'.$user->nama.'</b>!';
					echo json_encode($respons_ajax);
					
				} else {
					
					// login failed
					$respons_ajax['status'] = 'error';
					$respons_ajax['pesan'] = 'Wrong Username or Password!';
					echo json_encode($respons_ajax);
					
				}
				
			}
		}
	}

	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			redirect(base_url());
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect(base_url());
			
		}
		
	}

	public function submit_register(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register';
			//initialize button submit
		
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->load->library('encryption');
			
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
	        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]',
	                array('required' => 'You must provide a %s.')
	        );
	        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]');
	        $this->form_validation->set_rules('recovery', 'Recovery Question', 'required|trim|min_length[10]');
	        $this->form_validation->set_rules('recovery_answer', 'Recovery Answer', 'required|trim');
	        $this->form_validation->set_rules('role', 'Role', 'required');

			$username = $this->input->post('username',TRUE);
			$password = $this->input->post('password');
			$fullname = $this->input->post('full_name',TRUE);
			$recovery = $this->input->post('recovery', TRUE);
			$answer = $this->input->post('recovery_answer', TRUE);
			$role = $this->input->post('role');
	        
	        if ($this->form_validation->run() == FALSE){

	            $errors = validation_errors();
	            $respons_ajax['status'] = 'error';
	            $respons_ajax['pesan'] = $errors;
	            echo json_encode($respons_ajax);

	        }
			else{
				$this->user_model->create_user($username, $password, $fullname, $recovery, $answer, $role);
				$respons_ajax['status'] = 'success';
				$respons_ajax['pesan'] = 'Register Success';
				echo json_encode($respons_ajax);		
			}
			
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}	
	}


	public function forgot_password(){

		$data = new stdClass();

		$this->load->view('header');
		$this->load->view('footer');
	}

	
}