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
}