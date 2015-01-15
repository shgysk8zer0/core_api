<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @version 1.0.0
 * @copyright 2015, Chris Zuber
 * @license http://opensource.org/licenses/GPL-3.0 GNU General Public License, version 3 (GPL-3.0)
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, either version 3
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace shgysk8zer0\Core_API\Abstracts;

use \shgysk8zer0\Core_API as API;

/**
 *
 */
abstract class Error_Logger extends Logger implements API\Interfaces\Errors, API\Interfaces\Logger
{
	use API\Traits\Logger;
	use API\Traits\Errors;

	protected static $errorLoggerInstance = null;

	/**
	 * Registers $this::$hander method as `set_error_handler`
	 *
	 * @param string $handler Method to use for reporting errors
	 * @param int    $level   Error reporting level to use.
	 */
	abstract public function __construct($handler = null, $level = null);

	/**
	* Converts error constants into PSR-3 defined log levels
	*
	* @param string $e_level E_* error level
	* @return string             Log level as defined by LogLevel constants
	*/
	final public function errorToLogLevel($e_level = 0)
	{
		switch ($e_level) {
			case E_PARSE:
				return LogLevel::EMERGENCY;
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				return LogLevel::ERROR;
			case E_RECOVERABLE_ERROR:
				return LogLevel::CRITICAL;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_COMPILE_WARNING:
			case E_USER_WARNING:
				return LogLevel::WARNING;
			case E_NOTICE:
			case E_USER_NOTICE:
				return LogLevel::NOTICE;
			case E_DEPRECATED:
			case E_USER_DEPRECATED:
			return LogLevel::INFO;
			case E_STRICT:
				return LogLevel::DEBUG;
		}
	}

	/**
	 * Passes the error to logger as an exception, converting error level
	 * to Logger level.
	 *
	 * @param int    $level   Error level from `E_*` error constants
	 * @param string $message Message given with the error
	 */
	final protected static function callErrorLogger($level, $message)
	{
		if (is_null(static::$errorLoggerInstance)) {
			static::$errorLoggerInstance = new self;
		}
		static::$errorLoggerInstance->{
			static::$errorLoggerInstance->errorToLogLevel($level)
		}($message);
	}
}
