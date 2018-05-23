<?php

$text = '';
$text .= '<form method="post" action="?view=search"><input type="search" name="search"></form>';
if ( isset( $_POST[ 'search' ] ) ) {
	$search = urlencode( htmlspecialchars( $_POST[ 'search' ] ) );
	$CONFIG[ 'wikis' ] = json_decode( file_get_contents( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis', false, $CONFIG[ 'httpcontext' ] ), true );
	foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
		$text .= '<h2 id="' . $sWiki . '">' . $aWiki[ 'name' ] . '</h2>';
		$bHasPages = true;
		$sContinue = '&continue=';
		$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=search&srsearch=' . $search . '&srnamespace=0|4|10&srlimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
		$aPages = json_decode( $sPages, true );
		if ( (isset( $aPages[ 'query' ][ 'search' ] )) && (count( $aPages[ 'query' ][ 'search' ] ) > 0) ) {
			$bHasPages = true;
			$text .= '<ol>';
			foreach ( $aPages[ 'query' ][ 'search' ] as $aPage ) {
				$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a><br>' . $aPage[ 'snippet' ] . '</li>';
			}
		} else {
			$bHasPages = false;
		}
		if ( isset( $aPages[ 'continue' ][ 'sroffset' ] ) ) {
			$sContinue = '&continue=&sroffset=' . $aPages[ 'continue' ][ 'sroffset' ];
		} else {
			$sContinue = false;
		}
		while ( $sContinue ) {
			$sPages = file_get_contents( $aWiki[ 'api' ] . '?action=query&format=json&list=search&srsearch=' . $search . '&srnamespace=0|4|10&srlimit=' . $CONFIG[ 'listlimit' ] . $sContinue, false, $CONFIG[ 'httpcontext' ] );
			$aPages = json_decode( $sPages, true );
			foreach ( $aPages[ 'query' ][ 'search' ] as $aPage ) {
				$text .= '<li><a target="_blank" href="' . $CONFIG[ 'wikis' ][ 'baseurl' ] . '/' . $sWiki . '/' . str_replace( ' ', '_', $aPage[ 'title' ] ) . '">' . $aPage[ 'title' ] . '</a><br>' . $aPage[ 'snippet' ] . '</li>';
			}
			if ( isset( $aPages[ 'continue' ][ 'sroffset' ] ) ) {
				$sContinue = '&continue=&sroffset=' . $aPages[ 'continue' ][ 'sroffset' ];
			} else {
				$sContinue = false;
			}
		}
		if ( $bHasPages ) {
			$text .= '</ol>';
		}
	}
}
