<?php
class Common_model extends CI_Model
{
   function __construct() 
   {
        parent::__construct();
		 $this->load->database();
		 $this->load->helper('url');
		

		 $this->load->model('Usermodel');

   }

}