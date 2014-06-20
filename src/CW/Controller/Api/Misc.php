<?php

namespace CW\Controller\Api;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class Misc implements ControllerProviderInterface
{
	public function connect(Application $app) {
		
		$this->app = $app;
		$self = $this;
		$controllers = $app['controllers_factory'];
		
		$controllers->get('/', function(Application $app) use ($self) {
		});
		
		$controllers->get('/companies', function(Application $app) use ($self) {
			return $app['api']['misc']->getCompanies();
		});
		
		$controllers->get('/emails', function(Application $app) use ($self) {
			return $app['api']['misc']->getEmails();
		});
		
		$controllers->get('/humans', function(Application $app) use ($self) {
			return $app['api']['misc']->getHumans();
		});
		
		return $controllers;
	}
}
