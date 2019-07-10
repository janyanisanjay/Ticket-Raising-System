<?php

class Login extends CI_Controller
{
    public function index()
	{
		$this->load->view("Home/home_page");
	}
    
    public function log()
    {
        $this->load->view("Home/login_page");
    }
    public function validate()
    {   
        if($this->form_validation->run('login'))
        {

            $post=$this->input->post();
            $this->load->model("Login_model");
            $result=$this->Login_model->login_process($post);
            $user_type=$result[0]['user_type'];
            $id=$result[0]['user_id'];
            if($user_type == 1)
            {
                $this->session->set_userdata('user_id',$id);
                header("Location: ../User_controller/index");

            }else if($user_type ==2)
            {
                $this->session->set_userdata('resolver_id',$id);
                header("Location: ../Resolver_controller/index");
                
                
            }elseif($user_type == 3)
            {
                
                $this->session->set_userdata('manager_id',$id);
                header("Location: ../Manager_controller/index");
                
            }
            
//            print_r($post);
        }
        else
        {
            $this->load->view("Home/login_page");
        }
    }
    
    
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        redirect("Login/index");
        
    }
    public function resolver_logout()
    {
        $this->session->unset_userdata('resolver_id');
        redirect("Login/log");
        echo "logout";
    }
    
    
}

?>