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
	public function filePutContents($data, $flags = 0);
	public function fileGetContents($offset = -1, $maxlen = null);

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
