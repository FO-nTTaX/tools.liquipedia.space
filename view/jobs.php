<?php

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );

$aWikiData = [];
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$sData = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&meta=siteinfo&formatversion=2&format=json&siprop=statistics' );
	$aData = json_decode( $sData, true );
	$aWikiData[] = [
		'name' => $aWiki[ 'name' ],
		'jobs' => intval( $aData[ 'query' ][ 'statistics' ][ 'jobs' ] ),
	];
}

usort( $aWikiData, function( $a, $b ) {
	if ( $a[ 'jobs' ] === $b[ 'jobs' ] ) {
		return $a[ 'name' ] < $b[ 'name' ] ? -1 : 1;
	}
	return $a[ 'jobs' ] > $b[ 'jobs' ] ? -1 : 1;
} );

$text = '';

$text .= '<div class="table-responsive">';
$text .= '<table>';
foreach ( $aWikiData as $aData ) {
	$text .= '<tr>';
	$text .= '<th>' . $aData[ 'name' ] . '</th>';
	$text .= '<td>' . $aData[ 'jobs' ] . '</td>';
	$text .= '</tr>';
}
$text .= '</table>';
$text .= '</div>';
