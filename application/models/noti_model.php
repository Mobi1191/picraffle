<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Noti_model extends CI_Model
{
	private $table_name = "tbl_notification";

	function addNotification($data)
	{
		$this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getAllNotifications()
	{
		$query = $this->db->get($this->table_name);
		$result = $query->result_array();
		return  $result;
	}

	function editNotification($noti_id, $noti_content)
	{
		$this->db->where('noti_id',$noti_id);
		$this->db->update($this->table_name,  array('noti_content' =>$noti_content));
	}
}