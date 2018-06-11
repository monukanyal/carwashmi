<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model
{	function __construct()    {
		parent::__construct(); 
		$this->load->library('session');
		$this->load->database();    
	}
	function settings(){
		$this->db->select("*");
		$this->db->from('websetting');
		$query = $this->db->get();
		$arr = $query->result();
		return $arr;
	}
	
	function edit($sid){
		$qry = "SELECT * FROM websetting WHERE id = '".$sid."'";
		$sql = $this->db->query($qry);
		$row = $sql->row_array();
	} 
	function update($data,$id){
		// print_r($data);
		$this->db->where('id', $id);
		$true = $this->db->update('websetting', $data); 
		if($true){
			return true;
		}else{
			return false;
		}
	} 
	function deletes($id){ 
		$res = $this->db->delete('websetting', array('id' => $id)); 
		if($res){
			return true;
		}else{
			return false;
		}
	}
}