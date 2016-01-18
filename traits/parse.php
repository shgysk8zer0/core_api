<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
 * @version 1.0.0
 * @copyright 2016, Chris Zuber
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
 * Provides methods to parse a file by its MIME type or file extension
 */
trait Parse
{
	/**
	 * Array of [extension => MIME-type]
	 * @var array
	 */
	private $_type_extensions = array(
		'txt' => 'text/plain',
		'csv' => 'text/csv',
		'html' => 'text/html',
		'xml' => 'application/json',
		'json' => 'application/json',
		'svg' => 'image/svg+xml',
		'jpg' => 'image/jpeg',
		'png' => 'image/png',
		'gif' => 'image/gif'
	);

	private $_custom_parsers = array();

	/**
	 * Add a parser for a MIME-type
	 *
	 * @param string   $mime     Type that parser handles
	 * @param Parser   $callback Parser for this type
	 * @return void
	 */
	final public function addParser($mime, API\Interfaces\Parser $parser)
	{
		$this->_custom_parsers[$mime] = $parser;
	}

	/**
	 * Associates an extension with a MIME-type
	 *
	 * @param  string $ext  Extension
	 * @param  string $mime MIME-type
	 * @return void
	 */
	final public function associateExtension($ext, $mime)
	{
		$this->_type_extensions[$ext] = $mime;
	}

	/**
	 * Parse a data: URI
	 *
	 * @param  string $data The data: URI
	 * @return mixed        The parsed data
	 */
	final public function parseDataURI($data)
	{
		// data:$type;$encoding?,$str
		if ($encoding === 'base64') {
			$str = base64_decode($str);
		}

		return $this->parseStringByType($str, $type);
	}

	/**
	 * Parse a string by its MIME-Type
	 *
	 * @param  string $body The string to parse
	 * @param  string $type Its Content-Type/MIME type
	 *
	 * @return mixed        The parsed string
	 */
	final public function parseStringByType($body, $type = 'text/plain')
	{
		try {
			if (! is_string($body)) {
				throw new \Exception(sprintf(
					'%s expects $body to be a string, got a %s.',
					__METHOD__,
					gettype($body)
				));
			}
			if (array_key_exists($type, $this->_custom_parsers)) {
				return call_user_func_array(
					[$this->_custom_parsers[$type], 'parseString'],
					[$body]
				);
			}
			switch (strtolower($type)) {
				case 'text/plain':
					return $body;

				case 'application/json':
					return json_decode($body);

				case 'application/xml':
				case 'image/svg+xml':
					$dom = new \DOMDocument('1.0', 'UTF-8');
					$dom->loadXML($body, 0);
					return $dom;

				case 'text/html':
					$dom = new \DOMDocument('1.0', 'UTF-8');
					$dom->loadHTML($body, 0);
					return $dom;

				// Not sure of INI MIME type
				case 'application/ini':
					return parse_ini_string($body, true);

				case 'application/x-www-form-urlencoded':
					return parse_url("?$body");

				case 'text/csv';
					return array_map('str_getcsv', explode(PHP_EOL, $body));

				case 'image/jpeg':
					// Create JPEG image

				case 'image/png':
					// Create PNG image

				case 'image/gif':
					// Create GIF image

				default:
					// Throw exception
					break;
			}
		} catch (\Exception $e) {
			// Handle exception
		}
	}

	/**
	 * Parse a file by its extension
	 *
	 * @param  string $filename Path of file to parse
	 * @return mixed            Parsed file
	 */
	final public function parseFileByExtension($filename = 'php://input')
	{
		try {
			if (! is_string($filename)) {
				throw new \Exception(sprintf(
					'%s expects $filename to be a string, got a %s.',
					__METHOD__,
					gettype($body)
				));
			} elseif (! file_exists($filename)) {
				throw new \Exception("$filename not found");
			}
			if (array_key_exists($type, $this->_custom_parsers)) {
				return call_user_func_array(
					[$this->_custom_parsers[$type], 'parseFile'],
					[$filename]
				);
			}
			$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			switch ($ext) {
				case 'value':
					# code...
					break;

				default:
					// Get MIME type from ext;
					$type = $this->getTypeFromExtension($filename);
					return $this->parseStringByType(file_get_contents($filename), $type);
					break;
			}
		} catch (\Exception $e) {
			// Handle exception
		}
	}

	/**
	 * Get MIME-type from filename extension
	 *
	 * @param  string $filename File extension
	 * @return string           MIME-type
	 */
	final public function getTypeFromExtension($filename)
	{
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		if (array_key_exists($ext, $this->_type_extensions)) {
			return $this->_type_extensions[$ext];
		} else {
			return (new \Finfo(FILEINFO_MIME_TYPE))->file($filename);
		}
	}

	/**
	 * Get extension from MIME-type
	 *
	 * @param  string $type MIME-type
	 * @return string       Extension for type
	 */
	final public function getExtensionFromType($type)
	{
		if (in_array($type, $this->_type_extensions)) {
			return array_search($type, $this->_type_extensions);
		}
	}
}
