<?php
include_once("header.php");
?>
<html>
    <head> 
    </head>
    <body>
      <div class="jumbotron">    
        
       <?php
            $result=$details->result_array();
        ?>
            
            <h1 class="display-3">Common Issues : </h1>
            <?php
                $j=0;
                for($i=0;$i<sizeof($result);$i++){
                $j++;
            ?>
            <h1><?php echo " SR No : ".$j ?></h1>
            <h3><?php echo $result[$i]['issue_title']; ?></h3>

            <p class="lead"><?php echo $result[$i]['issue_description']; ?></p>
            <hr class="my-4">
            <p><?php echo $result[$i]['issue_solution']; ?></p>
            <button type="button" class="btn btn-primary"><?php echo $result[$i]['likes']; ?>  People Liked This</button>
            <button type="button" class="btn btn-primary"><?php echo $result[$i]['dislikes']; ?>  People Diskliked This</button>
            
            
             <?php
                    echo "<br><br><br>";
                    echo "<hr>";
              }
              ?>
              </div>        
        
    </body>
</html>