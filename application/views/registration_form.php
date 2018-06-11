
<?php include'template/menu.php'; ?>

<h3 style="margin-left:140px;">  New user Register Here... 
<?php  echo form_open(base_url().'user/registration'); ?>



 
<table width="" border="0" align="left" style="margin-left:30px; font-size:13px;  font-family:Verdana, Geneva, sans-serif; margin-bottom:20px;">


  <tr>
    <td align="right">First Name</td>
    <td>:</td>
    <td><?php echo form_input('firstname', ''); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('firstname', '<span class="error">', '</span>'); ?></td>
  </tr>
  <tr>
    <td align="right">Last Name</td>
    <td>:</td>
   <td><?php echo form_input('lastname', ''); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('lastname', '<span class="error">', '</span>'); ?></td>
  </tr>
  
    <td align="right">Age</td>
    <td>:</td>
   <td><?php echo form_input('age', ''); ?></td>
  </tr>

  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('age', '<span class="error">', '</span>'); ?></td>
  </tr>
   <tr>
    <td align="right">Gender</td>
    <td>:</td>
   <td align="center">Male<?php echo form_radio('gender', 'male'); ?>
   Female<?php echo form_radio('gender', 'female'); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"></td>
  </tr>
  <tr>
    <td align="right">Email Address</td>
    <td>:</td>
    <td><?php echo form_input('emailad', ''); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('emailad', '<span class="error">', '</span>'); ?></td>
  <tr>
    <td align="right">Username</td>
    <td>:</td>
    <td><?php echo form_input('username', ''); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('username', '<span class="error">', '</span>'); ?></td>
  <tr>
  <tr>
    <td align="right">Password</td>
    <td>:</td>
    <td><?php echo form_password('password', ''); ?></td>
  </tr>
  <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('password', '<span class="error">', '</span>'); ?></td>
  <tr>
  <tr>
    <td align="right">Password Confirmation</td>
    <td>:</td>
    <td><?php echo form_password('cpassword', ''); ?></td>
  </tr>
   <tr>
  <td colspan="4"  height="13" align="right"><?php echo form_error('cpassword', '<span class="error">', '</span>'); ?></td>
  <tr>
  <tr>
<td colspan="3" align="right"><input style="width:90px;" type="submit" value="Register" name="mysubmit "class="classname"/></td>

  </tr><br />
</table>

<?php echo form_close();  ?>

<style>
.error{
color:#FF0000;
}
</style>