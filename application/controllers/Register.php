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
		$this->load->model('Warkat_model');
		$this->load->model('Bg_model');
		$this->load->model('Task_model');
		$this->load->library("excel");


	}	


	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Register';
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
			$data->page = 'Register';
			$data->year = $this->Register_masuk_model->get_year()->result();
			$data->user = $this->User_model->select_user(array('amgr','asst'));
			$data->status = $this->Register_masuk_model->get_list_status()->result();
			$data->select_vendor = $this->Tdr_model->select_tdr();
			$data->select_jenis = $this->Register_masuk_model->select_jenis_surat()->result();
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
				$row['no_surat'] = $field->no_surat_masuk;
				$row['tgl_surat'] = tgl_indo($field->tgl_surat_masuk);
				$row['perihal'] = $field->perihal;
				$row['tgl_terima_surat'] = tgl_indo($field->tgl_terima_surat);
				$row['jenis_surat'] = $field->jenis_surat;
				$row['tgl_disposisi_pimkel'] = tanggal($field->tgl_disposisi_pimkel);
				$row['tgl_disposisi_manajer'] = tanggal($field->tgl_disposisi_manajer);
				$row['status_data'] = $field->status_data;
				$row['status'] = $field->status;
				$row['comment'] = $field->comment == null ? '-': $field->comment;
				$row['created_at'] = $field->created_at == null ? '-' : 'Update at: '.tgl_jam($field->created_at);
				$row['username'] = $field->username;
				$row['alasan'] = $field->alasan;
				$row['tgl_srt_pengembalian'] = $field->tgl_srt_pengembalian;
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
					
				}elseif($this->input->post('jenis_surat') == 'Permintaan Ulang'){
					$this->form_validation->set_rules('id_pengadaan', 'Id Pengadaan Sebelumnya', 'required');
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
					$idr = $this->input->post('id_register');
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

					if($this->Register_masuk_model->add_data_masuk($id,  $divisi, $jenis, $email, $tglemail, $nosurat, $tglsurat, $perihal, $user, $kelompok, $tglterimasurat, $tglterimaemail, $tahun, $status, $beban, $anggaran, $idr)){

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
			$data['register'] = $this->Register_masuk_model->get_data_register($id);
			$data['aanwijzing'] = $this->get_aanwijzing($id);
			$data['auction'] = $this->get_auction($id);
            $data['comment'] = $this->get_comment($id);
            $data['pfa'] = $this->Register_masuk_model->get_pfa($id)->result();
			echo json_encode($data);
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

					//$this->form_validation->set_rules('tgl_d_pimkel', 'Tgl. Disposisi Pimkel', 'required');
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
					
					//$this->form_validation->set_rules('tgl_d_pimkel', 'Tgl. Disposisi Pimkel', 'required');
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
						if($this->Register_masuk_model->cek_pembuat($idregister)->num_rows() > 0){
							$u = $this->Register_masuk_model->cek_pembuat($idregister)->row()->id_pembuat;
							$u = explode('-', $u);
							$ur = $u[2];
							foreach($pembuat AS $p){
								$ur++;
								$res[] = array(
									'id_pembuat'=> $idregister.'-'.str_pad((int) $ur,2,"0",STR_PAD_LEFT),
									'id_register'=>$idregister,
									'username'=>$p
								);
							}
						}else{
							foreach($pembuat AS $p){
								$no++;
								$res[] = array(
									'id_pembuat'=> $idregister.'-'.str_pad((int) $no,2,"0",STR_PAD_LEFT),
									'id_register'=>$idregister,
									'username'=>$p
								);
							}
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

	public function get_count_task()
	{
		if($this->input->post(null)){
			$pembuat = $this->input->post('username');
			return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($this->Register_masuk_model->get_my_task($pembuat)->num_rows()));
		}

	}

	public function submit_jenis()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){

				$data = new stdClass();
				$this->form_validation->set_rules('tempat_pengadaan', 'Tempat Pengadaan', 'required');
				if($this->input->post('tempat_pengadaan') == 'BSK')
				{
					$this->form_validation->set_rules('jenis', 'Metode Pengadaan', 'required');
				}
				if ($this->form_validation->run() == false) {
					
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
					
				} else {
					$id = $this->input->post('id_register', TRUE);
					$jenis = $this->input->post('jenis', TRUE);
					$tempat = $this->input->post('tempat_pengadaan');

					if($this->Register_masuk_model->cek_jenis($id)->num_rows() > 0){
						if($this->Register_masuk_model->update_jenis($id, $jenis, $tempat)){
							$data->type = 'success';
				            $data->pesan = 'Berhasil';
						}else{
							$data->type = 'error';
				            $data->pesan = 'Failed';
				    
						}
					}else{
						if($this->Register_masuk_model->jenis($id, $jenis, $tempat)){
							
							$data->type = 'success';
				            $data->pesan = 'Berhasil';
						}else{
							$data->type = 'error';
				            $data->pesan = 'Failed';
				    
						}
					}
				}

				echo json_encode($data);
				
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
				$data = new stdClass();
				$this->form_validation->set_rules('id_vendor[]', 'Nama Vendor', 'required');

				$this->form_validation->set_rules('no_sp[]', 'No. SPK', 'required');
				$this->form_validation->set_rules('tgl_sp[]', 'Tgl. Surat', 'required');
				$this->form_validation->set_rules('id_jenis[]','Jenis Surat', 'required');
				
				if ($this->form_validation->run() == false) 
				{
					
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            
				}else{
					$id = $this->input->post('id_register');
					$nospk = $this->input->post('no_sp');
					$tgl = $this->input->post('tgl_sp');
					$idvendor = $this->input->post('id_vendor');
					$idjenis = $this->input->post('id_jenis');

					$no = $this->get_last_id_register($id);
					foreach($nospk AS $key => $val){
						$no++;
						$res[] = array(
							'id_detail_register'=> $id.'-'.str_pad((int) $no,2,"0",STR_PAD_LEFT),
							'id_register'=>$id,
							'tgl_surat'=>tanggal1($tgl[$key]),
							'no_surat'=>$nospk[$key],
							'id_surat'=>$idjenis[$key],
							'id_vendor'=>$idvendor[$key]
						);						
					}//pending

                    
					if($this->db->insert_batch('detail_register_masuk', $res)){
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
                        if($this->input->post('jenis_pengadaan') == 'Pembelian Langsung'){
                            $this->Register_masuk_model->update_status($id);   
                        }
			            if($this->Register_masuk_model->cek_status_done($id)->num_rows() > 0)
			            {
			            	$this->Register_masuk_model->update_status($id);
			            }
					}else{
						$data->type = 'error';
			            $data->pesan = 'Failed';
					}
				}

				echo json_encode($data);
			}
		}
	}

	public function update_status_done($id)
	{
		return $this->Register_masuk_model->update_status($id);
	}
	public function get_user()
	{
		echo json_encode($this->User_model->select_user(array('amgr','asst'))->result());
	}

	protected function _get_name($username)
	{
		return $this->User_model->get_name($username)->row('nama');
	}

	protected function get_last_id_register($id)
	{
		if($this->Register_masuk_model->get_last_id($id)->num_rows() > 0)
		{
			$r = $this->Register_masuk_model->get_last_id($id)->row();
			$idlast = $r->id_detail_register;
			$pecah = explode('-',$idlast);
			$urut = (int) $pecah[2];

		}else{
			$urut = 0;
		}

		return $urut;
	}

	public function proses_return()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				$data = new stdClass();
				$this->form_validation->set_rules('tgl_kembali', 'Tanggal kembali', 'required');

				//$this->form_validation->set_rules('no_surat', 'Nomor Surat', 'required');
				//$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
				$this->form_validation->set_rules('alasan','Alasan', 'required|max_length[200]');
				
				if ($this->form_validation->run() == false) 
				{
					
					$errors = validation_errors();
		            $data->type = 'error';
		            $data->pesan = $errors;
		            
				}else{

					$id = uniqid();
					$idr = $this->input->post('id_register');
					$tglk = tanggal1($this->input->post('tgl_kembali'));
					$no = $this->input->post('no_surat');
					$tgls = tanggal1($this->input->post('tgl_surat'));
					$alasan = $this->input->post('alasan');

					if($this->Register_masuk_model->new_return($id, $idr, $tglk, $no, $tgls, $alasan)){
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
					}else{
						$data->type = 'error';
			            $data->pesan = 'Failed';
			    
					}
				}

				echo json_encode($data);
			}


		}else{
			show_404();
		}

	}
    public function proses_batal()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
        {

            if($this->input->post(null))
            {
                $data = new stdClass();
                $this->form_validation->set_rules('tgl_batal', 'Tanggal Batal', 'required');

                //$this->form_validation->set_rules('no_surat', 'Nomor Surat', 'required');
                //$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
                $this->form_validation->set_rules('alasan','Alasan', 'required|max_length[200]');
                
                if ($this->form_validation->run() == false) 
                {
                    
                    $errors = validation_errors();
                    $data->type = 'error';
                    $data->pesan = $errors;
                    
                }else{

                    $id = uniqid();
                    $idr = $this->input->post('id_register');
                    $tglb = tanggal1($this->input->post('tgl_batal'));
                    $no = $this->input->post('no_surat');
                    $tgls = tanggal1($this->input->post('tgl_surat'));
                    $alasan = $this->input->post('alasan');

                    if($this->Register_masuk_model->pembatalan($id, $idr, $tglb, $no, $tgls, $alasan)){
                        $data->type = 'success';
                        $data->pesan = 'Berhasil';
                    }else{
                        $data->type = 'error';
                        $data->pesan = 'Failed';
                
                    }
                }

                echo json_encode($data);
            }


        }else{
            show_404();
        }

    }
	public function hapus_data(){
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{	

				$data = new stdClass();
				$id = $this->input->post('id');

				/*if($this->Register_masuk_model->hapus_register($id) && $this->Register_masuk_model->hapus_detail($id) && $this->Register_masuk_model->hapus_pembuat_register($id) && $this->Register_masuk_model->hapus_jenis_reg($id) )
				{*/

				if($this->Register_masuk_model->hapus_register($id))
				{
					$data->type = 'success';
		            $data->pesan = 'Berhasil';
				}else{
					$data->type = 'error';
		            $data->pesan = 'Failed';
				}

				echo json_encode($data);
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
				$data = new stdClass();
				$this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('tgl_terima_surat', 'Tgl. Terima Surat', 'required');

				if ($this->form_validation->run() == false) {
					$errors = validation_errors();
		            $data->type = 'error';
		            $data->pesan = $errors;
		            
					
				} else {
					$id = $this->input->post('id_register');
					$jenis = $this->input->post('jenis_surat');
					$no = $this->input->post('no_surat');
					$tgl = tanggal1($this->input->post('tgl_surat'));
					$perihal = $this->input->post('perihal');
					$tgltrm =  tanggal1($this->input->post('tgl_terima_surat'));

					if($this->Register_masuk_model->update_surat($id, $jenis, $no, $tgl, $perihal, $tgltrm)){
						
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			            $data->no = $no;
			            $data->tgl = $this->input->post('tgl_surat');
			            $data->perihal = $perihal;
			            $data->jenis = $jenis;
			            $data->tgltrm = $this->input->post('tgl_terima_surat');					
					}else{
						
						$data->type = 'error';
			            $data->pesan = 'Failed';	
					}
				}

				echo json_encode($data);

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
			$data->page = 'Register';
			$data->year = $this->Register_masuk_model->get_year()->result();
			$data->user = $this->User_model->select_user(array('amgr','asst'));
			
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

	public function add_pengumuman_lelang()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null))
			{
				$data = new stdClass();
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');
				$this->form_validation->set_rules('perihal','Perihal', 'required');
				if ($this->form_validation->run() == false) {

					$errors = validation_errors();
		            $data->type = 'error';
		            $data->pesan = $errors;
				
				}else{
					$id = uniqid();
					$no_surat = $this->input->post('no_surat');
					$tgl_surat = tanggal1($this->input->post('tgl_surat'));
					$idr = $this->input->post('id_register');
					$perihal = $this->input->post('perihal');
					if($this->Register_masuk_model->add_pengumuman_lelang($id, $idr, $no_surat, $tgl_surat, $perihal))
					{
						$data->type = 'success';
						$data->pesan = 'Success!';
						
					}else{

						$data->type = 'error';
						$data->pesan = 'Failed!';
						
					}

				}

				echo json_encode($data);

			}else{

			}
		}else{
			show_404();
		}
	}
	public function add_pengolahan()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null))
			{

				$data = new stdClass();
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required|max_length[250]');
				$this->form_validation->set_rules('dari', 'Dari', 'required');
				$this->form_validation->set_rules('tgl_kirim', 'Tgl. Kirim', 'required');
				if ($this->form_validation->run() == false) {

					$errors = validation_errors();
		            $data->type = 'error';
		            $data->pesan = $errors;
				
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
						
						$data->type = 'success';
						$data->pesan = 'Success!';
						
					}else{

						$data->type = 'error';
						$data->pesan = 'Failed!';
						
					}
				}

				echo json_encode($data);
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
				$datas = $this->input->post('data');

				if($datas == 'data'){
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
				$tglkirim = tanggal1($this->input->post('tgl_kirim'));
				$tglterima = tanggal1($this->input->post('tgl_terima'));
				
				if($this->Pengolahan_model->update_pengolahan($id, $no, $divisi, $perihal, $dari, $tglkirim, $tglterima))
				{
					$data->type = 'success';
					$data->pesan = 'Berhasil';

				}else{
					$data->type = 'error';
					$data->pesan = 'Gagal';

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

	public function submit_auction()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				
				$data = new stdClass();
				$this->form_validation->set_rules('tempat', 'Tempat', 'required');
				$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
				$this->form_validation->set_rules('jam', 'Jam', 'required');
				$this->form_validation->set_rules('vendor[]', 'Vendor', 'required');
				if ($this->form_validation->run() == false) {

					$errors = validation_errors();
		            $data->type = 'error';
		            $data->pesan = $errors;
				
				}else{
					$id = uniqid();
					$idregister = $this->input->post('id_register');
					$tempat = $this->input->post('tempat');
					$tanggal = tanggal1($this->input->post('tanggal'));
					$jam = $this->input->post('jam');
					$vendor = $this->input->post('vendor');

					foreach($vendor AS $key => $val){
					
						$res[] = array(
							'id'=> uniqid(),
							'id_auction'=>$id,
							'id_vendor'=>$vendor[$key],
							'id_register'=> $idregister
						);						
					}

					if($this->Register_masuk_model->add_auction($id, $idregister, $tempat, $tanggal, $jam) && $this->db->insert_batch('vendor_auction', $res)){
						$data->type = 'success';
						$data->pesan = 'Berhasil';

					}else{

						$data->type = 'error';
						$data->pesan = 'Gagal';

					}

				}

				echo json_encode($data);

			}else{
				show_404();
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

	public function hapus_pengolahan()
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

	public function warkat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			$data->title = 'Warkat Purchasing';
			$data->page = 'Register';
			$data->year = $this->Warkat_model->get_year()->result();
			$data->user = $this->User_model->select_user(array('amgr','asst'));
			$data->pemutus = $this->User_model->pemutus_warkat('active')->result();
			$data->petugas = $this->list_pemutus(array('asst'));
			
			$this->load->view('header',$data);
			$this->load->view('warkat_purchasing');

		}else{
			show_404();
		}
	}
	public function get_data_warkat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Warkat_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['no_warkat'] = $field->no_warkat;
				$row['perihal'] = $field->perihal;
				$row['pemutus'] = $field->nama_pemutus;
				$row['petugas'] = $field->nama;
				$row['nominal'] = titik($field->nominal);
				$row['tanggal'] = tanggal($field->tanggal);
				$row['catatan'] = $field->catatan;
				$row['status'] = $field->status;
				$row['id_warkat'] = $field->id_warkat;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Warkat_model->count_all(),
				"recordsFiltered"=>$this->Warkat_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	protected function list_pemutus(array $params)
	{
		return $this->User_model->select_user($params)->result();
	}

	public function add_warkat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null)){
				
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('pemutus', 'Pemutus', 'required');
				$this->form_validation->set_rules('petugas', 'Petugas', 'required');
				$this->form_validation->set_rules('nominal', 'Nominal', 'required');
				$this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
				if ($this->form_validation->run() == false) {

					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
				
				}else{
					$data = new stdClass();
					$perihal = $this->input->post('perihal');
					$pemutus = $this->input->post('pemutus');
					$petugas = $this->input->post('petugas');
					$nominal = $this->input->post('nominal');
					$tanggal = tanggal1($this->input->post('tanggal'));
					$catatan = $this->input->post('catatan');
					$rubrik = 'STL/4/';

					$tahun = date('Y');
					if($this->Warkat_model->get_last_id($tahun)->num_rows() > 0){
						$s = $this->Warkat_model->get_last_id(date('Y'))->row()->no_warkat;
						$lastid = (int) substr($s, -3);
						
						$nowarkat = $rubrik.date('y').STR_PAD($lastid+1,3,'0',STR_PAD_LEFT);
						$idwarkat = $nowarkat.'/'.$tahun;
					}else{
						$nowarkat = $rubrik.date('y').'001';
						$idwarkat = $nowarkat.'/'.$tahun;
					}

					if($this->Warkat_model->insert_data($idwarkat, $nowarkat, $perihal, $pemutus, $petugas, $nominal, $tanggal, $catatan, $tahun))

					{
						$data->type = 'success';
						$data->pesan = 'Berhasil! nomornya adalah: '.$nowarkat;

					}else{
						$data->type = 'error';
						$data->type = 'Gagal';
					}
					echo json_encode($data);
				}

			}
			

		}
	}

	public function update_warkat()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				$id = $this->input->post('id');
				$val = $this->input->post('value');
				$data = new stdClass();
				if($this->Warkat_model->update($id, $val))
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

	public function gb()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			$data->title = 'Garansi Bank';
			$data->page = 'Register';
			$data->year = $this->Bg_model->get_year()->result();

			$this->load->view('header', $data);
			$this->load->view('gb');
		}else{
			redirect('/');
		}
	}

	public function get_data_gb()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Bg_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['no_bg'] = $field->no_bg;
				$row['beneficiary'] = $field->beneficiary;
				$row['applicant'] = $field->applicant;
				$row['issuer'] = $field->issuer;
				$row['ccy'] = $field->ccy;
				$row['amount'] = titik($field->amount);
				$row['eqv'] = titik($field->eqv);
				$row['open'] = tanggal($field->open);
				$row['start'] = tanggal($field->start);
				$row['maturity'] = tanggal($field->maturity);
				$row['gl_acc'] = $field->gl_acc;
				$row['type'] = $field->type;
				$row['keterangan'] = $field->keterangan;
				$row['buku_satu'] = $field->buku_satu;
				$row['buku_dua'] = $field->buku_dua;
				$row['jenis_pekerjaan'] = $field->jenis_pekerjaan;
				$row['divisi'] = $field->divisi;
				$row['id_bg'] = $field->id_bg;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Bg_model->count_all(),
				"recordsFiltered"=>$this->Bg_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

    public function new_comment_register()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            $data = new stdClass();
            $this->form_validation->set_rules('comment', 'Comment', 'required|min_length[1]|max_length[200]');

            if ($this->form_validation->run() == false) {

                $errors = validation_errors();
                $data->type = 'error';
                $data->pesan = $errors;
                
            }else{

                $idr = $this->input->post('id_register');
                $id = uniqid();
                $comment = $this->input->post('comment');
                $comment_by = $_SESSION['username'];

                if($this->Register_masuk_model->new_comment_register($id, $idr, $comment, $comment_by))
                {
                        $data->type = 'success';
                        $data->pesan = 'Success!';
                            
                }else{

                        $data->type = 'error';
                        $data->pesan = 'Failed!';
                        
                }
            }

            echo json_encode($data);

        }else{
            show_404();
        }
    }

    private function get_comment($id)
    {
        return $this->Register_masuk_model->get_comment($id)->result();
        
    }

	public function my_task()
	{	
		$data = new stdClass();
		$data->title = 'My Task';
		$this->load->view('header', $data);
		$this->load->view('my_task');
	}

	public function get_data_task()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Task_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['id_task'] = $field->id_task;
				$row['date'] = tanggal($field->date);
				$row['perihal'] = $field->perihal;
				$row['due_date'] = tanggal($field->due_date);
				$row['status'] = $field->status;
				$row['id_user'] = $field->id_user;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Task_model->count_all(),
				"recordsFiltered"=>$this->Task_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_jenis()
	{
		echo json_encode($this->Register_masuk_model->select_jenis_surat()->result());
	}

	public function form_aanwijzing()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			$data = new stdClass();
			$this->form_validation->set_rules('id_register', 'ID. Register', 'required');
			$this->form_validation->set_rules('tgl', 'Tgl. Aanwijzing', 'required');
			$this->form_validation->set_rules('jam', 'Jam Aanwijzing', 'required');
			$this->form_validation->set_rules('tempat', 'Tempat Aanwijzing', 'required');
			$this->form_validation->set_rules('perihal', 'Perihal', 'required');
			$this->form_validation->set_rules('peserta', 'Peserta', 'required');

			if ($this->form_validation->run() == false) {

				$errors = validation_errors();
	            $data->type = 'error';
	            $data->pesan = $errors;
	            
			}else{
				$id = uniqid();
				$idp = $this->input->post('id_register');
				$tgl = tanggal1($this->input->post('tgl'));
				$jam = $this->input->post('jam');
				$tempat = $this->input->post('tempat');
				$perihal = $this->input->post('perihal');
				$peserta = $this->input->post('peserta');

				if($this->Register_masuk_model->new_aanwijzing($id, $idp, $tgl, $jam, $tempat, $perihal, $peserta))
				{
					$data->type = 'success';
					$data->pesan = 'Success!';
						
				}else{

					$data->type = 'error';
					$data->pesan = 'Failed!';
					
				}
			}

			echo json_encode($data);


		}else{
			show_404();
		}
	}

	protected function get_aanwijzing($id)
	{
		return $this->Register_masuk_model->get_aanwijzing($id)->result();
	}

	private function get_auction($id)
	{
		
		//$data['auction'] = $this->Register_masuk_model->get_ven_auc($id)->result();
		return $this->Register_masuk_model->get_auction($id)->result();
	}

    public function submit_pfa()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
        {

            if($this->input->post(null))
            {

                $data = new stdClass();
                $this->form_validation->set_rules('tglkirim', 'Tanggal Kirim Surat', 'required');
                $this->form_validation->set_rules('no', 'No. Memo', 'required');
                $this->form_validation->set_rules('tgl', 'Tanggal Memo', 'required');
                $this->form_validation->set_rules('tglkirim', 'Tanggal Kirim Surat', 'required');
                $this->form_validation->set_rules('perihal', 'Perihal', 'required');

                if ($this->form_validation->run() == false) {

                    $errors = validation_errors();
                    $data->type = 'error';
                    $data->pesan = $errors;
                
                }else{
                    $id = uniqid();

                    $tglkirim = tanggal1($this->input->post('tglkirim'));
                    $no = $this->input->post('no');
                    $idr = $this->input->post('id_register');
                    $tgl = tanggal1($this->input->post('tgl'));
                    $perihal = $this->input->post('perihal');

                    if($this->Register_masuk_model->new_pfa($id, $idr, $tglkirim, $no, $tgl, $perihal))
                    {
                        $data->type = 'success';
                        $data->pesan = 'Success!';
                            
                    }else{

                        $data->type = 'error';
                        $data->pesan = 'Failed!';
                        
                    }
                }
            }

            echo json_encode($data);
        }
    }
	public function add_gb()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null))
			{
				$nobg = trim($this->input->post('no_bg'));
				$beneficiary = trim($this->input->post('beneficiary'));
				$applicant = trim($this->input->post('applicant'));
				$issuer = trim($this->input->post('issuer'));
				$ccy = $this->input->post('ccy');
				$amount = $this->input->post('amount');
				$eqv = $this->input->post('eqv_rupiah');
				$open = tanggal1($this->input->post('open_date'));
				$start = tanggal1($this->input->post('start_date'));
				$maturity = tanggal1($this->input->post('maturity_date'));
				$gl = trim($this->input->post('gl_account'));
				$type = $this->input->post('gb_type');
				$keterangan = trim($this->input->post('keterangan'));
				$buku1 = trim($this->input->post('pembukuan_satu'));
				$jenispekerjaan = trim($this->input->post('jenis_pekerjaan'));
				$divisi = $this->input->post('divisi');
				$year = explode('-',$open);
				$id = $this->id_bg($divisi,$year[0]);
				$data = new stdClass();
				if($this->Bg_model->add_data($id, $nobg, $beneficiary, $applicant, $issuer, $ccy, $amount, $eqv, $open, $start, $maturity, $gl, $type, $keterangan, $buku1, $jenispekerjaan, $divisi))
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
		}
	}

	private function id_bg($divisi, $year)
	{
		
		$query = $this->Bg_model->get_last_id($year, $divisi);
		if($query->num_rows() > 0){
			$lastid = $query->row('id_bg');
			$ex = explode('-', $lastid);
			$id = 'bg-'.$divisi.'-'.$year.'-'.str_pad((int) $ex[3]+1,3,"0",STR_PAD_LEFT);
		}else{
			$id = 'bg-'.$divisi.'-'.$year.'-001';
		}

		return $id;
	}

	public function test_report($year = null, $month = null)
	{
		$data = new stdClass();
		$divisi = 'BSK';
		$data->query = $this->Bg_model->get_bg($year, $month, $divisi);
		$this->load->view('report_pdf', $data);
		/*$object = new PHPExcel();
		$object->getProperties()->setCreator("Muhamad Reza")
								 ->setLastModifiedBy("Muhamad Reza")
								 ->setTitle("Export Document By Sistem Purchasing")
								 ->setSubject("Office 2007 XLSX Document")
								 ->setDescription("Report BG By Sytem.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("BG FILE");

		//$object->createSheet();
		// Create a new worksheet called “My Data”
		$sheetbsk = new PHPExcel_Worksheet($object, 'Divisi BSK');
		$sheetpdm = new PHPExcel_Worksheet($object, 'Divisi PDM');
		$sheetebk = new PHPExcel_Worksheet($object, 'Divisi EBK');
		// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
		$object->addSheet($sheetbsk, 0);
		$object->addSheet($sheetpdm, 1);
		$object->addSheet($sheetebk, 2);

		//bsk
		$object->setActiveSheetIndex(0);	

		$table_columns = array("Name", "Email");

		$column = 0;
		$object->getActiveSheet()->setCellValue('B2', 'Saldo Awal Tahun '.$year)->getStyle('B2')->getFont()->setBold(true);

		foreach($table_columns as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);

        	$column++;

      	}
      	$object->getActiveSheet();
      	//end bsk


      	//pdm
      	$object->setActiveSheetIndex(1);	

		$table_columns1 = array("Names", "Email");

		$columns = 0;
		$object->getActiveSheet()->setCellValue('B2', 'Saldo Awal Tahun '.$year)->getStyle('B2')->getFont()->setBold(true);


		foreach($table_columns1 as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($columns, 1, $field);

        	$columns++;

      	}
      	$object->getActiveSheet();
      	//end pdm


      	//save excel

      	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="Report.xls"');

		$object_writer->save('php://output');*/
	}


	public function report($year = null, $month = null)
	{
		$object = new PHPExcel();
		$object->getProperties()->setCreator("Muhamad Reza")
								 ->setLastModifiedBy("Muhamad Reza")
								 ->setTitle("Export Document By Sistem Purchasing")
								 ->setSubject("Office 2007 XLSX Document")
								 ->setDescription("Report BG By Sytem.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("BG FILE");

		//$object->createSheet();
		// Create a new worksheet called “My Data”
		$sheetbsk = new PHPExcel_Worksheet($object, 'Divisi BSK');
		$sheetpdm = new PHPExcel_Worksheet($object, 'Divisi PDM');
		$sheetebk = new PHPExcel_Worksheet($object, 'Divisi EBK');
		// Attach the “My Data” worksheet as the first worksheet in the PHPExcel object
		$object->addSheet($sheetbsk, 0);
		$object->addSheet($sheetpdm, 1);
		$object->addSheet($sheetebk, 2);

		$rowawal = 8;
		

		$table_column = array("No.", "No. BG", "Beneficiary", "Applicant", "Issuing Bank / Issuer", "CCY", "Amount", "Eqv Rupiah", "Open Date", "Start Date", "Maturity Date", "GL Account", "GB Type", "Keterangan", "Pembukuan I", "Pembukuan II");

		$query= $this->Bg_model->get_bg($year, $month, 'BSK');

		//bsk

		$object->setActiveSheetIndex(0);	
		
		$column = 1;
		

		$object->getActiveSheet()->setCellValue('B4', 'Daftar Penerimaan Tahun '.$year)->getStyle('B4')->getFont()->setBold(true);

		/*foreach($table_column as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, $rowawal, $field);

        	$column++;

      	}*/
      	$no = 1;
      	$r = $query->result();

      	for($i = 0; $i < $query->num_rows();$i++){
      		if($i > 0){
      			if($r[$i]->bulan_open != $r[$i-1]->bulan_open)
      			{	
      				$rowawal++;

      				$objWorksheet = $object->getActiveSheet();
      				$highhestrow = $objWorksheet->getHighestRow();
      				foreach($table_column as $field){

						$object->getActiveSheet()->setCellValueByColumnAndRow($column, $rowawal, $field);
			        	$column++;

			      	}
			      	$row = $object->getActiveSheet()->getHighestRow()+1;

              		$object->getActiveSheet()->setCellValue('B'.$row, $no++);
              		$object->getActiveSheet()->setCellValue('C'.$row, $r[$i]->no_bg);
              		$object->getActiveSheet()->setCellValue('D'.$row,$r[$i]->beneficiary);
					$object->getActiveSheet()->setCellValue('E'.$row,$r[$i]->applicant);
					$object->getActiveSheet()->setCellValue('F'.$row,$r[$i]->issuer);
					$object->getActiveSheet()->setCellValue('G'.$row,$r[$i]->ccy);
					$object->getActiveSheet()->setCellValue('H'.$row,$r[$i]->amount);
					$object->getActiveSheet()->setCellValue('I'.$row,$r[$i]->eqv);
					$object->getActiveSheet()->setCellValue('J'.$row,$r[$i]->open)->getNumberFormat()
					    ->setFormatCode(
					        PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH
				    );
					$object->getActiveSheet()->setCellValue('K'.$row,$r[$i]->start)->getNumberFormat()
					    ->setFormatCode(
					        PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH
				    );
					$object->getActiveSheet()->setCellValue('L'.$row,$r[$i]->maturity)->getStyle('L'.$row)
					    ->getNumberFormat()
					    ->setFormatCode(
					        PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH
				    );
					$object->setActiveSheetIndex(0)->setCellValue('M'.$row,$r[$i]->gl_acc);
					$object->setActiveSheetIndex(0)->setCellValue('N'.$row,$r[$i]->type);
					$object->setActiveSheetIndex(0)->setCellValue('O'.$row,$r[$i]->keterangan);
					$object->setActiveSheetIndex(0)->setCellValue('P'.$row,$r[$i]->buku_satu);
					$object->setActiveSheetIndex(0)->setCellValue('Q'.$row,$r[$i]->buku_dua);
      			}
      		}     		

      	}

      	/*$object->getActiveSheet()->fromArray(
      		$arraydata,
      		NULL,
      		'B9');*/

      	$object->getActiveSheet();
      	//end bsk


      	//pdm
      	$object->setActiveSheetIndex(1);	

      	$column = 1;
		$object->getActiveSheet()->setCellValue('B2', 'Saldo Awal Tahun '.$year)->getStyle('B2')->getFont()->setBold(true);

		$object->getActiveSheet()->setCellValue('B4', 'Daftar Penerimaan Tahun '.$year)->getStyle('B4')->getFont()->setBold(true);

		foreach($table_column as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, $rowawal, $field);

        	$column++;

      	}
      	$object->getActiveSheet();
      	//end pdm

      	//ebk
      	//pdm
      	$object->setActiveSheetIndex(2);

		$column = 1;

		$object->getActiveSheet()->setCellValue('B2', 'Saldo Awal Tahun '.$year)->getStyle('B2')->getFont()->setBold(true);

		$object->getActiveSheet()->setCellValue('B4', 'Daftar Penerimaan Tahun '.$year)->getStyle('B4')->getFont()->setBold(true);

		foreach($table_column as $field){
			$object->getActiveSheet()->setCellValueByColumnAndRow($column, $rowawal, $field);

        	$column++;

      	}
      	$object->getActiveSheet();
      	//end ebk

      	//save excel

      	 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="Report.xls"');

		$object_writer->save('php://output');
	}


	


	
}