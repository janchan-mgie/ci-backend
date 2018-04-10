<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Guest Photo List</h3>
        <div class="box-tools">
          <a href="<?php echo site_url($controller_url . 'add'); ?>" class="btn btn-success btn-sm">Add</a>
        </div>
      </div>
      <div class="box-body">
      <?php
      $this->table->set_template(array('table_open' => '<table class="table table-striped">'));
      $this->table->set_caption('Guest Photo List');
      $this->table->set_heading('ID', 'Guest name', 'Photo URL', 'Saved', 'Actions');
      foreach ($guest_photo_list as $record) {
        $row_record = array();
        $row_record[] = $record['id'];
        $row_record[] = $record['guest']['firstname'] . ' ' . $record['guest']['lastname'];
        $row_record[] = $record['photo']['img_url'];
        $row_record[] = ($record['saved'] !== 'Y') ? 'N' : 'Y';
        $row_record[] =
          '<a href="' . site_url($controller_url . 'edit/' . $record['id']) . '" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>' .
          '&nbsp' .
          '<a href="'. site_url($controller_url . 'remove/' . $record['id']) . '" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>';
        $this->table->add_row($row_record);
      }
      // echo $this->table->generate();
      $this->table->clear();
      // echo $total_records;
      ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Guest name</th>
              <th>Photo URL</th>
              <th>Saved</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($guest_photo_list as $record) { ?>
            <tr>
              <td>
                <?php echo $record['id'];?>
              </td>
              <td>
                <?php echo $record['guest']['firstname'] . ' ' . $record['guest']['lastname']; ?>
              </td>
              <td>
                <?php echo $record['photo']['img_url']; ?>
              </td>
              <td>
                <?php echo ($record['saved'] !== 'Y') ? 'N' : 'Y'; ?>
              </td>
              <td>
                <a href="<?php echo site_url($controller_url . 'edit/' . $record['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a>
                <a href="<?php echo site_url($controller_url . 'remove/' . $record['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div class="pull-right">
          <ul class="pagination pagination-sm inline">
            <?php echo $pagination; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
