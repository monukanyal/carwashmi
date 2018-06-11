<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	
	function getpayment_method(){
		$this->db->select("*");
		$this->db->from('payment_settigns');
		$query = $this->db->get();
		$arr = $query->result();
		return $arr;
	}
	
	function payment_status($uid){
		$status = "";
		$this->db->select("payment_status,default_method");
		$this->db->from('users');
		$this->db->where('user_id', $uid);
		$query = $this->db->get();
		$arr = $query->result();
		if(count($arr) > 0){
			// print_r($arr);
			if($arr[0]->default_method == 'paypal' && $arr[0]->payment_status == 1){
				$status = 'Authorized';
			}else if($arr[0]->default_method == 'card'){
				$status = 'No';
			}
		}
		return $status;
	}
	
	function edit($id){
		$qry = "SELECT * FROM payment_settigns WHERE payment_settigns_id = '".$id."'";
		$sql = $this->db->query($qry);
		$row = $sql->row_array();
		if(count($row) > 0){
			return $row;
		}else{
			return '0';
		}
	} 
	function update($data,$id){
		// print_r($data);
		$this->db->where('payment_settigns_id', $id);
		$true = $this->db->update('payment_settigns', $data); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 
	function deletes($id){ 
		$res = $this->db->delete('payment_settigns', array('payment_settigns_id' => $id)); 
		if($res){
			return true;
		}else{
			return false;
		}
	}
}