<?php
class Usermodel extends CI_Model
{
	function __construct() 
	{
        parent::__construct();
	}
   	
	function getAllwashers(){
		$this->db->select("*");
		$this->db->from('account');
		$this->db->where('usertype',"washer");
		$query = $this->db->get();
		return $query->result();
		return $arr;
	}
	
    function loggedin_user($data){
		
		$condition = "account.username ='" . $data['user_email'] . "'";
		if($data['from']==0){
			$condition .= " AND account.password ='" . $data['password'] . "' ";
		}
		$this->db->select('*');
		$this->db->from('account');

		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		if ($query->num_rows() ==1) {
			$userdata =  $query->result_array();
			return $userdata[0];
		} else {
			return false;
		}
	}
	
	function checkOldpassword($em){
		$this->db->select('*');
		$this->db->where('email', $em);  
		$query = $this->db->get('account');
		$arr = $query->result();
		return $arr[0]->password;
   }
   
   
	function update_password($data, $em){
		$this->db->trans_start();
		$this->db->set('password', $data);
		$this->db->where('email', $em);
		$this->db->update('account'); 
		$this->db->trans_complete();

       if ($this->db->trans_status() === FALSE){
			 return false;
        }else{ return true; }
   }    
 
	function add_user($data){
		$this->db->insert('users', $data);
			  
		  $rows =  $this->db->affected_rows();
			if($rows>0){
			// return $rows;
			 return $this->db->insert_id();
			}else{
			  return FALSE;
			}
		
	}
	function get_g_user($key)
	{
		$this->db->where('email',$key);
		$query = $this->db->get('account');
		if ($query->num_rows() > 0){
			return true;
		}
	 
	} 
	
	function get_registerd_user($key)
	{
		$this->db->where('email',$key);
		$query = $this->db->get('account');
		if ($query->num_rows() > 0){
			$arr = $query->result_array();	 
			return $arr[0];
		} 
	}
	
	function get_customer($key)
	{
		$this->db->where('email',$key);
		$this->db->where('own_car',0);
		$this->db->where('usertype',"customer");
		$query = $this->db->get('account');
		if ($query->num_rows() > 0){
			$arr = $query->result_array();	 
			return $arr[0];
		} 
	}
	
	function get_biker($key)
	{
		$this->db->where('email',$key);
		$this->db->where('own_car',0);
		$this->db->where('usertype','washer');
		$query = $this->db->get('account');
		if ($query->num_rows() > 0){
			$arr = $query->result_array();	 
			return $arr[0];
		} 
	}
	
	function get_driver($key)
	{
		$this->db->where('email',$key);
		//$this->db->where('own_car',1);
		$this->db->where('usertype','washer');
		$query = $this->db->get('account');
		if ($query->num_rows() > 0){
			$arr = $query->result_array();	 
			return $arr[0];
		} 
	}
	
	function update_user($data, $em){
        $this->db->trans_start();
        $this->db->where('email', $em);
		$this->db->where('usertype','customer');
        $this->db->update('account', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ return true;}
	} 

	function update_biker($data, $em){
        $this->db->trans_start();
        $this->db->where('email', $em);
        $this->db->where('own_car',0);
		$this->db->where('usertype','washer');
        $this->db->update('account', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ return true;}
	}  

	function update_driver($data, $em){
        $this->db->trans_start();
        $this->db->where('email', $em);
        // $this->db->where('own_car',1);
		$this->db->where('usertype','washer');
        $this->db->update('account', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			return $this->db->_error_message();
        }else{ return true;}
	}
   
	function insertUser($data){ 
			$this->db->insert('account', $data);
			$rows =  $this->db->affected_rows();
			if($rows>0){
				$uid = $this->db->insert_id();		
				return $uid;
			}else{
				return FALSE;
			}
    }
	
 
	function sendEmail($data,$password,$sitename,$mail_detail)
    {
		    $sender_name=$mail_detail[0]->sender_name;
		    $sender_email=$mail_detail[0]->sender_email;
		    $sender_subject=$mail_detail[0]->sender_subject;
		    $mail_body=$mail_detail[0]->mail_body;
			
			$name=$data['first_name'].' '.$data['last_name'];
			$sender_subject=str_replace("{sitename}",$sitename,$sender_subject);
			$sender_subject=str_replace("{name}",$name,$sender_subject);
			
			$login_url=base_url().'user/sign_in/';
			$username =$data['username'];
			
			$mail_body=str_replace("{name}",$name,$mail_body);
			$mail_body=str_replace("{sitename}",$sitename,$mail_body);
			$mail_body=str_replace("{siteurl}",$login_url,$mail_body);
			$mail_body=str_replace("{username}",$username,$mail_body);
			$mail_body=str_replace("{password}",$password,$mail_body);
			
			$to       = $data['user_email']; // Send email to our user
			$subject  = $sender_subject; // Give the email a subject
			
			$message = $this->Common_model->mail_body($mail_body); // Our message above including the link
			
			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From:'.$sender_email.'' . "\r\n"; // Set from headers
			
			if(mail($to, $subject, $message, $headers))
			{
				return true;
			}else{
				return false;
			}
    }   

	function UserExist($emil)
	{
	    $this->db->where('user_email',$emil);
		$query = $this->db->get('users');
		$rowcount = $query->num_rows();		
		if($rowcount>0)
		{
			return true;
		}
		else
			return false;
	}
   
	function ChangePassword($data1,$userid)
	{        
        $this->db->where('username',$userid);
		return $query = $this->db->update('users', $data1);
	}
	
	
	function CounterUsers()
	{	
		$sql= "SELECT * FROM users where is_active=1";
		$query = $this->db->query($sql);
		return $query->num_rows();		
	}   
   function GetUserbyId($id)
	{
	    $sql2 = "SELECT * FROM users WHERE user_id=$id";  
        $query2 = $this->db->query($sql2);
        $row = $query2->result();
		if($query2->num_rows() > 0)
		{		
			$fname=$row[0]->first_name;
			$lname=$row[0]->last_name;
			return $fullname= ucwords($fname." ".$lname);
		}
		else
		{
			return NULL;
		}
    }
	
	function save_payment_settings($settings){
		$this->db->insert('payment_settings', $settings);  
		$rows =  $this->db->affected_rows();
		if($rows > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function update_payment_settings($settings, $uid){
		$qry = "UPDATE `payment_settings` SET `account_number` = ".$settings['account_number'].", `routing_number` = ".$settings['routing_number'].", `additional_info` = '".$settings['additional_info']."' WHERE `uid` = ".$uid;
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
		die;
	}
	
	function get_payment_settings($uid){ 
		$qry1 = "SELECT * FROM payment_settings where uid = '".$uid."'";
		$query  = $this->db->query($qry1);
		$arr1 = $query->result(); 
		 return $arr1;
		 
	}
	
	function update_hash($hash, $email){
		$qry = "update account set password = '".md5($hash)."' where email = '".$email."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
		die;
	}
	
	function update_hash_signup($hash, $uid){
		$qry = "update account set hash = '".$hash."' where account_id = '".$uid."'";
		$query  = $this->db->query($qry);
		if($query){
			return true; 
		}else{
			return false;
		}
		die;
	}
	
	function update_firstlogin_status($email){
		$qry = "";
		$this->db->select('*');
		$this->db->where('email', $email);  
		$query = $this->db->get('account');
		$arr = $query->result();
		$firstlogin = $arr[0]->firstlogin;
		if($firstlogin == 1){
			$data = array(
				'firstlogin' => 0
			);
			$this->db->trans_start();
			$this->db->where('email', $email);
			$this->db->update('account', $data); 
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
		$query = $this->db->get('account');
		$arr = $query->result();
		$firstlogin = $arr[0]->firstlogin;
		
		if($firstlogin == 0){
			$data = array(
				'firstlogin' => 1
			);
			$this->db->trans_start();
			$this->db->where('email', $email);
			$this->db->update('account', $data); 
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
	
	function getUsername($id){
		$this->db->select('*');
		$this->db->where('account_id', $id);  
		$query = $this->db->get('account');
		$arr = $query->result();
		$user = strstr($arr[0]->username, '@', true);	
		return $user;	
	}
	
	function update_user_location($data, $email){
        $this->db->trans_start();
        $this->db->where('email', $email);
        $this->db->update('account', $data); 
		 $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
			echo $this->db->_error_message();
        }else{ 
			echo '1';
		}
	}
	
	// function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
	// {
	  //convert from degrees to radians
	  // $latFrom = deg2rad($latitudeFrom);
	  // $lonFrom = deg2rad($longitudeFrom);
	  // $latTo = deg2rad($latitudeTo);
	  // $lonTo = deg2rad($longitudeTo);

	  // $latDelta = $latTo - $latFrom;
	  // $lonDelta = $lonTo - $lonFrom;

	  // $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		// cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  // return $angle * $earthRadius;
	// }
	
	function distance($lat1, $lon1, $lat2, $lon2) {

		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		//$unit = strtoupper($unit);
		return $miles;
		// } else if ($unit == "N") {
			// return ($miles * 0.8684);
		// } else {
			// return $miles;
		// }
	}
	 
}