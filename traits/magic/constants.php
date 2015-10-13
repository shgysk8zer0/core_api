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
 * Provides magic methods for working with class constants, including isset
 * and a getter. Adding unset or a setter makes no sense here since they are
 * constants.
 */
trait Constants
{
	/**
	 * Get a constant by name if defined
	 *
	 * @param  string $name The name of the constant
	 *
	 * @return mixed        The constant's value if defined, otherwise null
	 */
	public function __get($name)
	{
		if (isset($this->$name)) {
			return constant($this->_getConst($name));
		} else {
			trigger_error("Undefined class constant: {$this->_getConst($name)}");
		}
	}

	/**
	 * Checks whether or not the class constant is defined
	 *
	 * @param  string $name Name of the class constant to check
	 *
	 * @return bool         `defined(__CLASS__::$name)`
	 */
	public function __isset($name)
	{
		return defined($this->_getConst($name));
	}

	/**
	 * Private method for getting string to use in `constant` or `defined`
	 *
	 * @param  String $name Name of constant
	 *
	 * @return string       '__CLASS__::$name'
	 */
	final private function _getConst($name)
	{
		return sprintf('\\%s::%s', __CLASS__, strtoupper($name));
	}
}
