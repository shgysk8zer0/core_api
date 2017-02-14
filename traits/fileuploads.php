<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
 * @version 1.0.0
 * @copyright 2017, Chris Zuber
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

use \shgysk8zer0\Core_API\Abstracts\HTTPStatusCodes as HTTP;

/**
 * Traits to validate and normalize file uploads
 */
trait FileUploads
{
	/**
	 * Get `$_FILES` as a normalized array
	 * @return Array $_FILES[$key][0]...
	 */
	final public static function normalizeUploads(): Array
	{
		$files = [];

		foreach($_FILES as $name => $value) {
			$file_post = $_FILES[$name];
			if (
				array_key_exists('name', $file_post)
				and is_array($file_post['name'])
			) {
				$file_count = count($file_post['name']);
				$file_keys = array_keys($file_post);

				for ($i = 0; $i < $file_count; $i++) {
					foreach ($file_keys as $key) {
						$files[$name][$i][$key] = $file_post[$key][$i];
					}
				}
			} else {
				$files[$name] = [$value];
			}
		}

		return $files;
	}

	/**
	 * Verifies that $file is a valid upload file and of an allowed type
	 * If there is an error with the file, an exception is thrown with a description
	 * of the problem and a fitting HTTP status code as the exception code
	 * @param  Array $file          Uploaded file (from $_FILES) as an array
	 * @param  Array $allowed_types Array of allowed Mime-types ['image/jpeg', 'text/plain', ...]
	 * @return Bool                 Whether or not $file is a valid upload of an allowed type
	 */
	final public static function isValidUpload(
		Array  $file,
		Array  $allowed_types
	): Bool
	{
		try {
			if (!static::_hasFileKeys($file)) {
				throw new \InvalidArgumentException('Invalid file upload', HTTP::INTERNAL_SERVER_ERROR);
			} elseif ($file['error'] !== UPLOAD_ERR_OK) {
				switch($file['error']) {
					case UPLOAD_ERR_NO_FILE:
						throw new \RuntimeException('No file sent', HTTP::BAD_REQUEST);
						break;

					case UPLOAD_ERR_INI_SIZE:
						throw new \InvalidArgumentException("{$file['name']} exceeds max upload size", HTTP::PAYLOAD_TOO_LARGE);
						break;

					case UPLOAD_ERR_FORM_SIZE:
						throw new \InvalidArgumentException("{$file['name']} exceeds max upload size set by form", HTTP::PAYLOAD_TOO_LARGE);
						break;

					case UPLOAD_ERR_PARTIAL:
						throw new \RuntimeException("{$file['name']} has only been partially uploaded", HTTP::INTERNAL_SERVER_ERROR);
						break;

					case UPLOAD_ERR_NO_TMP_DIR:
						throw new \RuntimeException('Missing tmp directory for uploads', HTTP::INTERNAL_SERVER_ERROR);
						break;

					case UPLOAD_ERR_CANT_WRITE:
						throw new \RuntimeException('Failed to save upload to tmp directory', HTTP::INTERNAL_SERVER_ERROR);
						break;

					case UPLOAD_ERR_EXTENSION:
						throw new \RuntimeException('A PHP extension stopped the file upload', HTTP::INTERNAL_SERVER_ERROR);
						break;

					default:
						throw new \RuntimeException("An unknown error occured handling upload of {$file['name']}", HTTP::INTERNAL_SERVER_ERROR);
				}
			} elseif (! is_uploaded_file($file['tmp_name'])) {
				throw new \InvalidArgumentException("{$file['name']} is not a valid file upload", HTTP::INTERNAL_SERVER_ERROR);
			} elseif (! in_array($file['type'], $allowed_types)) {
				throw new \InvalidArgumentException("{$file['name']} is an allowed file type", HTTP::UNSUPPORTED_MEDIA_TYPE);
			} elseif ($file['size'] !== filesize($file['tmp_name'])) {
				throw new \InvalidArgumentException("Filesize conflict on upload: {$file['name']}", HTTP::BAD_REQUEST);
			} else {
				return true;
			}
		} catch (\Throwable $e) {
			trigger_error($e);
			$status = $e->getCode();
			if ($status > 399 and $status < 600) {
				http_response_code($status);
			} else {
				http_response_code(500);
			}
			return false;
		}
	}

	/**
	 * Verifies that an array has all keys expected of a file upload
	 * @param  Array $file Array, such as from `$_FILES` to validate
	 * @return Bool  If $file has all array keys expected of an upload
	 */
	final private static function _hasFileKeys(Array $file): Bool
	{
		$valid = true;
		foreach(['error', 'tmp_name', 'type', 'size', 'name'] as $key) {
			if (! array_key_exists($key, $file)) {
				$valid = false;
				break;
			}
		}
		return $valid;
	}
}
