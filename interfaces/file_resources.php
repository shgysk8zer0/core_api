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
namespace shgysk8zer0\Core_API\Interfaces;

/**
 * Interface for filesystem functions. Intended to unify functions between
 * filesystem functions which take a filename and those which use a handle
 * created by fopen.
 */
interface File_Resources
{
	/**
	 *  Write a string to a file
	 *
	 * @param mixed   $data  The data to write. String or single dimension array
	 * @param int     $flags FILE_APPEND... no others have any effect
	 */
	public function filePutContents($data, $flags = FILE_APPEND);

	/**
	 * Reads entire file into a string
	 *
	 * @param int     $offset The offset where the reading starts on the original stream.
	 * @param int     $maxlen Maximum length of data read
	 */
	public function fileGetContents($offset = -1, $maxlen = null);

	/**
	 * Read an entire file parsed as CSV
	 *
	 * @param string $delimiter Sets the field delimiter (1 character only)
	 * @param string $enclosure Sets the field enclosure (1 character only)
	 * @param string $escape    Sets the escape character (1 character only)
	 * @return array            Multi-dimensional indexed array (rows & columns)
	 */
	public function fileGetCSV(
		$delimiter = ',',
		$enclosure = '"',
		$escape = '\\'
	);

	/**
	 * Format line as CSV and write to file
	 *
	 * @param array  $fields      An array of values.
	 * @param string $delimiter   Sets the field delimiter (1 character only)
	 * @param string $enclosure   Sets the field enclosure (1 character only)
	 * @param string $escape_char Sets the escape character (1 character only)
	 */
	public function filePutCSV(
		array $fields,
		$delimiter = ',',
		$enclosure = '"',
		$escape_char = '\\'
	);

	/**
	 * Outputs a file
	 *
	 * @param void
	 * @return int The number of bytes read from the file
	 */
	public function readfile();

	/**
	 * Reads entire file into an array
	 *
	 * @param  int     $flags [FILE_IGNORE_NEW_LINES, FILE_SKIP_EMPTY_LINES]
	 * @return array          Each line of file as an array
	 * @see https://php.net/manual/en/function.file.php
	 * @todo Make handling of FILE_IGNORE_NEW_LINES match original function
	 */
	public function file($flags = 0);

	/**
	 * Gets file size
	 *
	 * @param void
	 * @return int   The size of the file in bytes
	 * @see https://php.net/manual/en/function.filesize.php
	 */
	public function filesize();

	/**
	 * Gets file inode
	 *
	 * @param void
	 * @return int inode number of the file
	 * @see https://php.net/manual/en/function.fileinode.php
	 */
	public function fileinode();

	/**
	 *  Gets last access time of file
	 *
	 * @param void
	 * @return int   The time the file was last accessed
	 */
	public function fileatime();

	/**
	 * Gets inode change time of file
	 *
	 * @param void
	 * @return int The time the file was last changed
	 */
	public function filectime();

	/**
	 * Gets file modification time
	 *
	 * @param void
	 * @return int The time the file was last modified
	 */
	public function filemtime();

	/**
	 * Gets file owner
	 *
	 * @param void
	 * @return int The user ID of the owner of the file
	 */
	public function fileowner();

	/**
	 * Gets file group
	 *
	 * @param void
	 * @return int The group ID of the file
	 */
	public function filegroup();

	/**
	 * Gets file permissions
	 *
	 * @param void
	 * @return int The file's permissions as a numeric mode
	 */
	public function fileperms();
}
