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

/**
 * Require a few standard methods for PDO classes implementing this interface.
 */
interface PDO
{
	/**
	 * Connects to database using mixed $con
	 *
	 * @param mixed $con Connection credentials
	 */
	public function __construct($con);

	/**
	 * PDO has not escape method, so a custom one is required
	 *
	 * @param  string $string The unescaped string
	 * @return string         The escaped string
	 */
	public function escape($string);

	/**
	 * Returns an array of available database tables
	 *
	 * @param void
	 * @return array
	 */
	public function showTables();

	/**
	 * Describe a table
	 *
	 * @param  string $table Name of table to describe
	 * @return array        [key => \stdClass]
	 */
	public function describe($table);

	/**
	 * Lazy/magic method for PDO::query(). Combines all steps in into one.
	 *
	 * @param  string $query       The query string
	 * @param  int $fetch_style    From PDO constants
	 * @return array               [key => \stdClass]
	 * @example $PDO($query, \PDO::FETCH_CLASS);
	 * @example $PDO("SELECT * FROM `table`");
	 */
	public function __invoke($query, $fetch_style = self::FETCH_CLASS);
}
