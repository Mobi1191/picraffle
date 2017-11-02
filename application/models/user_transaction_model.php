<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_transaction_model extends CI_Model
{

    private $table_name = 'tbl_transaction';

    public function addTransactionHistory($user_id, $amount)
    {
        $data['user_id'] = $user_id;
        $data['amount'] = $amount;
        $data['transact_datetime'] = date('Y-m-d H:i:s');

        $result = $this->db->insert($this->table_name, $data);
        return $result;
    }
}

  