<?php 
include 'template/front_header.php'; 
?>
	<section class="header-section-1 bg-contact-image-3 header-js" id="header" >
		<div class="overlay-color">
			<div class="container">
				<div class="row section-separator">
					<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
						<div class="part-inner text-center">
							<h1 class="title">Contact Us</h1> 
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<section class="features-section-5 bg-image-3 relative" id="contact">
		<div class="container">
			<div class="row section-contact-separator">

				<div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
					<div class="form-outer background-light">

						<div class="clearfix"></div>
						
						<form id="contact-form" method="post" class="single-form" action="#">

							<div class="message col-xs-12">
								<div class="inner"> 

									<p class="email-loading"><img src="<?php echo base_url();?>images/loading.gif" alt="">&nbsp;&nbsp;&nbsp;Sending...</p>
									<p class="email-success"><i class="icon icon-icon-check-alt2"></i> Your quote has successfully been sent.</p>
									<p class="email-failed"><i class="icon icon-icon-close-alt2"></i> Something went wrong!</p>

								</div>
							</div> 

							
							<div class="col-sm-6">
								<input name="name" class="contact-name form-control" id="contact-name" type="text" placeholder="Name"  required="">
							</div>

							<div class="col-sm-6">
								<input name="name" class="contact-email form-control" id="contact-email" type="email" placeholder="Email"  required="">
							</div>

							<div class="col-sm-12">
								<input name="name" class="contact-subject form-control" id="contact-subject" type="text" placeholder="Subject"  required="">
							</div>

							<div class="col-sm-12">
								<textarea class="contact-message form-control" id="contact-message" rows="3" placeholder="Message" required=""></textarea>
							</div>
							
							<div class="btn-form text-center col-xs-12">
								<button class="btn btn-fill right-icon">send message <i class="icon icons8-advance"></i></button>
							</div>
						</form>

					</div>
				</div>

			</div>
		</div>
	</section>	
<?php include 'template/front_footer.php';?>		