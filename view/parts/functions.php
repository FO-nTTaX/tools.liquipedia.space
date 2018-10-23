<?php

function file_get_contents_gzip( $path ) {
	global $CONFIG;
	$content = file_get_contents( $path, false, $CONFIG[ 'httpcontext' ] );
	foreach ( $http_response_header as $c => $h ) {
		if ( stristr( $h, 'content-encoding' ) and stristr( $h, 'gzip' ) ) {
			$content = gzinflate( substr( $content, 10, -8 ) );
		}
	}
	return $content;
}
