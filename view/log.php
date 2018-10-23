<?php

$text = '';
$text .= '<form method="get"><input type="hidden" name="view" value="log"><input type="text" name="type" placeholder="type"></form>';
$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );
$params = '';
if ( isset( $_GET[ 'type' ] ) && !empty( $_GET[ 'type' ] ) ) {
	$params .= '&letype=' . urlencode( htmlspecialchars( $_GET[ 'type' ] ) );
}
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<h2 id="' . $sWiki . '">' . $aWiki[ 'name' ] . '</h2>';
	$sLogEntries = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&format=json&list=logevents&lelimit=500' . $params );
	$aLogEntries = json_decode( $sLogEntries, true );
	$text .= '<table>';
	$text .= '<tr>';
	$text .= '<th>Timestamp</th>';
	$text .= '<th>Title</th>';
	$text .= '<th>Type</th>';
	$text .= '<th>Action</th>';
	$text .= '<th>Params</th>';
	$text .= '</tr>';
	foreach ( $aLogEntries[ 'query' ][ 'logevents' ] as $aLogEvent ) {
		if ( !in_array( $aLogEvent[ 'type' ], [ 'patrol', 'review' ] ) ) {
			$text .= '<tr>';
			$text .= '<td>' . $aLogEvent[ 'timestamp' ] . '</td>';
			$text .= '<td><a href="' . $CONFIG[ 'wikibaseurl' ] . '/' . $sWiki . '/' . $aLogEvent[ 'title' ] . '">' . $aLogEvent[ 'title' ] . '</a></td>';
			$text .= '<td>' . $aLogEvent[ 'type' ] . '</td>';
			$text .= '<td>' . $aLogEvent[ 'action' ] . '</td>';
			$text .= '<td>';
			if ( isset( $aLogEvent[ 'params' ] ) ) {
				foreach ( $aLogEvent[ 'params' ] as $heading => $content ) {
					$text .= '<b>' . $heading . '</b><br>';
					$text .= json_encode( $content ) . '<br>';
				}
			}
			$text .= '</td>';
			$text .= '</tr>';
		}
	}
	$text .= '<table>';
}
?>