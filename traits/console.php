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
namespace shgysk8zer0\Core_API\Traits;

trait Console
{
	abstract function __toString();

	/**
	 * Magic call method for console
	 * @param  string $method Log level to use ('log', 'error', ...)
	 * @param  Array  $args   Things to log
	 * @return self           Return `$this` to make chainable
	 */
	final public function __call($method, Array $args)
	{
		// Converts 'fooBar' into 'foo_Bar'
		$method = preg_replace('/[A-Z]/', '_${0}', $method);
		$method = strtoupper($method);
		if (defined(__CLASS__ . "::{$method}")) {
			$this->_log(constant(__CLASS__ . "::{$method}"), $args);
		} else {
			throw new \BadMethodCallException(sprintf(
				'Unknown method: %s',
				func_get_arg(0)
			));
		}
		return $this;
	}

	/**
	 * Magic call method for console
	 * @param  string $method Log level to use ('log', 'error', ...)
	 * @param  Array  $args   Things to log
	 * @return self           Return `$this` to make chainable
	 */
	final public static function __callStatic($method, Array $args)
	{
		return call_user_func_array([static::getInstance(), $method], $args);
	}

	// /**
	//  * logs a variable to the console
	//  *
	//  * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	//  * @return void
	//  */
	// final public function log()
	// {
	// 	return $this->_log(self::LOG, func_get_args());
	// }
	//
	// /**
	//  * sends an info log
	//  *
	//  * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	//  * @return void
	//  */
	// final public function info()
	// {
	// 	return $this->_log(self::INFO, func_get_args());
	// }
	//
	// /**
	//  * sends a table log
	//  *
	//  * @param string value
	//  */
	// final public function table()
	// {
	// 	return $this->_log(self::TABLE, func_get_args());
	// }
	//
	// /**
	// * logs a warning to the console
	// *
	// * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	// * @return void
	// */
	// final public function warn()
	// {
	// 	return $this->_log(self::WARN, func_get_args());
	// }
	//
	// /**
	//  * logs an error to the console
	//  *
	//  * @param mixed $data,... unlimited OPTIONAL number of additional logs [...]
	//  * @return void
	//  */
	// final public function error()
	// {
	// 	return $this->_log(self::ERROR, func_get_args());
	// }
	//
	// /**
	//  * sends a group log
	//  *
	//  * @param string value
	//  */
	// final public function group()
	// {
	// 	return $this->_log(self::GROUP, func_get_args());
	// }
	//
	// /**
	//  * sends a collapsed group log
	//  *
	//  * @param string value
	//  */
	// final public function groupCollapsed()
	// {
	// 	return $this->_log(self::GROUP_COLLAPSED, func_get_args());
	// }
	//
	// /**
	//  * ends a group log
	//  *
	//  * @param string value
	//  */
	// public function groupEnd()
	// {
	// 	return $this->_log(self::GROUP_END, func_get_args());
	// }

	/**
	 * formats the location from backtrace using sprintf
	 *
	 * @param  string $file   the file the log was created in
	 * @param  int    $line   the line the log was created on
	 * @param  string $format output format
	 *
	 * @return string         location formatted according to $format
	 */
	final protected function _formatLocation($file, $line, $format = self::LOG_FORMAT)
	{
		return sprintf($format, $file, $line);
	}

	/**
	 * internal logging call
	 *
	 * @param string $type
	 * @return void
	 */
	final protected function _log($type, array $args)
	{
		// nothing passed in, don't do anything
		if (count($args) === 0 && $type !== self::GROUP_END) {
			return;
		}
		$this->_processed = array();

		$logs = array_map([$this, '_convert'], $args);
		$backtrace = debug_backtrace(false);
		$level = $this->{self::BACKTRACE_LEVEL};
		$backtrace_message = 'unknown';
		if (isset($backtrace[$level]['file'], $backtrace[$level]['line'])) {
			$backtrace_message = $this->_formatLocation(
				$backtrace[$level]['file'],
				$backtrace[$level]['line']
			);
		}
		$this->_addRow($logs, $backtrace_message, $type);
	}

	/**
	 * converts an object to a better format for logging
	 *
	 * @param Object
	 * @return array
	 */
	final protected function _convert($object)
	{
		// if this isn't an object then just return it
		if (!is_object($object)) {
			return $object;
		}
		//Mark this object as processed so we don't convert it twice and it
		//Also avoid recursion when objects refer to each other
		$this->_processed[] = $object;
		$object_as_array = array();
		// first add the class name
		$object_as_array['___class_name'] = get_class($object);
		// loop through object vars
		$object_vars = get_object_vars($object);
		foreach ($object_vars as $key => $value) {
			// same instance as parent object
			if ($value === $object || in_array($value, $this->_processed, true)) {
				$value = 'recursion - parent object [' . get_class($value) . ']';
			}
			$object_as_array[$key] = $this->_convert($value);
		}
		$reflection = new \ReflectionClass($object);
		// loop through the properties and add those
		foreach ($reflection->getProperties() as $property) {
			// if one of these properties was already added above then ignore it
			if (array_key_exists($property->getName(), $object_vars)) {
				continue;
			}
			$type = $this->_getPropertyKey($property);
			if ($this->_php_version >= 5.3) {
				$property->setAccessible(true);
			}
			try {
				$value = $property->getValue($object);
			} catch (\ReflectionException $e) {
				$value = 'only PHP 5.3 can access private/protected properties';
			}
			// same instance as parent object
			if ($value === $object || in_array($value, $this->_processed, true)) {
				$value = 'recursion - parent object [' . get_class($value) . ']';
			}
			$object_as_array[$type] = $this->_convert($value);
		}
		return $object_as_array;
	}

	/**
	 * takes a reflection property and returns a nicely formatted key of the property name
	 *
	 * @param ReflectionProperty
	 * @return string
	 */
	final protected function _getPropertyKey(\ReflectionProperty $property)
	{
		$static = $property->isStatic() ? ' static' : '';
		if ($property->isPublic()) {
			return 'public' . $static . ' ' . $property->getName();
		}
		if ($property->isProtected()) {
			return 'protected' . $static . ' ' . $property->getName();
		}
		if ($property->isPrivate()) {
			return 'private' . $static . ' ' . $property->getName();
		}
	}

	/**
	 * adds a value to the data array
	 *
	 * @var mixed
	 * @return void
	 */
	final protected function _addRow(array $logs, $backtrace, $type)
	{
		// if this is logged on the same line for example in a loop, set it to null to save space
		if (in_array($backtrace, $this->_backtraces)) {
			$backtrace = null;
		}
		// for group, groupEnd, and groupCollapsed
		// take out the backtrace since it is not useful
		if ($type === self::GROUP || $type === self::GROUP_END || $type === self::GROUP_COLLAPSED) {
			$backtrace = null;
		}
		if (isset($backtrace)) {
			$this->_backtraces[] = $backtrace;
		}
		array_push($this->_json['rows'], array($logs, $backtrace, $type));
	}
}
