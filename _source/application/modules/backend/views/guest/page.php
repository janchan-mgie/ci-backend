<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Guest List</h3>
        <div class="box-tools">
          <a href="<?php echo site_url($controller_url . 'add'); ?>" class="btn btn-success btn-sm">Add</a>
        </div>
      </div>
      <div class="box-body">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Guest name</th>
              <?php if ($this->ion_auth->is_admin()) { ?>
              <th>Email</th>
              <?php } ?>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($guest_list as $record) { ?>
            <tr>
              <td>
                <?php echo $record['id']; ?>
              </td>
              <td>
                <?php echo $record['firstname'] . ' ' . $record['lastname']; ?>
              </td>
              <?php if ($this->ion_auth->is_admin()) { ?>
              <td>
                <?php echo $record['email']; ?>
              </td>
              <?php } ?>
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
