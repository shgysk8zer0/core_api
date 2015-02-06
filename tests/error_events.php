<?php

namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;

final class Error_Events implements API\Interfaces\Errors
{
	use API\Traits\Errors;
	use API\Traits\Events;

	/**
	 * Keep a static instance of class for use in static functions
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Registers $this::$hander method as `set_error_handler`
	 *
	 * @param string $handler Method to use for reporting errors
	 * @param int    $level   Error reporting level to use.
	 */
	public function __construct($handler = null, $level = null)
	{
		set_error_handler(
			[
				$this,
				(is_string($handler) and method_exists($this, $handler))
				? $handler
				: 'reportError'
			],
			is_int($level) ? $level : error_reporting()
		);

		if (is_null(static::$instance)) {
			static::$instance = $this;
		}
	}

	public function __set($event, Callable $callback)
	{
		$this->registerEvent($event, $callback);
	}

	public static function reportError(
		$level,
		$message,
		$file,
		$line,
		array $context = array()
	)
	{
		$e = static::errorToException($level, $message, $file, $line);
		static::$instance->triggerEvent(static::errorLevelAsString($level), [
			'level' => static::errorLevelAsString($level),
			'message' => $e->getMessage(),
			'file' => $e->getFile(),
			'line' => $e->getLine(),
			'trace' => $e->getTraceAsString()
		]);
	}
}
