<?php

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

$CONFIG[ 'wikis' ] = json_decode( file_get_contents_gzip( $CONFIG[ 'wikibaseurl' ] . '/api.php?action=listwikis' ), true );
ksort( $CONFIG[ 'wikis' ][ 'allwikis' ] );
$aInstalledExtensionInformation = [];
$aInstalledExtensions = [];
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$sData = file_get_contents_gzip( $aWiki[ 'api' ] . '?action=query&meta=siteinfo&formatversion=2&format=json&siprop=extensions' );
	$aData = json_decode( $sData, true );
	foreach ( $aData[ 'query' ][ 'extensions' ] as $aExtensionInformation ) {
		if ( !array_key_exists( $aExtensionInformation[ 'name' ], $aInstalledExtensionInformation ) ) {
			$aInstalledExtensionInformation[ $aExtensionInformation[ 'name' ] ] = [];
		}
		$aInstalledExtensionInformation[ $aExtensionInformation[ 'name' ] ] = [
			'version' => array_key_exists( 'version', $aExtensionInformation ) ? $aExtensionInformation[ 'version' ] : null,
			'url' => $aExtensionInformation[ 'url' ],
			'hash' => array_key_exists( 'vcs-version', $aExtensionInformation ) ? $aExtensionInformation[ 'vcs-version' ] : null,
		];
		if ( !array_key_exists( $aExtensionInformation[ 'name' ], $aInstalledExtensions ) ) {
			$aInstalledExtensions[ $aExtensionInformation[ 'name' ] ] = [];
		}
		$aInstalledExtensions[ $aExtensionInformation[ 'name' ] ][ $sWiki ] = true;
	}
}
ksort( $aInstalledExtensionInformation );
#var_dump( $aInstalledExtensions );

$text = '';

$text .= '<div class="table-responsive">';
$text .= '<table>';
$text .= '<tr>';
$text .= '<th></th>';
foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
	$text .= '<th style="writing-mode: vertical-lr; transform: rotate(180deg);">' . $aWiki[ 'name' ] . '</th>';
}
$text .= '</tr>';

foreach ( $aInstalledExtensionInformation as $sExtension => $aExtensionDetails ) {
	$text .= '<tr>';
	$text .= '<th>';
	if ( !is_null( $aExtensionDetails[ 'url' ] ) ) {
		$text .= '<a target="_blank" href="' . $aExtensionDetails[ 'url' ] . '">';
	}
	$text .= $sExtension;
	if ( !is_null( $aExtensionDetails[ 'version' ] ) ) {
		$text .= '<br>' . $aExtensionDetails[ 'version' ];
		if ( !is_null( $aExtensionDetails[ 'hash' ] ) ) {
			$text .= '<br>(' . substr( $aExtensionDetails[ 'hash' ], 0, 7 ) . ')';
		}
	}
	if ( !is_null( $aExtensionDetails[ 'url' ] ) ) {
		$text .= '</a>';
	}
	$text .= '</th>';
	foreach ( $CONFIG[ 'wikis' ][ 'allwikis' ] as $sWiki => $aWiki ) {
		$text .= '<td>';
		if ( !array_key_exists( $sWiki, $aInstalledExtensions[ $sExtension ] ) ) {
			$text .= '-';
		} else {
			$text .= '&#10003;';
		}
		$text .= '</td>';
	}
	$text .= '</tr>';
}
$text .= '</table>';
$text .= '</div>';
