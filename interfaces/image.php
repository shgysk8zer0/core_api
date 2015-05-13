<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Interfaces
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
 * Provides Object-Oriented methods for reading and manipulating images
 * @see https://php.net/manual/en/ref.image.php
 */
interface Image
{
	/**
	 * Get the image width
	 *
	 * @param void
	 * @return int  Width of image in pixels
	 */
	public function imageWidth();

	/**
	 * Get the image height
	 *
	 * @param void
	 * @return int  Hight of image in pixels
	 */
	public function imageHeight();

	/**
	 * Crop an image from $x, $y to $width & $height
	 *
	 * @param  int $x       Starting x coordinate
	 * @param  int $y       Starting y coordinate
	 * @param  int  $width  Ending width in pixels
	 * @param  int  $height Ending height in pixels
	 * @return self
	 */
	public function crop($x = 0, $y = 0, $width = null, $height = null);

	/**
	* Resize an image to an exact width and height
	*
	* @param  int $width  Width in pixels
	* @param  int $height Height in pixels
	* @return self        With $this->_image_handle as resized image
	*/
	public function resizeImage($width = null, $height = null);

	/**
	 * Scale an image by given $factor
	 *
	 * @param float $factor Amount to scale by (0.5 is half, 2 is double, etc.)
	 * @return self
	 * @see https://php.net/manual/en/function.imagescale.php
	 */
	public function scaleImage($factor = 1);

	/**
	 * Rotate an image with a given angle
	 *
	 * @param int     $angle              Rotation angle, in degrees.
	 * @param array   $bgd_color          RGBA array for background color
	 * @param bool    $ignore_transparent Ignore transparent colors?
	 */
	public function rotateImage(
		$angle              = 0,
		array $bgd_color    = array(0, 0, 0, 127),
		$ignore_transparent = false
	);

	/**
	* Output JPEG image to browser or file
	*
	* @param string $filename The path to save the file to. null outputs directly
	* @param int    $quality  Range from 0 - 100
	* @return bool            True on success, false on failure
	* @see https://php.net/manual/en/function.imagejpeg.php
	*/
	public function imageJPEG($filename = null, $quality = 75);

	/**
	* Output GIF image to browser or file
	*
	* @param string $filename The path to save the file to. null outputs directly
	* @return bool            True on success, false on failure
	* @see https://php.net/manual/en/function.imagegif.php
	*/
	public function imageGIF($filename = null);
	/**
	* Output a PNG image to either the browser or a file
	*
	* @param string  $filename The path to save the file to. null outputs directly
	* @param int     $quality  Compression level: from 0 (no compression) to 9.
	* @param int     $filters  Any combination of the PNG_FILTER_XXX constants.
	* @return bool             True on success, false on failure
	*/
	public function imagePNG($filename = null, $quality = -1, $filters = PNG_NO_FILTER);

	/**
	 * Generic save funciton, which converts image according to extension
	 *
	 * @param string $filename Path and extension to save to
	 * @return bool            Success or failure of save
	 */
	public function saveImage($filename);

	/**
	 * Create a DOMElement containing attributes of the image
	 *
	 * @param void
	 * @return DOMElement
	 * @uses DOMDocument
	 */
	public function imageAsDOMElement($as = null);

	/**
	 * Uses imageAsDOMElement and returns it as an HTML string
	 *
	 * @param void
	 * @return string   HTML <img> element
	 */
	public function imageAsString($as = null);

	/**
	 * Converts image to a base64 encoded string
	 *
	 * @param void
	 * @return string   "data:image/*;base64,..."
	 */
	public function dataURI($as = null);

	/**
	 * Calls image* method to get binary image data and returns as string using output buffering
	 *
	 * @param int     $type Optional IMAGETYPE_* constant to convert to
	 * @param bool    $ob   Whether or not to use output buffering (true returns string)
	 * @return mixed        Binary image data if $ob is true, otherwise null
	 */
	public function imageAsBinary($as = null, $ob = true);
}
