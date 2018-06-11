<?php 
class News extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct();	
		$data = array();
		$this->load->helper('url');
                $this->load->model('Settings_model'); 
 	}

	public function index()
	{
                $settings_data = $this->Settings_model->settings();
		
		if($settings_data[0]->coming_soon == 1){
			$this->load->view('comingsoon');
		}else{
		        $this->load->view('front_news');
                }
	}
}
?>