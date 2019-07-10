<?php
include_once("header.php");
?>
<html>
    <head></head>
    <body>
        <h1>Issues</h1>
        <hr class="my-4">
        <h1 id="show" ></h1>
        
        <?php 
                if($resolver_id_flash = $this->session->flashdata('issue_solve'))
                {
                    echo $resolver_id_flash;
                    $resolver_id = $this->session->userdata('resolver_id');
                    if($resolver_id_flash ==  $resolver_id)
                    {
        ?>
               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible ">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Conngrats!</strong> <?php echo "The issue you solved has been approved by user. Your Profile has been Updated"; ?>
                          <a href="#" class="alert-link"></a>.
                        </div>
                    </div>
                </div>    
                
        <?php 
                    }
                }
        ?>
          
          
          
        <?php 
            $resolver_id = $this->session->userdata('resolver_id');
            $query="Select * from resolver where resolver_id =$resolver_id";
            $q=$this->db->query($query);
            $resolver_detail=$q->result_array();
            if($resolver_detail[0]['current_total_issues'] > 10)
            {
        ?>        
              <div class="jumbotron">
               <h1 class="display-6">Sorry!!!</h1>
                  <p class="lead">You are currently working on 4 issues.Please solve previous issues first </p>
                  <hr class="my-4">
                  <p>If compelted previous issues</p>
                  <p>Go back To Current Issues </p>
                  <p class="lead">
                    <a class="btn btn-dark " href="../Resolver_controller/current_issue" >Current Issue</a>
                  </p>
            </div>
                
        <?php  
           }else{
        
        
        
        ?>
        
          
          
          
          
          
          
           
          <?php
//                print_r($resolver_ids);
//                print_r($ticket_details);
//                
                $resolver_id = $this->session->userdata('resolver_id');
                $val=array_search($resolver_id,$resolver_ids);
//                echo $resolver_id;
//                echo "<br>";
//                echo $val;
//                print_r($ticket_details);
            $t=empty($ticket_details);
//            echo "<br>".$t;
            if($t!=1){
           if($val >= 0)
           {
                echo "
            <div class='alert alert-dismissible alert-danger' style='margin-left:40px; margin-right:40px'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <h4 class='alert-heading'>New Issue</h4>
            <p class='mb-0'>Software name:";
            echo $ticket_details[0]['software_name'];  
            echo "</p>
            <p>Desciption:";
            echo $ticket_details[0]['description'];
            echo "</p>
            <p>Raised at:";
            echo $ticket_details[0]['time'];
            echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Priority:";
            echo "<strong>CRITICAL</strong>";
            echo "
            <span style='margin-left:1300px'><a href='view_ticket/{$ticket_details[0]['ticket_id']}' class='btn btn-dark'>View</a></span></p> </div>";
               
           }
        }
             
                
                
                
                
                
//                <?php
//                print_r($software_expert_resolver);
//                print_r($unsolved_ticket_details);
////                
//                exit;
                $resolver_id = $this->session->userdata('resolver_id');
                $val=array_search($resolver_id,$software_expert_resolver);
//                print_r($software_expert_resolver);
//                echo $val;
//                exit;
//                echo $resolver_id;
//                echo "<br>";
//                echo $val;
//                print_r($ticket_details);
//            $t=empty($ticket_details);
//            echo "<br>".$t;
//            if($t != 1){
        if(is_int($val)){
            
            
           if($val >= 0)
           {
                echo "
            <div class='alert alert-dismissible alert-danger' style='margin-left:40px; margin-right:40px'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <h4 class='alert-heading'>New Issue</h4>
            <p class='mb-0'>Software name:";
            echo $unsolved_ticket_details[0]['software_id'];  
            echo "</p>
            <p>Desciption:";
            echo $unsolved_ticket_details[0]['description'];
            echo "</p>
            <p>Raised at:";
            echo $unsolved_ticket_details[0]['time'];
            echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Priority:";
            echo "<strong>UNSOLVED</strong>";
            echo "
            <span style='margin-left:1300px'><a href='view_ticket/{$unsolved_ticket_details[0]['ticket_id']}' class='btn btn-dark'>View</a></span></p> </div>";
               
           }
           }
//        }
                
                
                
                
                
                
                
                
                
                
                
                
                
            $resolver_id = $this->session->userdata('resolver_id');
//            echo $resolver_id;
//        echo $resolver_id;
            $query="SELECT distinct t.ticket_id, s.software_name,t.description,t.priority,t.time FROM ticket t, ticket_allocation ta, resolver r, resolver_language rl, software s WHERE t.software_id = s.software_id AND s.language_id = (select  rl.language_id where rl.resolver_id=$resolver_id ) AND r.resolver_id = $resolver_id AND  t.ticket_id = ta.ticket_id AND ta.resolver_id = 0 and rl.resolver_id=$resolver_id and t.priority != 3";
                
//        echo $query;
//        exit;
        
        $q=$this->db->query($query);
        
        $num=$q->num_rows();
        
        $result_set = $q->result_array();
//        echo "<pre>";
//        print_r($result_set);
//        echo $result_set[0]['software_name'];
//        echo $num;
//            echo '<br>';
        
        $count=0;
        while($count!=$num)
        {
            if($result_set[$count]['priority'] == 1)
            {
                $priority="low";
            }
            else if($result_set[$count]['priority'] == 2)
            {
                $priority="high";
            }else if($result_set[$count]['priority'] == 3)
            {
                $priority="critical";
            }
            
            echo "
            <div class='alert alert-dismissible alert-dark' style='margin-left:40px; margin-right:40px'>
            <button type='button' class='close' data-dismiss='alert'>&times;</button>
            <h4 class='alert-heading'>New Issue</h4>
            <p class='mb-0'>Software name:";
            echo $result_set[$count]['software_name'];  
            echo "</p>
            <p>Desciption:";
            echo $result_set[$count]['description'];
            echo "</p>
            <p>Raised at:";
            echo $result_set[$count]['time'];
            echo "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Priority:";
            echo "<strong>$priority</strong>";
            echo "
            <span style='margin-left:1300px'><a href='view_ticket/{$result_set[$count]['ticket_id']}' class='btn btn-dark'>View</a></span></p> </div>";
            
//            echo '<br>';
//            
            $count=$count+1;
        }
        }
        ?>
    </body>

<script>
    setTimeout(function(){
    window.location.reload(1);   
}, 900000);
    
//    function show(){
//        
//    window.setInterval(function(){
//  /// call your function here
////        window.alert("hi");
//
//        xmlhttp = new XMLHttpRequest();
//        xmlhttp.onreadystatechange = function(){
//        if (this.readyState==4 && this.status==200) {
//        document.getElementById("show").innerHTML=this.responseText;
////      document.getElementById("show").style.border="1px solid #A5ACB2";
//        }
//    }    
////        var x=document.getElementById("show").innerHTML=this.responseText;
////        window.alert(x);
//        var urls="<?php echo base_url('index.php/Resolver_controller/ajax')?>";
//        xmlhttp.open("GET","Resolver_controller/ajax",true);
//        xmlhttp.send();
//        window.alert(urls);
//        
//}, 1000);
//    }
</script>



<!--

 function showResult(str){
        if (str.length==0)
  { 
    document.getElementById("show").innerHTML="";
    document.getElementById("show").style.border="0px";
    return;
  }
        xmlhttp = new XMLHttpRequest();
//                window.alert();

        xmlhttp.onreadystatechange = function(){
//                    window.alert();

            if (this.readyState==4 && this.status==200) {
      document.getElementById("show").innerHTML=this.responseText;
      document.getElementById("show").style.border="1px solid #A5ACB2";
        }
    }
        
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
    
}-->
