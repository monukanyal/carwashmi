<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Dashboard extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct();	
		$this->load->model('User_model');
		$this->load->helper('url');
		$session = $this->session->userdata;
		if(isset($session['loginuser']))
		{
		
			if($session['loginuser'] != '1'){
			
				redirect('login');
			}
		}
		else
		{
			redirect('login');
		}
 	}

	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->dashboard();
	}
	
	
	public function dashboard()
	{
		$session = $this->session->userdata;
		if(isset($session['loginuser']))
		{
			$data['maindata']=$this->User_model->all_count_info();
			if($session['loginuser'] == '1'){
				$x=$this->User_model-> get_request_last7day();
				$data['data2']=json_encode($x);
				$data['latest_transaction_data']=$this->User_model->get_latest_transaction();
				$this->load->view('dashboard',$data);
			}else{
				redirect('login');
			}
		}
		else
		{
			redirect('login');
		}
	}
	
	public function users()
	{
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('users');
		}else{
			redirect('login');
		}
	}
	
	public function admin_profile()
	{
		$p = $this->User_model->profile();
		return $p;
	}
	
	public function profile()
	{
		$data['profile'] = $this->admin_profile();
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('profile',$data);
		}else{
			redirect('login');
		}
	}

	public function client_email_template()
	{
		$data['client']=$this->User_model->get_client_email_template();
		$this->load->view('email_templates_client',$data);
	}

	public function washer_email_template()
	{
		$data['washer']=$this->User_model->get_washer_email_template();
		$this->load->view('email_templates_washer',$data);
	}

	public function clients()
	{
		$data['clients']=$this->User_model->get_customers();
		$this->load->view('clients_list',$data);
	}

	public function send_mail_client()
	{
		if(isset($_POST['email_data']))
			{
		
				$template=$this->User_model->get_client_email_template();
				$subject=$template[0]['subject'];
				$content=$template[0]['content'];
				 $output = '';
				 foreach($_POST['email_data'] as $row)
				 {
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
					    //$mail->addAddress('monu_kanyal@esferasoft.com', 'Monu kanyall');     // Add a recipient
					    $mail->AddAddress($row["email"], $row["name"]);
					    
					    //$mail->addReplyTo('info@example.com', 'Information');
					    //$mail->addCC('cc@example.com');
					    //$mail->addBCC('bcc@example.com');

					    //Attachments
					    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
					    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

					    //Content
					    $mail->isHTML(true);                                  // Set email format to HTML
					    $mail->Subject =$subject;
						$mail->Body =$content;
					    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
					    $result=$mail->send();
						if($result["code"] == '400')
						{
							$output .= html_entity_decode($result['full_error']);
						}

						} catch (Exception $e) {
							   $output.=$mail->ErrorInfo;
							}
				 }
				 if($output == '')
				 {
				  echo 'ok';
				 }
				 else
				 {
				  echo $output;
				 }
			}	
	}


	public function washers()
	{
		$data['washers']=$this->User_model->get_washers();
		$this->load->view('washer_list',$data);
	}


	public function send_mail_washer()
	{
		if(isset($_POST['email_data']))
			{
		
				$template=$this->User_model->get_washer_email_template();
				$subject=$template[0]['subject'];
				$content=$template[0]['content'];
				 $output = '';
				 foreach($_POST['email_data'] as $row)
				 {
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
							    $mail->AddAddress($row["email"], $row["name"]);
							    
							    //$mail->addReplyTo('info@example.com', 'Information');
							    //$mail->addCC('cc@example.com');
							    //$mail->addBCC('bcc@example.com');

							    //Attachments
							    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
							    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

							    //Content
							    $mail->isHTML(true);                                  // Set email format to HTML
							    $mail->Subject =$subject;
								$mail->Body =$content;
							    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
							    $result=$mail->send();
								if($result["code"] == '400')
								{
									$output .= html_entity_decode($result['full_error']);
								}
							} catch (Exception $e) {
							   $output.=$mail->ErrorInfo;
							}
				 }
				 if($output == '')
				 {
				  echo 'ok';
				 }
				 else
				 {
				  echo $output;
				 }
			}	
	}

	function get_histogram_data()
	{
		$x=$this->User_model->get_histogram_data($this->input->post('start'),$this->input->post('end'));
		echo json_encode($x);
	}

	function get_request_last7day()
	{
		$x=$this->User_model->get_request_last7day();
		echo json_encode($x);
	}
	function orders()
	{
		$session = $this->session->userdata;
		if(isset($session['loginuser']))
		{
		
			if($session['loginuser'] == '1'){
			
				$this->load->view('orders');
			}else{
				redirect('login');
			}
		}
		else
		{
			redirect('login');
		}
	}
	function pagination()
	 {
	
	  $this->load->library("pagination");
	  $config = array();
	  $config["base_url"] = "#";
	  $config["total_rows"] = $this->User_model->count_all();
	  $config["per_page"] = 10;
	  $config["uri_segment"] = 3;
	  $config["use_page_numbers"] = TRUE;
	  $config["full_tag_open"] = '<ul class="pagination">';
	  $config["full_tag_close"] = '</ul>';
	  $config["first_tag_open"] = '<li>';
	  $config["first_tag_close"] = '</li>';
	  $config["last_tag_open"] = '<li>';
	  $config["last_tag_close"] = '</li>';
	  $config['next_link'] = '&gt;';
	  $config["next_tag_open"] = '<li>';
	  $config["next_tag_close"] = '</li>';
	  $config["prev_link"] = "&lt;";
	  $config["prev_tag_open"] = "<li>";
	  $config["prev_tag_close"] = "</li>";
	  $config["cur_tag_open"] = "<li class='active'><a href='#'>";
	  $config["cur_tag_close"] = "</a></li>";
	  $config["num_tag_open"] = "<li>";
	  $config["num_tag_close"] = "</li>";
	  $config["num_links"] = 1;
	  $this->pagination->initialize($config);
	  $page = $this->uri->segment(3);
	  $start = ($page - 1) * $config["per_page"];

	  $output = array(
	   'pagination_link'  => $this->pagination->create_links(),
	   'country_table'   => $this->User_model->fetch_details($config["per_page"], $start)
	  );
	  echo json_encode($output);
	 }

	 function promotions()
	 {
	 	$data['calendar_list']=$this->User_model->get_promotions();
	 	$this->load->view('promotions',$data);
	 }
	 function store_promotions()
	 {

		 	$title=$this->input->post('ptitle');
		 	$description=$this->input->post('description');
		 	$pdaterange1=$this->input->post('pdaterange1');
		 	$pdaterange2=$this->input->post('pdaterange2');
		 	$offer=$this->input->post('offer');
		 	if(isset($_POST['isday']))
		 	{
		 		$is1day=1;	
		 	}
		 	else
		 	{
		 		$is1day=0;
		 	}

		   if($is1day==0)
		   {
		   	 $rangearr=explode(' - ', $pdaterange1);
		   	$a=array(
		 		'promotion_title'=>$title,
		 		'description'=>$description,
		 		'promotion_from'=>$rangearr[0],
		 		'promotion_to'=>$rangearr[1],
		 		'offer'=>$offer.$_POST['offer_type'],
		 		'promotion_day'=>$is1day	
		 		);
		   	 $status=$this->User_model->store_promotion_info1($a);
			   if($status)
			   {
			   		$this->session->set_flashdata('saved', true);	
			   		
			   }
			   else
			   {
			   		$this->session->set_flashdata('saved', false);
			   }
		   }
		   else
		   {
		   		$a=array(
		 		'promotion_title'=>$title,
		 		'description'=>$description,
		 		'promotion_date'=>$pdaterange2,
		 		'promotion_day'=>$is1day,
		 		'offer'=>$offer.$_POST['offer_type'],
		 		);

		 		 $status=$this->User_model->store_promotion_info2($a);
				   if($status)
				   {
				   		$this->session->set_flashdata('saved', true);	
				   		
				   }
				   else
				   {
				   		$this->session->set_flashdata('saved', false);
				   }
		   }
		  
		    redirect('/dashboard/promotions', 'refresh');
	 	
	 }

	 function fetchpromotiondata()
	 {
	 	$res=$this->User_model->get_promotion_data_byid($this->input->post('pid'));
	 	echo json_encode($res);
	 } 

	 function update_promotions()
	 {
	 		$pid=$this->input->post('pid');
	 		$title=$this->input->post('ptitle');
		 	$description=$this->input->post('description');
		 	$pdaterange1=$this->input->post('pdaterange1');
		 	$pdaterange2=$this->input->post('pdaterange2');
		 	$offer=$this->input->post('offer');
		 	if(isset($_POST['isday']))
		 	{
		 		$is1day=1;	
		 	}
		 	else
		 	{
		 		$is1day=0;
		 	}

		   if($is1day==0)
		   {
		   	 $rangearr=explode(' - ', $pdaterange1);
		   	$a=array(
		 		'promotion_title'=>$title,
		 		'description'=>$description,
		 		'promotion_from'=>$rangearr[0],
		 		'promotion_to'=>$rangearr[1],
		 		'offer'=>$offer.$_POST['offer_type'],
		 		'promotion_day'=>$is1day	
		 		);
		   	
		   }
		   else
		   {
		   		$a=array(
		 		'promotion_title'=>$title,
		 		'description'=>$description,
		 		'promotion_date'=>$pdaterange2,
		 		'promotion_day'=>$is1day,
		 		'offer'=>$offer.$_POST['offer_type'],
		 		);

		 		 
		   }
		  		 $status=$this->User_model->update_promotion_info($a,$pid);
			   if($status)
			   {
			   		$this->session->set_flashdata('updated', true);	
			   		
			   }
			   else
			   {
			   		$this->session->set_flashdata('updated', false);
			   }

		    redirect('/dashboard/promotions', 'refresh');
	 }

	 function delete_promotion()
	 {
	 	$status=$this->User_model->delete_promotion_now($this->input->post('pid'));
	 	echo $status;
	 }


	 function more_info($client_request_id)
	 {
	 	$data['paydetails']=$this->User_model->get_payment_details($client_request_id);
		$this->load->view('payment_details',$data);
	 }
	/* function test_api(){
	 	
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

			if(empty($result))die("Error: No response.");
			else
			{
			    $json = json_decode($result);
			   $access_token=$json->access_token;
			   $details=json_encode(array(
			   			"number"=>"5528993586921510",
						"type"=>"mastercard",
						"expire_month"=>03,
						"expire_year"=>2024,
						"cvv2"=>"708",
						"first_name"=>"Joe",
						"last_name"=>"Shopper",
						"external_customer_id"=>"01"
			   	));
			   
			   $curl2 = curl_init();

					curl_setopt_array($curl2, array(
					  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/vault/credit-cards/",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_ENCODING => "",
					  CURLOPT_MAXREDIRS => 10,
					  CURLOPT_TIMEOUT => 30,
					  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POSTFIELDS => $details,
					  CURLOPT_HTTPHEADER => array("Content-Type: application/json","Authorization: Bearer ".$json->access_token, "content-type: application/json")
					));

					$response = curl_exec($curl2);
					$err = curl_error($curl2);

					curl_close($curl2);

					if ($err) {
					  echo "cURL Error #:" . $err;
					} else {
					  if($response)
					  {
					  	
					  	$x=json_decode($response);
					  	echo 'card_id:'.$x->id;
					  }
					}
			}
	 }
*/
}
?>