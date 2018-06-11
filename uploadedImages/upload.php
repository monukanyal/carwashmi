<?php
header('Access-Control-Allow-Origin: *');

if (!isset($_FILES) && $_FILES["file"]["error"] > 0){
	echo "Error Code: " . $_FILES["file"]["error"] . "<br />";
}
else
{
	$target_path = $_FILES["file"]["tmp_name"];
	$tmp_name = $_FILES["file"]["tmp_name"];
	$name = $_FILES["file"]["name"];
	if(move_uploaded_file($tmp_name, $name)){
	    //chmod($tmp_name, 0777);
	    echo "Upload and move success";
	} else{
	    echo "There was an error uploading the file, please try again! ".$target_path;
	}
}
?>