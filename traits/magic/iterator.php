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
	 * Current position of the Iterator. Incremented by `next` & reset by `rewind`
	 * @var int
	 */
	protected $iterator_position = 0;

	/**
	 * Gets the value @ $iterator_position
	 *
	 * @param void
	 * @return mixed Whatever the current value is
	 */
	final public function current()
	{
		return array_values($this->{$this::MAGIC_PROPERTY})[$this->iterator_position];
	}

	/**
	 * Returns the original key (not $iterator_position) at the current position
	 *
	 * @param void
	 * @return mixed  Probably a string, but could be an integer.
	 */
	final public function key()
	{
		return array_keys($this->{$this::MAGIC_PROPERTY})[$this->iterator_position];
	}

	/**
	 * Increment $iterator_position
	 *
	 * @param void
	 * @return void
	 */
	final public function next()
	{
		++$this->iterator_position;
	}

	/**
	 * Reset $iterator_position to 0
	 *
	 * @param void
	 * @return void
	 */
	final public function rewind()
	{
		$this->iterator_position = 0;
	}

	/**
	 * Checks if data is set for current $iterator_position
	 *
	 * @param void
	 * @return bool Whether or not there is data set at current position
	 */
	final public function valid()
	{
		return array_key_exists(
			$this->iterator_position,
			array_values($this->{$this::MAGIC_PROPERTY})
		);
	}
}
