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
namespace shgysk8zer0\Core_API\Traits\Magic;

/**
 * Makes MAGIC_PROPERTY array (for magic methods) iterable (in `foreach`)
 * Classes using this trait should make use of the \Iterator interface
 * @see https://php.net/manual/en/class.iterator.php
 */
trait Iterator
{
	/**
	 * Gets the value @ $_iterator_position
	 *
	 * @param void
	 * @return mixed Whatever the current value is
	 */
	final public function current()
	{
		return current($this->{$this::MAGIC_PROPERTY});
	}

	/**
	 * Returns the original key (not $_iterator_position) at the current position
	 *
	 * @param void
	 * @return mixed  Probably a string, but could be an integer.
	 */
	final public function key()
	{
		return key($this->{$this::MAGIC_PROPERTY});
	}

	/**
	 * Increment $_iterator_position
	 *
	 * @param void
	 * @return void
	 */
	final public function next()
	{
		next($this->{$this::MAGIC_PROPERTY});
	}

	/**
	 * Reset $_iterator_position to 0
	 *
	 * @param void
	 * @return void
	 */
	final public function rewind()
	{
		reset($this->{$this::MAGIC_PROPERTY});
	}

	/**
	 * Checks if data is set for current $_iterator_position
	 *
	 * @param void
	 * @return bool Whether or not there is data set at current position
	 */
	final public function valid()
	{
		return $this->key() !== null;
	}
}
