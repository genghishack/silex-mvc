<?php

namespace CW;

use Silex\Application;

/**
 * This is just a place to put functions that are for general use, 
 * to keep them out of the global namespace.
 * 
 * It can also be used as TEMPORARY storage for functions until they have a home elsewhere.
 * But, please be careful not to leave code here unless it is truly for general use.
 */
class Utility
{
	protected $app;
	
	public function __construct(Application $app) {
			$this->app = $app;
	}
	
	public function resizedImageUrl($width,$height,$url) {
		$width = $width ? 'width/' . $width . '/' : '';
		$height = $height ? 'height/' . $height . '/' : '';

		if ($this->app['imageResize']) {
			$trimmedPath = strip_url_protocol($url);

			$url = sprintf($this->app['imageResize'],$width,$height,$trimmedPath);
		}

		return $url;
	}

	public function browserSupport() {
		$browser = parse_user_agent($_SERVER['HTTP_USER_AGENT']);
		$minSupported = array(
			'Firefox' => 5,
			'MSIE' => 9
		);

		$evalBrowser = isset($minSupported[$browser['browser']]) ? $minSupported[$browser['browser']] : false;

		if ($evalBrowser && intval($browser['version']) < $evalBrowser) {
			return array('unsupportedBrowser' => array(
				'userAgentString' => $_SERVER['HTTP_USER_AGENT'])
			);
		} else {
			return array();
		}
	}
	
	public function currentWeek() {
		
		$conferenceKey = $this->app['defaults']['schedule']['conference'];
		$sportKey = $this->app['defaults']['schedule']['sport'];

		$now = strtotime("now");
		$start = strtotime($this->app['data']['sports'][$sportKey]['start']);

		return min(max(ceil(($now - $start) / (3600 * 24 * 7)), 1), $this->app['data']['conferences'][$conferenceKey]["weeks"]);

	}

	public function jsonCurlRequest($url) {
	
		$ch = curl_init($url);
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false
		);
		curl_setopt_array( $ch, $options );
	
		$response = curl_exec($ch);
	
		if (false === $response) {
			return curl_error($ch);
		} else {
			return json_decode($response);
		}
	}

	function time_ago($unix_date) {
	
		if(empty($unix_date)) {
			return "No date provided";
		}
	
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
		$now = time();
	
		// check validity of date
		if(empty($unix_date)) {
			return "Bad date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {
			$difference = $now - $unix_date;
			$tense = "ago";
		} else {
			$difference = $unix_date - $now;
			$tense = "from now";
		}
	
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	
		$difference = round($difference);
	
		if($difference != 1) {
			$periods[$j].= "s";
		}
	
		return "$difference $periods[$j] {$tense}";
	
	}

	function time_ago_short($unix_date) {
	
		if(empty($unix_date)) {
			return "";
		}
	
		$periods = array("s", "m", "h", "d", "w", "m", "y", "dec");
		$lengths = array("60","60","24","7","4.35","12","10");
		$now = time();
	
		// check validity of date
		if(empty($unix_date)) {
			return "Bad date";
		}
	
		// is it future date or past date
		if($now > $unix_date) {
			$difference = $now - $unix_date;
			$tense = "ago";
		} else {
			$difference = $unix_date - $now;
			$tense = "from now";
		}
	
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
	
		$difference = round($difference);
	
		return "$difference$periods[$j]";
	
	}

	/**
	 * truncateHtml can truncate a string up to a number of characters while preserving whole words and HTML tags
	 *
	 * @param string $text String to truncate.
	 * @param integer $length Length of returned string, including ellipsis.
	 * @param string $ending Ending to be appended to the trimmed string.
	 * @param boolean $exact If false, $text will not be cut mid-word
	 * @param boolean $considerHtml If true, HTML tags would be handled correctly
	 *
	 * @return string Trimmed string.
	 */
	function truncateHtml($text, $length = 100, $ending = ' ...', $exact = false, $considerHtml = true) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
						// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
							unset($open_tags[$pos]);
						}
						// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

	public function date_sort($a,$b) {
		if ($a['date'] == $b['date']) {
			return 0;
		}
		return ($a['date'] > $b['date']) ? -1 : 1;
	}

	public function millisecondsToHMS($ms) {
		$sec = intval($ms/1000);
		// start with a blank string
		$hms = "";
		$hours = intval(intval($sec) / 3600);

		$hms .= $hours ? $hours . ':' : '';

		$minutes = intval(($sec / 60) % 60);
		$hms .= $hours ? str_pad($minutes, 2, "0", STR_PAD_LEFT). ":" : $minutes . ':';
		$seconds = intval($sec % 60);
		$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

		return $hms;

	}
}
