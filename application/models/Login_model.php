<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
     function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->database();
     }

     function get_user($usr, $pwd)
     {
          $sql = "select * from account where username = '".$usr."' and password = '". md5($pwd)."'";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }
}
?>