<?php
class Resolver_controller extends CI_Controller 
{  
    public function index()
    {
//        $this->load->model->("Resolver_model");
////        $this->Resolver_model->check_issue_approve();
        $this->session->set_flashdata('issue_solve_approved','issue');
        $this->load->model("Resolver_model");
        $ticket_id = $this->Resolver_model->urgent_ticket();
        $resolver_ids = $this->Resolver_model->fastest_resolvers();
        
        $unsolved_ticket_details=$this->Resolver_model->unsolved_ticket_id();
        $software_expert_resolver=$this->Resolver_model->software_expert($unsolved_ticket_details);
//        print_r($unsolved_ticket_details);
//        exit;
        $this->load->view("Resolver/resolver_home",['resolver_ids'=>$resolver_ids,'ticket_details'=>$ticket_id,'software_expert_resolver'=>$software_expert_resolver,'unsolved_ticket_details'=>$unsolved_ticket_details]);
        
    }
    
    public function view_ticket($id)
    {
        $this->load->model('Resolver_model');
        $result=$this->Resolver_model->open_ticket($id);
        $this->load->view('Resolver/view_ticket',['result'=>$result[0]]);
    }
    
    public function accept_ticket($ticket_id)
    {
        $this->load->model('Resolver_model');
        $result=$this->Resolver_model->accept_ticket($ticket_id);
        if($result == "0")
        {
            $this->session->set_flashdata('ticekt_accept_fail','failed');
            $this->load->view("Resolver/view_ticket");
        }
        else
        {
            $resolver_detail=$this->Resolver_model->get_resolver_details();
            $this->Resolver_model->update_resolver_details($resolver_detail);
            echo "done";
            $this->session->set_flashdata("ticket_accpted","ticket_accpted");
            redirect("Resolver_controller/current_issue");
            
        }
    }
    
    public function profile()
    {
        $this->load->model('Resolver_model');
        $user_details=$this->Resolver_model->resolver_user_details();
        $reolver_detalis=$this->Resolver_model->get_resolver_details();
        $this->load->view("Resolver/profile",['user_details'=>$user_details,'resolver_details'=>$reolver_detalis]);
    }
    
    
    public function current_issue()
    {
        $this->load->model('Resolver_model');
        $details = $this->Resolver_model->accepted_ticket_details();
        $this->data['resolver'] = $this->Resolver_model->accepted_ticket_details();
        $this->load->view("Resolver/resolver_current_issues",$this->data);   
    }
    
    public function ticket_solved($ticket_id)
    {
        $this->load->model("Resolver_model");
        $this->Resolver_model->update_ticket_status($ticket_id,2);
        $this->session->set_flashdata('ticket_solved','ticket_solved');
        redirect("Resolver_controller/current_issue");
        
    }
    
    public function ticket_unsolved($ticket_id)
    {
        $this->load->model("Resolver_model");
//        $resolver_ids=$this->Resolver_model->software_expert($ticket_id);
//        $this->software_experts_resolver($resolver_ids);
        $this->Resolver_model->update_ticket_status($ticket_id,3);
        $this->Resolver_model->ticket_unsolved($ticket_id);
        $this->load->current_issue();
        
        
    }
    
    public function software_experts_resolver($resolver_ids)
    {
        print_r($resolver_ids);
        
        
    }
    
}



?>
