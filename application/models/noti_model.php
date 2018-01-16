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

	function getLastNotification(){
     $this->db->order_by("noti_id", "desc");
     $this->db->limit(1);
     $query = $this->db->get($this->table_name);

     $res = $this->db->result($query);

     if(count($res) == 0) 
     {
        return $res[0];
     }
    	return false;
    }

    function getNotification($noti_id) {
    	$this->db->where('noti_id', $noti_id);
    	$query = $this->db->get($this->table_name);
    	return $query->result_array();
    }

    function deleteNotification($noti_id, $data) {
    	$this->db->where('noti_id',$noti_id);
    	$this->db->where($this->table_name, $data);
    }
}