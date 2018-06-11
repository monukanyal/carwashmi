<?php 
class Services extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct(); 
		$this->load->model('Service_model'); 
			$this->load->library('session');
			$this->load->database();    
 	}

	public function index()
	{
		$data = array();
		$this->load->helper('url');
		$this->services();
	}

	public function add_services()
	{
		$insert_user_in_database=array(
		   'service_type' => $this->input->post('service'),
		   'amount'=>json_encode($this->input->post('pricepack'))
		);		   
		$query=$this->db->insert('services_new',$insert_user_in_database);
		return $query;
	}
	
	public function get_services()
	{
		$arr = $this->Service_model->services();
		return $arr;
	}
	
	public function services()
	{
		$data['get_services'] = $this->get_services();
		$data['get_data']=$this->Service_model->get_cancellation_info();
		$session = $this->session->userdata;
		if(isset($session['loginuser']))
		{
			
			if($session['loginuser'] == '1'){
				$this->load->view('services',$data);
			}else{
				redirect('login');
			}
		}
		else
		{
			redirect('login');
		}
	}
	
	function service_action(){
		$datavl = array();
		$action = $this->input->post('action');
		$id = $this->input->post('id');
		$service_name = $this->input->post('service_name');
		 $pricepack = $this->input->post('pricepack');

		switch($action){
		
			case "update":
				$result = $this->Service_model->update($service_name,$pricepack,$id);
				break;
			case "delete":
				$result = $this->Service_model->delete($id);
				break;
		}
		
		echo $result;
		
	}

	function update_cancellation_fee()
	{
		$cncl_fee = $this->input->post('cncl_fee');
		if(!empty($cncl_fee))
		{
			$result=$this->Service_model->update_cancellation_fee($cncl_fee);
			if(!empty($result))
			{
				echo json_encode($result);
			}
			else
			{
				echo 'err';
			}
		}
		else
		{
			echo 'err';
		}
	}

	function update_admin_service_charge()
	{
		$percentage = $this->input->post('admin_service_charge');
		if(!empty($percentage))
		{
			$result=$this->Service_model->update_adminservice_percentage($percentage);
			if(!empty($result))
			{
				echo json_encode($result);
			}
			else
			{
				echo 'err';
			}
		}
		else
		{
			echo 'err';
		}
	}


	function update_template_client()
	{
		$subject = $this->input->post('subject');
		$content = $this->input->post('body');
		if(!empty($subject) && !empty($content))
		{
			$result=$this->Service_model->update_template_client($subject,$content);
			if(!empty($result))
			{
				echo json_encode($result);
			}
			else
			{
				echo 'err';
			}
		}
		else
		{
			echo 'err';
		}
	}

	function update_template_washer()
	{
		$subject = $this->input->post('subject');
		$content = $this->input->post('body');
		if(!empty($subject) && !empty($content))
		{
			$result=$this->Service_model->update_template_washer($subject,$content);
			if(!empty($result))
			{
				echo json_encode($result);
			}
			else
			{
				echo 'err';
			}
		}
		else
		{
			echo 'err';
		}
	}
	
}
?>