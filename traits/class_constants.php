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
 * Provides a few simple methods for working with and testing for class constants
 */
trait Class_Constants
{
	/**
	 * Static array of class to avoid creatingnew Reflection classes each time
	 *
	 * @var array
	 */
	protected static $consts_arr = [];

	/**
	 * Searches class constants for $val and returns the name of the first const
	 * name, if any.
	 *
	 * @param mixed $val Value to search for
	 * @return string
	 */
	final public function getConstName($val)
	{
		if (empty(static::$consts_arr)) {
			$this->getClassConstants();
		}
		return array_search($val, static::$consts_arr);
	}

	/**
	 * Sets and returns an array of class constants. The array is created only
	 * once and stored as a static variable.
	 *
	 * @param void
	 * @return array
	 * @todo exclude parent constants?
	 */
	final public function getClassConstants()
	{
		if (empty(static::$consts_arr)) {
			static::$consts_arr = (new \ReflectionClass(__CLASS__))->getConstants();
		}
		return static::$consts_arr;
	}

	/**
	 * Checks if $const is defined for this class.
	 *
	 * @param  string $const Name of class constant
	 * @return bool
	 */
	final public function defined($const)
	{
		return defined('\\' . __CLASS__ . '::' . $const);
	}
}
