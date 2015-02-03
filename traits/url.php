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
		$current_url = [
			'scheme' => array_key_exists('REQUEST_SCHEME', $_SERVER)
				? $_SERVER['REQUEST_SCHEME']
				: 'http',
			'host' => array_key_exists('HTTP_HOST', $_SERVER)
				? $_SERVER['HTTP_HOST']
				: 'localhost',
			'port' => null,
			'user' => null,
			'pass' => null,
			'path' => array_key_exists('REQUEST_URI', $_SERVER)
				? $_SERVER['REQUEST_URI']
				: '/',
			'query' => array_key_exists('QUERY_STRING', $_SERVER)
				? $_SERVER['QUERY_STRING']
				: '',
			'fragment' => null
		];

		if (is_string($url)) {
			// If $url is a string, we can just use parse_url
			$url = parse_url($url);
		} elseif (is_object($url)) {
			// If it is an object, we must convert it into an array
			$url = get_object_vars($url);
		} elseif (!is_array($url)) {
			// For all other casses (namely null), use the caclulated URL
			$url = $current_url;
		}

		if (is_array($url)) {
			// Use array_merge to fill in missing components of $url
			$this->url_data = array_merge($current_url, $url);
		}
		return $this;
	}

	/**
	 * Combine URL components into a URL string
	 *
	 * @param void
	 * @return string
	 */
	final protected function URLToString()
	{
		if (! is_string($this->url_data['query'])) {
			$this->url_data['query'] = http_build_query($this->url_data['query']);
		}
		$url = "{$this->url_data['scheme']}://";

		if (@is_string($this->url_data['user'])) {
			$url .= $this->url_data['user'];
			if (@is_string($this->url_data['pass'])) {
				$url .= ":{$this->url_data['pass']}";
			}
			$url .= '@';
		}
		$url .= $this->url_data['host'];
		if (@is_int($this->url_data['port'])) {
			$url .= ":{$this->url_data['port']}";
		}
		$url .= '/' . trim($this->url_data['path'], '/');

		if (@strlen($this->url_data['query'])) {
			$url .= "?{$this->url_data['query']}";
		}
		if (is_string($this->url_data['fragment'])) {
			$url .= "#{$this->url_data['fragment']}";
		}
		return $url;
	}
}
