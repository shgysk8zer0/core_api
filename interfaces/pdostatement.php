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
 *
 */
interface PDOStatement
{
	/**
	 * Binds a parameter to the specified variable name. Do not prefix keys with ":"
	 *
	 * @param  array  $bind_params [$key => $value]
	 * @return self
	 * @see http://php.net/manual/en/pdostatement.bindparam.php
	 */
	public function bind(array $bind_params = array());

	/**
	 * Execute the prepared statement
	 *
	 * @param  array $bound_input_params  [$key => $value]
	 * @return self
	 */
	public function execute($bound_input_params = null);

	/**
	 * Returns an array containing all of the result set rows
	 *
	 * @param mixed $col          int or null. If int, returns that index of results
	 * @param int   $fetch_style  Controls the contents of the returned array
	 * @see http://php.net/manual/en/pdostatement.fetchall.php
	 */
	public function getResults($col = null, $fetch_style = \PDO::FETCH_CLASS);
}
