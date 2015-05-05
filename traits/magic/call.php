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
namespace shgysk8zer0\Core_API\Traits\Magic;

/**
 * Provides a default implementation of the __call magic method.
 */
trait Call
{
	/**
	 * Chained magic getter and setter (and isset via has)
	 *
	 * @param string $name      Name of the method called
	 * @param array $arguments  Array of arguments passed to the method
	 * @return mixed
	 * @example "$class->[getName|setName|hasName|$name]($arguments[0], ...)"
	 * @method get*
	 * @method set*
	 * @method has*
	 * @method rem*
	 * @method del*
	 */
	final public function __call($name, array $arguments = array())
	{
		$name = strtolower($name);
		$key = substr($name, 3);
		switch(substr($name, 0, 3)) {
			case 'get':
				return $this->__get($key);

			case 'set':
				array_map(
					[$this, '__set'],
					array_pad(array(), count($arguments), $key),
					array_values($arguments)
				);
				return $this;

			case 'has':
				return $this->__isset($key);

			case 'del':
			case 'rem':
				$this->__unset($name);
				return $this;

			default:
				throw new \InvalidArgumentException(sprintf('%s is not a valid method', $name));
		}
	}

	abstract public function __set($name, $value);

	abstract public function __get($name);

	abstract public function __isset($name);

	abstract public function __unset($name);
}
