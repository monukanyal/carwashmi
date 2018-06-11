<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Reset Password</title>
		<!-- CSS -->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="/forgot-password/assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="/forgot-password/assets/css/font-awesome.min.css">
		<link rel="stylesheet" href="/forgot-password/assets/css/form-elements.css">
		<link rel="stylesheet" href="/forgot-password/assets/css/style.css">
	</head>
	<body>
		<!-- Top content -->
		<div class="top-content">
			<div class="inner-bg">
				<div class="container">
					
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 text">
							<h1><strong>Carwash</strong> Reset Password</h1>                            
						</div>
					</div>                   
					<div class="col-sm-6 col-sm-offset-3 text">                        	
						<div class="form-box">
							<?php 
							if(!isset($_GET['hash'])){
								?>
								<div class="form-top">
									<div>
										<h3>You have no request for change password!</h3>
									</div>
								</div>
								<?php
							}else{
								?>
								<div class="form-top">
									<div class="form-top-left">
										<h3>Change your password for carwash</h3>
										<p>Enter password and confirm password:</p>
									</div>
									<div class="form-top-right">
										<i class="fa fa-lock"></i>
									</div>
								</div>
								<div class="form-bottom">
									<div class="form-group">
										<div id="success"> </div>
									</div>
									<input type="hidden" id="hash" value="<?php echo (isset($_GET['hash'])) ? $_GET['hash'] : '';?>" />
									<div class="form-group">
										<label class="sr-only" for="form-username">Password</label>
										<input type="password" name="form-username" id="password" placeholder="Password..." class="form-username form-control" id="form-username">
									</div>
									<div class="form-group">
										<label class="sr-only" for="form-password">Confirm Password</label>
										<input type="password" name="form-password" id="confirm_password" placeholder="Confirm Password..." class="form-password form-control" id="form-password">
									</div>                                        
									<button type="submit" class="btn col-sm-5" id="update_pass">Update Password</button>
									<br />
									<br />
								</div>
								<?php 
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>        
		<script src="/forgot-password/assets/js/jquery-1.11.1.min.js"></script>
		<script src="/forgot-password/assets/js/bootstrap.min.js"></script>
		<script src="/forgot-password/assets/js/jquery.backstretch.min.js"></script>
		<script src="/forgot-password/assets/js/scripts.js"></script>
		<div class="backstretch" style="left: 0px; top: 0px; overflow: hidden; margin: 0px; padding: 0px; height: 311px; width: 1349px; z-index: -999999; position: fixed;"><img src="/forgot-password/assets/img/backgrounds/1.jpg" style="position: absolute; margin: 0px; padding: 0px; border: none; width: 1349px; height: 843.125px; max-height: none; max-width: none; z-index: -999999; left: 0px; top: -266.063px;"></div> 
		<script>
		$(document).ready(function(){
			var url = "/forgot-password/pwd.php";
			$('#update_pass').on('click', function(){
				$("#update_pass").text('Please wait...');
				var password = $('#password').val();
				var confpassword = $('#confirm_password').val();
				var hash = $('#hash').val();
				if(confpassword != password){
					$('#success').html('Password not match!');
					$("#update_pass").text('Update');
					return false;
				}
				
				$.ajax({
					type: "POST",
					url: url,
					data: {pass:password,confpass:confpassword,hash:hash}, 
					success: function(response){
						if(response == 1){
							$('#success').html('Password changed successfully.');
							$("#update_pass").text('Updated');
							$('#password').val('');
							$('#confirm_password').val('');
							$('#hash').val('');
						}
						console.log(response.blablabla);
						// put on console what server sent back...
					}
				});
			});
		});
		</script>
	</body>
</html>