<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis', false, $CONFIG[ 'httpcontext' ] ), true );
$text = '';

foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<h2 id="' . $sWiki . '">' . $aWiki[ 'name' ] . '</h2>';
	$bHasPages = true;
	$sContinue = '&continue=';
	$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=recentchanges&rcprop=title&rcnamespace=0|4|10&rclimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
	$aPages = json_decode( $sPages, true );
	if ( (isset( $aPages[ 'query' ][ 'recentchanges' ] )) && (count( $aPages[ 'query' ][ 'recentchanges' ] ) > 0) ) {
		$bHasPages = true;
		$text .= '<ol>';
		foreach ( $aPages[ 'query' ][ 'recentchanges' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
	} else {
		$bHasPages = false;
	}
	if ( isset( $aPages[ 'query-continue' ][ 'recentchanges' ][ 'rccontinue' ] ) ) {
		$sContinue = '&continue=&rccontinue=' . $aPages[ 'query-continue' ][ 'recentchanges' ][ 'rccontinue' ];
	} else {
		$sContinue = false;
	}
	$i = 1;
	while ( $sContinue ) {
		$i++;
		$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=recentchanges&rcprop=title&rcnamespace=0|4|10&rclimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
		$aPages = json_decode( $sPages, true );
		foreach ( $aPages[ 'query' ][ 'recentchanges' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
		if ( isset( $aPages[ 'query-continue' ][ 'recentchanges' ][ 'rccontinue' ] ) && $i <= 3 ) {
			$sContinue = '&continue=&rccontinue=' . $aPages[ 'query-continue' ][ 'recentchanges' ][ 'rccontinue' ];
		} else {
			$sContinue = false;
		}
	}
	if ( $bHasPages ) {
		$text .= '</ol>';
	}
}
