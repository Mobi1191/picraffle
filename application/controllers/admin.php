<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Admin extends BaseController
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('contest_model');
        $this->load->model('ticket_model');
        $this->load->model('noti_model');
        $this->load->model('dev_model');
        $this->load->model('withdraw_model');
        $this->isLoggedIn();   
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
    }


    //front process

    public function contests()
    {
    	$this->global['pageTitle'] = 'Admin : Contests';
        $this->global['all_contests'] = $this->contest_model->getAllContests();
        $this->loadViews("admin/contests", $this->global, NULL , NULL);
    }

    public function todaycontest()
    {
    	$this->global['pageTitle'] = "Admin : Today's Contest";
        $today_contest = $this->contest_model->getTodayContest();

        if(count($today_contest) == 0)
        {
            $inserted_id = $this->contest_model->createTodayContest();            
            $today_contest = $this->contest_model->getTodayContest();
           
            $data['noti_content'] = "Today contest is created.";
            $data['noti_type'] = 'create_contest';
            $noti_id = $this->noti_model->addNotification($data);
            $data['id'] = $noti_id;
            $this->sendNotificationMessage($data);
        }

        $this->global['all_todays_tickets'] = $this->ticket_model->getAllTodayTickets();
        $this->global['today_contest'] = $today_contest[0];

        $this->global['owned_ticket'] = $this->ticket_model->getOwner($today_contest[0]->contest_id);

        $this->loadViews("admin/todaycontest", $this->global, NULL , NULL);	
    }

    public function viewcontest($contest_id)
    {
        $this->global['pageTitle'] = 'Admin : View Contest';
        $contest = $this->contest_model->getContest($contest_id);

        if(count($contest) == 0)
        {
            $this->loadThis();
        }
        else
        {
            $this->global['contest'] = $contest[0];
            $this->global['all_tickets'] = $this->ticket_model->getTicketsByContestId($contest[0]->contest_id);
            $this->global['owned_ticket'] = $this->ticket_model->getOwner($contest[0]->contest_id);
            $this->loadViews("admin/viewcontest", $this->global, NULL , NULL);
        }
    }




    //back process

    public function editcontest()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('prize','Prize','trim|required');
        $this->form_validation->set_rules('price_one_ticket','Price One Ticket','trim|required');
        $this->form_validation->set_rules('30_tickets_price','30 Tickets Price','trim|required');
        $this->form_validation->set_rules('70_tickets_price','70 Tickets Price','trim|required');
        $this->form_validation->set_rules('120_tickets_price','120 Tickets Price','trim|required');
        $this->form_validation->set_rules('200_tickets_price','200 Tickets Price','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $this->todaycontest();
        }
        else
        {
            $contest_id         = $this->input->post('contest_id');
            $prize              = $this->input->post('prize');
            $price_one_ticket   = $this->input->post('price_one_ticket');
            $t30_tickets_price  = $this->input->post('30_tickets_price');
            $t70_tickets_price  = $this->input->post('70_tickets_price');
            $t120_tickets_price = $this->input->post('120_tickets_price');
            $t200_tickets_price = $this->input->post('200_tickets_price');
            $duration = $this->input->post('duration');

            $data = array(
                'prize'             => $prize,
                't30_tickets_price' => $t30_tickets_price,
                't70_tickets_price' => $t70_tickets_price,
                't120_tickets_price' => $t120_tickets_price,
                't200_tickets_price' => $t200_tickets_price,
                'price_one_ticket'  => $price_one_ticket,
                'duration'          => $duration
            );

            $result = $this->contest_model->updateDataWhereId($contest_id, $data);

            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Contest is changed successfully!');
            }
            else
            {
                $this->session->set_flashdata('error', 'Contest changing is not changed!');
            }
            
            redirect('admin/editcontest');
        }

    }

    public function own($ticket_id, $user_id, $contest_id)
    {
        $this->ticket_model->own($ticket_id, $user_id, $contest_id);
        $this->contest_model->own($ticket_id, $user_id, $contest_id);

        $this->session->set_flashdata('success', 'Selected Owner Successfully!');
         $user = $this->user_model->getUserInfo($user_id)[0];
        $data['noti_content'] = $user->name." is owned today!";
        $data['noti_type'] = 'picked_own';
        $data['id'] = $noti_id;
        $this->sendNotificationMessage($data);
        redirect('admin/todaycontest');
    }

    public function notification()
    {
        $this->global['pageTitle'] = 'Admin : Notification';
        $this->global['notifications'] = $this->noti_model->getAllNotifications();
        $this->loadViews("admin/notification", $this->global, NULL , NULL);
    }

    public function sendNotification()
    {
        $noti_content = $this->input->post('noti_content');
       
        // send notification
        $data['noti_content'] = $noti_content;
        $data['noti_type'] = 'other';
        $result = $this->noti_model->addNotification($data);
        $data['id'] = $result;
        $this->sendNotificationMessage($data);
        redirect('admin/notification');
    }

    public function editNotification()
    {
        $noti_id = $this->input->post('noti_id');
        $noti_content = $this->input->post('noti_content');
        $this->noti_model->editNotification($noti_id, $noti_content);
        
        $data['noti_content'] = $noti_content;
        $data['noti_type'] = 'other';
        $data['id'] = $noti_id;
        $this->sendNotificationMessage($data);
        redirect('admin/notification');
    }

    public function sendNotificationMessage($data)
    {
        $devices = $this->dev_model->getAllDevices();
        //var_dump($devices);
        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'picrafflepem.pem'); 
        //stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        //stream_context_set_option($ctx, 'ssl', 'passphrase', 'song');
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
           
            // Create the payload body
            $body['aps'] = array(
                'alert' => $data['noti_content'],
                'sound' => 'default',
                'type'  => $data['noti_type'],
                'id'    => $data['id']
            );
            // Encode the payload as JSON
            $payload = json_encode($body);

        foreach ($devices as $device)
        {
            $deviceToken= $device['dev_token']; 
                // Change 2 : If any
                
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                // Send it to the server
            fwrite($fp, $msg, strlen($msg));

        }
        fclose($fp);
    }

    public function withdraw()
    {
        // $this->global['pageTitle'] = 'Admin : Withdraw';
        // $this->global['withdraws'] = $this->withdraw_model->getAllWithdraws();
        // $this->loadViews("admin/withdraw", $this->global, NULL , NULL);

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
            ->setEmailSubject("You have a payment");
        // #### Sender Item
        // Please note that if you are using single payout with sync mode, you can only pass one Item in the request
        $senderItem1 = new \PayPal\Api\PayoutItem();
        $senderItem1->setRecipientType('Email')
            ->setNote('Thanks you.')
            ->setReceiver('calin.blitiu@outlook.com')
            ->setSenderItemId("item_1" . uniqid())
            ->setAmount(new \PayPal\Api\Currency('{
                                "value":"20",
                                "currency":"USD"
                            }'));
      
        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem1);
        // For Sample Purposes Only.
        $request = clone $payouts;
        // ### Create Payout
        try {
            $output = $payouts->create(null, $apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            // ResultPrinter::printError("Created Batch Payout", "Payout", null, $request, $ex);
            // exit(1);
            //var_dump($output);
            var_dump($ex);
            exit();
        }
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //  ResultPrinter::printResult("Created Batch Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);
        // return $output;

        var_dump($output);

    }
}


?>