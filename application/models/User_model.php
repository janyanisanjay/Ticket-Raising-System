<?php
class User_model extends CI_Model
{
    public function Raise_ticket($details)
    {
//        print_r($details);
        $details['description']=$details['article_body'];
        unset($details['article_body']);

        $query="Insert into ticket(user_id,software_id,description,image_path,priority,time) values($details[user_id],$details[software_id],'$details[description]','$details[image_path]',$details[priority],now())";
        $this->db->query($query);
        $ticket_id=$this->db->insert_id();
        
        $query="insert into ticket_allocation(ticket_id,resolver_id,resolver_allocation_time,status_by_resolver,approved_by_user) values($ticket_id,0,null,0,0)";
        return $this->db->query($query);  
    }
    
    
   public function showTicket(){
        $user_id=$this->session->userdata('user_id');

        $query = "SELECT u.user_first_name,u.user_id,s.software_name,s.software_id,t.priority,ta.status_by_resolver,ta.resolver_id FROM user u,ticket_allocation ta,ticket t,software s WHERE u.user_id = t.user_id AND ta.status_by_resolver in (0,1) AND t.ticket_id = ta.ticket_id AND s.software_id = t.software_id and t.user_id=$user_id ORDER BY resolver_allocation_time ASC";
        return $this->db->query($query);
    }
    
    
    public function history()
    {
        $user_id=$this->session->userdata('user_id');
        
        $query="
        Select t.ticket_id,t.description,t.priority,t.image_path,s.software_name,ta.resolver_id,ta.resolver_allocation_time,ta.status_by_resolver, ta.approved_by_user,t.time from software s,ticket t,ticket_allocation ta where t.software_id=s.software_id and t.ticket_id=ta.ticket_id and t.user_id=$user_id " ;
//        echo $query;
//        exit;
        $q=$this->db->query($query);
        $result = $q->result_array();
        return $result;
    }
    
        public function approve_by_user($ticket_id)
        {
            $query = "Update ticket_allocation set approved_by_user=1,resolved_time=now() where ticket_id=$ticket_id";
            $q=$this->db->query($query);
            $query="Select resolver_id from ticket_allocation where ticket_id = $ticket_id";
            $q=$this->db->query($query);
            $result=$q->result_array();
            $resolver_id = $result[0]['resolver_id'];
            return $resolver_id;
        }
    
        public function get_userdata($user_id)
        {
            $query="Select * from user where user_id = $user_id";
            $q=$this->db->query($query);
            $result=$q->result_array();
            return $result[0]['user_email'];
            
        }
    
        public function keywordMatcher($description,$software_id){
//            echo $description;
//            echo $software_id;
//            exit;
            $query = "SELECT issue_description FROM common_issues WHERE software_id = $software_id"; 
//            echo $query;
            $q = $this->db->query($query);
            $result = $q->result_array();
            
            $dummy= array("","in","the","is","and","k","a","i","of","can","sake","very","call","world","me",'it');
            
            $count=($q->num_rows());
            
//            echo $count;
//            echo "<pre>";
//            print_r($result);
            
            $percentages_array =array();
            
            for($m=0;$m<$count;$m++){
                
//                echo "<br>$m";
            $temp=$result[$m]['issue_description'];
//            echo $temp;
//            echo "<br> ".$result[0]['issue_description'];
//            exit;
            $v=array();
            array_push($v,$result[$m]['issue_description']);
            $str=implode(" ",$v);
            //echo $str;
            $w=array();
            array_push($w,$description);
            $str1=implode(" ",$w);

            $array = explode(' ',$str);
            //print_r($array);
            $array1 = explode(' ',$str1);

            $new_array=array();
//            echo "<pre>";
//            print_r($array1);
            for($i=0;$i<sizeof($array1);$i++){
                $temp=$array1[$i];
                $found=array_search($temp,$dummy);
                if($found>0){
//                    echo " found";
                }else{
                    array_push($new_array,$temp);
                }
            }

            $new_array1=array();
            for($i=0;$i<sizeof($array);$i++){
                $temp=$array[$i];
                $found=array_search($temp,$dummy);
                if($found>0){
//                    echo " found";
                }else{
                    array_push($new_array1,$temp);
                }
            }

            $string=implode(" ",$new_array);
            $string1=implode(" ",$new_array1);
//            echo $string;
//            echo "<br>$string1";
            $sim = similar_text($string1, $string, $perc);
//            $p=s
//            echo "Similarity: $sim ($perc %)\n\n";
//            echo "<br>";
//            echo $perc;
            array_push($percentages_array,$perc);
            
            }
            $max=max($percentages_array);
//            echo $max;
//            exit;
            return $max;            
        }
        public function commonIssues(){
        $query = "SELECT * FROM common_issues";
        return $this->db->query($query);
        }
}
?>