<?php

$db = new PDO( 'mysql:dbname=liquipedia_discord;host=localhost', $CONFIG[ 'db' ][ 'user' ], $CONFIG[ 'db' ][ 'password' ] );
$res = $db->prepare( 'SELECT `user`, SUM(`counter`) as `count` FROM `liquipedia_discord` GROUP BY `user_id` ORDER BY `count` DESC LIMIT 500' );
$res->execute();
$text = '';
$text .= '<h2>Liquipedia Discord spammers</h2>';
$text .= '<table>';
$text .= '<tr><th>#</th><th>User</th><th>Count</th></tr>';
$i = 0;
while ( $row = $res->fetchObject() ) {
	$text .= '<tr>';
	$text .= '<th>' . ( ++$i ) . '</th>';
	$text .= '<td>' . $row->user . '</td>';
	$text .= '<td>' . $row->count . '</td>';
	$text .= '</tr>';
}
$text .= '</table>';
