<?php 
include'template/header.php'; 

?>
<!-- APP WRAPPER -->
        <?php include'template/sidebar.php'; ?>
        <style type="text/css">
            .table-fit {
    width: 1px;
}
        </style>
                
                <!-- START APP CONTENT -->
                <div class="app-content app-sidebar-left">
                    <!-- START APP HEADER -->
					<?php include'template/righ-header.php'; ?>
                    <!-- END APP HEADER  -->
                    
                    <!-- START PAGE HEADING -->
                    <div class="app-heading app-heading-bordered app-heading-page">
                        <div class="icon icon-lg">
                            <span class="icon-laptop-phone"></span>
                        </div>
                        <div class="title">
                            <h1>Car-Wash - Admin Panel</h1>
                            <p></p>
                        </div>               
                        <!--<div class="heading-elements">
                            <a href="#" class="btn btn-danger" id="page-like"><span class="app-spinner loading"></span> loading...</a>
                        </div>-->
                    </div>
                    <div class="app-heading-container app-heading-bordered bottom">
                        <ul class="breadcrumb">
                            <li><a href="#">Application</a></li>                                                     
                            <li class="active">Dashboard</li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADING -->
                    
                    <!-- START PAGE CONTAINER -->
                    <div class="container">         
                        <div class="row">
                            <div class="col-md-3">
                                
                                <ul class="app-feature-gallery app-feature-gallery-noshadow margin-bottom-0">
                                    <li>
                                          <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-taxi"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Orders</div>         
                                                        <div class="title pull-right"><span class="label label-success label-bordered">Overall</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['total_orders']; ?></div>                                        
                                                    <div class="line">
                                                        <div class="subtitle"><a href="#">Client request</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>

                                       <!--  <div class="app-widget-tile">
                                            <div class="line">
                                                <div class="title">Total Order</div>
                                                 <div class="title pull-right"><span class="label label-success label-bordered">+14.2%</span></div>
                                            </div>                                        
                                            <div class="intval"><?php // echo $maindata['total_orders']; ?></div>                                        
                                            <div class="line">
                                                <div class="subtitle">Total request counter</div>
                                                <div class="subtitle pull-right text-success"><span class="icon-arrow-up"></span> good</div>
                                            </div>
                                        </div> -->                                                              
                                       
                                    </li>
                                      <li>
                                         <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-users"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">ACTIVE ORDER</div>         
                                                        <div class="title pull-right"><span class="label label-danger label-bordered">OPEN</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['active_request']; ?></div>                                        
                                                   <!-- <div class="line">
                                                        <div class="subtitle"><a href="<?php //echo base_url();?>dashboard/clients">Client list</a></div>
                                                    </div> --> 
                                                </div>
                                            </div>
                                        </div>
                                  </li>
                                <!--     <li>
                                        
                                        <div class="app-widget-tile">
                                            <div class="line">
                                                <div class="title">Sales Per Year</div>
                                                <div class="title pull-right text-success">+32.9%</div>
                                            </div>                                        
                                            <div class="intval">24,834</div>
                                            <div class="line">
                                                <div class="subtitle">Total items sold</div>
                                                <div class="subtitle pull-right text-success"><span class="icon-check"></span> good</div>
                                            </div>
                                        </div>                                                                        
                                       
                                    </li>
                                    <li>
                                        
                                        <div class="app-widget-tile">
                                            <div class="line">
                                                <div class="title">Profit</div>
                                                <div class="title pull-right text-success">+9.2%</div>
                                            </div>                                        
                                            <div class="intval">539,277 <small>usd</small></div>
                                            <div class="line">
                                                <div class="subtitle">Frofit for the year</div>                                                
                                            </div>
                                        </div>                                                                        
                                      
                                    </li>
                                    <li>
                                      
                                        <div class="app-widget-tile">
                                            <div class="line">
                                                <div class="title">Outlay</div>
                                                <div class="title pull-right text-success">-12.7%</div>
                                            </div>                                        
                                            <div class="intval">45,385<small>usd</small></div>
                                            <div class="line">
                                                <div class="subtitle">Statistic per year</div>                                                
                                            </div>
                                        </div>                                                                        
                                        
                                    </li>
 -->                                </ul>
                                
                            </div>
                            <div class="col-md-3">
                                
                                <ul class="app-feature-gallery app-feature-gallery-noshadow margin-bottom-0">
                                    <li>
                                       
                                      <!--   <div class="app-widget-tile app-widget-highlight">
                                            <div class="line">
                                                <div class="title">Customers</div>
                                                <div class="title pull-right"><span class="label label-warning label-bordered">%</span></div>
                                            </div>                                        
                                            <div class="intval"><?php //echo $maindata['total_client']; ?></div>
                                            <div class="line">
                                                <div class="subtitle">customer overall</div>
                                                <div class="subtitle pull-right text-warning"><span class="icon-arrow-down"></span> normal</div>
                                            </div>
                                        </div>
                                         -->
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-users"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Clients</div>         
                                                        <div class="title pull-right"><span class="label label-success label-bordered">Overall</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['total_client']; ?></div>                                        
                                                   <div class="line">
                                                        <div class="subtitle"><a href="<?php echo base_url();?>dashboard/clients">Client list</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                   <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-users"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Clients</div>         
                                                        <div class="title pull-right"><span class="label label-danger label-bordered">Unverified</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['unverified_client']; ?></div>                                        
                                                   <div class="line">
                                                        <div class="subtitle"><a href="<?php echo base_url();?>dashboard/clients">Client list</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li>
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="line">
                                                <div class="title">New</div>
                                                <div class="title pull-right text-success">33.9%</div>
                                            </div>                                        
                                            <div class="intval">38,085</div>
                                            <div class="line">
                                                <div class="subtitle">New visitors per month</div>                                                
                                                <div class="subtitle pull-right text-success"><span class="icon-arrow-up"></span></div>
                                            </div>
                                        </div>
                                        
                                    </li>
                                    <li>
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="line">
                                                <div class="title">Registred</div>
                                                <div class="title pull-right">+458</div>
                                            </div>                                        
                                            <div class="intval">12,554</div>
                                            <div class="line">
                                                <div class="subtitle">Total registred users</div>                                                
                                            </div>
                                        </div>
                                        
                                    </li>  -->
                                </ul>
                                                                
                            </div>
                            <div class="col-md-3">
                                
                                <ul class="app-feature-gallery app-feature-gallery-noshadow margin-bottom-0">
                                    <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-users"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Washer</div>         
                                                        <div class="title pull-right"><span class="label label-success label-bordered">Overall</span></div>
                                                    </div>                                        
                                                 <div class="intval text-left"><?php echo $maindata['total_washer']; ?></div>                                        
                                                   <div class="line">
                                                        <div class="subtitle"><a href="<?php echo base_url();?>dashboard/washers">Washer list</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                                                                
                                    </li>
                                       <li>
                                   <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa-users"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Washer</div>         
                                                        <div class="title pull-right"><span class="label label-danger label-bordered">Unverified</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['unverified_washer']; ?></div>                                        
                                                   <div class="line">
                                                        <div class="subtitle"><a href="<?php echo base_url();?>dashboard/washers">Washer list</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-shield-alert"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Server Notifications</div>                                                        
                                                    </div>                                        
                                                    <div class="intval text-left">14 / 631</div>                                        
                                                    <div class="line">
                                                        <div class="subtitle"><a href="#">Open all notifications</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                                
                                    </li>
                                    <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-envelope"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Inbox Mail</div>                                                        
                                                    </div>                                        
                                                    <div class="intval text-left">2 / 481</div>                                        
                                                    <div class="line">
                                                        <div class="subtitle"><a href="#">Open inbox messages</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                                
                                    </li>
                                    <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-user-plus"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Customers</div>             
                                                        <div class="title pull-right"><span class="label label-danger label-bordered">15 NEW</span></div>
                                                    </div>                                        
                                                    <div class="intval text-left">6,233</div>                                        
                                                    <div class="line">
                                                        <div class="subtitle"><a href="#">Open contact list</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                                                
                                    </li> -->
                                </ul>
                                
                            </div>
                            <div class="col-md-3">
                                
                                <ul class="app-feature-gallery app-feature-gallery-noshadow margin-bottom-0">
                                  <li>
                                         <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-md">
                                                        <span class="fa fa fa-usd"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                       <!--  <div class="title" s>Business Amount</div>   -->       
                                                        <div class="title"><span class="label label-success">BUSINESS VALUE</span></div>
                                                    </div>                                        
                                                <div class="intval text-left"><?php echo $maindata['Total_business_amount']; ?></div>                                        
                                              <div class="line">
                                                        <div class="subtitle"><a href="#">Payment record</a></div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                  </li>
                                  <!--   <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-server"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Total Server Load</div>
                                                        <div class="subtitle pull-right text-success"><span class="fa fa-check"></span> UP</div>
                                                    </div>                                        
                                                    <div class="intval text-left">85.2%</div>                                        
                                                    <div class="line">
                                                        <div class="subtitle">Latest back up: <a href="#">12/07/2016</a></div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                                                                
                                    </li> -->
                                   <!--  <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-database-check"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Database Load</div>
                                                        <div class="subtitle pull-right text-success"><span class="fa fa-check"></span> UP</div>
                                                    </div>                                        
                                                    <div class="intval text-left">43.16%</div>
                                                    <div class="line">
                                                        <div class="subtitle">4/10 databases used</div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                                                                
                                    </li>
                                    <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-hdd-down text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Disk Space</div>
                                                        <div class="subtitle pull-right text-danger"><span class="fa fa-times"></span> Critical</div>
                                                    </div>                                        
                                                    <div class="intval text-left">99.98%</div>
                                                    <div class="line">
                                                        <div class="subtitle">234.2GB / 240GB used</div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                                                                
                                    </li>
                                    <li>                                        
                                       
                                        <div class="app-widget-tile app-widget-highlight">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="icon icon-lg">
                                                        <span class="icon-chip-x64"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">                                                    
                                                    <div class="line">
                                                        <div class="title">Proccessor</div>
                                                        <div class="subtitle pull-right text-success"><span class="fa fa-check"></span> Normal</div>
                                                    </div>                                        
                                                    <div class="intval text-left">32.5%</div>
                                                    <div class="line">
                                                        <div class="subtitle">Intule Cori P7, 3.6Ghz</div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                                                                
                                    </li> -->
                                </ul>
                                
                            </div>
                        </div>
                            
                        <div class="row">
                            <div class="col-md-6">
                                
                                <!-- START PRODUCT SALES HISTORY -->
                                <div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>Number of orders per service type</h2>
                                            <p>Date wise record</p>
                                            	
                                        </div>   
                                       
                                        <div class="heading-elements">
                                       
                                         <input type="text" class="form-control" name="daterange" value="05/01/2018 - 05/30/2018" />
                                        			
                                        </div>
                                    </div>
                                    
                                   <div class="block-content">
                                          <div id="graph_bar_group1" style="width:100%;height:566px"></div>
                                     
                                    </div>
                                </div>
                                <!-- END PRODUCT SALES HISTORY -->
                                
                            </div>
                            <div class="col-md-6">
                                
                                <!-- START LATEST TRANSACTIONS -->
                                <div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>LATEST ORDER</h2>
                                            <p>Quick information</p>
                                        </div>              
                                    <div class="heading-elements">
                                            <a href="<?php echo base_url();?>dashboard/orders" class="btn btn-default btn-icon-fixed"><span class="icon-register"></span> All Requests</a>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <div class="table-responsive">
                                            <table class="table table-clean-paddings margin-bottom-0  table-fit">
                                                <thead>
                                                    <tr>
                                                        <th>Request by</th>
                                                        <th width="150">Order</th>                                                    
                                                        <th width="150">Payment status</th>
                                                        <th width="150">Order status</th>
                                                      <!--   <th width="55"></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php //echo json_encode($latest_transaction_data);
                                                    //echo json_encode($data2);
                                                    if(count($latest_transaction_data)>0)
                                                    {
                                                        for($k=0;$k<count($latest_transaction_data);$k++)
                                                        {
                                                    ?>
                                                    <tr>

                                                        <td >
                                                            <div class="contact contact-rounded contact-bordered contact-lg">
                                                                    <?php 
                                                            $imgExists = FCPATH . "uploadedImages/".$latest_transaction_data[$k]['profile_pic'];
                                                                    $c = "";
                                                                    if(file_exists($imgExists)){
                                                                        $c = 1;
                                                                    }else{
                                                                        $c = 0;
                                                                    }
                                                                    
                                                                    if($c == 0){
                                                                        ?>
                                                                 <img class="" src="<?php echo base_url();?>assets/images/users/user-60.jpg">
                                                                        <?php

                                                                    }else if($latest_transaction_data[$k]['profile_pic'] != ""){

                                                                        ?>
                                                                        <img class="" src="<?php echo base_url();?>uploadedImages/<?php echo $latest_transaction_data[$k]['profile_pic']; ?>">
                                                                        <?php
                                                                    
                                                                    }else{

                                                                        ?>
                                                                    <img class="" src="<?php echo base_url();?>assets/images/users/user-60.jpg">
                                                                        <?php
                                                                    }
                                                                    ?>   
                                                                <div class="contact-container">
                                                                    <a href="#"><?php echo $latest_transaction_data[$k]['name'];?></a>
                                                                    <span>on <?php echo $latest_transaction_data[$k]['req_date'];?></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?php echo 'REQ-'.$latest_transaction_data[$k]['request_id']; ?></td>
                                                        <td>
                                                        <?php if($latest_transaction_data[$k]['payment_status']=="Paid"){ ?>
                                                        <span class="label label-success label-bordered"><?php echo $latest_transaction_data[$k]['payment_status'];?></span>
                                                        <?php } else { ?>
                                                         <span class="label label-danger label-bordered"><?php echo $latest_transaction_data[$k]['payment_status'];?></span>
                                                        <?php } ?>
                                                        </td>
                                                        <td>
                                                       <?php if($latest_transaction_data[$k]['request_status']=="Accept" || $latest_transaction_data[$k]['request_status']=="Washing started" ||  $latest_transaction_data[$k]['request_status']=="washer completed" || $latest_transaction_data[$k]['request_status']=="Payment Done" || $latest_transaction_data[$k]['request_status']=="Client rating done" || $latest_transaction_data[$k]['request_status']=="Washer Rating Given" || $latest_transaction_data[$k]['request_status']=="Open"){ ?>
                                                        <span class="label label-success label-bordered"><?php echo $latest_transaction_data[$k]['request_status'];?></span>
                                                        <?php } else{ ?>
                                                          <span class="label label-danger label-bordered"><?php echo $latest_transaction_data[$k]['request_status'];?></span>
                                                        <?php  } ?>
                                                        </td>
                                                       <!--  <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-default btn-icon btn-clean dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="icon-cog"></span></button>
                                                                <ul class="dropdown-menu dropdown-left">
                                                                    <li><a href="#"><span class="icon-notification-circle text-info"></span> More information</a></li> 
                                                                    <li><a href="#"><span class="icon-arrow-up-circle text-warning"></span> Promote to top</a></li> 
                                                                    <li class="divider"></li>
                                                                    <li><a href="#"><span class="icon-cross-circle text-danger"></span> Delete transactions</a></li> 
                                                                </ul>
                                                            </div>
                                                        </td> -->
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
                                <!-- END LATEST TRANSACTIONS -->
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                             <div class="block block-condensed">
                                <div class="app-heading">                                        
                                <div class="title">
                                    <h2> NUMBER OF ORDER PER DAY</h2>
                                    <p></p>
                                        
                                </div>   
                                <div class="heading-elements">
                                <!--  <input type="text" class="form-control" name="daterange" value="01/01/2018 - 01/15/2018" /> -->
                                </div>
                                </div>
                                <div class="block-content">
                                <div id="area_chart" style="width: 100%"></div>

                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                
                               
                                <!-- div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>Purchase Statistics</h2>
                                            <p>Who purchase products</p>
                                        </div>              
                                        <div class="heading-elements">
                                            <button class="btn btn-default btn-icon-fixed"><span class="icon-refresh"></span> Update</button>
                                        </div>
                                    </div>
                                    
                                    <div class="block-content">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <label>20-25</label><span class="pull-right text-bold">37%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="37%">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100" style="width: 37%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>26-30</label><span class="pull-right text-bold">33%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="33%">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>31-40</label><span class="pull-right text-bold">25%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="25%">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>41-50</label><span class="pull-right text-bold">12%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="15%">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" style="width: 15%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>51+</label><span class="pull-right text-bold">3%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="3%">
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="100" style="width: 3%"></div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">                                            
                                                    <label>Male</label><span class="pull-right text-bold">75%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="75%">
                                                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>Female</label><span class="pull-right text-bold">25%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="25%">
                                                        <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>< $25</label><span class="pull-right text-bold">68%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="68%">
                                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100" style="width: 68%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>> $26</label><span class="pull-right text-bold">22%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="22%">
                                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 22%"></div>
                                                    </div>                                            
                                                </div>
                                                <div class="form-group">                                            
                                                    <label>> $100</label><span class="pull-right text-bold">10%</span>
                                                    <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="10%">
                                                        <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%"></div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            
                                
                            </div>
                            <div class="col-md-4">
                                
                              
                               <!--  <div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>Locations</h2>
                                            <p>Statistics by locations</p>
                                        </div>              
                                        <div class="heading-elements">
                                            <button class="btn btn-default btn-icon-fixed"><span class="icon-refresh"></span> Update</button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        
                                        <div id="dashboard-map" class="app-chart-holder" style="height: 285px;"></div>
                                        
                                    </div>
                                </div> -->
                                
                            </div>
                            <div class="col-md-4">
                                
                               
                                <!--<div class="block block-condensed">
                                    <div class="app-heading">                                        
                                        <div class="title">
                                            <h2>Top 5 Stores</h2>
                                            <p>Best sellers per month</p>
                                        </div>              
                                        <div class="heading-elements">
                                            <button class="btn btn-default btn-icon-fixed"><span class="icon-city"></span>All Stores</button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        
                                        <div class="form-group">                                            
                                            <label>1. Shopnumone</label><span class="pull-right text-bold">135</span>
                                            <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="75%">
                                                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <label>2. Best Shoptwo</label><span class="pull-right text-bold">121</span>
                                            <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="70%">
                                                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%"></div>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <label>3. Third Awesome</label><span class="pull-right text-bold">107</span>
                                            <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="65%">
                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: 65%"></div>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <label>4. Alltranding</label><span class="pull-right text-bold">83</span>
                                            <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="51%">
                                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="51" aria-valuemin="0" aria-valuemax="100" style="width: 51%"></div>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">                                            
                                            <label>5. Shop Name</label><span class="pull-right text-bold">77</span>
                                            <div class="progress progress-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="42%">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%"></div>
                                            </div>                                            
                                        </div>
                                        
                                    </div>
                                </div> -->
                             
                                
                            </div>                            
                        </div>
                        
                    </div>
                    <!-- END PAGE CONTAINER -->
                    
                </div>
                <!-- END APP CONTENT -->
                                
            </div>
            <!-- END APP CONTAINER -->
                        
<?php include'template/footer.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){

		  $('input[name="daterange"]').daterangepicker({
		    opens: 'left'
		  }, function(start, end, label) {
		    //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
		     $.post("<?php echo base_url();?>dashboard/get_histogram_data",{start:start.format('YYYY-MM-DD'),end:end.format('YYYY-MM-DD') },function(data, status){
		        chart.setData(JSON.parse(data));
		      });
		  
          });
		var chart =Morris.Bar({
				element: 'graph_bar_group1',
				xLabelMargin:8,
				data:[{"service_type":"Elite","nor":0},{"service_type":"Premium","nor":0},{"service_type":"Standard","nor":0},{"service_type":"Fast","nor":0}],
				hidehover:false,
				//  hoverCallback: function(index, options, content) 
				//  {
				//     return(options.data[index].b);
				//  },
				xkey: 'service_type',
				ykeys: ['nor'],
				xLabelAngle: 60,
				resize:true,
				gridTextColor:"#000000",
				labels: ['Number of request'],
				barColors: function (row, series, type) {
    				// console.log("--> "+row.label, series, type);
    				if(row.label == "Elite") return "#AD1D28";
    				else if(row.label == "Premium") return "#4180f4";
    				else if(row.label == "Standard") return "#fec04c";
    				else if(row.label == "Fast") return "#42f489";
				}
		});

        Morris.Area({
          element: 'area_chart',
          data:<?php echo $data2; ?>,
          xkey: 'datereq',
          ykeys: ['nor'],
          labels: ['Number of request'],
          fillOpacity: 0.4,
          hideHover: 'auto',
          behaveLikeLine: true,
          resize: true,
          pointFillColors: ['#ffffff'],
          pointStrokeColors: ['grey'],
          lineColors: ['blue'],
          xLabels:'day',
          xLabelAngle: 35,
        });

        $(window).load(()=>{
    console.log('page is loaded');
         $.post("<?php echo base_url();?>dashboard/get_histogram_data",{start:'2018-05-01',end:'2018-05-30' },function(data, status){
                    chart.setData(JSON.parse(data));
                  });
    });
});

    
</script>   