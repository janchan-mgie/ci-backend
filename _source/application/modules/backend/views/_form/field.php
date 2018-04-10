<div class="<?php echo isset($wrapper_class) ? $wrapper_class : 'col-md-12'; ?>">
  <label for="<?php echo $input_id; ?>" class="control-label"><?php $this->load->view('required'); ?><?php echo $label; ?></label>
  <div class="form-group">
    <?php $this->load->view($form_input_type); ?>
    <span class="text-danger"><?php echo form_error($input_id);?></span>
  </div>
</div>
