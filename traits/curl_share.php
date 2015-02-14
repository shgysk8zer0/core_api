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
 * Provides object oriented methods for cURL share handle
 * @see http://php.net/manual/en/book.curl.php
 */
trait cURL_Share
{
	protected $curl_share_handle;

	/**
	 * Initialize a cURL share handle
	 *
	 * @param void
	 * @return self
	 */
	final public function curlShareInit()
	{
		$this->curl_share_handle = curl_share_init();
		return $this;
	}

	/**
	 * Close a cURL share handle
	 *
	 * @param void
	 * @return void
	 */
	final public function curlShareClose()
	{
		curl_share_close($this->curl_share_handle);
	}

	/**
	 * Set an option for a cURL share handle.
	 *
	 * @param int   $option CURLSHOPT_SHARE | CURLSHOPT_UNSHARE
	 * @param mixed $value  CURL_LOCK_DATA_(COOKIE | DNS | SSL_SESSION)
	 * @return self
	 */
	final public function curlShareSetOpt($option, $value)
	{
		curl_share_setotp($this->curl_share_handle, $option, $value);
		return $this;
	}
}
