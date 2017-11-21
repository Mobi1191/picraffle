<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dev_model extends CI_Model
{
	private $table_name = "tbl_device";

	function getDeviceInfo($dev_token)
	{
		$this->db->where('dev_token', $dev_token);
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}

	function addNewDevice($dev_token)
	{
		$this->db->insert($this->table_name, array('dev_token' => $dev_token));
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getAllDevices()
	{
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}
}