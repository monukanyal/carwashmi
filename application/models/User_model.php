<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	function users(){
		$this->db->order_by("user_id","desc");
		$this->db->select("*");
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
		
	}
	function profile(){
		$this->db->select("*");
		$this->db->from('account');
		$this->db->where('usertype', "admin");
		$query = $this->db->get();
		return $query->result();
		return $arr;
	} 
	function edit($uid){
		$qry = "SELECT * FROM users WHERE user_id = '".$uid."' AND user_type != 'admin'";
		$sql = $this->db->query($qry);
		$row = $sql->row_array();
		if(count($row) > 0){
			return $row;
		}else{
			return '0';
		}
	} 
	
	function updateuser($data,$id){
		// print_r($data);
		$this->db->where('user_id', $id);
		$true = $this->db->update('users', $data); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 
	function deleteusr($id){ 
		$res = $this->db->delete('users', array('user_id' => $id)); 
		if($res){
			return true;
		}else{
			return false;
		}
	} 
	
	function updatefirstloginstatus($id){
		// print_r($data);
		$this->db->where('user_id', $id);
		$true = $this->db->update('users', array('firstlogin' => 1)); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 
	
	// userverify
	
	function userverify($id){
		// print_r($data);
		$this->db->where('user_id', $id);
		$true = $this->db->update('users', array('verify_by_admin' => 1)); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 

	//@mk
	function get_client_email_template(){
				$this->db->select('*');
			$this->db->where('type','client');
			$query = $this->db->get('email_templates');
			return $query->result_array();
	}

	function get_washer_email_template(){
			
			$this->db->select('*');
			$this->db->where('type','washer');
			$query = $this->db->get('email_templates');
			return $query->result_array();
	}

	function get_customers()
	{
			$this->db->select('*');
			$this->db->where('user_type',0);
			$query = $this->db->get('users');
			return $query->result_array();
	}

	function get_washers()
	{
			$this->db->select('*');
			$this->db->where('user_type',1);
			$query = $this->db->get('users');
			return $query->result_array();
	}
	function all_count_info()
	{
		$data['total_orders']=$this->get_total_orders();
		$data['total_washer']=$this->get_total_washer();
		$data['total_client']=$this->get_total_client();
		$data['unverified_client']=$this->get_unverified_client();
		$data['unverified_washer']=$this->get_unverified_washer();
		$data['active_request']=$this->get_active_request();
		$data['Total_business_amount']=$this->get_business_amount();
		return $data;
	}
	function get_total_orders()
	{
		$this->db->select('*');
		$query = $this->db->get('client_request');
		return $query->num_rows();
	}
	function get_total_washer()
	{
		$this->db->select('*');
		$this->db->where('user_type',1);
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	function get_total_client()
	{
		$this->db->select('*');
		$this->db->where('user_type',0);
		$query = $this->db->get('users');
		return $query->num_rows();
	}
	function get_unverified_client()
	{

		$this->db->select('*');
		$this->db->where('user_type',0);
		$this->db->where('is_email_verified',0);
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	function get_unverified_washer()
	{
		
		$this->db->select('*');
		$this->db->where('user_type',1);
		$this->db->where('verify_by_admin',0);
		$query = $this->db->get('users');
		return $query->num_rows();
	}

	function get_active_request()
	{
		$this->db->select('*');
		$this->db->where('is_job_completed',0);
		$this->db->where('is_request_open',0);  //open
		$query = $this->db->get('client_request');
		return $query->num_rows();
	}

	function get_business_amount()
	{
		$this->db->select('*');
		$this->db->where('payment_status',1);
		$query = $this->db->get('service_payment');
		if($query->num_rows()>0)
		{	$total=0;
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{
					$amount=$a[$i]['amount'];
					$total=$total+$amount;
			}
			return $total; 
		}
		else{
			return 0;
		}
	}

	function get_histogram_data($start,$end)
	{
		$this->db->select('*');
		$this->db->where('request_date>=',$start);
		$this->db->where('request_date<=',$end);
		$query = $this->db->get('client_request');
		if($query->num_rows()>0)
		{	
			$nor1=0;
			$nor2=0;
		    $nor3=0;
		    $nor4=0;
		    $x=array();
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{		
					if($a[$i]['service_type']==0)
					{
						$nor1=$nor1+1;
					}
					else if($a[$i]['service_type']==1)
					{
						$nor2=$nor2+1;
					}
					else if($a[$i]['service_type']==2)
					{
						$nor3=$nor3+1;
					}
					else if($a[$i]['service_type']==3)
					{	
						$nor4=$nor4+1;
					}
			}
			$service=array('Elite','Premium','Standard','Fast');
			for($k=0;$k<4;$k++)
			{	if($k==0)
				{
				
				 $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor1);
				}
				else if($k==1){
					
					  $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor2);
				}
				else if($k==2)
				{
					 
					  $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor3);
				}
				else
				{
					 $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor4);
				}
			  
			}
			return $newres;
			
		}
		else
		{
			//no data
			$nor1=0;
			$nor2=0;
		    $nor3=0;
		    $nor4=0;
			$service=array('Elite','Premium','Standard','Fast');
			for($k=0;$k<4;$k++)
			{	if($k==0)
				{
				
				 $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor1);
				}
				else if($k==1){
					
					  $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor2);
				}
				else if($k==2)
				{
					 
					  $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor3);
				}
				else
				{
					 $newres[]=array('service_type'=>"$service[$k]",'nor'=>$nor4);
				}
			  
			}
			return $newres;
			return '';
		}
	}

	function get_all_request()
	{
		
		$this->db->select('*');
		$this->db->order_by('client_request_id', 'DESC');
		$query = $this->db->get('client_request');
		if($query->num_rows()>0)
		{	
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{	
					$req_status='';
					$customer_id=$a[$i]['user_id'];
					$req_date=date('M d,Y',strtotime($a[$i]['request_date']));
					$this->db->select('*');
					$this->db->where('user_id',$customer_id);
					$query2 = $this->db->get('users');
					$res2=$query2->result_array();

					$name=$res2[0]['first_name'].' '.$res2[0]['last_name'];
					$profile_pic=$res2[0]['profile_pic'];
					if($a[$i]['is_payment_done']==1)
					{
						$status='Paid';
					}
					else
					{
						$status='Pending';
					}
					$req_status=$this->request_status_meaning($a[$i]['is_request_open']);	
              	 $newres[]=array('name'=>$name, 'profile_pic'=>$profile_pic,'payment_status'=>$status,'request_status'=>$req_status,'request_id'=>$a[$i]['client_request_id'],'req_date'=>$req_date);	
			}
			return $newres;
		}
		else
		{
			$newres=array();
			return $newres;
		}
	}

	function get_latest_transaction()
	{
		
		$this->db->select('*');
		$this->db->order_by('client_request_id', 'DESC');
		$query = $this->db->get('client_request',5);
		if($query->num_rows()>0)
		{	
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{	
					$req_status='';
					$customer_id=$a[$i]['user_id'];
					$req_date=date('M d,Y',strtotime($a[$i]['request_date']));
					$this->db->select('*');
					$this->db->where('user_id',$customer_id);
					$query2 = $this->db->get('users');
					$res2=$query2->result_array();

					$name=$res2[0]['first_name'].' '.$res2[0]['last_name'];
					$profile_pic=$res2[0]['profile_pic'];
					if($a[$i]['is_payment_done']==1)
					{
						$status='Paid';
					}
					else
					{
						$status='Pending';
					}
					$req_status=$this->request_status_meaning($a[$i]['is_request_open']);	
               $newres[]=array('name'=>$name, 'profile_pic'=>$profile_pic,'payment_status'=>$status,'request_status'=>$req_status,'request_id'=>$a[$i]['client_request_id'],'req_date'=>$req_date);	
			}
			return $newres;
		}
		else
		{
			$newres=array();
			return $newres;
		}
	}

	function request_status_meaning($is_request_open)
	{
		
		switch ($is_request_open) {
			    case  0:
			        return "Open";
			        break;
			    case 1:
			        return "Accept";
			        break;
			  	case 2:
			        return "Rejected";
			        break;

			        case 3:
			        return "Cancel By Client";
			        break;

			        case 4:
			        return "Cancel by washer";
			        break;

			        case 5:
			        return "Washing started";
			        break;

			        case 6:
			        return "washer completed";
			        break;

			        case 7:
			        return "Payment Done";
			        break;

			        case 8:
			        return "Client rating done";
			        break;

			        case 9:
			        return "Washer Rating Given";
			        break;

			    default:
			        return "Client Cancelation Charges";
			}
	}
	function get_request_last7day()
	{	
		$start='2017-10-10';
		$end=date('Y-m-d');
		$query=$this->db->query("SELECT DISTINCT DATE_FORMAT(`request_date`, '%Y-%m-%d') as dt FROM client_request where `request_date`>='$start' and `request_date`<='$end'");
		if($query->num_rows()>0)
		{	
			
		    $x=array();
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{		
					$getdate=$a[$i]['dt'];
					$this->db->select('*');
					$this->db->like('request_date',"$getdate",'after'); 
					$query2 = $this->db->get('client_request');
					 $newres[]=array('datereq'=>"$getdate",'nor'=>$query2->num_rows());
					
			}
			return $newres;
			
		}
		else
		{
			return array();
		}
	}

	function count_all()
	 {
		 $this->db->select('*');
		$this->db->order_by('client_request_id', 'DESC');
		$query = $this->db->get('client_request');
		if($query->num_rows()>0)
		{	
			$a=$query->result_array();
			for($i=0;$i<count($a);$i++)
			{	
					$req_status='';
					$customer_id=$a[$i]['user_id'];
					$req_date=date('M d,Y',strtotime($a[$i]['request_date']));
					$this->db->select('*');
					$this->db->where('user_id',$customer_id);
					$query2 = $this->db->get('users');
					$res2=$query2->result_array();
					if($res2)
					{
					$name=$res2[0]['first_name'].' '.$res2[0]['last_name'];
					$profile_pic=$res2[0]['profile_pic'];
					}
					else
					{
						$name='';
						$profile_pic='';		
					}	
					if($a[$i]['is_payment_done']==1)
					{
						$status='Paid';
					}
					else
					{
						$status='Pending';
					}
					$req_status=$this->request_status_meaning($a[$i]['is_request_open']);	
               $newres[]=array('name'=>$name, 'profile_pic'=>$profile_pic,'payment_status'=>$status,'request_status'=>$req_status,'request_id'=>$a[$i]['client_request_id'],'req_date'=>$req_date);	
			}
			return count($newres);
		}
		else
		{
			$newres=array();
			return 0;
		}
	 }

	 function fetch_details($limit, $start)
	 {

	 	 $this->db->select('*');
		$this->db->order_by('client_request_id', 'DESC');
		 $this->db->limit($limit, $start);
		$query = $this->db->get('client_request');
		if($query->num_rows()>0)
		{	
			$a=$query->result_array();
			  $output = '';
			  $output .= '
			  <table class="table table-bordered table-condensed" style="font-size:small;">
			   <tr>
			    <th>Order id</th>
			    <th>Request by</th>
			    <th>Accepted by</th>
			    <th>Promotion Applicable</th>
			    <th>Payment Status</th>
			    <th>Order Status</th>
			    <th>Action</th>
			   </tr>
			  ';
			for($i=0;$i<count($a);$i++)
			{	
					$req_status='';
					$customer_id=$a[$i]['user_id'];
					$request_date=$a[$i]['request_date'];

					$promotiondata=$this->available_promotion_list($request_date);
					if($promotiondata!='')
					{
						$offer=$promotiondata[0]['offer'].' discount applied';
					}
					else
					{
						$offer='No offer available';
					}
					$this->db->select('*');
					$this->db->where('client_request_id', $a[$i]['client_request_id']);
					$this->db->where('is_washer_accepted',1);
					$this->db->limit(1);
					$query3 = $this->db->get('washer_response');
                     if($query3->num_rows()==1)
                     {
                     	$res3=$query3->result_array();
                     	$washer_id=$res3[0]['user_id']; //waher id
	                     $this->db->select('*');
						$this->db->where('user_id',$washer_id);
						$query4 = $this->db->get('users');
						$res4=$query4->result_array();

						$washername=$res4[0]['first_name'].' '.$res4[0]['last_name'];
                     }
                     else
                     {
                     	$washername='';
                     }
					$req_date=date('M d,Y h:i a',strtotime($a[$i]['request_date']));
					$this->db->select('*');
					$this->db->where('user_id',$customer_id);
					$query2 = $this->db->get('users');
					$res2=$query2->result_array();
					if($res2)
					{
						$name=$res2[0]['first_name'].' '.$res2[0]['last_name'];
						$profile_pic=$res2[0]['profile_pic'];
					}
					else
					{
						$name='';
						$profile_pic='';
					}
					if($a[$i]['is_payment_done']==1)
					{
						$status='Paid';
					}
					else
					{
						$status='Pending';
					}
					$req_status=$this->request_status_meaning($a[$i]['is_request_open']);	
            	   		/* image url*/
	            		$imgExists = FCPATH . "uploadedImages/".$profile_pic;
	                    $c = "";
	                    if(file_exists($imgExists)){
	                        $c = 1;
	                    }else{
	                        $c = 0;
	                    }
	                    
	                    if($c == 0){
	                    	$url=base_url().'assets/images/users/user-60.jpg'; 
	                      

	                    }else if($profile_pic != ""){
	                    	$url= base_url().'uploadedImages/'.$profile_pic; 
	                        
	                    
	                    }else{
	                    		$url= base_url().'assets/images/users/user-60.jpg'; 
	                      
	                    }       
	                    /* payment status*/

	                    if($status=="Paid"){
	                    	$newstatus='<span class="label label-success label-bordered">'.$status.'</span>';
	                    }
	                    else
	                    {
	                    		$newstatus='<span class="label label-danger label-bordered">'.$status.'</span>';
	                    }         

	                     if($req_status=="Accept" || $req_status=="Washing started" ||  $req_status=="washer completed" || $req_status=="Payment Done" || $req_status=="Client rating done" || $req_status=="Washer Rating Given" || $req_status=="Open"){
	                     	$newreqstatus='<span class="label label-success label-bordered">'.$req_status.'</span>';

	                     	}
	                     	else
	                     	{
	                     		$newreqstatus='<span class="label label-danger label-bordered">'.$req_status.'</span>';
	                     	}                                                                         
			               $output .= '
						   <tr>
						    <td>'.$a[$i]['client_request_id'].'</td>
						    <td><div class="contact contact-rounded contact-lg"><img src="'.$url.'" style="height:100%"><div class="contact-container"><a href="#">'.$name.'</a><span>on '.$req_date.'</span></div></div></td>
						    <td>'.$washername.'</td>
						    <td>'.$offer.'</td>
						    <td>'.$newstatus.'</td>
						    <td>'.$newreqstatus.'</td>
						    <td><a href="'.base_url().'dashboard/more_info/'.$a[$i]['client_request_id'].'">More details</a></td>
						   </tr>';

			}

			 $output .= '</table>';
		 	 return $output;
		}
		else
		{
			
			return '';
		}
	 }

	 function available_promotion_list($request_date)
	{
		$qry = "SELECT * FROM  promotions WHERE ((promotion_from <= '".$request_date."') AND (promotion_to >= '".$request_date."') OR (DATE(promotion_date) = '".date('Y-m-d',strtotime($request_date))."'))";
		$query = $this->db->query($qry);
		$row = $query->result_array();
		if(count($row)>0)
		{
			$mainobj=array();
			for($k=0;$k<count($row);$k++)
			{	
				$mainobj[$k]=$row[$k];
				$offer=$row[$k]['offer'];
				$offer_in=substr("$offer", -1);
				$mainobj[$k]['offer_in']=$offer_in;
				$mainobj[$k]['offer_price']=rtrim($offer,"$offer_in ");
			}
			return $mainobj;
		}
		else
		{
			return '';
		}
	}

	 function store_promotion_info1($data)
	 {
	 	$this->db->select('*');
		$this->db->where('promotion_from',$data['promotion_from']);
		$this->db->where('promotion_to',$data['promotion_to']);
		$query=$this->db->get('promotions');
	 	if($query->num_rows()==0)
	 	{
		 	if($this->db->insert('promotions', $data))
		 	{
		 		return true;
		 	}
	 	}
	 	else
	 	{
	 		return false;
	 	}
	 }

	  function store_promotion_info2($data)
	 {
	 	$this->db->select('*');
		$this->db->where('promotion_date',$data['promotion_date']);
		$query=$this->db->get('promotions');
	 	if($query->num_rows()==0)
	 	{
		 	if($this->db->insert('promotions', $data))
		 	{
		 		return true;
		 	}
	 	}
	 	else
	 	{
	 		return false;
	 	}
	 }


	 function update_promotion_info($a,$pid)
	 {
	 	$this->db->where('pid', $pid);
		if($this->db->update('promotions', $a))
		{
			return true;
		}
		else
		{
			return false;
		}
	 }

	 function get_promotions()
	 {
	 	$this->db->select('*');
		$query=$this->db->get('promotions');
	 	if($query->num_rows()>0)
	 	{
	 		$res=$query->result_array();
		 	for($k=0;$k<count($res);$k++)
		 	{
		 		$id=$res[$k]['pid'];
		 		$title=$res[$k]['promotion_title'];
		 		$des=$res[$k]['description'];
		 		$isday=$res[$k]['promotion_day'];
		 		$updatedon=$res[$k]['updated_on'];
		 		$createdon=$res[$k]['created_on'];
		 		$offer=$res[$k]['offer'];
		 		if($isday==1)
		 		{
		 			$fromdate=$res[$k]['promotion_date'];
		 		$calender[]="{ id: $id,title2: '$title',title: '$title (ALL DAY)',className:'event',color: '#2a3f54',offer:'$offer discount', time:'All day',start: '$fromdate'}";
		 		}
		 		else
		 		{
		 			$from=$res[$k]['promotion_from'];
		 			$starttime=date("h:i a",strtotime($from));
		 			

					$from = str_replace(' ', '', $from);
					$fr=substr_replace("$from",'T',10,0);
		 			
		 			$to=$res[$k]['promotion_to'];

					$to = str_replace(' ', '', $to);
					$todate=substr_replace("$to",'T',10,0);
					$endtime=date("h:i a",strtotime($to));
					$finaltime='('.$starttime.'-'.$endtime.')';
		 			$calender[]="{ id: $id,title2: '$title',title: '$title $finaltime',className:'event',color: '#2a3f54',offer:'$offer discount', time:'All day',start: '$fr',end:'$todate', starttime:'$starttime', endtime:'$endtime'}";
		 		}
		 	}

		 	 $calenderjs=implode(", ",$calender);
		 	 $calenderdata="[ ".$calenderjs." ]"; 
		 	 return $calenderdata;
	 	}
	 	else
	 	{
	 		$calender[]="{ id:0,title2: 'test',className:'event',color: '#2a3f54',offer:'No discount', time:'All day',start: '2014-10-10'}";
	 		 $calenderjs=implode(", ",$calender);
		 	 $calenderdata="[ ".$calenderjs." ]"; 
		 	 return $calenderdata;
	 	}	
	 }

	 function get_promotion_data_byid($pid)
	 {
	 	$this->db->select('*');
	 	$this->db->where('pid',$pid);
		$query=$this->db->get('promotions');
	 	if($query->num_rows()==1)
	 	{
	 		$res=$query->result_array();
	 		return $res;
	 	}
	 	else
	 	{
	 		return array();
	 	}
	 
	 }
   function delete_promotion_now($pid)
   {
   	  	$this->db->where('pid', $pid);
		if($this->db->delete('promotions'))
		{
			return 'success';
		}
		else
		{
			return 'error';
		}
   }

   function get_payment_details($client_request_id)
   {
   		$mainobj=array();
   		$this->db->select('*');
   		$this->db->where('client_request_id',$client_request_id);
   		$query=$this->db->get('client_request');
   		if($query->num_rows()==1)
   		{	
   			
   			$mainobj['client_request_id']=$client_request_id;
   				$res=$query->result_array();
   				$customer_id=$res[0]['user_id'];
   				$mainobj['vehicle_name']=$res[0]['vehicle_name'];
   				$mainobj['vehicle_make']=$res[0]['vehicle_make'];
   				$mainobj['vehicle_model']=$res[0]['vehicle_model'];
   				$mainobj['vehicle_model_year']=$res[0]['vehicle_model_year'];
   				$mainobj['vehicle_color']=$res[0]['vehicle_color'];
   				$mainobj['request_date']=$res[0]['request_date'];
   				$this->db->select('*');
   				$this->db->where('user_id',$customer_id);
   				$query2=$this->db->get('users');
   				if($query2->num_rows()==1)
   				{
   					$userinfo=$query2->result_array();
   					$mainobj['customer_name']=$userinfo[0]['first_name'].' '.$userinfo[0]['last_name'];
   									
   				}
   					$this->db->select('*');
					$this->db->where('client_request_id', $client_request_id);
					$this->db->where('is_washer_accepted',1);
					$this->db->limit(1);
					$query3 = $this->db->get('washer_response');
                     if($query3->num_rows()==1)
                     {
                     	$res3=$query3->result_array();
                     	$washer_id=$res3[0]['user_id']; //waher id
	                     $this->db->select('*');
						$this->db->where('user_id',$washer_id);
						$query4 = $this->db->get('users');
						$res4=$query4->result_array();

						$mainobj['washername']=$res4[0]['first_name'].' '.$res4[0]['last_name'];
                     }
                     else
                     {
                     	$mainobj['washername']='';	
                     }
                     
   				$this->db->select('*');
   				$this->db->where('client_request_id',$client_request_id);
   				$query5=$this->db->get('service_payment');
   				if($query5->num_rows()==1)
   				{
   					$mainobj['is_trans_available']=true;
   					$payapi=$query5->result_array();
   					$mainobj['transaction_id']=$payapi[0]['transaction_id'];
   					$mainobj['amount']=$payapi[0]['amount'];
   					$mainobj['payment_status']=$payapi[0]['payment_status'];
   					$mainobj['payment_type']=$payapi[0]['payment_type'];
   					$mainobj['is_washer_paid']=$payapi[0]['is_washer_paid'];
   					$mainobj['washer_payment_status']=$payapi[0]['washer_payment_status'];
   					$mainobj['transaction_date']=$payapi[0]['transaction_date'];
   					$mainobj['washer_received_amount']=$payapi[0]['washer_received_amount'];
   				}
   				else
   				{
   					$mainobj['is_trans_available']=false;
   					$mainobj['transaction_id']='';
   					$mainobj['amount']='';
   					$mainobj['payment_status']='';
   					$mainobj['payment_type']='';
   					$mainobj['is_washer_paid']='';
   					$mainobj['washer_payment_status']='';
   					$mainobj['transaction_date']='';
   					$mainobj['washer_received_amount']='';
   				}
   				return $mainobj;
   		}
   		else
   		{
   			return '';
   		}
   		
   }

}
?>