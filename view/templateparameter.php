<?php

$work = filter_input( INPUT_POST, 'work' );
if ( !$work ) {
	$work = '';
}

$text = '<form method="post">
<textarea name="work" rows="20" style="width:100%;">' . $work . '</textarea>
<input type="submit">
</form>';

$matches = null;
preg_match_all( '/\{\{\{([^\|\{\}]*)/', $work, $matches );
$paramnames = array_unique( $matches[ 1 ] );
$docexample = '<pre>|\'\'\'';
$docexample .= implode( "='''<br>|'''", $paramnames );
$docexample .= '=\'\'\'</pre>';
sort( $paramnames );
$paramnamelist = '<ul><li><code>';
$paramnamelist .= implode( '</code></li><li><code>', $paramnames );
$paramnamelist .= '</code></li></ul>';

if ( $work != '' ) {
	$text .= '<h2>Found Parameters (alphabetical)</h2>' . $paramnamelist . '<h2>Code for Mediawiki documentation (by order of appearance)</h2>' . $docexample;
}
