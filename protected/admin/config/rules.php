<?php

return array(

	'admin' => 'admin',

	'admin/login' => 'admin/login',
	'admin/logout' => 'admin/logout',
	'admin/remember' => 'admin/remember',

	// for sort widget
	'admin/<widget:\w+>/sort/<path:\w+>/<id:\d+>' => 'admin/show/action/sort',

	'admin/<widget:\w+>/<id:\d+>' => 'admin/show/action/update',
	'admin/<widget:\w+>/<action:\w+>' => 'admin/show',
	'admin/<widget:\w+>/<action:\w+>/<id:\d+>' => 'admin/show',
	'admin/<widget:\w+>' => 'admin/show',

);
