<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requests_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	function requests(){
		$this->db->select("*");
		$this->db->from('washer_response');
		$query = $this->db->get();
		return $query->result();
		return $arr;
	}
	
	function client_request($rid){
		$this->db->select("*");
		$this->db->from('client_request');
		$this->db->where('client_request_id',$rid);
		$query = $this->db->get();
		return $query->result();
		return $arr;
	}

	function deleteRequest($rid){ 
		$res = $this->db->delete('client_request', array('client_request_id' => $rid)); 
		if($res){
			return true;
		}else{
			return false;
		}
	} 
}
?>