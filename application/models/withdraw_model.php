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
	
	public function getAllWithdraws()
	{
		$this->db->where('withdraw_status','pending');
		$this->db->from($this->table_name);
		$this->db->join('tbl_users', 'tbl_users.userId = '.$this->table_name.'.owner_id');
		$query = $this->db->get();
		$result = $query->result_array();
		return  $result;
	}

	public function getWithdraw($withdraw_id)
	{
		$this->db->where('withdraw_id',$withdraw_id);
		$query = $this->db->get($this->table_name);
		return $query->result();
	}

	public function payout($withdraw)
	{
		$apiContext = new \PayPal\Rest\ApiContext(
                    new \PayPal\Auth\OAuthTokenCredential(
                        'AQzYw8vdU8Ki-YqKaFt9VfDQM1zflfYrU2a1Kp7NlI9Ox_IL04uCYcJY8NIz8DwEhOwK5-rpJtIBSqGi',
                        'EOqr48gpaT8CLxmSPKKA7RrNVQYc4DSpstUfiUXeTPZP7AoReIrLZNoU82XFlK-sg67jIfS02QnBBOY2'
                    )
                );
                
        $payouts = new \PayPal\Api\Payout();
        
        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();
        // ### NOTE:
        // You can prevent duplicate batches from being processed. If you specify a `sender_batch_id` that was used in the last 30 days, the batch will not be processed. For items, you can specify a `sender_item_id`. If the value for the `sender_item_id` is a duplicate of a payout item that was processed in the last 30 days, the item will not be processed.
        // #### Batch Header Instance
        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("You have a payment as Withdraw");
        // #### Sender Item
        // Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem1 = new \PayPal\Api\PayoutItem();
        $senderItem1->setRecipientType('Email')
            ->setNote('Thanks you.')
            ->setReceiver($withdraw->withdraw_email)
            ->setSenderItemId("item_1" . uniqid())
            ->setAmount(new \PayPal\Api\Currency('{
                                "value": '.$withdraw->withdraw_amount.',
                                "currency":"USD"
                            }'));
      
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem1);
        // For Sample Purposes Only.
        $request = clone $payouts;
        // ### Create Payout
        try {
            $output = $payouts->create(null, $apiContext);
            return true;
        } catch (Exception $ex) {
			//var_dump($ex);            
            return false;
            exit();
        }

        
	}

	public function updateWithdraw($withdraw_id, $data)
	{
		$this->db->where('withdraw_id', $withdraw_id);
		$this->db->update($this->table_name,$data);
	}
}