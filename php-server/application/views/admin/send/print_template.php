<link rel="stylesheet"
	href="<?php echo base_url(); ?>public/css/custom.css">
<h3 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Send'); ?></h3>
Date: <?php echo date("Y-m-d");?>
<hr>
<!--*************************************************
*********mpdf header footer page no******************
****************************************************-->
<htmlpageheader name="firstpage" class="hide"> </htmlpageheader>

<htmlpageheader name="otherpages" class="hide"> <span class="float_left"></span>
<span class="padding_5"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span>
<span class="float_right"></span> </htmlpageheader>
<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />

<htmlpagefooter name="myfooter" class="hide">
<div align="center">
	<br>
	<span class="padding_10">Page {PAGENO} of {nbpg}</span>
</div>
</htmlpagefooter>

<sethtmlpagefooter name="myfooter" value="on" />
<!--*************************************************
*********#////mpdf header footer page no******************
****************************************************-->
<!--Data display of send-->
<table cellspacing="3" cellpadding="3" class="table" align="center">
	<tr>
		<th>Agent Users</th>
		<th>Subject</th>
		<th>Note</th>
		<th>Phone No</th>
		<th>Amount</th>
		<th>Assigned Users</th>
		<th>Status</th>

	</tr>
	<?php foreach($send as $c){ ?>
    <tr>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Users_model');
    $dataArr = $this->CI->Users_model->get_users($c['agent_users_id']);
    echo $dataArr['email'];
    ?>
									</td>
		<td><?php echo $c['subject']; ?></td>
		<td><?php echo $c['note']; ?></td>
		<td><?php echo $c['phone_no']; ?></td>
		<td><?php echo $c['amount']; ?></td>
		<td><?php
    $this->CI = & get_instance();
    $this->CI->load->database();
    $this->CI->load->model('Users_model');
    $dataArr = $this->CI->Users_model->get_users($c['assigned_users_id']);
    echo $dataArr['email'];
    ?>
									</td>
		<td><?php echo $c['status']; ?></td>

	</tr>
	<?php } ?>
</table>
<!--End of Data display of send//-->