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
 * Gets pathinfo about $path, such as direcory and file name, as well
 * as extension and basename (file name + extension). Set protected class
 * variables for each.
 *
 * Also provides individual methods for retrieving each individual component
 * from a path without settings class variables in the process.
 *
 * @see http://php.net/manual/en/function.pathinfo.php
 */
trait Path_Info
{
	/**
	 * Full directory path (/path/to)
	 *
	 * @var string
	 */
	protected $dirname;

	/**
	 * Filename without directory, but with extension
	 *
	 * @var string
	 */
	protected $basename;

	/**
	 * Extension for file. If multiple extensions, this is the last one.
	 * E.G. /path/to/file.tar.gz, this woud be "gz"
	 *
	 * @var string
	 */
	protected $extension;

	/**
	 * Filename without directory or extension. If multiple extensions, this will
	 * include all but the last. E.G /path/to/file.tar.gz this would be "file.tar"
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Full, absolute path to file, including dirname & basename.
	 *
	 * @var string
	 */
	protected $absolute_path;

	/**
	 * Retrieves information about path components
	 *
	 * @param string $path             The path to work with
	 * @param bool   $use_include_path Whether or not to search inclde_path
	 * @return void
	 */
	final public function getPathInfo($path, $use_include_path = false)
	{
		if ($use_include_path) {
			$path = stream_resolve_include_path($path);
		} else {
			$path = realpath($path);
		}

		if (is_string($path)) {
			list(
				$this->dirname,
				$this->basename,
				$this->extension,
				$this->filename
			) = array_values(pathinfo($path));

			$this->absolute_path = $this->dirname . DIRECTORY_SEPARATOR . $this->basename;
		}
	}

	/**
	 * Returns the extension for the path
	 *
	 * @param string $path Absolute or relative path
	 * @return string      The final extension, without the "."
	 */
	final public function pathExtension($path = self::absolute_path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}

	/**
	 * Returns the directory portion of the path
	 *
	 * @param string  $path Absolute or relative path
	 * @return string The directory portion of the path
	 */
	final public function pathDirname($path = self::absolute_path)
	{
		return pathinfo($path, PATHINFO_DIRNAME);
	}

	/**
	 * Returns the filename of the path
	 *
	 * @param string $path Absolute or relative path
	 * @return sting       Path without directory or final extension
	 */
	final public function pathFilename($path = self::absolute_path)
	{
		return pathinfo($path, PATHINFO_FILENAME);
	}

	/**
	 * Returns the basename of the path
	 *
	 * @param string $path Absolute or relative path
	 * @return             Path without directory, but with extension.
	 */
	final public function pathBasename($path = self::absolute_path)
	{
		return pathinfo($path, PATHINFO_BASENAME);
	}
}
