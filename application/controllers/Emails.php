<?php 
class Emails extends CI_Controller
{
	var $data;
 	public function __construct(){
 		parent::__construct(); 
 		$this->load->model('User_model');
 	}
 	
	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->email_inbox();
	}
	
	public function email_inbox()
	{
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('email_inbox');
		}else{
			redirect('login');
		}
	}
	
	function sendEmail(){
		// configure
		// print_r($_POST);
		$from = 'info@carwashmi.com';
		$sendTo = $_POST['email'];
		$subject = 'New message from contact form';
		$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in the email
		$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
		$errorMessage = 'There was an error while submitting the form. Please try again later';

		// let's do the sending

		try
		{
			$emailText = "You have new message from contact form\n=============================\n";

			foreach ($_POST as $key => $value) {

				if (isset($fields[$key])) {
					$emailText .= "$fields[$key]: $value\n";
				}
			}

			$headers = array('Content-Type: text/html; charset="UTF-8";',
				'From: ' . $from,
				'Reply-To: ' . $from,
				'Return-Path: ' . $from,
			);
			
			mail($sendTo, $subject, $emailText, implode("\n", $headers));

			$responseArray = array('type' => 'success', 'message' => $okMessage);
		}
		catch (\Exception $e)
		{
			$responseArray = array('type' => 'danger', 'message' => $errorMessage);
		}

		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$encoded = json_encode($responseArray);

			header('Content-Type: application/json');

			echo $encoded;
		}
		else {
			echo $responseArray['message'];
		}
	}
	
}
?>