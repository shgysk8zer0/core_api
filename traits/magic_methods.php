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
 * Provides magic getters, setters, as well as set and unset methods
 *
 * Any class using this trait is required to set a constant MAGIC_PROPERTY and
 * to have a protected or private property of the same name.
 * @see http://php.net/manual/en/language.oop5.magic.php
 */
trait Magic_Methods
{
	/**
	 * Magic getter method.
	 *
	 * @param  string $prop The property to work with
	 * @return mixed        The value of property.
	 * @example echo $magic_class->$prop;
	 * @example $magic_class->$prop .= $value;
	 */
	final public function __get($prop)
	{
		if ($this->__isset($prop)) {
			return (is_array($this->{$this::MAGIC_PROPERTY}))
				? $this->{$this::MAGIC_PROPERTY}[$prop]
				: $this->{$this::MAGIC_PROPERTY}->$prop;
		} else {
			return null;
		}
	}

	/**
	 * Maggic ssetter method.
	 *
	 * @param string $prop  The property to work with
	 * @param mixed  $value The value to set it to.
	 * @return void
	 * @example $magic_class->$prop = $value
	 */
	final public function __set($prop, $value)
	{
		is_array($this->{$this::MAGIC_PROPERTY})
			? $this->{$this::MAGIC_PROPERTY}[$prop] = $value
			: $this->{$this::MAGIC_PROPERTY}->$prop = $value;
	}

	/**
	 * Magic isset metod.
	 *
	 * @param  string   $prop The property to work with
	 * @return bool           Whether or not it is set.
	 * @example isset($magic_class->$prop) ? 'True' : 'False';
	 */
	final public function __isset($prop)
	{
		return is_array($this->{$this::MAGIC_PROPERTY})
			? array_key_exists($prop, $this->{$this::MAGIC_PROPERTY})
			: isset($this->{$this::MAGIC_PROPERTY}->$prop);
	}

	/**
	 * Magic unseet method.
	 *
	 * @param string $prop The property to work with
	 * @return void
	 * @example unset($magic_class->$prop);
	 */
	final public function __unset($prop)
	{
		unset($this->{$this::MAGIC_PROPERTY}->$prop);
	}
}
