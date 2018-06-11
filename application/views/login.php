<?php include'template/header.php'; ?>

<!-- APP WRAPPER -->
        <div class="app app-fh">

            <!-- START APP CONTAINER -->
            <div class="app-container" style="background: url(<?php echo base_url();?>assets/images/background/bg3.jpg) repeat fixed;">
                
                <div class="app-login-box">                                        
                    <div class="app-login-box-user"><img src="<?php echo base_url();?>img/user/user_no_photo.png"></div>
                    <div class="app-login-box-title">
                        <div class="title">Admin Login</div>
                        <div class="subtitle">Login to your account</div>                        
                    </div>
                    <div class="app-login-box-container">
                        <form action="" method="post">
                            <div id="add_err"> </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="login" id="user_login" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" id="user_pass" placeholder="Password">
                            </div>
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <div class="app-checkbox">
                                            <label><input type="checkbox" name="app-checkbox-1" value="0"> Remember me</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <button class="btn btn-success btn-block" id="login">Sign In</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    
                    <div class="app-login-box-footer">
                        &copy; CarWashmi 2017. All rights reserved.
                    </div>
                </div>
                                
            </div>
            <!-- END APP CONTAINER -->
           
        </div>        
        <!-- END APP WRAPPER -->   
<?php include'template/footer.php'; ?>