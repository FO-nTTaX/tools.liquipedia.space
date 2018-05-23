<?php

$githubbaseurl = 'https://github.com/';
$githubteam = 'Liquipedia';
$gitinfo = json_decode( file_get_contents( 'https://api.github.com/orgs/' . $githubteam . '/events', false, $CONFIG[ 'httpcontext' ] ), true );
$text = '';

$text .= '<ul>';
foreach ( $gitinfo as $gitevent ) {
	if ( $gitevent[ 'type' ] == 'PushEvent' ) {
		$text .= '<li>';
		$text .= '<strong><a target="_blank" href="' . $githubbaseurl . $gitevent[ 'repo' ][ 'name' ] . '/tree/' . str_replace( 'refs/heads/', '', $gitevent[ 'payload' ][ 'ref' ] ) . '">' . str_replace( $githubteam . '/', '', $gitevent[ 'repo' ][ 'name' ] ) . '</strong> [<em>' . str_replace( 'refs/heads/', '', $gitevent[ 'payload' ][ 'ref' ] ) . '</em>]</a>';
		$text .= ' - <a target="_blank" href="' . $githubbaseurl . $gitevent[ 'actor' ][ 'login' ] . '">' . $gitevent[ 'actor' ][ 'display_login' ] . '</a>';
		$text .= '<ul>';
		foreach ( $gitevent[ 'payload' ][ 'commits' ] as $commit ) {
			$text .= '<li>';
			$text .= '<strong><a target="_blank" href="' . $githubbaseurl . $gitevent[ 'repo' ][ 'name' ] . '/commit/' . $commit[ 'sha' ] . '">' . substr( $commit[ 'sha' ], 0, 7 ) . '</a></strong>: ' . $commit[ 'message' ];
			$text .= '</li>';
		}
		$text .= '</ul>';
		$text .= '</li>';
	}
}
$text .= '</ul>';
$text .= 'Commits to the <a target=_blank" href="' . $githubbaseurl . $githubteam . '">' . $githubteam . ' GitHub</a>';
