<?php
require __DIR__ . '/../config/config.php';
$view = filter_input( INPUT_GET, 'view' );
if ( !$view ) {
	$view = 'home';
}
if ( !in_array( $view, array_keys( $CONFIG[ 'views' ] ) ) ) {
	http_response_code( 404 );
	$view = 'home';
}
require __DIR__ . '/../view/parts/functions.php';
require __DIR__ . '/../view/parts/menu.php';
require __DIR__ . '/../view/parts/footer.php';
require __DIR__ . '/../view/' . $view . '.php';
?><!DOCTYPE html>
<html>
	<head>
		<title>liquipedia.tools</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="initial-scale=1, width=device-width, user-scalable=no">
		<meta name="description" content="liquipedia.tools is a collection of tools that are aimed to make the life of Liquipedia editors a bit easier.">
		<link rel="icon" href="/favicon.ico">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet" type="text/css">
		<link href="/css/main.css" rel="stylesheet">
		<link href="/css/tools.css" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<?php echo $menu; ?>
			<div class="wrapper-inner">
				<?php
				echo '<h1>' . $CONFIG[ 'views' ][ $view ][ 'name' ] . '</h1>';
				echo $text;
				?>
			</div>
			<?php echo $footer; ?>
		</div>
	</body>
</html>
