<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core
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
 * Provides variable filters (check $var is email, URL, etc.)
 * @see http://php.net/manual/en/function.filter-var.php
 * @see http://php.net/manual/en/filter.filters.validate.php
 */
trait Filters
{
	/**
	 * Validates that $var is a URL
	 *
	 * @param mixed  $var     Value to filter
	 * @param array  $options Associative array of options
	 * @return bool           Whether or not the test was passed
	 */
	final public function isURL($var = null, array $options = array())
	{
		return filter_var($var, FILTER_VALIDATE_URL, $options);
	}

	/**
	 * Validates that $var is an email address
	 *
	 * @param mixed  $var     Value to filter
	 * @param array  $options Associative array of options
	 * @return bool           Whether or not the test was passed
	 */
	final public function isEmail($var = null)
	{
		return filter_var($var, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * Validates that $var is an IP address
	 *
	 * @param mixed  $var     Value to filter
	 * @param array  $options Associative array of options
	 * @return bool           Whether or not the test was passed
	 */
	final public function isIP($var = null, array $options = array())
	{
		return filter_var($var, FILTER_VALIDATE_IP, $options);
	}

	/**
	 * Validates that $var is a Regular Expression
	 *
	 * @param mixed  $var     Value to filter
	 * @param array  $options Associative array of options
	 * @return bool           Whether or not the test was passed
	 */
	final public function isRegExp($var = null)
	{
		return filter_var($var, FILTER_VALIDATE_REGEXP, $options);
	}

	final public function isBoolean($var = null, array $options = array())
	{
		return filter_var($var, FILTER_VALIDATE_BOOLEAN, $options);
	}

	final public function isFloat($var = null, array $options = array())
	{
		return filter_var($var, FILTER_VALIDATE_FLOAT, $options);
	}

	final public function isInt($var = null, array $options = array())
	{
		return filter_var($var, FILTER_VALIDATE_INT, $options);
	}

	final public function isString($var = null)
	{
		return is_string($var);
	}

	final public function isArray($var =null)
	{
		return is_array($var);
	}

	final public function isAssociative($var = null)
	{
		return (
			$this->isArray($var)
			and $length = count($var)
			and $keys = count(array_filter('is_string', array_keys($array)))
			and $length === $keys
		);
	}

	final public function isObject($var = null)
	{
		return is_object($var);
	}

	final public function isClass($var, $class_name)
	{
		return $this->isObject($var) and is_a($var, $class_name);
	}

	final public function isSubclass($var, $class_name)
	{
		return $this->isObject($var) and is_subclass_of($var, $class_name);
	}

	final public function hasMethod($var, $method)
	{
		return method_exists($var, $method);
	}

	final public function hasProperty($var = null, $property = null)
	{
		return $this->isObject($var) and property_exists($var, $property);
	}
}
