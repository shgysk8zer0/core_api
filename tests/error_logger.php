<?php
namespace shgysk8zer0\Core_API\Tests;
use \shgysk8zer0\Core_API as API;
final class Error_logger extends API\Abstracts\Error_Logger
{
	use API\Traits\Logger_Interpolation;
	use API\Traits\File_IO;

	const LOG_FILE = 'logs/errors.log';

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

		if (is_null(static::$errorLoggerInstance)) {
			static::$errorLoggerInstance = $this;
		}
	}

	/**
	 * Method to be set in `set_error_handler` and called automatically
	 * when an error is triggered, either through `trigger_error` or naturally
	 * through errors in a script.
	 *
	 * @param int    $level   Any of the error levels (E_*)
	 * @param string $message Message given with the error
	 * @param string $file    File generating the error
	 * @param int    $line    Line on which the error occured
	 * @param array  $context Symbols set when the error was triggered
	 * @see http://php.net/manual/en/function.set-error-handler.php
	 */
	public static function reportError(
		$level,
		$message,
		$file,
		$line,
		array $context = array()
	)
	{
		static::callErrorLogger(
			$level,
			static::errorToException($level, $message, $file, $line)
		);
	}

	public function log($level, $message, array $context = array())
	{
		file_put_contents(
			self::LOG_FILE,
			$this->interpolate($message, $context) . PHP_EOL,
			LOCK_EX | FILE_APPEND
		);
	}
}
