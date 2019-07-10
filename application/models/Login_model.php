<?php

class Login_model extends CI_Model
{
    public function login_process($details)
    {
        
        $query=$this->db->select('*')
                        ->where(['user_name'=>$details['user_name'],'user_password'=>$details['user_password']])
                        ->get('user');
        
        if($query->num_rows())
        {
        $result=$query->result_array();
        return $result;
        }
        else{
            $this->session->set_flashdata('login_fail','Invalid Username or Password');
            redirect("Login/log");
        }
        
    }
}
?>