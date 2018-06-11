<?php include'template/header.php'; ?>
	<?php include'template/sidebar.php'; ?>     
		<!-- START APP CONTENT -->
		<div class="app-content app-sidebar-left">
			<!-- START APP HEADER -->
			<?php include'template/righ-header.php'; ?>
			<!-- START PAGE HEADING -->
			<div class="app-heading app-heading-bordered app-heading-page">
				<div class="title">
					<h2>Website Setting</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
					<li><a href="javascript:void(0);">Web Site Front End Settings</a></li>
				</ul>
				
				<div style="float:right;">
				<a href="settings/pages">Page Settings</a>
				</div>
			</div>
			<!-- END PAGE HEADING -->

			<div class="container">
				<!-- BASIC INPUTS -->
				<div class="block">
					<div class="form-group">
						<div class="block block-condensed">
							<div class="block-content">
								<div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<div class="row">
										<div class="col-sm-12">
											<form class="form-horizontal" method="post" enctype="multipart/form-data" action="settings/save_settings">
												<input type="hidden" name="id" id="id" value="<?php echo $settings[0]->id;?>" />
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Enable Coming Soon Template</label>
														<div class="col-md-10">
															<input type="checkbox" name="enamble_template" id="enamble_template" value="<?php echo $settings[0]->coming_soon; ?>" <?php if(isset($settings[0]->coming_soon) && $settings[0]->coming_soon == 1){ echo "checked = 'checked'"; } ?> />
														</div>
													</div>
												</div>
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Web Site Name</label>
														<div class="col-md-10">
															<input type="text" name="site_name" id="site_name" value="<?php echo $settings[0]->site_name;?>" class="form-control" />
														</div>
													</div>
												</div>
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Admin Email</label>
														<div class="col-md-10">
															<input type="text" name="admin_email" id="admin_email" value="<?php echo $settings[0]->admin_email;?>" class="form-control" />
														</div>
													</div>
												</div>
												<?php 
												if($settings[0]->site_favicon != ""){
													?>
													<div class="container">
														<div class="form-group">
															<label class="col-md-2 control-label">Upload Favicon</label>
															<div class="col-md-4">
																<img src="<?php echo $uploadpath . $settings[0]->site_favicon;?>" />
															</div>
															<div class="col-md-4">
																<input type="file" name="favicon" id="site_favicon" />
															</div>
														</div>
													</div>
													<?php 
												} ?>
												
												<?php if($settings[0]->site_logo != ""){
													?>
													<div class="container">
														<div class="form-group">
															<label class="col-md-2 control-label">Upload Logo</label>
															<div class="col-md-4">
																<img src="<?php echo $uploadpath . $settings[0]->site_logo;?>" />
															</div>
															<div class="col-md-4">
																<input type="file" name="site_logo" id="site_logo" />
															</div>
														</div>
													</div>
													
													<?php 
												}
												?>
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label"> &nbsp;</label>
														<div class="col-md-10">
															<button id="save_settings" class="buttonFinish btn btn-primary pull-left" style="display: block;">Update</button>
														</div>
													</div>
												</div>
												
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BASIC INPUTS -->
				<!-- BASIC SELECT -->
			</div>
		</div>	
<?php include'template/footer.php'; ?>