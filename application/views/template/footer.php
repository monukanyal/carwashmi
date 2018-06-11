 <!-- START APP FOOTER -->
<?php
	if(isset($_SERVER["HTTPS"]) && !empty($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] != 'on' )) {
        $url = 'https://'.$_SERVER["SERVER_NAME"];//https url
	}  else {
		$url =  'http://'.$_SERVER["SERVER_NAME"];//http url
	}
	if(( $_SERVER["SERVER_PORT"] != 80 )) {
		$url .= $_SERVER["SERVER_PORT"];
	}
	$url .= $_SERVER["REQUEST_URI"];
	$dsf = explode("/",$url);
	// if($dsf[5] != "login"){
	// if($dsf[4] != "login"){
        if($dsf[3] != "login"){
?>
            <div class="app-footer app-footer-default" id="footer">

            

                <div class="alert alert-primary alert-dismissible alert-inside text-center">

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span class="icon-cross"></span></button>

                    We use cookies to offer you the best experience on our website. Continuing browsing, you accept our cookies policy.

                </div>

            

                <div class="app-footer-line extended">

                    <div class="row">

                        <div class="col-md-3 col-sm-4">

                            <h3 class="title"><!--- <img src="<?php echo base_url();?>img/logo-footer.png" alt="boooyah"> --> Car Wash</h3>                            

                            <p>The innovation in admin template design. You will save hundred hours while working with our template. That is based on latest technologies and understandable for all.</p>

                            <p><strong>How?</strong><br>This template included with thousand of best components, that really help you to build awesome design.</p>

                        </div>

                        <div class="col-md-2 col-sm-4">

                            <h3 class="title"><span class="icon-clipboard-text"></span> About Us</h3>

                            <ul class="list-unstyled">

                                <li><a href="#">About</a></li>                                                                

                                <li><a href="#">Team</a></li>

                                <li><a href="#">Why use us?</a></li>

                                <li><a href="#">Careers</a></li>

                            </ul>

                        </div>

                        <div class="col-md-2 col-sm-4">                            

                            <h3 class="title"><span class="icon-lifebuoy"></span> Need Help?</h3>

                            <ul class="list-unstyled">

                                <li><a href="#">FAQ</a></li>                                                                

                                <li><a href="#">Community</a></li>

                                <li><a href="#">Contacts</a></li>

                                <li><a href="#">Terms & Conditions</a></li>

                            </ul>

                        </div>

                        <div class="col-md-3 col-sm-6 clear-mobile">

                            <h3 class="title"><span class="icon-reading"></span> Latest News</h3>

            

                            <div class="row app-footer-articles">

                                <div class="col-md-3 col-sm-4">

                                    <img src="<?php echo base_url();?>assets/images/preview/img-1.jpg" alt="" class="img-responsive">

                                </div>

                                <div class="col-md-9 col-sm-8">

                                    <a href="#">Best way to increase vocabulary</a>

                                    <p>Quod quam magnum sit fictae veterum fabulae declarant, in quibus tam multis.</p>

                                </div>

                            </div>

            

                            <div class="row app-footer-articles">

                                <div class="col-md-3 col-sm-4">

                                    <img src="<?php echo base_url();?>assets/images/preview/img-2.jpg" alt="" class="img-responsive">

                                </div>

                                <div class="col-md-9 col-sm-8">

                                    <a href="#">Best way to increase vocabulary</a>

                                    <p>In quibus tam multis tamque variis ab ultima antiquitate repetitis tria.</p>

                                </div>

                            </div>

            

                        </div>

                        <div class="col-md-2 col-sm-6">

                            <h3 class="title"><span class="icon-thumbs-up"></span> Social Media</h3>

            

                            <a href="#" class="label-icon label-icon-footer label-icon-bordered label-icon-rounded label-icon-lg">

                                <i class="fa fa-facebook"></i>

                            </a>

                            <a href="#" class="label-icon label-icon-footer label-icon-bordered label-icon-rounded label-icon-lg">

                                <i class="fa fa-twitter"></i>

                            </a>

                            <a href="#" class="label-icon label-icon-footer label-icon-bordered label-icon-rounded label-icon-lg">

                                <i class="fa fa-youtube"></i>

                            </a>

                            <a href="#" class="label-icon label-icon-footer label-icon-bordered label-icon-rounded label-icon-lg">

                                <i class="fa fa-google-plus"></i>

                            </a>

                            <a href="#" class="label-icon label-icon-footer label-icon-bordered label-icon-rounded label-icon-lg">

                                <i class="fa fa-feed"></i>

                            </a>

            

                            <h3 class="title"><span class="icon-paper-plane"></span> Subscribe</h3>

            

                            <div class="input-group">

                                <input type="text" class="form-control" placeholder="E-mail...">

                                <div class="input-group-btn">

                                    <button class="btn btn-primary">GO</button>

                                </div>

                            </div> 

                        </div>                        

                    </div>                    

                </div>

                <div class="app-footer-line darken">                

                    <div class="copyright wide text-center">&copy; <?php echo date('Y');?> Carwash. All right reserved.</div>                

                </div>

            </div>

            <!-- END APP FOOTER -->

            <!-- APP OVERLAY -->

            <div class="app-overlay"></div>

            <!-- END APP OVERLAY -->

        </div>        
  <?php } ?>
        <!-- END APP WRAPPER --> 
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/jquery/jquery.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/bootstrap/bootstrap.min.js"></script>
       <script type="text/javascript" src="<?php echo base_url();?>js/vendor/moment/moment.min.js"></script>  
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/bootstrap-select/bootstrap-select.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- <script type="text/javascript" src="<?php //echo base_url();?>js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/maskedinput/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/form-validator/jquery.form-validator.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/noty/jquery.noty.packaged.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/datatables/dataTables.bootstrap.min.js"></script>
        
         <script type="text/javascript" src="<?php echo base_url();?>js/vendor/sweetalert/sweetalert.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/knob/jquery.knob.min.js"></script>
        
      <!--  <script type="text/javascript" src="<?php //echo base_url();?>js/vendor/jvectormap/jquery-jvectormap.min.js"></script>
        <script type="text/javascript" src="<?php //echo base_url();?>js/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <script type="text/javascript" src="<?php //echo base_url();?>js/vendor/jvectormap/jquery-jvectormap-us-aea-en.js"></script> -->
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/sparkline/jquery.sparkline.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/morris/raphael.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/morris/morris.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/rickshaw/d3.v3.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/rickshaw/rickshaw.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/vendor/isotope/isotope.pkgd.min.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url();?>js/app.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/app_plugins.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/app_demo.js"></script>
		

	
        <!-- END SCRIPTS -->

        
        <script>
        $(document).ready(function(){
        	
        	
			$("#add_err").css('display', 'none', 'important');
			$("#login").click(function(event){
				event.preventDefault();	
				var username = $("#user_login").val();
				var password = $("#user_pass").val();
				$.ajax({
					type: "GET",
					url: "<?php echo base_url();?>login/checkadmin",
					data: {username:username,password:password},
					success: function(response){    
						if(response == '1')    {
							window.location="<?php echo base_url();?>dashboard";
						}
						else{
							$("#add_err").css('display', 'inline', 'important');
							$("#add_err").html("<img src=<?php echo base_url();?>assets/images/alert.png /> Wrong username or password <p></p>");
						} 
					} 
				});
				return false; 
			});
			
			$(".edituser").click(function(edt){
				edt.preventDefault();
				$('#editUser').modal('show')				
				var uid = $(this).attr('data-uid');
				var uname = $(this).attr('data-uname');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>user/edituser",
					data: {userid:uid},
					success: function(response){    
						$('#ajax-result').html(response);
						$('.modal-title').text(uname);
					} 
				});
				return false; 
			});
			
			$(".deleteuser").click(function(dlt){
				dlt.preventDefault();			
				var uid = $(this).attr('data-uid');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>user/deleteusr",
					data: {id:uid},
					success: function(response){    
						if(response == 1){
							$('#rowID'+uid).hide('fade');
						} 
					} 
				});
				return false; 
			});
			
			$(".firstloginenable").on("click",function(){			
				var uid = $(this).attr('data-userid');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>user/enablefirstlogin",
					data: {id:uid},
					success: function(response){    
						if(response == 1){
							 window.location.reload(); 
						} 
					} 
				});
				return false; 
			});
			
			$(".verifybtn").on("click",function(evtprvt){ 
				evtprvt.preventDefault();
				var uid = $(this).attr('data-userverifyid');
				var email = $(this).attr('data-userverifyemail');
				var username = $(this).attr('data-userverifyusername');
				var tokan = $(this).attr('data-randomnumber');
				$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>user/verifyuser",
					data: {id:uid,email:email,username:username,tokan:tokan},
					success: function(response){    
						if(response == 1){
							 window.location.reload();
						} 
					} 
				});
				return false; 
			});
			$("#enamble_template").on('change', function() {
				if($(this).is(':checked')){
					$(this).val(1);
				}else{
					$(this).val(0);
				}
			});
		}); 
		
		function getdata(id){
			$(".update_user").text("Please wait...");
			var fname = $('#fname').val();
			var lname = $('#lname').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>user/updateuser",
				data: {userid:id,fname:fname,lname:lname,email:email,phone:phone},
				success: function(response){    
					if(response == 1){
						$(".update_user").text("Updated");
					}else{
						$(".update_user").text("Error!");
					}
				} 
			}); 
		}
		
        </script>
		
		<!-- Modal -->
		<div id="editUser" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body" id="ajax-result">
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>

    </body>
</html>