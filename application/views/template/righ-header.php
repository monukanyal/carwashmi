 <div class="app-header">

	<ul class="app-header-buttons">

		<li class="visible-mobile"><a href="#" class="btn btn-link btn-icon" data-sidebar-toggle=".app-sidebar.dir-left"><span class="icon-menu"></span></a></li>

		<li class="hidden-mobile"><a href="#" class="btn btn-link btn-icon" data-sidebar-minimize=".app-sidebar.dir-left"><span class="icon-list4"></span></a></li>

	</ul>

	<form class="app-header-search" action="" method="post">        

		<input type="text" name="keyword" placeholder="Search">

	</form>    



	<ul class="app-header-buttons pull-right">

		<li>

			<div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls">

				<img src="<?php echo base_url();?>assets/images/users/user-60.jpg" alt="John Doe">

				<div class="contact-container">
					<?php $session = $this->session->userdata;?>
					<a href="javascript:void(0);"><?php echo $session['username'];?></a>
					<?php 
					
					$admin = ($session['username'] == '19chetan87sharma@gmail.com') ? 'Hello Admin' : "Hello Guest";
					?>
					<span><?php echo $admin;?></span>

				</div>

				<div class="contact-controls">

					<div class="dropdown">

						<button type="button" class="btn btn-default btn-icon" data-toggle="dropdown"><span class="icon-cog"></span></button>                        

						<ul class="dropdown-menu dropdown-left">

							<li><a href="javascript:void(0);"><span class="icon-cog"></span> Settings</a></li> 

							<li><a href="<?php echo base_url();?>dashboard/profile"><span class="icon-users"></span> Profile </a></li>

							<li class="divider"></li>

							<li><a href="<?php echo base_url();?>main/logout"><span class="icon-exit-right"></span> Log Out</a></li> 

						</ul>

					</div>                    

				</div>

			</div>

		</li>        

	</ul>

</div>