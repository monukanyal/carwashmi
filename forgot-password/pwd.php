<?php 
$conn = mysqli_connect("43.255.154.55", "cw_app17", "ZE?S8({zt3}1", "cw_app2017");
if($_POST['confpass'] != $_POST['pass']){
	echo "Password not match. Please match password again!";
	exit;
}else{
	$sql = "SELECT * FROM account WHERE hash='".$_POST['hash']."' LIMIT 1";
	$query = mysqli_query($conn, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows == 0){
		echo "There is no match for actual user with hash password in the system. We cannot proceed.";
	} else {
		$row = mysqli_fetch_row($query);

		$sql = "UPDATE account SET password='".md5($_POST['pass'])."' WHERE hash='".$_POST['hash']."' LIMIT 1";
		$query = mysqli_query($conn, $sql);
		if($query){
			$sqlh = "update account set hash = '' where password='".md5($_POST['pass'])."'";
			$queryh = mysqli_query($conn, $sqlh);
			echo "1";
		}else{
			echo "0";
		}
		exit(); 
	}
}
mysqli_close($conn);
?>