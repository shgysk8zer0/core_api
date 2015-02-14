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
 * Provides object oriented methods for cURL multi-handle functions
 * @see http://php.net/manual/en/ref.curl.php
 */
trait cURL_Multi
{
	protected $curl_multi_handle = null;

	/**
	 * Creates a new cURL multi handle
	 *
	 * @param void
	 * @return self
	 */
	final public function curlMultiInit()
	{
		$this->curl_multi_handle = curl_multi_init();
		return $this;
	}

	/**
	 * Add a normal cURL handle to a cURL multi handle
	 *
	 * @param resource $ch A cURL handle returned by curl_init()
	 * @return self
	 */
	final public function curlMultiAddHandle($ch = null)
	{
		curl_multi_add_handle(
			$this->curl_mlti_handle,
			$ch
		);
		return $this;
	}

	/**
	 * Run the sub-connections of the current cURL handle
	 *
	 * @param int $still_running A reference to a flag to tell whether the operations are still running
	 * @return self
	 */
	final public function curlMultiExec(&$still_running)
	{
		curl_multi_exec($this->curl_multi_handle, $still_running);
		return $this;
	}

	/**
	 * Return the content of a cURL handle if CURLOPT_RETURNTRANSFER is set
	 *
	 * @param void
	 * @return string   The content of a cURL handle if CURLOPT_RETURNTRANSFER is set.
	 */
	final public function curlMultiGetContent()
	{
		return curl_multi_getcontent($this->curl_multi_handle);
	}

	/**
	 * Get information about the current transfers
	 *
	 * @param int $msgs_in_queue Number of messages that are still in the queue
	 * @return array             On success, returns an associative array for the message, FALSE on failure.
	 */
	final public function curlMultiInfoRead(&$msgs_in_queue = null)
	{
		return curl_multi_info_read($this->curl_multi_handle, $msgs_in_queue);
	}

	/**
	 * Remove a multi handle from a set of cURL handles
	 *
	 * @param resource $ch A cURL handle returned by curl_init().
	 * @return self
	 */
	final public function culrMultiRemoveHandle($ch)
	{
		curl_multi_remove_handle($this->curl_multi_handle, $ch);
		return $this;
	}

	/**
	 * Wait for activity on any curl_multi connection
	 * Blocks until there is activity on any of the curl_multi connections.
	 *
	 * @param float $timeout Time, in seconds, to wait for a response.
	 */
	final public function curlMultiSelect($timeout = 1.0)
	{
		curl_multi_select($this->curl_multi_handle, $timeout);
	}

	/**
	 * Set an option for the cURL multi handle
	 *
	 * @param int $option    One of the CURLMOPT_* constants.
	 * @param mixed $value   The value to be set on option.
	 * @return self
	 */
	final public function curlMultiSetOpt($option, $value)
	{
		curl_multi_setopt($this->curl_multi_handle, $option, $value);
		return $this;
	}

	/**
	 * Return string describing error code
	 *
	 * @param int $errornum One of the CURLM error codes constants. 
	 * @return string       Error string for valid error code, NULL otherwise.
	 */
	final public function curlMultiStrerror($errornum)
	{
		return curl_multi_strerror($this->curl_multi_handle, $errornum);
	}
}
