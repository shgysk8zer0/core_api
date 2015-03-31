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
trait Set
{
	/**
	* Magic setter method.
	*
	* @param string $prop  The property to work with
	* @param mixed  $value The value to set it to.
	* @return void
	* @example $magic_class->$prop = $value
	*/
	final public function __set($prop, $value)
	{

		// Check for setting restricted to existing data
		if (
			! defined('self::RESTRICT_SETTING')
			or ! self::RESTRICT_SETTING
			or isset($this->$prop)
		) {
			$this->magicPropConvert($prop);
			is_array($this->{$this::MAGIC_PROPERTY})
				? $this->{$this::MAGIC_PROPERTY}[$prop] = $value
				: $this->{$this::MAGIC_PROPERTY}->$prop = $value;
		} else {
			throw new \InvalidArgumentException(
				sprintf(
					'No property `%s::%s` is set and setting is restricted',
					__CLASS__,
					$prop
				)
			);
		}
	}
}
