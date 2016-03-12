<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
 * @version 1.0.0
 * @copyright 2016, Chris Zuber
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
 * Trait for parsing, setting, and removing headers.
 * Does not contain a method for getting request header, since that is done statically
 */
trait Headers
{
	private static $_request_headers = array();
	/**
	 * Protected method to get the headers array, cleaned for usage with magic methods
	 *
	 * @param void
	 * @return array Headers array
	 */
	final protected static function _readHeaders()
	{
		if (empty(static::$_request_headers)) {
			$headers = function_exists('getallheaders') ? getallheaders() : [];
			$keys = array_keys($headers);
			array_walk($keys, [__CLASS__, '_cleanHeader']);
			static::$_request_headers = array_combine($keys, array_values($headers));
		}
		return static::$_request_headers;
	}

	/**
	 * Get a request header's value by key
	 *
	 * @param  string $key
	 * @return string      Value of the header
	 */
	final public function getHeader($key)
	{
		if (static::hasHeader($key)) {
			static::_cleanHeader($key);
			return static::_readHeaders()[$key];
		}
	}

	/**
	 * Check if a request header was sent
	 *
	 * @param  string  $key Name of header to check for
	 * @return boolean      If it was sent
	 */
	final public static function hasHeader($key)
	{
		static::_cleanHeader($key);
		return array_key_exists($key, static::_readHeaders());
	}

	/**
	 * Set a response header
	 *
	 * @param string $key   Header key to set
	 * @param mixed  $value String or array value to set it to
	 * @return void
	 */
	final public static function setHeader($key, $value)
	{
		if (function_exists('header')) {
			static::_cleanHeader($key);
			if (is_array($value) or (is_object($value) and $value = get_object_vars($value))) {
				$value = join('; ', array_map(
					[__CLASS__, '_encodeHeader'],
					array_keys($value),
					array_values($value)
				));
			}
			header("$key: $value");
		}
	}

	/**
	 * Remove a header client-side
	 *
	 * @param string $key The header key to remove
	 * @return void
	 */
	final public static function removeHeader($key)
	{
		if (function_exists('header_remove')) {
			static::_cleanHeader($key);
			header_remove($key);
		}
	}

	/**
	 * Protected static method for making header names safe for magic methods
	 *
	 * @param  string $prop String for header name
	 * @return void
	 */
	final protected static function _cleanHeader(&$prop)
	{
		$prop = str_replace(' ', '-', ucwords(str_replace(['-', '_'], ' ', strtolower($prop))));
	}

	/**
	 * Converts header values for non-simple headers
	 *
	 * @param  mixed  $key   Name
	 * @param  string $value Value
	 * @return string        String to set header to
	 */
	final private static function _encodeHeader($key, $value)
	{
		if (is_string($key)) {
			return "$key=$val";
		} else {
			return "$val";
		}
	}
}
