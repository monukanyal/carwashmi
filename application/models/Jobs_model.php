<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobs_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	function getorders(){
		$this->db->select("*");
		$this->db->from('service_payment');
		$query = $this->db->get();
		return $query->result();
		return $arr;
	}
	
	function deletes($oid){ 
		$res = $this->db->delete('service_payment', array('service_payment_id' => $oid)); 
		if($res){
			return true;
		}else{
			return false;
		}
	}
}