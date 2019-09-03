<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Invoice_model extends CI_Model {

	/*var $table = 'tdr';
	var $column_order = array('id_vendor', 'no_srt_vendor', 'nm_vendor', 'alamat', 'sub_bdg_usaha','kualifikasi','tgl_mulai','tgl_akhir','status','id_vendor');//,'status');//field yang ada di table user
	var $column_search = array('id_vendor', 'no_srt_vendor', 'nm_vendor', 'alamat', 'sub_bdg_usaha','kualifikasi','tgl_mulai','tgl_akhir','IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) <= 90 AND DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) > 0, "Expired_Soon", IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) < 0, "Expired", "Active"))');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tgl_akhir'=>'desc', 'nm_vendor'=> 'asc'); //default sort
*/
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/*private function _get_datatables_query() 
	{
		$this->db->select('tdr.id_vendor, tdr.no_srt_vendor, tdr.divisi, tdr.nm_vendor, tdr.sub_bdg_usaha, tdr.kualifikasi, tdr.tgl_mulai, tdr.tgl_akhir, tdr.alamat, tdr.file_tdr, DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) AS diff, IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) <= 90 AND DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) > 0, "Expired_Soon", IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) < 0, "Expired", IF(tdr.tgl_akhir = "0000-00-00","-", "Active"))) AS status, (SELECT defaultnya FROM settings WHERE namasetting = "default_tdr") setting ');
		$this->db->from($this->table);

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
	}*/


	public function submit_invoice($idinv, $tglinput, $idvendor, $noinv, $memo, $nokontrak, $nominal, $perihal, $tglinv, $invkeuser, $tahun)
	{
		$data = array('id_invoice'=>$idinv,
					  'tgl_input'=>$tglinput,
					  'id_vendor'=>$idvendor,
					  'no_invoice'=>$noinv,
					  'memo_keluar'=>$memo,
					  'no_kontrak'=>$nokontrak,
					  'nominal'=>$nominal,
					  'perihal'=>$perihal,
					  'tgl_invoice'=>$tglinv,
					  'tgl_invoice_diantar'=>$invkeuser,
					  'tahun'=>$tahun);
		return $this->db->insert('invoice', $data);
	}

	public function update_tk($id,$tgl)
	{
		$data = array('tgl_invoice_kembali'=>$tgl);
		$this->db->where('id_invoice', $id);
		return $this->db->update('invoice', $data);
	}
	public function update_tp($id,$tgl)
	{
		$data = array('tgl_kebagian_pembayaran'=>$tgl);
		$this->db->where('id_invoice', $id);
		return $this->db->update('invoice', $data);
	}
	
	
}
