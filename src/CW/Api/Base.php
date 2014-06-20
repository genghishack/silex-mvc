<?php

namespace CW\Api;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Query;

class Base
{
	protected $app;
	
	public function __construct(Application $app) {
		$this->app = $app;
		$this->em = $this->app['db.orm.em'];
		
	}
	
	protected function json($data) {
		if (is_array($data)) {
			return new Response(json_encode($data));
		} else {
			return new Response($data);
		}
	}
	
	protected function php($data) {
		// TODO: This generates an error when trying to browse to the url directly.
		// need to have a better way of handling this
		return $data;
	}
	
	public function response($data) {
		if ($this->app['request']->isXmlHttpRequest() && !isset($data['lightbox'])) {
			return $this->json($data);
		} else {
			return $this->php($data);
		}
	}
	
}
