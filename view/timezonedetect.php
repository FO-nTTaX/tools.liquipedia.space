<?php

$text = '';

$text .= '<input type="text" id="detectedtimezone" readonly>';
$text .= '<script>';
$text .= 'var result;var parts = ( new Intl.DateTimeFormat( \'en\', { timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone, timeZoneName: \'long\' } ) ).formatToParts();';
$text .= 'parts.forEach( function( el ) {if ( el.type === \'timeZoneName\' ) {result = el.value;}} );';
$text .= 'document.getElementById(\'detectedtimezone\').value = result;';
$text .= '</script>';
