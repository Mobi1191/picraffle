<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_model extends CI_Model
{
	private $table_name = "tbl_tickets";

	public function addNewTicket($data)
	{
		$result = $this->db->insert($this->table_name, $data);
		return $result;
	}
}