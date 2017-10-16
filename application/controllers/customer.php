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
            
            $userInfo = array();
            
            $userInfo = array('email'=>$email, 'name'=>$name,
                'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
          
            
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
    }
}