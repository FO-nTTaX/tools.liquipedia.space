<?php

$text = '';
$sData = file_get_contents( 'https://liquipedia.net/starcraft/skins/Bruinen/skin.json' );
$aData = json_decode( $sData, true );
$aThemes = [];
foreach ( $aData[ 'ResourceModules' ] as $sName => $aResourceModule ) {
	if ( strpos( $sName, 'skins.bruinen.theme.' ) === 0 ) {
		$aThemes[ $aResourceModule[ 'variables' ][ 'bruinen-theme-name' ] ] = [
			'primary' => $aResourceModule[ 'variables' ][ 'wiki-color-primary' ],
			'secondary' => $aResourceModule[ 'variables' ][ 'wiki-color-secondary' ],
		];
	}
}
$text .= '<h2>By theme name</h2>';
ksort( $aThemes );
$text .= '<table><tbody>';
$text .= '<tr><th>Theme</th><th>Primary</th><th>Secondary</th></tr>';
foreach ( $aThemes as $sName => $aData ) {
	$text .= '<tr>';
	$text .= '<td>' . htmlspecialchars( $sName ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'primary' ] ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'secondary' ] ) . '</td>';
	$text .= '</tr>';
}
$text .= '</tbody></table>';

$text .= '<h2>By primary color</h2>';
uasort( $aThemes, function( $a, $b ) {
	if ( $a[ 'primary' ] !== $b[ 'primary' ] ) {
		return $a[ 'primary' ] > $b[ 'primary' ];
	}
	return $a[ 'secondary' ] > $b[ 'secondary' ];
} );
$text .= '<table><tbody>';
$text .= '<tr><th>Theme</th><th>Primary</th><th>Secondary</th></tr>';
foreach ( $aThemes as $sName => $aData ) {
	$text .= '<tr>';
	$text .= '<td>' . htmlspecialchars( $sName ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'primary' ] ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'secondary' ] ) . '</td>';
	$text .= '</tr>';
}
$text .= '</tbody></table>';

$text .= '<h2>By secondary color</h2>';
uasort( $aThemes, function( $a, $b ) {
	if ( $a[ 'secondary' ] !== $b[ 'secondary' ] ) {
		return $a[ 'secondary' ] > $b[ 'secondary' ];
	}
	return $a[ 'primary' ] > $b[ 'primary' ];
} );
$text .= '<table><tbody>';
$text .= '<tr><th>Theme</th><th>Primary</th><th>Secondary</th></tr>';
foreach ( $aThemes as $sName => $aData ) {
	$text .= '<tr>';
	$text .= '<td>' . htmlspecialchars( $sName ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'primary' ] ) . '</td>';
	$text .= '<td>' . htmlspecialchars( $aData[ 'secondary' ] ) . '</td>';
	$text .= '</tr>';
}
$text .= '</tbody></table>';
