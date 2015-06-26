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
namespace shgysk8zer0\Core_API\Traits\Auth;

/**
 * Trait for using HTTP Basic Authentication
 * @see https://secure.php.net/manual/en/features.http-auth.php
 */
trait Basic
{
	/**
	 * Check for Basic Auth credentials and attempt to login if present
	 *
	 * @param  string $realm The "realm" to pass along if asking for credentials
	 * @return void
	 */
	final public function requireBasicLogin($realm = 'Restricted')
	{
		if (! (
			array_key_exists('PHP_AUTH_USER', $_SERVER)
			and array_key_exists('PHP_AUTH_PW', $_SERVER)
		)) {
			$this->_basicAuthFailed($realm);
		} else {
			$this->loginWith([
				'user' => $_SERVER['PHP_AUTH_USER'],
				'password' => $_SERVER['PHP_AUTH_PW']
			]);

			if (! $this->logged_in) {
				$this->_basicAuthFailed($realm);
			}
		}
	}

	/**
	 * Authentication has already failed, so set the headers & exit
	 *
	 * @param  string $realm "realm" to use in authentication
	 * @return void
	 */
	final protected function _basicAuthFailed($realm = 'Restricted')
	{
		header(sprintf('WWW-Authenticate: Basic realm="%s"', $realm));
		header('HTTP/1.0 401 Unauthorized');
		exit;
	}

	abstract function loginWith(array $creds = array());
}
