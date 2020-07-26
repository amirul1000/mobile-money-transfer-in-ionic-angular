<a href="<?php echo site_url('admin/transactions/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php echo str_replace('_',' ','Transactions'); ?></h5>
<!--Data display of transactions with id-->
<?php
$c = $transactions;
?>
<table class="table table-striped table-bordered">
	<tr>
		<td>Users</td>
		<td><?php
$this->CI = & get_instance();
$this->CI->load->database();
$this->CI->load->model('Users_model');
$dataArr = $this->CI->Users_model->get_users($c['users_id']);
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
		<td>Debit</td>
		<td><?php echo $c['debit']; ?></td>
	</tr>

	<tr>
		<td>Credit</td>
		<td><?php echo $c['credit']; ?></td>
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
<!--End of Data display of transactions with id//-->
