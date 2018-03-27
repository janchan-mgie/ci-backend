<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <?php $this->template->loadView('main_side_bar/user_panel'); ?>

    <!-- search form (Optional) -->
    <?php $this->template->loadView('main_side_bar/search'); ?>

    <!-- Sidebar Menu -->
    <?php $this->template->loadView('main_side_bar/side_menu'); ?>
  </section>
  <!-- /.sidebar -->
</aside>
