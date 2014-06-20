<?php

date_default_timezone_set('America/Denver');

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/constants.php';

use \Doctrine\Common\Cache\ApcCache;
use \Doctrine\Common\Cache\ArrayCache;

$app = new Silex\Application();
unset($app['exception_handler']);

if('cli' == php_sapi_name()){
	if (isset($argv[1])) {
		$app['env'] = $argv[1];
	} else {
		die ("You must specify an environment, i.e. 'php news.php [local|dev|stage|prod]'\n");
	}
}else{
	$app['env'] = require __DIR__.'/env.php';
}

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/all.json"));
$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/{$app['env']}.json"));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new CW\Service\Debug\DebugServiceProvider());
$app->register(new CW\Service\Page\PageServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../webroot/tpl'
    // 'twig.options' => array(
        // 'cache' => $app['cache.dir'].DS.'twig'.DS
    // )
));

$app->register(new Mustache\Silex\Provider\MustacheServiceProvider(), array(
	'mustache.path' => __DIR__.'/../webroot/tpl'
));

// Register Doctrine DBAL
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
    	'driver'   => 'pdo_mysql',
    	'dbname'   => $app['db.name'],
    	'user'     => $app['db.user'],
    	'password' => $app['db.pass'],
    	'host'     => $app['db.host']
	)
));

// Register Doctrine ORM
$app->register(new Nutwerk\Provider\DoctrineORMServiceProvider(), array(
    'db.orm.proxies_dir'           => __DIR__ . '/../cache/doctrine/proxy',
    'db.orm.proxies_namespace'     => 'DoctrineProxy',
    'db.orm.cache'                 => 
        !$app['debug'] && extension_loaded('apc') ? new ApcCache() : new ArrayCache(),
    'db.orm.auto_generate_proxies' => true,
    'db.orm.entities'              => array(array(
        'type'      => 'annotation',       // entity definition 
        'path'      => __DIR__,   // path to your entity classes
        'namespace' => 'CW\Entities', // your classes namespace
    )),
));

$app['data'] = array();

$app['debugger']->registerDebugVar($app['data'], 'App Data');

require_once __DIR__.'/utils.php';

/**
 * PHP settings based off ENV config.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
date_default_timezone_set($app['timezone']);
if ($app['debug']) {
	ini_set('log_errors', 'On');
	ini_set('display_errors', 'On');
	//TODO ADD E_STRICT when all of those errors have been fixed.
	error_reporting(E_ALL);
}

return $app;
