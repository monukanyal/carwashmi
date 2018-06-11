<?php 
class Login extends CI_Controller
{
 	public function __construct(){
 		parent::__construct(); 
 		$this->load->model('Login_model');
 	}
 	
	public function index()
	{
		$this->load->helper('url');
                
		$this->login();
	}
	
	public function login()
	{
		$this->load->view('login');
	}
	
  
    public function restricted()
	{
        $this->load->view('restricted');
	}
	
	public function checkadmin()
	{
	
		$username = isset($_GET['username']) ? $_GET['username'] : "";
		$password= isset($_GET['password']) ? $_GET['password'] : "";
		
		if($username == "" && $password == ""){
			echo "0"; exit;
		}else{
			$usr_result = $this->Login_model->get_user($username, $password);
			if ($usr_result > 0) //active user record is present
			{
				//set the session variables
				$sessiondata = array(
					'username' => $username,
					'loginuser' => '1'
				);
				$this->session->set_userdata($sessiondata);
				echo "1";
			}else{
				echo "0";
			}
		}
	
    }
}
?>