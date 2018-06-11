<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subscribe extends CI_Controller
{
        function __construct() 
	{
		parent::__construct();
		$this->load->model('Subscribe_model');
                $this->output->nocache();
	}
	
	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->subscribers();
	}

	public function add_subscriber()
	{
                $validate = $this->Subscribe_model->checksubscribers($this->input->post('subscriber_email'));
                if($validate == 1 || $validate == true){
                        echo "You are already registered!";
                        exit;
                }
		$insert_subscribers_in_database=array(
                   'subscriber_ip' => $this->input->post('subscriber_ip'),
		   'subscriber_email' => $this->input->post('subscriber_email')
		);		   
		$query = $this->db->insert('subscribers',$insert_subscribers_in_database);
		if($query){
                   echo "Subscribed successfully.Thank you";
                }
                exit;
	}
	
	public function get_subscribers()
	{
		$arr = $this->Subscribe_model->subscribers();
		return $arr;
	}

	public function subscribers()
	{
		$data['get_subscribers'] = $this->get_subscribers();
		$session = $this->session->userdata;
		if($session['loginuser'] == '1'){
			$this->load->view('subscribers',$data);
		}else{
			redirect('login');
		}
	}
	
	function subscribers_action(){
		$datavl = array();
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$subscriber_email = $this->input->post('subscriber_email');
		$datavl['subscriber_email'] = $subscriber_email;
		switch($action){
			case "edit":
				$result = $this->Subscribe_model->edit($id);
				break;
			case "delete":
				$result = $this->Subscribe_model->delete($id);
				break;
		}
		
		echo $result;
		
	} 

}	
?>