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
 * Standard class trait for reading and writing to/from files.
 * Unlike the abstract class, this does not use file handles, so reading and
 * writing goes along with opening and closing of the resource. For extensive
 * reads/writes, extending the abstract class will result in better performance.
 */
trait File_IO
{
	protected $fileName;
	/**
	 * Opens the file in the specified mode designating read, write, create
	 * capabilities. Obtains exclusive lock on file if $lock is true.
	 *
	 * @param string $filename Name/path of file to be working with
	 * @param string $mode     Specifies mode (read, write, create, etc)
	 * @param bool   $lock     Whether or not to obtain an excludive lock on file
	 */
	public function openFile($filename)
	{
		$this->fileName = $filename;
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
		file_put_contents(
			$this->fileName,
			($addNL) ? $content . PHP_EOL : $content,
			FILE_APPEND | LOCK_EX
		);
	}

	/**
	 * Read the content of the file and return content as string.
	 *
	 * @param void
	 * @return string
	 */
	public function readFile()
	{
		return file_get_contents($this->fileName);
	}

	/**
	 * Get information about the file
	 * @param string $prop Specific property to retrieve
	 * @return mixed Array if $prop is null, string or int otherwise
	 */
	public function fileInfo($prop = null)
	{
		return (is_string($prop))
			? stat($this->fileName)[$prop]
			: stat($this->fileName);
	}
}
