<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Swebi extends CI_Controller
{
    function __construct() 
	{
		parent::__construct();
			 $this->CI =& get_instance();
			$this->load->model('Common_model');
			$this->load->model('Api_model');
			$this->load->model('Service_model');
			$this->load->model('Usermodel');

			$this->load->library('Creditcard');
			$sanbox = $this->CI->config->item('sandbox');
        $this->paypal_url = ($sanbox == TRUE)?'https://api.sandbox.paypal.com':'https://api.paypal.com';
		//$this->output->nocache();
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

		$myFile = FCPATH ."auth.txt";
		$lines = file($myFile);
		$auth_variables = explode("|", $lines[0]);
		$actionn = $_POST;
		$data = array("username" => $auth_variables[0], "password" => $auth_variables[1]);
		if(@$actionn['username'] != "" && @$actionn['pwd'] != "") {
			$error = '';
			$username = $actionn['username'];
			$password = $actionn['pwd'];
			if($username == $data['username'] && $password == $data['password']){
				switch($actionn['action']){				
					case 'login':
						$email = $actionn['email'];
						$pwd = $actionn['password'];
						$data = array('email' => $email,'password' => $pwd);
						if($this->Api_model->getuser($email) == true){
							$veryfi = $this->Api_model->email_verify($email);
							if($veryfi['user_type'] == 0 && $veryfi['is_email_verified'] == 0){
								$code = 301;
								$error = "Your email is not verified!";
								$response = false;
							}else{
								$arr = $this->Api_model->login($data);
								if($arr != 0){
									$responseArr['userinfo'] = $arr;
									$response = ($responseArr);
									$code = 200;
									$message = 'Login successful';
								}else{
									$code = 300;
									$error = "Username and password doesn't match!";
									$response = false;
								}
							}
						}else{
							$error = 'User not found!';
							$code = 102;
							$response = false;
						}
						break;	
					case 'signup':
						$random = substr(md5(uniqid(mt_rand(), true)), 0, 32);
						$userData = array();
						$data['random'] = $random;
						if($actionn['user_type'] == 1){
							$userData['firstlogin'] = 0;
						}
							
						$userData['email'] = strtolower($actionn['email']);
						$userData['password'] = md5($actionn['password']);
						$userData['user_type'] = $actionn['user_type'];
						$userData['registration_date'] = date('y-m-d h:i:s');
						if($this->Api_model->getuser($actionn['email'])==true){
							$error = 'User Already Exists';
							$code = 300;
						}else{
							$uid = $this->Api_model->register($userData);
	                        			if($actionn['user_type'] == 1){
								$data['link'] = "javascript:void(0);";
								$data['washer'] = 1;
							}else{
								$data['link'] = base_url() . "swebi/confirm?hash=".$random."&is_verify=f&u=".$uid;
								$data['washer'] = 0;
							}
							
							/**
							 * update `tokan` field in `user` table with random number
							 **/
							$this->Api_model->updatetokan($random, $uid);
							$data['user_name'] = $this->Api_model->getusername($uid);
							$data['password'] = $actionn['password'];
							
							$to = $actionn['email'];
							$subject = 'Registration Successfully Done.';
							//$headers = "From: carwashmi@carwashmi.com\r\n"; 
							//$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
							//$headers .= "MIME-Version: 1.0\r\n";
							//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							ob_start();
								$this->load->view('success_email_template', $data);
							$message = ob_get_clean();
							//$m = mail($to, $subject, $message, $headers);
							$m = $this->send_mail($to, $subject, $message);
							if($m){
								$response = ($uid);		
								$code = 200;
								$message = 'User successfully registred ';
							}else{
								$error = 'We are unable to send email!';		
								$code = 301;
							}
						        $response = ($uid);		
								$code = 200;
								$message = 'User successfully registred ';
						}
						break;
					case 'forgotpass':
						$email = $actionn['email'];
						if($this->Api_model->getuser($email)==true){
							$hash = substr(md5(uniqid(mt_rand(), true)), 0, 8); 
							$arr = $this->Api_model->forgotpassStatus(1,$email);
							$this->Api_model->update_forgot_firstlogin_status($email);
							$data['hash'] = $hash;
							$this->Api_model->updateTempPass($data['hash'],$email);
							$to = $email;
							$subject = 'Set up a new password for account';

							//$headers = "From: carwashmi@carwashme.com\r\n"; 
							//$headers .= "Reply-To: noreply@carwashmi.com\r\n";
							//$headers .= "MIME-Version: 1.0\r\n";
							//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							ob_start();
								$this->load->view('reset_email_template', $data);
							$message = ob_get_clean();
							//$m = mail($to, $subject, $message, $headers);
							$m = $this->send_mail($to, $subject, $message);
							if($m){
								$response = ($arr);
								$code = 200;
								$message = 'Email has been sent with temporary password. You can change it later.';
							}else{
								$code = 101;
								$error = 'Please try again';
							}
						}else{
								$error = 'Email address not found';
								$code = 102;
						}
						break;
					case 'changepass':
						$new_password = md5($actionn['new_password']);
						$email = $actionn['email'];
						$oldpassword = $this->Api_model->checkOldpassword($email);
						if($new_password == $oldpassword){
							$code = 300;
							$error = 'New password must be diffrent from old password!';
						}else{
							
							if($this->Api_model->update_password($new_password,$email)){
								$this->Api_model->forgotpassStatus(0,$email);
								$this->Api_model->update_firstlogin_status($email);
								$code = 200;
								$message = 'Password changed successfully';
							}else{
								$code = 300;
								$error = 'Please try again'; 
							}
						}
						break;
					case 'getprofile':
						$udata = array();
						$arr = $this->Api_model->getprofile($actionn['user_id']);
						if(count($arr) > 0 && $arr != false){
							$udata['user_id'] = intval($arr->user_id);
							$udata['first_name'] = $arr->first_name;
							$udata['last_name'] = $arr->last_name;
							$udata['email'] = $arr->email;
							$udata['mobile_number'] = $arr->mobile_number;
							$udata['location'] = $arr->location;
							$udata['user_type'] = $arr->user_type;
							$udata['latitude'] = $arr->latitude;
							$udata['longitude'] = $arr->longitude;
							$udata['rider_type']=$arr->rider_type;
                            $udata['dob']=$arr->dob;
							$udata['is_elite_service'] = ($arr->is_elite_service) ? true : false;
							$udata['is_standard_service'] = ($arr->is_standard_service) ? true : false;
							$udata['is_premium_service'] = ($arr->is_premium_service) ? true : false;
							
							$udata['totalamount'] = $arr->points;
							$udata['firstlogin'] = $arr->firstlogin;
							$udata['washer_paypal_email'] = $arr->washer_paypal_email;
							$udata['washer_address'] = $arr->washer_address;
							$response = ($udata);		
							$code = 200;
							$message = '';
						}else{
							$code = 300;
							$error = 'Record Not found!'; 
						}
						break;
					case 'updateprofile':
						$udata = array();
						$arr = $this->Api_model->getprofile($actionn['user_id']);
						$data['email'] = $arr->email;
						$udata['user_id'] = isset($actionn['user_id'])?$actionn['user_id']:0;
						$udata['first_name'] = (isset($actionn['first_name']))?$actionn['first_name']:$arr->first_name;
						$udata['last_name'] = (isset($actionn['last_name']))?$actionn['last_name']:$arr->last_name;
						$udata['mobile_number'] = (isset($actionn['mobile_number']))?$actionn['mobile_number']:$arr->mobile_number;
						$udata['location'] = (isset($actionn['location']))?$actionn['location']:$arr->location;
						$udata['latitude'] = (isset($actionn['latitude']))?$actionn['latitude']:$arr->latitude;
						$udata['longitude'] = (isset($actionn['longitude']))?$actionn['longitude']:$arr->longitude;
						$udata['rider_type'] = (isset($actionn['rider_type']))?$actionn['rider_type']:"";
						$udata['user_type'] = (isset($actionn['user_type']))?$actionn['user_type']:$arr->user_type;
						$udata['firstlogin'] = 1;
						$udata['is_email_verified'] = 1;
							
                         $udata['is_fast_service'] = (isset($actionn['is_fast_service']) && $actionn['is_fast_service'] == "true")?1:0;
						$udata['is_elite_service'] = (isset($actionn['is_elite_service']) && $actionn['is_elite_service'] == "true")?1:0;
						$udata['is_standard_service'] = (isset($actionn['is_standard_service']) && $actionn['is_standard_service'] == "true")?1:0;
						$udata['is_premium_service'] = (isset($actionn['is_premium_service']) && $actionn['is_premium_service'] == "true")?1:0;
						$udata['dob'] = (isset($actionn['dob']))?$actionn['dob']:$arr->dob;
	$udata['washer_paypal_email'] = (isset($actionn['washer_paypal_email']))?$actionn['washer_paypal_email']:$arr->washer_paypal_email;
						$udata['washer_address'] = (isset($actionn['washer_address']))?$actionn['washer_address']:$arr->washer_address;
						$arr1 = $this->Api_model->updateuser($udata,$actionn['user_id']);
						if(isset($actionn['user_type']) && $actionn['user_type'] == 1){
							$to = $arr->email;
							$subject = 'Profile updated successfully';
							//$headers = "From: carwashmi@carwashmi.com\r\n"; 
							//$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
							//$headers .= "MIME-Version: 1.0\r\n";
							//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
							ob_start();
								$this->load->view('verification_email_template', $data);
							$message = ob_get_clean();
							//$m = mail($to, $subject, $message, $headers);
							$m = $this->send_mail($to, $subject, $message);
							$tokan = $this->Api_model->sdschecktokan($actionn['user_id']);
							$this->Api_model->sendnotification($tokan, $actionn['first_name']." - Admin verifying your account, you will receive a confirmation email Soon");
							$verified = ($arr->verify_by_admin == 1)?1:0;
							$arrt = array('Update Profile' => true, 'washerconfirmed' => $verified);
							$response = ($arrt);	
							$code = 200;
							$message = 'Profile Updated successfully';
						}else{
							$arr = array('Update Profile' => true);
							$response = ($arr);	
							$code = 200;
							$message = 'Profile Updated successfully';
						}

						break;
					
					case 'profileimage':
						$postData = array();
						$postData['user_id'] = $actionn['user_id'];
						$postData['profile_pic'] = $actionn['img'];
						$arr = $this->Api_model->update_profile_img($postData);
						
						$response = (array('update'=>"true"));	
						$code = 200;
						$message = 'Profile Image Updated successfully';
						
						break;
					case 'getprofileimg':
						$arr = $this->Api_model->checkprofileimage($actionn['user_id']);
						$img = ($arr != false)?$arr:false;
						$response = ($img);	
						$code = 200;
						$message = 'success';								
						break;
					case 'savelatlong': 
						$data = array( 
							'email' => $actionn['email'], 
							'latitude' => $actionn['latitude'], 
							'longitude' => $actionn['longitude'],
						);
						
						if($this->Api_model->getuser($actionn['email'])==true){
							$arr = $this->Api_model->update_user_location($data,$actionn['email']);
							$response = ($arr);		
							$code = 200;
							$message = 'Location Saved Successfully';							
						}else{
							$error = 'Email Not Exists!';		
							$code = 300;
						}
						break;
					case 'getwashers':
						$finalwashers = array();
						$lat = $actionn['latitude'];
						$long = $actionn['longitude'];
						$arr = $this->Api_model->getAllwashers();
						if($arr > 0){
							for($count=0;$count<count($arr);$count++){
								if($arr[$count]->rider_type == 0){
									$bikers_distense = $this->distance($lat, $long, $arr[$count]->latitude, $arr[$count]->longitude, "K");
									if($bikers_distense <= 40){
										array_push($finalwashers,$arr[$count]);
									}
								}else{
									$d = $this->distance($lat, $long, $arr[$count]->latitude, $arr[$count]->longitude, "K");
									if($d <= 40){
										array_push($finalwashers,$arr[$count]);
									}
								}
								
							}
							if($finalwashers > 0){
								$response = ($finalwashers);		
								$code = 200;
								$message = 'success';
							}else{
								$code = 301;
								$error = 'No washer found!';
							}
						}else{
							$code = 300;
							$error = 'No record found!';
						}
						break;
					case "request":
						$washers = array();
                                                
						$points = $actionn['points'];
						$vehicle_type = intval($actionn['vehicle_type']);
						$service_type = intval($actionn['service_type']);
						$requestData = array(
							'user_id' => $actionn['user_id'], 
							'vehicle_type' => $vehicle_type,
							'service_type' => $service_type,
							'points' => $points,
							'client_meta_data_id' => $actionn['client_meta_data_id'],
							'vehicle_name'=>$actionn['vehicle_name']?$actionn['vehicle_name']:'',
							'vehicle_make'=>$actionn['vehicle_make']?$actionn['vehicle_make']:'',
							'vehicle_model'=>$actionn['vehicle_model']?$actionn['vehicle_model']:'',
							'vehicle_model_year'=>$actionn['vehicle_year']?$actionn['vehicle_year']:'',
							'vehicle_color'=>$actionn['vehicle_color']?$actionn['vehicle_color']:''
						);
						
						$requestId = $this->Api_model->request($requestData, $actionn['user_id'],$points);
						
						if($requestId){

							$carinfo=array(
							'customer_id'=>$actionn['user_id'],
							'vehicle_name'=>$actionn['vehicle_name']?$actionn['vehicle_name']:'',
							'vehicle_make'=>$actionn['vehicle_make']?$actionn['vehicle_make']:'',
							'vehicle_model'=>$actionn['vehicle_model']?$actionn['vehicle_model']:'',
							'vehicle_model_year'=>$actionn['vehicle_year']?$actionn['vehicle_year']:'',
							'vehicle_color'=>$actionn['vehicle_color']?$actionn['vehicle_color']:''
								);
							
							$this->Api_model->updateclientmetadataid($actionn['user_id'], $actionn['client_meta_data_id']);
							$this->Api_model->add_mycar_info($carinfo);
							$uaData = array(
								'user_id' => $actionn['user_id'], 
								'transaction_type' => 1,
								'is_transaction_settled' => 0,
								'client_request_id' => $requestId,
								'points' => $points
							);
							$this->Api_model->useraccountdata($uaData, $requestId);
							if(count($actionn['users']) > 0){
								for($w=0;$w<count($actionn['users']);$w++){
									// check if washer verified
									if($this->Api_model->is_washer_verified($actionn['users'][$w]['user_id']) == false){
										$response = false;		
										$code = 300;
										$message = false;
									}else{
										$responseData = array(
											'client_request_id' => $requestId, 
											'user_id' => $actionn['users'][$w]['user_id']
										);
										$responseId = $this->Api_model->add_response($responseData);
										$username = $this->Api_model->getusername($responseData['user_id']);
										$tokan = $this->Api_model->sdschecktokan($responseData['user_id']);
										$this->Api_model->sendnotification($tokan, $username." - New job created for you");
									}
								}
								
								//$response = $tokan;		
								$response = (count($actionn['users']));		
								$code = 200;
								$message = $requestId;
							}else{
							        $tokan = $this->Api_model->sdschecktokan($actionn['user_id']);
								$this->Api_model->sendnotification($tokan, "Sorry, no washer found nearby your location.");
								$code = 301;
								$error = 'No washer found';
							}
							
						}
						break;
					case "response":
						$arr = $this->Api_model->getresponse();
						$requestCount = count($arr);
						if($arr > 0){
							$response = array('count' => $requestCount);		
							$code = 200;
							$message = 'success';
						}else{
							$code = 300;
							$error = 'No response found!';
						}
						break;
					case "totalwash":
						$ar = array();
						$requests = $this->Api_model->getwashcount($actionn['user_id']);
						if($requests != false){
							//foreach($requests as $r){
								//$ar['bikewash'] = $r->bikewash;
								$ar['bikewash'] = 0;
								$ar['carwash'] = count($requests);
								$ar['totalwash'] = 0;
								//$ar['totalwash'] = $r->totalwash;
							//}
							$response = ($ar);		
							$code = 200;
							$message = 'success';
						}else{
							$ar['bikewash'] = 0;
							$ar['carwash'] = 0;
							$ar['totalwash'] = 0;
							$response = ($ar);
							$code = 300;
							$message = 'empty';
						}
						break;
					case 'checkpaymentstatus':
								$status = $this->Api_model->checkstatus_payment($actionn['user_id']);
								if($status == false){
									$response = array('payment_status' => false);
									$code = 300;
									$message = false;
									$error = 'Payment method not exists!';
								}else{
									$response = array('payment_status' => true, 'data' => $status);
									$code = 200;
									$message = true;
								}	
								break;
								/*@mkcode start*/
								case 'addpaymentmethod':
									if(isset($actionn['user_id']))
									{
									$cardnumber = isset($actionn['cardnumber']) ? $actionn['cardnumber'] : "";
									$type = $this->Api_model->validatecard($cardnumber);
									switch($type){
										case "visa" :
											$paymenttype = "visa";
											break;
										case "mastercard" :
											$paymenttype = "mastercard";
											break;
										case "amex" :
											$paymenttype = "amex";
											break;
										case "discover" :
											$paymenttype = "discover";
											break;
										case "unknown" :
											$paymenttype = "unknown";
											break;
									}

									if($paymenttype == "unknown"){
										$code = 300;
										$error = 'Cardnumber not valid!';
										$msg = 'false';
									}else{
												$month = isset($actionn['xpirymonth']) ? $actionn['xpirymonth'] : "";
												$year = isset($actionn['year']) ? $actionn['year'] : "";
												
												$cvv = isset($actionn['cvv']) ? $actionn['cvv'] : "";
												$xpiry = $month.'/'.$year;
												$country = isset($actionn['country']) ? $actionn['country'] : "";
												
														
													   $details=json_encode(array(
													   			"number"=>"$cardnumber",
																"type"=>$paymenttype,
																"expire_month"=>$month,
																"expire_year"=>$year,
																"cvv2"=>"$cvv",
																"first_name"=>$actionn['card_name'],
																"external_customer_id"=>$actionn['user_id']
													   	));
											   $stat=$this->Api_model->check_card_exist($cardnumber,$actionn['user_id']);
											   if($stat==false)
											   { 
											      	//new card
													   $access_token=$this->get_access_token();
													   if($access_token!='')
													   {

													   $curl2 = curl_init();
													   $url=$this->paypal_url."/v1/vault/credit-cards/";
														curl_setopt_array($curl2, array(
														  CURLOPT_URL => "$url",
														  CURLOPT_RETURNTRANSFER => true,
														  CURLOPT_ENCODING => "",
														  CURLOPT_MAXREDIRS => 10,
														  CURLOPT_TIMEOUT => 30,
														  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
														  CURLOPT_CUSTOMREQUEST => "POST",
														  CURLOPT_POSTFIELDS => $details,
														  CURLOPT_HTTPHEADER => array("Content-Type: application/json","Authorization: Bearer ".$access_token)
														));

														$responsedata = curl_exec($curl2);
														$err = curl_error($curl2);
														curl_close($curl2);
														if ($err)
														{
														 	$response = array('paymentmethod' => false);
																$code = 300;
																$msg = 'Something is wrong, please try again later!';

														} else {
														  if($responsedata)
														  {
														  	 
														  		$x=json_decode($responsedata);
															  	$card_id=$x->id;
															  	$data=array(
															  		"user_id"=>$actionn['user_id'],
															  		"card_type"=>$paymenttype,
															  		"card_number"=>$cardnumber,
															  		"card_id"=>$card_id,
															  		'payment_mode' => "card",
												                    'type' => $actionn['type']
															  		);
															  	$rw2 = $this->Api_model->savecard($data);
																if($rw2){
																	$this->Api_model->defaultmethod($actionn['user_id'], "addcard");
																	$this->Api_model->payment_status_update($actionn['user_id']);
																	
																	$response = array('paymentmethod' => true);		
																	$code = 200;
																	$msg = 'Credit Card Details Saved!';
																}else{
																	$response = array('paymentmethod' => false);
																	$code = 300;
																	$msg = 'Card details not valid!';
																}
														  }
														  else
														  {
														  	$response = array('paymentmethod' => false);
																$code = 300;
																$msg = 'Something is wrong, please try again later!';
														  }
														}
												}
												else
												{
														$response = array('paymentmethod' => false);
																$code = 300;
																$msg = 'Access token not found, please try again later!';
												}
											}
											else
											{
															$response = array('paymentmethod' => false);
																$code = 300;
																$msg = 'Card details already exist!!';
											}

										}
									}
										$response = ($response);		
										$code = $code;
										$message = $msg;
										$error = $error;
								break;

								case 'deletecard':
								$card_id = $actionn['card_id'];
								$access_token=$this->get_access_token();
									if(!empty($access_token))
									{
										$url=$this->paypal_url."/v1/vault/credit-cards/$card_id";
										$curl = curl_init();
										curl_setopt_array($curl, array(
										  CURLOPT_URL => "$url",
										  CURLOPT_RETURNTRANSFER => true,
										  CURLOPT_ENCODING => "",
										  CURLOPT_MAXREDIRS => 10,
										  CURLOPT_TIMEOUT => 30,
										  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										  CURLOPT_CUSTOMREQUEST => "DELETE",
										  CURLOPT_HTTPHEADER => array(
										   "Authorization: Bearer ".$access_token,
										  ),
										));

										$responsedata = curl_exec($curl);
										$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
										$err = curl_error($curl);
										curl_close($curl);

										if ($err) {
										 
										  			$response = false;
													$code = 300;
													$error = 'Error';
										} else {
												$carddata = $this->Api_model->deletepayment_method($actionn['user_id'],$actionn['delete_type']);
												if($carddata == true){
													$response = true;		
													$code = 200;
													$message = 'success';
												}else{
													$response = false;
													$code = 300;
													$error = 'Error';
												}
										}
									}
									else
									{
												$response = false;
													$code = 300;
													$error = 'Error';
									}

						break;

						case 'getcarddata':
						
						$payer_email = "";
						$paymentData = array();
						$carddata = $this->Api_model->getuserCardDetails($actionn['user_id']);
						if($carddata!='')
						{
							
							$paymentData['card_type'] = $carddata->card_type;
							$paymentData['card_id'] = $carddata->card_id;
							$paypaldata = $this->Api_model->getusertokens($actionn['user_id']); 
							$paymentData['payerinfo'] = ($paypaldata != false) ? $this->Api_model->checkpaymentstatus_customer($actionn['user_id']) : "NULL";
							$defaultmethod = $this->Api_model->getdefaultmethod($actionn['user_id']);
							$data = $this->Api_model->getpaypalEmail($actionn['user_id']); 
							$paymentData['default_method'] = ($defaultmethod != "")?$defaultmethod:"NULL";
							if(!empty($carddata)){
								$card_number=str_replace("+","",$carddata->card_number);  
								$paymentData['card_number']=str_repeat("x", (strlen($card_number) - 8)) . substr($card_number,-4,4); 
							}else{
								$paymentData['card_number'] = "NULL";
							}
						}
						else
						{
							$paypaldata = $this->Api_model->getusertokens($actionn['user_id']); 
							$paymentData['payerinfo'] = ($paypaldata != false) ? $this->Api_model->checkpaymentstatus_customer($actionn['user_id']) : "NULL";
							$defaultmethod = $this->Api_model->getdefaultmethod($actionn['user_id']);
							$data = $this->Api_model->getpaypalEmail($actionn['user_id']); 
							$paymentData['default_method'] = ($defaultmethod != "")?$defaultmethod:"NULL";
							$paymentData['card_number'] = "NULL";
							$paymentData['card_type'] ="NULL";
							$paymentData['card_id'] = "NULL";

						}
						$response = ($paymentData);		
						$code = 200;
						$message = true; 
						break;

						/*@mkcode end*/

					/* --------old code-----------
					case 'addpaymentmethod':
						if(isset($actionn['user_id'])){
							$cardnumber = isset($actionn['cardnumber']) ? $actionn['cardnumber'] : "";
							$type = $this->Api_model->validatecard($cardnumber);
							switch($type){
								case "visa" :
									$paymenttype = "visa";
									break;
								case "mastercard" :
									$paymenttype = "mastercard";
									break;
								case "amex" :
									$paymenttype = "amex";
									break;
								case "discover" :
									$paymenttype = "discover";
									break;
								case "unknown" :
									$paymenttype = "unknown";
									break;
							}
							
							if($paymenttype == "unknown"){
								$code = 300;
								$error = 'Cardnumber not valid!';
								$msg = 'false';
							}else{
								$month = isset($actionn['xpirymonth']) ? $actionn['xpirymonth'] : "";
								$year = isset($actionn['year']) ? $actionn['year'] : "";
								
								$cvv = isset($actionn['cvv']) ? $actionn['cvv'] : "";
								$xpiry = $month.'/'.$year;
								$country = isset($actionn['country']) ? $actionn['country'] : "";
								
								$data = array(
									'user_id' => $actionn['user_id'],
									'card_type' => $paymenttype,
									'card_number' => $cardnumber,
									'expiry_year' => $year,
									'expiry_month' => $month,
									'cvv' => $cvv,
									'country' => $country,
									'card_name' => $actionn['card_name'],
									'payment_mode' => "card",
									'type' => $actionn['type']
								);
								$rw2 = $this->Api_model->savecard($data);
								if($rw2){
									$this->Api_model->defaultmethod($actionn['user_id'], "addcard");
									$this->Api_model->payment_status_update($actionn['user_id']);
									$response = array('paymentmethod' => true);		
									$code = 200;
									$msg = true;
								}else{
									$response = array('paymentmethod' => false);
									$code = 300;
									$msg = 'Card details not valid!';
								}
							}
						}
						$response = ($response);		
						$code = $code;
						$message = $msg;
						$error = $error;
						break;
					case 'deletecard':
						$deletetype = $actionn['delete_type'];
						$carddata = $this->Api_model->deletepayment_method($actionn['user_id'],$deletetype);
						if($carddata == true){
							$response = true;		
							$code = 200;
							$message = 'success';
						}else{
							$response = false;
							$code = 300;
							$error = 'Error';
						}
						break;
					case 'getcarddata':
						$paymentData = array();
						$payer_email = "";
						$carddata = $this->Api_model->getuserCardDetails($actionn['user_id']);
						$paypaldata = $this->Api_model->getusertokens($actionn['user_id']); 
						$paymentData['payerinfo'] = ($paypaldata != false) ? $this->Api_model->checkpaymentstatus_customer($actionn['user_id']) : "NULL";
						$defaultmethod = $this->Api_model->getdefaultmethod($actionn['user_id']);
						$data = $this->Api_model->getpaypalEmail($actionn['user_id']); 
						$paymentData['default_method'] = ($defaultmethod != "")?$defaultmethod:"NULL";
						if(!empty($carddata)){
							$card_number=str_replace("+","",$carddata->card_number);  
							$paymentData['card_number']=str_repeat("x", (strlen($card_number) - 8)) . substr($card_number,-4,4); 
						}else{
							$paymentData['card_number'] = "NULL";
						}
						$response = ($paymentData);		
						$code = 200;
						$message = true; 
						break;
						

					case 'cardpayment':
						$paymentData = array();					
						$price = $actionn['amount'];
						$userid = $actionn['user_id'];
						$rid = $actionn['client_request_id'];
						$carddata = $this->Api_model->getuserCardDetails($userid);
						
						$firstName = urlencode($carddata->first_name);
						$lastName = urlencode($carddata->last_name);
						$address = urlencode($carddata->location);
						
						$card_number = urlencode($carddata->card_number);
						$cardtype = urlencode($carddata->card_type);
						$expMonth = urlencode($carddata->expiry_month);
						$expYear = urlencode($carddata->expiry_year);
						$cvv = urlencode($carddata->cvv);
						$expirationDate = $expMonth.$expYear;
						
						$paymentData['amount'] = $price;
						
						$productDetail = $this->Api_model->getservicdetail($actionn['client_request_id']);
						switch($productDetail->service_type){
							case "0":
								$snm = "Elite";
								break;
							case "1":
								$snm = "Premium";
								break;
							case "2":
								$snm = "Standard";
								break;
							case "3":
								$snm = "Fast";
								break;
						}
						
						switch($productDetail->vehicle_type){
							case "0":
								$vtyp = "small";
								break;
							case "1":
								$vtyp = "medium";
								break;
							case "2":
								$vtyp = "big";
								break;
						}
						
						$requestParams = array(
							'IPADDRESS' => $_SERVER['REMOTE_ADDR'],          // Get our IP Address
							'PAYMENTACTION' => 'Sale'
						);
						$creditCardDetails = array(
							'CREDITCARDTYPE' => urlencode($carddata->card_type),
							'ACCT' => $card_number,
							'EXPDATE' => $expirationDate,       // Make sure this is without slashes (NOT in the format 07/2017 or 07-2017)
							'CVV2' => $cvv
						);
						$payerDetails = array(
							'FIRSTNAME' => $firstName,
							'LASTNAME' => $lastName,
							'COUNTRYCODE' => 'US'
						);
						$orderParams = array(
							'AMT' => $price,              // This should be equal to ITEMAMT + SHIPPINGAMT
							'ITEMAMT' => $price,
							'CURRENCYCODE' => 'USD'       // USD for US Dollars
						);
						$item = array(
							'L_NAME0' => $snm,
							'L_DESC0' => $vtyp,
							'L_AMT0' => $price,
							'L_QTY0' => '1'
						);
						
						$responses = $this->creditcard->request('DoDirectPayment',$requestParams + $creditCardDetails + $payerDetails + $orderParams + $item);
						if( is_array($responses) && $responses['ACK'] == 'Success') { // Payment successful
							// We'll fetch the transaction ID for internal bookkeeping
							$transactionId = $responses['TRANSACTIONID'];
							$washer_response_id = $this->Api_model->getwasherresponseID($actionn['client_request_id']);
							$washerid = $this->Api_model->getwasherID($washer_response_id);
							$tokan = $this->Api_model->sdschecktokan($washerid);
							$this->Api_model->sendnotification($tokan, "Great! Job done successfully.Payment done from customer end.");
							$paymentData['payment_type'] = 0;
							$paymentData['user_id'] = $actionn['user_id'];
							$paymentData['transaction_id'] = $transactionId;
							$paymentData['washer_response_id'] = $washer_response_id;
							$paymentData['client_request_id'] = $actionn['client_request_id'];
							$paymentData['payment_status'] = 1;
							$this->Api_model->addorder($paymentData);
							$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 1);
							$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 1,1);
							$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	1);
							$response = ($responses);		
							$code = 200;
							$message = 'success';
						}
						else
						{
							$washer_response_id = $this->Api_model->getwasherresponseID($actionn['client_request_id']);
							$paymentData['user_id'] = $actionn['user_id'];
							$paymentData['payment_type'] = 0;
							$paymentData['transaction_id'] = '0000000000000';
							$paymentData['washer_response_id'] = $washer_response_id;
							$paymentData['client_request_id'] = $actionn['client_request_id'];
							$paymentData['payment_status'] = 2;
							$this->Api_model->addorder($paymentData);
							$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 	2);
							$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 0,0);
							$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	0);
							// $this->Api_model->paymentfailnotification($usertype,$requestid,$amount){
							$response = ($responses);		
							$code = 300;
							$error = 'failure';
						}
						break;

						*/

					case 'cardpayment':
						$paymentData = array();					
						$price = $actionn['amount'];
						$userid = $actionn['user_id']; //client id
						$rid = $actionn['client_request_id'];
						
						$carddata = $this->Api_model->getuserCardDetails($userid);
						//$firstName = urlencode($carddata->first_name);
						//$lastName = urlencode($carddata->last_name);
						//$address = urlencode($carddata->location);
						if(!empty($carddata))
						{
								$card_id = $carddata->card_id;
								$cardtype = urlencode($carddata->card_type);
								// $expMonth = urlencode($carddata->expiry_month);
								// $expYear = urlencode($carddata->expiry_year);
								// $cvv = urlencode($carddata->cvv);
								// $expirationDate = $expMonth.$expYear;
								$productDetail = $this->Api_model->getservicdetail($actionn['client_request_id']);
								switch($productDetail->service_type){
									case "0":
										$snm = "Elite";
										break;
									case "1":
										$snm = "Premium";
										break;
									case "2":
										$snm = "Standard";
										break;
									case "3":
										$snm = "Fast";
										break;
								}
								
								switch($productDetail->vehicle_type){
									case "0":
										$vtyp = "small";
										break;
									case "1":
										$vtyp = "medium";
										break;
									case "2":
										$vtyp = "big";
										break;
								}
								
								$vehicle_name=$productDetail->vehicle_name;
								$vehicle_make=$productDetail->vehicle_make;
								$vehicle_model=$productDetail->vehicle_model;
								$vehicle_model_year=$productDetail->vehicle_model_year;
								$vehicle_color=$productDetail->vehicle_color;
								$payidnum=md5(uniqid(rand(), true));
								$mainarray=json_encode(array(
								  'id' => "CPPAY-$payidnum",
								  'intent' => 'sale',
								  'payer' => 
									  array (
									    'payment_method' => 'credit_card',
									    'funding_instruments' => 
									    array (0 => array (
									        'credit_card_token' =>array (
									          'credit_card_id' => "$card_id",
									          'external_customer_id' =>$userid,
									        ),
									      ),
									    ),
									  ),
								  'transactions' => array (0 =>array (
								  	'amount' => 
								      array (
								        'total' => "$price",
								        'currency' => 'USD',
								      ),
								      'description' => 'Payment by vaulted credit card@mkfastpay.',
								      'item_list' => array ('items' => array (0 => array(
														"name"=>"$vehicle_name Order(Request id:$rid)",
														"price"=>"$price",
														"currency"=>"USD",
														"quantity"=>"1",
														"description"=>"$vehicle_name Order(Request id:$rid)"
													),
								        ),
								      ),
								    ),
								),
							));

						$paymentData['amount'] = $price;
						$access_token=$this->get_access_token();
						if(!empty($access_token))
						{
							 $ch = curl_init();
							 $url=$this->paypal_url."/v1/payments/payment";
							curl_setopt_array($ch, array(
							  CURLOPT_URL => "$url",
							  CURLOPT_RETURNTRANSFER => true,
							  CURLOPT_ENCODING => "",
							  CURLOPT_MAXREDIRS => 10,
							  CURLOPT_TIMEOUT => 30,
							  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							  CURLOPT_CUSTOMREQUEST => "POST",
							  CURLOPT_POSTFIELDS => $mainarray,
							  CURLOPT_HTTPHEADER => array("Content-Type: application/json","Authorization: Bearer ".$access_token)
							));

							$responsedata = curl_exec($ch);
							$err = curl_error($ch);
							curl_close($ch);
							if(empty($responsedata))
							{
								$response ='';		
								$code = 300;
								$message = 'failure';
							}
							else
							{
							    $json = json_decode($responsedata);
							    if(($json->state=='approved') || ($json->state=='created'))
							    {
									 $transactionId = $json->id;
									$washer_response_id = $this->Api_model->getwasherresponseID($actionn['client_request_id']);
									$washerid = $this->Api_model->getwasherID($washer_response_id);
									$tokan = $this->Api_model->sdschecktokan($washerid);
									$notif_msg=$this->Api_model->sendnotification($tokan, "Great! Job done successfully.Payment done from customer end.");
									$paymentData['sale_id']=$json->transactions[0]->related_resources[0]->sale->id;
									$paymentData['payment_type'] = 0;
									$paymentData['user_id'] = $actionn['user_id'];
									$paymentData['transaction_id'] = $transactionId;
									$paymentData['washer_response_id'] = $washer_response_id;
									$paymentData['client_request_id'] = $actionn['client_request_id'];
									$paymentData['payment_status'] = 1;
									$this->Api_model->addorder($paymentData);
									$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 1);
									$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 1,1);
									$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	1);
							    	
							   		$response ='';		
									$code = 200;
									$message = 'success';
								}
								else
								{
									$washer_response_id = $this->Api_model->getwasherresponseID($actionn['client_request_id']);
									$paymentData['user_id'] = $actionn['user_id'];
									$paymentData['payment_type'] = 0;
									$paymentData['transaction_id'] = '0000000000000';
									$paymentData['washer_response_id'] = $washer_response_id;
									$paymentData['client_request_id'] = $actionn['client_request_id'];
									$paymentData['payment_status'] = 2;
									$this->Api_model->addorder($paymentData);
									$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 	2);
									$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 0,0);
									$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	0);
									// $this->Api_model->paymentfailnotification($usertype,$requestid,$amount){
									$response ='Transaction has been failed';		
									$code = 300;
									$message = 'failure';
								}
							}
						}
						else
						{

								$response =null;		
								$code = 300;
								$error = 'failure';	
						}
					}
					else
					{
								$response ='Credit card does not exist';		
								$code = 300;
								$error = 'failure';	
					}
					break;

					case "washernotification":
						$notifications = $this->Api_model->getwasherNotification($actionn['user_id']);
						if(count($notifications)>0){
							$response = ($notifications);		
							$code = 200;
							$message = 'success';
						}else{
							$code = 300;
							$error = 'Zero notification!';
						}
						break;
					case "washerhistory":
						$notifications = $this->Api_model->washerhistory($actionn['user_id']);
						if(count($notifications)>0){
							$response = ($notifications);		
							$code = 200;
							$message = 'success';
						}else{
							$code = 300;
							$error = 'Zero notification!';
						}
						break;
					case 'washerdetails':
						$response = $this->Api_model->getwasherdetls($actionn['client_request_id']);
						if($response != false){
							$response = $response;
							$code = 200;
							$message = true;
						}else{
							$response = false;
							$code = 200;
							$message = false;
						}
						break;
					case 'cutomerdetails':
						$response = $this->Api_model->getcustomerdetls($actionn['client_request_id']);
						if($response != false){
							$response = $response;
							$code = 200;
							$message = true;
						}else{
							$response = false;
							$code = 200;
							$message = false;
						}
						break;
					case "updatewasherresponse":
						if($actionn['is_washer_accepted'] == 1){ 
							$d = $this->Api_model->checkresponse($actionn['client_request_id']);
							$clientid = $this->Api_model->getclientID($actionn['client_request_id']);
							$washerid = $this->Api_model->getwasherID($actionn['washer_response_id']);
							$username = $this->Api_model->getusername($washerid);
							$tokan = $this->Api_model->sdschecktokan($clientid);
							$this->Api_model->sendnotification($tokan, "Job has been accepted by washer named ". $username);
							if(count($d) > 0){
								if($d[0]->is_request_open == 0){
									$washerdetails=$this->Api_model->updateWresponse1($actionn['washer_response_id'],$washerid, 1);
									$this->Api_model->requestClose($actionn['client_request_id'], 1);
									$this->Api_model->allrequestclose($actionn['client_request_id'], $actionn['user_id']);
									$arr = $this->Api_model->getallwashersclosed();
									foreach($arr as $washers){
										$tokan = $this->Api_model->sdschecktokan($washers->user_id);
										$this->Api_model->sendnotification($tokan, "Job has been closed! Accepted by someone else!");
									}
									$response=$washerdetails;
									$code = 200;
									$message = 'success';
								}else{
									$requestClose = $this->Api_model->updateWresponse1($actionn['washer_response_id'],$washerid, 3);
									$response = ($requestClose);		
									$code = 301;
									$message = 'May reuqest has been closed or hired some one else!';
								}
							}else{		
								$code = 300;
								$error = 'No request found!';
							}
						}else{
							$update = $this->Api_model->updateWresponse($actionn['washer_response_id'], 2);
							$response = ($update);		
							$code = 200;
							$message = 'Success!';
						}
						break;
						
					case "getclientrequest":
						$arr = $this->Api_model->getclientrequest($actionn['client_request_id']);
						if(count($arr) > 0){
							$response = ($arr);		
							$code = 200;
							$message = 'success';
						}else{
							$code = 300;
							$error = 'No request found!';
						}
						break;
					case "allclientrequest":
						$arr = $this->Api_model->getallrequests($actionn['user_id']);
						$response = ($arr);		
						$code = 200;
						$message = 'success';
						break;
						
					case "clientrequestdetail":
						$arr = $this->Api_model->clientrequestdetail($actionn['client_request_id']);
						if($arr != false){
							$response = ($arr);		
							$code = 200;
							$message = 'success';
						}else{
							$response = false;		
							$code = 300;
							$message = 'NULL';
						}
						break;
					case "getservices":
						$arr = $this->Service_model->services();
						$response = ($arr);		
						$code = 200;
						$message = 'success';
						break;
					// case "addpoints":
						// $pointsArr = array( 
							// 'user_id' => $actionn['user_id'],
							// 'points' => $actionn['points'], 
							// 'transaction_id' => $actionn['transaction_id'],
							// 'environment' => $actionn['environment'], 
							// 'transaction_status' => $actionn['transaction_status']
						// );
						// $arr = $this->Api_model->addpoints($pointsArr,$actionn['user_id'],$actionn['points']);
						// if($arr == false){
							// $code = 300;
							// $error = 'Access Denied!';
						// }else{
							// $response = true;		
							// $code = 200;
							// $message = 'success';
						// }
						// break;
					case "getpointslist":
						$arr = $this->Api_model->getpoints();
						$response = ($arr);		
						$code = 200;
						$message = 'success';
						break;
					case "getpoints":
						$arr = $this->Api_model->getpointsbyUid($actionn['user_id']);
						$response = ($arr);		
						$code = 200;
						$message = 'success';
						break;
					case 'updatelocation': 
						$data = array( 
							'latitude' => $actionn['latitude'], 
							'longitude' => $actionn['longitude'],
						);
						$arr = $this->Api_model->update_location($data,$actionn['user_id']);
						$response = ($arr);		
						$code = 200;
						$message = 'Location Updated Successfully';							
						break;
					case 'pushnotifications':
						$message = $actionn['message']; 
						$tokan = $this->Api_model->sdschecktokan($actionn['user_id']);
						$id = $tokan;
						
						$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		
						// $fields = array(
							// 'to' => $id,
							// 'notification' => array('title' => 'Working Good', 'body' => 'That is all we want'),
							// 'data' => array('message' => $message)
						// );
						
						/*$fields = array (
								'registration_ids' => array ($id),
								'data' => array ("message" => $message)
						);
                        */
	
				 	
				 		$fields = array (
						        'to' => $id,
						        'notification' => array (
						                "body" => $message,
						                "title" => "Working heading"
						        )
						);
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
					   
						curl_close($ch);
						
						$response = array($result);		
						$code = 200;
						break;
					case 'sendpushnotification':
						$message = $actionn['message']; 
						$id = $actionn['tokan'];
						
						$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		
						// $fields = array(
							// 'to' => $id,
							// 'notification' => array('title' => 'Working Good', 'body' => 'That is all we want'),
							// 'data' => array('message' => $message)
						// );
						
						// $fields = array (
						// 		'registration_ids' => array (
						// 				$id
						// 		),
						// 		'data' => array (
						// 				"message" => $message
						// 		)
						// );
				 		$fields = array (
						        'to' => $id,
						        'notification' => array (
						                "body" => $message,
						                "title" => "Working heading"
						        )
						);
					/*	$headers = array(
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
					   
						curl_close($ch);
						
						$response = array($result);		
						$code = 200;
						break;
					case 'getLocationHistory':
						$arr = $this->Api_model->getlocationhistory($actionn['user_id'], $actionn['client_request_id']);
						$response = ($arr);		
						$code = 200; 
						$message = 'success';
						break;
					case 'saveLocationHistory':
						$locationData = array( 
							'user_id' => $actionn['user_id'],
							'latitude' => $actionn['latitude'], 
							'longitude' => $actionn['longitude']
						);
						$arr = $this->Api_model->addlocationhistory($locationData, $actionn['user_id']);
						if($arr == true){
							$response = true;		
							$code = 200;
							$message = 'success';
						}else{
							$response = false;		
							$code = 300;
							$error = 'error';
						}
						break;
					case 'updatedevicetokan':
						$uid = $actionn['user_id'];
						$data = array(
							'device_type' => $actionn['device_type'],
							'device_token' => $actionn['device_token']
						);
						$arr = $this->Api_model->updatedevicetokan($data, $uid);
						if($arr == true){
							$response = true;		
							$code = 200;
							$message = 'success';
						}else{
							$error = false;		
							$code = 300;
						}
						break;
					case 'checktokan':
						$uid = $actionn['user_id'];
						$arr = $this->Api_model->getallwashersclosed();
						if(count($arr) > 0){
							$response = $arr;		
							$code = 200;
							$message = 'success';
						}else{
							$error = false;		
							$code = 300;
						}
						break;
					case 'cancelrequest':
						$cancelby = "";
						$client_request_id = $actionn['client_request_id'];
						if(isset($actionn['cancelby'])){
							$cancelby = $actionn['cancelby'];
						}
						if($cancelby == "washer"){
							$arr = $this->Api_model->cancel_request($client_request_id,"washer");
						}else if($cancelby == "customer"){
							$arr = $this->Api_model->cancel_request($client_request_id,"customer");
						}else{
							$arr = $this->Api_model->cancel_request($client_request_id,0);
						}
						$response = "Success";		
						$code = 200;
						$message = 'success';
						
						break;
					case 'updaterequeststatus':
						$ratingdata = [];
						$client_request_id = $actionn['client_request_id'];
						$userid = $actionn['user_id'];
						$status = $actionn['number'];
						if($status=='7')
						{
							$this->Api_model->jobstatus($client_request_id,$userid,$rate=0);
						}
						
						if(isset($actionn['washer_rating']) && isset($actionn['washer_comment']))
						{
							$ratingdata['washer_rating'] = $actionn['washer_rating'];
							$ratingdata['washer_comment'] = $actionn['washer_comment'];
							$arr = $this->Api_model->update_requestStatus($client_request_id, $userid, $status,$ratingdata);
							$response = true;		
							$code = 200;
							$message = true;
							
						}else if(isset($actionn['customer_rating']) && isset($actionn['customer_comment'])){
							
							$ratingdata['customer_rating'] = $actionn['customer_rating'];
							$ratingdata['customer_comment'] = $actionn['customer_comment'];
							$arr = $this->Api_model->update_requestStatus1($client_request_id, $userid, $status,$ratingdata);

							$response = $arr;		
							$code = 200;
							$message = true;
								
						}else{
							$arr = $this->Api_model->update_requestStatus($client_request_id, $userid, $status,0);
							$response = true;		
							$code = 200;
							$message = true;
						}
						
						break;
					case 'isjobcompleted':
						$client_request_id = $actionn['client_request_id'];
						$user_id = $actionn['user_id'];
						$arr = $this->Api_model->jobstatus($client_request_id,$user_id,$rate=0);
						$requestData = $this->Api_model->getrequerstamount($client_request_id);
						if($requestData){
							$response = true;
							$error = false;
							$message = true;
							$code = 200;
						}else{
							$response = false;
							$error = false;
							$message = false;
							$code = 301;
						}						
						break;
					case 'setrating':
						$client_request_id = $actionn['client_request_id'];
						$user_id = $actionn['user_id'];
						$arr = $this->Api_model->jobstatus($client_request_id,$user_id, 0);
						$requestData = $this->Api_model->getrequerstamount($client_request_id);
						$washerid = $this->Api_model->getwasherdt($client_request_id);
						$tokan = $this->Api_model->sdschecktokan($washerid);
						$data = array(
							'user_id' => $actionn['user_id'],
							'client_request_id' => $client_request_id,
							'rate' => $actionn['rate'],
							'comment' => $actionn['comment']
						);
						$rating = $this->Api_model->saverating($data);
						if($rating == true){
							$this->Api_model->sendnotification($tokan, "Congratulations! You got".$actionn['rate']." star rating from ".$this->Usermodel->GetUserbyId($actionn['user_id']). "!");
							$response = array('amount' => $requestData->amount);
							$error = false;
							$message = true;
							$code = 200;
						}else{
							$response = array('amount' => 'NULL');
							$error = false;
							$message = false;
							$code = 301;
						}						
						break;
					case 'userdetails':
						$userID = $actionn['user_id'];
						$arr = $this->Api_model->getuserData($userID);
						if(count($arr) > 0){
							$response = array($arr);	
							$code = 200;
							$message = 'success';
						}else{
							$error = false;		
							$code = 300;
						}
						break;
					case 'getuseraccounts':
						$userID = $actionn['user_id'];
						$arr = $this->Api_model->getDatawashmi($userID);
						if(count($arr) > 0){
							$response = array($arr);	
							$code = 200;
							$message = 'success'; 
						}else{
							$error = false;		
							$code = 300;
						}
						break;
					case 'userauthorization':
						
						/*-org

						$clientId = 'AbcHTHa-EN_3a0b6L_5KD9VUJgu5c9oZnd9GRzTZPB1HRpl1vxrfFl4dYye263X9qywmOAIsOtFrBBFV';
						$secret = 'EPpPvgaTprACPhkpYSTb1ZuUYJkUq5UtY6hM1ZW7zazQdIsrs2-1P1n_1YPYbyFBsyCv1W3SK9nr4hfn';*/
						
						$clientId="ARD4nYKFdo0p667pnwp3aRoTPvCVH0AUndiN7eGTBTFhbMMZJabEbk2CMwVYAyBXZdHnsNUsKhaqXlKQ";
						$secret="EEhelyFzRME7427TXa3p8HElLp818A3PIJQ-cNZBD6SsJL0Yb0qsgare-AbhVOh9YXIO0ytYOEvp02PN";
						$url=$this->paypal."/v1/oauth2/token";

						$ch = curl_init("$url");
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&response_type=token&redirect_uri=urn:ietf:wg:oauth:2.0:oob&code=".$actionn['code']);
						$response = curl_exec($ch);
						curl_close($ch);
						$json = json_decode($response);
						if($json->refresh_token){ 
							$this->Api_model->defaultmethod($actionn['user_id'], "authorization");
							$data = array(
								'user_id' => $actionn['user_id'],
								'access_token' => $json->access_token,
								'refresh_token' => $json->refresh_token,
								'payment_mode' => 'paypal',
								'authorized_code' => $actionn['code']
							); 
							$this->Api_model->saveauthorization($data);
							$this->Api_model->payment_status_update($actionn['user_id']);
							$message = true; 
							$code = 200;
							$response = ($json);
							$error = false;
						}else{
							$message = false;
							$code = 300;
							$response = ("Api Error!");
							$error = false;
						}
						break;
					case 'makepayment':
						$paymentData = array();
						$amount = $actionn['amount'];
						$tokendata = $this->Api_model->getusertokensPayment($actionn['user_id']);
						/*$clientId = 'AbcHTHa-EN_3a0b6L_5KD9VUJgu5c9oZnd9GRzTZPB1HRpl1vxrfFl4dYye263X9qywmOAIsOtFrBBFV';
						$secret = 'EPpPvgaTprACPhkpYSTb1ZuUYJkUq5UtY6hM1ZW7zazQdIsrs2-1P1n_1YPYbyFBsyCv1W3SK9nr4hfn';*/
						
						$clientId="ARD4nYKFdo0p667pnwp3aRoTPvCVH0AUndiN7eGTBTFhbMMZJabEbk2CMwVYAyBXZdHnsNUsKhaqXlKQ";
						$secret="EEhelyFzRME7427TXa3p8HElLp818A3PIJQ-cNZBD6SsJL0Yb0qsgare-AbhVOh9YXIO0ytYOEvp02PN";

						$refreshToken = $tokendata[0]->refresh_token; 


						$ch = curl_init($this->paypal_url.'/v1/oauth2/token');
						curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=refresh_token&refresh_token='.$refreshToken);
						$response = curl_exec($ch);
						curl_close($ch);
						$json1 = json_decode($response);
					 	
					   // echo '----'.$json1->access_token.'------------'.$_POST['id'];
						$ch = curl_init($this->paypal_url.'/v1/payments/payment');
						curl_setopt($ch, CURLOPT_HTTPHEADER, 
						array("Content-Type: application/json", 
						"PayPal-Client-Metadata-Id: ".$this->Api_model->get_client_metadata_id($actionn['user_id']),
					    //"PayPal-Client-Metadata-Id: ".$_POST['id'],
						"Authorization: Bearer ". $json1->access_token));
						
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, '{
						   "intent":"sale",
						   "payer":{
							  "payment_method":"paypal"
						   },
						   "transactions":[
							  {
								 "amount":{
										"currency":"USD",
										"total":"'.$amount.'"
									 },
									 "description":"Paid by client-Carwashmi"
								  }
							   ]
							}'
						);
						$response1 = curl_exec($ch);
						
						curl_close($ch);
						$json = json_decode($response1);
						$washer_response_id = $this->Api_model->getwasherresponseID($actionn['client_request_id']);
						$washer_id = $this->Api_model->getwasherID($washer_response_id);
						$payerinfo = serialize($json->payer);
						if($json->state=='approved'){
							$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 1,1);
							$this->Api_model->savepayerinfo($actionn['user_id'], $payerinfo);
							$paymentData['sale_id']=$json->transactions[0]->related_resources[0]->sale->id;
							$paymentData['payment_type'] = 1;
							$paymentData['user_id'] = $actionn['user_id'];
							$paymentData['washer_response_id'] = $washer_response_id;
							$paymentData['client_request_id'] = $actionn['client_request_id'];
							$paymentData['payment_status'] = 1;
							$paymentData['transaction_id'] = $json->id;
							$paymentData['transaction_date'] = $json->create_time;
							$paymentData['amount'] = $amount;
							$this->Api_model->addorder($paymentData);
							$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 1);
							$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	1);
							$error = false;
							$response = true;
							$message = true;
							$msg = 'Payment Successful! '.$json->state;
							$code = 200; 
						}else{
							$tokan = $this->Api_model->sdschecktokan($washer_id);
							$this->Api_model->sendnotification($tokan, "Customer payment failed! But you will paid by carwashmi for your service.");
							$this->Api_model->updateclientpaymentstatus($actionn['client_request_id'], 0,0);
							$paymentData['payment_type'] = 1;
							$paymentData['user_id'] = $actionn['user_id'];
							$paymentData['washer_response_id'] = $washer_response_id;
							$paymentData['client_request_id'] = $actionn['client_request_id'];
							$paymentData['payment_status'] = 2;
							$this->Api_model->addorder($paymentData);
							$this->Api_model->updateuser_paymentstatus($actionn['client_request_id'], 2);
							$this->Api_model->updatePaymentResponse($actionn['client_request_id'], 	0);
							$error = true;
							$response = false;
							$message = false;
							$msg = 'Payment Unsuccessful! '.$json->state;
							$code = 300; 
						}
						// $response = ($json);
						break;
					case 'getpaypalemail';
						$data = $this->Api_model->getpaypalEmail($actionn['user_id']);
						if($data != false){
							$d = unserialize($data);
							$message = true; 
							$code = 200;
							$resp = $d->payer_info;
							$response = str_repeat("x", (strlen($resp->email) - 12)) . substr($resp->email,-12,12);
							$error = false;
						}
						break;
					case 'defaultcard':
						$tru = $this->Api_model->updatemethod($actionn['user_id'],$actionn['default_type']);
						if($tru == true){
							$message = true; 
							$code = 200;
							$response = true;
							$error = false;
						}else{
							$message = false; 
							$code = 300;
							$response = false;
							$error = false;
						}
						break;
					case 'userblock':
						$tru = $this->Api_model->userblock($actionn['user_id']);
						if($tru == true){
							$message = true; 
							$code = 200;
							$response = array("user block" => true);
							$error = false;
						}else{
							$message = false; 
							$code = 300;
							$response = array("user block" => false);
							$error = false;
						}
						break;
					case 'paymentrequest':
						$data['washer_id'] = $actionn['user_id'];
						$data['washer_email'] = $this->Api_model->getuemail($actionn['user_id']);
						$data['user_name'] = $this->Api_model->getfirstnamelastname($actionn['user_id']);
						$data['totalamount'] = $this->Api_model->gettotalamount($actionn['user_id']);
						$data['link'] = base_url();
						$to = "info@carwashmi.com";
						$subject = 'Washer has request for payment';
						$headers = "From: ".$this->Api_model->getuemail($actionn['user_id'])."\r\n"; 
						$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						ob_start();
							$this->load->view('paymentrequest', $data);
						$mmm = ob_get_clean();
						$m = mail($to, $subject, $mmm, $headers);
						if($m){
							$response = array('status' => true, 'requested_amount' => $this->Api_model->gettotalamount($actionn['user_id']). " USD" );		
							$code = 200;
							$message = 'Request for payment sent successfuly';
						}else{
							$response = array('status' => false, 'requested_amount' => "0 USD" );
							$error = 'Error in send email!';		
							$code = 301;
						}
						break;
					case 'jobstarted':
						$requestID = $actionn['client_request_id'];
						$clientid = $this->Api_model->getclientID($requestID);
						$token = $this->Api_model->sdschecktokan($clientid);
						$message = "Congratulations, Washer started his job now!";
						$this->Api_model->sendnotification($token, $message);
						break;
					case 'userrating':
						$usID = $actionn['user_id'];
						$avragerating = $this->Api_model->getrating($usID);
						$message = true; 
						$code = 200;
						$response = array("average_rating" => $avragerating);
						$error = false;
						break;
					case 'getpriceofservice':
						$customer_id = $actionn['customer_id'];
						$vhicle_type = $actionn['vhicle_type'];
						$service_type = $actionn['service_type'];
						$amount = $this->Api_model->getserviceprice($service_type);
						$pricesArr = json_decode($amount->amount, true);
						$i = 0;
						foreach($pricesArr as $index => $indexval){
							if($vhicle_type == 0){
								$i = $pricesArr[0];
							}
							
							if($vhicle_type == 1){
								$i = $pricesArr[1];
							}
							
							if($vhicle_type == 2){
								$i = $pricesArr[2];
							}
						}

						$offer='';
						$netprice='';
						$result=$this->Api_model->available_promotion_list();
						if($result!='')
						{
							$available=true;
							$offer=$result[0]['offer'];
							if($result[0]['offer_in']=='%')
							{
								$discounted_amount=(($i*$result[0]['offer_price'])/100);
								$netprice=$i-$discounted_amount;
							}
							else
							{
								
								$netprice=$i-$result[0]['offer_price'];
							}
						}
						else
						{
							$available=false;
							$netprice=$i;
						}
						$is_cancellation_charge=$this->Api_model->is_cancellation_charge_pending($customer_id);
						/*if($is_cancellation_charge!='')
						{
							$netprice=$netprice+$is_cancellation_charge;
						}*/
						
						$message = true; 
						$code = 200;
			$response = array("service_price" => $i,"is_promotion_available"=>$available,'offer'=>$offer,"netprice"=>$netprice,'is_cancellation_charge'=>$is_cancellation_charge);
						$error = false;
						break;
                      
                      case 'testnotifications' :
						$tokan = $actionn['token'];
						$msg = $actionn['message'];
						$r = $this->Api_model->sendnotification($tokan, $msg);
						if(!empty($r)){
							$message = true; 
							$code = 200;
							$response = array("Push Responce" => $r);
							$error = false;
						}else{
							$message = true; 
							$code = 300;
							$response = array("Push Responce" => "Not working");
							$error = false;
						}
						break;

						case 'available_promotion_list':
									$result=$this->Api_model->available_promotion_list();
									if($result!='')
									{
										$message ='promotion available!!'; 
										$code = 200;
										$response =$result;
										$error = false;
									}
									else
									{
										$message ='no promotion available!!'; 
										$code = 300;
										$response =$result;
										$error = true;
									}
							break;

						case 'update_washer_location':
							$washer_id = $actionn['user_id'];
							$lat = $actionn['latitude'];
							$lng = $actionn['longitude'];
							$status=$this->Api_model->update_washer_location($washer_id,$lat,$lng);
							if($status)
							{
							   	$message = 'Washer location has been updated'; 
								$code = 200;
								$response ='';
								$error = false;
						    }
						    else
						    {
						    	$message = 'Unable to update washer location'; 
								$code = 300;
								$response ='';
								$error = true;
						    }
						    break;

						    case 'getdistancenow':
						    $lat_c=trim($actionn['c_lat']);
						    $lng_c=trim($actionn['c_lng']);
						    $lat_w=trim($actionn['w_lat']);
						    $lng_w=trim($actionn['w_lng']);
						    $resultt=$this->getdistancenow($lat_c,$lng_c,$lat_w,$lng_w);
						    //$resultt=$this->getdistancenow();
						    if($resultt)
						    {
						    	 	$message = 'distance data'; 
									$code = 200;
									$response =$resultt;
									$error = false;
						    }
						    else
						    {
						    		$message = 'No data found'; 
									$code = 300;
									$response ='';
									$error = true;
						    }	
						    break;

						    case 'my_car_list':
						    $resultt=$this->Api_model->get_mycar_list($actionn['user_id']);
						    if($resultt)
						    {
						    	
						    		$message = 'MY Car list'; 
									$code = 200;
									$response =$resultt;
									$error = false;	
						    }
						    else
						    {
						    		$message = 'No data found'; 
									$code = 300;
									$response ='';
									$error = true;
						    }
						    break;

						    case 'delete_car_details':
						      $resultt=$this->Api_model->delete_car_list($actionn['user_id'],$actionn['car_id']);
						    if($resultt==true)
						    {
						    		$message = 'Deleted successfully'; 
									$code = 200;
									$response =$resultt;
									$error = false;	
						    }
						    else
						    {
						    		$message = 'Unable to delete car details'; 
									$code = 300;
									$response =$resultt;
									$error = true;
						    }
						    break;

						    case 'add_mycar_info':
						    	if(!empty($actionn['user_id']) && !empty($actionn['vehicle_name']) && !empty($actionn['vehicle_make']) && !empty($actionn['vehicle_model']) && !empty($actionn['vehicle_year']) && !empty($actionn['vehicle_color']))
						    	{
							    	$carinfo=array(
											'customer_id'=>$actionn['user_id'],
											'vehicle_name'=>$actionn['vehicle_name']?$actionn['vehicle_name']:'',
											'vehicle_make'=>$actionn['vehicle_make']?$actionn['vehicle_make']:'',
											'vehicle_model'=>$actionn['vehicle_model']?$actionn['vehicle_model']:'',
											'vehicle_model_year'=>$actionn['vehicle_year']?$actionn['vehicle_year']:'',
											'vehicle_color'=>$actionn['vehicle_color']?$actionn['vehicle_color']:''
										);
								
									$status=$this->Api_model->add_mycar_info($carinfo);
									$message = 'Car details added successfully'; 
									$code = 200;
									$response =$status;
									$error = false;	
							    }
							    else
							    {
							    	$message = 'Please provide all required data'; 
									$code = 300;
									$response ='';
									$error = true;
							    }
						    break;

						     case 'getcarinfo':
						    	if(!empty($actionn['car_id']))
						    	{
									$car_id=$actionn['car_id'];
									$result=$this->Api_model->get_car_info($car_id);
									$message = 'Car details found'; 
									$code = 200;
									$response =$result;
									$error = false;	
							    }
							    else
							    {
							    	$message = 'Please provide car id'; 
									$code = 300;
									$response ='';
									$error = true;
							    }
						    break;
				}
				$arr = array('success'=> $message, 'code'=> $code, 'response'=> $response, 'error'=> $error);
				$response = json_encode($arr);
				echo $response;				
				die;
			}else{
				$message = "Access Denied To Use Api!";
				$arr = array('error'=> array('errorcode' => 404, 'reason' => $message) );
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
	
	function confirm(){
		$data['getparam'] = $_REQUEST;
		$this->load->view('confirm',$data);
	}
	
	function distance($lat1, $lon1, $lat2, $lon2, $unit) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

	function send_mail($to, $subject, $message)
	{
			$output='';
			try{
				  $mail = new PHPMailer();
				 	$mail->isSMTP();                                      // Set mailer to use SMTP
				    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				    $mail->SMTPAuth = true;                               // Enable SMTP authentication
				    $mail->Username = 'carwashmi23@gmail.com';                 // SMTP username
				    $mail->Password = 'piresfigo';                           // SMTP password
				    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				    $mail->Port = 587;                                    // TCP port to connect to

				    //Recipients
				    $mail->setFrom('carwashmi23@gmail.com', 'Admin');
				    //$mail->addAddress('himanshu_gurung@esferasoft.com', 'Himanshu Gurung');     // Add a recipient
				    $mail->AddAddress($to,'User');
				    
				    //$mail->addReplyTo('info@example.com', 'Information');
				    //$mail->addCC('cc@example.com');
				    //$mail->addBCC('bcc@example.com');

				    //Attachments
				    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

				    //Content
				    $mail->isHTML(true);                                  // Set email format to HTML
				    $mail->Subject =$subject;
					$mail->Body =$message;
				    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				    $result=$mail->send();
					if($result["code"] == '400')
					{
						$output .= html_entity_decode($result['full_error']);
						return false;

					}
					else
					{
						return true;
					}
				} catch (Exception $e) {
				   $output.=$mail->ErrorInfo;
				   return false;
				}
	}

	function get_access_token()
	{
			$ch = curl_init();
			$client="ARD4nYKFdo0p667pnwp3aRoTPvCVH0AUndiN7eGTBTFhbMMZJabEbk2CMwVYAyBXZdHnsNUsKhaqXlKQ";
			$secret="EEhelyFzRME7427TXa3p8HElLp818A3PIJQ-cNZBD6SsJL0Yb0qsgare-AbhVOh9YXIO0ytYOEvp02PN";
			$url=$this->paypal_url."/v1/oauth2/token";
			curl_setopt($ch, CURLOPT_URL, "$url");
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_USERPWD, $client.":".$secret);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

			$result = curl_exec($ch);
			
			if(empty($result)){ 
				return '';
			}
			else
			{
			    $json = json_decode($result);
			   return $json->access_token;

			}
				curl_close($ch);
	}

	function getdistancenow($lat_c,$lng_c,$lat_w,$lng_w)
	{
			$curl = curl_init();

			//@client:AIzaSyAHWBMDILFS9PHC5Fk9OFAdv0i8L7B2TPM
			//@mk:AIzaSyDnjiB1yHIkT3BDVTpf80LqC3fMZ8_ygIU
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$lat_c,$lng_c&destinations=$lat_w,$lng_w&key=AIzaSyDnjiB1yHIkT3BDVTpf80LqC3fMZ8_ygIU",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			if ($err) {
			  return '';
			} else {
			  
				if(empty($response)){ 
				return '';
				}
				else
				{
				    $json = json_decode($response);
				   return $json;

				}
			}
				curl_close($curl);
	}
}	
?>