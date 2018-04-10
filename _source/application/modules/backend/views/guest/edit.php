<div class="row">
  <div class="col-md-12">
  	<div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Guest Edit</h3>
      </div>
  		<?php echo form_open($controller_url . 'edit/'. $guest['id']); ?>
  			<div class="box-body">
  				<div class="row clearfix">
  					<div class="col-md-12">
  						<label for="firstname" class="control-label"><span class="text-danger"></span>First Name</label>
  						<div class="form-group">
                <input type="text" name="firstname" value="<?php echo $guest['firstname']; ?>" />
  							<span class="text-danger"><?php echo form_error('firstname');?></span>
  						</div>
  					</div>
  					<div class="col-md-12">
  						<label for="lastname" class="control-label"><span class="text-danger"></span>Last Name</label>
  						<div class="form-group">
                <input type="text" name="lastname" value="<?php echo $guest['lastname']; ?>" />
  							<span class="text-danger"><?php echo form_error('lastname');?></span>
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="box-footer">
        	<button type="submit" class="btn btn-success">
  					<i class="fa fa-check"></i> Save
  				</button>
    			<button type="button" class="btn btn-danger" onclick="window.history.back();">
    				<i class="fa fa-close"></i> Back
    			</button>
        </div>
  	  <?php echo form_close(); ?>
    </div>
  </div>
</div>
