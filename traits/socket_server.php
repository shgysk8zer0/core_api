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
 *
 * @see http://php.net/manual/en/book.sockets.php
 */
trait Socket_Server
{
	public $socket_server;

	/**
	 * Create a socket (endpoint for communication)
	 *
	 * @see http://php.net/manual/en/function.socket-create.php
	 *
	 * @param int $domain   The protocol family to be used by the socket.
	 * @param int $type     The type of communication to be used by the socket.
	 * @param int $protocol Sets the specific protocol within the specified domain
	 * @return self
	 */
	final public function socketCreate(
		$domain = AF_INET,
		$type = SOCK_STREAM,
		$protocol = SOL_TCP
	)
	{
		$this->socket_server = socket_create($domain, $type, $protocol);
		return $this;
	}

	/**
	 * Binds a name to a socket
	 * Note: If socket was created with type AF_UNIX, then address will be the
	 * path to a Unix-domain socket (/path/to/socket.sock) instead of an IP
	 * address and $port will be unnecessary.
	 *
	 * @see http://php.net/manual/en/function.socket-bind.php
	 *
	 * @param string  $address An IP in dotted-quad notation (e.g. 127.0.0.1).
	 * @param int     $port    Designates the port on which to listen for connections.
	 * @return bool
	 */
	final public function socketBind($address, $port = 0)
	{
		return socket_bind($this->socket_server, "{$address}", (int)$port);
	}

	/**
	 * Listens for a connection on a socket
	 * Applicable only to sockets of type SOCK_STREAM or SOCK_SEQPACKET.
	 *
	 * @see http://php.net/manual/en/function.socket-listen.php
	 *
	 * @param int $backlog A maximum of backlog incoming connections will be queued for processing.
	 * @return bool
	 */
	final public function socketListen($backlog = 0)
	{
		return socket_listen($this->socket_server);
	}

	/**
	 * Reads a maximum of length bytes from a socket
	 *
	 * @see http://php.net/manual/en/function.socket-read.php
	 *
	 * @param int  $length The maximum number of bytes read
	 * @param int  $type   Binary or normal
	 * @return string
	 */
	final public function socketRead($length = 2048, $type = PHP_NORMAL_READ)
	{
		return socket_read($this->socket_server, $length, $type);
	}
}
