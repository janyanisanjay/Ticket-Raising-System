<?php
include_once("header.php");
?>

<html>
    <head>
        
    </head>
    <body>

<div class="jumbotron">
  <h1 class="display-6"><?php echo $user_details['user_first_name']." ".$user_details['user_last_name'] ;?></h1>
  <p class="lead">Email: <?php echo $user_details['user_email']; ?>  </p>
<!--  <a href="#"><img src="<?php  ?>" width="200px" height ="200px"alt=""></a>-->
  <hr class="my-4">
  
  <p class="lead">Contact No: <?php echo $user_details['user_contact'];?>  </p>
  <hr class="my-4">
  
  <p class="lead">Issues Solved: <?php echo $resolver_details['issues_solved'];?>  </p>
  <hr class="my-4">
  
  <p class="lead">Issues Unolved: <?php echo $resolver_details['issues_unsolved'];?>  </p>
  <hr class="my-4">
  
  <p class="lead">Currently Working with <?php echo $resolver_details['current_total_issues']; ?> issues  </p>
  <hr class="my-4">
  
  
  <p class="lead">Image:   </p>
  <a href="#"><img src="<?php  ?>" width="200px" height ="200px"alt=""></a>
  <hr class="my-4">
</div>
    </body>
</html>
