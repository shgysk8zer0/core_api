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
 * Dynamically build absolute URLs filling in current values for defaults
 */
trait URL
{
	protected $url_data = [];

	/**
	 * Break  URL into components, setting missing values to components from
	 * current calculated URL using $_SERVER. Does not set user, pass, or port,
	 * as those are likely to be either security risks or unnecessary.
	 *
	 * @param mixed $url URL string or anything containing components from parse_url
	 * @return self
	 * @see http://php.net/manual/en/function.parse-url.php
	 */
	final protected function parseURL($url = null)
	{
		if (is_string($url)) {
			// If $url is a string, we can just use parse_url
			$url = parse_url($url);
			if (array_key_exists('pass', $url)) {
				$url['pass'] = urldecode($url['pass']);
			}
			if (array_key_exists('user', $url)) {
				$url['user'] = urldecode($url['user']);
			}
		} elseif (is_object($url)) {
			// If it is an object, we must convert it into an array
			$url = get_object_vars($url);
		} elseif (!is_array($url)) {
			// For all other casses (namely null), use the caclulated URL
			$url = [];
		}

		if (is_array($url)) {
			// Use array_merge to fill in missing components of $url
			$this->url_data = array_merge(
			[
				'scheme' => array_key_exists('REQUEST_SCHEME', $_SERVER)
					? $_SERVER['REQUEST_SCHEME']
					: 'http',
				'host' => array_key_exists('HTTP_HOST', $_SERVER)
					? $_SERVER['HTTP_HOST']
					: 'localhost',
				'port' => array_key_exists('SERVER_PORT', $_SERVER)
					? (int)$_SERVER['SERVER_PORT']
					: 80,
				'user' => array_key_exists('PHP_AUTH_USER', $_SERVER)
					? $_SERVER['PHP_AUTH_USER']
					: null,
				'pass' => array_key_exists('PHP_AUTH_PW', $_SERVER)
					? $_SERVER['PHP_AUTH_PW']
					: null,
				'path' => array_key_exists('REQUEST_URI', $_SERVER)
					? strtok($_SERVER['REQUEST_URI'], '?')
					: '/',
				'query' => array_key_exists('QUERY_STRING', $_SERVER)
					? $_SERVER['QUERY_STRING']
					: null,
				'fragment' => null
			],
				$url
			);
		}
		if ($this->url_data['path'] !== '/') {
			$this->url_data['path'] = '/' . trim($this->url_data['path'], '/');
		}
		return $this;
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
		if (in_array('scheme', $components)) {
			if (is_string($this->url_data['scheme'])) {
				$url .= rtrim($this->url_data['scheme'], ':/') . '://';
			} else {
				$url .= 'http://';
			}
		}

		if (@is_string($this->url_data['user']) and in_array('user', $components)) {
			$url .= urlencode($this->url_data['user']);
			if (@is_string($this->url_data['pass']) and in_array('pass', $components)) {
				$url .= ':' . urlencode($this->url_data['pass']);
			}
			$url .= '@';
		}

		if (in_array('host', $components)) {
			if (@is_string($this->url_data['host'])) {
				$url .= $this->url_data['host'];
			} else {
				$url .= 'localhost';
			}
		}
		if (
			@is_int($this->url_data['port'])
			and ! in_array($this->url_data['port'], array(80, 443))
			and in_array('port', $components)
		) {
			$url .= ":{$this->url_data['port']}";
		}
		if (in_array('path', $components)) {
			if (@is_string($this->url_data['path'])) {
				$url .= '/' . ltrim($this->url_data['path'], '/');
			} else {
				$url .= '/';
			}
		}

		if(
			isset($this->url_data['query'])
			and ! empty($this->url_data['query'])
			and in_array('query', $components)
		) {
			if (! is_string($this->url_data['query'])) {
				$url .= '?' . http_build_query($this->url_data['query']);
			} elseif (@is_string($this->url_data['query'])) {
				$url .= '?' . ltrim($this->url_data['query'], '?');
			}
		}
		if (@is_string($this->url_data['fragment']) and in_array('fragment', $components)) {
			$url .= '#' . ltrim($this->url_data['fragment'], '#');
		}
		return $url;
	}
}
