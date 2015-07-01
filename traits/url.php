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
	/**
	 * Array of default data for URL
	 *
	 * @var array
	 */
	protected $url_data = array(
		'scheme' => 'http',
		'host' => 'localhost',
		'port' => 80,
		'user' => null,
		'pass' => null,
		'path' => '/',
		'query' => array(),
		'fragment' => null
	);

	/**
	 * Array of reserved port numbers, such as HTTP, HTTPS, etc
	 *
	 * @var array
	 */
	private $_reserved_ports = array(
		'HTTP' => 80,
		'HTTPS' => 443,
		'FTP-data' => 20,
		'FTP' => 21,
		'SSH' => 22,
		'Telnet' => 23,
		'WHOIS' => 43,
		'DNS' => 53,
		'GOPHER' => 70,
		'POP3' => 110,
		'Ident' => 113,
		'IMAP' => 143,
		'IRC' => 194,
		'IMAP-3' => 220,
		'SMTPS' => 465,
		'SMTP' => 587,
		'Flash' => 843,
		'rsync' => 873,
		'Samba' => 901,
		'SharePoint' => 987,
		'FTPS-data' => 989,
		'FTPS' => 990,
		'NAS' => 991,
		'TELNETS' => 993,
		'IRCS' => 994,
		'POP3S' => 995,
		'IMAPS' => 993,
		'MySQL' => 3306
	);

	/**
	 * Break  URL into components, setting missing values to components from
	 * current calculated URL using $_SERVER. Does not set user, pass, or port,
	 * as those are likely to be either security risks or unnecessary.
	 *
	 * @param string $url A URL string
	 * @return self
	 * @see http://php.net/manual/en/function.parse-url.php
	 */
	final protected function parseURL()
	{

		$this->_parseRequestURL();

		$args = array_map('urldecode', array_filter(func_get_args(), 'is_string'));
		$args = array_reverse($args);

		$this->url_data = array_reduce($args, [$this, '_buildFromURLs'], $this->url_data);

		$this->_normalizeURL();

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
			and ! in_array($this->url_data['port'], $this->_reserved_ports)
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
			if (@ is_array($this->url_data['query'])) {
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

	/**
	 * Starts the URL data from info taken from $_SERVER
	 *
	 * @param void
	 * @return void
	 */
	private function _parseRequestURL()
	{
		if (array_key_exists('REQUEST_SCHEME', $_SERVER)) {
			$this->url_data['scheme'] = $_SERVER['REQUEST_SCHEME'];
		}

		if (array_key_exists('HTTP_HOST', $_SERVER)) {
			$this->url_data['host'] = $_SERVER['HTTP_HOST'];
		}

		if (array_key_exists('SERVER_PORT', $_SERVER)) {
			$this->url_data['port'] = (int)$_SERVER['SERVER_PORT'];
		}

		if (array_key_exists('PHP_AUTH_USER', $_SERVER)) {
			$this->url_data['pass'] = $_SERVER['PHP_AUTH_PW'];
		}

		if (array_key_exists('PHP_AUTH_PW', $_SERVER)) {
			$this->url_data['pass'] = $_SERVER['PHP_AUTH_PW'];
		}

		if (array_key_exists('REQUEST_URI', $_SERVER)) {
			$this->url_data['path'] = strtok($_SERVER['REQUEST_URI'], '?');
		}

		if (array_key_exists('QUERY_STRING', $_SERVER)) {
			$this->url_data['query'] = $_SERVER['QUERY_STRING'];
		}
	}

	/**
	 * Parses and merges arrays of URL data
	 *
	 * @param  array  $parsed Array containing data, as from parse_url
	 * @param  string $url    The current URL to parse
	 *
	 * @return array          The origiinal $parsed array, hopefully with
	 */
	private function _buildFromURLs(array $parsed, $url)
	{
		if (! is_string($url)) {
			throw new \InvalidArgumentException(sprintf('%s expects a URL string. Got %s instead', __METHOD__, gettype($url)));
		} elseif ($url = parse_url($url)) {
			$parsed = array_merge($parsed, array_filter($url));
		} else {
			throw new \InvalidArgumentException(sprintf('Error parsing URL "%s" in %s', func_get_arg(1), __METHOD__));
		}
		return $parsed;
	}

	/**
	 * Makes slashes in path consisten, and converts query to an array
	 *
	 * @param void
	 * @return void
	 */
	private function _normalizeURL()
	{
		if ($this->url_data['path'] !== '/') {
			$this->url_data['path'] = '/' . trim($this->url_data['path'], '/');
		}

		parse_str($this->url_data['query'], $this->url_data['query']);
	}
}
