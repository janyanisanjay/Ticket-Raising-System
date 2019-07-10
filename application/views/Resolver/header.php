<html>
    <head>
        <?= link_tag("Assets/css/bootstrap.min.css") ?>
    </head>
    <body>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
    </ul>
    <div  class=" my-2 my-lg-1">
     <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url("index.php/Resolver_controller/index");  ?>">Home <span class="sr-only">(current)</span></a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url("index.php/Resolver_controller/current_issue");  ?>">Current Issues</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url("index.php/Resolver_controller/profile");  ?>">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url("index.php/Login/resolver_logout");  ?>" >Logout</a>
      </li>
    </ul>

      </div>
  </div>
</nav>
  
  
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
       
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
   
   
    </body>
</html>