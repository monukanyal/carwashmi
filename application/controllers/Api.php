<?php 
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller
{
    function __construct() 
	{
		parent::__construct();
		$this->load->model('Common_model');
		$this->load->model('Usermodel');
	}
	
	public function index()
	{   
		header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
		header('content-type: application/json; charset=utf-8');
		header("Accept: application/json");
		header("access-control-allow-origin: *");
		error_reporting(E_ALL);
		$responseArr = array();
		$response = null;
		$message = null;
		$code = null;

		$myFile = FCPATH ."pwd.txt";
		$lines = file($myFile);//file in to an array
		$auth_variables = explode("|", $lines[0]);
		$actionn = $_POST;
		
		$data = array("username" => $auth_variables[0], "password" => $auth_variables[1]);
		if(@$actionn['username'] != "" && @$actionn['password'] != "") {
			
			$error = '';
			
			// READING USERNAME & PASSWORD
			$username = $actionn['username'];
			$password = $actionn['password'];
			if($username == $data['username'] && $password == $data['password']){
	
				# JSON DECODE
				// print_r($_POST);
				# SWITCH STATEMENT FOR ACTIONS
				// $actionn = json_decode($_POST['action']);
				
				file_put_contents(FCPATH . 'array.txt', var_export($actionn, TRUE));
				switch($actionn['action']){
					case 'forgot':
						$email = $actionn['user_email'];
						if($this->Usermodel->get_g_user($email)==true){
							$hash = substr(md5(uniqid(mt_rand(), true)), 0, 8); 
							$arr = $this->Usermodel->update_hash($hash,$email);
							$this->Usermodel->update_forgot_firstlogin_status($email);
							$data['hash'] = $hash;
							$to = $email;
							$subject = 'Set up a new password for Carwash';

							$headers = "From: info@carwashme.com\r\n"; 
							$headers .= "Reply-To: noreply@carwashmi.com\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							ob_start();
								$this->load->view('reset_email_template', $data);
							$message = ob_get_clean();
							$m = mail($to, $subject, $message, $headers);
							if($m){
								$response = ($arr);
								$code = 200;
								$message = 'Email has been sent with password';
							}else{
								$code = 101;
								$error = 'Please try successful';
							}
						}else{
								$error = 'Email address not found';
								$code = 102;
						}
						break;							
					case 'userlogin':
						$email = $actionn['user_email'];
						$pwd = $actionn['pwd'];
						$from = 0;
						$data = array('user_email'=>$email,'password'=>md5($pwd),'from'=>$from);
						if($this->Usermodel->get_g_user($email)==true){
							$arr = $this->Usermodel->loggedin_user($data);
							$responseArr['usertype'] = $arr['usertype'];
							$responseArr['first_login'] = $arr['firstlogin'];
							if($arr!=false){
								$response = ($responseArr);
								$code = 200;
								$message = 'login successful';
							}else{
								$code = 300;
								$error = "Email password didn't match";
							}
						}else{
								$error = 'Email address not found';
								$code = 102;
						}
						break;	
					case 'signup':
						$password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
						$data = array( 
							'email' => $actionn['user_email'], 
							'username' => $actionn['user_email'],
							'password' => md5($password),
							'usertype' => $actionn['usertype'],
							'registration_date' => date('y-m-d h:i:s')
						);
						if($this->Usermodel->get_g_user($actionn['user_email'])==true){
							$error = 'User Already Exists';
							$code = 300;
						}else{
							$arr = $this->Usermodel->insertUser($data);
							$data['uid'] = $arr;
							$data['user_name'] = $this->Usermodel->getUsername($arr);
							$data['password'] = $password;
							
							$to = $actionn['user_email'];
							$subject = 'Registration Successfully Done.';
							$headers = "From: info@carwashmi.com\r\n"; 
							$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
							$headers .= "MIME-Version: 1.0\r\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							ob_start();
								$this->load->view('success_email_template', $data);
							$message = ob_get_clean();
							$m = mail($to, $subject, $message, $headers);
							if($m){
								$response = ($arr);		
								$code = 200;
								$message = 'User registred successfully';
							}else{
								$error = 'We are unable to send Email!';		
								$code = 301;
							}							
						}
						break;
					case 'getprofile_washer':
						$udata = array();
						$arr = $this->Usermodel->get_driver($actionn['user_email']);
						if($arr['email'] != null){
							$udata['first_name'] = $arr['firstname'];
							$udata['last_name'] = $arr['lastname'];
							$udata['user_email'] = $arr['email'];
							$udata['mobile_number'] = $arr['phone'];
							$udata['location'] = $arr['location'];
							$udata['usertype'] = $arr['usertype'];
							$udata['place_id'] = $arr['place_id'];
							$udata['own_car'] = $arr['own_car'];
							$udata['latitude'] = $arr['lat'];
							$udata['longitude'] = $arr['long'];
							$udata['service_plan'] = json_decode($arr['service_plan']);
							$udata['car_make'] = $arr['car_make'];
							$udata['car_model'] = $arr['car_model'];
							$udata['car_year'] = $arr['car_year'];
							$udata['liscence_plate'] = $arr['liscence_plate'];
							
							$response = ($udata);		
							$code = 200;
							$message = '';
						}else{
							$error = 'you are not registered as washer! Please check your email';		
							$code = 300;
						}
						break;
					case 'getprofile_driver':
						$udata = array();
						$arr = $this->Usermodel->get_driver($actionn['user_email']);
						$servicesArr = array(
							'wash_service' => (!isset($actionn['wash_service'])?"NULL":$actionn['wash_service']), 
							'cleaning_service' => (!isset($actionn['cleaning_service'])?"NULL":$actionn['cleaning_service']),
							'automatic_car_wash' => (!isset($actionn['automatic_car_wash'])?"NULL":$actionn['automatic_car_wash']),
							'polish_service' => (!isset($actionn['polish_service'])?"NULL":$actionn['polish_service']),
							'waxing_service' => (!isset($actionn['waxing_service'])?"NULL":$actionn['waxing_service']),
							'interior_service' => (!isset($actionn['interior_service'])?"NULL":$actionn['interior_service']),
							'two_whealer_washing' => (!isset($actionn['two_whealer_washing'])?"NULL":$actionn['two_whealer_washing'])
						);
						if($arr['email'] != null){
							$udata['first_name'] = $arr['firstname'];
							$udata['last_name'] = $arr['lastname'];
							$udata['user_email'] = $arr['email'];
							$udata['mobile_number'] = $arr['phone'];
							$udata['location'] = $arr['location'];
							$udata['place_id'] = $arr['place_id'];
							$udata['latitude'] = $arr['lat'];
							$udata['longitude'] = $arr['long'];
							$udata['services'] = json_decode($servicesArr);
							$udata['car_make'] = $arr['car_make'];
							$udata['car_model'] = $arr['car_model'];
							$udata['car_year'] = $arr['car_year'];
							$udata['liscence_plate'] = $arr['liscence_plate'];
							
							$response = ($udata);		
							$code = 200;
							$message = '';
						}else{
							$error = 'you are not registered as driver! Please check your email';		
							$code = 300;
						}
						break;
					case 'getprofile_biker':
						$udata = array();
						$arr = $this->Usermodel->get_biker($actionn['user_email']);
						if($arr['email'] != null){
							$udata['first_name'] = $arr['firstname'];
							$udata['last_name'] = $arr['lastname'];
							$udata['user_email'] = $arr['email'];
							$udata['mobile_number'] = $arr['phone'];
							$udata['location'] = $arr['location'];
							$udata['latitude'] = $arr['lat'];
							$udata['longitude'] = $arr['long']; 
							
							
							$response = ($udata);		
							$code = 200;
							$message = '';
						}else{
							$error = 'You are not registered as biker! Please check your email';		
							$code = 300;
						}
						break;
					case 'getprofile_customer':
						$udata = array();
						$arr = $this->Usermodel->get_customer($actionn['user_email']);
						if($arr['email'] != null){
							$udata['first_name'] = $arr['firstname'];
							$udata['last_name'] = $arr['lastname'];
							$udata['user_email'] = $arr['email'];
							$udata['mobile_number'] = $arr['phone'];
							$udata['location'] = $arr['location'];
							$udata['place_id'] = $arr['place_id'];
							$udata['latitude'] = $arr['lat'];
							$udata['longitude'] = $arr['long'];
							$udata['service_plan'] = json_decode($arr['service_plan']);
							$response = ($udata);		 
							$code = 200;
							$message = '';
						}else{
							$error = 'You email not exists!Please register your email first.';		
							$code = 300;
						}
						break;
					case 'updateprofile':
						$a = [];
						// $servicesArr = array(
							// 'wash_service' => (!isset($actionn['wash_service'])?"null":$actionn['wash_service']), 
							// 'cleaning_service' => (!isset($actionn['cleaning_service'])?"null":$actionn['cleaning_service']),
							// 'automatic_car_wash' => (!isset($actionn['automatic_car_wash'])?"null":$actionn['automatic_car_wash']),
							// 'polish_service' => (!isset($actionn['polish_service'])?"null":$actionn['polish_service']),
							// 'waxing_service' => (!isset($actionn['waxing_service'])?"null":$actionn['waxing_service']),
							// 'interior_service' => (!isset($actionn['interior_service'])?"null":$actionn['interior_service']),
							// 'two_whealer_washing' => (!isset($actionn['two_whealer_washing'])?"null":$actionn['two_whealer_washing'])
						// );
						$servicesArr = array(
							'elite' => (!isset($actionn['elite'])?"false":$actionn['elite']), 
							'standard' => (!isset($actionn['standard'])?"false":$actionn['standard']),
							'premium' => (!isset($actionn['premium'])?"false":$actionn['premium']),
						);
						$a[] = $servicesArr;
						$str = json_encode($a);
							
						if($this->Usermodel->get_g_user($actionn['user_email'])==true){
							$arr = $this->Usermodel->update_driver($data,$actionn['user_email']);
							$response = ($arr);		
							$code = 200;
							$message = 'Profile Updated successfully';								
						}
						break;
					case 'updateprofile_biker':
						$data = array(
							'firstname' => $actionn['first_name'], 
							'lastname' => $actionn['last_name'], 
							'email' => $actionn['user_email'], 
							'phone' => $actionn['mobile_number'],
							'location' => $actionn['location'],
							'lat' => $actionn['latitude'],
							'long' => $actionn['longitude'],
							'own_car' => $actionn['own_car']
						);	
						
						if($this->Usermodel->get_g_user($actionn['user_email'])==true){
							$arr = $this->Usermodel->update_biker($data,$actionn['user_email']);
							$response = ($arr);		
							$code = 200;
							$message = 'Profile Updated successfully';								
						}
						break;
					case 'updateprofile_customer':
						$a = array();
						$planArr = array(
							'elite' => (!isset($actionn['elite'])?"false":$actionn['elite']), 
							'standard' => (!isset($actionn['standard'])?"false":$actionn['standard']),
							'premium' => (!isset($actionn['premium'])?"false":$actionn['premium']),
						);
						$a[] = $planArr;
						$str = json_encode($a);
						$data = array(
							'firstname' => $actionn['first_name'], 
							'lastname' => $actionn['last_name'], 
							'email' => $actionn['user_email'], 
							'phone' => $actionn['mobile_number'],
							'location' => $actionn['location'],
							'place_id' => $actionn['place_id'],
							'lat' => $actionn['latitude'],
							'long' => $actionn['longitude'],
							'service_plan' => $str
						);	
						
						if($this->Usermodel->get_g_user($actionn['user_email'])==true){
							$arr = $this->Usermodel->update_user($data,$actionn['user_email']);
							$response = ($arr);		
							$code = 200;
							$message = 'Profile Updated successfully';								
						}
						break;
					case 'savelatlong':
						$data = array( 
							'email' => $actionn['user_email'], 
							'lat' => $actionn['lat'], 
							'long' => $actionn['long'],
						);
						
						if($this->Usermodel->get_g_user($actionn['user_email'])==true){
							$arr = $this->Usermodel->update_user_location($data,$actionn['user_email']);
							$response = ($arr);		
							$code = 200;
							$message = 'location saved';							
						}else{
							$error = 'email not exists!';		
							$code = 300;
						}
						break;
					case 'changepass':
						$new_pwd = md5($actionn['new_pwd']);
						$user_email = $actionn['user_email'];
						$oldpassword = $this->Usermodel->checkOldpassword($user_email);
						if($new_pwd == $oldpassword){
							$code = 300;
							$error = 'New password must be diffrent from old password!';
						}else{
							if($this->Usermodel->update_password($new_pwd,$user_email)){
								$this->Usermodel->update_firstlogin_status($user_email);
								$code = 200;
								$message = 'Password changed';
							}else{
								$code = 300;
								$error = 'Please try again'; 
							}
						}
						break;
					case 'getwashers':
						$washers = [];
						$lat = $actionn['latitude'];
						$long = $actionn['longitude'];
						$arr = $this->Usermodel->getAllwashers();
						if($arr > 0){
							for($count=0;$count<count($arr);$count++){
								$d = $this->Usermodel->distance($lat, $long, $arr[$count]->lat, $arr[$count]->long);
								if($d <= 10){
									$washers[] = $arr[$count];
								}
							}
							if($washers > 0){
								$response = ($washers);		
								$code = 200;
								$message = 'success';
							}else{
								$code = 301;
								$error = 'No service provider found!';
							}
						}else{
							$code = 300;
							$error = 'No record found!';
						}
						break;
				}
				
				// $arr = array('code'=> $code, 'info'=> $response, 'error'=> $error, 'message'=> $message );
				$arr = array('success'=> $message, 'code'=> $code, 'info'=> $response, 'error'=> $error);
				$response = json_encode($arr);
				echo $response;				
				die;
			}else{
				$message = "Access denied To Use Api!";
				$arr = array('error'=> array('errorcode' => 401, 'reason' => $message) );
				$response = json_encode($arr);
				echo $response;
			}
		}else{
			$message = "Access denied please check credentials used";
			$arr = array('error'=> array('errorcode' => 401, 'reason' => $message) );
			$response = json_encode($arr);
			echo $response;
		}
	}
	
	function base64_to_jpeg($base64_string, $output_file) {
		$ifp = fopen($output_file, "wb"); 

		$data = explode(',', $base64_string);

		fwrite($ifp, base64_decode($data[1])); 
		fclose($ifp); 

		return $output_file; 
	}
	
}	