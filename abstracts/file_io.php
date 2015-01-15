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
/**
 * Standard class for reading and writing to/from files.
 * Extend this abstract class and `openFile` with the file to work with.
 * Note: $mode is set to allow reading and writing, as well as creating if file
 * does not exist, beginning with the cursor at the end of the file. Changing
 * $mode from default may reduce functionality.
 * @see http://php.net/manual/en/ref.filesystem.php
 */
abstract class File_IO implements API\Interfaces\File_IO
{
	const FILE_MODE = 'a+';
	protected $fileResource;

	/**
	 * Opens the file in the specified mode designating read, write, create
	 * capabilities. Obtains exclusive lock on file, which is released when class
	 * is destroyed.
	 *
	 * @param string $filename Name/path of file to be working with
	 * @return bool  Whether or not lock was able to be obtained.
	 */
	final public function openFile($filename)
	{
		$this->fileResource = fopen($filename, self::FILE_MODE);
		return flock($this->fileResource, LOCK_EX);
	}

	/**
	 * Write $content to file, optionally inserting a trailing newline
	 *
	 * @param string $content The string to write to the file
	 * @param bool   $addNL   Whether or not to append a newline after $content
	 * @return void
	 */
	public function writeFile($content, $addNL = true)
	{
		fwrite($this->fileResource, $content);
		if ($addNL) {
			fwrite($this->fileResource, PHP_EOL);
		}
	}

	/**
	 * Read the content of the file and return content as string.
	 *
	 * @param void
	 * @return string
	 */
	public function readFile()
	{
		rewind($this->fileResource);
		return fread($this->fileResource, $this->fileInfo('size'));
	}

	/**
	 * Get information about the file
	 * @param string $prop Specific property to retrieve
	 * @return mixed Array if $prop is null, string or int otherwise
	 */
	public function fileInfo($prop = null)
	{
		return (is_string($prop))
			? fstat($this->fileResource)[$prop]
			: fstat($this->fileResource);
	}

	/**
	 * When class is destroyed, make sure to close file and release lock.
	 * To prevent extending classes of overwriting this method, it MUST be final
	 * in order to ensure that the lock on file is released.
	 *
	 * @param void
	 * @return string
	 */
	final public function __destruct()
	{
		flock($this->fileResource, LOCK_UN);
		fclose($this->fileResource);
	}
}
