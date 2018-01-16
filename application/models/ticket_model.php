<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_model extends CI_Model
{
	private $table_name = "tbl_tickets";

	public function addNewTicket($data)
	{
		$result = $this->db->insert($this->table_name, $data);
		return $result;
	}

	public function getAllTodayTickets(){
		$this->db->from($this->table_name);
		
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');
		$this->db->where('DATE(contest_date)',$curr_date);
		$this->db->where('deletedAt', NULL);

		$this->db->select('*');
		$this->db->join('tbl_contest', 'tbl_contest.contest_id = tbl_tickets.contest_id');

		$this->db->join('tbl_users', 'tbl_tickets.user_id = tbl_users.userId');

		$query = $this->db->get();

		return $query->result();

	}

	public function isRefundAble($ticket_id) {
		$this->db->from($this->table_name);
		
		$date = new DateTime("now");
		$curr_date = $date->format('Y-m-d ');
		$this->db->where('DATE(contest_date)',$curr_date);
		$this->db->where('ticket_id', $ticket_id);
		$this->db->select('*');
		$this->db->join('tbl_contest', 'tbl_contest.contest_id = tbl_tickets.contest_id');

		$this->db->join('tbl_users', 'tbl_tickets.user_id = tbl_users.userId');

		$query = $this->db->get();

		return $query->result();		
	}

	public function getTicketsByContestId($contest_id)
	{
		$this->db->from($this->table_name);
		
		$this->db->where('tbl_contest.contest_id', $contest_id);
		$this->db->where('deletedAt', 'NULL');

		$this->db->select('*');
		$this->db->join('tbl_contest', 'tbl_contest.contest_id = tbl_tickets.contest_id');

		$this->db->join('tbl_users', 'tbl_tickets.user_id = tbl_users.userId');

		$query = $this->db->get();

		return $query->result();

	}

	public function own($ticket_id, $user_id, $contest_id)
	{
		$this->unsetOwn($contest_id);

		$this->db->where('ticket_id', $ticket_id);

		$data = array(
			'is_owned'		=> 1
		);

		$this->db->update($this->table_name, $data);

	}

	public function unsetOwn($contest_id)
	{
		$this->db->where('contest_id', $contest_id);
		$data = array(
			'is_owned' 		=> 0
		);
		$this->db->update($this->table_name, $data);
	}

	public function getOwner($contest_id)
	{
		$this->db->from($this->table_name);
		$this->db->where('contest_id', $contest_id);
		$this->db->where('is_owned', 1);
		$this->db->where('deletedAt', 'NULL');

		$this->db->join('tbl_users', 'tbl_users.userId = tbl_tickets.user_id');

		$query = $this->db->get();
		return $query->result();

	}

	public function getTicketsByUserId($user_id){
		$this->db->from($this->table_name);
		$this->db->select('*');
		$this->db->where('userId', $user_id);	
		$this->db->where('deletedAt', 'NULL');	
		$this->db->join('tbl_contest', 'tbl_contest.contest_id = tbl_tickets.contest_id');
		$this->db->join('tbl_users', 'tbl_tickets.user_id = tbl_users.userId');

		$query = $this->db->get();

		return $query->result();

	}

	public function getPastWinners()
	{
		$this->db->from($this->table_name);
		$this->db->select('*');
		$this->db->where('is_owned',1);		
		$this->db->where('deletedAt !=', 'NULL');
		$this->db->join('tbl_contest', 'tbl_contest.contest_id = tbl_tickets.contest_id');
		$this->db->join('tbl_users', 'tbl_tickets.user_id = tbl_users.userId');
		$query = $this->db->get();
		return $query->result();
	}

	public function deleteTicket($ticket_id) {
		$this->db->where('ticket_id', $ticket_id);
		$date = new DateTime();
		// echo $date->getTimestamp();
		$timestamp = date('Y-m-d H:i:s',$date->getTimestamp());
		$this->db->update($this->table_name,array('deletedAt' =>  $timestamp));

	}
}