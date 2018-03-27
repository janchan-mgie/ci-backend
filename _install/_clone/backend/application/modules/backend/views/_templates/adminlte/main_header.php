<!-- Main Header -->
<header class="main-header">

  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>A</b>LT</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b>LTE</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php $hide = $this->config->item('hide', 'backend'); ?>
        <?php if (!isset($hide['main_header/messages_menu']) || (!$hide['main_header/messages_menu'])) { ?>
        <!-- Messages: style can be found in dropdown.less-->
        <?php $this->template->loadView('main_header/messages_menu'); ?>
        <?php } ?>
        <?php if (!isset($hide['main_header/notifications_menu']) || (!$hide['main_header/notifications_menu'])) { ?>
        <!-- Notifications Menu -->
        <?php $this->template->loadView('main_header/notifications_menu'); ?>
        <?php } ?>
        <!-- Tasks Menu -->
        <?php $this->template->loadView('main_header/tasks_menu'); ?>
        <!-- User Account Menu -->
        <?php $this->template->loadView('main_header/user_menu'); ?>

        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
