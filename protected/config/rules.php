<?php

return array(

	'admin' => 'admin/admin',
	'admin/login' => 'admin/admin/login',
	'admin/logout' => 'admin/admin/logout',
	'admin/<id:\d+>' => 'admin/admin/show/<id>',

	'site/page/<pageName>' => 'site/page',
	'<controller:\w+>/<id:\d+>' => '<controller>/view',
	'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
	'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
);
