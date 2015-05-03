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

/**
 * HTTP authentication
 * @see https://php.net/manual/en/features.http-auth.php
 */
trait HTTP_Auth
{
	/**
	 * HTTP user string
	 * @var string
	 */
	public $HTTP_user = null;

	/**
	 * HTTP password string
	 * @var string
	 */
	public $HTTP_pass = null;

	/**
	 * Checks for credentials in HTTP headers for "Basic" authentication
	 *
	 * @param string $realm
	 * @return bool
	 */
	final public function authenticateBasic($realm = null)
	{
		if (! (
			array_key_exists('PHP_AUTH_USER', $_SERVER)
			and array_key_exists('PHP_AUTH_PW', $_SERVER))
			and ! empty($_SERVER['PHP_AUTH_USER'])
			and ! empty($_SERER['PHP_AUTH_PW'])
		) {
			$this->HTTPAuthenticate('Basic', array('realm' => $realm));
			return false;
		} else {
			$this->HTTP_user = $_SERVER['PHP_AUTH_USER'];
			$this->HTTP_pass = $_SERVER['PHP_AUTH_PW'];
			return true;
		}
	}

	/**
	 * Send headers requiring HTTP/WWW Authentication
	 *
	 * @param string $mode   Basic or Digest
	 * @param array  $params Additional components, such as "realm"
	 * @return void
	 */
	final public function HTTPAuthenticate(
		$mode         = 'Basic',
		array $params = array()
	)
	{
		if (is_string($mode)) {
			$mode = ucwords(strtolower($mode));
		}
		if (! (is_string($mode) and in_array($mode, array('Basic', 'Digest')))) {
			$mode = 'Basic';
		}
		$params = array_filter($params, 'is_string');
		$params = array_merge(array('realm' => $_SERVER['HTTP_HOST']), $params);
		header(sprintf(
			'WWW-Authenticate: %s %s',
			$mode,
			join(', ', array_map(
				function($key, $val)
				{
					return $key . '="' . trim($val, '"') . '"';
				},
				array_keys($params),
				array_values($params)
			))
		));
		http_response_code(401);
	}
}
