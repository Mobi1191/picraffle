<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Contest_model extends CI_Model
{
	private $table_name = "tbl_contest";

	public function getContest($id)
	{

	}

	public function getTodayContest()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');

		$this->db->select('*');
		$this->db->from($this->table_name); 
		$this->db->where('DATE(contest_date)',$curr_date);
		$query = $this->db->get();
		
		return $query->result();

	}

	public function createTodayContest()
	{
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');

		$data = array(
        	'prize' 			=> '500',
        	't30_tickets_price' 	=> '100',
        	't70_tickets_price' 	=> '150',
        	't120_tickets_price' => '200',
        	't200_tickets_price' => '150',
        	'contest_date'		=>	$curr_date
		);

		$this->db->insert($this->table_name, $data);

		return $this->db->insert_id();
	}

	public function updateDataWhereId($contest_id, $data)
	{
		$this->db->where('id', $contest_id);
		$this->db->update($this->table_name, $data);

		$updated_status = $this->db->affected_rows();

		if($updated_status){
		    return $contest_id;
		}
		return false;
	}
}

?>
