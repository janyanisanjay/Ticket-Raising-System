
<?php
include_once("header.php");
?>



<div class="jumbotron" style="padding-top:30px;">
  <h1 class="display-4"> Current Issues : </h1>
  <?php if($error=$this->session->flashdata('ticket_solved'))
                {?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-light alert-dismissible ">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          You have solved one Issue. We will update your profile as soon as we recive &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Users Confirmation.</strong>
                          <a href="#" class="alert-link">Your Profile</a>.
                        </div>
                    </div>
                </div>    
                
        <?php } ?>
  
        <?php if($error=$this->session->flashdata('ticket_accpted'))
                {?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-light alert-dismissible ">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          Mark it as Solved as soon as you solve it.Be quick in your actions.
                          
                        </div>
                    </div>
                </div>    
                
        <?php } ?>
        
  <p class="lead">
     <?php
      
              $result=$resolver->result_array();
              
//      echo $result[0]['ticket_id'];
      ?></p>
<div class="row">  
<?php
    $count = count($result);
//    echo $count;
    for($i=0;$i<$count;$i++){
    ?>

     <?php
        if($i%2==0){
        ?>
<div class="card text-white bg-dark mb-3" style="max-width: 20rem;">
  <div class="card-header">
     <?php
        echo $result[$i]['software_name'];
     ?>
  </div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $result[$i]['resolver_allocation_time'] ?></h4>

    <img src="<?php echo $result[$i]['image_path'];?>" alt="" width="100%";height="100%">
    <p class="card-text"><?php echo $result[$i]['description']?></p>
    <a href="ticket_solved/<?php echo $result[$i]['ticket_id'];?> " class="btn btn-light">Issue Solved</a>
    <a href="ticket_unsolved/<?php echo $result[$i]['ticket_id'];?>" class="btn btn-primary">Unable Solve </a>
    
        </div>
</div>
  <?php
  }
else{
            ?>  

<div class="card bg-light mb-3" style="max-width: 20rem;">
  <div class="card-header"><?php echo $result[$i]['software_name'];?></div>
  <div class="card-body">
    <h4 class="card-title"><?php echo $result[$i]['resolver_allocation_time'] ?></h4>
    <img src="<?php echo $result[$i]['image_path'];?>" alt="" width="100%";height="100%">
    <p class="card-text"><?php echo $result[$i]['description']?></p>
    <?php
        $resolver_id = $this->session->userdata('resolver_id');
        $query = "SELECT * FROM ticket_allocation WHERE resolver_id = $resolver_id";
    ?>
    
    
    
    <a href="ticket_solved/<?php echo $result[$i]['ticket_id'];?>" class="btn btn-dark" >Issue Solved</a>
    
    <a href="ticket_unsolved/<?php echo $result[$i]['ticket_id'];?>" class="btn btn-dark" >Unable to Solve</a>

    
  </div>
</div>
<?php
    }
}
    ?>
    </div>  
</div>
