<?php

$db = new PDO( 'mysql:dbname=liquipedia_discord;host=localhost', $CONFIG[ 'db' ][ 'user' ], $CONFIG[ 'db' ][ 'password' ] );
$res = $db->prepare( 'SELECT `channel`, SUM(`counter`) as `count`, SUM(`naughtycounter`) as `naughtycount` FROM `liquipedia_discord` GROUP BY `channel` ORDER BY `count` DESC LIMIT 500' );
$res->execute();
$text = '<a href="https://discord.gg/liquipedia" target="_blank">Link to the server</a>';
$text .= '<h2>Liquipedia Discord active channels</h2>';
$text .= '<div class="table-responsive">';
$text .= '<table>';
$text .= '<tr><th>#</th><th>Channel</th><th>Count</th><th>Naughty Count</th></tr>';
$i = 0;
while ( $row = $res->fetchObject() ) {
	if ( !in_array( $row->channel, [ 'staff', 'football', 'social-media-suggestions', 'community-twitters' ] ) ) {
		$text .= '<tr>';
		$text .= '<th>' . ( ++$i ) . '</th>';
		$text .= '<td>#' . htmlspecialchars( $row->channel ) . '</td>';
		$text .= '<td>' . $row->count . '</td>';
		$text .= '<td>' . $row->naughtycount . '</td>';
		$text .= '</tr>';
	}
}
$text .= '</table>';
$text .= '</div>';

$res2 = $db->prepare( 'SELECT `user`, SUM(`counter`) as `count`, SUM(`naughtycounter`) as `naughtycount` FROM `liquipedia_discord` GROUP BY `user_id` ORDER BY `count` DESC LIMIT 500' );
$res2->execute();

$text .= '<h2>Liquipedia Discord spammers</h2>';
$text .= '<div class="table-responsive">';
$text .= '<table>';
$text .= '<tr><th>#</th><th>User</th><th>Count</th><th>Naughty Count</th></tr>';
$j = 0;
while ( $row = $res2->fetchObject() ) {
	$text .= '<tr>';
	$text .= '<th>' . ( ++$j ) . '</th>';
	$text .= '<td>' . htmlspecialchars( $row->user ) . '</td>';
	$text .= '<td>' . $row->count . '</td>';
	$text .= '<td>' . $row->naughtycount . '</td>';
	$text .= '</tr>';
}
$text .= '</table>';
$text .= '<div>';
