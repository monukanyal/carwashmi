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
					<li><a href="javascript:void(0);">Services</a></li>
				</ul>
			</div>

			<div class="container">
			<div id="template1">
		
				<div class="panel panel-primary">
				<div class="panel-heading">Washer Email Template</div>
				  <div class="panel-body">
				  		<div class="form-group">
					    <label class="control-label col-sm-2" for="email">Email Subject:</label>
					    <div class="col-sm-10">
					      <input type="text"  class="form-control" id="cl_subject" value="<?php if(!empty($washer)) { echo $washer[0]['subject'];} ?>"> 
					    </div>
					  </div>
					  <div class="form-group">
						<label class="control-label col-sm-2" for="email">Email Body:</label>
						<div class="col-sm-10">
						<div id="toolbar-toolbar" class="toolbar">
						  <span class="ql-formats">
						  <select class="ql-font">
						  <option selected=""></option>
						  <option value="serif"></option>
						  <option value="monospace"></option>
						  </select>
						  <select class="ql-size">
						  <option value="small"></option>
						  <option selected=""></option>
						  <option value="large"></option>
						  <option value="huge"></option>
						  </select>
						  </span>
						  <span class="ql-formats">
						  <button class="ql-bold"></button>
						  <button class="ql-italic"></button>
						  <button class="ql-underline"></button>
						  <button class="ql-strike"></button>
						  </span>
						  <span class="ql-formats">
						  <select class="ql-color"></select>
						  <select class="ql-background"></select>
						  </span>
						  <span class="ql-formats">
						  <button class="ql-list" value="ordered"></button>
						  <button class="ql-list" value="bullet"></button>
						  <select class="ql-align">
						  <option selected=""></option>
						  <option value="center"></option>
						  <option value="right"></option>
						  <option value="justify"></option>
						  </select>
						  </span>
						  <span class="ql-formats">
						  <button class="ql-link"></button>
						  <button class="ql-image"></button>
						  </span>
						  </div>
						    <div id='edit1' style="margin-top: 0px;">
						    <?php if(!empty($washer)) { echo $washer[0]['content'];} else{ ?>
						      	 <h2> Mail body</h2>
						    	  <h4> Mail footer</h4>
						    	  <?php } ?>
						    </div>
						</div>
						</div>
						<div class="form-group">
						<p id="updateat">Last update at: <?php if(!empty($washer)) { echo $washer[0]['updated_at'];} ?></p>
						<p id="res_upd" style="float: right"></p>
  							<button type="button" class="btn btn-primary" id="cl_upd" style="float: right">Update</button>
       					</div>  
       				</div>  
				  </div>
				 <!--  <div class="panel-footer">Panel Footer</div> -->
				</div>
			</div>	
		</div>	

<?php include'template/footer.php'; ?>
	<link href="https://cdn.quilljs.com/1.3.3/quill.snow.css" rel="stylesheet">
	 <script src="//cdn.quilljs.com/1.3.3/quill.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			var quill = new Quill('#edit1', {
			  	modules: {
			    toolbar: { container: '#toolbar-toolbar' }
			  },
			  theme: 'snow'
			});


	$('#cl_upd').click(function(){
		var cl_subject=$.trim($('#cl_subject').val());
		// console.log(cl_subject);
		var content=$('.ql-editor').html();
		if((cl_subject.length>=4)&&(content.length>=0))
		{
				console.log(content);
				
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url();?>services/update_template_washer',
					data: {subject:cl_subject,body:content},
					success:function(data){
						
						if(data!='err')
						{
							var x=JSON.parse(data);
							$('#updateat').html('Last update at:'+x[0]['updated_at']);
							$('#res_upd').html('Great!! template updated successfully for washer!!').css("color", "green");
					setTimeout(function(){ 
						$('#res_upd').html('').removeAttr("style");
					 }, 3000);
							
						}
						else
						{
							$('#res_upd').html('Something is wrong while updating template,please try later!!').css("color", "crimson");
							setTimeout(function(){ 
								$('#res_upd').html('').removeAttr("style");
							 }, 3000);
						}
						
					}
				});
		}
		else
		{
			$('#res_upd').html('Please provide subject and body as well!!').css("color", "crimson");
							setTimeout(function(){ 
								$('#res_upd').html('').removeAttr("style");
							 }, 3000);
		}
	});

});
</script>