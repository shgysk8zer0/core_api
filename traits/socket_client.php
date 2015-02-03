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
 */
trait Socket_Client
{
	protected $socket_client;

	/**
	 * Creates a client side sockets from a server side one
	 *
	 * @param resource $socket Socket created through socket_create
	 * @return self
	 */
	final public function socketAccept($socket = null)
	{
		if (gettype($socket) === 'resource') {
			$this->socket_client = socket_accept($socket);
		} else {
			throw new InvalidArgumentException(__METHOD__ . ' expects $socket to be an instance of resource. ' . gettype($resource) . ' given instead');
		}
		return $this;
	}

	/**
	 * Write to client socket
	 *
	 * @param string $message The message to send
	 * @param int    $length  Optional lenght (defaults to length of $message)
	 * @return self
	 */
	final public function socketWrite($message = '', $length = null)
	{
		if (!is_int($length)) {
			$length = strlen($message);
		}
		socket_write($this->socket_client, "{$message}", $length);
		return $this;
	}
}
