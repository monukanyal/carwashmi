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
					<h2>REQUEST PAYMENT STATUS</h2>
				</div>
			</div>
			<div class="app-heading-container app-heading-bordered bottom">
				<ul class="breadcrumb">
					<li><a href="/dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0);">Services</a></li>
				</ul>
			</div>

			<div class="container">
			   <div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>ALL ORDER LIST</h2>
                                            <p>Quick information</p>
                                        </div>              
                                    <div class="heading-elements">
                                           <div align="right" id="pagination_link"></div>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                    	<div class="table-responsive" id="data_table"></div>
                                    </div>
                 </div>
			</div>	

<?php include'template/footer.php'; ?>
		<script type="text/javascript">
		$(document).ready(function(){

			  function load_country_data(page)
				 {
				  $.ajax({
				   url:"<?php echo base_url(); ?>dashboard/pagination/"+page,
				   method:"GET",
				   dataType:"json",
				   success:function(data)
				   {
				    $('#data_table').html(data.country_table);
				    $('#pagination_link').html(data.pagination_link);
				   }
				  });
				 }
				 
				 load_country_data(1);

				 $(document).on("click", ".pagination li a", function(event){
				  event.preventDefault();
				  var page = $(this).data("ci-pagination-page");
				  load_country_data(page);
 				});
		});
		</script>