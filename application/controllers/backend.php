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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Backend extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('contest_model');
        $this->load->model('ticket_model');
        $this->load->model('login_model');
        $this->load->model('user_transaction_model');
        $this->load->model('dev_model');
        $this->load->model('withdraw_model');
        $this->load->model('noti_model');
    }

    public function login()
    {
        $user_name_email = $this->input->post('user_name_email');
        $password = $this->input->post('password');

        if($user_name_email == "" || $password == "")
        {
            $data = array(
                'success' => '0',
                'msg'     => 'Please Input User Name and Password'
            );
            echo json_encode($data);
            exit();
        }

        $result = $this->login_model->b_loginUserName($user_name_email,$password);
        if(count($result) == 0)
        {
            
            $result = $this->login_model->b_loginEmail($user_name_email, $password);

            if(count($result) == 0)
            {
                $data = array(
                    'success' => '0',
                    'msg'     => 'Invalid user name or password'
                );
                echo json_encode($data);
                exit();   
            }
            else
            {
                $data = array(
                    'success' => '1',
                    'msg' => $result[0]
                );
                echo json_encode($data);
                exit();       
            }

            
        }
        else
        {
            $data = array(
                'success' => '1',
                'msg' => $result[0]
            );
            echo json_encode($data);
            exit();
        }

    }

    public function signup()
    {
        $user_name = $this->input->post('user_name');
        $user_email = $this->input->post('user_email');
        $user_password = $this->input->post('user_password');

        if(count($this->user_model->getUserByUserName($user_name)) == 0 && count($this->user_model->getUserByEmail($user_email)) == 0)
        {
            $data = array(
                'email'         => $user_email,
                'name'          => $user_name,
                'password'      => getHashedPassword($user_password),
                'roleId'        => 3,
                'createdBy'     =>'-1', 
                'createdDtm'    =>date('Y-m-d H:i:s')
            );

            $result = $this->user_model->addNewUser($data);

            if($result > 0)
            {
               $data = array(
                    'success' => '1',
                    'msg' => $this->user_model->getUserInfo($result)[0]
                );
                echo json_encode($data);
                exit();  
            }
            
               $data = array(
                    'success' => '0',
                    'msg'     => 'Cannot signup, Database Processing Error, Try again.'
                );
                echo json_encode($data);
                exit();
            
        }
       
            $data = array(
                    'success' => '0',
                    'msg'     => 'User Name or Email is duplicated, Please signup with other username  and email.'
                );
                echo json_encode($data);
                exit();
       

    }

    public function todaytickets()
    {
        $todaycontest= $this->ticket_model->getAllTodayTickets();

        if(count($todaycontest)>0)
        {
            $data = array(
                'success' => '1',
                'msg' => $todaycontest
            );
            echo json_encode($data);
            exit();
        }
        else{
            $data =  array(
                'success' => '0',
                'msg'   => array('error'=>'There is no any Images')
             );
            echo json_encode($data);
            exit();
        }
    }

    public function getticketsbyuserid($user_id)
    {
        $result = $this->ticket_model->getTicketsByUserId($user_id);
        if(count($result) == 0)
        {
            $data = array(
                'success'       => '0',
                'msg'           => array('error' => 'There is not any Images')
            );

            echo json_encode($data);
            exit();
        }
        else{
            $data = array(
                'success'       => '1',
                'msg'           => $result
            );

            echo json_encode($data);
            exit();   
        }
    }

    public function getpastwinners()
    {
        $result = $this->ticket_model->getPastWinners();
        if(count($result) == 0)
        {
            $data = array(
                'success'       => '0',
                'msg'           => array('error' => 'There is not any Winners')
            );

            echo json_encode($data);
            exit();
        }
        else{
            $data = array(
                'success'       => '1',
                'msg'           => $result
            );

            echo json_encode($data);
            exit();   
        }
    }

    public function gettodaycontestinfo()
    {
        $result = $this->contest_model->getTodayContest();

        if(count($result) == 0)
        {
            $data = array(
                'success'       => '0',
                'msg'           => "Today's Contest has not started yet, please try to upload later."
            );

            echo json_encode($data);
            exit();
        }
        else{
            $data = array(
                'success'       => '1',
                'msg'           => $result[0]
            );

            echo json_encode($data);
            exit();   
        }
    }

    public function contestupload()
    {
        $user_id = $this->input->post('user_id');
        $contest_id = $this->input->post('contest_id');
        $location = $this->input->post('location');
        $data = array();
        $uploaddir = './assets/uploads/';
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $dest_filename = md5(uniqid(rand(),true)).'.'.$ext;
        $uploadfile = $uploaddir.$dest_filename;
        $file_name = $dest_filename;
      
        $user = $this->user_model->getUserInfo($user_id)[0];

        if($user->tickets == "0")
        {
            $data_return = array(
                'success'       => '0',
                'msg'           => array('error' => 'Tickets is not enough. Please buy tickets')
            );
            echo json_encode($data_return);
            exit(); 
        }

        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
        {
            $contest = $this->contest_model->getTodayContest()[0];
            
            $data['image_name'] = $file_name;
            $data['user_id'] = $user_id;
            $data['contest_id'] = $contest_id;
            $data['location'] = $location;

            $result = $this->ticket_model->addNewTicket($data);
            if($result)
            {
               
               $user_info['tickets'] = $user->tickets-1;
               $this->user_model->changeUserInfo($user->userId, $user_info);
               $data_return = array(
                    'success'       => '1',
                    'msg'           => array('success' => "Image uploding is done successfully.")
                );

                echo json_encode($data_return);
                exit();   
            }

            $data_return = array(
                'success'       => '0',
                'msg'           => array('error' => 'Image uploding is not done.')
            );

     
            echo json_encode($data_return);
            exit();
            
        }

        $data_return = array(
            'success'       => '0',
            'msg'           => array('error' => 'Image uploding is not done.')
        );

        echo json_encode($data_return);
        exit();
    }

    public function buyticketsuccess(){
        $user_id = $this->input->post('user_id');
        $count = $this->input->post('count');

        $user = $this->user_model->getUserInfo($user_id);


    }

    public function getbraintreetoken()
    {
        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('68by6yqnx2v7kdyc');
        Braintree_Configuration::publicKey('dkg4smxkwt5cqzfb');
        Braintree_Configuration::privateKey('d071d4c3780a2850b4347221abc69746');
        $token = Braintree_ClientToken::generate();
        echo json_encode(array(
            'token' => $token
        ));
    }

    public function maketransaction()
    {

        Braintree_Configuration::environment('sandbox');
        Braintree_Configuration::merchantId('68by6yqnx2v7kdyc');
        Braintree_Configuration::publicKey('dkg4smxkwt5cqzfb');
        Braintree_Configuration::privateKey('d071d4c3780a2850b4347221abc69746');

        $user_id = $this->input->post('user_id');
        $amount = $_POST['amount'];
        $count = (int)$this->input->post('count');

        $result = Braintree_Transaction::sale([
          'amount' => $amount,
          'paymentMethodNonce' => $_POST['payment_method_nonce'],
          'options' => [
            'submitForSettlement' => true
          ]
        ]);
        if(isset($result->transaction->paypal)){
            $email = $result->transaction->paypal['payerEmail'];
            $this->user_model->editUser(array('paypal_email'=>$email), $user_id);
        }
       

        if($result->success === true){

            $this->user_transaction_model->addTransactionHistory($user_id, $amount);

            $user = $this->user_model->getUserInfo($user_id)[0];

            $tickets = $user->tickets+$count;

            $data['tickets'] = $tickets;
            $this->user_model->editUser($data, $user_id);

            echo json_encode(array(
                'status' => "ok",
                'count' => $tickets
                // 'post_count' => $count
            ));

        } else{
            echo json_encode(array(
                'status' => "fail"
            ));
        }
    }

    public function getuserinfo()
    {
        $user_id = $this->input->post('user_id');
        $user = $this->user_model->getUserInfo($user_id)[0];
        if(count($user) == 0)
        {
            $data['success'] = '0';
            $data['msg'] = 'There is no user with this id';
            echo json_encode($data);
        }
        else {
            $data['success'] = '1';
            $data['msg'] = $user;
            echo json_encode($data);
        }
    }

    public function changeusername()
    {
        $user_id = $this->input->post('user_id');
        $user_name = $this->input->post('user_name');
        $this->user_model->changeUserName($user_id, $user_name);
        $data['success'] = 1;
        $data['msg'] = "User Name is changed successfully.";
        echo json_encode($data);
    }

    public function changeemail()
    {
        $user_id = $this->input->post('user_id');
        $user_email = $this->input->post('user_email');
        $this->user_model->changeUserEmail($user_id, $user_email);
        $data['success'] = 1;
        $data['msg'] = "User Email is changed successfully.";
        echo json_encode($data);
    }
    
    public function changepassword()
    {
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $user_id  = $this->input->post('user_id');

        $user = $this->user_model->getUserInfo($user_id);
        if(verifyHashedPassword($old_pass, $user[0]->password))
        {
            $this->user_model->changePassword($user_id, array('password'=>getHashedPassword($new_pass)));
            $data['success'] = 1;
            $data['msg'] = "Password is changed successfully!";
            echo json_encode($data);
            exit();
        }
        else{
            $data['success'] = 0;
            $data['msg'] = "Current Password is not matched!";
            echo json_encode($data);
            exit();
        }
    }

    public function changeUerPhoto()
    {
        $user_id  = $this->input->post('user_id');
        $user = $this->user_model->getUserInfo($user_id)[0];

        $uploaddir = './assets/account_image/';
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $dest_filename = md5(uniqid(rand(),true)).'.'.$ext;
        $uploadfile = $uploaddir.$dest_filename;
        $file_name = $dest_filename;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
        {
            $this->user_model->editUser(array('account_image_name'=>$file_name), $user_id);
            $data['success'] = '1';
            $data['msg'] = "Account Image is changed successfully!";
            echo json_encode($data);
            exit();
        }
        else{
            $data['success'] = '0';
            $data['msg'] = "Account Image is not changed!";
            echo json_encode($data);
            exit();
        }
    }

    public function deleteuser()
    {
        $user_id = $this->input->post('user_id');            
        $result = $this->user_model->deleteuserbyid($user_id);
        $data['success'] = 1;
        $data['msg'] = "User is deleted.";
        echo json_encode($data);
        exit();
    }

    public function addDeviceToken()
    {
        $dev_token = $this->input->post('dev_token');
        $result = $this->dev_model->getDeviceInfo($dev_token);

        if(count($result) == 0)
        {
            $this->dev_model->addNewDevice($dev_token);
        }
    }

    public function getleftsecondstodaycontest(){
      $result = $this->contest_model->getTodayContest();

        if(count($result) == 0)
        {
            $data = array(
                'success'       => '0',
                'msg'           => array('error' => 'Today contest is not yet created.')
            );

            echo json_encode($data);
            exit();
        }
        else{
            
            $till_time =strtotime($result[0]->duration);
            $t_hours = date('H', $till_time);
            $t_mins = date('i', $till_time);
            $t_secs = date('s', $till_time);
            $t_seconds = $t_hours*3600+$t_mins*60+$t_secs;

            $c_hours = date('H');
            $c_mins = date('i');
            $c_secs = date('s');
            $c_seconds = $c_hours*3600+$c_mins*60+$c_secs;

            $gap_seconds = $t_seconds-$c_seconds;
            $data = array(
                'success'       => '1',
                'msg'           => $gap_seconds
            );

            echo json_encode($data);
            exit();   
        }
    }

    public function getbalance()
    {
        $user_id = $this->input->post('user_id');
        $result = $this->contest_model->getamount($user_id);
        //var_dump($result);
        if(count($result) == 0 || $result[0]->prize == null)
        {
            $data['balance'] = '0';
        }
        else{

            $data['balance'] = $result[0]->prize;
        }

        echo json_encode($data);
    }

    public function changepaypalemail()
    {
        $user_id = $this->input->post('user_id');
        $email = $this->input->post('email');

        $this->user_model->changepaypalemail($user_id, $email);

      $data['success'] = '1';
      echo json_encode($data);
    }

    public function withdraw()
    {
        $user_id = $this->input->post('user_id');
        $balance = $this->contest_model->getamount($user_id);
        if(count($balance) == 0)
        {
            $data['success'] = '0';
            $data['msg'] = 'Balance is empty!';
            echo json_encode($data);
            exit();
        }
        else{
            $this->contest_model->toPending($user_id);
            $user = $this->user_model->getUserInfo($user_id)[0];
            $withdraw_id = $this->withdraw_model->addNewWithdraw(array(
                'owner_id' => $user_id,
                'withdraw_amount' => $balance[0]->prize,
                'withdraw_email' => $user->paypal_email,
                'withdraw_status' => 'pending'
            ));
            $data['success'] = '1';
            $data['msg'] = 'Your request is pending!';
            echo json_encode($data);
            exit();         
        }

    }

    public function changeuserlocation()
    {
        $user_id = $this->input->post('user_id');
        $location = $this->input->post('location');

        $this->user_model->changeuserlocation($user_id, $location);
    }

    public function changeuserdescription(){
        $user_id = $this->input->post('user_id');
        $description = $this->input->post('description');
        $this->user_model->changeuserdescription($user_id, $description);
        $data['success'] = '1';
        $data['msg'] = 'User Description is changed successfully!';
        echo json_encode($data);
    }

    public function getAllNotifications() {
        $user_id = $this->input->post('user_id');
        $result = $this->noti_model->getAllNotifications();

        if (count($result) == 0) {
            $data['success'] = "0";
            $data['msg'] = "There is not any notification.";
            echo json_encode($data);
            exit();
        } else {
            $data['success'] = "1";
            $temp = array();
            foreach ($result as $notification) {
                $users =explode(',',  $notification['delete_by_users']);
                $isDeleted = false;
                foreach ($users as $user) {
                    if ($user == $user_id) {
                        $isDeleted = true;
                        break;
                    }
                }

                if (!$isDeleted) {
                    $temp[] = $notification;
                }
            }
            $data['msg'] = $temp;
            echo json_encode($data);
            exit();
        }
    }

    public function deleteTicket() {
        $ticket_id = $this->input->post('ticket_id');
        $this->ticket_model->deleteTicket($ticket_id);
        $this->refundTicket($ticket_id);

        $data['success'] = '1';
        echo json_encode($data);
    }

    public function refundTicket($ticket_id) {
         $isRefundableTickets = $this->ticket_model->isRefundAble($ticket_id);
         if (count($isRefundableTickets) != 0) {
            // var_dump($isRefundableTickets);
            $this->user_model->refundTicket($isRefundableTickets[0]->userId,$isRefundableTickets[0]->tickets + 1);
         }
    }

    public function deleteNotification() {
        $noti_id = $this->input->post('noti_id');
        $user_id = $this->input->post('user_id');

        $notification = $this->noti_model->getNotification($noti_id);

        if(count($notification) == 0){
            $data['success'] = '0';
            echo json_encode($data);
            exit();
        } else {
            if ($notification[0]['delete_by_users'] == '' ) {
                $savedata['delete_by_users'] = $user_id;
                $this->noti_model->deleteNotification($noti_id, $savedata);

                $data['success'] = '1';
                echo json_encode($data);
                exit();
            } else {
                $savedata['delete_by_users'] = $notification[0]['delete_by_users'] . ',' . $user_id;
                $this->noti_model->deleteNotification($noti_id, $savedata);

                $data['success'] = '1';
                echo json_encode($data);
                exit();
            }
        }
    }

    function sendmail($subject, $body) {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.picraffleadmin.com';  // Specify main and backup SMTP servers
            // $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'noreply@picraffleadmin.com';                 // SMTP username
            $mail->Password = 'soksunae';                           // SMTP password
            // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;     
            // $mail->Port = 25;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;                               // TCP port to connect to

            //Recipients
            $mail->setFrom('noreply@picraffleadmin.com', 'Mailer');
            $mail->addAddress('softwarecup.ex@gmail.com', 'basic email');     // Add a recipient
            
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
             echo json_encode(
                array(
                    'success' => '1',
                    'msg' => "Message has been sent!!!"
                ));
        } catch (Exception $e) {
            echo json_encode(
                array(
                    'success' => '0',
                    'msg' => "Message could not be sent. <br>". 'Mailer Error: ' . $mail->ErrorInfo
                ));
        }
    }
}