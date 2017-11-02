<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

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
                    'msg'     => 'Faild user name or password'
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
                'msg'           => array('error' => 'Today contest is not yet created.')
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
        $data = array();
        $uploaddir = './assets/uploads/';
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $dest_filename = md5(uniqid(rand(),true)).'.'.$ext;
        $uploadfile = $uploaddir.$dest_filename;
        $file_name = $dest_filename;
      
        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
        {
            $contest = $this->contest_model->getTodayContest()[0];
            
            $data['image_name'] = $file_name;
            $data['user_id'] = $user_id;
            $data['contest_id'] = $contest_id;

            $result = $this->ticket_model->addNewTicket($data);
            if($result)
            {
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

        if($result->success === true){

            $this->user_transaction_model->addTransactionHistory($user_id, $amount);

            $user = $this->user_model->getUserInfo($user_id)[0];

            $tickets = (int)$user->tickets+$count;

            $data['tickets'] = $tickets;
            $this->user_model->editUser($data, $user_id);



            echo json_encode(array(
                'status' => "ok",
                'count' => $tickets
            ));



        } else{
            echo json_encode(array(
                'status' => "fail"
            ));
        }
    }
            
}