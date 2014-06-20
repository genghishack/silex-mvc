<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Links up a custom 404 and generic error page.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$handleError = function(\Exception $e) use ($app) {
	$viewData = $app['viewData'];

	if ($e instanceof NotFoundHttpException) {
		$viewData['code'] = 404;
		$viewData['message'] = ERROR_NOT_FOUND;
	}
	else {
		$viewData['code'] = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
		if ($app['debug']) {
			$viewData['message'] = $e;
		}
		else {
			$viewData['message'] = $e->getStatusCode() == 404 ? ERROR_NOT_FOUND : ERROR_INTERNAL;
		}
	}

	if ('json' == $app['format']) {
		$response = new Response(json_encode(array(
			'message' => $viewData['message']
		)));
	}
	else {
		$response = $app['mustache']->render('error.html.twig', $viewData);
	}

	return $response;
};

/**
 * Automatically sets the response content-type based off of $app['format'].
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$setContentType = function(Request $request, Response $response) use ($app) {
	$mimeType = $request->getMimeType($app['format']);
	if (!$mimeType) {
		$mimeType = 'text/html';
	}

	$response->headers->set('Content-Type', $mimeType);
};

/**
 * Making the request/response format type (json|html|xml|...) available.
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
$getContentType = function() use($app) {
	$request = $app['request'];
	$format = null;
	$accepts = $request->getAcceptableContentTypes();
	foreach ($accepts as $accept) {
		$format = $request->getFormat($accept);
		if ($format) {
			break;
		}
	}

	if (!$format) {
		$format = 'html';
	}

	return $format;
};



/**
 * Replace $limit occurences of the search string with the replacement
 * @param mixed $search The value being searched for. An array may be used to
 * designate multiple needles.
 * @param mixed $replace The replacement value that replaces found search
 * values. An array may be used to designate multiple replacements.
 * @param mixed $subject The string or array being searched and replaced on. If
 * subject is an array, then the search and replace is performed with every
 * entry of subject, and the return value is an array as well.
 * @param string $count If passed, this will be set to the number of
 * replacements performed.
 * @param int $limit The maximum possible replacements for each pattern in each
 * subject string. Defaults to -1 (no limit).
 * @return string This function returns a string with the replaced values.
 */
function str_replace_limit($search, $replace, $subject, &$count, $limit = -1) {
	$count = 0;
	// Invalid $limit provided
	if(!($limit===strval(intval(strval($limit))))){
		trigger_error('Invalid $limit `'.$limit.'` provided. Expecting an integer', E_USER_WARNING);
		return $subject;
	}
	// Invalid $limit provided
	if($limit<-1){
		trigger_error('Invalid $limit `'.$limit.'` provided. Expecting -1 or a positive integer', E_USER_WARNING);
		return $subject;
	}
	// No replacements necessary
	if($limit===0){
		trigger_error('Invalid $limit `'.$limit.'` provided. Expecting -1 or a positive integer', E_USER_NOTICE);
		return $subject;
	}
	// Use str_replace() when possible
	if($limit===-1){
		return str_replace($search, $replace, $subject, $count);
	}
	if(is_array($subject)){
		// Loop through $subject values
		foreach($subject as $key => $this_subject){
			// Skip values that are arrays
			if(!is_array($this_subject)){
				// Call this function again
				$this_function = __FUNCTION__;
				$subject[$key] = $this_function($search, $replace, $this_subject, $this_count, $limit);
				// Adjust $count
				$count += $this_count;
				// Adjust $limit
				if($limit!=-1){
					$limit -= $this_count;
				}
				// Reached $limit
				if($limit===0){
					return $subject;
				}
			}
		}
		return $subject;
	} elseif(is_array($search)){
		// Clear keys of $search
		$search = array_values($search);
		// Clear keys of $replace
		if(is_array($replace)){
			$replace = array_values($replace);
		}
		// Loop through $search
		foreach($search as $key => $this_search){
			// Don't support multi-dimensional arrays
			$this_search = strval($this_search);
			// If $replace is an array, use $replace[$key] if exists, else ''
			if(is_array($replace)){
				if(array_key_exists($key, $replace)){
					$this_replace = strval($replace[$key]);
				} else {
					$this_replace = '';
				}
			} else {
				$this_replace = strval($replace);
			}
			// Call this function again for
			$this_function = __FUNCTION__;
			$subject = $this_function($this_search, $this_replace, $subject, $this_count, $limit);
			// Adjust $count
			$count += $this_count;
			// Adjust $limit
			if($limit!=-1){
				$limit -= $this_count;
			}
			// Reached $limit
			if($limit===0){
				return $subject;
			}
		}
		return $subject;
	} else {
		$search = strval($search);
		$replace = strval($replace);
		// Get position of first $search
		$pos = strpos($subject, $search);
		// Return $subject if $search cannot be found
		if($pos===false){
			return $subject;
		}
		// Get length of $search
		$search_len = strlen($search);
		// Loop until $search cannot be found or $limit is reached
		for($i=0;(($i<$limit)||($limit===-1));$i++){
			$subject = substr_replace($subject, $replace, $pos, $search_len);
			// Increase $count
			$count++;
			// Get location of next $search
			$pos = strpos($subject, $search);
			// Break out of loop
			if($pos===false){
				break;
			}
		}
		return $subject;
	}
}

/**
 * Replace hashtags, urls and user mentions in a tweet or set of tweets using data
 * provided by twitter for the purpose.
 * @param array $tweets An array of tweet objects returned from twitter's API.
 */
function replace_twitter_entities($tweets) {

	if (!is_array($tweets)) {
		$tweets = array($tweets);
	}

	foreach ($tweets as &$tweet) {

		foreach ($tweet->entities->urls as $obj) {
			$tweet->text = str_replace_limit(
				$obj->url,
				"<a href=\"{$obj->url}\"
				    target=\"_blank\"
				    title=\"{$obj->expanded_url}\"
			     >{$obj->display_url}</a>",
				$tweet->text,
				$count,
				'1'
			);
		}

		foreach ($tweet->entities->hashtags as $obj) {
			$tweet->text = str_replace_limit(
				"#{$obj->text}",
				"<span class=\"hash\">#</span><a
				    href=\"https://twitter.com/search/?q=%23{$obj->text}&src=hash\"
				    target=\"_blank\"
			     >{$obj->text}</a>",
				$tweet->text,
				$count,
				'1'
			);
		}

		foreach ($tweet->entities->user_mentions as $obj) {
			$tweet->text = str_replace_limit(
				"@{$obj->screen_name}",
				"<span class=\"mention\">@</span><a
				    href=\"https://twitter.com/{$obj->screen_name}\"
				    target=\"_blank\"
			     >{$obj->screen_name}</a>",
				$tweet->text,
				$count,
				'1'
			);
		}

		foreach ($tweet->entities->user_mentions as $obj) {
			$tweet->text = str_replace_limit(
				'@' . strtolower($obj->screen_name),
				"<span class=\"mention\">@</span><a
				    href=\"https://twitter.com/{$obj->screen_name}\"
				    target=\"_blank\"
			     >{$obj->screen_name}</a>",
				$tweet->text,
				$count,
				'1'
			);
		}

		// TODO: handle special characters - I can't get it to replace these so far
		// $tweet->text = str_replace(
		// 'â',
		// '&hellip;',
		// $tweet->text
		// );
	}

	return $tweets;

}

function strip_url_protocol($url) {
	$arr = parse_url($url);

	$protocol = isset($arr['scheme']) ? $arr['scheme'] : 'http';
	$protocol = $protocol . '://';

	return str_replace($protocol,'',$url);
}

function parse_user_agent( $u_agent = null ) {
	if(is_null($u_agent)) $u_agent = $_SERVER['HTTP_USER_AGENT'];

	$data = array(
		'platform' => null,
		'browser'  => null,
		'version'  => null,
	);

	if( preg_match('/\((.*?)\)/im', $u_agent, $regs) ) {

		/*
(?P<platform>Android|iPhone|iPad|Linux|Macintosh|Windows\ Phone\ OS|Windows|Silk|linux-gnu|BlackBerry|Xbox)
(?:\ [^;]*)?
(?:;|$)
*/
		preg_match_all('/(?P<platform>Android|iPhone|iPad|Linux|Macintosh|Windows\ Phone\ OS|Windows|Silk|linux-gnu|BlackBerry|Nintendo\ Wii|Xbox)
            (?:\ [^;]*)?
            (?:;|$)/imx', $regs[1], $result, PREG_PATTERN_ORDER);

		$priority = array('Android', 'Xbox');
		$result['platform'] = array_unique($result['platform']);
		if( count($result['platform']) > 1 ) {
			if( $keys = array_intersect($priority, $result['platform']) ) {
				$data['platform'] = reset($keys);
			}else{
				$data['platform'] = $result['platform'][0];
			}
		}elseif(isset($result['platform'][0])){
			$data['platform'] = $result['platform'][0];
		}
	}

	/*
(?<browser>Camino|Kindle|Kindle\ Fire\ Build|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|Silk|Lynx|Version|Wget|curl|PLAYSTATION\ \d+)
(?:;?)
(?:(?:[/\ ])(?<version>[0-9.]+)|/(?:[A-Z]*))
*/
	preg_match_all('%(?P<browser>Camino|Kindle|Kindle\ Fire\ Build|Firefox|Safari|MSIE|AppleWebKit|Chrome|IEMobile|Opera|Silk|Lynx|Version|Wget|curl|PLAYSTATION\ \d+)
        (?:;?)
        (?:(?:[/ ])(?P<version>[0-9.]+)|/(?:[A-Z]*))%x',
		$u_agent, $result, PREG_PATTERN_ORDER);

	if( $data['platform'] == 'linux-gnu' ) { $data['platform'] = 'Linux'; }

	$key = 0;

	if( ($key = array_search( 'Kindle Fire Build', $result['browser'] )) !== false || ($key = array_search( 'Silk', $result['browser'] )) !== false ) {
		$data['browser']  = $result['browser'][$key] == 'Silk' ? 'Silk' : 'Kindle';
		$data['platform'] = 'Kindle Fire';
		if( !($data['version']  = $result['version'][$key]) ) {
			$data['version'] = $result['version'][array_search( 'Version', $result['browser'] )];
		}
	}elseif( ($key = array_search( 'Kindle', $result['browser'] )) !== false ) {
		$data['browser']  = $result['browser'][$key];
		$data['platform'] = 'Kindle';
		$data['version']  = $result['version'][$key];
	}elseif( $result['browser'][0] == 'AppleWebKit' ) {
		if( ( $data['platform'] == 'Android' && !($key = 0) ) || $key = array_search( 'Chrome', $result['browser'] ) ) {
			$data['browser'] = 'Chrome';
			if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		}elseif( $data['platform'] == 'BlackBerry' ) {
			$data['browser'] = 'BlackBerry Browser';
			if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		}elseif( $key = array_search( 'Safari', $result['browser'] ) ) {
			$data['browser'] = 'Safari';
			if( ($vkey = array_search( 'Version', $result['browser'] )) !== false ) { $key = $vkey; }
		}

		$data['version'] = $result['version'][$key];
	}elseif( ($key = array_search( 'Opera', $result['browser'] )) !== false ) {
		$data['browser'] = $result['browser'][$key];
		$data['version'] = $result['version'][$key];
		if( ($key = array_search( 'Version', $result['browser'] )) !== false ) { $data['version'] = $result['version'][$key]; }
	}elseif( $result['browser'][0] == 'MSIE' ){
		if( $key = array_search( 'IEMobile', $result['browser'] ) ) {
			$data['browser'] = 'IEMobile';
		}else{
			$data['browser'] = 'MSIE';
			$key = 0;
		}
		$data['version'] = $result['version'][$key];
	}elseif( $key = array_search( 'PLAYSTATION 3', $result['browser'] ) !== false ) {
		$data['platform'] = 'PLAYSTATION 3';
		$data['browser']  = 'NetFront';
		$data['version']  = $result['version'][0];
	}else{
		$data['browser'] = $result['browser'][0];
		$data['version'] = $result['version'][0];
	}

	return $data;

}

/**
 * This function is to be used instead of include() when you want to include a file but it renders 
 * HTML straight to the page (like when you're refactoring some idiot n00b's code)....
 */
function get_include_contents($sFileName)
{
    if (is_file($sFileName)) {
        ob_start();
        include $sFileName;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}
