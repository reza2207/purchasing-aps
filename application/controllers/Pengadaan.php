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
		$this->load->model('Invoice_model');
		date_default_timezone_set("Asia/Jakarta");

	}	
	public function index()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$data = new stdClass();
			$data->title = 'Pengadaan';
			$data->page = 'Pengadaan';
			$data->role = $_SESSION['role'];
			$data->select_tdr = $this->Tdr_model->select_tdr();
			$data->tahun = $this->Pengadaan_model->get_tahun();
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
			$no = $this->input->post('start');
			foreach ($list as $field) {
				$no++;
				$row = array();
				$row['no'] = $no;
				$row['no_notin'] = $field->no_notin;
				$row['tgl_notin'] = tgl_indo($field->tgl_notin);
				$row['jenis_notin_masuk'] = $field->jenis_notin_masuk;
				$row['tgl_disposisi'] = tgl_indo($field->tgl_disposisi);
				$row['perihal'] = $field->perihal;
				$row['jenis_pengadaan'] = $field->jenis_pengadaan;
				$row['divisi'] = $field->divisi;
				$row['kewenangan'] = $field->kewenangan;
				$row['id_pengadaan'] = $field->id_pengadaan;
				$row['no_id'] = $field->no;
				$row['nego'] = $field->nego;
				$row['realisasi'] = titik($field->realisasi);
				$row['file'] = $field->file;
				$data[] = $row;
				
			}

			$output = array(
				"draw"=> $_POST['draw'], 
				"recordsTotal" =>$this->Pengadaan_model->count_all(),
				"recordsFiltered"=>$this->Pengadaan_model->count_filtered(),
				"data"=>$data,
			);
			return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($output));
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	public function submit_new_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{

			if($this->input->post(null)){
				$this->load->library('form_validation');

				$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');
				$this->form_validation->set_rules('tgl_disposisi', 'Tgl. Disposisi', 'required');
				$this->form_validation->set_rules('tahun_pengadaan', 'Tahun Pengadaan', 'required');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');
				if($this->input->post('divisi') == 'BSK'){
					$this->form_validation->set_rules('kelompok', 'Kelompok', 'required');
				}

				if($this->input->post('jenis_surat') == 'Permintaan Ulang'){
					$this->form_validation->set_rules('id_pengadaan','Id Pengadaan Sebelumnya','required');
				}
				$this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');//
				$this->form_validation->set_rules('jenis_pengadaan', 'Jenis Pengadaan', 'required');
				if(($this->input->post('jenis_pengadaan')!= 'Pembelian Langsung') &&	 ($this->input->post('jenis_pengadaan')!= '')){
					
				}
				$this->form_validation->set_rules('kewenangan', 'Kewenangan', 'required');

				//validate array
				$this->form_validation->set_rules('item[]', 'Item', 'required');
				$this->form_validation->set_rules('ukuran[]', 'Ukuran', 'required');
				$this->form_validation->set_rules('bahan[]', 'Bahan', 'required');
				$this->form_validation->set_rules('jumlah[]', 'Jumlah', 'required');
				$this->form_validation->set_rules('satuan[]', 'Satuan', 'required');
				$this->form_validation->set_rules('hpssatuan[]', 'Hps Satuan', 'required');
				$this->form_validation->set_rules('penawaran[]', 'Harga Penawaran', 'required|trim|numeric');
				$this->form_validation->set_rules('realisasirp[]', 'Harga Realisasi', 'required');
				$this->form_validation->set_rules('realisasiqty[]', 'Qty Realisasi', 'required');
				$this->form_validation->set_rules('nokontrak[]', 'No. Kontrak', 'required');
				$this->form_validation->set_rules('tglkontrak[]', 'Tgl. Kontrak', 'required');
				$this->form_validation->set_rules('vendor[]', 'Vendor', 'required');

				if ($this->form_validation->run() == false) 
				{
					$data = new stdClass();
					$errors = validation_errors();
					$data->type = 'error';
		            $data->pesan = $errors;
		            echo json_encode($data);
					
				}else{

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
					$keterangan = $this->input->post('keterangan');
					$kewenangan = $this->input->post('kewenangan');
					//$idr = $this->input->post('id_pengadaan');
					$id = $this->_get_id_pengadaan($tahun);
					//array
					$item = $this->input->post('item');
					$ukuran = $this->input->post('ukuran');
					$bahan = $this->input->post('bahan');
					$jumlah = $this->input->post('jumlah');
					$satuan = $this->input->post('satuan');
					$hpssatuan = $this->input->post('hpssatuan');
					$penawaran = $this->input->post('penawaran');
					$realisasiusd = $this->input->post('realisasiusd');
					$realisasirp = $this->input->post('realisasirp');
					$realisasiqty = $this->input->post('realisasiqty');
					$nokontrak = $this->input->post('nokontrak');
					$tglkontrak = $this->input->post('tglkontrak');
					$vendor = $this->input->post('vendor');

					foreach($item AS $key => $val){
						$result[] = array(
							"id_pengadaan" => $id,
							"id_pengadaan_uniq" => $id.'-'.str_pad($key,3,"0",STR_PAD_LEFT),
							"item" =>$item[$key],
							"ukuran" =>$ukuran[$key],
							"bahan" => $bahan[$key],
							"jumlah" => $jumlah[$key],
							"satuan" => $satuan[$key],
							"hps_satuan"=> $hpssatuan[$key],
							"penawaran" => $penawaran[$key],
							"realisasi_nego_usd" => $realisasiusd[$key],
							"realisasi_nego_rp" => $realisasirp[$key],
							"realisasi_qty_unit"=>$realisasiqty[$key],
							"no_kontrak" => $nokontrak[$key],
							"tgl_kontrak"=> tanggal1($tglkontrak[$key]),
							"id_vendor" => $vendor[$key]
						);
					}
       

					if($this->Pengadaan_model->add_new($jenispengadaan,$tglsurat,$nosurat,$jenissurat,$tgldisposisi,$tahun,$perihal,$nousulan,$tglusulan,$divisi,$kelompok,$keterangan,$kewenangan,$id) && $this->db->insert_batch('detail_item_pengadaan', $result))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
						
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';
						

					}

					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
				}
			}else{
				show_404();
			}

		}else{
			show_404();
		}

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
					$tgl_awal = $this->Pengadaan_model->get_pengadaan($id)->tgl_disposisi;
					$tgl_akhir = $this->Pengadaan_model->get_tgl_kontrak($id);
					//$data->sli = '0';
					$data->sli = $this->_get_sli($tgl_awal, $tgl_akhir);
					
					echo json_encode($data);
						
				}else{

					echo json_encode($this->Pengadaan_model->get_detail_row($id)->row());
				}
			}else{
				if($this->Pengadaan_model->get_pengadaan($id)){
					$data = $this->Pengadaan_model->get_pengadaan($id);
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
						
				}else{

					return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($id));
				}
			}
		}else{
			$this->load->helper('form');
			$this->load->view('login');
		}
			
	}

	public function get_kontrak(){

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

			if($this->input->post(null)){
				$id = $this->input->post('no_kontrak');
				$tahun = $this->input->post('tahun');
				$idpengadaan = $this->input->post('id');

				if($this->Pengadaan_model->get_kontrak($id, $tahun)){

					if($this->Pengadaan_model->get_kontrak($id, $tahun)->num_rows()>0){
						$data = new stdClass();

						$data->data = $this->Pengadaan_model->get_kontrak($id, $tahun)->result();
						$data->jml = $this->Pengadaan_model->get_kontrak($id, $tahun)->num_rows();
						return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
					}else{
						$data = new stdClass();
						$data = $this->Pengadaan_model->get_nominal($id, $idpengadaan);
						$data->jml = $this->Pengadaan_model->get_kontrak($id, $tahun, $idpengadaan)->num_rows();
						return $this->output
				        ->set_content_type('application/json')
				        ->set_output(json_encode($data));
					}
				}else{
					
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($id));
				}
			}else{
				show_404();
			}
		}
	}

	public function input_invoice()
	{

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			$this->load->library('form_validation');
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
	            $data['status'] = 'error';
	            $data['pesan'] = $errors;
	            return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
	        }else{
	        	$this->Pengadaan_model->tambah_invoice();
				$data['status'] = 'success';
				$data['pesan'] = 'Register Success';
						
	        }
	        return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
	    }else{
			$this->load->helper('form');
			$this->load->view('login');
		}
	}

	

	public function get_kewenangan()
	{
		$divisi = $this->input->post('divisi');

		/*foreach($this->Pengadaan_model->get_kewenangan($divisi) AS $result) {
			
			$row[] = $result->kewenangan;
			
		}*/
		return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->Pengadaan_model->get_kewenangan($divisi)));
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

	public function submit_invoice()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			if($this->input->post(null)){

				$this->load->library('form_validation');

				$this->form_validation->set_rules('tahun', 'Tahun', 'required');
				$this->form_validation->set_rules('id_vendor', 'Nama Vendor', 'required');
				$this->form_validation->set_rules('no_invoice', 'No. Invoice', 'required|max_length[35]|is_unique[invoice.no_invoice]');
				$this->form_validation->set_rules('no_kontrak', 'No. Kontrak', 'required');
				$this->form_validation->set_rules('nominal', 'Nominal', 'required|max_length[10]');
				$this->form_validation->set_rules('perihal', 'Perihal', 'required|max_length[250]');
				$this->form_validation->set_rules('tgl_invoice', 'Tgl. Invoice', 'required');
				$this->form_validation->set_rules('invoice_ke_user', 'Tgl. Invoice ke User', 'required');


				if ($this->form_validation->run() == false) 
				{
					$data = new stdClass();
					$errors = validation_errors();
					$data->type = 'error';
		            $data->pesan = $errors;
					
				}else{

					$tahun = $this->input->post('tahun');
					$nokontrak = $this->input->post('no_kontrak');
					$noinv = $this->input->post('no_invoice');
					$tglinv = tanggal1($this->input->post('tgl_invoice'));
					$perihal = $this->input->post('perihal');
					$nominal = $this->input->post('nominal');
					$memo = $this->input->post('memo_keluar');
					$invkeuser = tanggal1($this->input->post('invoice_ke_user'));
					$idvendor = $this->input->post('id_vendor');
					$tglinput = date('Y-m-d');
					$idinv = uniqid();

					if($this->Invoice_model->submit_invoice($idinv, $tglinput, $idvendor, $noinv, $memo, $nokontrak, $nominal, $perihal, $tglinv, $invkeuser, $tahun))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';

					}
				}
				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));


			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function get_file()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			$id = $_GET['file'];
			$tahun = $_GET['tahun'];
			$dir = $this->Setting_model->get_dir_file($tahun)->row('defaultnya');
			$file = $dir.$id;
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
		   		echo "Sorry file doesn't exist, please contact administrator... :(";
		   	}

		}else{
			show_404();
		}

	}

	protected function _get_sli($tgl_awal, $tgl_akhir)
	{
		$tl = $this->Setting_model->get_tgl_libur($tgl_awal, $tgl_akhir);
		if($tl->num_rows()>0){
			foreach($tl->result_array() AS $r){
				$tgl_libur[] = $r['tgl'];
			}
		}else{
			$tgl_libur = array("0000-00-00");
		}
		return jmlharikerja($tgl_awal, $tgl_akhir, $tgl_libur);
		//return $tgllibur;
	}

	public function update_inv()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$id = $this->input->post('id');
				$tgl = tanggal1($this->input->post('tgl'));
				$j = $this->input->post('j');
				if($j == 'tk'){

					if($this->Invoice_model->update_tk($id, $tgl))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';
						
					}

					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
				}elseif($j == 'tp'){
					if($this->Invoice_model->update_tp($id, $tgl))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';
					}
					return $this->output
			        ->set_content_type('application/json')
			        ->set_output(json_encode($data));
				}
			}


		}else{

			show_404();
		}
	}

	public function tgl_libur()
	{
		if(isset($_GET['awal']) && isset($_GET['akhir'])){
			$tgl_awal = $_GET['awal'];
			$tgl_akhir = $_GET['akhir'];
			$tl = $this->Setting_model->get_tgl_libur($tgl_awal, $tgl_akhir);
			if($this->Setting_model->get_tgl_libur($tgl_awal, $tgl_akhir)->num_rows() > 0){
				foreach($tl->result_array() AS $r){
					$tgl_libur[] = $r['tgl'].'|'.$r['keterangan'];
					
				}
			}else{
				$tgl_libur = null;
			}
			echo '<pre>';
			print_r($tgl_libur);
			echo '</pre>';
		}else{
			echo "cara penggunaannya<br>";
			echo '- masukkan parameter tanggal awal dan akhir<br>';
			echo '- dipisahkan dengan simbol &<br>';
			echo '- contoh: ?awal=2019-08-19&akhir=2019-10-22<br>';
			echo '- url lengkapnya: pengadaan/tgl_libur?awal=2019-08-19&akhir=2019-10-22';
			
		}
	}

	public function hapus()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$id = $this->input->post('id');

				if($this->Pengadaan_model->hapus_data($id) && $this->Pengadaan_model->hapus_detail($id))
				{

					$data = new stdClass();
					$data->type = 'success';
					$data->pesan = 'Success';
					
				}else{
					$data = new stdClass();
					$data->type = 'error';
					$data->pesan = 'Failed';
					
				}

				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function update_row()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true)
		{
			if($this->input->post(null))
			{
				$data = new stdClass();

				$item = $this->input->post('item');
				$id = $this->input->post('id_row');
				$idp = $this->input->post('id');
				$ukuran = $this->input->post('ukuran');
				$bahan = $this->input->post('bahan');
				$jumlah = $this->input->post('jumlah');
				$satuan = $this->input->post('satuan');
				$hpssatuan = $this->input->post('hpssatuan');
				$penawaran = $this->input->post('penawaran');
				$realisasiusd = $this->input->post('realisasiusd');
				$realisasirp = $this->input->post('realisasirp');
				$realisasiqty = $this->input->post('realisasiqty');
				$nokontrak = $this->input->post('nokontrak');
				$tglkontrak = $this->input->post('tglkontrak');
				$vendor = $this->input->post('vendor');

				if($this->Pengadaan_model->update_row($idp, $id, $item, $ukuran, $bahan, $jumlah, $satuan, $hpssatuan, $penawaran, $realisasiusd, $realisasirp, $realisasiqty, $nokontrak, $tglkontrak, $vendor))
				{

					$data->type = 'success';
					$data->pesan = 'Success';
					
				}else{
					
					$data->type = 'error';
					$data->pesan = 'Failed';
					
				}

				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));

			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function hapus_row()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null))
			{
				$this->input->post('id');
				$data = new stdClass();
				if($this->Pengadaan_model->hapus_row($id))
				{
					$data->type = 'success';
					$data->pesan = 'Success';
					
				}else{
					
					$data->type = 'error';
					$data->pesan = 'Failed';
					
				}

				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function update_data()
	{	
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){

				$this->load->library('form_validation');

				$this->form_validation->set_rules('tahun_pengadaan', 'Tahun Pengadaan', 'required');//
				$this->form_validation->set_rules('tgl_surat', 'Tgl. Surat', 'required');//
				$this->form_validation->set_rules('no_surat', 'No. Surat', 'required');//
				$this->form_validation->set_rules('tgl_disposisi', 'Tgl. Disposisi', 'required');//
				
				$this->form_validation->set_rules('perihal', 'Perihal', 'required');//
				$this->form_validation->set_rules('divisi', 'Divisi', 'required');//
				$this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');//
				$this->form_validation->set_rules('jenis_pengadaan', 'Jenis Pengadaan', 'required');//

				if ($this->form_validation->run() == false) 
				{
					$data = new stdClass();
					$errors = validation_errors();
					$data->type = 'error';
		            $data->pesan = $errors;
					
				}else{

					$id = $this->input->post('id_pengadaan');
					$tahun = $this->input->post('tahun_pengadaan');//
					$tglsurat = tanggal1($this->input->post('tgl_surat'));//
					$nosurat = $this->input->post('no_surat');//
					$jenissurat = $this->input->post('jenis_surat');//
					$tgldisposisi = tanggal1($this->input->post('tgl_disposisi'));//
					$divisi = $this->input->post('divisi');//
					$kelompok = $this->input->post('kelompok');
					$jenispengadaan = $this->input->post('jenis_pengadaan');//
					$perihal = $this->input->post('perihal');//
					$nousulan = $this->input->post('no_usulan');
					$tglusulan = tanggal1($this->input->post('tgl_usulan'));
					$keterangan = trim($this->input->post('keterangan'));
					$kewenangan = $this->input->post('kewenangan');
					$file = $this->input->post('file');

					if($this->Pengadaan_model->update($jenispengadaan,$tglsurat,$nosurat,$jenissurat,$tgldisposisi,$tahun,$perihal,$nousulan,$tglusulan,$divisi,$kelompok,$keterangan,$kewenangan,$id,$file))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';

					}

				}
				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
			}else{
				show_404();
			}
		}else{
			show_404();
		}
	}

	public function add_row()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{
			if($this->input->post(null)){
				$this->load->library('form_validation');
				$data = new stdClass();
				//validate array
				
				$this->form_validation->set_rules('bahan[]', 'Bahan', 'required');
				$this->form_validation->set_rules('hpssatuan[]', 'Hps Satuan', 'required');
				$this->form_validation->set_rules('item[]', 'Item', 'required');
				$this->form_validation->set_rules('jumlah[]', 'Jumlah', 'required');
				$this->form_validation->set_rules('ukuran[]', 'Ukuran', 'required');
				$this->form_validation->set_rules('satuan[]', 'Satuan', 'required');
				$this->form_validation->set_rules('penawaran[]', 'Harga Penawaran', 'required|trim|numeric');
				$this->form_validation->set_rules('realisasirp[]', 'Harga Realisasi', 'required');
				$this->form_validation->set_rules('realisasiqty[]', 'Qty Realisasi', 'required');
				$this->form_validation->set_rules('nokontrak[]', 'No. Kontrak', 'required');
				$this->form_validation->set_rules('tglkontrak[]', 'Tgl. Kontrak', 'required');
				$this->form_validation->set_rules('vendor[]', 'Vendor', 'required');

				if ($this->form_validation->run() === false) 
				{
					
					$errors = validation_errors();
					$data->type = 'error';
		            $data->pesan = $errors;
		            					
				}else{
					$bahan = $this->input->post('bahan');
					$hpssatuan = $this->input->post('hpssatuan');
					$item = $this->input->post('item');
					$ukuran = $this->input->post('ukuran');
					$vendor = $this->input->post('vendor');
					$jumlah = $this->input->post('jumlah');
					$nokontrak = $this->input->post('nokontrak');
					$tglkontrak = $this->input->post('tglkontrak');
					$penawaran = $this->input->post('penawaran');
					$realisasiqty = $this->input->post('realisasiqty');
					$realisasirp = $this->input->post('realisasirp');
					$realisasiusd = $this->input->post('realisasiusd');
					$satuan = $this->input->post('satuan');
					$idp = $this->input->post('idpengadaan');

					if($this->Pengadaan_model->get_last_id_d($idp)->num_rows() > 0){
						$idl =$this->Pengadaan_model->get_last_id_d($idp)->row('id_pengadaan_uniq');
						$t = explode('-', $idl);
						$urut = (int) $t[2];
						//$idb = $idp.'-'.str_pad((int) $urut+1,4,"0",STR_PAD_LEFT);
					}else{
						$urut = 0;
						//$idb = $idp.'-0001';
					}

					foreach($item AS $key => $val){
						$urut++;
						$result[] = array(
							"id_pengadaan" => $idp,
							"id_pengadaan_uniq" => $idp.'-'.str_pad($urut,3,"0",STR_PAD_LEFT),
							"item" =>$item[$key],
							"ukuran" =>$ukuran[$key],
							"bahan" => $bahan[$key],
							"jumlah" => $jumlah[$key],
							"satuan" => $satuan[$key],
							"hps_satuan"=> $hpssatuan[$key],
							"penawaran" => $penawaran[$key],
							"realisasi_nego_usd" => $realisasiusd[$key],
							"realisasi_nego_rp" => $realisasirp[$key],
							"realisasi_qty_unit"=>$realisasiqty[$key],
							"no_kontrak" => $nokontrak[$key],
							"tgl_kontrak"=> tanggal1($tglkontrak[$key]),
							"id_vendor" => $vendor[$key]
						);
					}

					if($this->db->insert_batch('detail_item_pengadaan', $result))
					{
						$data = new stdClass();
						$data->type = 'success';
						$data->pesan = 'Success';
					
						
					}else{
						$data = new stdClass();
						$data->type = 'error';
						$data->pesan = 'Failed';
					
					
			        }

				}

				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));

			}
		}
	}

	public function hapus_data_inv()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{	
			if($this->input->post(null)){

				$id = $this->input->post('id');
				$data = new stdClass();
				if($this->Invoice_model->hapus_inv($id))
				{
					$data->type = 'success';
					$data->pesan = 'Success';
					
				}else{
				
					$data->type = 'error';
					$data->pesan = 'Failed';
				}
				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));

			}else{
				show_404();
			}
		}else{
			redirect('');
		}
	}

	

	public function get_p()
	{
		$tahun = $this->input->post('tahun');
		$divisi = $this->input->post('divisi');
		$row = $this->get_d_p($tahun);

		$row['divisi'] = $this->get_div($tahun);

		echo json_encode($row);
	}

	public function get_report()
	{
		$tahun = $this->input->post('tahun');
		$divisi = $this->input->post('divisi');
		$row = $this->get_d_r($tahun);

		return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($row));
	}
	private function get_d_r($tahun = null, $divisi = null)
	{
		$r = $this->Pengadaan_model->get_data_p_d($tahun, $divisi)->result();
		for($i = 0;$i < count($r);$i++){
				
				$row[] = $r[$i]->divisi.'|'.$r[$i]->jenis.'|'.$r[$i]->jml;
			
		}
		return $row;
	}

	private function get_d_p($tahun = null, $divisi = null)
	{
		
		
		$r = $this->Pengadaan_model->get_data_p_d($tahun, $divisi)->result();
		//$jmldiv = $this->Pengadaan_model->get_div($tahun)->num_rows();
		for($i = 0;$i < count($r);$i++){
				
				$row['trans'][$r[$i]->jenis][] = $r[$i]->jml;
				$row['jenis'][$r[$i]->jenis] = $r[$i]->jenis;
			
		}
		return $row;
		
	}

	private function get_div($tahun)
	{
		$r = $this->Pengadaan_model->get_div($tahun)->result();
		for($i = 0;$i < count($r);$i++){
				
				$row[] = $r[$i]->divisi;
			
		}
		return $row;
	}

	public function update_file()
	{
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) 
		{	
			if($this->input->post(null)){

				$id = $this->input->post('id');
				$file = $this->input->post('file');
				$data = new stdClass();
				if($this->Pengadaan_model->update_file($id, $file))
				{
					$data->type = 'success';
					$data->pesan = 'Success';
					
				}else{
				
					$data->type = 'error';
					$data->pesan = 'Failed';
				}

				return $this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));

			}

		}
	}

}
