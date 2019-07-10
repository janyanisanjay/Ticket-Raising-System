<?php
include_once("header.php");
?>
<html>
    <head></head>
    <body>
       <div class="jumbotron" style="padding-top:30px;">
        <?php
//        echo "<pre>";
//        print_r($history);
        ?>

            <?php if($error=$this->session->flashdata('approve'))
                {?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissible">
                           <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo "We are happy to solve your Issue.Thanks for your Feedback" ?>
                        </div>
                    </div>
                </div>    
                
        <?php } ?>
  <div class="row">      
        

   
   
   <?php
        $count=sizeof($history);
//      echo "$count";
//      exit;
      for($i=0;$i<$count;$i++)
      {
          if($history[$i]['priority'] == 1)
            {
                $priority="low";
            }
            else if($history[$i]['priority'] == 2)
            {
                $priority="high";
            }else if($history[$i]['priority'] == 3)
            {
                $priority="critical";
            }
          
          
          
          if($history[$i]['status_by_resolver'] == 1  )
            {
                $resolver_status="Pending";
            }
            else if($history[$i]['status_by_resolver'] == 2)
            {
                $resolver_status="Solved";
            }
            else if($history[$i]['status_by_resolver'] == 3)
            {
                $resolver_status="Will take Time";
            }
            else if($history[$i]['status_by_resolver'] == 0)
            {
                $resolver_status="Resolver has not been allocated yet";
            }
          
          
          
          if($history[$i]['approved_by_user'] == 0)
            {
                $approved_by_user="Not Solved";
                $approved="No";
                
            }
            else if($history[$i]['approved_by_user'] == 1)
            {
                $approved_by_user="Solved";
                $approved="Yes";
            }else if($history[$i]['approved_by_user'] == 3)
            {
                $approved_by_user="Will take Time";
            }
      ?>
   
  <div class="card col-md-3" style="margin-left:90px; margin-top:50px">
  <h3 class="card-header bg-dark text-white">Software: <?php echo $history[$i]['software_name']; ?></h3>
  <div class="card-body">
    <h5 class="card-title">Urgency <?php echo $priority;    ?></h5>
    <h6 class="card-subtitle text-muted">Raised at <?php echo $history[$i]['time']; ?></h6>
  </div>
  <img style="height: 200px; width: 50%; display: block;" src="<?php echo $history[$i]['image_path']; ?>" alt="Card image">
  <div class="card-body">
    <p class="card-text">Description: <?php echo $history[$i]['description']; ?></p>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Resolver Status: <?php echo $resolver_status; ?></li>
    
    <li class="list-group-item">Issue Status:<?php echo $approved_by_user; ?> </li>
      <li class="list-group-item">Approved: <?php echo $approved; ?></li>
      
       <?php
        if($approved=="No" and $resolver_status == "Solved")
        {
            ?>
         <li class='list-group-item'>Are u satisfied with the Solution??
         <p>
         <a href='<?php echo "issue_solved/{$history[$i]['ticket_id']}" ; ?>'  class='btn btn-dark'  >Accept </a>
         
         <a href='#'  class='btn btn-light' style='margin-left:100px;    background-color: #1a1a1a; color:white' data-toggle="modal" data-target="#myModal">Reject</a>
    
<!--         <button class='btn' style='margin-left:100px; background-color: #1a1a1a; color:white' data-toggle="modal" data-target="#RejectModal">Reject</button>-->
          
<!--         <a href='#'  class='btn' style='margin-left:100px;    background-color: #1a1a1a; color:white' data-toggle="modal" data-target="#RejectModal">Reject</a> -->
         </p>     
         </li>
<!--         data-toggle="modal" data-target="#myModal"-->
         
         
<!--
<div class="modal" id="myModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Is your Issue Solved ???</p>
      </div>
      <div class="modal-footer">
         <a class="btn btn-dark " href="" role="button">Accept</a>
        <a  href="#" class="btn btn-ligh " data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
         <h4 class="modal-title">Issue Not solved??</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <p>Report it again</p>
          <textarea class="form-control" placeholder="What is not solved?"></textarea>
        </div>
        <div class="modal-footer">
             <a class="btn btn-dark" href="" role="button">Report</a>
             
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<!--

<div class="modal" id="RejectModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>What is the problem ???</p>
        <textarea class="form-control" placeholder="What is not solved?"></textarea>
      </div>
      <div class="modal-footer">
        
         <a class="btn btn-dark " href="" role="button">Report</a>
        <a  href="#" class="btn btn-ligh " data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
-->

   
        <?php
        }
        ?>
        
        
    
  </ul>
  



<!--
  <div class="card-body">
    <a href="#" class="card-link">Card link</a>
    <a href="#" class="card-link">Another link</a>
  </div>
-->
  <div class="card-footer text-muted">
   
   <?php
          $date=date("Y/m/d");
          $val=explode("/",$date);
//          echo $date;
//          print_r($val);
          $d=$val[2];
//          echo $d;
          $temp=$history[$i]['time'];
          $dr=explode("-",$temp);
          $dd=$dr[2];
//          echo $dd;
//          echo intval($d);
          $days=intval($d)-intval($dd);
          echo $days;
          
          
          ?>
     days ago
        
        
  </div>
</div>
  
 <?php
      }
          ?>
   </div>
   
        </div>
   
    </body>
</html>