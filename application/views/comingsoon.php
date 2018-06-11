<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
	   	<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="<?php echo base_url();?>comingsoon/img/favicon.ico" type="image/x-icon">
		<title>Carwashmi - Coming Soon</title>
	
		<link href='//fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' type='text/css'>
		<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>comingsoon/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>comingsoon/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>comingsoon/css/animate.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>comingsoon/css/custom.css">
		<style>
		.custom_height{
			height: 400px !important;	
		}
		.input-group .form-control{
			width:68% !important;
		}
		</style>
	</head>
	<body>
		<div class="body-wrapper">
			<section class="header custom_height" id="overlay-1">
				<div class="header-wrapper">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-md-offset-2 text-center">
								<div class="theme-name">
									<a href="#" class="title">Carwashmi</a>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<div class="header-text">
									<p class="service-text">our awesome product and services are</p>
									<p class="coming">coming soon</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="newsletter text-center">
				<div class="newsletter-wrapper">
					<div class="container">
						<div class="row">
							<h2 class="newsletter-text">Send us email for more updates</h2>
							<div class="col-md-8 col-md-offset-2">
							       <div id="successmsg" />
								<form method="post" action="/subscribe/add_subscriber">
								
								<?php
								if (!empty($_SERVER["HTTP_CLIENT_IP"]))
								{
								 //check for ip from share internet
								 $ip = $_SERVER["HTTP_CLIENT_IP"];
								}
								elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
								{
								 // Check for the Proxy User
								 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
								}
								else
								{
								 $ip = $_SERVER["REMOTE_ADDR"];
								}
								?>
								<input type="hidden" name="subsriber_ip" id="subsriber_ip" value="<?php echo $ip;?>" />
	  								<div class="form-group">
	    								<div class="input-group">
	      									<div class="input-group-addon"><i class="fa fa-envelope-o"></i></div>
	      									<input type="text" class="form-control" placeholder="Enter Your Email Here..." name="subscriber_email" id="subscriber_email" /> <button class="subsribe-btn" id="subscribe" type="submit">Subscribe Now</button>
	    								</div>
	    								
	  								</div>
								</form>
							</div>
						</div>
						 
					</div>
				</div> 
			</section>
			
			<section class="footer">
				<div class="footer-wrapper">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<p class="copy-right text-center">&copy; 2017 Carwashmi. All rights reserved.</p>
							</div>
							<div class="col-md-6">
								<p class="develop text-center">Developed by <a href="javascript:void(0);">wpexpertsweb </a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<script type="text/javascript" src="<?php echo base_url();?>comingsoon/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>comingsoon/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>comingsoon/js/timer.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>comingsoon/js/script.js"></script>
		
		<script> 
		jQuery(document).ready(function($){
		    
		    $(document).on('click', '.subsribe-btn', function(){
		           var subsriber_ip = $("#subsriber_ip").val();
		           var subscriber_email = $("#subscriber_email").val();
		           if(subscriber_email == ""){
		              alert("Email Required");
		              return false;
		           }
		           $.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>subscribe/add_subscriber',
				data: {subsriber_ip : subsriber_ip, subscriber_email : subscriber_email},
				success:function(data){
					console.log(data);
					$("#successmsg").html(data);
					$("#subscribe").val('');
				}
			   });
			   
			   return false;
		     });
		     
		     return false;
		});
		</script>
	
	</body>
</html>