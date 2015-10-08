<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
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
namespace shgysk8zer0\Core_API\Traits;

/**
 * Adds error and exception handlers to Chrome Logger type classes
 */
trait ConsoleHandlers
{
	abstract protected function _addRow(array $logs, $backtrace, $type);
	/**
	 * logs a PHP error to the console as an error
	 *
	 * @param  int    $errno      the level of the error raised
	 * @param  string $errstr     the error message
	 * @param  string $errfile    the filename that the error was raised in
	 * @param  int    $errline    the line number the error was raised at
	 * @param  array  $errcontext an array that points to the active symbol table at the point the error occurred
	 *
	 * @return void
	 */
	final public function reportError(
		$errno,
		$errstr,
		$errfile,
		$errline,
		array $errcontext = array()
	)
	{
		$this->_addRow(
			array($errstr),
			$this->_formatLocation($errfile, $errline),
			self::ERROR
		);
	}

	/**
	 * logs a PHP exception to the console as a warn
	 *
	 * @param  Exception $e the exception
	 *
	 * @return void
	 */
	final public function reportException(\Exception $e)
	{
		$this->_addRow(
			array($e->getMessage()),
			$this->_formatLocation($e->getFile(), $e->getLine()),
			self::WARN
		);
	}
}
