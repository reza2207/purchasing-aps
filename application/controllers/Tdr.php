<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tdr extends CI_Controller {

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
		
		$this->load->model('Tdr_model');
		$this->load->helper('terbilang_helper');
		$this->load->helper('tanggal_helper');
		$this->load->model('Pks_model');
	}	
	public function index()
	{
		$this->load->helper('form');
		if(isset($_SESSION['username'])){
			$data = new stdClass();
			
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->pks = $this->Pks_model->list_reminder(180);
			$data->tdr = $this->Tdr_model->get_reminder()->num_rows();
			$this->load->view('header', $data);
			$this->load->view('tdr');
		
		}else{
		
		$this->load->view('login');
		
		}

	}

	public function detail_tdr($id){

		$data = new stdClass();
		//$sql = $this->tdr_model->list_tdr();
		$sql = $this->Tdr_model->get_detail_tdr($id);

		echo json_encode($sql->result());

	}

	public function get_data_tdr()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Tdr_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['id_vendor'] = $field->id_vendor;
				$row['no_srt_vendor'] = $field->no_srt_vendor;
				$row['nm_vendor'] = $field->nm_vendor;
				$row['sub_bdg_usaha'] = $field->sub_bdg_usaha;
				$row['kualifikasi'] = $field->kualifikasi;
				$row['tgl_mulai'] = tanggal($field->tgl_mulai);
				$row['tgl_akhir'] = tanggal($field->tgl_akhir);
				$row['alamat'] = $field->alamat;
				$row['file_tdr'] = $field->file_tdr;
				$row['datedif'] = $field->diff;
				$row['status'] = $field->status;
				$row['setting'] = $field->setting;

				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Tdr_model->count_all(),
				"recordsFiltered"=>$this->Tdr_model->count_filtered(),
				"data"=>$data,
			);
			echo json_encode($output);
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function get_pdf()
	{
		$id = $_GET['id'];
		$file = $this->get_dir($id);
		$pdf = file_get_contents($file);
		if(file_exists($file)){
	       	header('Content-Type: application/pdf');
	       	header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
	       header('Pragma: public');
	       header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	       header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	       header('Content-Length: '.strlen($pdf));
	       header('Content-Disposition: inline; filename="'.basename($file_name).'";');
	       ob_clean(); 
	       flush(); 
	       echo $pdf;
	   	}else{
	   		echo $this->get_dir($id);
	   	}
	}

	public function get_dir($id){
		$dir = $this->Tdr_model->get_dir($id)->row('defaultnya');
		$file = $this->Tdr_model->get_file($id)->row('file_tdr');

		return $dir.$file;
	}

	public function get_tdr(){
		echo json_encode($this->Tdr_model->select_tdr());
	}

}
