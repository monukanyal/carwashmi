<h3>Members page..</h3>
<p>
<?php
//print_r($this->session->all_userdata());

?></p>Welcome&nbsp;<?php 
 echo $this->session->userdata('username'); ?>&nbsp;&nbsp;
<a href='<?php echo base_url()."main/logout"  ?>'>Logout</a>
