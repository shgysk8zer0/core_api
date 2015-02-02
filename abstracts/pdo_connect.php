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
namespace shgysk8zer0\Core_API\Abstracts;

use \shgysk8zer0\Core_API as API;
use API\Abstracts\Exception_Codes as Exception_Codes;

/**
 * Provides method to connect to database using a variety of paramater types.
 * Strings are understood to be filenames, and files are parsed for credentials.
 * Associative Arrays and Obects are also used for credentials.
 * @see http://php.net/manual/en/book.pdo.php
 */
class PDO_Connect extends \PDO
{
	use API\Traits\Parser;
	use API\Traits\Logger;
	use API\Traits\Default_Log_Method;

	/**
	 * Whether or not connetion was successful
	 * @var bool
	 */
	public $connected = false;

	/**
	 * Data Source Name contains the information required to connect to the database.
	 * @var string
	 */
	protected $dsn;

	/**
	 * The user name for the DSN string
	 * @var string
	 */
	protected $user;

	/**
	 * The password for the DSN string
	 * @var string
	 */
	protected $database;

	/**
	 * The password for the DSN string
	 * @var string
	 */
	protected $password;

	/**
	 * The host/server for the DSN string
	 * @var string
	 */
	protected $host;

	/**
	 * The port for the DSN string
	 * @var int
	 */
	protected $port;

	const DEFAULT_CON = 'connect.json';
	const DEFAULT_HOST = 'localhost';
	const DEFAULT_PORT = 3306;
	const DEFAULT_TYPE = 'mysql';
	const DEFAULT_EXTENSION = 'json';

	/**
	 * Creates a PDO instance representing a connection to a database
	 *
	 * @param  mixed  $con     String (filename), object, or array for credentials
	 * @param  array  $options A key=>value array of driver-specific connection options.
	 * @return void
	 */
	final protected function connect($con, array $options = array())
	{
		if (is_null($con)) {
			$con = $this::DEFAULT_CON;
		}
		if (is_string($con)) {
			if (! pathinfo($con, PATHINFO_EXTENSION)) {
				$con .= '.' . $this::DEFAULT_EXTENSION;
			}
			$con = $this->parse($con);
		} elseif (is_array($con)) {
			$con = (object)$con;
		}
		if (!is_object($con) or !(isset($con->user) and isset($con->password))) {
			throw new \DomainException('PDO requires at least a user and password');
		}
		$this->user = $con->user;
		$this->password = $con->password;
		$this->type = (isset($con->type)) ? $con->type : $this::DEFAULT_TYPE;
		$this->database = (isset($con->database)) ? $con->database : $this->user;
		$this->port = (isset($con->port) and $con->port !== $this::DEFAULT_PORT) ? $con->port : null;
		$this->host = (isset($con->host) and $con->host !== $this::DEFAULT_HOST) ? $con->host : null;
		$this->dsn = "{$this->type}:dbname={$this->database}";

		if (
			is_string($this->host) and (
				filter_var($this->host, FILTER_VALIDATE_IP)
				or filter_var("http://{$this->host}", FILTER_VALIDATE_URL)
			)
		) {
			$this->dsn .= ";host={$this->host}";
		}

		if (is_int($this->port)) {
			$this->dsn .= ";port={$this->port}";
		}

		try {
			parent::__construct($this->dsn, $this->user, $this->password, $options);
			$this->connected = true;
		} catch(\PDOException $e) {
			echo $e . PHP_EOL;
		}
	}
}
