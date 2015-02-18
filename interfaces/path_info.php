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
 * Gets pathinfo about $path, such as direcory and file name, as well
 * as extension and basename (file name + extension). Set protected class
 * variables for each.
 *
 * Also provides individual methods for retrieving each individual component
 * from a path without settings class variables in the process.
 *
 * @see http://php.net/manual/en/function.pathinfo.php
 */
interface Path_Info
{
	/**
	 * Retrieves information about path components
	 *
	 * @param string $path             The path to work with
	 * @param bool   $use_include_path Whether or not to search inclde_path
	 * @return void
	 */
	function getPathInfo($path, $use_include_path = false);

	/**
	 * Returns the extension for the path
	 *
	 * @param string $path Absolute or relative path
	 * @return string      The final extension, without the "."
	 */
	function pathExtension($path = self::absolute_path);

	/**
	 * Returns the directory portion of the path
	 *
	 * @param string  $path Absolute or relative path
	 * @return string The directory portion of the path
	 */
	function pathDirname($path = self::absolute_path);

	/**
	 * Returns the filename of the path
	 *
	 * @param string $path Absolute or relative path
	 * @return sting       Path without directory or final extension
	 */
	function pathFilename($path = self::absolute_path);

	/**
	 * Returns the basename of the path
	 *
	 * @param string $path Absolute or relative path
	 * @return             Path without directory, but with extension.
	 */
	function pathBasename($path = self::absolute_path);
}
