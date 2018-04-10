<div class="row">
  <div class="col-md-12">
  	<div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">Guest Photo Add</h3>
      </div>
			<?php echo form_open($controller_url . 'add'); ?>
  			<div class="box-body">
  				<div class="row clearfix">
            <?php
            $input_list[] = array(
              'type' => 'dropdown',
              'wrapper_class' => 'col-md-6',
              'required' => TRUE,
              'label' => 'Guest',
              'input_id' => 'guest_id',
              'data_list' => $all_guest,
            );
            $input_list[] = array(
              'type' => 'dropdown',
              'required' => TRUE,
              'label' => 'Photo',
              'input_id' => 'photo_id',
              'data_list' => $all_photo,
            );
            $input_list[] = array(
              'type' => 'radio_group',
              'wrapper_class' => 'col-md-6',
              'required' => TRUE,
              'label' => 'Saved',
              'input_id' => 'saved',
              'selected' => 'N',
              'options' => array(
                array(
                  'label' => 'Yes',
                  'id' => 'saved-y',
                  'value' => 'Y',
                ),
                array(
                  'label' => 'No',
                  'id' => 'saved-n',
                  'value' => 'N',
                ),
              )
            );
            echo $this->form->create_all($input_list);
            ?>
  				</div>
  			</div>
  			<div class="box-footer">
        	<button type="submit" class="btn btn-success">
  					<i class="fa fa-check"></i> Save
  				</button>
        	<button type="button" class="btn btn-danger" onclick="window.location.href='<?php echo $back_url; ?>';">
  					<i class="fa fa-close"></i> Back
  				</button>
        </div>
  	  <?php echo form_close(); ?>
    </div>
  </div>
</div>
