<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core
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
 * Trait to provide quick access to Mime-Type of files
 * @uses \Finfo
 * @see https://php.net/manual/en/ref.fileinfo.php
 */
trait Mime_Type
{
	/**
	 * Finfo gets many types wrong. Provide an array of extensions and MIME-types
	 * for these instances, and only use Finfo if not in this array.
	 *
	 * @var array
	 */
	private $_alt_mime_types = array(
		'js' => 'application/javascript',
		'css' => 'text/css',
		'php' => 'application/x-php',
		'mysql' => 'text/x-sql',
		'svg' => 'image/svg+xml',
		'svgz' => 'image/svg+xml',
		'ogv' => 'video/ogg',
		'webm' => 'video/webm',
		'ogg' => 'audio/ogg',
		'oga' => 'audio/ogg',
		'opus' => 'audio/ogg',
		'flac' => 'audio/flac',
		'm4a' => 'audio/mp4',
		'appcache' => 'text/cache-manifest',
		'woff' => 'application/font-woff',
		'woff2' => 'application/font-woff2',
		'otf' => 'application/x-font-opentype',
		'md' => 'text/x-markdown',
		'mml' => 'application/xhtml+xml'
	);

	/**
	 * Get mime-type from file.
	 * Checks extensions array first, then attempts to get mime-type using Finfo
	 *
	 * @param  string $file Path to file
	 * @return string       Mime-type
	 */
	public function getMimeTypeFromFile($file)
	{
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if (array_key_exists($extension, $this->_alt_mime_types)) {
			return $this->_alt_mime_types[$extension];
		} else {
			return (new \Finfo(FILEINFO_MIME_TYPE))->file($file);
		}
	}
}
