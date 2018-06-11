<?php 
class Requests extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct(); 
		$this->load->model('Requests_model'); 
		$this->load->model('Usermodel'); 
 	}

	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->requests();
	}

	public function add_services()
	{
		$insert_user_in_database=array(
		   'service_name' => $this->input->post('service'),
		);		   
		$query=$this->db->insert('services',$insert_user_in_database);
		return $query;
	}
	
	public function get_requests()
	{
		$arr = $this->Requests_model->requests();
		return $arr;
	}
	
	public function requests()
	{
		$data['get_requests'] = $this->get_requests();
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('requests',$data);
		}else{
			redirect('login');
		}
	}
	
	function delete_request(){
		$datavl = array();
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		switch($action){
			case "delete":
				$result = $this->Requests_model->deleteRequest($id);
				break;
		}
		
		echo $result;
		
	}
}
?>