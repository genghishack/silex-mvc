<?php

/**
 * BOOTSTRAP
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$app = require __DIR__.'/bootstrap.php';

use Symfony\Component\HttpFoundation\Response;

/**
 * APP SETUP
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$app['format'] = $app->share($getContentType);

$app->error(function (\Exception $e, $code) use ($app) {
	$error = new CW\Controller\Page\Error($app);

	if ($code == '404') {
		return $error->renderPage('Error', array('code' => $code));
	}
});

$app->after($setContentType);

$app['api'] = array(
	'misc' => new CW\Api\Misc($app)
);

$app['util'] = new CW\Utility($app);

/**
 * API CALLS
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$app->mount('/api', new CW\Controller\Api\Misc());
 
/**
 * PAGE ROUTES
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$app->mount('/populate', new CW\Controller\Page\Home());
$app->mount('/depopulate', new CW\Controller\Page\Home());
$app->mount('/', new CW\Controller\Page\Home());
 
// $app['debugger']->registerDebugVar($app, 'app');

return $app;
