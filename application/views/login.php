
<?php $this->load->view('header'); ?>

  
    <div class="row">    
        <div class="formnya col-md-6 col-md-offset-3">
            <div class="loginform"> 
                
                <!-- alert for handle error registration -->
                <?php if(isset($_SESSION['error'])){ ?>
                    <div class="alert alert-danger"> <?php echo $_SESSION['error']; ?></div>
                <?php } ?>

                <!-- alert for handle empty form -->
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form action="" method="POST">
                    <div class="form-group left-addon">
                    <!-- <label for="username" > </label> -->
                    <i class="glyphicon glyphicon-user"></i>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                    </div>
                        
                    <div class="form-group left-addon">
                    <!-- <label for="password" ></label> -->
                    <i class="glyphicon glyphicon-lock"></i>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" >
                    </div>

                    <div class="text-center">
                    <button class="btn btn-primary btn-login" name="login">Login</button>
                    </div><hr>
                </form>
            </div>
        </div>
    </div>
<?php $this->load->view('footer'); ?>
