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
 * Provides Object Oriented methods for cURL functions
 * @see http://php.net/manual/en/book.curl.php
 */
trait cURL
{
	protected $curl_handle = null;

	/**
	 * Initialize a cURL session
	 *
	 * @param sstring $url If provided, the CURLOPT_URL option will be set to its value
	 * @return self
	 */
	final public function curlInit($url = null)
	{
		$this->curl_handle = curl_init($url);
		return $this;
	}

	/**
	 * Copy a cURL handle along with all of its preferences
	 *
	 * @param void
	 * @return resource
	 */
	final public function curlCopyHandle()
	{
		return curl_copy_handle($this->curl_handle);
	}

	/**
	 * Reset all options of a libcurl session handle
	 *
	 * @param void
	 * @return self
	 */
	final public function curlReset()
	{
		curl_reset($this->curl_handle);
		return $this;
	}

	/**
	 * Pause and unpause a connection
	 *
	 * @param int $bitmask One of CURLPAUSE_* constants.
	 * @return self
	 */
	final public function curlPause($bitmask)
	{
		curl_pause($this->curl_handle, $bitmask);
		return $this;
	}

	/**
	 * Close a cURL session
	 *
	 * @param void
	 * @return void
	 */
	final public function curlClose()
	{
		curl_close($this->curl_handle);
	}

	/**
	 * Perform a cURL session
	 *
	 * @param void
	 * @return mixed True or false unless CURLOPT_RETURNTRANSFER is set
	 */
	final public function curlExec()
	{
		return curl_exec($this->curl_handle);
	}

	/**
	 * Set an option for a cURL transfer
	 *
	 * @param int   $opt   The CURLOPT_XXX option to set.
	 * @param mixed $value The value to be set on option.
	 * @return self
	 * @see http://php.net/manual/en/function.curl-setopt.php
	 */
	final public function curlSetOpt($opt, $value)
	{
		curl_setopt($this->curl_handle, $opt, $value);
		return $this;
	}

	/**
	 * Set multiple options for a cURL transfer
	 *
	 * @param array $options An array specifying which options to set and their values.
	 * @return self
	 */
	final public function curlSetOptArry(array $options = array())
	{
		curl_setopt_array($this->curl_handle, $options);
		return $this;
	}

	/**
	 * URL encodes the given string
	 *
	 * @param string $str The string to be encoded.
	 * @return string     Escaped string
	 */
	final public function curlEscape($str)
	{
		return curl_escape($this->curl_handle, $str);
	}

	/**
	 * Decodes the given URL encoded string
	 *
	 * @param string $str The URL encoded string to be decoded.
	 * @return string     The decoded string
	 */
	final public function curlUnescape($str)
	{
		return curl_unescape($this->curl_handle, $str);
	}

	/**
	 * Return the last error number
	 *
	 * @param void
	 * @return int  The error number or 0 (zero) if no error occurred.
	 */
	final public function curlErrno()
	{
		return curl_errno($this->curl_handle);
	}

	/**
	 * Return a string containing the last error for the current session
	 *
	 * @param void
	 * @return string  The error message or '' (the empty string) if no error occurred.
	 */
	final public function curlError()
	{
		return curl_error($this->curl_handle);
	}

	/**
	 * Return string describing the given error code
	 *
	 * @param int $errnum One of the cURL error codes constants.
	 * @return string     Error description or NULL for invalid error code.
	 */
	final public function curlStrError($errnum)
	{
		return curl_strerror($this->curl_handle, $errnum);
	}

	/**
	 * Gets cURL version information
	 *
	 * @param int $age ?
	 * @return array
	 */
	final public function curlVersion($age = CURLVERSION_NOW)
	{
		return curl_version($this->curl_handle, $age);
	}

	/**
	 * Get information regarding a specific transfer
	 *
	 * @param integer $opt One of the cURL constants
	 * @return mixed       Value if $opt given, array otherwise
	 */
	final public function curlGetInfo($opt = 0)
	{
		return curl_getinfo($this->curl_handle, $opt);
	}
}
