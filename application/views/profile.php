<?php 
include'template/header.php';
?>
	<?php include'template/sidebar.php'; ?>
                
		<!-- START APP CONTENT -->
		<div class="app-content app-sidebar-left">
			<!-- START APP HEADER -->
			<?php include'template/righ-header.php'; ?>
			<!-- START PAGE HEADING -->
			<div class="app-heading app-heading-bordered app-heading-page">
				<div class="title">
					<h2>Profile</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url();?>dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">Profile</a></li>
				</ul>
			</div>
			<!-- END PAGE HEADING -->

			<div class="container">
				<!-- BASIC INPUTS -->
					
				<div class="col-sm-6">
                <div class="panel widget light-widget panel-bd-top">
                  <div class="panel-heading no-title"> </div>
                  <div class="panel-body">
                    <div class="text-center vd_info-parent"> <img alt="example image" src="<?php echo base_url();?>assets/images/users/admin.png"> </div>

                    <h2 class="text-center font-semibold mgbt-xs-5"><?php echo $profile[0]->firstname . ' ' . $profile[0]->lastname;?></h2>
                    <h4 class="text-center">Owner at Carwash</h4>
                   
                    <div class="mgtp-20">
                      <table class="table table-striped table-hover">
                        <tbody>
                          <tr>
                            <td style="width:60%;">Type</td>
                            <td><span class="label label-success"><?php echo $profile[0]->usertype;?></span></td>
                          </tr>
                        
                        
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
              </div>
				<!-- END BASIC INPUTS -->
				<!-- BASIC SELECT -->
			</div>
		</div>	
<?php include'template/footer.php'; ?>