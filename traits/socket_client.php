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
 * This trait converts Socket functions into OOP.
 * It uses socket* (camelCase) method names instead of socket_* functions.
 * @see http://php.net/manual/en/book.sockets.php
 */
trait socket
{
	/**
	 * Variable containing Socket Client resource
	 * @var resource
	 */
	protected $socket;

	/**
	 * Creates a client side sockets from a server side one
	 *
	 * @param resource $socket Socket created through socket_create
	 * @return resource
	 */
	final public function socketAccept($socket = null)
	{
		if (is_resource($socket)) {
			$this->socket = socket_accept($socket);
			return $this->socket;
		} else {
			throw new InvalidArgumentException(__METHOD__ . ' expects $socket to be an instance of resource. ' . gettype($resource) . ' given instead');
		}
	}

	/**
	 * Reads a maximum of length bytes from a socket
	 *
	 * @param int $length The maximum number of bytes read
	 * @param int $type   PHP_BINARY_READ | PHP_NORMAL_READ
	 * @return string
	 */
	final public function socketRead($length, $type = PHP_BINARY_READ)
	{
		return socket_read($this->socket, $length, $type);
	}

	/**
	 * Write to client socket
	 *
	 * @param string $message The message to send
	 * @param int    $length  Optional lenght (defaults to length of $message)
	 * @return int            The number of bytes successfully written to the socket or FALSE on failure
	 */
	final public function socketWrite($message = '', $length = null)
	{
		return @socket_write(
			$this->socket,
			"{$message}",
			is_int($length) ? $length : strlen($message)
		);
	}

	/**
	 * Queries the local side of the given socket which may either result in
	 * host/port or in a Unix filesystem path, dependent on its type
	 *
	 * @param resource $socket  A valid socket resource created with socket_create() or socket_accept()
	 * @param string   $addr    Varies with socket type.
	 * @param int      $port   If provided, this will hold the associated port.
	 * @return bool
	 */
	final public function socketGetSockName($socket, &$addr, &$port = null)
	{
		return @socket_getsockname($socket, $addr, $port);
	}
}
