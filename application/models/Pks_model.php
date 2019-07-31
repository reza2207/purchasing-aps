<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Pks_model extends CI_Model {

	var $table = 'pks';
	var $column_order = array(null, 'tgl_minta', 'no_srt_pelaksana', 'no_notin','nm_vendor','perihal','nominal_rp','tgl_krj_awal','tgl_krj_akhir', 'status');//,'status');//field yang ada di table user
	var $column_search = array('tgl_minta', 'no_srt_pelaksana', 'no_notin', 'nm_vendor', 'perihal', 'tgl_krj_awal', 'tgl_krj_akhir','nominal_rp', 'IF(pks.tgl_ke_legal = "0000-00-00", "Processing_Form_PKS", IF(pks.tgl_draft_ke_user = "0000-00-00" AND pks.tgl_draft_ke_vendor = "0000-00-00", "Drafting", IF(pks.tgl_review_send_to_legal = "0000-00-00", "On_Process_Review_User/Vendor", IF(pks.tgl_ke_vendor = "0000-00-00","Review_Draft_By_Legal", IF(pks.tgl_blk_dr_vendor_ke_legal = "0000-00-00", "Signing_Vendor", IF(pks.tgl_ke_vendor_kedua = "0000-00-00", "Signing_Head",IF(pks.tgl_ke_vendor_kedua != "0000-00-00" AND pks.tgl_krj_akhir > current_date, "On_Process", "Done")))))))', 'IF(datediff(pks.tgl_krj_akhir, curdate()) > 0 AND datediff(pks.tgl_krj_akhir, curdate()) < 180, "Segera", "")');//,'status');//field yang dizinkan untuk pencarian
	var $order = array('tgl_minta'=>'desc'); //default sort
	
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	private function _get_datatables_query() 
	{
		$this->db->select('pks.id_pks, pks.tgl_minta, pks.no_srt_pelaksana, pks.no_notin, pks.perihal, pks.nominal_rp, pks.tgl_krj_awal, pks.tgl_krj_akhir, pks.tgl_ke_legal, pks.tgl_draft_ke_user, pks.tgl_draft_ke_vendor, pks.tgl_review_send_to_legal, pks.tgl_ke_vendor, pks.tgl_blk_dr_vendor_ke_legal, tgl_ke_vendor_kedua,tdr.nm_vendor, IF(pks.reminder = "y", "Done", "-") AS reminder, 
		IF(pks.tgl_ke_legal = "0000-00-00", "Processing_Form_PKS", IF(pks.tgl_draft_ke_user = "0000-00-00" AND pks.tgl_draft_ke_vendor = "0000-00-00", "Drafting", IF(pks.tgl_review_send_to_legal = "0000-00-00", "On_Process_Review_User/Vendor", IF(pks.tgl_ke_vendor = "0000-00-00","Review_Draft_By_Legal", IF(pks.tgl_blk_dr_vendor_ke_legal = "0000-00-00", "Signing_Vendor", IF(pks.tgl_ke_vendor_kedua = "0000-00-00", "Signing_Head",IF(pks.tgl_ke_vendor_kedua != "0000-00-00" AND pks.tgl_krj_akhir > current_date, "On_Process", "Done"))))))) AS status, datediff(pks.tgl_krj_akhir, curdate()) as beda, IF(datediff(pks.tgl_krj_akhir, curdate()) > 0 AND datediff(pks.tgl_krj_akhir, curdate()) < 180, "Segera", "") AS segera ');
		/*$this->db->select('pks.tgl_minta, pks.no_srt_pelaksana, pks.no_notin, pks.perihal, pks.tgl_krj_awal, pks.tgl_krj_akhir, pks.tgl_ke_legal, pks.tgl_draft_ke_user, pks.tgl_draft_ke_vendor, pks.tgl_review_send_to_legal, pks.tgl_ke_vendor, pks.tgl_blk_dr_vendor_ke_legal, tgl_ke_vendor_kedua,tdr.nm_vendor, IF(pks.reminder = "y", "Done", "-") AS reminder, 
		IF(pks.tgl_ke_legal = "0000-00-00", "On_Process_Form_PKS", IF(pks.tgl_draft_ke_user = "0000-00-00" AND pks.tgl_draft_ke_vendor = "0000-00-00", "On_Process_Draft", IF(pks.tgl_review_send_to_legal = "0000-00-00", "On_Process_Review_User/Vendor", IF(pks.tgl_ke_vendor = "0000-00-00","On_Process_Hasil_Review_Send_To_Legal", IF(pks.tgl_blk_dr_vendor_ke_legal = "0000-00-00", "On_Process_Penandatanganan_PKS_ke_Vendor", IF(pks.tgl_ke_vendor_kedua = "0000-00-00", "On_Process_Penandatanganan_PKS_ke_Pemimpin",IF(pks.tgl_ke_vendor_kedua != "0000-00-00" AND pks.tgl_krj_akhir > current_date, "On_Process_Pelaksanaan", "Done"))))))) AS status, datediff(pks.tgl_krj_akhir, curdate()) as beda');*/
		$this->db->from($this->table);
		$this->db->join('tdr', 'pks.id_vendor = tdr.id_vendor', 'left');
		$this->db->where('pks.tgl_minta != ', '0000-00-00');
		$this->db->where('YEAR(current_date) - YEAR(pks.tgl_krj_awal) <', '4');
		
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

	public function save_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi)
	{
		$data = array(
			'id_pks'=>$id,
			'no_srt_pelaksana' => $nopenunjukan,
			'tgl_minta' =>$tglminta,
			'id_vendor' =>$idtdr,
			'no_notin' => $nousulan,
			'perihal' => $perihal,
			'tgl_krj_awal' => $tglawal,
			'tgl_krj_akhir' =>$tglakhir,
			'nominal_usd' =>$nominalusd,
			'nominal_rp'=>$nominalrp,
			'bg_rp' => $bankgaransi);
		return $this->db->insert('pks', $data);
	}

	public function get_detail($id)
	{
		$this->db->select('pks.id_pks, pks.tgl_minta, pks.no_srt_pelaksana, pks.no_notin, pks.perihal, pks.tgl_krj_awal, pks.tgl_krj_akhir, pks.tgl_ke_legal, pks.tgl_draft_ke_user, pks.tgl_draft_ke_vendor, pks.tgl_review_send_to_legal, pks.tgl_ke_vendor, pks.tgl_blk_dr_vendor_ke_legal, tgl_ke_vendor_kedua,tdr.nm_vendor, pks.id_vendor, IF(pks.reminder = "y", "Done", "-") AS reminder, 
		IF(pks.tgl_ke_legal = "0000-00-00", "Processing_Form_PKS", IF(pks.tgl_draft_ke_user = "0000-00-00" AND pks.tgl_draft_ke_vendor = "0000-00-00", "Drafting", IF(pks.tgl_review_send_to_legal = "0000-00-00", "On_Process_Review_User/Vendor", IF(pks.tgl_ke_vendor = "0000-00-00","Review_Draft_By_Legal", IF(pks.tgl_blk_dr_vendor_ke_legal = "0000-00-00", "Signing_Vendor", IF(pks.tgl_ke_vendor_kedua = "0000-00-00", "Signing_Head",IF(pks.tgl_ke_vendor_kedua != "0000-00-00" AND pks.tgl_krj_akhir > current_date, "On_Process", "Done"))))))) AS status, datediff(pks.tgl_krj_akhir, curdate()) as beda, pks.nominal_rp, pks.bg_rp, pks.no_pks, pks.tgl_pks, IF(datediff(pks.tgl_krj_akhir, curdate()) > 0 AND datediff(pks.tgl_krj_akhir, curdate()) < 180, "(Segera_Berakhir)", "") AS segera');
		$this->db->from($this->table);
		$this->db->join('tdr', 'pks.id_vendor = tdr.id_vendor', 'left');
		$this->db->where('id_pks', $id);
		return $this->db->get()->row();
	}

	public function get_id_comment($idpks)
	{
		$this->db->select('id_comment');
		$this->db->from('comment_pks');
		$this->db->where('id_pks', $idpks);
		$this->db->order_by('id_comment desc');
		$this->db->limit('1');
		return $this->db->get();
	}

	public function input_comment($comment_id, $id_pks, $comment, $comment_by, $comment_date)
	{
		

		$data = array(
			'id_comment' =>$comment_id,
			'id_pks' =>$id_pks,
			'comment'=>$comment,
			'comment_by'=>$comment_by,
			'comment_date'=>$comment_date);
		return $this->db->insert('comment_pks', $data);

	}

	public function get_comment($id)
	{
		$this->db->select('comment_pks.id_comment, comment_pks.comment, user.nama, comment_pks.comment_date');
		$this->db->from('comment_pks');
		$this->db->join('user', 'comment_pks.comment_by = user.username', 'left');
		$this->db->where('id_pks', $id);
		return $this->db->get()->result();
	}

	public function update_pks($id, $nopenunjukan, $tglminta, $nousulan, $idtdr, $perihal, $tglawal, $tglakhir, $nominalrp, $nominalusd, $bankgaransi,$tgldraftdarilegal, $tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks, $tglpks, $nopks)
	{
		$data = array(
			'no_srt_pelaksana' => $nopenunjukan,
			'tgl_minta' =>$tglminta,
			'id_vendor' =>$idtdr,
			'no_notin' => $nousulan,
			'perihal' => $perihal,
			'tgl_krj_awal' => $tglawal,
			'tgl_krj_akhir' =>$tglakhir,
			'nominal_usd' =>$nominalusd,
			'nominal_rp'=>$nominalrp,
			'bg_rp' => $bankgaransi,
			'tgl_ke_legal' =>$tgldraftdarilegal,
			'tgl_draft_ke_vendor' =>$tgldraftkevendor,
			'tgl_draft_ke_user' =>$tgldraftkeuser,
			'tgl_review_send_to_legal'=> $tglreviewkelegal,
			'tgl_ke_vendor'=>$tglttdkevendor,
			'tgl_blk_dr_vendor_ke_legal'=>$tglttdkepemimpin,
			'tgl_ke_vendor_kedua'=>$tglserahterimapks,
			'no_pks'=>$nopks,
			'tgl_pks'=>$tglpks);

		$this->db->where('id_pks', $id);
		return $this->db->update('pks', $data);
	}

	public function delete_pks($id)
	{	
		return $this->db->delete('pks', array('no_srt_pelaksana' => $id));
	}

	public function proses_pks($id,$tgldraftdarilegal,$tgldraftkeuser,$tgldraftkevendor,$tglreviewkelegal,$tglttdkevendor,$tglttdkepemimpin,$tglserahterimapks,$nopks,$tglpks)
	{
		$data = array(
			'tgl_ke_legal' =>$tgldraftdarilegal,
			'tgl_draft_ke_vendor' =>$tgldraftkevendor,
			'tgl_draft_ke_user' =>$tgldraftkeuser,
			'tgl_review_send_to_legal'=> $tglreviewkelegal,
			'tgl_ke_vendor'=>$tglttdkevendor,
			'tgl_blk_dr_vendor_ke_legal'=>$tglttdkepemimpin,
			'tgl_ke_vendor_kedua'=>$tglserahterimapks,
			'no_pks'=>$nopks,
			'tgl_pks'=>$tglpks);

		$this->db->where('id_pks', $nopenunjukan);
		return $this->db->update('pks', $data);
	}

	public function list_reminder($days){
		$this->db->select('pks.no_srt_pelaksana, pks.perihal, pks.tgl_krj_akhir, datediff(pks.tgl_krj_akhir, curdate()) as beda');
		$this->db->from($this->table);
		$this->db->where('datediff(pks.tgl_krj_akhir, curdate()) > ',0);
		$this->db->where('datediff(pks.tgl_krj_akhir, curdate()) <= ',$days);
		return $this->db->get();

	}

	public function last_id($year)
	{
		$this->db->select('pks.id_pks');
		$this->db->from($this->table);
		$this->db->where('YEAR(tgl_minta)',$year);
		$this->db->order_by('id_pks', 'DESC');
		$this->db->limit('1');

		return $this->db->get();
	}
}