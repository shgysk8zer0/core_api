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
namespace shgysk8zer0\Core_API\Traits;

/**
 * Privides simplified magic method for binding paramaters to prepared statements
 * using magic setter method. No other megic methods currently make sense, since
 * there should be no static methods, no use for getters, etc.
 */
trait PDOStatement_Magic
{
	/**
	 * Bind a paramater to PDOStatement as though it were a object property.
	 * No need to prefix with ":"
	 *
	 * @param string $key   Bound paramater to set
	 * @param mixed $value  Value to set it to
	 * @return void
	 * @example $stm->$key = $value;
	 */
	final public function __set($key, $value)
	{
		$this->bindParam(":{$key}", $value);
	}
}
