<?php

$CONFIG = array(
	'httpcontext' => stream_context_create(
		array(
			'http' => array(
				'method' => "GET",
				'header' => "User-Agent: FO-nTTaX Tools\r\n"
			)
		)
	),
	'wikibaseurl' => 'http://liquipedia.net',
	'listlimit' => 200,
	'views' => array(
		'home' => array(
			'name' => 'Home',
			'inmenu' => true
		),
		'recentchanges' => array(
			'name' => 'Recent Changes',
			'inmenu' => true
		),
		'pendingchanges' => array(
			'name' => 'Pending Changes',
			'inmenu' => true
		),
		'unreviewedpages' => array(
			'name' => 'Unreviewed Pages',
			'inmenu' => true
		),
		'search' => array(
			'name' => 'Search',
			'inmenu' => true
		),
		'github' => array(
			'name' => 'GitHub',
			'inmenu' => false
		),
		'templateparameter' => array(
			'name' => 'Find Template Parameters',
			'inmenu' => false
		)
	)
);

?>
