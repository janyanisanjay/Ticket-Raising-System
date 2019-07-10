<?php
include_once("header.php");
?>
<html>
    <head></head>
    <body>
       <div class="jumbotron">
        <div class="container" style="margin-top:60px;margin-left:360px">
            <h2>Login</h2>
            <?php echo form_open("Login/validate")?>
            <?php if($error=$this->session->flashdata('login_fail'))
                {?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="alert alert-danger">
                            <?php echo $error; ?>
                        </div>
                    </div>
                </div>    
                
        <?php } ?>
            <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
                <label>Username</label>
                <?php echo form_input(['class' => 'form-control','placeholder'=>'Enter Username','name'=>'user_name','value'=>set_value('user_name') ]);?>
                
                <div class="text-danger">
                <?php echo form_error('user_name'); ?>
                </div> 
            </div>
            
          </div> 
        </div>  
        
        
        <div class="row">
           <div class="col-lg-6">
            <div class="form-group">
                <label>Password</label>

                <?php echo form_password(['class' => 'form-control','placeholder'=>'Enter Password','type'=>'password','name'=>'user_password','value'=>set_value('user_password')]); ?>
                <div class="text-danger"><?php echo form_error('user_password'); ?></div>
            </div> 
          </div>  
        </div>
            <?php echo form_input(['class' =>'btn btn-dark','type'=>'submit','value'=>'Submit']); ?>
            <?php echo form_reset(['class' =>'btn btn-light','type'=>'reset','value'=>'Reset']); ?>
<!--            </form>-->
        </div>
        </div>
    </body>
</html>
