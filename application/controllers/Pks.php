<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pks extends CI_Controller {

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
		
		$this->load->model('Pks_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('form');
		$this->load->model('Tdr_model');

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'PKS';
			$data->select_tdr = $this->Tdr_model->select_tdr();
			$data->pks = $this->Pks_model->list_reminder(180);
			$data->role = $_SESSION['role'];
			$this->load->view('header', $data);
			$this->load->view('pks', $data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_data_pks()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Pks_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['tgl_minta'] = tanggal_indo($field->tgl_minta);
				$row['no_penunjukan'] = $field->no_srt_pelaksana;
				$row['no_usulan'] = $field->no_notin;
				$row['nm_vendor'] = $field->nm_vendor;
				$row['perihal'] = $field->perihal;
				$row['tgl_awal'] = tanggal_indo($field->tgl_krj_awal);
				$row['tgl_akhir'] = tanggal_indo($field->tgl_krj_akhir);
				$row['status'] = str_ireplace("_"," ",$field->status);
				$row['nominal'] = titik($field->nominal_rp);
				$row['beda'] = $field->beda;
				$row['segera'] = $field->segera;
				$row['id_pks'] = $field->id_pks;
				
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Pks_model->count_all(),
				"recordsFiltered"=>$this->Pks_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function add_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			//$data = $this->input->post();
			
			$this->load->library('form_validation');
			$this->load->library('encryption');
			
			//validasi
			$this->form_validation->set_rules('no_srt_penunjukan', 'No. Penunjukan', 'required|is_unique[pks.no_srt_pelaksana]',
	        array(
	                'required'      => 'You have not provided %s.',
	                'is_unique'     => 'This %s already exists.'
	        ));
	        $this->form_validation->set_rules('no_usulan', 'No. Usulan', 'required');
	        $this->form_validation->set_rules('perihal', 'Perihal', 'required');
	        $this->form_validation->set_rules('nominal_rp', 'Nominal PKS', 'required');
	        
	        if ($this->form_validation->run() == FALSE){

	        	$errors = validation_errors();
	            $respons_ajax['type'] = 'error';
	            $respons_ajax['message'] = $errors;
	            echo json_encode($respons_ajax);

	        }else{

				$nopenunjukan = $this->input->post('no_srt_penunjukan');
				$tglminta = $this->input->post('tgl_minta');
				$date = date_create($tglminta);
				$year = date_format($date, "Y");
				$nousulan = $this->input->post('no_usulan');
				$idtdr = $this->input->post('id_tdr');
				$perihal = $this->input->post('perihal');
				$tglawal = $this->input->post('tgl_awal');
				$tglakhir = $this->input->post('tgl_akhir');
				$nominalrp = $this->input->post('nominal_rp');
				$nominalusd = $this->input->post('nominal_usd');
				$bankgaransi = $this->input->post('bank_garansi');
				$id = $this->_get_id($year);

				if($this->Pks_model->save_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi))
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
		}
	}

	protected function _get_id($year)
	{
		if($this->Pks_model->last_id($year)->num_rows() > 0){
			$lastid = $this->Pks_model->last_id($year)->row('id_pks');
			$uniq = explode('-', $lastid);
			return 'PKS-'.$year.'-'.str_pad((int) $uniq[3]+1,3,"0",STR_PAD_LEFT);
		}else{
			return 'PKS-'.$year.'-001';
		}
	}

	public function get_detail()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			$id = $this->input->post('id');
			if($this->input->post('ubah') == NULL){
				if($this->Pks_model->get_detail($id)){
					$data = new stdClass();
					$data->pks = $this->Pks_model->get_detail($id);
					$data->comment = $this->Pks_model->get_comment($id);
					echo json_encode($data);
						
				}else{

					echo json_encode($id);
				}
			}else{
				if($this->Pks_model->get_detail($id)){
					$data = $this->Pks_model->get_detail($id);
					echo json_encode($data);
						
				}else{

					echo json_encode($nopenunjukan);
				}
			}
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
			
	}

	public function add_comment()
	{	
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			date_default_timezone_set("Asia/Bangkok");
			$id_pks = $this->input->post('id');
			$comment = $this->input->post('comment');
			$comment_date = date('Y-m-d H:i:s');
			$comment_by = $_SESSION['username'];
			$comment_name = $_SESSION['nama'];

			//$comment_id = $this->Comment_model->get_id_comment($nopenunjukan);
			
			if($this->Pks_model->get_id_comment($id_pks)->num_rows() > 0){

				$idlast = $this->Pks_model->get_id_comment($id_pks)->row()->id_comment;
				$id = explode("_", $idlast);
				$id = "comm_".$id_pks.'_'.STR_PAD((int) $id[2]+1, 3, "0", STR_PAD_LEFT);
				//echo json_encode($id);

			}else{

				$id = "comm_".$nopenunjukan.'_001';
			}

			
			if($this->Pks_model->input_comment($id, $id_pks, $comment, $comment_by, $comment_date))
			{	
				$data = new stdClass();
				$data->comment = $comment;
				$data->comment_date = $comment_date;
				$data->nama = $comment_name;
				$data->type = 'success';
				$data->message = 'Berhasil';
				$data->comment_id = $id;
				echo json_encode($data);
			}else{

				$data->type = 'error';
				$data->message = 'Gagal';
				echo json_encode($data);
			}
		
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		} //cek session
	}

	public function delete_pks()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$id = $this->input->post('id');
			$data = new stdClass();
			if($this->Pks_model->delete_pks($id))
			{	
				$data->type = 'success';
				$data->message = 'Berhasil';

				
			}else{
			
				$data->type = 'error';
				$data->message = 'Gagal';
			
			}

			echo json_encode($data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function update_pks()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			//$id = $this->input->post('id');
			$id = $this->input->post('id_pks');
			$nopenunjukan = $this->input->post("no_srt_penunjukan");
			$tglminta = $this->input->post("tgl_minta");
			$nousulan = $this->input->post("no_usulan");
			$idtdr = $this->input->post("id_tdr");
			$perihal = $this->input->post("perihal");
			$tglawal = $this->input->post("tgl_awal");
			$tglakhir = $this->input->post("tgl_akhir");
			$nominalrp = $this->input->post("nominal_rp");
			$nominalusd = $this->input->post("nominal_usd");
			$bankgaransi = $this->input->post("bank_garansi");
			$tgldraftdarilegal = $this->input->post("tgl_draft_dari_legal");
			$tgldraftkeuser = $this->input->post("tgl_draft_ke_user");
			$tgldraftkevendor = $this->input->post("tgl_draft_ke_vendor");
			$tglreviewkelegal = $this->input->post("tgl_review_ke_legal");
			$tglttdkevendor = $this->input->post("tgl_ttd_ke_vendor");
			$tglttdkepemimpin = $this->input->post("tgl_ttd_ke_pemimpin");
			$tglserahterimapks = $this->input->post("tgl_serahterima_pks");
			$tglpks = $this->input->post("tgl_pks");
			$nopks = $this->input->post("no_pks");
			$data = new stdClass();

			//if($this->Pks_model->)
			if($this->Pks_model->update_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi,$tgldraftdarilegal, $tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks, $tglpks, $nopks))
			{	
				$data->type = 'success';
				$data->message = 'Berhasil';

				
			}else{
			
				$data->type = 'error';
				$data->message = 'Gagal';
			
			}

			echo json_encode($data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	function proses_pks(){
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			//echo json_encode($this->input->post());
			$data = new stdClass();
			$id = $this->input->post('id');
			$tgldraftdarilegal = $this->input->post('tgl_draft_dari_legal');
			$tgldraftkeuser = $this->input->post('tgl_draft_ke_user');
			$tgldraftkevendor = $this->input->post('tgl_draft_ke_vendor');
			$tglreviewkelegal = $this->input->post('tgl_review_ke_legal');
			$tglttdkevendor = $this->input->post('tgl_ttd_ke_vendor');
			$tglttdkepemimpin = $this->input->post('tgl_ttd_ke_pemimpin');
			$tglserahterimapks = $this->input->post('tgl_serahterima_pks');
			$nopks = $this->input->post('no_pks');
			$tglpks = $this->input->post('tgl_pks');

			if($this->Pks_model->proses_pks($id,$tgldraftdarilegal,$tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks,$nopks,$tglpks))
			{
				$data->type = 'success';
				$data->message = 'Berhasil';

			}else{
				$data->type = 'error';
				$data->message = 'Gagal';
			}

			echo json_encode($data);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}


}
