<?php 
include'template/header.php'; 
?>
	<?php include'template/sidebar.php'; ?>
                
		<!-- START APP CONTENT -->
		<div class="app-content app-sidebar-left">
			<!-- START APP HEADER -->
			<?php include'template/righ-header.php'; ?>
			
			<style>

			  #top,
			  #calendar.fc-unthemed {
			    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
			  }

			  #top {
			    background: #eee;
			    border-bottom: 1px solid #ddd;
			    padding: 0 10px;
			    line-height: 40px;
			    font-size: 12px;
			    color: #000;
			  }

			  #top .selector {
			    display: inline-block;
			    margin-right: 10px;
			  }

			  #top select {
			    font: inherit; /* mock what Boostrap does, don't compete  */
			  }

			  .left { float: left }
			  .right { float: right }
			  .clear { clear: both }

			  #calendar {
			    max-width: 900px;
			    margin: 40px auto;
			    padding: 0 10px;
			  }
			  .customblk{
			  	border: 1px solid;
			    padding-bottom: 15px;
			    background: #1c9fea;
			    color: antiquewhite;
			  }

			</style>
			<!-- START PAGE HEADING -->
			<div class="app-heading app-heading-bordered app-heading-page">
				<!-- <div class="title">
					<h2>Edit Email Templates</h2>
				</div> -->
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="/dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">Promotions</a></li>
				</ul>
			</div>

			<div class="container">
			<div class="col-md-5">
				<div class="panel panel-primary">
				<div class="panel-heading"><h4>PROMOTION SCHEDULAR</h4><?php if($this->session->flashdata('saved')) { ?> <strong style="color:yellowgreen"><?php  echo 'Promotion has been created successfully!';?></strong><?php } ?><?php if($this->session->flashdata('updated')) { ?> <strong style="color:yellowgreen"><?php  echo 'Promotion has been updated successfully!';?></strong><?php } ?> </div>
				<div class="panel-body">
					<form id="mainform" class="form-inline" action="<?php echo base_url(); ?>dashboard/store_promotions" method="post">
						  <div class="form-group">
						    <label class="control-label col-sm-2" for="email" style="font-size: 11px;">TITLE: </label>
						     <div class="col-sm-10">
						    <input type="text" class="form-control" name="ptitle" required style="width: 100%;margin-bottom: 5px;margin-left: 8%">
						   
						    </div>
						  </div>
						  <div class="form-group">
						    <label class="control-label col-sm-2" for="email" style="font-size: 11px;">OFFER: </label>
						     <div class="col-sm-10">
						    <input type="number" class="form-control" name="offer" min='0' required style="width: 50%;margin-bottom: 5px;margin-left: 8%">
						     <select class="form-control" id="offer_type" name="offer_type">
						    	<option value="$">$</option>
						    	<option value="%">%</option>
						    </select>	
						    </div>
						  </div>
						  <div class="form-group">
							  <label class="control-label col-sm-2" style="font-size: 11px;">DESCRIPTION: </label>
							    <div class="col-sm-10">
							  <textarea class="form-control" rows="5" cols="29" id="description" name="description" required style="resize:none;padding-right: 16px;margin-left: 8%;margin-bottom: 5px"></textarea>
							  </div>
							</div>
						    <div class="form-group">
						    <label class="control-label col-sm-2" for="email" style="font-size: 11px;">DURATION: </label>
						     <div class="col-sm-10 duration1">
						    <input type="text" class="form-control" name="pdaterange1" value="" required style="width: 100%;margin-left: 8%" />
						  	</div>
						  	 <div class="col-sm-10 duration2" style="display: none">
						    <input type="text" class="form-control" name="pdaterange2" value="" required style="width: 100%;margin-left: 8%" />
						  	</div>
						  </div>
						  <div class="form-group">
						    <label ><input type="checkbox" class="form-control" id="is1day" name="isday" value="FALSE" />Is Promotion for 1 day</label>
						  </div>
						  <input type="hidden" name="pid" id="pid" value="">
						  <button type="submit" class="btn btn-primary subbtn">SAVE</button>
						  <button type="button" class="btn btn-warning removebtn" style="display: none;">Cancel</button>
						
						  <div class="container customblk" style="display: none">
						   
						    <div class="col-md-12">
						     <p id="promotion_title" style="text-transform: uppercase;"></p>
						     Offer:<i id="promotion_offer"></i> <hr/>
						    <p style="float: right">Are you sure to delete this event? <button type="button" class="btn btn-danger deletebtn">Delete</button></p> 
						  	</div>
						  </div>

						</form>
						
						<?php //echo $calendar_list; ?>
				</div>
				</div>

			</div>
			<div class="col-md-7">
			<div class="panel panel-primary">
				<div class="panel-heading"><h4>PROMOTION LISTING</h4>
				</div>
				  <div class="panel-body">
				 <div id='calendar'></div>
				 </div>
				 </div>
			
			</div>	
		</div>	
		</div>	

<?php include'template/footer.php'; ?>
			<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.css">
			<link rel="stylesheet" type="text/css" media="print" href="<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css">
			<script src="<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js"></script>
			<script src="<?php echo base_url();?>assets/fullcalendar/theme-chooser.js"></script>
			<script>

			  $(document).ready(function() {


			  	 
			  	$('#is1day').change(function(){
			  		
			  		if($("#is1day").prop('checked') == true){
					    
					     $("#is1day").val('TRUE');
						$('.duration1').hide();
						$('.duration2').show();
					}
					else
					{
						 $("#is1day").val('FALSE');
						$('.duration1').show();
						$('.duration2').hide();
					}
			  	});
			  	 $('input[name="pdaterange2"]').daterangepicker({
				    singleDatePicker: true,
				    showDropdowns: true,
				    minYear: 1901,
				     locale: {
					      format: 'YYYY-MM-DD'
					    }
				  }, function(start, end, label) {
				   	 console.log(start.format('YYYY-MM-DD'));
				  });


			  	 $('input[name="pdaterange1"]').daterangepicker({
				    opens: 'center',
				    timePicker: true,
				    startDate: moment().startOf('hour'),
				    endDate: moment().startOf('hour').add(32, 'hour'),
				     locale: {
					      format: 'YYYY-MM-DD HH:MM:SS'
					    },
					    autoApply:true
				  }, function(startDate, endDate, label) {
				   // console.log("A new date selection was made: " + startDate.format('YYYY-MM-DD HH:MM:SS') + ' to ' + endDate.format('YYYY-MM-DD HH:MM:SS'));
				  });

			  	  	$('.removebtn').on('click', function(e){
						//console.log('working btn=='+e);
						$('#pid').val('');
						$('.subbtn').html('Save');
						$('.removebtn').css('display','none');
						$('#mainform').attr('action',"<?php echo base_url(); ?>dashboard/store_promotions");
						$('input[name="ptitle"]').val('');
						$('input[name="offer"]').val('');
						$('textarea#description').val('');
						$('div.customblk').css('display','none');
					});

					$('.deletebtn').on('click',function(e){
						console.log('deleting'+$('#pid').val());
						var pid=$('#pid').val();
						   if(pid!='')
						   {
							  $.post("<?php echo base_url(); ?>dashboard/delete_promotion",{pid:pid}, function(data, status){
										if(data=='success')
										{
											window.open('<?php echo base_url(); ?>dashboard/promotions','_self');
										}
								});	
						}	
					});
			  	 initThemeChooser({

								init: function(themeSystem) {
								$('#calendar').fullCalendar({
								  themeSystem: themeSystem,
								  header: {
								    left: 'prev,next today',
								    center: 'title',
								    //right: 'month,agendaWeek,agendaDay,listMonth'
								    right: 'listMonth'
								  },
								  //defaultDate: '2018-03-12',
								  defaultView:'listMonth',
								  displayEventTime:false,
								  weekNumbers: true,
								  navLinks: true, // can click day/week names to navigate views
								  editable: true,
								  eventLimit: true, // allow "more" link when too many events
								   events: <?php echo isset($calendar_list)?$calendar_list:'';?>,
								   eventMouseover: function(event) {
								  var event_id=event.id;
								  
								  if(event.starttime!=undefined)
								  {
								  	 var tooltip = '<div class="tooltipevent" style="padding-left:2%;width:18%;height:120px;background:black;color:white;position:absolute;z-index:10001;"><p>Title:'+ event.title2 +'</p><p>Offer:'+event.offer+'</p><p>Start time:'+event.starttime+'</p><p>End Time:'+event.endtime+'</p></div>';
									 }
									 else
									 {
									 	var tooltip = '<div class="tooltipevent" style="padding-left:2%;width:18%;height:120px;background:black;color:white;position:absolute;z-index:10001;"><p>Title:'+ event.title2 +'</p><p>Offer:'+event.offer+'</p></div>';
									 }
								          var $tooltip = $(tooltip).appendTo('body');
								          $(this).mouseover(function(e) {
								              $(this).css('z-index', 10000);
								              $tooltip.fadeIn('500');
								              $tooltip.fadeTo('10', 1.9);
								          }).mousemove(function(e) {
								              $tooltip.css('top', e.pageY + 10);
								              $tooltip.css('left', e.pageX + 20);
								          });
								            
								      },
								      eventMouseout: function(calEvent, jsEvent) {
								          $(this).css('z-index', 8);
								          $('.tooltipevent').remove();
								      },
								      eventClick:function(event,jsEvent){
								      	$('i#promotion_offer').html(event.offer);
								          var event_id=event.id;
								          $('#pid').val(event.id);
								          $('.subbtn').html('Update');
								          $('.removebtn').css('display','inline-block');
								          $('#mainform').attr('action',"<?php echo base_url(); ?>dashboard/update_promotions");

								           $.post("<?php echo base_url(); ?>dashboard/fetchpromotiondata",{pid:event.id}, function(data, status){
										        //console.log("Data: " + data );
										        var maindata=JSON.parse(data);
										        $('input[name="ptitle"]').val(maindata[0]['promotion_title']);
										        $('p#promotion_title').html(maindata[0]['promotion_title']);
										        $('div.customblk').css('display','block');
										        $('input[name="offer"]').val(maindata[0]['offer'].substring(0, maindata[0]['offer'].length - 1));
										        $('#offer_type').val(maindata[0]['offer'].slice(maindata[0]['offer'].length-1));
										        $('textarea#description').val(maindata[0]['description']);
										        if(maindata[0]['promotion_day']==0)
										        {
										        	$('#is1day').prop('checked', false);
										        	$('#is1day').trigger('change');
										        	$('input[name="pdaterange1"]').val(maindata[0]['promotion_from']+' - '+maindata[0]['promotion_to']);
										        }
										        else
										        {
										        	//single
										        	$('#is1day').prop('checked', true);
										        	$('#is1day').trigger('change');
										        	$('input[name="pdaterange2"]').val(maindata[0]['promotion_date']);
										        }
										    });
								          

								        }
								});
							}

								// change: function(themeSystem) {
								// $('#calendar').fullCalendar('option', 'themeSystem', themeSystem);
								// }

						});
			});

			</script>