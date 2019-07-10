<?php
include_once("header.php");
?>
<html>
    <head></head>
    <body>
    <?php 
            $result=$users->result_array();
//            print_r($result);
//            echo $result[0]['user_first_name']
    ?>    
        <h1>User : <?php 
//            echo $result[0]['user_first_name']; 
            ?>
            </h1>
<table class="table table-hover">
  <thead>
    <tr class="">
      <th scope="col">User First Name</th>
      <th scope="col">Software Name</th>
      <th scope="col">Status</th>
      <th scope="col">Priority  </th>
      
   </tr>
  </thead>
  <tbody>
   <?php
      for($i=0;$i<$users->num_rows();$i++){      
      ?>
    <tr class="table-secondary">
      <th scope="row"><?php echo $result[$i]['user_first_name'];?></th>
      <td><?php echo $result[$i]['software_name'];?></td>
      <td><?php if($result[$i]['status_by_resolver']==0){
          echo "Please Wait Your Resolver Will Be Shortly Allocated";
      }else if($result[$i]['status_by_resolver']==1){
          echo "Your Resolver Has Been Allocated";
      }else if($result[$i]['status_by_resolver']==2){
          echo "Hope Your Issue Has Been Resolved";
      }
          ?></td>
      <td><?php if($result[$i]['resolver_id']==0){
          echo "Resolver Has Been Allocated";
      }else{
          echo "Resolver Not Allocated";
      };?> </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table> 
</body>
</html>
