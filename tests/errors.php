<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;

final class Errors extends \shgysk8zer0\Core_API\Abstracts\PDO_Connect
{
	use API\Traits\PDO;
	use API\Traits\Errors;
	final static function reportError(
		$level,
		$message,
		$file,
		$line,
		array $context = array()
	)
	{
		echo static::errorToException($level, $message, $file, $line);
	}
}
