<?php

$menu = '<nav class="topnav"><ul>';
foreach ( $CONFIG[ 'views' ] as $viewkey => $menuview ) {
	if ( $menuview[ 'inmenu' ] ) {
		$menu .= '<li><a href="?view=' . $viewkey . '"' . (($view == $viewkey) ? ' class="active"' : '') . '>' . $menuview[ 'name' ] . '</a></li>';
	}
}
$menu .= '</ul></nav>';
