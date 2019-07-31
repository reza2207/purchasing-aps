<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Tdr_model extends CI_Model {

	var $table = 'tdr';
	var $column_order = array('id_vendor', 'no_srt_vendor', 'nm_vendor', 'alamat', 'sub_bdg_usaha','kualifikasi','tgl_mulai','tgl_akhir','status','id_vendor');//,'status');//field yang ada di table user
	var $column_search = array('id_vendor', 'no_srt_vendor', 'nm_vendor', 'alamat', 'sub_bdg_usaha','kualifikasi','tgl_mulai','tgl_akhir','IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) <= 90 AND DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) > 0, "Expired_Soon", IF(DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) < 0, "Expired", "Active"))');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tgl_akhir'=>'desc', 'nm_vendor'=> 'asc'); //default sort

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	private function _get_datatables_query() 
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
	}


	public function get_detail_tdr($id){
		$this->db->select('id_vendor, no_srt_vendor, divisi, nm_vendor, sub_bdg_usaha, kualifikasi, tgl_mulai, tgl_akhir, alamat, file_tdr');
		$this->db->from('tdr');
		$this->db->where('id_vendor', $id);
		return $this->db->get();
		
	}

	public function select_tdr(){
		$this->db->select('id_vendor, nm_vendor');
		$this->db->from('tdr');
		$this->db->order_by('nm_vendor ASC');
		return $this->db->get()->result();
	}

	public function get_dir()
	{
		$this->db->select('defaultnya');
		$this->db->from('settings');
		$this->db->where('namasetting', 'default_tdr');

		return $this->db->get();
	}
	public function get_file($id){
		$this->db->select('tdr.file_tdr');
		$this->db->from($this->table);
		$this->db->where('id_vendor', $id);
		return $this->db->get();
	}

	public function get_reminder()
	{
		$this->db->select('tdr.id_vendor, tdr.no_srt_vendor, tdr.divisi, tdr.nm_vendor, tdr.sub_bdg_usaha, tdr.kualifikasi, tdr.tgl_mulai, tdr.tgl_akhir, tdr.alamat, tdr.file_tdr, DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) AS diff');
		$this->db->from($this->table);
		$this->db->where('DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) <=',90);
		$this->db->where('DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) >',0);
		$this->db->where('DATEDIFF(tdr.tgl_akhir, CURRENT_DATE) !=', NULL);
		return $this->db->get();

	}

	public function get_nama($id)
	{
		$this->db->select('nm_vendor');
		$this->db->from($this->table);
		$this->db->where('id_vendor', $id);

		return $this->db->get()->row('nm_vendor');
	}
	
	
}
