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

/**
 * Standardized parser. Automatically detects file extension and parses file's
 * constents accordingly.
 *
 * Currently works with JSON, XML, INI, and to a limited extent, CSV.
 *
 * @todo Improve parsing of CSV to create associative instead of indexed arrays
 */
abstract class Parser extends File_IO
{
	/**
	 * Reads and parses file contents
	 *
	 * @param  string $file The name of file to parse.
	 * @return mixed        The parsed data from file contents
	 */
	public function parse($file)
	{
		$this->openFile($file);

		switch (strtolower($this->extension)) {
			case 'json':
			return json_decode($this->readFile());
			case 'ini':
			return (object)parse_ini_string($this->readFile(), true);
			case 'xml':
			return simplexml_load_string($this->readFile());
			case 'csv':
			return array_map(
				'str_getcsv',
				explode(PHP_EOL, trim($this->readFile()))
			);
			default:
				throw new \InvalidArgumentException(
					"{$this->extension} is not a supported extension."
				);
		}
	}
}
