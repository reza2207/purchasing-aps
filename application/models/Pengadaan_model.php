<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Pengadaan_model extends CI_Model {

	var $table = 'pengadaan';
	var $column_order = array('id_pengadaan', 'tgl_notin', 'jenis_notin_masuk', 'tgl_disposisi','perihal','jenis_pengadaan','divisi','kewenangan');//,'status');//field yang ada di table user
	var $column_search = array('pengadaan.id_pengadaan','kewenangan', 'tgl_notin', 'jenis_notin_masuk', 'tgl_disposisi', 'no_notin', 'perihal', 'no_usulan', 'tgl_usulan', 'jenis_pengadaan', 'divisi', 'item', 'LEFT(pengadaan.id_pengadaan,4)', 'no_kontrak');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('id_pengadaan'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select(' pengadaan.id_pengadaan, pengadaan.kewenangan, pengadaan.tgl_notin, pengadaan.jenis_notin_masuk, pengadaan.tgl_disposisi, pengadaan.no_notin, pengadaan.perihal, pengadaan.no_usulan, pengadaan.tgl_usulan, pengadaan.jenis_pengadaan, pengadaan.divisi, GROUP_CONCAT(detail_item_pengadaan.item) AS item, GROUP_CONCAT(detail_item_pengadaan.no_kontrak) AS no_kontrak, LEFT(pengadaan.id_pengadaan,4) AS tahun, pengadaan.kelompok ');
		$this->db->from($this->table);
		$this->db->join('detail_item_pengadaan', 'pengadaan.id_pengadaan = detail_item_pengadaan.id_pengadaan', 'left');
		$this->db->group_by('pengadaan.id_pengadaan');

		if($this->input->post('tahun') != NULL){
		
			if($this->input->post('tahun')) //select tahun
	        {	
	        	if($this->input->post('tahun') == 'semua'){

	        	}else{
		            $this->db->where('LEFT(pengadaan.id_pengadaan,4)', $this->input->post('tahun'));
		        }
	        }
	    }else{

	    	$this->db->where('LEFT(pengadaan.id_pengadaan,4)', date('Y'));
	    }

	    if($this->input->post('divisi') != NULL){

	    	if($this->input->post('divisi') != 'semua'){
	    		$this->db->where('pengadaan.divisi', $this->input->post('divisi'));
	    	}

	    }
		$i = 0;
		foreach($this->column_search as $item) // looping awal
		{
			if($_POST['search']['value']) // jika dtb mengirimkan pencarian melalui method post
			{
				if($i === 0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) -1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_pengadaan($id)
	{
		$this->db->select('pengadaan.id_pengadaan, pengadaan.kewenangan, pengadaan.tgl_notin, pengadaan.jenis_notin_masuk, pengadaan.tgl_disposisi, pengadaan.no_notin, pengadaan.perihal, pengadaan.no_usulan, pengadaan.tgl_usulan, pengadaan.jenis_pengadaan, pengadaan.divisi, LEFT(pengadaan.id_pengadaan,4) AS tahun, pengadaan.file, settings.defaultnya');
		$this->db->from($this->table);
		$this->db->join('detail_item_pengadaan', 'pengadaan.id_pengadaan = detail_item_pengadaan.id_pengadaan', 'left');
		$this->db->join('settings', 'CONCAT("default_doc_", pengadaan.tahun_pengadaan) = settings.namasetting', 'LEFT');
		$this->db->group_by('pengadaan.id_pengadaan');
		$this->db->where('pengadaan.id_pengadaan', $id);
		return $this->db->get()->row();
	}

	public function get_tgl_kontrak($id)
	{
		$this->db->select('detail_item_pengadaan.id_pengadaan, detail_item_pengadaan.tgl_kontrak');
		$this->db->from('detail_item_pengadaan');
		$this->db->where('detail_item_pengadaan.id_pengadaan', $id);
		$this->db->group_by('id_pengadaan');
		return $this->db->get()->row('tgl_kontrak');
	}

	public function get_detail($id)
	{
		$this->db->select('a.id_pengadaan, a.id_pengadaan_uniq, a.item, a.ukuran, a.bahan, a.jumlah, a.satuan, a.hps_usd, a.hps_idr, a.hps_satuan, a.penawaran, a.id_vendor, a.realisasi_nego_usd, a.realisasi_nego_rp, a.realisasi_qty_unit, a.no_kontrak, a.tgl_kontrak, a.nm_vendor, a.jml, status.keterangan AS status, a.tahun ');
		$this->db->from('(SELECT `detail_item_pengadaan`.*, `tdr`.`nm_vendor`, (detail_item_pengadaan.realisasi_qty_unit*detail_item_pengadaan.realisasi_nego_rp) as jml, IF(invoice.no_invoice IS NULL, "10", IF(invoice.tgl_invoice_diantar = "0000-00-00", "11", IF(invoice.tgl_invoice_kembali = "0000-00-00", "12", IF(invoice.tgl_kebagian_pembayaran = "0000-00-00", "13", "14")))) AS status, LEFT(pengadaan.id_pengadaan, 4) AS tahun FROM `detail_item_pengadaan` LEFT JOIN `tdr` ON `detail_item_pengadaan`.`id_vendor` = `tdr`.`id_vendor` LEFT JOIN `pengadaan` ON `detail_item_pengadaan`.`id_pengadaan` = `pengadaan`.`id_pengadaan` LEFT JOIN `invoice` ON CONCAT(detail_item_pengadaan.no_kontrak,"-",pengadaan.tahun_pengadaan) = CONCAT(invoice.no_kontrak,"-",invoice.tahun) group by detail_item_pengadaan.id_pengadaan_uniq) a');
		$this->db->join('status','a.status = status.id_status_pks', 'LEFT');
		$this->db->where('a.id_pengadaan', $id);
		$this->db->order_by('a.id_pengadaan', 'ASC');
		return $this->db->get()->result();

	}

	public function get_kontrak($id, $tahun){

		$this->db->select('invoice.id_invoice,invoice.no_invoice, invoice.memo_keluar, invoice.id_vendor, invoice.no_kontrak, invoice.tgl_invoice, invoice.tgl_invoice_diantar, invoice.tgl_invoice_kembali, invoice.tgl_kebagian_pembayaran, tdr.nm_vendor, invoice.perihal, invoice.nominal, a.nominalkontrak, b.totalbayar, (a.nominalkontrak - b.totalbayar) AS sisapembayaran, invoice.tahun');
		$this->db->from('invoice');
		$this->db->join('tdr', 'invoice.id_vendor = tdr.id_vendor', 'left');
		$this->db->join('(SELECT no_kontrak, id_pengadaan, SUM(realisasi_nego_rp*realisasi_qty_unit) AS nominalkontrak, LEFT(detail_item_pengadaan.id_pengadaan, 4) AS tahun FROM detail_item_pengadaan GROUP BY no_kontrak, id_pengadaan) AS a', 'CONCAT(invoice.no_kontrak,invoice.tahun) = CONCAT(a.no_kontrak,a.tahun)', 'left');
		$this->db->join('(SELECT no_kontrak, SUM(nominal) AS totalbayar, tahun FROM invoice GROUP BY no_kontrak, tahun) AS b', 'CONCAT(invoice.no_kontrak,invoice.tahun) = CONCAT(b.no_kontrak,b.tahun)','left' );
		$this->db->where('invoice.no_kontrak', $id);
		$this->db->where('invoice.tahun', $tahun);

		
		return $this->db->get();

	}

	public function add_new($jenispengadaan,$tglsurat,$nosurat,$jenissurat,$tgldisposisi,$tahun,$perihal,$nousulan,$tglusulan,$divisi,$kelompok,$keterangan,$kewenangan,$id){
		$data = array('id_pengadaan'=>$id,
					  'tgl_notin'=>$tglsurat,
					  'jenis_notin_masuk'=>$jenissurat,
					  'tgl_disposisi'=>$tgldisposisi,
					  'no_notin'=>$nosurat,
					  'perihal'=>$perihal,
					  'no_usulan'=>$nousulan,
					  'tgl_usulan'=>$tglusulan,
					  'jenis_pengadaan'=>$jenispengadaan,
					  'keterangan'=>$keterangan,
					  'divisi'=>$divisi,
					  'kewenangan'=>$kewenangan,
					  'tahun_pengadaan'=>$tahun,
					  'kelompok'=>$kelompok);

		return $this->db->insert('pengadaan', $data);
		
	}


	public function get_nominal($id, $idpengadaan){
		$this->db->select('SUM(realisasi_nego_rp*realisasi_qty_unit) AS nominalkontrak');
		$this->db->from('detail_item_pengadaan');
		$this->db->where('detail_item_pengadaan.no_kontrak', $id);
		$this->db->where('detail_item_pengadaan.id_pengadaan', $idpengadaan);
		$this->db->group_by('no_kontrak, id_pengadaan');
		return $this->db->get()->row();
	}

	public function get_tahun(){
		$this->db->select('LEFT(pengadaan.id_pengadaan,4) AS tahun');
		$this->db->from($this->table);
		$this->db->group_by('LEFT(pengadaan.id_pengadaan,4)');
		$this->db->order_by('tahun', 'DESC');


		return $this->db->get()->result();
	}

	public function get_kewenangan($divisi){
		$this->db->select('kewenangan');
		$this->db->from('kewenangan');
		$this->db->where('divisi', $divisi);

		return $this->db->get()->result();

	}

	public function get_id_pengadaan($tahun){
		$this->db->select('id_pengadaan');
		$this->db->from('pengadaan');
		$this->db->where('left(id_pengadaan,4)', $tahun);
		$this->db->order_by('id_pengadaan DESC');
		$this->db->limit(1);

		return $this->db->get();
	}

	public function list_pengadaan($tahun){
		$this->db->select(' pengadaan.perihal');
		$this->db->from($this->table);
		$this->db->where('LEFT(pengadaan.id_pengadaan,4) = ', $tahun);
		return $this->db->get();
	}

}