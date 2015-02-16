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
trait socket
{
	/**
	 * Variable containing Socket Server resource
	 * @var resource
	 */
	public $socket;

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
		$this->socket = socket_create($domain, $type, $protocol);
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
		return socket_bind($this->socket, "{$address}", (int)$port);
	}

	/**
	 * Shuts down a socket for receiving, sending, or both
	 *
	 * @param int $how {0:reading, 1: writing, 2: both}
	 * @return bool    TRUE on success or FALSE on failure
	 */
	final public function socketShutdown($how = 2)
	{
		return socket_shutdown($this->socket, $how);
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
		return socket_listen($this->socket);
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
		return socket_read($this->socket, $length, $type);
	}

	/**
	 * Receives data from a connected socket
	 *
	 * @param string $buff  Data received will be fetched to the variable
	 * @param int    $len   Up to len bytes will be fetched from remote host
	 * @param int    $flags MSG_(OOB|PEEK|WAITALL|DONTWAIT) joined with the binary OR (|) operator
	 */
	final public function socketRecv(&$buff, $len, $flags)
	{
		return socket_recv($this->socket, $buff, $len, $flags);
	}

	/**
	 * Receives data from a socket whether or not it is connection-oriented
	 *
	 * @param string $buff  The data received
	 * @param int    $len   Up to len bytes will be fetched from remote host
	 * @param int    $flags MSG_(OOB|PEEK|WAITALL|DONTWAIT) joined with the binary OR (|) operator
	 * @param string $name  Path for AF_UNIX, IP address, or null for connection-oriented
	 * @param int    $port  [description]
	 */
	final public function socketRecvfrom(&$buff, $len, $flags, &$name, &$port = null)
	{
		return socket_recvfrom($this->socket, $buff, $len, $flags, $name, $port);
	}

	/**
	 * Returns the last error on the socket
	 *
	 * @param void
	 * @return int   A socket error code
	 */
	final public function socketLastError()
	{
		return socket_last_error($this->socket);
	}

	/**
	 * Return a string describing a socket error
	 *
	 * @param int $errno A valid socket error number, likely produced by socket_last_error()
	 * @return string    The error message associated with the errno parameter
	 */
	final public function socketStrerror($errno = null)
	{
		if (! is_int($errno)) {
			$errno = $this->socketLastError();
		}

		return socket_strerror($errno);
	}

	/**
	 * Clears the error on the socket or the last error code
	 *
	 * @param void
	 * @return void
	 */
	final public function socketClearError()
	{
		socket_clear_error($this->socket);
	}
}
