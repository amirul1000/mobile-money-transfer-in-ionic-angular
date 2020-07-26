<a href="<?php echo site_url('admin/send/index'); ?>"
	class="btn btn-info"><i class="arrow_left"></i> List</a>
<h5 class="font-20 mt-15 mb-1"><?php if($id<0){echo "Save";}else { echo "Update";} echo " "; echo str_replace('_',' ','Send'); ?></h5>
<!--Form to save data-->
<?php echo form_open_multipart('admin/send/save/'.$send['id'],array("class"=>"form-horizontal")); ?>
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<label for="Agent Users" class="col-md-4 control-label">Agent Users</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Users_model');
        $dataArr = $this->CI->Users_model->get_all_users();
        ?> 
          <select name="agent_users_id" id="agent_users_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($send['agent_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Subject" class="col-md-4 control-label">Subject</label>
			<div class="col-md-8">
				<input type="text" name="subject"
					value="<?php echo ($this->input->post('subject') ? $this->input->post('subject') : $send['subject']); ?>"
					class="form-control" id="subject" />
			</div>
		</div>
		<div class="form-group">
			<label for="Note" class="col-md-4 control-label">Note</label>
			<div class="col-md-8">
				<textarea name="note" id="note" class="form-control" rows="4" /><?php echo ($this->input->post('note') ? $this->input->post('note') : $send['note']); ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="Phone No" class="col-md-4 control-label">Phone No</label>
			<div class="col-md-8">
				<input type="text" name="phone_no"
					value="<?php echo ($this->input->post('phone_no') ? $this->input->post('phone_no') : $send['phone_no']); ?>"
					class="form-control" id="phone_no" />
			</div>
		</div>
		<div class="form-group">
			<label for="Amount" class="col-md-4 control-label">Amount</label>
			<div class="col-md-8">
				<input type="text" name="amount"
					value="<?php echo ($this->input->post('amount') ? $this->input->post('amount') : $send['amount']); ?>"
					class="form-control" id="amount" />
			</div>
		</div>
		<div class="form-group">
			<label for="Assigned Users" class="col-md-4 control-label">Assigned
				Users</label>
			<div class="col-md-8"> 
          <?php
        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Users_model');
        $dataArr = $this->CI->Users_model->get_all_users();
        ?> 
          <select name="assigned_users_id" id="assigned_users_id"
					class="form-control" />
				<option value="">--Select--</option> 
            <?php
            for ($i = 0; $i < count($dataArr); $i ++) {
                ?> 
            <option value="<?=$dataArr[$i]['id']?>"
					<?php if($send['assigned_users_id']==$dataArr[$i]['id']){ echo "selected";} ?>><?=$dataArr[$i]['email']?></option> 
            <?php
            }
            ?> 
          </select>
			</div>
		</div>
		<div class="form-group">
			<label for="Status" class="col-md-4 control-label">Status</label>
			<div class="col-md-8"> 
           <?php
        $enumArr = $this->customlib->getEnumFieldValues('send', 'status');
        ?> 
           <select name="status" id="status" class="form-control" />
				<option value="">--Select--</option> 
             <?php
            for ($i = 0; $i < count($enumArr); $i ++) {
                ?> 
             <option value="<?=$enumArr[$i]?>"
					<?php if($send['status']==$enumArr[$i]){ echo "selected";} ?>><?=ucwords($enumArr[$i])?></option> 
             <?php
            }
            ?> 
           </select>
			</div>
		</div>

	</div>
</div>
<div class="form-group">
	<div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-success"><?php if(empty($send['id'])){?>Save<?php }else{?>Update<?php } ?></button>
	</div>
</div>
<?php echo form_close(); ?>
<!--End of Form to save data//-->
<!--JQuery-->
<script>
	$( ".datepicker" ).datepicker({
		dateFormat: "yy-mm-dd", 
		changeYear: true,
		changeMonth: true,
		showOn: 'button',
		buttonText: 'Show Date',
		buttonImageOnly: true,
		buttonImage: '<?php echo base_url(); ?>public/datepicker/images/calendar.gif',
	});
</script>
