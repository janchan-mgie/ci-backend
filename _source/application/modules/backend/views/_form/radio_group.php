<?php
foreach ($options as $key => $radio_info) {
  $radio_tag = form_radio(
    array(
      'name' => $input_id,
      'value' => $radio_info['value'],
      'checked' => ($radio_info['value'] === $selected),
      'id' => $radio_info['id']
    )
  );
?><label class="radio-inline" for="<?php echo $radio_info['id']; ?>"><?php echo $radio_tag ?><?php echo $radio_info['label']; ?></label>
<?php } ?>
