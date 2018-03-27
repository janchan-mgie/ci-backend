<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//
$config['template'] = 'adminlte';
$config['auth_base'] = 'backend';
$config['auth_front_page'] = 'backend/home';
//
$config['hide']['main_header/messages_menu'] = TRUE;
//
$config['side_menu_style'] = array(
  'menu_item' => '<a href="||URL||" target="||TARGET||"><i class="||ICON||"></i> <span>||NAME||</span>||EXPAND||</a>||CHILDMENU||',
  'expand' => '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
  'active_class' => 'active',
  'header_class' => 'header',
  'parent_class' => 'treeview',
  'child_class' => 'treeview-menu'
);

$config['side_menu'] = array(
  'header' => array(
    'type' => 'header',
    'name' => 'HEADER'
  ),
	'home' => array(
		'name'		=> '首頁',
		'url'		=> $config['auth_front_page'],
		'icon'		=> 'fa fa-home',
	),
	'user' => array(
		'name'		=> 'Users',
		'url'		=> '',
		'icon'		=> 'fa fa-users',
		'children'  => array(
      array(
  			'name'		=> 'List',
  			'url'		=> $config['auth_base'] . '/users_list',
				'icon'		=> 'fa fa-pencil-square',
  		),
			array(
				'name'		=> 'Create',
				'url'		=> $config['auth_base'] . '/create_user',
				'icon'		=> 'fa fa-pencil-square',
			),
			array(
				'name'		=> 'User Groups',
				'url'		=> $config['auth_base'] . '/create_group',
				'icon'		=> 'fa fa-pencil-square',
			),
		)
	),
  'admin' => array(
    'type' => 'header',
    'name' => 'ADMIN'
  ),
	'panel' => array(
		'name'		=> 'Backend',
		'url'		=> '',
		'icon'		=> 'fa fa-cog',
		'children'  => array(
      array(
  			'name'		=> 'List',
  			'url'		=> $config['auth_base'] . '/temp',
				'icon'		=> 'fa fa-pencil-square',
        // (check BLOCK before ALLOW)
        'allow' => array('admin'),
  		),
			array(
				'name'		=> 'Create',
				'url'		=> $config['auth_base'] . '/user/create',
				'icon'		=> '',
        'allow' => array('admin'),
        // 'block' => array('staff'),
			),
			array(
				'name'		=> 'User Groups',
				'url'		=> $config['auth_base'] . '/user/group',
        'block' => array('staff'),
			),
		)
	),
	'util' => array(
		'name'		=> 'Utilities',
		'url'		=> 'util',
		'icon'		=> 'fa fa-cogs',
    // 'allow' => array('admin'),
		'children'  => array(
      array(
  			'name'		=> 'Database Versions',
  			'url'		=> 'util/list_db',
				'icon'		=> 'fa fa-pencil-square',
  		)
		)
	),
  'account' => array(
    'type' => 'header',
  ),
	'extlink' => array(
		'name'		=> 'External Link',
		'url'		=> 'https://google.com',
		'icon'		=> 'fa fa-cogs'
  ),
	'logout' => array(
		'name'		=> '登出',
		'url'		=> 'auth/logout',
		'icon'		=> 'fa fa-sign-out',
	)
);
