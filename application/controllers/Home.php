<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payout;
use PayPal\Api\PayoutSenderBatchHeader;
use PayPal\Api\PayoutItem;
use PayPal\Api\Currency;
// use PayPal\Api\CreditCard;
// use PayPal\Api\CreditCardToken;
// use PayPal\Api\FundingInstrument;
// use PayPal\Api\Payer;
// use PayPal\Api\Amount;
// use PayPal\Api\Transaction;
// use PayPal\Api\Payment;	
// use PayPal\Api\ItemList;
// use PayPal\Api\Item;



class Home extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct();	
		$data = array();
		$this->load->helper('url');
		$this->load->model('Login_model');
		$this->load->model('Settings_model'); 
 	}

	public function index()
	{
		$settings_data = $this->Settings_model->settings();
		
		if($settings_data[0]->coming_soon == 1){
			$this->load->view('comingsoon');
		}else{
			$this->load->view('front_home');
		}
		
	}

	/* cron job test*/
	public function job_first()
	{
						 $output = '';
						/* try{
									 $mail = new PHPMailer();
								    //$mail->SMTPDebug = 2;    
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
								    $mail->AddAddress('monu_kanyal@esferasoft.com', 'developer');
								   
								    //Content
								    $mail->isHTML(true);                                  // Set email format to HTML
								    $mail->Subject ='cron test';
									$mail->Body ='Admin to washer pay sample';
								    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
								    $result=$mail->send();
									if($result["code"] == '400')
									{
										$output .= html_entity_decode($result['full_error']);
									}
							 } 
							 catch(Exception $e)
							 {
									   $output.= $mail->ErrorInfo;
							}

									if($output == '')
									 {
									  echo 'ok';
									 }
									 else
									 {
									  echo $output;
									 } */


	}

	function test_job()
	{

			 $clientId = 'AaSp8eXOVxdKgIuZevbNMx5VaBovlZYpGkhDpx6yRMEQSPpFrNqfpiyWUbGm-VsMLdjdNGQV7tdLd_Qg';
			$secredId = 'EO-UAnZOLvru8QMdUJwpydJm8uxApPfFt-uRIMnuR_466eC0CVeA-FL8oPwM_98-XbMKH6wOMRGsSeAy';
			$sdkConfig = array( "mode" => "sandbox" );

			$cred = new OAuthTokenCredential($clientId, $secredId, $sdkConfig);
			$apiContext = new ApiContext($cred, 'Request' . time());
			$apiContext->setConfig($sdkConfig);
			// $card = new CreditCard();
			// $card->setType("visa");
			// $card->setNumber("4446283280247004");
			// $card->setExpireMonth("03");
			// $card->setExpireYear("2020");
			// $card->setFirstName("Amit");
			// $card->setLastName("Singh");

			// $response = $card->create($apiContext);
			// echo $response->id;
		$payouts = new Payout();
		$senderBatchHeader = new PayoutSenderBatchHeader();
		$senderBatchHeader->setSenderBatchId(uniqid())->setEmailSubject("You have a payment");

		// #### Sender Item
		// Please note that if you are using single payout with sync mode, you can only pass one Item in the request

		// $senderItem1 = new PayoutItem();
		// $senderItem1->setRecipientType('Email')
		//     ->setNote('Thanks you.')
		//     ->setReceiver('monu_kanyal-buyer1@esferasoft.com')
		//     ->setSenderItemId("item_1" . uniqid())
		//     ->setAmount(new Currency('{
		//                         "value":"1.00",
		//                         "currency":"GBP"
		//                     }'));

		// #### Sender Item 2
		// There are many different ways of assigning values in PayPal SDK. Here is another way where you could directly inject json string.
		// $senderItem2 = new PayoutItem(
		//     '{
		//             "recipient_type": "EMAIL",
		//             "amount": {
		//                 "value": 1.90,
		//                 "currency": "GBP"
		//             },
		//             "receiver": "monu_kanyal-buyer3@esferasoft.com",
		//             "note": "Thank you.",
		//             "sender_item_id": "item_2"
		//         }'
		// );
		// #### Sender Item 3
		// One more way of assigning values in constructor when creating instance of PayPalModel object. Injecting array.
		$senderItem1 = new PayoutItem(
		    array(
		        "recipient_type" => "EMAIL",
		        "receiver" => "monu_kanyal-buyer4@esferasoft.com",
		        "note" => "Thank you.",
		        "sender_item_id" => uniqid(),
		        "amount" => array(
		            "value" => "1.90",
		            "currency" => "GBP"
		        )
		    )
		);

			$senderItem2 = new PayoutItem(
		    array(
		        "recipient_type" => "EMAIL",
		        "receiver" => "monu_kanyal-buyer4@esferasoft.com",
		        "note" => "Thank you.",
		        "sender_item_id" => uniqid(),
		        "amount" => array(
		            "value" => "1.90",
		            "currency" => "GBP"
		        )
		    )
		);
		//$payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem1)->addItem($senderItem2)->addItem($senderItem3);
		$payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem1)->addItem($senderItem2);

		// For Sample Purposes Only.
		//$request = clone $payouts;

		try {
		    $output = $payouts->create(null, $apiContext);

		} catch (Exception $ex) {
		    // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		    echo "PayPal Payout Error: ". $ex . "<br><br>";
		    echo "PayPal Payout GetData:<br>". $ex->getData() . "<br><br>";
		    //ResultPrinter::printError("Created Batch Payout", "Payout", null, $request, $ex);
		   exit(1);
		}
		// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		// ResultPrinter::printResult("Created Batch Payout", "Payout", $output->getBatchHeader()->getPayoutBatchId(), $request, $output);
		var_dump($output);
		//print_r($output);
	}
}
?>