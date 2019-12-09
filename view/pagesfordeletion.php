<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );
$sCategory = 'Category:Articles_listed_for_deletion';
$iTotal = 0;
$text = '';

$text .= '<table>';
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$sData = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&format=json&prop=categoryinfo&titles=' . $sCategory );
	$aData = json_decode( $sData, true );
	$aPageData = array_values( $aData[ 'query' ][ 'pages' ] )[ 0 ];
	$text .= '<tr>';
	$text .= '<th>';
	$text .= $aWiki[ 'name' ];
	$text .= '</th>';
	$text .= '<td>';
	$text .= '<a target="_blank" href="' . $CONFIG[ 'wikibaseurl' ] . '/' . $sWiki . '/' . $sCategory . '">';
	if ( array_key_exists( 'categoryinfo', $aPageData ) ) {
		$text .= $aPageData[ 'categoryinfo' ][ 'size' ];
		$iTotal += $aPageData[ 'categoryinfo' ][ 'size' ];
	} else {
		$text .= 0;
	}
	$text .= '</a>';
	$text .= '</td>';
	$text .= '</tr>';
}
$text .= '<tr>';
$text .= '<th>';
$text .= 'Total';
$text .= '</th>';
$text .= '<td>';
$text .= $iTotal;
$text .= '</td>';
$text .= '</tr>';
$text .= '</table>';
