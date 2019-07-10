
<?php
class User_controller extends CI_Controller 
{
        public function index()
        {
            if($this->session->userdata('user_id'))
            {
            $this->load->model("User_model");
            $this->data['users'] = $this->User_model->showTicket();
            $this->load->view('User/user_home',$this->data);    
            }else{
                $this->load->view("Home/home");
            }
        }
    
        public function ticket_form(){
            $config=[
                'upload_path'=>'./upload/',
                'allowed_types'=>'gif|jpg|png',
            ];
            $this->load->library('upload',$config);
            

            if($this->form_validation->run('ticket_form') && $this->upload->do_upload())
            {   
                $post=$this->input->post();
                
                $this->load->model('User_model');
    //            $temp=$post[''];
                $this->data['resolver'] =$this->User_model->keywordMatcher($post['article_body'],$post['software_id']);
                
                $data=$this->upload->data();
                $image_path = base_url("upload/".$data['raw_name'].$data['file_ext']);
                $post['image_path']=$image_path;
                $user_id=$this->session->userdata('user_id');
//                echo $user_id;
                $post['user_id']=$user_id;
                $this->load->model("User_model");
                
                
                if($this->User_model->Raise_ticket($post))
                {
                    $perc =$this->User_model->keywordMatcher($post['article_body'],$post['software_id']);
                    $this->data['details'] = $this->User_model->commonIssues();
                    
//                    $x=$perc>=30;
                    if($perc>=30){
                        $this->load->view('User/user_common_issues',$this->data);
                    }
                    else{
                    $this->session->set_flashdata("insert_msg","Your Ticket/Issue has been raised");
                    $this->load->model("User_model");
                    
//                    echo $perc;
//                    exit;
                        
                    $user_email=$this->User_model->get_userdata($user_id);
                    $this->load->library('email');
                    $config['protocol']    = 'smtp';
                    $config['smtp_host']    = 'ssl://smtp.gmail.com';
                    $config['smtp_port']    = '465';
                    $config['smtp_timeout'] = '7';
                    $config['smtp_user']    = 'sanjayjanyani43@gmail.com';
                    $config['smtp_pass']    = '9730319048';
                    $config['charset']    = 'utf-8';
                    $config['newline']    = "\r\n";
                    $config['mailtype'] = 'text'; // or html
                    $config['validation'] = TRUE; // bool whether to validate email or not      

                    $this->email->initialize($config);
                    $this->email->from(set_value('sanjayjanyani43@gmail.com'),set_value('Sanjay'));
                    $this->email->to($user_email);
                    $this->email->subject("Your Ticket has been raised");
                    $this->email->message("Your issue would be solved as soon as possible.You would be frequntly updated on status of your ticket.You can chek it on history in dashboard.");
                    $this->email->send();
                    
                    return redirect("User_controller/ticket_form");
                    }

                }

            }
            else
            {
                    $upload_error=$this->upload->display_errors();
                    $this->load->view("User/user_ticket_form",compact('upload_error'));
            
            }
        }
    
        public function history()
        {
        
            $this->load->model('User_model');
            $result=$this->User_model->history();
            $this->load->view('User/history',['history'=>$result]);
        }
    
        public function issue_solved($ticket_id)
        {
            $this->load->model('User_model');
            $resolver_id=$this->User_model->approve_by_user($ticket_id);

            $this->session->set_flashdata('issue_solve',$resolver_id);
            $this->session->set_flashdata('approve','approved');
            $this->load->model("Resolver_model");
            $this->Resolver_model->inc_update_resolver_rating($resolver_id);
            redirect("User_controller/history");

        }
}
?>
