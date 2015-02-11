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
 * Trait to provide static method of loading class. Stores in a private static
 * array.
 */
trait Singleton
{
	/**
	 * Array of static instnces of class
	 * @var array
	 */
	protected static $instances = [];

	/**
	 * Checks if $arg is in the private static array of instances. If it is,
	 * returns that, otherwise creates one with $arg given to class constructor,
	 * stores that instance in the static array for later use, and returns that
	 * instance.
	 *
	 * @param  string $arg
	 * @return self
	 */
	final public static function load($arg = null)
	{
		if (is_string($arg) or is_null($arg)) {
			if (! array_key_exists($arg, static::$instances)) {
				if (is_null($arg)) {
					static::$instances[$arg] = new self;
				} else {
					static::$instances[$arg] =new self($arg);
				}
			}

			return static::$instances[$arg];
		}

		throw new \InvalidArgumentException(
			'Static load method requires a string, ' . gettype($arg) . ' given.',
			\shgysk8zer0\Core_API\Abstracts\Exception_Codes::INVALID_ARGS
		);
	}
}
