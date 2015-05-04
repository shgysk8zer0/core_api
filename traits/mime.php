<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
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
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace shgysk8zer0\Core_API\Traits;
/**
 * Provides Mime-type method(s)?
 * @uses Finfo
 */
trait Mime
{
	/**
	 * Get mime-type from extension or finfo()
	 *
	 * First, try go through a list of unrecognized extensions.
	 * If not one of those, use the default finfo() method
	 *
	 * @param  string $file  Path to some file
	 * @return string        File's mime-type, either from Finfo::file or extension
	 */
	protected function _typeByExtension($file)
	{
		switch(strtolower(pathinfo($file, PATHINFO_EXTENSION))) {
			case 'svg':
			case 'svgz':
				return 'image/svg+xml';
				break;

			case 'woff':
				return 'application/font-woff';
				break;

			case 'otf':
				return 'application/x-font-opentype';
				break;

			case 'sql':
				return 'text/x-sql';
				break;

			case 'appcache':
				return 'text/cache-manifest';
				break;

			case 'mml':
				return 'application/xhtml+xml';
				break;

			case 'ogv':
				return 'video/ogg';
				break;

			case 'webm':
				return 'video/webm';
				break;

			case 'ogg':
			case 'oga':
			case 'opus':
				return 'audio/ogg';
				break;

			case 'flac':
				return 'audio/flac';
				break;

			case 'm4a':
				return 'audio/mp4';
				break;

			case 'css':
			case 'cssz':
				return 'text/css';
				break;

			case 'js':
			case 'jsz':
				return 'text/javascript';
				break;

			default:		//If not found, try the file's default
				return preg_replace('/\;.*$/', null, (new \Finfo(FILEINFO_MIME))->file($file));
		}
	}
}
