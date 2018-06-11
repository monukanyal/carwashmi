<?php 
include'template/header.php';
// echo "<pre>";
// print_r($this->User_model->users());
// echo "</pre>";
$users = $this->User_model->users();
$count = "";
?>
<style>
#overlay{
    position: fixed; 
    width: 100%; 
    height: 100%; 
    top: 0px; 
    left: 0px; 
    background-color: #000; 
    opacity: 0.7;
    filter: alpha(opacity = 70) !important;
    display: none;
    z-index: 100;
    
}

#overlayContent{
    position: fixed; 
    width: 80%;
    top: 100px;
    text-align: center;
    display: none;
    overflow: hidden;
    z-index: 100;
}

#contentGallery{
    margin: 0px auto;
}

#imgBig, #imgSmall{
    cursor: pointer;
}
li{
	list-style:none;
}
.documentList{
	margin:0px;
	padding:0px;
}
.documentList li{
	list-style:none;
	float:left;
	width:50%;
}
.nopadding {
   padding: 0 !important;
   margin: 0 !important;
}
.customhw{
	max-width: 75% !important;
    max-height: 145px !important;
    left: 30px;
    position: relative;
    width: 100%;
    height: 145px;
	border-radius: 10px;
}
img.imgSmall {
    max-width: 90%;
    max-height: 135px;
    height: 135px;
    width: 90%;
}
</style>
<!-- APP WRAPPER -->
		 <?php include'template/sidebar.php'; ?>
       
                <!-- START APP CONTENT -->

                <div class="app-content">

                    <!-- START APP HEADER -->

                   <?php include'template/righ-header.php'; ?>

                    <!-- END APP HEADER  -->

                    

                    <!-- START PAGE HEADING -->

                    <div class="app-heading app-heading-bordered app-heading-page">

                        <div class="icon icon-lg">

                            <span class="icon-group-work"></span>

                        </div>

                        <div class="title">

                            <h1>Users List</h1>

                            <p>List of Users With Info</p>

                        </div>               

                        <!--<div class="heading-elements">

                            <a href="#" class="btn btn-danger" id="page-like"><span class="app-spinner loading"></span> loading...</a>

                        </div>-->

                    </div>

                    <div class="app-heading-container app-heading-bordered bottom">

                        <ul class="breadcrumb">

                            <li><a href="#">Application</a></li>

                            <li><a href="#">Pages</a></li>

                            <li class="active">Users List</li>

                        </ul>

                    </div>

                    <!-- END PAGE HEADING -->
                    <!-- START PAGE CONTAINER -->

                    <div class="container">
						<div id="overlay"></div>
						<div class="row">
						<ul>
						<?php
						$mg = array();
						$flnam = array();
						$profileimg = array();
						$uidd = array();
						foreach(glob(FCPATH . 'uploadedImages/*.{jpg,png,jpeg,gif}', GLOB_BRACE) as $filename){ 
							$imgarr = explode("/", $filename);
							//echo "<pre>";
							//print_r($imgarr);
							//die;
							$mystring = $imgarr[6];
							if (strpos($mystring, "Profile") == false) {
							  	$user_document_id = strtok($mystring, '_');
							  	//echo $user_document_id.'<br>';
								$flnam[] = str_replace($user_document_id . "_", "", $imgarr[6]);

								$mg[] = $user_document_id;
							}

                            if (strpos($mystring, "Profile") !== false) {
							  	$user_profile_id = strtok($mystring, '_');
								$profileimg[] = str_replace($user_profile_id . "_", "", $imgarr[6]);
								$uidd[] = $user_profile_id;
							}
							
						}
						//echo "<pre>";
						//print_r($flnam);
						//print_r($mg);
						//echo "</pre>";
						
						foreach($users as $user){
							$mm = 0;
							foreach($mg as $m){
								if($user->user_id == $m){
									$addvalue = $m . "_" . $flnam[$mm];
									if (strpos($addvalue, "Profile") == false) {
										  
									ob_start();
									?>
									<div id="overlayContent">
										<img class="imgBig" src="<?php echo base_url() . "uploadedImages/" . $addvalue;?>" alt="" width="400px" />
									</div>  
									<?php 
									$imcont = ob_get_clean();
									echo $imcont;
								
									}
								}
								$mm++;
							}
							
							$usertype = (ucfirst($user->user_type) == 0)?"Customer":"Washer";
							?>
							<li id="rowID<?php echo $user->user_id;?>">
                                                         
                                <div class="block block-condensed">

                                    <div class="col-md-6 nopadding">
										<div class="col-md-4 nopadding">
											<?php 
											$imgExists = FCPATH . "uploadedImages/".$user->profile_pic;
											$c = "";
											if(file_exists($imgExists)){
												$c = 1;
											}else{
												$c = 0;
											}
											
											if($c == 0){
												?>
												<img class="customhw" src="<?php echo base_url();?>assets/images/users/user-60.jpg">
												<?php
											}else if($user->profile_pic != ""){
												?>
												<img class="customhw" src="<?php echo base_url();?>uploadedImages/<?php echo $user->profile_pic;?>">
												<?php
											}else{
												?>
												<img class="customhw" src="<?php echo base_url();?>assets/images/users/user-60.jpg">
												<?php
											}
											?>
											
										</div>
										<div class="col-md-8">
											<div class="contact-container">
												<div class="list-group">
													<div class="col-md-3"><strong>Name: </strong></div> 
													<div class="col-md-9">
														<a href="javascript:void(0);">
															<strong><font color="#989898"><?php echo ($user->first_name != "") ? ucfirst($user->first_name.' '.$user->last_name) : "Guest";?></font></strong>
														</a> 
													</div>
												</div>
												<div class="list-group">
													<div class="col-md-3"> <strong>Type: </strong></div>
													<div class="col-md-9">
														<span>
															<strong><font color="#989898"><?php echo (ucfirst($user->user_type) == 0)?"Customer":"Washer";?></font></strong>
														</span>
													</div>
												</div>
												<?php if($usertype == "Washer"){ ?>
												<div class="list-group">
													<div class="col-md-3"> <strong>Amount: </strong></div>
													<div class="col-md-9">
														<span>
															<strong><font color="#989898">$<?php echo (ucfirst($user->points) != 0) ? number_format($user->points, 2) : number_format("0", 2);?></font></strong>
														</span>
													</div>
												</div>
												<?php } ?>
												<div class="list-group">
													<div class="col-md-3"> <strong>Address:</strong> </div>
													<div class="col-md-9"> 
														<strong><font color="#989898"><?php echo ($user->location != "") ? $user->location : "No Locatino/Address found!";?></font></strong>
													</div>
												</div>

												<div class="list-group">
													<div class="col-md-3"> <strong>Phone: </strong></div>
													<div class="col-md-9">
														
														<strong><font color="#989898"><?php $phone = ($user->mobile_number != "") ? $user->mobile_number : "No phone number found!";?>
														<?php 
														echo $formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone);
														?>
														</font></strong>
													</div>
												</div>

												<div class="list-group">
													<div class="col-md-3"> <strong>Email: </strong></div>
													<div class="col-md-9">
														<strong><font color="#989898"><?php echo $user->email;?></font></strong>
													</div>
												</div>
											</div> 

											
										</div>
										
                                    </div>
									
                                    <div class=" col-md-4 nopadding">                                        
										
										<ul class="documentList">
											<div class="col-md-12" style="padding: 0px;"> 
												<div class="pull-left">
													<strong> 
														<?php if($usertype == "Washer"){ echo "Documents:"; } ?> 
													</strong>
												</div> 
											</div>
											<div class="col-md-12" style="padding: 0px;"> 
												<?php 
												ob_start();
												$kl = 0;
												foreach($mg as $m){
													if($user->user_id == $m && $usertype != "Customer"){
														$addvalue = $m . "_" . $flnam[$kl];
														?>
														<li>
															 <img class="imgSmall" src ="<?php echo base_url()  . 'uploadedImages/' . $addvalue; ?>" height="60px" width="60px">
														</li>
														<?php 
													}
													$kl++;
												}
												$documents = ob_get_clean(); 
												if($documents){
													echo $documents;
												}else{
													if($usertype != "Customer") echo "<strong><font color='#989898'>No Document Found!</font></strong>";
												}
												?>
											</div> 
										</ul>
                                    </div>
                                    
                                    <div class="col-md-2 nopadding">   
										<div class="panel panel-default">
										<?php if($usertype == "Washer"){ ?>
												<?php 
												if($user->verify_by_admin == 1){ ?>
													<div class="panel-heading">
														<button type="submit" name="submit" class="adminbtn btn-success" disabled>
															<span class="fa fa-check"></span>  Approved
														</button>
													</div>
													
													<div class="panel-heading">
														<span><?php echo ($user->firstlogin != 0)?"<font color='green'><strong>Login Enabled</strong></font>":"<a href='#' class='firstloginenable' data-userid='".$user->user_id."'><font color='#ff0000'>Enable Login</font></a>";?>
														</span>
													</div>
												<?php 
												}else{
												?>
													<div class="panel-heading">
														<button type="submit" name="submit" class="adminbtn btn-danger verifybtn" data-userverifyid="<?php echo $user->user_id;?>" data-userverifyemail="<?php echo $user->email;?>" data-userverifyusername="<?php echo $user->first_name.' '.$user->last_name;?>" data-randomnumber="<?php echo $user->tokan;?>" />
															<span class="fa fa-times"></span>  Approve
														</button>
													</div>
													<div class="panel-heading">
														<div class="pull-right"><span><?php echo ($user->firstlogin != 0)?"<font color='green'><strong>Login Enabled</strong></font>":"<a href='#' class='firstloginenable' data-userid='".$user->user_id."'><font color='#ff0000'>Enable Login</font></a>";?></span>
														</div>
													</div>
												<?php } ?>
											<?php }else{ ?>
											
											 
												<div class="panel-heading">
													<span><?php echo ($user->firstlogin != 0)?"<font color='green'><strong>Login Enabled</strong></font>":"<a href='#' class='firstloginenable' data-userid='".$user->user_id."'><font color='#ff0000'>Enable Login</font></a>";?></span>
												</div>
											
											<?php } ?>
										
											<div class="panel-heading">
												<button class="btn btn-danger btn-clean btn-icon deleteuser" data-uid="<?php echo $user->user_id;?>"><span class="fa fa-trash-o"></span></button>
												<button class="btn btn-success btn-clean btn-icon edituser" data-toggle="modal" data-target="#editUser" data-uid="<?php echo $user->user_id;?>" data-uname="<?php echo $user->first_name;?>"><span class="fa fa-edit"></span></button>
											</div>
										</div>    
									</div>                                
							</li>
							<?php
						}?>
						</ul>
                    </div>

                    <!-- END PAGE CONTAINER -->
                </div>

                <!-- END APP CONTENT -->

                                

            </div>

            <!-- END APP CONTAINER -->

<?php include'template/footer.php'; ?>	
<script>
jQuery(document).ready(function($){
$(".imgSmall").click(function(){		                                       
    $("#overlay").show();
     $("#overlayContent").show();
});

$(".imgBig").click(function(){
    $("#overlay").hide();
    $("#overlayContent").hide();
});
});
</script>	