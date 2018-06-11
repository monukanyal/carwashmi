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
					<h2>Add/Edit Services</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="/dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">Services</a></li>
				</ul>
			</div>

			<div class="container">

			  <!-- <h2></h2> -->
			  <ul class="nav nav-pills">
			    <li class="active"><a data-toggle="pill" href="#menu1">SERVICE SETTING</a></li>
			    <li><a data-toggle="pill" href="#menu2">CANCELLATION FEE</a></li>
			    <li><a data-toggle="pill" href="#menu3">ADMIN SERVICE CHARGE</a></li>
			  
			  </ul>
			  
			  <div class="tab-content">
			    <div id="menu1" class="tab-pane fade in active">
			     <!-- BASIC INPUTS -->
			     <div class="col-md-4">
				<div class="block">
					<form class="form-inline"">
						<div class="input-group">

							<label >Add New Service</label>
							<input type="text" name="service" id="service" value="" class="form-control">
							
						</div>
						<div class="input-group">
						<!-- <label class="col-md-2 control-label">Car Type</label> -->
						<span class="input-group-addon" style="width:35%">Small</span>
						<input id="newcartype0" type="text" class="form-control" value="" placeholder="price in dollar" >
						</div>
						<div class="input-group">
						<span class="input-group-addon" style="width:35%">Medium</span>
						<input id="newcartype1" type="text" class="form-control" value="" placeholder="price in dollar">
						</div>
						<div class="input-group">
						<span class="input-group-addon" style="width:35%">Large</span>
						<input id="newcartype2" type="text" class="form-control" value="" placeholder="price in dollar">
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label"> &nbsp;</label>
							<div class="col-md-10">
								<!-- <a href="#" id="sve_srvc" style="float: right !important" class="buttonFinish btn btn-primary pull-left" style="display: block;">Save</a> -->
								<a href="#" id="upd_srvc"  class="btn btn-primary pull-left" style="display: none;float: right !important;">Update</a>
							</div>
						</div>
					</form>
				</div>
				</div>
				<!-- END BASIC INPUTS -->
				<!-- BASIC SELECT -->
			

			<!-- START PAGE CONTAINER -->
			<!-- <div class="container" id="toggle"> -->
				<!-- BASIC INPUTS -->
				<div class="col-md-8">
				<div class="block">
					
					<div class="form-group">
						<div class="block block-condensed">
							<!-- START HEADING -->
							<div class="app-heading app-heading-small">
								<div class="title">
									&nbsp;<h2> SERVICE CHARGE LIST </h2>
								</div>
							</div>
							<!-- END HEADING -->
							<div class="block-content">
								<div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
									<div class="row">
										<div class="col-sm-12">
									
											<table class="table table-striped table-bordered datatable-extended dataTable no-footer" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info">
												<thead>
													<tr role="row">
														<th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Service Name</th>
														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">CarType</th>

														<th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 232px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$evenodd = 0;
													foreach($get_services as $services){
														//print_r($services);
														$evenodd++;
														$class = ($evenodd%2==0) ? "even" : "odd";
														// switch($services->service_type){
														// 	case "0":
														// 		$service_name = "Elite";
														// 		break;
														// 	case "1":
														// 		$service_name = "Standard";
														// 		break;
														// 	case "2":
														// 		$service_name = "Premium";
														// 		break;
														// 	case "3":
														// 		$service_name = "Fast";
														// 	break;
														// }
														$pricesArr = json_decode($services->amount, true);
														//print_r($pricesArr);
														?>
														<tr role="row" class="<?php echo $class;?>" id="rowID<?php echo $services->id;?>">
															<td class="sorting_1"><?php echo $services->id;?></td>
															<td id="service_type<?php echo $services->id; ?>"><?php echo $services->service_name;?></td>
															<td>
															<div class="input-group">
															    <span class="input-group-addon" style="width:53%">Small</span>
															    <input id="cartype0<?php echo $services->id;?>" type="text" class="form-control" value="<?php echo '$'.$pricesArr[0];?>" disabled>
															  </div>
															  <div class="input-group">
															    <span class="input-group-addon" style="width:53%">Medium</span>
															    <input  id="cartype1<?php echo $services->id;?>" type="text" class="form-control" value="<?php echo '$'.$pricesArr[1];?>" disabled>
															  </div>

															  <div class="input-group">
															    <span class="input-group-addon" style="width:53%">Large</span>
															    <input  id="cartype2<?php echo $services->id;?>" type="text" class="form-control" value="<?php echo '$'.$pricesArr[2];?>" disabled>
															  </div>
															</td>
															<td><a href="javascript:void(0);" data-itemid="<?php echo $services->id;?>" class="edititem"><span class="fa fa-edit"></span></a> / <a href="javascript:void(0);" data-itemid="<?php echo $services->id;?>" class="deleteitem"><span class="fa fa-trash-o"></span></a> </td>
														</tr>
														<?php 
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
			    <div id="menu2" class="tab-pane fade">
			     <div class="panel panel-primary">
					  <div class="panel-heading">ORDER CANCELLATION FEE
					  <!-- <br><strong>Info:</strong> Price is in dollar currency. -->
					
					  </div>
					  <div class="panel-body">
					  	<div class="input-group">
					  		<span class="input-group-addon">Cancellation Fee [$]</span>
						    <input type="number" class="form-control" min="0" id="cncl_fee" placeholder="Price" value="<?php echo $get_data['cancellation_fee'];?>">
						    <div class="input-group-btn" style="font-size: 12px;">
						      <button class="btn btn-primary" id="cncl_btn" type="button">
						       Update Fee
						      </button>
						    </div>
						  </div>
					  	<p id="res_upd"></p>
					  	<p id="updateat">Last update at:<?php echo $get_data['updated_at1']; ?></p>

					  </div>
					</div>			    
				</div>
			     <div id="menu3" class="tab-pane fade">
			     <div class="panel panel-primary">
					  <div class="panel-heading">ADMIN SERVICE CHARGE
					  <br><strong>Info:</strong> It will deduct from service charge.
					
					  </div>
					  <div class="panel-body">
					  	<div class="input-group">
					  		<span class="input-group-addon">Admin Service charge [%]</span>
						    <input type="number" min="0" class="form-control" id="admn_service_chg" placeholder="Percentage" value="<?php echo $get_data['admin_service_charge'];?>">
						    <div class="input-group-btn" style="font-size: 12px;">
						      <button class="btn btn-primary" id="admn_chf_btn" type="button">
						       Update Charge
						      </button>
						    </div>
						  </div>
					  	<p id="res_upd2"></p>
					  	<p id="updateat2">Last update at:<?php echo $get_data['updated_at2']; ?></p>

					  </div>
					</div>			    
				</div>
			  </div>

			</div>	
		</div>	

<?php include'template/footer.php'; ?>
<script>
$(document).ready(function(){

	$('#cncl_btn').click(function(){
		var fee=$.trim($('#cncl_fee').val());
		console.log(fee);
		if(fee!='')
		{
				$.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>services/update_cancellation_fee',
				data: {cncl_fee:fee},
				success:function(data){
					
					if(data!='err')
					{
						var x=JSON.parse(data);
						$('#updateat').html('Last update at:'+x[0]['updated_at1']);
						$('#res_upd').html('Fee updated successfully!!').css("color", "green");
						setTimeout(function(){ 
							$('#res_upd').html('').removeAttr("style");
						 }, 3000);
						
					}
					else
					{
						$('#res_upd').html('Please provide fee correctly').css("color", "crimson");
						setTimeout(function(){ 
							$('#res_upd').html('').removeAttr("style");
						 }, 3000);
					}
				}

			});
		}
	});

	$('#admn_chf_btn').click(function(){
		var Percentage=$.trim($('#admn_service_chg').val());
		console.log(Percentage);

		if(Percentage!='')
		{
				$.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>services/update_admin_service_charge',
				data: {admin_service_charge:Percentage},
				success:function(data){
					
					if(data!='err')
					{
						var x=JSON.parse(data);
						$('#updateat2').html('Last update at:'+x[0]['updated_at2']);
						$('#res_upd2').html('Admin Service Charge has been updated successfully!!').css("color", "green");
						setTimeout(function(){ 
							$('#res_upd2').html('').removeAttr("style");
						 }, 3000);
						
					}
					else
					{
						$('#res_upd2').html('Please provide percentage value correctly').css("color", "crimson");
						setTimeout(function(){ 
							$('#res_upd2').html('').removeAttr("style");
						 }, 3000);
					}
					
				}
			});
		}
	});

	//update_admin_service_charge

	$('#sve_srvc').on('click', function(){
		console.log('#sve_srvc clicked');
		var srvc = $("#service").val();
		var cartype0_price = $('#newcartype0').val();
		var cartype1_price = $('#newcartype1').val();
		var cartype2_price = $('#newcartype2').val();
		var pricepack='{"0":'+cartype0_price+',"1":'+cartype1_price+',"2":'+cartype2_price+'}';
		var isShake = 0;
		$('#service').filter(function(){
			if ($.trim(this.value).length == 0){
				isShake = 1;
				$(this).css("border","1px solid red");				
				return false;
			}else{
				$(this).css("border","1px solid #ccc");
			}     

				if($.trim($('#newcartype0').val()).length == 0)
				{
					$('#newcartype0').css("border","1px solid red");
				}
				if($.trim($('#newcartype1').val()).length == 0)
				{
				$('#newcartype1').css("border","1px solid red");
				}

				if($.trim($('#newcartype2').val()).length == 0)
				{
					$('#newcartype2').css("border","1px solid red");
				}      
		});
		if(srvc == ''){
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>services/add_services',
			data: {service: srvc,pricepack:pricepack},
			success:function(data){
				console.log(data);
				$("#service").val('');
				 $('#newcartype0').val('');
				 $('#newcartype1').val('');
				 $('#newcartype2').val('');
				 	//var action = 'edit';
					window.open('<?php echo base_url();?>services','_self');
			}
		});
		
		if(isShake){
			return false;
		}
	});
	//$("#toggle").hide();
	//$("#edit_srvc").click(function(){
        $("#toggle").fadeIn(1500);
        
    //});
	
	$(".edititem").click(function(){
		var id = $(this).attr('data-itemid');
		console.log(id);
		$('#sve_srvc').hide();
		$('#upd_srvc').show();
		

		$('#upd_srvc').attr('dataid',id);
		$('#upd_srvc').attr('id','upd_srvc');
		var service_type=$('#service_type'+id).html();
		$('#newcartype0').val($('#cartype0'+id).val().replace("$", ""));
		$('#newcartype1').val($('#cartype1'+id).val().replace("$", ""));
		$('#newcartype2').val($('#cartype2'+id).val().replace("$", ""));

		$('#service').val(service_type);
		//$('#upd_srvc').text('Update*');
			var action = 'edit';
				 $('html, body').animate({
		        'scrollTop' : $("#service").position().top
		    });

		// $.ajax({
		// 	type: "POST",
		// 	url: "<?php //echo base_url();?>services/service_action",
		// 	data: {id:id,action:action,service_type:service_type},
		// 	success: function(response){    
		// 		$('#service').val(response);
		// 	} 
		// });
		return false; 
	});
	
	$("#upd_srvc").click(function(){
		//console.log('upd_srvc clicked');
		var id = $('#upd_srvc').attr('dataid');
		var service_name = $('#service').val();
		var cartype0_price = $('#newcartype0').val();
		var cartype1_price = $('#newcartype1').val();
		var cartype2_price = $('#newcartype2').val();
		var action = 'update';
		//var pricepack={"0":cartype0_price,"1":cartype1_price,"2":cartype2_price};
		var pricepack='{"0":'+cartype0_price+',"1":'+cartype1_price+',"2":'+cartype2_price+'}';
		var completedata={id:id,service_name:service_name,action:action,pricepack:pricepack};
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>services/service_action",
			data:completedata,
			success: function(response){    
				console.log(response);
				if(response)
				{
					window.open('<?php echo base_url();?>services','_self');
				}
			} 
		});
		//return false; 
	});
	
	$(".deleteitem").click(function(){			
		var id = $(this).attr('data-itemid');
		var action = 'delete';
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>services/service_action",
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