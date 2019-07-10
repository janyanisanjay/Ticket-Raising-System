<?php
include_once('header.php')
?>
<html>
    <head>
        
    </head>
    
    
    <body>
       <?php 
           if($error=$this->session->flashdata('ticekt_accept_fail'))
           {
        ?>        
              <div class="jumbotron">
               <h1 class="display-6">Sorry You are Late!!!</h1>
                  <p class="lead">This Issue has been accepted by other resolver</p>
                  <hr class="my-4">

                 

                  <p>Accept some other Isssue. </p>
                  <p>Go back To Home Page</p>
                  <p class="lead">
                    <a class="btn btn-dark " href="../../Resolver_controller/index" >Home</a>
                  </p>
                </div>
                
        <?php  
           }
            else{
        ?>
<div class="jumbotron">
  <h1 class="display-6">Issue Details</h1>
  <p class="lead">Software Name: <?php echo $result['software_name'];?>  </p>
  <hr class="my-4">
  
  <p class="lead">Description: <?php echo $result['description'];?>  </p>
  <hr class="my-4">
  
  <p class="lead">Image:   </p>
  <a href="#"><img src="<?php echo $result['image_path'] ?>" width="200px" height ="200px"alt=""></a>
  <hr class="my-4">
  
  
  <p>Be quick to accept</p>
  <p class="lead">
    <a class="btn btn-dark btn-lg" href="../accept_ticket/<?php echo $result['ticket_id'];?>" role="button">Accept</a>
    <a class="btn btn-light btn-lg" href="#" data-toggle="modal" data-target="#myModal">Back</a>
  </p>
        </div>
        <?php
           }
//    print_r($result);
    ?>
        
  
  
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
        <p>Are you sure you want to accept this ticket ???</p>
      </div>
      <div class="modal-footer">
         <a class="btn btn-dark " href="../accept_ticket/<?php echo $result['ticket_id'];?>" role="button">Accept</a>
        <a  href="#" class="btn btn-ligh " data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>

    </div>
    
    </body>
</html>