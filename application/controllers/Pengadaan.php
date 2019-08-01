<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan extends CI_Controller {

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
		
		$this->load->model('Pengadaan_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Pks_model');
		$this->load->model('Tdr_model');
		$this->load->model('Setting_model');
		$this->load->model('User_model');

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Pengadaan';
			$data->role = $_SESSION['role'];
			$data->select_tdr = $this->Tdr_model->select_tdr();
			$data->tahun = $this->Pengadaan_model->get_tahun();
			//$data->id = $this->get_id_pengadaan();
			$data->select_user = $this->User_model->select_user()->result();
			$data->divisi = $this->Setting_model->get_divisi()->result();
			$data->pks = $this->Pks_model->list_reminder(180);
			$this->load->view('header', $data);
			$this->load->view('pengadaan', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_data_Pengadaan()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Pengadaan_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['no_notin'] = $field->no_notin;
				$row['tgl_notin'] = tanggal($field->tgl_notin);
				$row['jenis_notin_masuk'] = $field->jenis_notin_masuk;
				$row['tgl_disposisi'] = tanggal($field->tgl_disposisi);
				$row['perihal'] = $field->perihal;
				$row['jenis_pengadaan'] = $field->jenis_pengadaan;
				$row['divisi'] = $field->divisi;
				$row['kewenangan'] = $field->kewenangan;
				$row['id_pengadaan'] = $field->id_pengadaan;
			
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Pengadaan_model->count_all(),
				"recordsFiltered"=>$this->Pengadaan_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function submit_new_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$this->form_validation->set_rules('tgl_surat', 'Tanggal Surat', 'required');
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('tahun_pengadaan', 'Tahun Pengadaan', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');

				$this->form_validation->set_rules('kelompok', 'Kelompok', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$this->form_validation->set_rules('jenis_pengadaan', 'Jenis Pengadaan', 'required');
				
				if(($this->input->post('jenis_pengadaan')!= 'Pembelian Langsung') || ($this->input->post('jenis_pengadaan')!= ''){
					$this->form_validation->set_rules('no_usulan', 'No. Usulan', 'required');
					$this->form_validation->set_rules('tgl_usulan', 'Tgl. Usulan', 'required');
				}
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				$jenispengadaan = $this->input->post('jenis_pengadaan');
				$tglsurat = tanggal1($this->input->post('tgl_surat'));
				$nosurat =  $this->input->post('no_surat');
				$jenissurat = $this->input->post('jenis_surat');
				$tgldisposisi = tanggal1($this->input->post('tgl_disposisi'));
				$tahun = $this->input->post('tahun_pengadaan');
				$perihal = $this->input->post('perihal');
				$nousulan = $this->input->post('no_usulan');
				
				$tglusulan = tanggal1($this->input->post('tgl_usulan'));
				$divisi = $this->input->post('divisi');
				$kelompok = $this->input->post('kelompok');
				//$pembuat = $this->input->post('pembuat_pekerjaan');
				$keterangan = $this->input->post('keterangan');
				$kewenangan = $this->input->post('kewenangan');
				$id = $this->_get_id_pengadaan($tahun);
				//array
				$item = $this->input->post('item');
				$ukuran = $this->input->post('ukuran');
				$bahan = $this->input->post('bahan');
				$jumlah = $this->input->post('jumlah');
				$satuan = $this->input->post('satuan');
				$hpsusd = $this->input->post('hpsusd');
				$hpsidr = $this->input->post('hpsidr');
				$hpssatuan = $this->input->post('hpssatuan');
				$penawaran = $this->input->post('penawaran');
				$realisasiusd = $this->input->post('realisasiusd');
				$realisasirp = $this->input->post('realisasirp');
				$realisasiqty = $this->input->post('realisasiqty');
				$nokontrak = $this->input->post('nokontrak');
				$tglkontrak = tanggal1($this->input->post('tglkontrak'));
				$vendor = $this->input->post('vendor');

				$result[] = array();
				foreach($item AS $key => $val){
					$result[] = array(
						"id_pengadaan" => $id,
						"id_pengadaan_uniq" => $id.'-'.str_pad($key,3,"0",STR_PAD_LEFT),
						"item" =>$item[$key],
						"ukuran" =>$ukuran[$key],
						"bahan" => $bahan[$key],
						"jumlah" => $jumlah[$key],
						"satuan" => $satuan[$key],
						"hps_usd" =>$hpsusd[$key],
						"hps_idr" =>$hpsidr[$key],
						"hps_satuan"=> $hpssatuan[$key],
						"penawaran" => $penawaran[$key],
						"realisasi_nego_usd" => $realisasiusd[$key],
						"realisasi_nego_rp" => $realisasirp[$key],
						"realisasi_qty_unit"=>$realisasiqty[$key],
						"no_kontrak" => $nokontrak[$key],
						"tgl_kontrak"=> $tglkontrak[$key],
						"id_vendor" => $vendor[$key]
					);
				}
			}
			//echo json_encode($result);

		}

			/*$data = new stdClass();
			//$data = $this->input->post();
			
			$this->load->library('form_validation');
			$this->load->library('encryption');
			
			//validasi
			$this->form_validation->set_rules('no_srt_penunjukan', 'No. Penunjukan', 'required|is_unique[Pengadaan.no_srt_pelaksana]',
	        array(
	                'required'      => 'You have not provided %s.',
	                'is_unique'     => 'This %s already exists.'
	        ));
	        $this->form_validation->set_rules('no_usulan', 'No. Usulan', 'required');
	        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
	        $this->form_validation->set_rules('nominal_rp', 'Nominal Pengadaan', 'required');
	        
	        if ($this->form_validation->run() == FALSE){

	        	$errors = validation_errors();
	            $respons_ajax['type'] = 'error';
	            $respons_ajax['message'] = $errors;
	            echo json_encode($respons_ajax);

	        }else{

				$nopenunjukan = $this->input->post('no_srt_penunjukan');
				$tglminta = $this->input->post('tgl_minta');
				$nousulan = $this->input->post('no_usulan');
				$idtdr = $this->input->post('id_tdr');
				$perihal = $this->input->post('perihal');
				$tglawal = $this->input->post('tgl_awal');
				$tglakhir = $this->input->post('tgl_akhir');
				$nominalrp = $this->input->post('nominal_rp');
				$nominalusd = $this->input->post('nominal_usd');
				$bankgaransi = $this->input->post('bank_garansi');
			

				if($this->Pengadaan_model->save_Pengadaan($nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi))
				{
					
					$data->type = 'success';
					$data->message = 'Success!';
					
				}else{
					$data->type = 'failed';
					$data->message = 'Failed!';

				}
			
			echo json_encode($data);
			}
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}*/
	}

	public function get_detail()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$id = $this->input->post('id');
			if($this->input->post('ubah') == NULL){
				if($this->Pengadaan_model->get_pengadaan($id)){
					$data = new stdClass();
					$data->pengadaan = $this->Pengadaan_model->get_pengadaan($id);
					$data->detail = $this->Pengadaan_model->get_detail($id);
					echo json_encode($data);
						
				}else{

					echo json_encode($id);
				}
			}else{
				if($this->Pengadaan_model->get_pengadaan($id)){
					$data = $this->Pengadaan_model->get_pengadaan($id);
					echo json_encode($data);
						
				}else{

					echo json_encode($id);
				}
			}
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
			
	}

	public function get_kontrak(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$id = $this->input->post('no_kontrak');
			$tahun = $this->input->post('tahun');

			if($this->Pengadaan_model->get_kontrak($id, $tahun)){

				if($this->Pengadaan_model->get_kontrak($id, $tahun)->num_rows()>0){
					$data = new stdClass();

					$data->data = $this->Pengadaan_model->get_kontrak($id, $tahun)->result();
					$data->jml = $this->Pengadaan_model->get_kontrak($id, $tahun)->num_rows();
					echo json_encode($data);
				}else{
					$data = new stdClass();
					$data = $this->Pengadaan_model->get_nominal($id);
					$data->jml = $this->Pengadaan_model->get_kontrak($id, $tahun)->num_rows();
					echo json_encode($data);
				}
			}else{
				
				
				//echo json_encode($this->Pengadaan_model->get_kontrak($id, $tahun));
				echo json_encode($id);
			}
		}
	}

	public function input_invoice(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$this->load->library('encryption');
			
			$this->form_validation->set_rules('no_invoice', 'No. Invoice', 'required|is_unique[invoice.no_invoice]',
				array('is_unique' => 'The number %s already exists.'));
			$this->form_validation->set_rules('perihal','Perihal', 'required',
				array('required' => 'You have not provided %s.'));
			$this->form_validation->set_rules('nominal','Nominal', 'required',
				array('required' => 'You have not provided %s.'));
			$this->form_validation->set_rules('invoice_ke_user','Tanggal Invoice ke User', 'required',
				array('required' => 'You have not provided %s.'));

			if ($this->form_validation->run() == FALSE){
				$errors = validation_errors();
	            $respons_ajax['status'] = 'error';
	            $respons_ajax['pesan'] = $errors;
	            echo json_encode($respons_ajax);
	        }else{
	        	$this->Pengadaan_model->tambah_invoice();
				$respons_ajax['status'] = 'success';
				$respons_ajax['pesan'] = 'Register Success';
				echo json_encode($respons_ajax);		
	        }
	    }else{
			$this->load->helper('form');
			$this->load->view('login');
		}
/*
        tahun_pengadaan
no_kontrak
o_invoice
tgl_invoice
perihal
nominal
memo_keluar
invoice_ke_user*/
	}

	

	public function get_kewenangan(){
		$divisi = $this->input->post('divisi');

		foreach($this->Pengadaan_model->get_kewenangan($divisi) AS $result) {
			
			$row[] = $result->kewenangan;
			
		}
		echo json_encode($this->Pengadaan_model->get_kewenangan($divisi));
	}

	protected function _get_id_pengadaan($tahun)
	{

		if($this->Pengadaan_model->get_id_pengadaan($tahun)->num_rows() == 0){
			$idpengadaan = $tahun.'-0001';
		}else{
			$idlast = $this->Pengadaan_model->get_id_pengadaan($tahun)->row('id_pengadaan');
			$p = explode('-', $idlast);
			$idpengadaan = $tahun.'-'.str_pad((int) $p[1]+1,4,"0",STR_PAD_LEFT);
		}
		
		return $idpengadaan;

	}

}
