<a href="<?php echo site_url('admin/send/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Send'); ?></h5>
<!--Data display of send with id-->
<?php
$c = $send;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Agent Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['agent_users_id']);
echo $dataArr['email'];
?>
									</td>
	</tr>

	<tr>
		<td>Subject</td>
		<td><?php echo $c['subject']; ?></td>
	</tr>

	<tr>
		<td>Note</td>
		<td><?php echo $c['note']; ?></td>
	</tr>

	<tr>
		<td>Phone No</td>
		<td><?php echo $c['phone_no']; ?></td>
	</tr>

	<tr>
		<td>Amount</td>
		<td><?php echo $c['amount']; ?></td>
	</tr>

	<tr>
		<td>Assigned Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['assigned_users_id']);
echo $dataArr['email'];
?>
									</td>
	</tr>

	<tr>
		<td>Status</td>
		<td><?php echo $c['status']; ?></td>
	</tr>

	<tr>
		<td>Created At</td>
		<td><?php echo $c['created_at']; ?></td>
	</tr>

	<tr>
		<td>Updated At</td>
		<td><?php echo $c['updated_at']; ?></td>
	</tr>


</table>
<!--End of Data display of send with id//-->
