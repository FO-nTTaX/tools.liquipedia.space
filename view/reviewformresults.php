<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );

$text = '<h2>Liquipedia Review Form Results</h2>';
$text .= '<table>';

$text .= '<tr>';
$text .= '<th></th>';
$text .= '<th>Crisp as pizza</th>';
$text .= '<th>#blamesalle</th>';
$text .= '<th>and Ricci</th>';
$text .= '</tr>';

$btnnames = [ 'MediaWiki:Btn1', 'MediaWiki:Btn2', 'MediaWiki:Btn3' ];
$totals = [];
foreach ( $btnnames as $btnname ) {
	$totals[ $btnname ] = 0;
}
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$api = $aWiki[ 'api' ];
	$text .= '<tr>';
	$text .= '<th>' . $aWiki[ 'name' ] . '</th>';
	$result = json_decode( file_get_contents_gzip( $api . '?action=query&prop=revisions&rvprop=content&format=json&titles=' . implode( '|', $btnnames ) . '&formatversion=2' ), true );
	$btns = [];
	foreach ( $result[ 'query' ][ 'pages' ] as $page ) {
		if ( array_key_exists( 'missing', $page ) && $page[ 'missing' ] ) {
			$btns[ $page[ 'title' ] ] = 0;
		} else {
			$btns[ $page[ 'title' ] ] = $page[ 'revisions' ][ 0 ][ 'content' ];
			$totals[ $page[ 'title' ] ] += (int) $btns[ $page[ 'title' ] ];
		}
	}
	foreach ( $btnnames as $btnname ) {
		$text .= '<td>' . $btns[ $btnname ] . '</td>';
	}
	$text .= '</tr>';
}

$text .= '<tr>';
$text .= '<th>Total</th>';
foreach ( $btnnames as $btnname ) {
	$text .= '<td>' . $totals[ $btnname ] . '</td>';
}
$text .= '</tr>';

$text .= '</table>';
