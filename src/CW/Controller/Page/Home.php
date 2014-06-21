<?php

namespace CW\Controller\Page;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class Home extends Base implements ControllerProviderInterface
{
	public function connect(Application $app) {
		
		$this->app = $app;

		$self = $this;
		$controllers = $app['controllers_factory'];
		
		$controllers->get('/', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('Home');
			} else {
				return '';
			}
		});		

		$controllers->get('/HumanList', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('HumanList');
			} else {
				return '';
			}
		});		

		$controllers->get('/CompanyList', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('CompanyList');
			} else {
				return '';
			}
		});		

		$controllers->get('/JobLeadList', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('JobLeadList');
			} else {
				return '';
			}
		});		

		$controllers->get('/populate', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('Populate');
			} else {
				return '';
			}
		});		

		$controllers->get('/depopulate', function(Application $app) use ($self) {
			if ('cli' != php_sapi_name()) {
				return $self->renderPage('Depopulate');
			} else {
				return '';
			}
		});		

		return $controllers;
	}
	
}
