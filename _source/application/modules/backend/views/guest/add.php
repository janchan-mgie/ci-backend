<?php echo form_open($controller_url . 'add', array("class"=>"form-horizontal")); ?>
	<div class="form-group">
		<label for="firstname" class="col-md-4 control-label"><span class="text-danger">*</span>First Name</label>
		<div class="col-md-8">
      <input type="text" name="firstname" value="<?php echo $this->input->post('firstname'); ?>" />
      <span class="text-danger"><?php echo form_error('firstname');?></span>
    </div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-md-4 control-label"><span class="text-danger">*</span>Last Name</label>
		<div class="col-md-8">
      <input type="text" name="lastname" value="<?php echo $this->input->post('lastname'); ?>" />
      <span class="text-danger"><?php echo form_error('lastname');?></span>
    </div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">
				<i class="fa fa-check"></i> Save
			</button>
			<button type="button" class="btn btn-danger" onclick="window.history.back();">
				<i class="fa fa-close"></i> Back
			</button>
    </div>
	</div>
<?php echo form_close(); ?>
