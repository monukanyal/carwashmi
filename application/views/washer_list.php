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
					<h2>Washer list</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="/dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">washers</a></li>
					<li style="float: right"><button type="button" name="bulk_email" class="btn btn-info email_button" id="bulk_email" data-action="bulk">Send Bulk</button></li>
				</ul>
			</div>

			<div class="container">
			 <div class="block block-condensed">
			<p id="error_message"></p>
		<table id="example1" class="table table-bordered table-responsive-md"" style="width:100%">
        <thead>
            <tr>
            	
                <th class="nosort"><input type="checkbox" class="filled-in" id="selectAll"> All </th>
                <th>Name</th>
                <th>Email-id</th>
                <th>Address</th>
                <th>Mobile Number</th>
                <th>status</th>
                <th>Login status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <?php if(isset($washers)) { 
          	for($k=0,$m=1;$k<count($washers);$k++,$m++)
          	{
          		
          	?>
            <tr>
                <td>
                <input type="checkbox" name="single_select" class="single_select" data-email="<?php echo $washers[$k]['email'];?>"  data-name="<?php echo $washers[$k]['first_name'].' '.$washers[$k]['last_name']; ?>" />
            	</td>
               <td><?php echo $washers[$k]['first_name'].' '.$washers[$k]['last_name'];?></td>
                <td><?php echo $washers[$k]['email'];?></td>
                <td><?php echo $washers[$k]['location'];?></td>
                <td><?php echo $washers[$k]['mobile_number'];?></td>
                <td><?php if($washers[$k]['verify_by_admin']==0){?>
                 <span class="label label-danger">Unverified</span>	
                <?php }else{ ?>
                <span class="label label-success">Verified</span>
                <?php } ?>
                </td>
                <td><?php echo ($washers[$k]['firstlogin'] != 0)?"<font color='green'><strong>Enabled</strong></font>":"<a href='#' class='firstloginenable' data-userid='".$washers[$k]['user_id']."'><font color='#ff0000'>Enable Login</font></a>";?></td>
                 <td><button type="button" name="email_button" class="btn btn-info btn-xs email_button" id="<?php echo $m;?>" data-email="<?php echo $washers[$k]['email']; ?>" data-name="<?php echo $washers[$k]['first_name'].' '.$washers[$k]['last_name']; ?>" data-action="single">Send Single</button></td>
            </tr>
            <?php
            	}
             } 

             ?>
        </tbody>
    
    </table>
    </div>
			</div>	
		</div>	

<?php include'template/footer.php'; ?>

		<script type="text/javascript">
		$(document).ready(function(){
		 $('#example1').DataTable({
			 'aoColumnDefs': [{
			        'bSortable': false,
			        'aTargets': [-8] /* 1st one, start by the right */
			    }]
			});	
	$('#selectAll').click(function (e) {
	    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
	});


 $('.email_button').click(function(){
 	 $('#error_message').html("");
	  $(this).attr('disabled', 'disabled');
	  var id = $(this).attr("id");
	  var action = $(this).data("action");
	  var email_data = [];
	  if(action == 'single')
	  {
		   email_data.push({
		    email: $(this).data("email"),
		    name: $(this).data("name")
		   });
	  }
	  else
	  {
		   $('.single_select').each(function(){
		    if($(this). prop("checked") == true)
		    {
		     email_data.push({
		      email: $(this).data("email"),
		      name: $(this).data('name')
		     });
		    }
		   });
	  }
  //console.log(email_data);
  if (email_data.length === 0) {
    $('#error_message').html("please select any client").css('color','red');
    $(this).removeAttr('disabled');
    setTimeout(function(){  $('#error_message').html("");  }, 2000);
}
else
{
  $.ajax({
  		 method:"POST",
	  	 url: '<?php echo base_url();?>dashboard/send_mail_washer',
	   data:{email_data:email_data},
	   beforeSend:function(){
	    $('#'+id).html('Sending...');
	    $('#'+id).addClass('btn-danger');
	   },
	   success:function(data){
	    if(data = 'ok')
	    {
	     $('#'+id).text('Success');
	     $('#'+id).removeClass('btn-danger');
	     $('#'+id).removeClass('btn-info');
	      $('#'+id).addClass('btn-success');
	      setTimeout(()=>{  
		      if(action == 'single')
		      {
		      $('#'+id).removeClass('btn-success');  $('#'+id).addClass('btn-info').text('Send Single'); 
		      }
		      else
		      {
		      	 $('#'+id).removeClass('btn-success');  $('#'+id).addClass('btn-info').text('Send Bulk'); 
		      }
	        }, 2000);
	    }
	    else
	    {
	     $('#'+id).text(data);
	    }
	    $('#'+id).attr('disabled', false);
	   }
   
  });
}

 });


});
</script>