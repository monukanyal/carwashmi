<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define ( "ERR_FAILURE",             -1 );
define ( "ERR_INVALID_EXPIRATION",  -2 );
define ( "ERR_INVALID_LENGTH",      -3 );
define ( "ERR_INVALID_MOD10",       -4 );
define ( "ERR_INVALID_PREFIX",      -5 );
define ( "ERR_NOT_NUMERIC",         -6 );
define ( "ERR_UNKNOWN",             -7 );

//Success Codes
define ( "CC_SUCCESS",  1 );
class Api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }
	
	function register($data){ 
		$this->db->insert('users', $data);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$uid = $this->db->insert_id();		
			return $uid;
		}else{
			return FALSE;
		}
    }
	
	function getuser($key)
	{
		$this->db->where('email',$key);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0){
			return true;
		}
	 
	}
	
	function getuserbyid($uid)
	{
		$this->db->where('user_id',$uid);
		$query = $this->db->get('users');
		if ($query->num_rows() > 0){
			return true;
		}
	 
	}
	
	function checkUsertype($uid)
	{
		$this->db->where('user_id',$uid);
		$query = $this->db->get('users');
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
	 
	}
	
	function getuserbyidfrauthorized($uid)
	{
		$this->db->where('user_id',$uid);
		$query = $this->db->get('authorized_data');
		if ($query->num_rows() > 0){
			return true;
		}
	 
	}

	function getuserbyidcard($uid)
	{
		$this->db->where('user_id',$uid);
		$query = $this->db->get('payment_settigns');
		if ($query->num_rows() > 0){
			return true;
		}
	 
	}
	
    function login($data)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email',$data['email']);
		$this->db->where('password',md5($data['password']));
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$userdata =  $query->result_array();
			
			if($userdata[0]['email'] == $data['email'] && $userdata[0]['password'] == md5($data['password'])){
				return $userdata[0];
			}else{
				return '0';
			}
			
		} else {
			return false;
		}
	}
	
	function email_verify($email)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email',$email);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			$userdata =  $query->result_array();
			return $userdata[0];
		} else {
			return false;
		}
	}
	
	function getusername($id){
		$this->db->select('*');
		$this->db->where('user_id', $id);  
		$query = $this->db->get('users');
		$arr = $query->result();
		$user = strstr($arr[0]->email, '@', true);	
		return $user;	
	}
	
	function getfirstnamelastname($id){
		$this->db->select('*');
		$this->db->where('user_id', $id);  
		$query = $this->db->get('users');
		$arr = $query->result();
		$username = $arr[0]->first_name . " " . $arr[0]->last_name;	
		return $username;	
	}
	
	function getuemail($id){
		$this->db->select('*');
		$this->db->where('user_id', $id);  
		$query = $this->db->get('users');
		$arr = $query->result();
		return $arr[0]->email;		
	}
	
	function updatetokan($random, $uid){
		$qry = "update users set tokan = '".$random."' where user_id = '".$uid."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
		die;
	}
	
	function checktokan($random, $uid){
		$qry = "update users set is_email_verified = 1 where user_id = '".$uid."' and tokan = '".$random."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
	}
	
	function update_password($data, $em){
		$this->db->trans_start();
		$this->db->set('password', $data);
		$this->db->where('email', $em);
		$this->db->update('users'); 
		$this->db->trans_complete();

       if ($this->db->trans_status() === FALSE){
			 return false;
        }else{ return true; }
	}
	
	function update_firstlogin_status($email){
		$qry = "";
		$this->db->select('*');
		$this->db->where('email', $email);  
		$query = $this->db->get('users');
		$arr = $query->result();
		$firstlogin = $arr[0]->firstlogin;
		if($firstlogin == 1){
			$data = array(
				'firstlogin' => 0
			);
			$this->db->trans_start();
			$this->db->where('email', $email);
			$this->db->update('users', $data); 
			 $this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				return $this->db->_error_message();
			}else{ 
				return '1';
			}
		}else{
			return false;
		}
		die;
	}
	
	function update_forgot_firstlogin_status($email){
		$this->db->select('*');
		$this->db->where('email', $email);  
		$query = $this->db->get('users');
		$arr = $query->result();
		$firstlogin = $arr[0]->firstlogin;
		
		if($firstlogin == 0){
			$data = array(
				'firstlogin' => 1
			);
			$this->db->trans_start();
			$this->db->where('email', $email);
			$this->db->update('users', $data); 
			 $this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				return $this->db->_error_message();
			}else{ 
				return '1';
			}
		}else{
			return false;
		}
		die;
	}
	
	function checkOldpassword($em){
		$this->db->select('*');
		$this->db->where('email', $em);  
		$query = $this->db->get('users');
		$arr = $query->result();
		return $arr[0]->password;
	}
	
	function forgotpassStatus($status, $email){
		$qry = "update users set forgot_status = '".$status."' where email = '".$email."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
	}
	
	function updateTempPass($hash,$mail){
		$qry = "update users set password = '".md5($hash)."' where email = '".$mail."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
	}
	
	function getprofile($uerid)
	{
		$qry = "SELECT u.* FROM users as u WHERE u.user_id = ".$uerid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
	}
	
	function updateuser($data, $id){
        $this->db->trans_start();
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);	
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ return true;}
	}
	
	function update_user_location($data, $email){
        $this->db->trans_start();
        $this->db->where('email', $email);
        $this->db->update('users', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			echo $this->db->_error_message();
        }else{ 
			echo '1';
		}
	}
	
	function update_location($data, $uid){
        $this->db->trans_start();
        $this->db->where('user_id', $uid);
        $this->db->update('users', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			echo $this->db->_error_message();
        }else{ 
			echo '1';
		}
	}
	
	function getAllwashers(){
		$qry = "SELECT u.* FROM users as u WHERE u.user_type = 1";
		$query = $this->db->query($qry);
		$arr = $query->result();
		return $arr;
	}

	function checkprofileimage($user_id){
		$this->db->select('*');
		$this->db->where('user_id', $user_id);  
		$query = $this->db->get('users');
		$arr = $query->result();
		if(count($arr) > 0){
			
			if(empty($arr[0]->profile_pic))
			{
				return 'user-60.jpg';
			}
			else
			{
				return $arr[0]->profile_pic;
			}
		}else{
			return false;
		}
	}
	
	function update_profile_img($pic)
	{
		
		$this->db->where('user_id', $pic['user_id']);
		$this->db->update('users', $pic);  
		return true;
					
        }
	
	function request($requestData,$uid,$pointsu){
		$this->db->insert('client_request', $requestData);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$reuestid = $this->db->insert_id();	
			// $qry = "SELECT * FROM users WHERE user_id = ".$uid; 
			// $query = $this->db->query($qry);
			// $row = $query->result(); 
			// $points = $row[0]->points;
			// $diductpoints = $points - $pointsu;
			// $uq = "UPDATE users SET points = '".$diductpoints."' WHERE user_id = '".$uid."'";
			// $this->db->query($uq);
						
			return $reuestid;
		}else{
			return FALSE;
		}
	}
	
	function add_response($responseData){
		$this->db->insert('washer_response', $responseData);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$uid = $this->db->insert_id();		
			return $uid;
		}else{
			return FALSE;
		}
	}
	
	function checkrequest($uid){
		$qry = "SELECT * FROM client_request WHERE user_id = ".$uid;
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}
	}
	
	function checkwasher($uid){
		$qry = "SELECT * FROM washer_response WHERE user_id = ".$uid;
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}
	}
	
	function checkwasherid($wid){
		$qry = "SELECT * FROM washer_response WHERE washer_response_id = ".$wid;
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}
	}
	
	function getresponse(){
		$qry = "SELECT cr.*, wr.* FROM client_request as cr, washer_response as wr WHERE wr.client_request_id = cr.client_request_id";
		$query = $this->db->query($qry);
		$arr = $query->result();
		return $arr;
	}
	
	function getwashcount($washerid){
		/*$qry1 = "SELECT * FROM users WHERE user_id = $washerid";
		$query1 = $this->db->query($qry1);
		$res = $query1->result();
		if(count($res) > 0){
			$rider_type= $res[0]->rider_type;
		*/

		//$qry = "select *, (select count(*) from client_request where is_job_completed = 1) as totalwash, (select count(*) from users where rider_type = 0) as bikewash, (select count(*) from users where rider_type = 1) as carwash from washer_response as w inner join client_request as o on o.client_request_id = w.client_request_id inner join users as u where w.user_id = '".$washerid."' and w.is_washer_accepted=1"; 
		$qry = "SELECT c.*,w.* FROM client_request c INNER JOIN washer_response w ON c.client_request_id = w.client_request_id WHERE c.is_job_completed = 1 and w.user_id=$washerid AND w.is_washer_accepted=1"; 
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row;
		}else{
			return false;
		}
	/*}
	else
	{
		return true;
	}*/
}
	
	function validatecard($number){
		global $type;
		$cardtype = array(
			"visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
			"mastercard" => "/^5[1-5][0-9]{14}$/",
			"amex"       => "/^3[47][0-9]{13}$/",
			"discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
		);

		if (preg_match($cardtype['visa'],$number)){
			$type= "visa";
			return 'visa';
		}else if (preg_match($cardtype['mastercard'],$number)){
			$type= "mastercard";
			return 'mastercard';
		}else if (preg_match($cardtype['amex'],$number)){
			$type= "amex";
			return 'amex';
		}else if (preg_match($cardtype['discover'],$number)){
			$type= "discover";
			return 'discover';
		}else{
			return 'unknown';
		} 
	}
	
	function is_valid_expiration ( $month, $year ){
		
		if ( ( !is_numeric ( $month ) ) || ( !is_numeric ( $year ) ) ){
			return ERR_INVALID_EXPIRATION;
		}

		
		if ( strlen ( $year ) == 4 ){
			$current_year = (integer) date ( 'Y' );
		}elseif ( strlen ( $year ) == 2 ){
			$current_year = (integer) date ( 'y' );
		}else{
			return ERR_INVALID_EXPIRATION;
		}

	
		$current_month = (integer) date ( 'm' );

		
		if ( ( $month < 1 ) || ( $month > 12 ) ){
			return ERR_INVALID_EXPIRATION;
		}

		
		if ( ( $year < $current_year ) || ( $year > ( $current_year + 10 ) ) ){
			return ERR_INVALID_EXPIRATION;
		}

	
		if ( ( $year == $current_year ) && ( $month < $current_month ) ){
			return ERR_INVALID_EXPIRATION;
		}

	
		return CC_SUCCESS;
	}
	
	function getwasherNotification($user_id){
		$data = $this->checkwasher($user_id);
		if(count($data)>0){	
			$qry = "SELECT cr.*, wr.* FROM client_request as cr, washer_response as wr WHERE cr.client_request_id = wr.client_request_id AND wr.user_id = '".$user_id."' AND cr.is_request_open = 0 AND wr.is_washer_accepted = 0 ORDER BY cr.client_request_id DESC"; 
			$query = $this->db->query($qry);
			$row = $query->result();
			return $row;
		}else{
			return false;
		}
	}
	
	function washerhistory($user_id){
		$data = $this->checkwasher($user_id);
		if(count($data)>0){	
			$qry = "SELECT cr.*, wr.* FROM client_request as cr, washer_response as wr WHERE cr.client_request_id = wr.client_request_id AND wr.user_id = '".$user_id."' ORDER BY cr.client_request_id DESC"; 
			$query = $this->db->query($qry);
			$row = $query->result();
			return $row;
		}else{
			return false;
		}
	}
	
	function checkresponse($request_id){
		$qry = "SELECT cr.* FROM client_request as cr WHERE cr.client_request_id = '".$request_id."' AND cr.is_request_open = 0";  
		$query = $this->db->query($qry);
		$row = $query->result();
		return $row;
	}
	
	function updateWresponse1($wid,$washerid, $parm){
		$data = array(
			'is_washer_accepted' => $parm
		);
		$this->db->trans_start();
        $this->db->where('washer_response_id', $wid);
		$this->db->update('washer_response', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 

        	$qry = "SELECT * FROM location_history WHERE user_id=$washerid"; 
			$query = $this->db->query($qry);
			$row = $query->result_array();
			if(count($row)>0)
			{
				return array('washer_id'=>$row[0]['user_id'],'longitude'=>$row[0]['longitude'],'latitude'=>$row[0]['latitude']);
			}
			else
			{
				return array();
			}
			//return true;
		}
	}
		function updateWresponse($wid, $parm){
		$data = array(
			'is_washer_accepted' => $parm
		);
		$this->db->trans_start();
        $this->db->where('washer_response_id', $wid);
		$this->db->update('washer_response', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
        	
			return true;
		}
	}
	
	function updatePaymentResponse($rid, $status){
		$data = array(
			'is_payment_done' => $status
		);
		$this->db->trans_start();
        $this->db->where('client_request_id', $rid);
		$this->db->update('client_request', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
			return true;
		}
	}
	
	function updateuser_paymentstatus($uid, $status){
		$data = array(
			'user_status' => $status,
			'is_cancellation_charge'=>'false'
		);
		$this->db->trans_start();
        $this->db->where('user_id', $uid);
		$this->db->update('users', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
			return true;
		}
	}
	
	function requestClose($reuestid, $parm){
		$data = array(
			'is_request_open' => $parm
		);
		$this->db->trans_start();
        $this->db->where('client_request_id', $reuestid);
		$this->db->update('client_request', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
			return true;
		}
	}
	
	function allrequestclose($reuestid, $uid){
		$data = array(
			'is_washer_accepted' => 3
		);
		$this->db->trans_start();
        $this->db->where('client_request_id', $reuestid);
        $this->db->where('user_id != ', $uid); 
		$this->db->update('washer_response', $data); 
		$this->db->trans_complete();
        if($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
			return true;
		}
	}
	
	function getclientrequest($request_id){
		$qry = "SELECT u.*, cr.* FROM users as u, client_request as cr WHERE cr.client_request_id = '".$request_id."' AND cr.user_id = u.user_id"; 
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}else{
			return false;
		}
	}
	
	function getallrequests($uid){
		$qry = "SELECT * FROM client_request WHERE user_id = ".$uid." ORDER BY client_request_id DESC";
		$query = $this->db->query($qry);
		$row = $query->result();
		return $row;
	}
	
	function clientrequestdetail($request_id){
		$arrData = array();
		$qry = "SELECT * FROM washer_response WHERE client_request_id = '".$request_id."' AND is_washer_accepted = 1";
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			$washer_accepted_id = $row[0]->user_id;
			$arrData['washer_response_id'] = $washer_response_id = $row[0]->washer_response_id;
			$arrData['washerdetail'] = $this->checkwasherid($arrData['washer_response_id']);
			$qry1 = "SELECT * FROM users WHERE user_id = '".$washer_accepted_id."'";
			$query1 = $this->db->query($qry1);
			$row1 = $query1->result();
			$arrData['user'] = $row1[0];
			$qry2 = "SELECT cr.* FROM client_request as cr WHERE cr.client_request_id = '".$request_id."'"; 
			$query2 = $this->db->query($qry2);
			$row2 = $query2->result();
			if($row2)
			{
				$arrData['client_request'] = $row2[0];
			
			}
			$qry3 = "SELECT * FROM users WHERE user_id = '".$row2[0]->user_id."'";
		    $query3 = $this->db->query($qry3);
		    $row3 = $query3->result();
		    $arrData['clientUser'] = $row3[0];
		    $qry4 = "SELECT * FROM service_charge_tbl";
		    $query4 = $this->db->query($qry4);
		    $row4 = $query4->result_array();
		    $arrData['cancellation_fee']=$row4[0]['cancellation_fee'];

			return $arrData;
		}else{
			return false;
		}
	}
	
	function clientrequestdetail2($request_id){
			$arrData = array();
			$qry2 = "SELECT cr.* FROM client_request as cr WHERE cr.client_request_id = '".$request_id."'"; 
			$query2 = $this->db->query($qry2);
			$row2 = $query2->result();
			if($row2)
			{
				
				if(($row2[0]->is_request_open==2) ||($row2[0]->is_request_open==4))
				{

						$arrData['job_cancel_status']=true; //go to home page
					
				}
				else if(($row2[0]->is_request_open==10)||($row2[0]->is_request_open==3))
				{
					if($row2[0]->is_payment_done==1)
					{
						$arrData['job_cancel_status']=true;
					}
					else
					{
						$arrData['job_cancel_status']=false;	
					}
				}
				else
				{
					$arrData['job_cancel_status']=false;
				}


				return $arrData;
			}
			else
			{
				return false;
			}
	}
	
	function addorder($data){ 
		$this->db->insert('service_payment', $data);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$uid = $this->db->insert_id();		
			return $uid;
		}else{
			return FALSE;
		}
    }
	
	function addpoints($data,$uid,$points){ 
		$newpoints = "";
		if($data['transaction_status'] == 1){
			$qry1 = "SELECT points FROM users WHERE user_id = ".$uid;
			$queryy = $this->db->query($qry1);
			$roww = $queryy->result(); 
			if(count($roww[0]) > 0){
				$newpoints = ($roww[0]->points + $points);
				$uq = "UPDATE users SET points = '".$newpoints."' WHERE user_id = '".$uid."'";
				$this->db->query($uq);
			}
		}
			
		$this->db->insert('points_history', $data);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$id = $this->db->insert_id();
			return $id;
		}else{
			return false;
		}
    }
	
	function getpoints(){ 
		$qry = "SELECT * FROM points_history";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
    }
	
	function gettotalamount($uid){ 
		$qry = "SELECT user_id, sum(points) as totalamount FROM users WHERE user_id = '".$uid."'";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0]->totalamount;
		}else{
			return 0;
		}
    }
	
	function getpointsbyUid($uerid){ 
		$qry = "SELECT p.* FROM points_history as p WHERE p.user_id = ".$uerid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
    }
	
	function getpaymentwasher($uerid){ 
		$qry = "SELECT p.* FROM users as p WHERE p.user_id = ".$uerid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0]->points;
		}else{
			return false;
		}
    }
	
	function addlocationhistory($data,$uid){
		$qry = "SELECT p.* FROM location_history as p WHERE p.user_id = ".$uid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			$this->db->trans_start();
			$this->db->where('user_id', $uid); 
			$this->db->update('location_history', $data); 
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				return $this->db->_error_message();
			}else{ 
				$this->update_washer_location($uid,$data['latitude'],$data['longitude']);
				return true;
			}
		}else{
			$this->db->insert('location_history', $data);
			$rows =  $this->db->affected_rows();
			if($rows>0){
				$uid = $this->db->insert_id();		
				$this->update_washer_location($uid,$data['latitude'],$data['longitude']);
				return true;
			}else{
				return FALSE;
			}
		}
		
		
	}
	
	function getlocationhistory($uerid, $requstid){
		$qry = "SELECT lh.*, cr.is_job_completed, cr.is_request_open, wr.user_id FROM washer_response as wr, client_request as cr, location_history as lh WHERE cr.client_request_id = wr.client_request_id AND lh.user_id = ".$uerid." AND cr.client_request_id = ".$requstid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0)
		{
			return $row[0];
		}else{
			return false; 
		}
    }
	
	function updatedevicetokan($data, $uerid){
		$this->db->trans_start();
        $this->db->where('user_id', $uerid); 
		$this->db->update('users', $data); 
		$this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ 
			return true;
		}
	}
	
	function sdschecktokan($uid){
		$qry = "SELECT user_id, device_token FROM users WHERE user_id =$uid";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row)>0)
		{
			return $row[0]->device_token;
		}
		else
		{
			return '';
		}
	}
	
	function getpaypalEmail($uid){
		$qry = "SELECT user_id, payerinfo FROM users WHERE user_id =$uid";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			return $row[0]->payerinfo;
		}else{
			return false;
		}
	}
	
	function refreshtokencheck($uid){
		$qry = "SELECT user_id, refresh_token FROM authorized_data WHERE user_id = ".$uid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
		return $row[0]->refresh_token;
		}
		else
		{
			return '';
		}
	}
	
	function sendnotification($token,$message){

		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		
			$fields = array(
			'to' => $token,
			'notification' => array(
				'title' => 'From Carwashmi',
				'body' => $message),
			    'content_available' => true,
				'data' => array('message' => $message),
			      'priority' => 'high'

			);
		
		/* $fields = array (
				'registration_ids' => array (
						$token
				),
				'data' => array (
						"message" => $message
				)
		);
                */

		/*$headers = array(
	'Authorization:key=AAAAQ0UQ8OA:APA91bFIv5LpTOyjisjDi5v-kZjkPaG414KOOzbfNfYxyu4VWl_implhePuHHQXNwxuhmhJXKVoaTv6rrNH-MLkO8pgharNRo9-M344E8_v80GrPwWhpWKVEuiMSGp8ETQ6sJYcDprJw',
			'Content-Type:application/json'
		);	*/
		
		$headers = array(
	'Authorization:key=AAAAeYDrqDw:APA91bF1Brq1xZEEiDuUkEl33LJ4tEBQpUJHfZINcjOY89YuIBxz8WlqbScVk0xx4Yx0f0-fXbxs7aWbM9-LGJid6h2Lnb2921SG88s29cy1Yqj4yvvuWNYDhUgf3EX4kQqFuQokBYl2',
	'Content-Type:application/json'
		);	
	
		$ch = curl_init();
 
		curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	
		$result = curl_exec($ch);
	        return $result;
		curl_close($ch);
	}
	
	function getclientID($requestID){
		$qry = "SELECT user_id FROM client_request WHERE client_request_id = ".$requestID;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		return $row[0]->user_id;
	}
	
	function getwasherID($responseID){
		$qry = "SELECT user_id FROM washer_response WHERE washer_response_id = ".$responseID;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		return $row[0]->user_id;
	}
	
	function getwasherresponseID($requestID){
		$qry = "SELECT * FROM washer_response WHERE client_request_id = ".$requestID;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		return $row[0]->washer_response_id;
	}
	
	function getwasherdt($requestID){
		$qry = "SELECT user_id FROM washer_response WHERE client_request_id = ".$requestID;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		return $row[0]->user_id;
	}
	
	function getwasherdetls($requestID){
		$details = array();
		$qry = "SELECT ws.* FROM washer_response as ws WHERE ws.client_request_id = ".$requestID." AND ws.is_washer_accepted = 1";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			$latlong = $this->getlocationhistory($row[0]->user_id, $requestID);
			$details['washer_id'] = $row[0]->user_id;
			$details['latitude'] = $latlong->latitude;
			$details['longitude'] = $latlong->longitude;
			return $details;
		}else{
			return false;
		}
		
	}
	
	function getcustomerdetls($requestID){
		$details = array();
		$qry = "SELECT ws.*, clr.* FROM washer_response as ws, client_request as clr WHERE clr.client_request_id = ".$requestID." AND ws.is_washer_accepted = 1";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			$latlong = $this->getlocationhistory($row[0]->user_id, $requestID);
			$details['washer_id'] = $row[0]->user_id;
			$details['latitude'] = $latlong->latitude;
			$details['longitude'] = $latlong->longitude;
			return $details;
		}else{
			return false;
		}
		
	}
	
	function getallwashersclosed(){
		$qry = "SELECT * FROM washer_response WHERE is_washer_accepted = 3";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			return $row;
		}else{
			return false;
		}
	}
	
	function cancel_request($requestID,$cancelby){
		if($cancelby == "washer"){
			$uq2 = "UPDATE client_request SET is_job_completed = 0, is_request_open = 4 WHERE client_request_id = '".$requestID."'";
		}else if($cancelby == "customer"){
			$uq2 = "UPDATE client_request SET is_job_completed = 0, is_request_open = 3 WHERE client_request_id = '".$requestID."'";
				
	$qry = "SELECT washer_response.washer_response_id,washer_response.is_washer_accepted, client_request.* FROM washer_response INNER JOIN client_request ON washer_response.client_request_id=client_request.client_request_id WHERE client_request.client_request_id = $requestID AND washer_response.is_washer_accepted = '1' limit 1";
			$query = $this->db->query($qry);
			$row = $query->result_array(); 
			if(count($row) > 0){
				$customer_id=$row[0]['user_id'];
				$nup = "UPDATE users SET is_cancellation_charge = 'true' WHERE user_id = '".$customer_id."'";
				$this->db->query($nup);
			}
				
		}else{
			$uq2 = "UPDATE client_request SET is_job_completed = 0, is_request_open = 2 WHERE client_request_id = '".$requestID."'"; 
		}
		$this->db->query($uq2);

	}
	
	function is_cancellation_charge_pending($customer_id)
	{

		/*$qry = "SELECT * FROM users  WHERE user_id = '".$customer_id."' AND user_type='0' AND is_cancellation_charge='true'";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){*/
			$query2="SELECT * FROM service_charge_tbl";
			$query3 = $this->db->query($query2);
			$result = $query3->result_array(); 
			return $result[0]['cancellation_fee'];
		/*}else{
			return '';
		}*/
	}
	function cancel($requestID){
		$qry = "SELECT * FROM client_request WHERE client_request_id = ".$requestID; 
		$query = $this->db->query($qry);
		$row = $query->result(); 
		$uid = $row[0]->user_id;
		$points = $row[0]->points;
		$data = array('points' => $points);
		if($row[0]->is_request_open == 1){
			$uq = "UPDATE users SET points = '".$points."' WHERE user_id = '".$uid."'";
			$this->db->query($uq);
			$uq2 = "UPDATE client_request SET is_request_open = 3 WHERE client_request_id = '".$requestID."'";
			$this->db->query($uq2); 
		}
	}
	
	function updateclientpaymentstatus($requestID,$param,$useraccountstats = 0){
		$uq1 = "UPDATE client_request SET is_payment_done = ".$param." WHERE client_request_id = '".$requestID."'";
		$uq2 = "UPDATE user_accounts SET is_transaction_settled = ".$useraccountstats." WHERE client_request_id = '".$requestID."'";
		$this->db->query($uq1); 
		$this->db->query($uq2); 
	}
	
	function jobstatus($rid,$uid, $setrating = 0){
		if($setrating != 0){
			//$uq = "UPDATE client_request SET is_job_completed = $setrating WHERE client_request_id = '".$rid."'";
			$uq = "UPDATE client_request SET is_job_completed = 0 WHERE client_request_id = '".$rid."'";
		}else{
			$uq = "UPDATE client_request SET is_job_completed = 1 WHERE client_request_id = '".$rid."'";
		}
		
		$this->db->query($uq);
		$q = "SELECT points FROM client_request WHERE client_request_id = '".$rid."'";
		$qry = $this->db->query($q);
		$rows = $qry->result();
		$points = $rows[0]->points;
		$arr = array(
			'user_id' => $uid,
			'client_request_id' => $rid,
			'points' => $points,
			'transaction_type' => 2
		);
		$this->db->insert('user_accounts', $arr);
		$rows2 =  $this->db->affected_rows();
		if($rows2>0){
			$rowid = $this->db->insert_id();		
		}
		$qry1 = "SELECT points FROM users WHERE user_id = ".$uid;
		$query1 = $this->db->query($qry1);
		$row1 = $query1->result();
		$user_points = $row1[0]->points;
		$washerPoints = ($points + $user_points);
		$uqA = "UPDATE users SET points = '".$washerPoints."' WHERE user_id = '".$uid."'";
		$this->db->query($uqA);
		$t = "SELECT user_id, device_token FROM users where user_id = '".$uid."'";
		$tqry = $this->db->query($t);
		$trows = $tqry->result();
		$device_token = $trows[0]->device_token;
		$message = "Job successfully completed! ".$washerPoints." points has been added in your account.";
		$this->sendnotification($device_token,$message);
	}
	
	function useraccountdata($data,$request_id){
		$qry1 = "SELECT client_request_id, is_job_completed FROM client_request WHERE client_request_id = ".$request_id; 
		$queryy = $this->db->query($qry1);
		$rowss = $queryy->result();
		$qry = "SELECT ua.* FROM user_accounts as ua WHERE ua.client_request_id = ".$request_id;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			if($rowss[0]->is_job_completed == 1){
				$this->db->trans_start();
				$this->db->where('client_request_id', $request_id); 
				$this->db->update('user_accounts', $data); 
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE){
					return $this->db->_error_message();
				}else{ 
					return true;
				}
			}
		}else{
			$this->db->insert('user_accounts', $data);
			$rows =  $this->db->affected_rows();
			if($rows>0){
				$uid = $this->db->insert_id();		
				return true;
			}else{
				return FALSE;
			}
		}
		
		
	}
	
	function getuserData($uerid)
	{
		$qry = "SELECT u.*,ua.*, (select sum(points) from user_accounts where user_id = '".$uerid."') as total_points FROM users as u, user_accounts as ua WHERE ua.user_id = u.user_id AND u.user_id = ".$uerid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
	}
	
	function getDatawashmi($uerid){
		$rData = array();
		$qry = "SELECT * FROM user_accounts WHERE user_id = ".$uerid." AND transaction_type = 2"; 
		$query = $this->db->query($qry);
		$rows = $query->result();
		if(count($rows[0]) > 0){
			$rData['useraccounts'] = $rows[0];
			foreach($rows as $r){
				$requestID = $rows[0]->client_request_id;
				$qry1 = "SELECT * FROM client_request WHERE client_request_id = ".$requestID; 
				$query1 = $this->db->query($qry1);
				$row = $query1->result();
				$rData['requestdata'] = $row[0];
			}
			return $rData;
		}else{ 
			return false; 
		}
	}
	
	function getuserCardDetails($uerid)
	{
		$qry = "SELECT u.*,ps.* FROM users as u, payment_settigns as ps WHERE ps.user_id = u.user_id AND u.user_id = ".$uerid;
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row) > 0){
			return $row[0];
		}else{
			return '';
		}
	}
	
	function saveauthorization($data){
		$userdata = $this->getuserbyidfrauthorized($data['user_id']);
		if($userdata == 1){
			$this->db->trans_start();
			$this->db->where('user_id', $data['user_id']); 
			$this->db->update('authorized_data', $data); 
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				return $this->db->_error_message();
			}else{  
				return true;
			}
		}else{
			$this->db->insert('authorized_data', $data);
			$rows =  $this->db->affected_rows();
			if($rows>0){
				$uid = $this->db->insert_id();		
				return true;
			}else{
				return false;
			}
		}
	}
	
	function getusertokens($uerid){
		$qry1 = "SELECT * FROM users where user_id = '".$uerid."'";
		$query1 = $this->db->query($qry1);
		$row1 = $query1->result();
		if(count($row1) > 0){
			$qry = "SELECT u.* FROM authorized_data as u where u.user_id = '".$uerid."'";
			$query = $this->db->query($qry);
			$row = $query->result();
			if(count($row) > 0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}
	
	function getusertokensPayment($uerid){
		$qry1 = "SELECT * FROM users as u where u.user_id = '".$uerid."'";
		$query1 = $this->db->query($qry1);
		$row1 = $query1->result();
		if(count($row1) > 0){
				$qry = "SELECT u.* FROM authorized_data as u where u.user_id = '".$uerid."'";
				$query = $this->db->query($qry);
				$row = $query->result(); 
				if(count($row) > 0){
					return $row;
				}else{
					return false;
				}
			}else{
				return $row1;
			}
		
	}
	
	function update_requestStatus($rid, $uid, $status,$ratingdata){
		$data=array();
		if($status == 7){
			$updateamount = "SELECT points FROM users WHERE user_id = ".$uid;
			$query = $this->db->query($updateamount);
			$row = $query->result(); 
			if(count($row[0]) > 0){
				$rt = "SELECT points FROM client_request WHERE client_request_id = ".$rid;
				$qr = $this->db->query($rt);
				$rows = $qr->result(); 
				$newpoints = ($row[0]->points + $rows[0]->points);
				$uq = "UPDATE users SET points = '".$newpoints."' WHERE user_id = '".$uid."'";
				$this->db->query($uq);
			}else{
				$rt = "SELECT points FROM client_request WHERE client_request_id = ".$rid;
				$qr = $this->db->query($rt);
				$rows = $qr->result(); 
				$uq = "UPDATE users SET points = '".$rows[0]->points."' WHERE user_id = '".$uid."'";
				$this->db->query($uq);
			}
		}
		$this->db->trans_start();
		$data['is_request_open'] = $status;
		if(isset($ratingdata['washer_rating']) && isset($ratingdata['washer_comment']))
		{ 
			$data['washer_rating'] = $ratingdata['washer_rating'];
			$data['washer_comment'] = $ratingdata['washer_comment'];
		}
		
		if(isset($ratingdata['customer_rating']) && isset($ratingdata['customer_comment'])){
			$data['customer_rating'] = $ratingdata['customer_rating'];
			$data['customer_comment'] = $ratingdata['customer_comment'];
		}
		$this->db->where('user_id', $uid); 
		$this->db->where('client_request_id', $rid); 
		$this->db->update('client_request', $data); 
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
		}else{ 
			// echo $this->db->last_query(); die;
			return true;
		}
		
	}


	function update_requestStatus1($rid, $uid, $status,$ratingdata){
		$data=array();
		if($status == 7){
			$updateamount = "SELECT points FROM users WHERE user_id = ".$uid;
			$query = $this->db->query($updateamount);
			$row = $query->result(); 
			if(count($row[0]) > 0){
				$rt = "SELECT points FROM client_request WHERE client_request_id = ".$rid;
				$qr = $this->db->query($rt);
				$rows = $qr->result(); 
				$newpoints = ($row[0]->points + $rows[0]->points);
				$uq = "UPDATE users SET points = '".$newpoints."' WHERE user_id = '".$uid."'";
				$this->db->query($uq);
			}else{
				$rt = "SELECT points FROM client_request WHERE client_request_id = ".$rid;
				$qr = $this->db->query($rt);
				$rows = $qr->result(); 
				$uq = "UPDATE users SET points = '".$rows[0]->points."' WHERE user_id = '".$uid."'";
				$this->db->query($uq);
			}
		}
		$this->db->trans_start();
		$data['is_request_open'] = $status;
		
		if(isset($ratingdata['customer_rating']) && isset($ratingdata['customer_comment'])){
			$data['customer_rating'] = $ratingdata['customer_rating'];
			$data['customer_comment'] = $ratingdata['customer_comment'];
		}
		//$this->db->where('user_id', $uid); 
		$this->db->where('client_request_id', $rid); 
		$this->db->update('client_request', $data); 
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
		}else{ 
			// echo $this->db->last_query(); die;
			return true;
		}
		
	}
	
	function savecard($data){
		$userdata = $this->getuserbyidcard($data['user_id']);
		if($userdata == true){
			$this->db->trans_start();
			$this->db->where('user_id', $data['user_id']); 
			$this->db->update('payment_settigns', $data); 
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE){
				return $this->db->_error_message();
			}else{ 
				return true;
			}
		}else{
			$this->db->insert('payment_settigns', $data);
			$rows =  $this->db->affected_rows();
			if($rows>0){
				$uid = $this->db->insert_id();		
				return true;
			}else{
				return FALSE;
			}
		}
	}

	/*	function savecard($data)
		{
		
				$this->db->insert('payment_settigns', $data);
				$rows =  $this->db->affected_rows();
				if($rows>0){
					$uid = $this->db->insert_id();		
					return true;
				}else{
					return false;
				}
			
		}*/
	
	function getrequerstamount($requestID){
		$qry = "SELECT cr.*, s.* FROM client_request as cr, services as s WHERE cr.client_request_id = '".$requestID."' AND s.service_type = cr.service_type";  
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row[0]) > 0){
			return $row[0];
		}else{
			return false;
		}
	}
	
	function saverating($data){
		$this->db->insert('rating', $data);
		$rows =  $this->db->affected_rows();
		if($rows>0){
			$ratid = $this->db->insert_id();		
			return true;
		}else{
			return false;
		}
	}
	
	function checkstatus_payment($user_id){
		$payment_methods = array();
		$qry2 = "SELECT u.*, auth.* FROM users as u, authorized_data as auth where u.user_id = auth.user_id AND u.user_id = ".$user_id;
		$query2 = $this->db->query($qry2);
		$row2 = $query2->result();
		if(count($row2) > 0){
			$paypal = $row2[0]->payment_mode;
		}else{
			$paypal = false;
		}
		$qry = "SELECT u.*, ps.* FROM users as u, payment_settigns as ps where ps.user_id = u.user_id AND u.user_id = ".$user_id;
		$query = $this->db->query($qry);
		$row = $query->result();	
		if(count($row) > 0){
			$payment_methods['status'] = $row[0]->payment_status;
			$payment_methods['card'] = $row[0]->payment_mode;
			$payment_methods['user_status'] = ($row[0]->user_status == 1 || $row[0]->user_status == 0) ? "active" : "block";
			$payment_methods['paypal'] = $paypal;
		}else{
			if($paypal != false){
				$payment_methods['status'] = 1;
				$payment_methods['card'] = false;
				$payment_methods['user_status'] = ($row2[0]->user_status == 1 || $row2[0]->user_status == 0) ? "active" : "block";
				$payment_methods['paypal'] = $paypal;
			}else{
				$payment_methods['status'] = 0;
				$payment_methods['card'] = false;
				$payment_methods['user_status'] = "Payment method not exists";
				$payment_methods['paypal'] = $paypal;
			}
			
		}
		
		return $payment_methods;
	}
	
	function payment_status_update($user_id){
		$data = array(
			'payment_status' => 1
		);
		$this->db->trans_start();
		$this->db->where('user_id', $user_id); 
		$this->db->update('users', $data); 
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
		}else{ 
			return true;
		}
	}
	
	public function deletepayment_method($uid,$whattodelet) {
		$res = "";
		if($whattodelet=="card"){
			$this->db->where('user_id',$uid);
			$res = $this->db->delete("payment_settigns"); 
			if($res){
				$checkpayment_mode = "select user_id,payment_mode from authorized_data where user_id = '".$uid."'";
				$checkqry = $this->db->query($checkpayment_mode);
				$result = $checkqry->result();
				if(count($result) > 0){
					$pmtd = $result[0]->payment_mode;
				}else{
					$pmtd = "";
				}
				$qry = "update users set default_method = '".$pmtd."' where user_id = '".$uid."'";
				$query  = $this->db->query($qry);
				return true;
			}else{
				return false;
			}
		}else{
			$this->db->where('user_id',$uid);
			$res = $this->db->delete("authorized_data");
			if($res){
				$checkpayment_mode = "select user_id,payment_mode from payment_settigns where user_id = '".$uid."'";
				$checkqry = $this->db->query($checkpayment_mode);
				$result = $checkqry->result();
				if(count($result) > 0){
					$pmtd = $result[0]->payment_mode;
				}else{
					$pmtd = "";
				}
				$qry = "update users set default_method = '".$pmtd."' where user_id = '".$uid."'";
				$query  = $this->db->query($qry);
				$qry1 = "update users set payerinfo = '' where user_id = '".$uid."'";
				$query1  = $this->db->query($qry1);
				return TRUE;
			}else{
				return FALSE;
			}	
		}
	}
	
	function savepayerinfo($uid, $payerinfo){
		$qry = "update users set payerinfo = '".$payerinfo."' where user_id = '".$uid."'";
		$query  = $this->db->query($qry);
	}
	
	function updtpayerinfo($userid){
		$qry = "update users set payerinfo = '' where user_id = '".$userid."'";
		$query  = $this->db->query($qry);
	}
	
	function get_client_metadata_id($uid){
		$qry = "SELECT user_id,client_metadataid FROM users where user_id = '".$uid."'";
		$query = $this->db->query($qry);
		$row = $query->result(); 
		if(count($row[0]) > 0){
			return $row[0]->client_metadataid;
		}else{
			return false;
		}
	}
	
	function defaultmethod($userid,$action){
		$methodname = "";
		$check = "SELECT user_id, default_method FROM users WHERE user_id = '".$userid."'";
		$query = $this->db->query($check);
		$row = $query->result();
		if(count($row[0]) > 0){
			$checkmethod = $row[0]->default_method;
			if($checkmethod == ""){
				switch($action){
					case 'authorization':
						$methodname = "paypal";
						break;
					case 'addcard':
						$methodname = "card";
						break;
				}
				$qry = "update users set default_method = '".$methodname."' where user_id = '".$userid."'";
				$query  = $this->db->query($qry);
				return true;
			}
		}else{
			return false;
		}
	}
	
	function updatemethod($userid, $type){
		$methodname = "";
		$check = "SELECT user_id, default_method FROM users WHERE user_id = '".$userid."'";
		$query = $this->db->query($check);
		$row = $query->result();
		if(count($row[0]) > 0){
			$checkmethod = $row[0]->default_method;
			if($checkmethod == 'paypal' || $checkmethod == 'card'){
				$qry = "update users set default_method = '".$type."' where user_id = '".$userid."'";
				$query  = $this->db->query($qry);
				return true;
			}
		}else{
			return false;
		}
	}
	
	function getdefaultmethod($userid){
		$check = "SELECT * FROM users where user_id = ".$userid;
		// $check = "SELECT user_id, default_method FROM users WHERE user_id = '".$userid."'";
		$query = $this->db->query($check);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0]->default_method;
		}else{
			return false;
		}
	}
	
	function userblock($user_id){
		$data = array(
			'user_status' => 2
		);
		$this->db->trans_start();
		$this->db->where('user_id', $user_id); 
		$this->db->update('users', $data); 
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
		}else{ 
			return true;
		}
	}
	
	function paymentfailnotification($usertype,$requestid,$amount){
		$data=array();
		$to = "";
		$subject = "";
		$message = "";
		$clientid = $this->Api_model->getclientID($requestid);
		$data['customerEmail'] = $this->getuemail($clientid);
		$washerid = $this->Api_model->getwasherID($requestid);
		$data['washerEmail'] = $this->getuemail($washerid);
		$data['adminEmail'] = "info@carwashmi.com";
		$data['requestid'] = $requestid;
		$data['amount'] = $amount;
		switch($usertype){
			case "customer":
				$to = $data['customerEmail'];
				$subject = "Your payment not done for Request ID: #$requestid";
				ob_start();
					$this->load->view("blockstatusemail", $data);
				$message = ob_get_clean();
				break;
			case "washer":
				$to = $data['washerEmail'];
				$subject = "Carwashmi will pay you for Request ID: #$requestid";
				ob_start();
					$this->load->view("paidbycarwashmi", $data);
				$message = ob_get_clean();
				break;
			case "admin":
				$to = $data['adminEmail'];
				$subject = "Customer Payment Failed";
				ob_start();
					$this->load->view("customerpaymentfail", $data);
				$message = ob_get_clean();
				break;
		}
		$headers = "From: ".$this->Api_model->getuemail($actionn['user_id'])."\r\n"; 
		$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($to, $subject, $message, $headers);
	}
	
	function updateclientmetadataid($user_id, $client_metadata_ID){
		$data = array(
			'client_metadataid' => $client_metadata_ID
		);
		$this->db->trans_start();
		$this->db->where('user_id', $user_id); 
		$this->db->update('users', $data); 
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
		}else{ 
			return true;
		}
	}
	
	function checkpaymentstatus_customer($userid){
		$returnstatus = "";
		$check = "SELECT user_id, default_method,payerinfo,payment_status FROM users WHERE user_id = '".$userid."'";
		$query = $this->db->query($check);
		$row = $query->result();
		// print_r($row);
		$status = $row[0]->payment_status;
		if($status == 1 && $row[0]->payerinfo == ""){
			$returnstatus = "Paypal Authorized";
		}else{
			$payRInfo = $this->getpaypalEmail($userid);
			if($payRInfo != false){
				$d = unserialize($payRInfo);
				$resp = $d->payer_info;
				$returnstatus = str_repeat("x", (strlen($resp->email) - 12)) . substr($resp->email,-12,12);
			}
		}
		
		return $returnstatus;
	}
	
	function getrating($uid){ 
		$param = "";
		// check user is washer or customer
		$user = $this->checkUsertype($uid);
		if($user->user_type == 0){
			$param = 'customer';
		}else{
			$param = 'washer';
		}
		$check = "SELECT sum(".$param."_rating) as average_rating FROM client_request WHERE user_id = '".$uid."'";
		$query = $this->db->query($check);
		$row = $query->result();
		if(count($row) > 0){
			return ($row[0]->average_rating / 5);
		}else{
			return false;
		}
	}
	
	function is_washer_verified($washerID){
		$qry = "SELECT user_id, verify_by_admin FROM users WHERE user_id = '".$washerID."' AND verify_by_admin = 1";
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function getserviceprice($service_type){
		$qry = "SELECT service_type, amount FROM services WHERE service_type = ".$service_type;
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}else{
			return false;
		}
	}
	
	function getservicdetail($client_request){
		$qry = "SELECT 	vehicle_name, vehicle_type, service_type,vehicle_make,vehicle_model,vehicle_model_year,vehicle_color FROM  client_request WHERE client_request_id = ".$client_request;
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return $row[0];
		}else{
			return false;
		}
	}

	function update_washer_location($washer_id,$lat,$lng)
	{
		$this->db->set('latitude', "$lat");
		$this->db->set('longitude', "$lng");
		$this->db->where('user_id', $washer_id);
		if($this->db->update('users'))
		{
            return true;
		} 
		else
		{
			return false;
		}
	}

	function check_card_exist($cardnumber,$user_id)
	{
		$qry = "SELECT 	* FROM  payment_settigns WHERE card_number='$cardnumber' and user_id='$user_id'";
		$query = $this->db->query($qry);
		$row = $query->result();
		if(count($row) > 0){
			return true;
		}else{
			return false;
		}
	}

	function available_promotion_list()
	{
		$qry = "SELECT * FROM  promotions WHERE ((promotion_from <= '".date('Y-m-d H:i:00')."') AND (promotion_to >= '".date('Y-m-d H:i:00')."') OR (DATE(promotion_date) = '".date('Y-m-d')."'))";
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

	function get_washer_list()
	{
		$mainobj=array();
		$qry="SELECT * FROM service_payment WHERE is_washer_paid='false' ORDER BY service_payment_id DESC limit 400";
		$query = $this->db->query($qry);
		$row = $query->result_array();
		if(count($row)>0)
		{
			$qry_service="SELECT * FROM service_charge_tbl";
			$query_s = $this->db->query($qry_service);
			$row_service = $query_s->result_array();
			$admin_service_charge=$row_service[0]['admin_service_charge'];
			$mainobj['admin_service_charge']=array('charge'=>$admin_service_charge);

			for($i=0;$i<count($row);$i++)
			{
				$washer_res_id=$row[$i]['washer_response_id'];
				$qry2="SELECT * FROM washer_response WHERE washer_response_id='$washer_res_id'";
				$query2 = $this->db->query($qry2);
				$res = $query2->result_array();
				if(count($res)>0)
				{
					$mainobj['washerlist'][$i]['service_payment_id']=$row[$i]['service_payment_id'];
					$mainobj['washerlist'][$i]['washer_id']=$res[0]['user_id'];
					$mainobj['washerlist'][$i]['client_request_id']=$row[$i]['client_request_id'];
					$mainobj['washerlist'][$i]['customer_id']=$row[$i]['user_id'];
					$mainobj['washerlist'][$i]['totalamount']=$row[$i]['amount'];
					$mainobj['washerlist'][$i]['washeramount']=$row[$i]['amount']-(($admin_service_charge*$row[$i]['amount'])/100);
					
					$this->db->where('user_id',$res[0]['user_id']);
					$query3 = $this->db->get('users');
					$newres = $query3->result_array(); 
					if(count($newres[0]) > 0)
					{
						 $mainobj['washerlist'][$i]['washer_paypal_email']=$newres[0]['washer_paypal_email'];
						 $mainobj['washerlist'][$i]['washer']=$newres[0]['washer_address'];
								
					}
				}
			}
			return $mainobj;

		}
		else
		{
			return '';
		}
	}

	function update_washer_payment_status($payment_arr,$batch_status,$batch_id)
	{
			
			for($j=0;$j<count($payment_arr);$j++)
			{
				$this->db->set('is_washer_paid','true');
				$this->db->set('washer_payment_status',$batch_status);
				$this->db->set('washer_received_amount',$payment_arr[$j][1]);
				$this->db->where('service_payment_id',$payment_arr[$j][0]);
				$this->db->update('service_payment');
			}
			$data = array(
		    	'batch_id' => $batch_id,
		  		'batch_status' =>$batch_status
			);

			if($this->db->insert('washer_payout_record', $data))
			{
				return true;
			}
			else
			{
				return false;
			}
	}

	function  add_mycar_info($carinfo)
	{
		$customer_id=$carinfo['customer_id'];
		$vehicle_name=$carinfo['vehicle_name'];
		$this->db->select('*');
		$this->db->from('my_vehical_info');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('vehicle_name',$vehicle_name);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return true;
		}
		else
		{
			//insert
			if($this->db->insert('my_vehical_info', $carinfo))
			{
				return true;
			}
		}
	}

	function get_mycar_list($customer_id)
	{
		$this->db->select('*');
		$this->db->from('my_vehical_info');
		$this->db->where('customer_id',$customer_id);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		else
		{
			return '';
		}
	}

	function delete_car_list($user_id,$car_id)
	{
		$this->db->where('id', $car_id);
		$this->db->where('customer_id', $user_id);
		if($this->db->delete('my_vehical_info'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_car_info($car_id)
	{
		$this->db->select('*');
		$this->db->from('my_vehical_info');
		$this->db->where('id',$car_id);
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			$res=$query->result_array();
			return $res[0];
		}
		else
		{
			return '';
		}
	}

}
?>