<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Interfaces
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

/**
 * Provides an interface for the logging methods of Chrome Logger
 * @see https://craig.is/writing/chrome-logger
 */
interface Console
{
	/**
	 * logs a variable to the console
	 *
	 * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	 * @return void
	 */
	public function log();

	/**
	 * sends an info log
	 *
	 * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	 * @return void
	 */
	public function info();

	/**
	 * sends a table log
	 *
	 * @param string value
	 */
	public function table();

	/**
 	* logs a warning to the console
 	*
 	* @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
 	* @return void
 	*/
	public function warn();

	/**
	 * logs an error to the console
	 *
	 * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	 * @return void
	 */
	public function error();

	/**
	 * sends a group log
	 *
	 * @param string value
	 */
	public function group();

	/**
	 * sends a collapsed group log
	 *
	 * @param string value
	 */
	public function groupCollapsed();

	/**
	 * ends a group log
	 *
	 * @param string value
	 */
	public function groupEnd();
}
