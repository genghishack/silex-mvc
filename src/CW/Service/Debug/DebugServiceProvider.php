<?php

namespace CW\Service\Debug;

use Silex\Application;
use Silex\ServiceProviderInterface;

class DebugServiceProvider implements ServiceProviderInterface
{	
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Application $app An Application instance
     */
    public function register(Application $app) {		
		$app['debugger'] = $app->share(function(Application $app) {
	    	return new DebugService($app);
		});
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registers
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app) {
    }
	
}