<?php

namespace thetechguy;

use thetechguy\Transaction;

class Mpesa {

	public static $api_key = null;
	public static $public_key = null;
	public static $environment = "development";
	public static $options = [];

	// Accept an optional $options array to support stream/curl overrides
	public static function init($api_key, $public_key, $environment, $options = []) {
		self::$api_key = $api_key;
		self::$public_key = $public_key;
		self::$environment = $environment;
		self::$options = $options;
		return new Transaction();
	}
}
