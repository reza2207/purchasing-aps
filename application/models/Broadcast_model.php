<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Broadcast_model extends CI_Model {

	var $table = 'broadcast';


	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	public function send_broadcast($nama, $msg, $sendto, $time)
	{
		$data = array('chat'=>$msg,
			'send_by'=>$_SESSION['username'],
			'send_to'=>$sendto,
			'created_at'=>$time);
		return $this->db->insert('broadcast', $data);
	}

	public function get_broadcast($sendto)
	{
		$this->db->select('`broadcast.id`, `broadcast.chat`, `broadcast.send_by`, `broadcast.send_to`, `broadcast.created_at`, `broadcast.deleted_at`,`user.nama`');
		$this->db->from('broadcast');
		$this->db->join('user', 'broadcast.send_by = user.username', 'LEFT');
		$this->db->where('broadcast.send_to', $sendto);
		return $this->db->get();
	}
}