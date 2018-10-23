<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );
$text = '';

foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<h2 id="' . $sWiki . '">' . $aWiki[ 'name' ] . '</h2>';
	$bHasPages = true;
	$sContinue = '&continue=';
	$sPages = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&format=json&list=unreviewedpages&urfilterredir=nonredirects&urnamespace=0|4|10&urlimit=' . $CONFIG[ 'listlimit' ] . $sContinue );
	$aPages = json_decode( $sPages, true );
	if ( (isset( $aPages[ 'query' ][ 'unreviewedpages' ] )) && (count( $aPages[ 'query' ][ 'unreviewedpages' ] ) > 0) ) {
		$bHasPages = true;
		$text .= '<ol>';
		foreach ( $aPages[ 'query' ][ 'unreviewedpages' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
	} else {
		$bHasPages = false;
	}
	if ( isset( $aPages[ 'continue' ][ 'urstart' ] ) ) {
		$sContinue = '&continue=&urstart=' . $aPages[ 'continue' ][ 'urstart' ];
	} else {
		$sContinue = false;
	}
	while ( $sContinue ) {
		$sPages = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&format=json&list=unreviewedpages&urfilterredir=nonredirects&urnamespace=0|4|10&urlimit=' . $CONFIG[ 'listlimit' ] . $sContinue );
		$aPages = json_decode( $sPages, true );
		foreach ( $aPages[ 'query' ][ 'unreviewedpages' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
		if ( isset( $aPages[ 'continue' ][ 'urstart' ] ) ) {
			$sContinue = '&continue=&urstart=' . $aPages[ 'continue' ][ 'urstart' ];
		} else {
			$sContinue = false;
		}
	}
	if ( $bHasPages ) {
		$text .= '</ol>';
	}
}
