<?php 
class User extends CI_Controller
{
 	public function __construct(){
 		parent::__construct(); 
 		$this->load->model('User_model');
 	}
 	
	public function index()
	{
		$this->load->helper('url');
	}
	
	public function edituser(){
		$uid = $this->input->post('userid');
		$edituser = $this->User_model->edit($uid);
		if($edituser == 0){
			ob_start();
			?>
			<div class="form-group">
				<label class="col-md-2 control-label">Status</label>
				<div class="col-md-10">
					YOU ARE ADMIN!.
				</div>
			</div>
			<?php
			$edituserform = ob_get_clean();			
		}else{
			ob_start();
			?>
			<div id="editForm">
				<div class="form-group">
					<label class="col-md-2 control-label">Firstname</label>
					<div class="col-md-10">
						<input type="text" name="fname" id="fname" value="<?php echo $edituser['first_name'];?>" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Lastname</label>
					<div class="col-md-10">
						<input type="text" name="lname" id="lname" value="<?php echo $edituser['last_name'];?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Email</label>
					<div class="col-md-10">
						<input type="email" name="email" id="email" value="<?php echo $edituser['email'];?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">Phone</label>
					<div class="col-md-10">
						<input type="text" name="phone" id="phone" value="<?php echo $edituser['mobile_number'];?>"  class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label"> &nbsp;</label>
					<div class="col-md-10">
						<a href="javascript:void(0);" onclick="getdata('<?php echo $edituser['user_id'];?>')" class="buttonFinish btn btn-primary pull-left update_user" data-userid="<?php echo $edituser['user_id'];?>" style="display: block;">Update</a>
					</div>
				</div>
			</div>
			<?php 
			$edituserform = ob_get_clean();
		}
		echo $edituserform;
		die;
	}
	
	function updateuser(){
		$dataArr = array();
		$uid = $this->input->post('userid');
		
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		
		$dataArr['first_name'] = $fname;
		$dataArr['last_name'] = $lname;
		$dataArr['email'] = $email;
		$dataArr['mobile_number'] = $phone;
		
		$edituser = $this->User_model->updateuser($dataArr,$uid);
		if($edituser == true){
			echo "1";
		}else{
			echo "0";
		}
	}
	function deleteusr(){
		$uid = $this->input->post('id'); 
		$edituser = $this->User_model->deleteusr($uid);
		if($edituser == true){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	function enablefirstlogin(){
		$uid = $this->input->post('id'); 
		$edituser = $this->User_model->updatefirstloginstatus($uid);
		if($edituser == true){
			echo "1";
		}else{
			echo "0";
		}
	}
	
	function verifyuser(){
		$dataArr = array();
		$uid = $this->input->post('id'); 
		$email = $this->input->post('email'); 
		$username = $this->input->post('username');
		$tokan = $this->input->post('tokan');
		if(isset($username)){
			$u = $username;
		}else{
			$u = "Guest User!";
		}
		$dataArr['user_name'] = $u;
		$dataArr['link'] = base_url() . "web/confirm?hash=".$tokan."&is_verify=f&u=".$uid;
		$edituser = $this->User_model->userverify($uid);
		if($edituser == true){
			$to = $email;
			$subject = 'You are verified by carwashmi administration.';
			$headers = "From: carwashmi@carwashmi.com\r\n"; 
			$headers .= "Reply-To: noreply@carwahsmi.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			ob_start();
				$this->load->view('verify_template', $dataArr);
			$message = ob_get_clean();
			$m = mail($to, $subject, $message, $headers);
			echo "1";
		}else{
			echo "0";
		}
	}

	
}
?>