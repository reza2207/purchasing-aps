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
}