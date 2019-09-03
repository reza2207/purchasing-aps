<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
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
		$this->load->model('User_model');
		$this->load->model('Pks_model');
		$this->load->model('Register_masuk_model');
		$this->load->model('Pengolahan_model');
		$this->load->helper(array('form', 'url', 'terbilang_helper','tanggal_helper'));
		$this->load->library('form_validation');
		$this->load->model('Tdr_model');
		date_default_timezone_set("Asia/Bangkok");

	}	


	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register';
			$data->pks = $this->Pks_model->list_reminder(180);
			$this->load->view('header', $data);
			$this->load->view('register');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
		
	}

	public function register_masuk()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register Masuk';
			$data->year = $this->Register_masuk_model->get_year()->result();
			$data->user = $this->User_model->select_user(array('amgr','asst'));
			$data->pks = $this->Pks_model->list_reminder(180);
			$data->select_vendor = $this->Tdr_model->select_tdr();
			$this->load->view('header', $data);
			$this->load->view('register_masuk');
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_data_surat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Register_masuk_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['id_register'] = $field->id_register;
				$row['divisi'] = $field->divisi;
				$row['email'] = $field->email;
				$row['tgl_email'] = tanggal($field->tgl_email);
				$row['tgl_terima_email'] = tanggal($field->tgl_terima_email);
				$row['kelompok'] = $field->kelompok;
				$row['no_surat'] = $field->no_surat;
				$row['tgl_surat'] = tanggal($field->tgl_surat);
				$row['perihal'] = $field->perihal;
				$row['tgl_terima_surat'] = tanggal($field->tgl_terima_surat);
				$row['jenis_surat'] = $field->jenis_surat;
				$row['tgl_disposisi_pimkel'] = tanggal($field->tgl_disposisi_pimkel);
				$row['tgl_disposisi_manajer'] = tanggal($field->tgl_disposisi_manajer);
				$row['status_data'] = $field->status_data;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Register_masuk_model->count_all(),
				"recordsFiltered"=>$this->Register_masuk_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function add_data_masuk(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){

				// set validation rules
				$this->form_validation->set_rules('tgl_terima', 'Tgl. Terima', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				if( $this->input->post('jenis_surat') == 'Email'){
					$this->form_validation->set_rules('email', 'Email', 'required');
					$this->form_validation->set_rules('tgl_email', 'Tgl. Email', 'required');
					
				}else{
					$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
					$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');
				}
				
				
				$this->form_validation->set_rules('user', 'User', 'required');
				$this->form_validation->set_rules('kelompok', 'Kelompok', 'required');

			
				if ($this->form_validation->run() == false) {
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
					
				} else {

					$tglterima = tanggal1($this->input->post('tgl_terima', TRUE));
					$divisi = $this->input->post('divisi', TRUE);
					$jenis = $this->input->post('jenis_surat', TRUE);
					$email = $this->input->post('email', TRUE);
					$tglemail = tanggal1($this->input->post('tgl_email', TRUE));
					$nosurat = $this->input->post('no_surat', TRUE);
					$tglsurat = tanggal1($this->input->post('tgl_surat', TRUE));
					$t = explode("-",$tglterima);
					$beban = $this->input->post('beban');
					$anggaran = $this->input->post('anggaran');
					$tahun = $t[0];
					if($jenis != 'Pemberitahuan' ){
						$status = 'On Process';
					}else{
						$status = 'Done';
					}
					if($jenis != 'Email'){
						$tglterimasurat = $tglterima;
						$tglterimaemail = '0000-00-00';

					}else{
						$tglterimasurat = '0000-00-00';
						$tglterimaemail = $tglterima;
					}
					$perihal = $this->input->post('perihal', TRUE);
					$user = $this->input->post('user', TRUE);
					$kelompok = $this->input->post('kelompok', TRUE);
					$id = $this->_id_register_masuk(date('Y'));

					if($this->Register_masuk_model->add_data_masuk($id,  $divisi, $jenis, $email, $tglemail, $nosurat, $tglsurat, $perihal, $user, $kelompok, $tglterimasurat, $tglterimaemail, $tahun, $status, $beban, $anggaran)){

						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			            echo json_encode($data);
			        }else{
			        	$data = new stdClass();
 						$data->type = 'error';
			            $data->pesan = 'Failed';
			            echo json_encode($data);
			        }
				}
			}else{
				echo "you're not allowed accessed this data";
			}


		}else{
			show_404();
		}
	}

	protected function _id_register_masuk($year = NULL)
	{	
		$year = date('Y');
		if($this->Register_masuk_model->get_last_id_register($year)->num_rows() == 0){
			$id = $year.'-0001';
		}else{
			$lastid = $this->Register_masuk_model->get_last_id_register($year)->row('id_register');
			$pecah = explode('-',$lastid);
			$lastq = $pecah[1];
			$id = $year.'-'.str_pad((int) $lastq+1,4,"0",STR_PAD_LEFT);
		}

		return $id;
		
	}

	public function get_detail_masuk(){
		$id = $this->uri->segment(3);
		if($id != NULL){
			echo json_encode($this->Register_masuk_model->get_data_register($id));
		}else{
			echo 'tidak ada data.';
		}
	}

	public function submit_disposisi()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				
				$idregister = $this->input->post('id_register');

				if($this->input->post('tgl_d_manager') === null && $this->input->post('pembuat') === null ){
					$this->form_validation->set_rules('tgl_d_pimkel', 'Tgl. Disposisi Pimkel', 'required');

					if ($this->form_validation->run() == false) {
						$data = new stdClass();
						$errors = validation_errors();
						$data->type = 'error';
			            $data->pesan = $errors;
			            echo json_encode($data);
					}else{

						$tgldpimkel = tanggal1($this->input->post('tgl_d_pimkel'));

						if($this->Register_masuk_model->disposisi($idregister, $tgldpimkel,NULL)){
							$data = new stdClass();
							$data->type = 'success';
				            $data->pesan = 'Berhasil';
				            $data->pimkel = $this->input->post('tgl_d_pimkel');
				            echo json_encode($data);
						}else{
							$data = new stdClass();
							$data->type = 'error';
				            $data->pesan = 'Failed';
				            echo json_encode($data);	
						}
					}
				}elseif($this->input->post('tgl_d_manager') !== null && $this->input->post('pembuat') === NULL)
				{

					$this->form_validation->set_rules('tgl_d_pimkel', 'Tgl. Disposisi Pimkel', 'required');
					$this->form_validation->set_rules('tgl_d_manager', 'Tgl. Disposisi Manager', 'required');

					if ($this->form_validation->run() == false) {
						$data = new stdClass();
						$errors = validation_errors();
						$data->type = 'error';
			            $data->pesan = $errors;
			            echo json_encode($data);
					}else{
						$tgldmanager = tanggal1($this->input->post('tgl_d_manager'));
						$tgldpimkel = tanggal1($this->input->post('tgl_d_pimkel'));
						if($this->Register_masuk_model->disposisi($idregister, $tgldpimkel, $tgldmanager)){
							$data = new stdClass();
							$data->type = 'success';
				            $data->pesan = 'Berhasil';
				            $data->pimkel = $this->input->post('tgl_d_pimkel');
			            	$data->manager = $this->input->post('tgl_d_manager');
				            echo json_encode($data);
						}else{
							$data = new stdClass();
							$data->type = 'error';
				            $data->pesan = 'Failed';
				            echo json_encode($data);	
						}
					}
					
				}else{
					$no = 0;
					
					$this->form_validation->set_rules('tgl_d_pimkel', 'Tgl. Disposisi Pimkel', 'required');
					$this->form_validation->set_rules('tgl_d_manager', 'Tgl. Disposisi Manager', 'required');
					$this->form_validation->set_rules('pembuat[]', 'Pembuat Pekerjaan', 'required');
					if ($this->form_validation->run() == false) {
						$data = new stdClass();
						$errors = validation_errors();
						$data->type = 'error';
			            $data->pesan = $errors;
			            echo json_encode($data);
					}else{
						$pembuat = $this->input->post('pembuat');
						$tgldpimkel = tanggal1($this->input->post('tgl_d_pimkel'));
						$tgldmanager = tanggal1($this->input->post('tgl_d_manager'));
						foreach($pembuat AS $p){
							$no++;
							$res[] = array(
								'id_pembuat'=> $idregister.'-'.str_pad((int) $no,2,"0",STR_PAD_LEFT),
								'id_register'=>$idregister,
								'username'=>$p
							);
						}

						if($this->Register_masuk_model->disposisi($idregister, $tgldpimkel ,$tgldmanager) && $this->db->insert_batch('pembuat_pekerjaan', $res)){
							$data = new stdClass();
							$data->type = 'success';
				            $data->pesan = 'Berhasil';
				            $data->manager = $this->input->post('tgl_d_manager');
				            $data->pembuat = $this->_get_name($pembuat);
				            $data->unamepembuat = implode(',',$pembuat);
				            echo json_encode($data);
						}else{
							$data = new stdClass();
							$data->type = 'error';
				            $data->pesan = 'Failed';
				            echo json_encode($data);
						}
					}
				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function submit_jenis()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){

				
				$this->form_validation->set_rules('tempat_pengadaan', 'Tempat Pengadaan', 'required');
				if($this->input->post('tempat_pengadaan') == 'BSK')
				{
					$this->form_validation->set_rules('jenis', 'Metode Pengadaan', 'required');
				}
				if ($this->form_validation->run() == false) {
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
					
				} else {
					$id = $this->input->post('id_register', TRUE);
					$jenis = $this->input->post('jenis', TRUE);
					$tempat = $this->input->post('tempat_pengadaan');

					if($this->Register_masuk_model->jenis($id, $jenis, $tempat)){
						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			            $data->tempat = $tempat;	
			            $data->jenis = $jenis;
			            echo json_encode($data);
					}else{
						$data = new stdClass();
						$data->type = 'error';
			            $data->pesan = 'Failed';
			            $data->jenis = '';
			            echo json_encode($data);
					}
				}
				
			}else{
				show_404();
			}

		}else{
			show_404();
		}

	}

	public function submit_spk()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				$this->form_validation->set_rules('no_spk[]', 'No. SPK', 'required');
				$this->form_validation->set_rules('tgl_spk[]', 'Tgl. SPK', 'required');
				$this->form_validation->set_rules('id_vendor[]', 'Nama Vendor', 'required');
				if ($this->form_validation->run() == false) 
				{
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
				}else{
					$id = $this->input->post('id_register');
					$nospk = $this->input->post('no_spk');
					$tgl = $this->input->post('tgl_spk');
					$idvendor = $this->input->post('id_vendor');

					$no = 0;
					foreach($nospk AS $key => $val){
						$no++;
						$res[] = array(
							'id_detail_register'=> $id.'-'.str_pad((int) $no,2,"0",STR_PAD_LEFT),
							'id_register'=>$id,
							'no_spk'=>$nospk[$key],
							'tgl_spk'=>tanggal1($tgl[$key]),
							'id_vendor'=>$idvendor[$key]
						);
						$idno[] = $id.'-'.str_pad((int) $no,2,"0",STR_PAD_LEFT);
						$nama[] = $this->_get_nama_vendor($idvendor[$key]);
					}//pending

					if($this->db->insert_batch('detail_register_masuk', $res) && $this->Register_masuk_model->update_status($id)){
						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			            $data->nospk = implode('<br>',$nospk);
			            $data->idspk = implode('<br>', $idno);
			            $data->tgl = implode('<br>',$tgl);
			            $data->status = 'Done';
			            $data->svendor = implode('<br>',$nama);
						echo json_encode($data);
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
			            $data->pesan = 'Failed';
						echo json_encode($data);
					
					}
				}
			}
		}
	}

	public function get_user(){
		echo json_encode($this->User_model->select_user(array('amgr','asst'))->result());
	}

	protected function _get_name($username){
		return $this->User_model->get_name($username)->row('nama');
	}

	public function hapus_data(){
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				$id = $this->input->post('id');

				if($this->Register_masuk_model->hapus_register($id) && $this->Register_masuk_model->hapus_detail($id) && $this->Register_masuk_model->hapus_pembuat_register($id) && $this->Register_masuk_model->hapus_jenis_reg($id) )
				{
					$data = new stdClass();
					$data->type = 'success';
		            $data->pesan = 'Berhasil';
					echo json_encode($data);
					
				}else{
					$data = new stdClass();
					$data->type = 'error';
		            $data->pesan = 'Failed';
					echo json_encode($data);
				
				}
			}else{
				show_404();
			}

		}else{
			show_404();
		}
	}

	public function update_surat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				
				$this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('tgl_terima_surat', 'Tgl. Terima Surat', 'required');

				if ($this->form_validation->run() == false) {
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
					
				} else {
					$id = $this->input->post('id_register');
					$jenis = $this->input->post('jenis_surat');
					$no = $this->input->post('no_surat');
					$tgl = tanggal1($this->input->post('tgl_surat'));
					$perihal = $this->input->post('perihal');
					$tgltrm =  tanggal1($this->input->post('tgl_terima_surat'));

					if($this->Register_masuk_model->update_surat($id, $jenis, $no, $tgl, $perihal, $tgltrm)){
						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			            $data->no = $no;
			            $data->tgl = $this->input->post('tgl_surat');
			            $data->perihal = $perihal;
			            $data->jenis = $jenis;
			            $data->tgltrm = $this->input->post('tgl_terima_surat');
						echo json_encode($data);
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
			            $data->pesan = 'Failed';
						echo json_encode($data);
					
					}
				}

			}else{
				show_404();
			}
		}else{
			show_404();
		}

	}

	protected function _get_nama_vendor($id){
		
		return $this->Tdr_model->get_nama($id);
	}

	public function lembar_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			$data->title = 'Lembar Pengolahan';
			$data->year = $this->Register_masuk_model->get_year()->result();
			$data->user = $this->User_model->select_user(array('amgr','asst'));
			$data->pks = $this->Pks_model->list_reminder(180);
			$this->load->view('header',$data);
			$this->load->view('lembar_pengolahan');

		}else{
			show_404();
		}
	}

	public function get_data_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$this->load->model('Pengolahan_model');
			$list = $this->Pengolahan_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['id_surat'] = $field->id_surat;
				$row['no_srt'] = $field->no_srt;
				$row['perihal'] = $field->perihal;
				$row['dari_kelompok'] = $field->dari_kelompok;
				$row['tgl_petugas_kirim'] = tanggal($field->tgl_petugas_kirim);
				$row['tgl_terima_doc'] = tanggal($field->tgl_terima_doc);
				$row['tahun'] = $field->tahun;
				$row['divisi'] = $field->divisi;
				$row['status'] = $row['tgl_terima_doc'] != '' ? 'Done': '-';
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Pengolahan_model->count_all(),
				"recordsFiltered"=>$this->Pengolahan_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function add_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null))
			{
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required|max_length[250]');
				$this->form_validation->set_rules('dari', 'Dari', 'required');
				$this->form_validation->set_rules('tgl_kirim', 'Tgl. Kirim', 'required');
				if ($this->form_validation->run() == false) {

					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
				
				}else{

					$no_surat = $this->input->post('no_surat');
					$divisi = $this->input->post('divisi');
					$perihal = $this->input->post('perihal');
					$dari = $this->input->post('dari');
					$tgl_kirim = tanggal1($this->input->post('tgl_kirim'));
					$tahun = date('Y');
					$id_register = $this->get_id_pengolahan($tahun);

					$this->load->model('Pengolahan_model');

					if($this->Pengolahan_model->add_pengolahan($id_register, $no_surat, $perihal, $dari, $tgl_kirim, $divisi, $tahun))
					{
						
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success!';
						echo json_encode($data);
					}else{

						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed!';
						echo json_encode($data);
					}

				}
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	protected function get_id_pengolahan($tahun)
	{
		$this->load->model('Pengolahan_model');
		if($this->Pengolahan_model->cek_id($tahun)->num_rows() > 0 )
		{
			$oldid = $this->Pengolahan_model->cek_id($tahun)->row()->id_surat;
			$oldid = explode("-", $oldid);
			$oldid = $oldid[1];
			$id_register = date("Y")."-".str_pad($oldid +1 ,4,"0",STR_PAD_LEFT);
			return $id_register;

		}else{
			$id_register = $tahun.'-0001';
			return $id_register;
		}
	}

	public function get_data_id_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null))
			{
				$this->load->model('Pengolahan_model');

				$id = $this->input->post('id');
				$data = $this->input->post('data');

				if($data == 'data'){
					if($this->Pengolahan_model->get_data_pengolahan($id))
					{
						$data = $this->Pengolahan_model->get_data_pengolahan($id)->row();
						echo json_encode($data);

					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'data not found';
						echo json_encode($data);
					}
				}elseif($data == 'status'){
					$data = $this->get_comment($id);
					echo json_encode($data);
				}



			}else{
				show_404();
			}
		}else{
			show_404();
		}

	}

	public function print_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->get('checkid') != NULL)
			{
				$this->load->model('Pengolahan_model');

				$id = $this->input->get('checkid');
				$id = explode(',',$id);
				

				if($this->Pengolahan_model->get_data_pengolahan($id)->num_rows()> 0 ){
					$data = new stdClass();
					$data->result = $this->Pengolahan_model->get_data_pengolahan($id);
					$this->load->view('print_surat', $data);
				}
			}
		}
	}

	public function edit_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			if($this->input->post(null))
			{

				$id = $this->input->post('id_surat');
				$no = $this->input->post('no_surat');
				$divisi = $this->input->post('divisi');
				$perihal = $this->input->post('perihal');
				$dari = $this->input->post('dari');
				$tglkirim = $this->input->post('tgl_kirim');
				$tglterima = $this->input->post('tgl_terima');
				
				if($this->update_pengolahan($id, $no, $divisi, $perihal, $dari, $tglkirim, $tglterima))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';

				}else{
					$data->type = 'error';
					$data->type = 'Gagal';

				}

				echo json_encode($data);
			}else{
				
				$data->status = '404';
				echo json_encode($data);
			}
		}else{
			show_404();
		}
	}

	public function get_status()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$id = $this->input->post('id');
				echo json_encode($this->Pengolahan_model->get_status($id)->result());
			}

		}else{
			show_404();
		}
	}

	public function addstatus()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			if($this->input->post(null))
			{
				$idsurat = $this->input->post('id');
				$status = $this->input->post('value');
				$username = $_SESSION['username'];
				$date = date('Y-m-d H:i:s');
				$idstatus = $this->get_id_status($idsurat);
				if($this->Pengolahan_model->input_status($idstatus, $idsurat, $status, $username, $date))
				{			
					$data->type = 'success';
					$data->pesan = 'Berhasil';

				}else{
					$data->type = 'error';
					$data->type = 'Gagal';
				}
				echo json_encode($data);
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	protected function get_id_status($id)
	{
		if($this->Pengolahan_model->get_id_status($id)->num_rows() > 0)
		{
			$lastid = $this->Pengolahan_model->get_id_status($id)->row('id_status');
			$uniqlastid = explode('-',$lastid);
			$uniq = $uniqlastid[2];
			$id = $id.'-'.str_pad($uniq+1, 3,"0",STR_PAD_LEFT);
			return $id;

		}else{
			return $id.'-001';
		}
	}

	public function hapus_pengelohan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			if($this->input->post(null))
			{
				$id = $this->input->post('id');

				if($this->Pengolahan_model->hapus_pengolahan($id) && $this->Pengolahan_model->hapus_status($id))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';

				}else{
					$data->type = 'error';
					$data->type = 'Gagal';
				}
				echo json_encode($data);
				
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	
}