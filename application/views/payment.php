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
					<h2>Manage Payments</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="#">Dashboard</a></li>
					<li><a href="javascript:void(0);">Payment Settings</a></li> 
				</ul>
			</div>
			<!-- START PAGE CONTAINER -->
			<div class="container" id="toggle">
				<!-- BASIC INPUTS -->
				<div class="block">
					
					<div class="form-group">
						<div class="block block-condensed">
							<!-- START HEADING -->
							<div class="app-heading app-heading-small">
								<div class="title">
									&nbsp;
								</div>
							</div>
							<!-- END HEADING -->
							<div class="block-content">
								<div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<div class="row">
										<div class="col-sm-12">
										<?php 
										//echo '<pre>';
										//print_r($get_services);
										?>
											<table class="table table-striped table-bordered datatable-extended dataTable no-footer" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
												<thead>
													<tr role="row">
														<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Payment Type</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Card Number</th>
												<!-- 		<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Cvv</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Expiry Date</th> -->
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$evenodd = 0;
													foreach($get_payments as $payments)
													{
														$evenodd++;
														$class = ($evenodd%2==0) ? "even" : "odd";
														?>
														<tr role="row" class="<?php echo $class;?>" id="rowID<?php echo $payments->payment_settigns_id;?>">
															<td class="sorting_1"><?php echo $payments->payment_settigns_id;?></td>
															<td><?php echo $payments->card_type;?></td>
															<td><?php echo ccMasking($payments->card_number);?></td>
															<td><a href="javascript:void(0);" data-itemid="<?php echo $payments->payment_settigns_id;?>" class="deleteitem"><span class="fa fa-trash-o"></span></a> </td>
														</tr>
														<?php 
													}

													function ccMasking($number, $maskingCharacter = 'X')
													{
														return substr($number, 0, 2) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
													}
													?>
												</tbody>
											</table>
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
<script>
$(document).ready(function(){
	
	$(".deleteitem").click(function(){			
		var id = $(this).attr('data-itemid');
		var action = 'delete';
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>payment/payment_action",
			data: {id:id,action:action},
			success: function(response){    
				if(response == 1){
					$('#rowID'+id).hide('fade');
				} 
			} 
		});
		return false; 
	});
});
</script>