<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Admin extends BaseController
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('contest_model');
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
        $this->global['all_contests'] = $this->contest_model->getAllContest();
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
        }

        
        $this->global['today_contest'] = $today_contest[0];
        $this->loadViews("admin/todaycontest", $this->global, NULL , NULL);	
    }




    //back process

    public function editcontest()
    {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('prize','Prize','trim|required');
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
            $t30_tickets_price  = $this->input->post('30_tickets_price');
            $t70_tickets_price  = $this->input->post('70_tickets_price');
            $t120_tickets_price = $this->input->post('120_tickets_price');
            $t200_tickets_price = $this->input->post('200_tickets_price');

            $data = array(
                'prize'             => $prize,
                't30_tickets_price' => $t30_tickets_price,
                't70_tickets_price' => $t70_tickets_price,
                't120_tickets_price' => $t120_tickets_price,
                't200_tickets_price' => $t200_tickets_price
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

}


?>