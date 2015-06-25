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
namespace shgysk8zer0\Core_API\Interfaces;

/**
 * Provides Object Oriented methods for cURL functions
 * @see http://php.net/manual/en/book.curl.php
 */
interface cURL
{
	/**
	 * Initialize a cURL session
	 *
	 * @param sstring $url If provided, the CURLOPT_URL option will be set to its value
	 * @return self
	 */
	public function curlInit($url = null);

	/**
	 * Copy a cURL handle along with all of its preferences
	 *
	 * @param void
	 * @return resource
	 */
	public function curlCopyHandle();

	/**
	 * Reset all options of a libcurl session handle
	 *
	 * @param void
	 * @return self
	 */
	public function curlReset();

	/**
	 * Pause and unpause a connection
	 *
	 * @param int $bitmask One of CURLPAUSE_* constants.
	 * @return self
	 */
	public function curlPause($bitmask);

	/**
	 * Close a cURL session
	 *
	 * @param void
	 * @return void
	 */
	public function curlClose();

	/**
	 * Perform a cURL session
	 *
	 * @param void
	 * @return mixed True or false unless CURLOPT_RETURNTRANSFER is set
	 */
	public function curlExec();

	/**
	 * Set an option for a cURL transfer
	 *
	 * @param int   $opt   The CURLOPT_XXX option to set.
	 * @param mixed $value The value to be set on option.
	 * @return self
	 * @see http://php.net/manual/en/function.curl-setopt.php
	 */
	public function curlSetOpt($opt, $value);

	/**
	 * Set multiple options for a cURL transfer
	 *
	 * @param array $options An array specifying which options to set and their values.
	 * @return self
	 */
	public function curlSetOptArray(array $options = array());

	/**
	 * URL encodes the given string
	 *
	 * @param string $str The string to be encoded.
	 * @return string     Escaped string
	 */
	public function curlEscape($str);

	/**
	 * Decodes the given URL encoded string
	 *
	 * @param string $str The URL encoded string to be decoded.
	 * @return string     The decoded string
	 */
	public function curlUnescape($str);

	/**
	 * Return the last error number
	 *
	 * @param void
	 * @return int  The error number or 0 (zero) if no error occurred.
	 */
	public function curlErrno();

	/**
	 * Return a string containing the last error for the current session
	 *
	 * @param void
	 * @return string  The error message or '' (the empty string) if no error occurred.
	 */
	public function curlError();

	/**
	 * Return string describing the given error code
	 *
	 * @param int $errnum One of the cURL error codes constants.
	 * @return string     Error description or NULL for invalid error code.
	 */
	public function curlStrError($errnum);

	/**
	 * Gets cURL version information
	 *
	 * @param int $age ?
	 * @return array
	 */
	public function curlVersion($age = CURLVERSION_NOW);

	/**
	 * Get information regarding a specific transfer
	 *
	 * @param integer $opt One of the cURL constants
	 * @return mixed       Value if $opt given, array otherwise
	 */
	public function curlGetInfo($opt = 0);
}
