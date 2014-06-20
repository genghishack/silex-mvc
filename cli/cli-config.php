<?php
// cli-config.php
// require_once "bootstrap.php";
// 
// return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);

require_once __DIR__ .  '/../vendor/doctrine/common/lib/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', realpath(__DIR__ . '/../vendor/doctrine/orm/lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', realpath(__DIR__ . '/../vendor/doctrine/dbal/lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', realpath(__DIR__ . '/../vendor/doctrine/common/lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', realpath(__DIR__ . '/../vendor/symfony/console'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__ . '/../src/CW/Entities');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__ . '/../cache/doctrine/proxy');
$classLoader->register();

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/../src/CW/Entities"));
$config->setMetadataDriverImpl($driverImpl);

$config->setProxyDir(__DIR__ . '/../src/CW/Proxies');
$config->setProxyNamespace('CW\Proxies');

// $revisionFile = __DIR__.'/../REVISION';
// if (is_readable($revisionFile)) {
	// $connectionOptions = array(
		// 'driver'   => 'pdo_mysql',
		// 'host'     => 'localhost',
		
		/* QA */
		
		// 'dbname'   => 'cisports',
		
		// root
		// 'user'     => 'root',
		// 'password' => 'S1P4Y',
		
		// normal
		// 'user'     => 'cidev',
		// 'password' => '59Vl17',
		

		/* Dev */

		// 'dbname'   => 'campus_insiders',
		
		// root
		// 'user'     => 'root',
		// 'password' => 'y1Lt2ul6',

		// normal
		// 'user'     => 'cidev',
		// 'password' => '9HdXh7Q3S2',

	// );
// } else {
	$connectionOptions = array(
		'driver'   => 'pdo_mysql',
		'dbname'   => 'jobSearch',
		'user'     => 'root',
		'password' => 'root',
		'host'     => 'localhost'
	);
// }

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);
