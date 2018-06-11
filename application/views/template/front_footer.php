

        <footer class="footer-section background-dark">
            <div class="container">
                <div class="row text-center">

                    <div class="copyright">
                        <p>Copyright: Carwashmi 2017. Designed And Developed by <a href="javascript:void(0);"> wpexpertsweb </a> </p> 
                    </div>

                </div>
            </div> 
        </footer>
      
        <script src="<?php echo base_url();?>js/plagin-js/jquery-1.11.3.js"></script>
        <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>js/plagin-js/plagin.js"></script>

        <script src="<?php echo base_url();?>js/custom-scripts.js"></script>

		<script src="<?php echo base_url();?>assets/js/slick.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/placeholdem.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/waypoints.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/scripts.js"></script>
		<script>
			$(document).ready(function() {
				appMaster.preLoader();
			});
			
			jQuery(document).ready(function($) {
				var url = "<?php echo base_url();?>";
				$("#navbar-nav li a").on("click", function(){
					var val = $(this).attr("data-click");
					if(val == "index"){
						window.location.href = url;
					}
					else{
						window.location.href = url + val;
					}
					return false;
				});
			});
		</script>

    </body>

</html>