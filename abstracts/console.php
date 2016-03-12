<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Abstracts
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

abstract class Console implements \shgysk8zer0\Core_API\Interfaces\Console
{
	/**
	 * @var string
	 */
	const LOG_FORMAT = '%s : %d';

	/**
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * @var string
	 */
	const HEADER_NAME = 'X-ChromeLogger-Data';

	/**
	 * @var string
	 */
	const BACKTRACE_LEVEL = 'backtrace_level';

	/**
	 * @var string
	 */
	const LOG = 'log';

	/**
	 * @var string
	 */
	const WARN = 'warn';

	/**
	 * @var string
	 */
	const ERROR = 'error';

	/**
	 * @var string
	 */
	const GROUP = 'group';

	/**
	 * @var string
	 */
	const INFO = 'info';

	/**
	 * @var string
	 */
	const GROUP_END = 'groupEnd';

	/**
	 * @var string
	 */
	const GROUP_COLLAPSED = 'groupCollapsed';

	/**
	 * @var string
	 */
	const TABLE = 'table';

	/**
	 * @var string
	 */
	protected $_php_version;

	/**
	 * @var int
	 */
	protected $_timestamp;

	protected $_backtraces = array();

	protected $_processed;

	/**
	 * @var array
	 */
	protected $_json = array(
		'version' => self::VERSION,
		'columns' => array('log', 'backtrace', 'type'),
		'rows' => array()
	);

	/**
	 * @var array
	 */
	protected $_settings = array(
		self::BACKTRACE_LEVEL => 1
	);

	/**
	 * Create new instance and set default properties of class
	 */
	public function __construct()
	{
		$this->_php_version = phpversion();
		$this->_timestamp = version_compare(PHP_VERSION, '5.1.0', '>=')
			? $_SERVER['REQUEST_TIME']
			: time();
		$this->_json['request_uri'] = array_key_exists('REQUEST_URI', $_SERVER)
			? $_SERVER['REQUEST_URI']
			: null;
	}

	/**
	 * [_sendLogHeader description]
	 *
	 * @param void
	 * @return void
	 */
	final public function sendLogHeader() {
		if (! headers_sent()) {
			header(self::HEADER_NAME . ':' . $this->_encodeLogHeader());
		} else {
			//
		}
	}

	/**
	 * [_encodeLogHeader description]
	 *
	 * @param void
	 * @return string [description]
	 */
	final protected function _encodeLogHeader() {
		return base64_encode(utf8_encode(json_encode($this->_json)));
	}
}
