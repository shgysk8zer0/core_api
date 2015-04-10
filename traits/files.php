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
 * Interface for filesystem functions. Intended to unify functions between
 * filesystem functions which take a filename and those which use a handle
 * created by fopen.
 */
trait Files
{
	/**
	 * Keep $filename as a string
	 * @var string
	 */
	protected $_fhandle = null;

	/**
	 * Whether or not to request a lock on the file
	 * @var bool
	 */
	protected $flocked = false;

	/**
	 * Whether or not to use include_path when working with file
	 * @var bool
	 */
	protected $use_include_path = false;

	/**
	 * "Opens" file. Only sets $filename & $use_include_path
	 *
	 * @param  string $filename Name of file
	 * @return bool            [description]
	 */
	final protected function fopen($filename = 'php://temp', $use_include_path = false)
	{

		$this->_fhandle = $filename;
		$this->use_include_path = $use_include_path;
		return $this;
	}

	/**
	 * "Closes" file. Only resets class variables
	 * @return [type] [description]
	 */
	final protected function fclose()
	{
		$this->_fhandle = null;
		$this->flocked = false;
		$this->use_include_path = false;
	}

	/**
	 * Portable advisory file locking
	 *
	 * @param  int    $operation  Type of lock (LOCK_SH, LOCK_EX, or LOCK_UN)
	 * @return self
	 * @see https://php.net/manual/en/function.flock.php
	 */
	final protected function flock($operation = LOCK_EX)
	{
		if ($operation === LOCK_EX or $operation == LOCK_SH) {
			$this->flocked = true;
		} else {
			$this->flocked = false;
		}
	}

	/**
	 *  Write a string to a file
	 *
	 * @param mixed   $data  The data to write. String or single dimension array
	 * @param int     $flags FILE_APPEND... no others have any effect
	 */
	public function filePutContents($data, $flags = FILE_APPEND)
	{
		if ($this->flocked) {
			$flags |= LOCK_EX;
		} else {
			$flags &= ~LOCK_EX;
		}
		if ($this->use_include_path) {
			$flags |= FILE_USE_INCLUDE_PATH;
		} else {
			$flags &= ~FILE_USE_INCLUDE_PATH;
		}
		file_put_contents($this->_fhandle, $data, $flags);
	}


	/**
	 * Reads entire file into a string
	 *
	 * @param int     $offset The offset where the reading starts on the original stream.
	 * @param int     $maxlen Maximum length of data read
	 */
	public function fileGetContents($offset = -1, $maxlen = null)
	{
		return is_int($maxlen) ? file_get_contents(
			$this->_fhandle,
			$this->use_include_path,
			null,
			$offset,
			$maxlen
		) : file_get_contents(
			$this->_fhandle,
			$this->use_include_path,
			null,
			$offset
		);
	}

	/**
	 * Format line as CSV and write to file
	 *
	 * @param array  $fields      An array of values.
	 * @param string $delimiter   Sets the field delimiter (1 character only)
	 * @param string $enclosure   Sets the field enclosure (1 character only)
	 * @param string $escape_char Sets the escape character (1 character only)
	 */
	final public function filePutCSV(
		array $fields,
		$delimiter = ',',
		$enclosure = '"',
		$escape_char = '\\'
	)
	{
		if (strlen($delimiter) !== 1) {
			trigger_error(
				sprintf('%s: delimiter must be a single character', __FUNCTION__)
			);
		}
		if (strlen($enclosure) !== 1) {
			trigger_error(
				sprintf('%s: enclosure must be a single character', __FUNCTION__)
			);
		}
		if (strlen($escape_char) !== 1) {
			trigger_error(
				sprintf('%s: escape_char must be a single character', __FUNCTION__)
			);
		}
		array_walk(
			$fields,
			function(&$col) use ($delimiter, $enclosure, $escape_char)
			{
				if (
					strpbrk($col,"{$enclosure}{$delimiter}\t\r\n\f ") !== false
				) {
					$col = str_replace($enclosure, $enclosure. $enclosure, $col);
					$col = $enclosure . $col . $enclosure;
				}
			}
		);
		$this->filePutContents(join($delimiter, $fields) . PHP_EOL);
	}

	/**
	 * Read an entire file parsed as CSV
	 *
	 * @param string $delimiter Sets the field delimiter (1 character only)
	 * @param string $enclosure Sets the field enclosure (1 character only)
	 * @param string $escape    Sets the escape character (1 character only)
	 * @return array            Multi-dimensional indexed array (rows & columns)
	 */
	final public function fileGetCSV(
		$delimiter = ',',
		$enclosure = '"',
		$escape = '\\'
	)
	{
		if (strlen($delimiter) !== 1) {
			trigger_error(
				sprintf('%s: delimiter must be a single character', __FUNCTION__)
			);
		}
		if (strlen($enclosure) !== 1) {
			trigger_error(
				sprintf('%s: enclosure must be a single character', __FUNCTION__)
			);
		}
		if (strlen($escape) !== 1) {
			trigger_error(
				sprintf('%s: escape must be a single character', __FUNCTION__)
			);
		}
		return array_map(
			function($line) use ($delimiter, $enclosure, $escape)
			{
				return str_getcsv($line, $delimiter, $enclosure, $escape);
			},
			$this->file(FILE_IGNORE_NEW_LINES)
		);
	}

	/**
	 * Outputs a file
	 *
	 * @param void
	 * @return int The number of bytes read from the file
	 */
	public function readfile()
	{
		return readfile($this->_fhandle, $this->use_include_path);
	}

	/**
	 * Reads entire file into an array
	 *
	 * @param  int     $flags [FILE_IGNORE_NEW_LINES, FILE_SKIP_EMPTY_LINES]
	 * @return array          Each line of file as an array
	 * @see https://php.net/manual/en/function.file.php
	 * @todo Make handling of FILE_IGNORE_NEW_LINES match original function
	 */
	public function file($flags = 0)
	{
		if ($this->use_include_path) {
			$flags |= FILE_USE_INCLUDE_PATH;
		} else {
			$flags &= ~FILE_USE_INCLUDE_PATH;
		}
		return file($this->_fhandle, $flags);
	}

	/**
	 * Gets file size
	 *
	 * @param void
	 * @return int   The size of the file in bytes
	 * @see https://php.net/manual/en/function.filesize.php
	 */
	public function filesize()
	{
		if ($this->use_include_path) {
			return filesize(stream_resolve_include_path($this->_fhandle));
		} else {
			return filesize($this->_fhandle);
		}
	}

	/**
	 * Gets file inode
	 *
	 * @param void
	 * @return int inode number of the file
	 * @see https://php.net/manual/en/function.fileinode.php
	 */
	public function fileinode()
	{
		if ($this->use_include_path) {
			return fileinode(stream_resolve_include_path($this->_fhandle));
		} else {
			return fileinode($this->_fhandle);
		}
	}

	/**
	 *  Gets last access time of file
	 *
	 * @param void
	 * @return int   The time the file was last accessed
	 */
	public function fileatime()
	{
		if ($this->use_include_path) {
			return fileatime(stream_resolve_include_path($this->_fhandle));
		} else {
			return fileatime($this->_fhandle);
		}
	}

	/**
	 * Gets inode change time of file
	 *
	 * @param void
	 * @return int The time the file was last changed
	 */
	public function filectime()
	{
		if ($this->use_include_path) {
			return filectime(stream_resolve_include_path($this->_fhandle));
		} else {
			return filectime($this->_fhandle);
		}
	}

	/**
	 * Gets file modification time
	 *
	 * @param void
	 * @return int The time the file was last modified
	 */
	public function filemtime()
	{
		if ($this->use_include_path) {
			return filemtime(stream_resolve_include_path($this->_fhandle));
		} else {
			return filemtime($this->_fhandle);
		}
	}

	/**
	 * Gets file owner
	 *
	 * @param void
	 * @return int The user ID of the owner of the file
	 */
	public function fileowner()
	{
		if ($this->use_include_path) {
			return fileowner(stream_resolve_include_path($this->_fhandle));
		} else {
			return fileowner($this->_fhandle);
		}
	}

	/**
	 * Gets file group
	 *
	 * @param void
	 * @return int The group ID of the file
	 */
	public function filegroup()
	{
		if ($this->use_include_path) {
			return filegroup(stream_resolve_include_path($this->_fhandle));
		} else {
			return filegroup($this->_fhandle);
		}
	}

	/**
	 * Gets file permissions
	 *
	 * @param void
	 * @return int The file's permissions as a numeric mode
	 */
	public function fileperms()
	{
		if ($this->use_include_path) {
			return fileperms(stream_resolve_include_path($this->_fhandle));
		} else {
			return fileperms($this->_fhandle);
		}
	}
}
