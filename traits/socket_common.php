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
 * Contains methods common to Socket Server & Client
 * @see http://php.net/manual/en/book.sockets.php
 */
trait Socket_Common
{
	/**
	 * Creates a pair of indistinguishable sockets and stores them in an array
	 *
	 * @param int    $domain   The protocol family to be used by the socket
	 * @param int    $type     The type of communication to be used by the socket
	 * @param int    $protocol The specific protocol within the specified domain
	 * @param array  $fd       Reference to an array in which the two socket resources will be inserted
	 */
	final public function socketCreatePair($domain, $type, $protocol, array &$fd)
	{
		return socket_create_pair($domain, $type, $protocol, $fd);
	}

	/**
	 * Opens a socket on port to accept connections
	 *
	 * @param int  $port    The port on which to listen on all interfaces
	 * @param int  $backlog Defines the maximum length the queue of pending connections may grow to
	 * @return resource     A new socket resource of type AF_INET listening on all local interfaces on the given port
	 */
	final public function socketCreateListen($port, $backlog = 128)
	{
		return socket_create_listen($port, $backlog);
	}

	/**
	 * Close a socket resource
	 *
	 * @param void
	 * @return void
	 */
	final public function socketClose()
	{
		socket_close($this->socket);
	}

	/**
	 * Sets socket options for the socket
	 *
	 * @param int   $optname  Same as those for the socket_get_option() function
	 * @param mixed $optval   The option value
	 * @param int   $level    The protocol level at which the option resides
	 */
	final public function socketSetOption($optname, $optval, $level = SOL_SOCKET)
	{
		return socket_set_option($this->socket, $level, $optname, $optval);
	}

	/**
	 * Gets socket options for the socket
	 *
	 * @param int $optname Same as those for the socket_get_option() function
	 * @param int $level   The protocol level at which the option resides
	 * @return mixed
	 */
	final public function socketGetOption($optname, $level = SOL_SOCKET)
	{
		return socket_get_option($this->socket, $level, $optname);
	}

	/**
	 * Queries the remote side of the given socket
	 *
	 * @param string $address IP address or Unix socket path
	 * @param int    $port    The port associated to teh address
	 * @return bool           TRUE on success or FALSE on failure
	 */
	final public function socketGetpeername(&$address, &$port = null)
	{
		return socket_getpeername($this->socket, $address, $port);
	}

	/**
	 * Sets blocking mode on a socket resource
	 *
	 * @param void
	 * @return bool   TRUE on success or FALSE on failure
	 */
	final public function socketSetBlock()
	{
		return socket_set_block($this->socket);
	}

	/**
	 * Sets nonblocking mode for file descriptor fd
	 *
	 * @param void
	 * @return bool   TRUE on success or FALSE on failure
	 */
	final public function socketSetNonblock()
	{
		return socket_set_nonblock($this->socket);
	}

	/**
	 * Import a stream
	 *
	 * @param resource $stream The stream resource to import
	 * @return resource        FALSE or NULL on failure
	 */
	final public function socketImportStream($stream)
	{
		return socket_import_stream($stream);
	}

	/**
	 * Runs the select() system call on the given arrays of sockets with a specified timeout
	 *
	 * @param array   $read    Watched to see if characters become available for reading
	 * @param array   $write   Watched to see if a write will not block
	 * @param array   $except  Watched for exceptions
	 * @param int     $tv_sec  Timeout upper bound seconds
	 * @param int     $tv_usec Another timeout option?
	 * @return int   The number of socket resources contained in the modified arrays
	 */
	final public function socketSelect(
		array &$read,
		array &$write,
		array &$except,
		$tv_sec,
		$tv_usec = 0
	)
	{
		return socket_select($read, $write, $except, $tv_sec, $tv_usec);
	}

	/**
	 * Sends data to a connected socket
	 *
	 * @param string $buff  A buffer containing the data that will be sent
	 * @param int    $len   The number of bytes that will be sent
	 * @param int    $flags MSG_(OOB|EOR|EOF|DOUNTROUTE) joined with the binary OR (|) operator
	 * @return int          The number of bytes sent
	 */
	final public function socketSend($buff, $len, $flags = MSG_OOB)
	{
		return socket_send(
			$this->socket,
			$buff,
			is_int($len) ? $len : strlen($buff),
			$flags
		);
	}

	/**
	 * Send a message (undocumented on PHP.net)
	 *
	 * @param array  $message [description]
	 * @param int    $flags   [description]
	 * @return int
	 */
	final public function socketSendmsg(array $message, $flags)
	{
		return socket_sendmsg($this->socket, $message, $flags);
	}

	/**
	 * Sends a message to a socket, whether it is connected or not
	 *
	 * @param string  $buf   The sent data
	 * @param int     $len   len bytes from buf will be sent
	 * @param int     $flags MSG_(OOB|EOR|EOF|DONTROUTE) joined with the binary OR (|) operator
	 * @param int     $addr  IP address of the remote host
	 * @param int     $port  The remote port number at which the data will be sent
	 * @return int
	 */
	final public function socketSendto($buf, $len, $flags, $addr, $port = 0)
	{
		return socket_sendto($this->socket, $buf, $len, $flags, $addr, $port);
	}
}
