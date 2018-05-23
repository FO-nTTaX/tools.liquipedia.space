<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis', false, $CONFIG[ 'httpcontext' ] ), true );
$text = '';

foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<h2 id="' . $sWiki . '">' . $aWiki[ 'name' ] . '</h2>';
	$bHasPages = true;
	$sContinue = '&continue=';
	$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=oldreviewedpages&ornamespace=0|4|10&orlimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
	$aPages = json_decode( $sPages, true );
	if ( (isset( $aPages[ 'query' ][ 'oldreviewedpages' ] )) && (count( $aPages[ 'query' ][ 'oldreviewedpages' ] ) > 0) ) {
		$bHasPages = true;
		$text .= '<ol>';
		foreach ( $aPages[ 'query' ][ 'oldreviewedpages' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
	} else {
		$bHasPages = false;
	}
	if ( isset( $aPages[ 'continue' ][ 'orstart' ] ) ) {
		$sContinue = '&continue=&orstart=' . $aPages[ 'continue' ][ 'orstart' ];
	} else {
		$sContinue = false;
	}
	while ( $sContinue ) {
		$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=oldreviewedpages&ornamespace=0|4|10&orlimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
		$aPages = json_decode( $sPages, true );
		foreach ( $aPages[ 'query' ][ 'oldreviewedpages' ] as $aPage ) {
			$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a></li>';
		}
		if ( isset( $aPages[ 'continue' ][ 'orstart' ] ) ) {
			$sContinue = '&continue=&orstart=' . $aPages[ 'continue' ][ 'orstart' ];
		} else {
			$sContinue = false;
		}
	}
	if ( $bHasPages ) {
		$text .= '</ol>';
	}
}
