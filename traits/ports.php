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

use \shgysk8zer0\Core_API\Abstracts\Ports as Port;

/**
 * Trait for matching or converting schemes and port numbers
 */
trait Ports
{
	/**
	 * Full class containing Port contstants
	 *
	 * @var string
	 */
	private $_port_class = '\\shgysk8zer0\\Core_API\\Abstracts\\Ports::';

	/**
	 * Get the port number from its name or scheme
	 *
	 * @param  string $name The name or scheme
	 * @return int          The default port number for it
	 */
	final public function getDefaultPort($name)
	{
		$this->_getPortKey($name);
		if ($this->isNamedPort($name)) {
			return constant($this->_port_class . $name);
		} else {
			throw new \InvalidArgumentException("Unknown name or scheme: {$name}");
		}
	}

	/**
	 * Checks that the given scheme and port match, according to defaults
	 *
	 * @param  string $scheme The scheme name (E.G. http)
	 * @param  int    $port   The number to check default port against
	 *
	 * @return bool           Whether or not given port is the default for the scheme
	 */
	final public function isDefaultPort($scheme, $port)
	{
		$this->_getPortKey($scheme);
		try {
			return $this->isNamedPort($scheme) and ($this->getDefaultPort($scheme) === (int)$port);
		} catch (\Exception $e) {
			echo $e. PHP_EOL;
		}
	}

	/**
	 * Checks if scheme ($name) has a defined default port
	 *
	 * @param  string $name The scheme name
	 * @return bool         Whether or not it is defined
	 */
	final public function isNamedPort($name)
	{
		$this->_getPortKey($name);
		return defined($this->_port_class . $name);
	}

	/**
	 * Private, internal method for normalizing schemes/names into constant names
	 *
	 * @param  string $name The scheme name
	 * @return void
	 * @example $this->_getPortKey('https://') // Converts to 'HTTPS'
	 */
	final private function _getPortKey(&$name)
	{
		if (! is_string($name)) {
			throw new \InvalidArgumentException(sprintf(
				'%s requires a string. %s given instead',
				__METHOD__,
				gettype($name)
			));
		}
		$name = strtoupper(str_replace(['-', ':', '/'], ['_', null], $name));
	}
}
