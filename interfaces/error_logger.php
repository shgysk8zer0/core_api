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
namespace shgysk8zer0\Core_API\Interfaces;
use Errors;

/**
 * Combination of Errors and Logger Interfaces.
 */
interface Error_Logger extends Logger
{
	/**
	 * Registers $this::$hander method as `set_error_handler`.
	 * Since Logger methods are not static, at some point the class will need
	 * to be constructed, and it makes sense to set an error handler class
	 * as the error handler in such cases.
	 *
	 * @param string $handler Method to use for reporting errors
	 * @param int    $level   Error reporting level to use.
	 */
	public function __construct($handler = null, $level = null);

	/**
	 * Converts error constants into PSR-3 defined log levels
	 *
	 * @param string $e_level E_* error level
	 * @return string             Log level as defined by LogLevel constants
	 */
	public function errorToLogLevel($e_level = 0);

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
	);
}
