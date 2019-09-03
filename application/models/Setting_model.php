<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Setting_model extends CI_Model {

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	public function get_divisi()
	{
		$this->db->select('divisi');
		$this->db->from('divisi');
		return $this->db->get();
	}

	public function get_dir_file($tahun)
	{
		$this->db->select('settings.defaultnya');
		$this->db->from('settings');
		$this->db->where('namasetting', 'default_doc_'.$tahun);
		return $this->db->get();
	}

	public function get_tgl_libur($tglawal, $tglakhir)
	{
		$this->db->select('tgl, keterangan');
		$this->db->from('tgl_libur');
		$where = "tgl BETWEEN '$tglawal' AND '$tglakhir'";
		$this->db->where($where);
		return $this->db->get();
	}

	public function dir_foto()
	{
		$this->db->select('defaultnya');
		$this->db->from('settings');
		$this->db->where('namasetting','dir_foto');
		return $this->db->get();
	}
}