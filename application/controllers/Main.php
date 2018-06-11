<?php 
class Main extends CI_Controller
{
	public function index()
	{
		$this->load->help('url');
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
	}
}
?>