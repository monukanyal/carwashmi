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
				<!-- <div class="title">
					<h2>Edit Email Templates</h2>
				</div> -->
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="/dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">Client Request details</a></li>
				</ul>
			</div>

			<div class="container">
			<div id="template1">
				 <div class="panel panel-info">
				 <?php //echo json_encode($paydetails); ?>
			      <div class="panel-heading">
			      	      <div class="row">
			                <div class="col-xs-6 col-sm-6 col-md-6">
			                    <address style="color:black">
			                        <strong><u><?php if(isset($paydetails)){ echo $paydetails['customer_name'];}?></u></strong>
			                        <br>
			                         Vehical Name:<label><?php if(isset($paydetails)){ echo $paydetails['vehicle_name'];}?></label>
			                        <br>
			                         Vehical Make:<label><?php if(isset($paydetails)){ echo $paydetails['vehicle_make'];}?></label>
			                        <br>
			                         Vehical Model:<label><?php if(isset($paydetails)){ echo $paydetails['vehicle_model'];}?></label>
			                        <br>
			                         Vehical Manufacturer year:<label><?php if(isset($paydetails)){ echo $paydetails['vehicle_model_year'];}?></label>
			                        <br>
			                         Vehical Color:<label><?php if(isset($paydetails)){ echo $paydetails['vehicle_color'];}?></label>
			                        <br>
			                         <i>Created at</i>:<label><?php if(isset($paydetails)){ echo $paydetails['request_date'];}?></label>
			                        <br>
			                    </address>
			                </div>
			                <div class="col-xs-6 col-sm-6 col-md-6 text-right" style="color: black">
			                    <p>
			                        <em>Client Request ID:<?php if(isset($paydetails)){ echo $paydetails['client_request_id'];}?></em>
			                    </p>
			                    <p>
			                        <em>Accepted by:<label class="label label-success"><?php if(isset($paydetails)){ echo $paydetails['washername'];}?></label></em>
			                    </p>
			                </div>
			            </div>
			      </div>
			      <div class="panel-body">
			      	<div class="row">
			      	   <?php if(isset($paydetails)){ 
			      	   		if($paydetails['is_trans_available'])
			      	   		{
			      	   	?>
			      		<div class="col-md-6">Payment Amount <u>received by admin</u></div>
			      		<div class="col-md-6"><?php if(isset($paydetails)){ echo $paydetails['amount'];}?>$</div>
			      		<div class="col-md-6">Transaction ID</div>
			      		<div class="col-md-6"><?php if(isset($paydetails)){ echo $paydetails['transaction_id'];}?></div>
			      		
			      		<div class="col-md-6">Transaction on</div>
			      		<div class="col-md-6"><label class="label label-success"><?php if(isset($paydetails)){ echo $paydetails['transaction_date'];}?></label></div>

			      		<div class="col-md-6">Payment status</div>
			      		<div class="col-md-6"><label class="label label-success"><?php if(isset($paydetails)){ if($paydetails['payment_status']==1){  echo 'Paid'; } else{ echo 'Failed'; }}?></label></label></div>

			      		<div class="col-md-6">Payment Amount <u>received by washer</u></div>
			      		<div class="col-md-6"><?php if(isset($paydetails)){ echo $paydetails['washer_received_amount'];}?> $</div>	
			      		<div class="col-md-6">Is washer paid </div>
			      		<div class="col-md-6"><label class="label label-success"><?php if(isset($paydetails)){ if($paydetails['is_washer_paid']=='true'){echo 'Paid';} else{ echo 'Pending'; }}?></label>
			      		</div>
			      		<?php
			      			}
			      			else
			      			{
			      				?>
			      				<div class="col-md-12"> <center><p style="color:green">Payment Process is not started yet!!</p></center></div>
			      				<?php
			      			}
			
			      		 	 } 

			      		 ?>	
			      	</div>	

			      </div>
			    </div>
					
				 <!--  <div class="panel-footer">Panel Footer</div> -->
				</div>
			</div>	
		</div>	

<?php include'template/footer.php'; ?>
		<script type="text/javascript">
		$(document).ready(function(){
			




});
</script>