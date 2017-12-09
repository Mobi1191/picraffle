<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Withdraw_model extends CI_Model
{
	private $table_name = "tbl_withdraw";

	public function addNewWithdraw($data)
	{
		$this->db->insert($this->table_name,$data);
		$insert_id = $this->db->insert_id();
        return $insert_id;
	}
	
	function getAllWithdraws()
	{
		$this->db->where('withdraw_status','pending');
		$this->db->from($this->table_name);
		$this->db->join('tbl_users', 'tbl_users.userId = '.$this->table_name.'.owner_id');
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}
}