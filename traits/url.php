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

use \shgysk8zer0\Core\URLSearchParams as Params;

/**
 * Dynamically build absolute URLs filling in current values for defaults
 */
trait URL
{
	use Ports;
	/**
	 * Array of default data for URL
	 *
	 * @var array
	 */
	protected $_url_data = array(
		'scheme' => 'http',
		'host' => 'localhost',
		'port' => 80,
		'user' => null,
		'pass' => null,
		'path' => '/',
		'query' => null,
		'fragment' => null
	);

	/**
	 * Break  URL into components, setting missing values to components from
	 * current calculated URL using $_SERVER. Does not set user, pass, or port,
	 * as those are likely to be either security risks or unnecessary.
	 *
	 * @param string $url A URL string
	 * @return array
	 * @see http://php.net/manual/en/function.parse-url.php
	 */
	final public static function parseURL($url = null)
	{
		$data = parse_url(is_string($url) ? $url : static::getRequestURL());
		if ($data === false) {
			trigger_error(sprintf('Error parsing URL in %s', __METHOD__));
			return array();
		}
		if (is_null($_SERVER)) {
			$_SERVER = array();
		}
		if (! array_key_exists('scheme', $data)) {
			$data['scheme'] = array_key_exists('REQUEST_SCHEME', $_SERVER) ? $_SERVER['REQUEST_SCHEME'] : 'http';
		}
		if (! array_key_exists('host', $data)) {
			$data['host'] = array_key_exists('SERVER_NAME', $_SERVER) ? $_SERVER['SERVER_NAME'] : 'localhost';
		}
		if (! array_key_exists('port', $data)) {
			if (array_key_exists('SERVER_PORT', $data)) {
				$data['port'] = $_SERVER['SERVER_PORT'];
			} else {
				$scheme = strtoupper($data['scheme']);
				if (defined("\shgysk8zer0\Core_API\Abstracts\Ports::{$scheme}")) {
					$data['port'] = constant("\shgysk8zer0\Core_API\Abstracts\Ports::{$scheme}");
				}
				unset($scheme);
			}
		}
		if (! array_key_exists('user', $data) and array_key_exists('PHP_AUTH_USER', $_SERVER)) {
			$data['user'] = $_SERVER['PHP_AUTH_USER'];
		}
		if (! array_key_exists('pass', $data) and array_key_exists('PHP_AUTH_PW', $_SERVER)) {
			$data['pass'] = $_SERVER['PHP_AUTH_PW'];
		}
		$data['query'] = new Params(array_key_exists('query', $data) ? $data['query'] : null);
		return $data;
	}

	/**
	 * URL encodes a string
	 *
	 * @param string $str string to encode
	 * @return string     the encoded string
	 */
	final public static function URLEncode($str)
	{
		return urlencode($str);
	}

	/**
	 * URL decodes a string
	 *
	 * @param string $str the string to decode
	 * @return string     the decoded string
	 */
	final public static function URLDecode($str)
	{
		return urldecode($str);
	}

	/**
	 * Static method to get the request URL from $_SERVER vars
	 *
	 * @param void
	 * @return string the URL string built from $_SERVER
	 */
	final public static function getRequestURL()
	{
		$url = array_key_exists('REQUEST_SCHEME', $_SERVER)
			? "{$_SERVER['REQUEST_SCHEME']}://"
			: 'http://';
		if (array_key_exists('PHP_AUTH_USER', $_SERVER)) {
			$url .= static::URLEncode($_SERVER['PHP_AUTH_USER']);
			if (array_key_exists('PHP_AUTH_PW', $_SERVER)) {
				$url .= ':' . static::URLEncode($_SERVER['PHP_AUTH_PW']);
			}
			$url .= '@';
		}

		$url .= $_SERVER['HTTP_HOST'];
		$url .= $_SERVER[array_key_exists('REDIRECT_URL', $_SERVER) ? 'REDIRECT_URL' : 'REQUEST_URI'];

		return $url;
	}

	/**
	 * Combine URL components into a URL string
	 *
	 * @param void
	 * @return string
	 */
	final protected function URLToString(array $components = array(
		'scheme',
		'user',
		'pass',
		'host',
		'port',
		'path',
		'query',
		'fragment'
	))
	{
		$url = '';
		$query = "{$this->query}";
		if (in_array('scheme', $components)) {
			if (is_string($this->_url_data['scheme'])) {
				$url .= rtrim($this->_url_data['scheme'], ':/') . '://';
			} else {
				$url .= 'http://';
			}
		}

		if (@is_string($this->_url_data['user']) and in_array('user', $components)) {
			$url .= urlencode($this->_url_data['user']);
			if (@is_string($this->_url_data['pass']) and in_array('pass', $components)) {
				$url .= ':' . urlencode($this->_url_data['pass']);
			}
			$url .= '@';
		}

		if (in_array('host', $components)) {
			if (@is_string($this->_url_data['host'])) {
				$url .= $this->_url_data['host'];
			} else {
				$url .= 'localhost';
			}
		}
		if (
			is_int($this->_url_data['port'])
			and ! $this->isDefaultPort($this->_url_data['scheme'], $this->_url_data['port'])
		) {
			$url .= ":{$this->_url_data['port']}";
		}
		if (in_array('path', $components)) {
			if (@is_string($this->_url_data['path'])) {
				$url .= '/' . ltrim($this->_url_data['path'], '/');
			} else {
				$url .= '/';
			}
		}

		if(
			strlen($query) !== 0 and in_array('query', $components)
		) {
			$url .= "?$query";
		}
		if (@is_string($this->_url_data['fragment']) and in_array('fragment', $components)) {
			$url .= '#' . ltrim($this->_url_data['fragment'], '#');
		}
		return $url;
	}
}
