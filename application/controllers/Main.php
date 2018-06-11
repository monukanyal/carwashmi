<?php 
class Main extends CI_Controller
{
	public function index()
	{
		$this->load->helper('url');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/login');
	}
}
?>