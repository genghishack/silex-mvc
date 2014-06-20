<?php

switch ($_SERVER['SERVER_NAME']) {
	case '127.0.0.1':
	case 'jobs':
		return ENV_LOCAL;
		
	case 'dev.':
        return ENV_DEV;

    case 'staging.':
	case 'qa.':
        return ENV_STAGE;

	default :
		return ENV_PROD;
}

return $env;