<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Customer extends BaseController
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('contest_model');
        $this->load->model('ticket_model');
        $this->isLoggedIn();   
    }

    public function profile()
    {
        $this->global['pageTitle'] = 'Customer : Profile';
        $this->global['vendorId'] = $this->vendorId;
        $this->global['userinfo'] = $this->user_model->getUserInfo($this->vendorId);
        $this->loadViews("customer/profile", $this->global, NULL , NULL);
    }

    public function editprofile()
    {
    	$this->load->library('form_validation');
   
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile();
        }
        else
        {
            $name = ucwords(strtolower($this->input->post('fname')));
            $email = $this->input->post('email');
            $mobile = $this->input->post('mobile');
            
            $uploaddir = './assets/account_image/';
            $path = $_FILES['image']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $dest_filename = md5(uniqid(rand(),true)).'.'.$ext;
            $uploadfile = $uploaddir.$dest_filename;
            $file_name = $dest_filename;
            if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile))
            {
                // $contest = $this->contest_model->getTodayContest()[0];
                
                // $data['image_name'] = $file_name;
                // $data['user_id'] = $this->vendorId;
                // $data['contest_id'] = $contest->contest_id;

                // $result = $this->ticket_model->addNewTicket($data);
                // if($result)
                // {
                //     $this->session->set_flashdata('success', 'Image uploading is done successfully!');
                //     redirect('customer/todaycontest');
                //     exit();    
                // }


                // $this->session->set_flashdata('error', 'Image uploading is not done!');
                // redirect('customer/todaycontest');
                // exit();

                $userInfo = array();
            
                $userInfo = array(
                    'email'=>$email, 
                    'name'=>$name,
                    'mobile'=>$mobile, 
                    'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'),
                    'image_name'=>$file_name
                );

                $this->session->set_userdata('avartarImage', $file_name);
                
              
                
                $result = $this->user_model->editUser($userInfo, $this->vendorId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('customer/myprofile');
                
            }
            else{
                $this->session->set_flashdata('error', 'User updation failed');
                redirect('customer/myprofile');
            }

            // $userInfo = array();
            
            // $userInfo = array('email'=>$email, 'name'=>$name,
            //     'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
          
            
            // $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            // if($result == true)
            // {
            //     $this->session->set_flashdata('success', 'User updated successfully');
            // }
            // else
            // {
                // $this->session->set_flashdata('error', 'User updation failed');
            // }
            
            // redirect('customer/myprofile');
        }
    }

    public function contests()
    {
        $this->global['pageTitle'] = 'Customer : Contests';
        $this->global['all_contests'] = $this->contest_model->getAllContests();
        $this->loadViews("customer/contests", $this->global, NULL , NULL);
    }

    public function viewcontest($contest_id)
    {
        $this->global['pageTitle'] = 'Customer : ViewContest';
       
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
            //var_dump($this->global['all_tickets']);
            $this->loadViews("customer/viewcontest", $this->global, NULL , NULL);
        }
    }

    public function todaycontest()
    {
        $this->global['pageTitle'] = "Customer : Today's Contest";
        $today_contest = $this->contest_model->getTodayContest();

        if(count($today_contest) == 0)
        {
            $this->loadThis();
            return;
        }

        
        $this->global['today_contest'] = $today_contest[0];
        $this->global['all_todays_tickets'] = $this->ticket_model->getAllTodayTickets();
        $this->global['owned_ticket'] = $this->ticket_model->getOwner($today_contest[0]->contest_id);
        // var_dump($this->global['all_todays_tickets']);
        $this->loadViews("customer/todaycontest", $this->global, NULL , NULL); 
    }

    public function uploadimage()
    {
        // $this->load->library('form_validation');

        // $this->form_validation->set_rules('image','Image','required');
        // if($this->form_validation->run() == FALSE)
        // {
        //     $this->session->set_flashdata('error', 'Image uploading is not done!');
        //     redirect('customer/todaycontest');

        // }
        // else
        // {   
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
                $data['user_id'] = $this->vendorId;
                $data['contest_id'] = $contest->contest_id;

                $result = $this->ticket_model->addNewTicket($data);
                if($result)
                {
                    $this->session->set_flashdata('success', 'Image uploading is done successfully!');
                    redirect('customer/todaycontest');
                    exit();    
                }


                $this->session->set_flashdata('error', 'Image uploading is not done!');
                redirect('customer/todaycontest');
                exit();
                
            }

            $this->session->set_flashdata('error', 'Image uploading is not done!');
            redirect('customer/todaycontest');
        // }
    }
}