<?php

require __DIR__ . '/../../../db_conf/db.php';
$CONFIG = [
	'httpcontext' => stream_context_create(
		[
			'http' => [
				'method' => 'GET',
				'header' => "User-Agent: FO-nTTaX Tools\r\nAccept-Encoding: gzip,deflate,sdch\r\n"
			]
		]
	),
	'wikibaseurl' => 'https://liquipedia.net',
	'listlimit' => 200,
	'views' => [
		'home' => [
			'name' => 'Home',
			'inmenu' => true
		],
		'recentchanges' => [
			'name' => 'Recent Changes',
			'inmenu' => true
		],
		'pendingchanges' => [
			'name' => 'Pending Changes',
			'inmenu' => true
		],
		'unreviewedpages' => [
			'name' => 'Unreviewed Pages',
			'inmenu' => true
		],
		'search' => [
			'name' => 'Search',
			'inmenu' => true
		],
		'log' => [
			'name' => 'Log',
			'inmenu' => true
		],
		'github' => [
			'name' => 'GitHub',
			'inmenu' => false
		],
		'templateparameter' => [
			'name' => 'Find Template Parameters',
			'inmenu' => false
		],
		'discord' => [
			'name' => 'Discord',
			'inmenu' => false
		],
		'timezonedetect' => [
			'name' => 'Timezone Detect',
			'inmenu' => false
		]
	],
	'db' => [
		'user' => $user,
		'password' => $password
	]
];
?>
