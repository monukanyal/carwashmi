<nav>
	<ul>
		<li><a href="<?php echo base_url();?>dashboard"><span class="icon-laptop-phone"></span> Dashboard</a></li>
		<li><a href="<?php echo base_url();?>dashboard/users"><span class="icon-group-work"></span> Users</a></li>
		<li><a href="<?php echo base_url();?>dashboard/clients"><span class="fa fa-users"></span>Customer list</a></li>
		<li><a href="<?php echo base_url();?>dashboard/washers"><span class="fa fa-users"></span>Washer list</a></li>
		<li><a href="<?php echo base_url();?>services"><span class="icon-shield-check"></span> Services</a></li>
		<li><a href="<?php echo base_url();?>dashboard/promotions"><span class="fa fa-gift"></span> Promotion</a></li>
		<li><a href="<?php echo base_url();?>requests"><span class="fa fa-taxi"></span> Requests</a></li>
		<li><a href="<?php echo base_url();?>emails"><span class="fa fa-envelope"></span> Emails</a></li>
		<li><a href="<?php echo base_url();?>payment"><span class="fa fa-credit-card"></span> Payments</a></li>
		
		<!-- <li><a href="<?php // echo base_url();?>orders"><span class="fa fa-paper-plane-o"></span> Orders</a></li> -->
	
		<li class="dropdown"><a href="#" ><span class="fa fa-envelope"></span> Email Template</a>
		
		    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
		    <li><a href="<?php echo base_url();?>dashboard/client_email_template"><span class="fa fa-paper-plane-o"></span> Client Email Template</a></li>
				<li><a href="<?php echo base_url();?>dashboard/washer_email_template"><span class="fa fa-paper-plane-o"></span> Washer Email Template</a></li>
		    </ul>
		</li> 
		<!-- <li><a href="<?php //echo base_url();?>settings"><span class="fa fa-globe"></span> Web Settings</a></li> -->
	</ul>
</nav>