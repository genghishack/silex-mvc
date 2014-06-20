<?php

namespace CW\Controller\Page;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class Error extends Base implements ControllerProviderInterface
{

	public function __construct($app) {
		$this->app = $app;
	}

	public function connect(Application $app) {

	}

}
