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
 * Provides a default implementation of the __call magic method.
 */
trait Magic_Call
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
	 */
	final public function __call($name, array $arguments = array())
	{
		$name = strtolower($name);
		$act = substr($name, 0, 3);
		$key = substr($name, 3);
		switch($act) {
			case 'get':
				return $this->__get($key);
			case 'set':
				$this->__set($key, current($arguments));
				return $this;
			case 'has':
				return $this->__isset($key);
		}
	}
}
