<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Task extends CI_Controller
{
 	public function __construct(){
 		parent::__construct(); 
 		$this->load->model('Api_model');
 	}
 	/* ----cron job task which pay washer after deducting admin service charge--------------*/
	
	public function index()
	{
		$results=$this->Api_model->get_washer_list();
		if($results)
		{
			if(count($results)>0)
			{
				$charge=$results['admin_service_charge']['charge'];
				$access_token=$this->get_access_token();
				$mainarray=array();
				$payment_arr=array();
				 for($j=0;$j<count($results['washerlist']);$j++)
				 {
				 		$payment_arr[$j]=array($results['washerlist'][$j]['service_payment_id'],$results['washerlist'][$j]['washeramount']);

					 	$client_req_id=$results['washerlist'][$j]['client_request_id'];
					 	$mainarray[$j]['recipient_type']="EMAIL";    
					 	$mainarray[$j]['amount']=array(
							"value"=>$results['washerlist'][$j]['washeramount'],
							"currency"=>"USD"
					 		);  
					 	$mainarray[$j]['note']="Thanks For doing great work [client Request id :$client_req_id]!!";
					 	$mainarray[$j]['sender_item_id']=mt_rand();  
					 	$mainarray[$j]['receiver']=$results['washerlist'][$j]['washer_paypal_email'];
				 }
				 
				 if(count($mainarray)>0)
				 {
				 	$unq_id=uniqid();
				 	$data=array(
				 		'sender_batch_header'=>array(
				 				"sender_batch_id"=>"$unq_id"
								//"email_subject"=>"You have a payout!",
								//"email_message"=>"You have received a payout from carwashmi! Thanks for using carwashmi service!"
				 			),
				 		'items'=>$mainarray
				 		);
						$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payouts",
						  CURLOPT_RETURNTRANSFER => true,
						  CURLOPT_ENCODING => "",
						  CURLOPT_MAXREDIRS => 10,
						  CURLOPT_TIMEOUT => 30,
						  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						  CURLOPT_CUSTOMREQUEST => "POST",
						  CURLOPT_POSTFIELDS => json_encode($data),
						  CURLOPT_HTTPHEADER => array(
						    "authorization: Bearer $access_token",
						    "cache-control: no-cache",
						    "content-type: application/json"
						  ),
						));

						$response = curl_exec($curl);
						$err = curl_error($curl);

						curl_close($curl);

						if ($err) {

						  echo "cURL Error #:" . $err;
						  $this->send_mail($err);

						} else {
								if($response)
								{
									$value =json_decode($response);
									//print_r($value);
									$batch_id=$value->batch_header->payout_batch_id;
									$batch_status=$value->batch_header->batch_status;
									//create log file
									$payupdate=$this->Api_model->update_washer_payment_status($payment_arr,$batch_status,$batch_id);
									//$this->send_mail2($batch_id,$batch_status,$payupdate);
									echo "done";
								}
								else
								{
									echo 'no response of payout';
								}
						}	
					}
					else
					{
						'No payout washer list found';
					}
			}
			else
			{
				echo 'No washer list';
			}
		}
		else
		{
			echo 'No washer pending';
		}
	}


	function send_mail($message)
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
			    $mail->AddAddress('monu_kanyal@esferasoft.com','User');
			    //Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject ='Washer payment api issue log';
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

	function send_mail2($batch_id,$batch_status,$payupdate)
	{
			$output='';
			$arr=array('batch_status'=>$batch_status,'batch_id'=>$batch_id,'payupdate status'=>$payupdate);
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
				    $mail->AddAddress('monu_kanyal@esferasoft.com','User');
				    //Content
				    $mail->isHTML(true);                                  // Set email format to HTML
				    $mail->Subject ='Washer payment api response';
					$mail->Body =$arr;
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
	public function get_access_token()
	{
			$ch = curl_init();
			$client="ARD4nYKFdo0p667pnwp3aRoTPvCVH0AUndiN7eGTBTFhbMMZJabEbk2CMwVYAyBXZdHnsNUsKhaqXlKQ";
			$secret="EEhelyFzRME7427TXa3p8HElLp818A3PIJQ-cNZBD6SsJL0Yb0qsgare-AbhVOh9YXIO0ytYOEvp02PN";
			curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
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
	
}
?>