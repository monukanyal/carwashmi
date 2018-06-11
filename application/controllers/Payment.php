<?php 
class Payment extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct(); 
		$this->load->model('Payment_model'); 
 	}

	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->paymantsettings();
	}

	public function add_services()
	{
		$insert_user_in_database=array(
		   'service_name' => $this->input->post('service'),
		);		   
		$query=$this->db->insert('payment_settigns',$insert_user_in_database);
		return $query;
	}
	
	public function get_payments()
	{
		$arr = $this->Payment_model->getpayment_method();
		return $arr;
	}
	
	public function paymantsettings()
	{
		$data['get_payments'] = $this->get_payments();
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('payment',$data);
		}else{
			redirect('login');
		}
	}
	
	function payment_action(){
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		switch($action){
			case "delete":
				$result = $this->Payment_model->deletes($id);
				break;
		}
		
		echo $result;
		
	}
}
?>