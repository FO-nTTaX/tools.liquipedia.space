<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );
ksort( $CONFIG[ 'wikis' ][ 'allwikis' ] );

$text = '';

$text .= '<div class="table-responsive">';
$text .= '<table>';
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<tr>';
	$text .= '<th>' . $aWiki[ 'name' ] . '</th>';
	$sData = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&meta=siteinfo&formatversion=2&format=json&siprop=statistics' );
	$aData = json_decode( $sData, true );
	$text .= '<td>' . $aData[ 'query' ][ 'statistics' ][ 'jobs' ] . '</td>';
	$text .= '</tr>';
}
$text .= '</table>';
$text .= '</div>';
