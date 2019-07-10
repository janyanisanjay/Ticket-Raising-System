<?php 
include_once('header.php');
?>
<html>
<head></head>
   <body>
    <div class="container" style="margin-top:20px;margin-left:375px">
        
        <h1>Raise</h1>
        <?php echo form_open_multipart('User_controller/ticket_form'); ?>
        
            <?php 
                if($error=$this->session->flashdata('insert_msg'))
                {
        ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="alert alert-dark alert-dismissible ">
                          <button type="button" class="close" data-dismiss="alert">&times;</button>
                          <strong>Success!</strong> <?php echo "hey"; ?>
                          <a href="#" class="alert-link">Get Status</a>.
                        </div>
                    </div>
                </div>    
                
        <?php 
        }
        ?>
        
          
            <div class="row">
          <div class="col-lg-6">
            <div class="form-group">
                <label>Software Name</label>
            <?php
            $query="SELECT * FROM software";
            $q=$this->db->query($query);
            $result=$q->result_array();
            
//            $software_name=$q[0]['software_name'];
            
            ?>
                <select class="form-control" name="software_id">
                    <?php
                     for($i=0;$i<$q->num_rows();$i++){
                         $software_name=$result[$i]['software_name'];
                         $software_id=$result[$i]['software_id'];
                         
                    ?>
                    
                        <option value="<?php echo $software_id?>"><?php echo $software_name ?></option>
                
                    <?php
                        }
                    ?>
                </select>
                <div class="text-danger">
                <?php echo form_error('software_name'); ?>
                </div> 
            </div>
          </div> 
        </div>  
        
        
        <div class="row">
           <div class="col-lg-6">
            <div class="form-group">
                <label>Body</label>

                <?php echo form_textarea(['class' => 'form-control','placeholder'=>'Enter Discription','name'=>'article_body','value'=>set_value('article_body')]); ?>
                <div class="text-danger"><?php echo form_error('article_body'); ?></div>
            </div> 
          </div>  
        </div>
        
        
        
        <div class="row">
           <div class="col-lg-6">
            <div class="form-group">
                <label>Upload Image</label>

                <?php echo form_upload(['name'=>'userfile']); ?>
                <div class="text-danger">
                <?php
                    if(isset($upload_error))
                    {
                        echo $upload_error; 
                    }
                    ?>
                </div>
            </div> 
          </div>  
        </div>
        
        <div class="row">
           <div class="col-lg-6">
            <div class="form-group">
                <label>Priority</label>
                <select class="form-control" name="priority">
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                </select>
            </div> 
          </div>  
        </div>
        
        <div>
            <?php echo form_submit(['class' =>'btn btn-dark','type'=>'submit','value'=>'Submit']); ?>
            <?php echo form_reset(['class' =>'btn btn-light','type'=>'reset','value'=>'Reset']); ?>
            
        </div> 
        
    </div>
    </body>
</html>

