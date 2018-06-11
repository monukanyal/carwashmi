<?php include'template/header.php'; ?>
	<?php include'template/sidebar.php'; ?>     
		<!-- START APP CONTENT -->
		<div class="app-content app-sidebar-left">
			<!-- START APP HEADER -->
			<?php include'template/righ-header.php'; ?>
			<!-- START PAGE HEADING -->
			<div class="app-heading app-heading-bordered app-heading-page">
				<div class="title">
					<h2>Page Setting</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
					<li><a href="javascript:void(0);">Add New Page</a></li>
				</ul>

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
												
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Banner</label>
														<div class="col-md-10">
															<input type="file" name="page_banner" id="page_title" />
														</div>
													</div>
												</div>
												
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Page Title</label>
														<div class="col-md-10">
															<input type="text" name="page_title" id="page_title" />
														</div>
													</div>
												</div>
												
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label">Page Content</label>
														<div class="col-md-10">
															<textarea name="page_content" id="page_content"></textarea>
														</div>
													</div>
												</div>
												
												<div class="container">
													<div class="form-group">
														<label class="col-md-2 control-label"> &nbsp;</label>
														<div class="col-md-10">
															<button id="save_settings" class="buttonFinish btn btn-primary pull-left" style="display: block;">Add New Page</button>
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