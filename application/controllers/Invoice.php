<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

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
		$this->load->model('Invoice_model');
		$this->load->library('form_validation');
		date_default_timezone_set("Asia/Bangkok");
	}	
	public function index()
	{
		$this->load->helper('form');
		if(isset($_SESSION['username'])){
			$data = new stdClass();
			
			$data->title = 'Welcome '.$_SESSION['nama'].'!';
			$data->pks = $this->Pks_model->list_reminder(180);
			$data->year = $this->Invoice_model->get_year()->result();
			$data->get_select_status = $this->Invoice_model->get_select_status()->result();
			$this->load->view('header', $data);
			$this->load->view('invoice');
		
		}else{
		
		$this->load->view('login');
		
		}

	}

	public function detail_tdr($id = null)
	{

		if($this->Tdr_model->get_detail_tdr($id)->num_rows() > 0){
			$sql = $this->Tdr_model->get_detail_tdr($id);

			echo json_encode($sql->row());
		}else{
			echo json_encode(null);
		}
	}

	public function get_data_invoice()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$list = $this->Invoice_model->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {
				
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['id_invoice'] = $field->id_invoice;
				$row['nm_vendor'] = $field->nm_vendor;
				$row['tgl_input'] = tanggal($field->tgl_input);
				$row['no_invoice'] = $field->no_invoice;
				$row['memo_keluar'] = $field->memo_keluar;
				$row['no_kontrak'] = $field->no_kontrak;
				$row['nominal'] = titik($field->nominal);
				$row['perihal'] = $field->perihal;
				$row['tgl_invoice'] = tanggal($field->tgl_invoice);
				$row['tgl_invoice_diantar'] = tanggal($field->tgl_invoice_diantar);
				$row['tgl_invoice_kembali'] = tanggal($field->tgl_invoice_kembali);
				$row['tgl_kebagian_pembayaran'] = tanggal($field->tgl_kebagian_pembayaran);
				$row['status'] = $field->status;
				$row['keterangan'] = $field->keterangan;
				//$row['setting'] = $field->setting;

				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Invoice_model->count_all(),
				"recordsFiltered"=>$this->Invoice_model->count_filtered(),
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
		
		if(file_exists($file)){
			$pdf = file_get_contents($file);
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
	   		echo "Sorry file doesn't exist... :(";
	   	}
	}

	protected function get_stat_pdf($id)
	{
		$file = $this->get_dir($id);
		if(file_exists($file)){
			return $id;
		}else{
			return null;
		}
	}

	protected function get_dir($id){
		$dir = $this->Tdr_model->get_dir($id)->row('defaultnya');
		$file = $this->Tdr_model->get_file($id)->row('file_tdr');

		return $dir.$file;
	}

	public function get_tdr(){
		echo json_encode($this->Tdr_model->select_tdr());
	}

	public function edit_tdr()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){

				//validate
				$this->form_validation->set_rules('no_vendor', 'No. TDR', 'required');
				$this->form_validation->set_rules('no_vendor', 'No Vendor', 'required');
				$this->form_validation->set_rules('nm_vendor', 'Nama Vendor', 'required');
				$this->form_validation->set_rules('alamat', 'Alamat Vendor', 'required');
				$this->form_validation->set_rules('bidang', 'Bidang Pekerjaan', 'required');
				$this->form_validation->set_rules('tgl_berlaku', 'Tgl. Mulai Berlaku', 'required');
				$this->form_validation->set_rules('tgl_berakhir', 'Tgl. Berakhir', 'required');
				$this->form_validation->set_rules('kualifikasi', 'Kualifikasi Vendor', 'required');
				//$this->form_validation->set_rules('file_tdr', 'File TDR', 'required');
					
				if ($this->form_validation->run() == false) {
					
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
					
				} else {
					$id = $this->input->post('id_vendor');
					$no = $this->input->post('no_vendor');
					$nm = $this->input->post('nm_vendor');
					$alt = $this->input->post('alamat');
					$bid = $this->input->post('bidang');
					$tglawal = tanggal1($this->input->post('tgl_berlaku'));
					$tglakhir = tanggal1($this->input->post('tgl_berakhir'));
					$kualifikasi = $this->input->post('kualifikasi');
					$file = $this->input->post('file_tdr');

					if($this->Tdr_model->update($id, $no, $nm, $alt, $bid, $tglawal, $tglakhir, $kualifikasi, $file))
					{
						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			        }else{
			        	$data = new stdClass();
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

	public function add_tdr()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){
				//validate
				$this->form_validation->set_rules('no_vendor', 'No. TDR', 'required');
				$this->form_validation->set_rules('no_vendor', 'No Vendor', 'required');
				$this->form_validation->set_rules('nm_vendor', 'Nama Vendor', 'required');
				$this->form_validation->set_rules('alamat', 'Alamat Vendor', 'required');
				$this->form_validation->set_rules('bidang', 'Bidang Pekerjaan', 'required');
				$this->form_validation->set_rules('tgl_berlaku', 'Tgl. Mulai Berlaku', 'required');
				$this->form_validation->set_rules('tgl_berakhir', 'Tgl. Berakhir', 'required');
				$this->form_validation->set_rules('kualifikasi', 'Kualifikasi Vendor', 'required');
				//$this->form_validation->set_rules('file_tdr', 'File TDR', 'required');
					
				if ($this->form_validation->run() == false) {
					
					$data = new stdClass();
					$errors = validation_errors();

		            $data->type = 'error';
		            $data->pesan = $errors;
					
				} else {
					$id = uniqid();
					$no = $this->input->post('no_vendor');
					$nm = $this->input->post('nm_vendor');
					$alt = $this->input->post('alamat');
					$bid = $this->input->post('bidang');
					$tglawal = tanggal1($this->input->post('tgl_berlaku'));
					$tglakhir = tanggal1($this->input->post('tgl_berakhir'));
					$kualifikasi = $this->input->post('kualifikasi');
					$file = $this->input->post('file_tdr');

					if($this->Tdr_model->new_data($id, $no, $nm, $alt, $bid, $tglawal, $tglakhir, $kualifikasi, $file))
					{
						$data = new stdClass();
						$data->type = 'success';
			            $data->pesan = 'Berhasil';
			        }else{
			        	$data = new stdClass();
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

}
