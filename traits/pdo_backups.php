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
 * Provides methods to backup and restore MySQL databases.
 */
trait PDO_Backups
{
	/**
	 * Do a mysqldump, either to a file or returning the string.
	 * If $fname is a string, dumps to a file by that name and returns success
	 * (true/false) or that dump. Otherwise, returns a string containing the
	 * mysqldump data.
	 *
	 * @param  string $fname Optional name of file to dump to
	 * @return mixed         bool if $fname is string, string if $fname is null
	 */
	final public function dump($fname = null)
	{
		$output = [];
		$return_var = 1;
		if (is_string($fname)) {
			if ($this->pathExtension($fname) === '') {
				$fname .= '.sql';
			}

			if($this->pathDirname($fname) === '.') {
				$fname = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $fname;
			}
		}

		$command = 'mysqldump -u ' . escapeshellarg($this->user);
		if (is_string($this->host)) {
			$command .= ' -h ' . escapeshellarg($this->host);
		}
		$command .= ' -p' . escapeshellarg($this->password);
		$command .= ' ' . escapeshellarg($this->database);

		exec($command, $output, $return_var);

		if ($return_var === 0 and is_array($output) and !empty($output)) {
			if (is_string($fname)) {
				return @file_put_contents($fname, join(PHP_EOL, $output), LOCK_EX);
			}
			return join(PHP_EOL, $output);
		}

		return false;
	}

	/**
	 * Restore a file from a mysqldump
	 *
	 * @param  string $fname Name of file, defaults to database name
	 * @return bool
	 */
	final public function restore($fname = null)
	{
		if (is_null($fname)) {
			$fname = $this->database;
		}
		if ($this->pathExtension($fname) === '') {
			$fname .= '.sql';
		}
		if ($this->pathDirname($fname) === '.') {
			$fname = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $fname;
		}

		if (@file_exists($fname) and $sql = @file_get_contents($fname)) {
			return ($this->exec($sql) > 0);
		}
		return false;
	}
}
