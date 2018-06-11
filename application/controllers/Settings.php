<?php 
class Settings extends CI_Controller
{
	var $data;
    public function __construct(){
 		parent::__construct(); 
		$data = array();
		$this->load->model('Settings_model'); 
 	}

	public function index()
	{
		$uploadpath = "./uploadedImages/uploads/";
		$data['uploadpath'] = $uploadpath;
		$data['settings'] = $this->Settings_model->settings();
		$this->load->view('settings', $data);
	}
	
	function save_settings(){

		$comming_soon = $this->input->post('enamble_template');

		$uploadpath = "./uploadedImages/uploads/";
		$settings_data = $this->Settings_model->settings();
		$data['id'] = $this->input->post('id');
		if(isset($_FILES)){
			/* favicon */
			$file_namej = $_FILES['favicon']['name'];
			$file_sizej = $_FILES['favicon']['size'];
			$file_tmpj = $_FILES['favicon']['tmp_name'];
			$file_typej = $_FILES['favicon']['type'];
			$tmpj = explode('.', $file_namej);
			$file_extj = end($tmpj);
		  
			$favicon_expensions = array("jpeg","jpg","png");
			
			$data['site_favicon'] = ($_FILES['favicon']['size'] == 0) ? $settings_data[0]->site_favicon : $file_namej;
			
			/* site_logo */
			$file_name = $_FILES['site_logo']['name'];
			$file_size = $_FILES['site_logo']['size'];
			$file_tmp = $_FILES['site_logo']['tmp_name'];
			$file_type = $_FILES['site_logo']['type'];
			$tmp = explode('.', $file_name);
			$file_ext = end($tmp);
		  
			$site_logo_expensions = array("jpeg","jpg","png");

			$data['site_logo'] = ($_FILES['site_logo']['size'] == 0) ? $settings_data[0]->site_logo : $file_name;
			
			
			move_uploaded_file($file_tmp,$uploadpath.$file_name);
			move_uploaded_file($file_tmpj,$uploadpath.$file_namej);

		}

		$data['coming_soon'] = $comming_soon;
		$data['site_name'] = $this->input->post('site_name');
		$data['admin_email'] = $this->input->post('admin_email');

		$status = $this->Settings_model->update($data, $data['id']);
		if($status == 1){
			$data['success'] = "Settings saved successfully";
		}else{
			$data['error'] = "Something wrong";
		}
		redirect('settings');
	}
	
	function pages(){
		$this->load->view('pages');
	}
}
?>