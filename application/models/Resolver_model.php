<?php
class Resolver_model extends CI_Model
{
    public function open_ticket($ticket_id)
    {
        $q=$this->db->query("Select t.ticket_id,s.software_name,t.image_path,t.time,t.image_path,t.priority,t.description from ticket t,software s where t.ticket_id=$ticket_id and s.software_id=t.software_id");
        return $q->result_array();
    }
    
    public function accept_ticket($ticket_id)
    {
        $reolver_id=$this->session->userdata('resolver_id');
        $query=$this->db->select('resolver_id')
                        ->where(['ticket_id'=>$ticket_id])
                        ->get('ticket_allocation');
        $result=$query->result_array();
        if($result[0]['resolver_id'] != 0)
        {
            return "0";
        }
        else{
        $query = "Update ticket_allocation set resolver_id=$reolver_id , resolver_allocation_time=now() , status_by_resolver=1 where ticket_id=$ticket_id";
        return $this->db->query($query);
            
        }
    }
    
    public function get_resolver_details()
    {
        $reolver_id=$this->session->userdata('resolver_id');
        $query="Select * from resolver where resolver_id=$reolver_id";
        $q=$this->db->query("$query");
        $result=$q->result_array();
        return $result[0];

    }
    public function update_resolver_details($resolver_detail)
    {
        
        $unsolved=$resolver_detail['issues_unsolved']+1;
        $current=$resolver_detail['current_total_issues']+1;
        $resolver_id=$resolver_detail['resolver_id'];
        $query= "Update resolver set issues_unsolved=$unsolved,current_total_issues=$current where resolver_id =$resolver_id";
        $q=$this->db->query($query);
        
    }
    
    public function resolver_user_details()
    {
        $reolver_id=$this->session->userdata('resolver_id');
        $query="Select * from user where user_id=$reolver_id";
        $q=$this->db->query($query);
        $result=$q->result_array();
        return $result[0];
        
    }
    
    public function accepted_ticket_details(){
        $resolver_id = $this->session->userdata('resolver_id');
        $query = "SELECT t.ticket_id,u.user_first_name,s.software_name,ta.resolver_allocation_time,t.description,t.image_path,ta.status_by_resolver FROM ticket t,ticket_allocation ta,user u,software s WHERE t.ticket_id = ta.ticket_id AND ta.resolver_id = $resolver_id AND t.user_id = u.user_id AND s.software_id = t.software_id AND ta.status_by_resolver=1";
        return $this->db->query($query);
    }
    
    public function update_ticket_status($ticket_id,$solve_staus){
        $resolver_id = $this->session->userdata('resolver_id');
        $query = "UPDATE ticket_allocation SET status_by_resolver = $solve_staus,resolved_time= now() WHERE ticket_id = $ticket_id and resolver_id=$resolver_id";
        $this->db->query($query);
    }
    
    
    public function inc_update_resolver_rating($resolver_id)
    {
        $query="Select * from resolver where resolver_id=$resolver_id";
        $q=$this->db->query($query);
        $resolver_detail=$q->result_array();
        print_r($resolver_detail);
        $solved=$resolver_detail[0]['issues_solved']+1;
        $unsolved=$resolver_detail[0]['issues_unsolved']-1;
        $current=$resolver_detail[0]['current_total_issues']-1;
        $query= "Update resolver set issues_unsolved=$unsolved,current_total_issues=$current,issues_solved=$solved where resolver_id =$resolver_id";
        $q=$this->db->query($query);
    }
    
    public function urgent_ticket()
    {
        $resolver_id=$this->session->userdata('resolver_id');
        $query="SELECT distinct t.ticket_id, s.software_name,t.description,t.priority,t.time FROM ticket t, ticket_allocation ta, resolver r, resolver_language rl, software s WHERE t.software_id = s.software_id AND s.language_id = (select  rl.language_id where rl.resolver_id=$resolver_id ) AND r.resolver_id = $resolver_id AND  t.ticket_id = ta.ticket_id AND ta.resolver_id = 0 and rl.resolver_id=$resolver_id and t.priority=3";
        $q=$this->db->query($query);
        $ticket_details = $q->result_array();
        return $ticket_details;
    }
    
    
    
    
    public function ticket_unsolved($ticket_id)
    {
        $query="insert into ticket_allocation(ticket_id,resolver_id,resolver_allocation_time,status_by_resolver,approved_by_user) values($ticket_id,-1,null,0,0)";   
        $this->db->query($query);
    }
    
    public function unsolved_ticket_id()
    {
        $query="Select * from ticket_allocation where status_by_resolver=3 ORDER BY ticket_id DESC";
        $q=$this->db->query($query);
        $result=$q->result_array();
        $ticket_id=$result[0]['ticket_id'];
//        echo $ticket_id;
        $query="Select * from ticket where ticket_id=$ticket_id";
        $q=$this->db->query($query);
        $result=$q->result_array();
        
//        print_r($result);
//        exit;
        return $result;
    }
    
    public function software_expert($ticket_details)
    {
        $resolver_ids=array();
        $ticket_id=$ticket_details[0]['ticket_id'];
//        print_r($ticket_details);
        $query="select * from ticket where ticket_id=$ticket_id";
        $q=$this->db->query($query);
        $result=$q->result_array();
//        print_r($result);
        $software_id = $result[0]['software_id'];
     
        $query="SELECT ta.resolver_id,t.software_id,COUNT(t.software_id) FROM ticket_allocation ta,ticket t WHERE t.ticket_id=ta.ticket_id and ta.status_by_resolver!=0 and t.software_id=$software_id and ta.approved_by_user=1 Group BY ta.resolver_id ORDER BY t.software_id ";
//        echo $query;
//        exit;
        $q=$this->db->query($query);
        $result=$q->result_array();
        $resolver_id=$result[0]['resolver_id'];
        array_push($resolver_ids,$resolver_id);
        return $resolver_ids;
        
        
    }
    
    
    public function fastest_resolvers()
    {
        
        $fast_resolver_ids=array();
        
        $query="select * from resolver";
        $q=$this->db->query($query);
        $resolver_detail=$q->result_array();
//        echo "<pre>";        
        $count=$q->num_rows();

        $resolver_avgs=array();
        $avg_time_all=array();
        for($i=0;$i<$count;$i++)
        {
            $total_mins=array();
            $avg_rating=0;
            $resolver_id= $resolver_detail[$i]['resolver_id'];
            $num_of_issues = $resolver_detail[$i]['issues_solved'];
            $query = "Select * from ticket_allocation where resolver_id=$resolver_id and status_by_resolver=2 and approved_by_user=1";
            $q=$this->db->query($query);
            $tickets_by_resolver = $q->result_array();
            
//            print_r($tickets_by_resolver);
            $tickets_count=$q->num_rows();
//            echo "<br>";
//            echo $tickets_count;
            for($j=0;$j<$tickets_count;$j++)
            {
                $start_date=$tickets_by_resolver[$j]['resolver_allocation_time'];
                $end_date = $tickets_by_resolver[$j]['resolved_time'];
//                echo $start_date;
//                echo "<br>";
//                echo $end_date;
//                echo"<br>";
                $dtestart = new DateTime($start_date);
                $dteend = new DateTime($end_date);
                $dteDiff  = $dtestart->diff($dteend)->days;
//                echo $dteDiff;
                $hrDiff = $dtestart->diff($dteend);
//                echo"<br>"; 
                $s=$hrDiff->format("%H:%I:%S");
//                echo $s;
//                print $hrDiff->format("%H:%I:%S"); 
//                echo"<br>";
                $hrs=explode(":",$s);
//                print_r($hrs);
                $mins=$dteDiff*24*60+$hrs[0]*60+$hrs[1];

                array_push($total_mins,$mins);
            
            }
//            print_r($total_mins);
            $val=0;
            foreach($total_mins as $tm)
            {
                $val=$val+$tm;
            }
//            echo $val;
            $avg_time=$val/$tickets_count;
//            echo "<br><strong>".$avg_time."</strong>";
            array_push($avg_time_all,$avg_time);
            array_push($resolver_avgs,$resolver_id);
        }
        
//        print_r($resolver_avgs);
//        print_r($avg_time_all);
//        
        $min= min($avg_time_all);
        $key=array_search($min,$avg_time_all);
        $r_id=$resolver_avgs[$key];
//        echo $r_id;
        array_push($fast_resolver_ids,$r_id);
        
        unset($avg_time_all[$key]);
        unset($resolver_avgs[$key]);
        
        $min= min($avg_time_all);
        $key=array_search($min,$avg_time_all);
        $r_id=$resolver_avgs[$key];
        array_push($fast_resolver_ids,$r_id);
        
//        print_r($fast_resolver_ids);
        return $fast_resolver_ids;
        
//        exit;
    }
    
    
    
}
       
?>