<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	function services(){
		$complete=array();
		$this->db->select("*");
		$this->db->from('services');
		$query = $this->db->get();
		return $query->result();
		//return $arr;
	}

	function get_cancellation_info()
	{
		$b=array();

		$this->db->select("cancellation_fee,updated_at1,admin_service_charge,updated_at2");
		$this->db->from('service_charge_tbl');
		$query2 = $this->db->get();
		$a=$query2->result_array();
		if($a)
		{
			$b['cancellation_fee']=$a[0]['cancellation_fee'];
			$b['admin_service_charge']=$a[0]['admin_service_charge'];
			$b['updated_at1']=date('Y-m-d h:i a',strtotime($a[0]['updated_at1']));
			$b['updated_at2']=date('Y-m-d h:i a',strtotime($a[0]['updated_at1']));
			return $b;
		}	
		else
		{
			return $b;
		}
	}
	
	function edit($sid){
		$qry = "SELECT * FROM services WHERE id = '".$sid."'";
		$sql = $this->db->query($qry);
		$row = $sql->row_array();
		if(count($row) > 0){
			switch($row['service_type']){
				case "0":
					$service_name = "Elite";
					break;
				case "1":
					$service_name = "Standard";
					break;
				case "2":
					$service_name = "Premium";
					break;
			}
			return $service_name;
		}else{
			return '0';
		}
	} 
	function update($service_name,$pricepack,$id)
	{
		
		// print_r($data);
		$data=array('service_name'=>$service_name,
					"amount"=>$pricepack
				);
		$this->db->where('id', $id);
		$true = $this->db->update('services', $data); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 
	function deletes($id){ 
		$res = $this->db->delete('services', array('id' => $id)); 
		if($res){
			return true;
		}else{
			return false;
		}
	}

	function update_cancellation_fee($fee)
	{
		$this->db->set('cancellation_fee', $fee);
		$this->db->set('updated_at1', date('Y-m-d H:i:s'));
		if($this->db->update('service_charge_tbl'))
		{	
			$this->db->select('*');
			$query = $this->db->get('service_charge_tbl');
			return $query->result();
		}
		else
		{
			return '';
		}
	}

	function update_adminservice_percentage($percentage)
	{
		$this->db->set('admin_service_charge', $percentage);
		$this->db->set('updated_at2', date('Y-m-d H:i:s'));
		if($this->db->update('service_charge_tbl'))
		{	
			$this->db->select('*');
			$query = $this->db->get('service_charge_tbl');
			return $query->result();
		}
		else
		{
			return '';
		}
	}

	function update_template_client($subject,$content)
	{
		$this->db->set('subject', $subject);
		$this->db->set('content', $content);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('type', 'client');
		if($this->db->update('email_templates'))
		{	
			$this->db->select('*');
			$this->db->where('type','client');
			$query = $this->db->get('email_templates');
			return $query->result();
		}
		else
		{
			return '';
		}
	}


	function update_template_washer($subject,$content)
	{
		$this->db->set('subject', $subject);
		$this->db->set('content', $content);
		$this->db->set('updated_at', date('Y-m-d H:i:s'));
		$this->db->where('type', 'washer');
		if($this->db->update('email_templates'))
		{	
			$this->db->select('*');
			$this->db->where('type','washer');
			$query = $this->db->get('email_templates');
			return $query->result();
		}
		else
		{
			return '';
		}
	}
}