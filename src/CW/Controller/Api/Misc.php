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
		
		return $controllers;
	}
}
