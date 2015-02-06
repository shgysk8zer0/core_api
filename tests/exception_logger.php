<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;
use API\Abstracts\Exception_Codes as Codes;
final class Exception_Logger implements API\Interfaces\Logger
{
	use API\Traits\Logger;
	use API\Traits\Logger_Interpolation;

	public static $MESSAGE = "exception:[code = {code}] '{class}' with message '{message}' in {file}:{line}\nStack trace:\n{trace}";
	public static $LOG_LEVEL = 'notice';

	final public function log($level, $message, array $context = array())
	{
		echo $this->interpolate($message, $context) . PHP_EOL;
	}

	final public static function report(\Exception $e)
	{
		(new self)->{static::$LOG_LEVEL}(
			static::$MESSAGE,
			[
				'code' => $e->getCode(),
				'line' => $e->getLine(),
				'file' => $e->getFile(),
				'trace' => $e->getTraceAsString(),
				'message' => $e->getMessage(),
				'class' => get_class($e)
			]
		);
	}
}
