<?php

$text = '<p>liquipedia.tools is a collection of tools that are aimed to make the life of Liquipedia editors a bit easier. The collection started sometime in 2016 and has since been expended.</p>
<p>Available tools:</p>
<ul>';
foreach ( $CONFIG[ 'views' ] as $viewkey => $listview ) {
	if ( $viewkey != 'home' ) {
		$text .= '<li><a href="?view=' . $viewkey . '">' . $listview[ 'name' ] . '</a></li>';
	}
}
$text .= '</ul>';
