<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
 * @version 1.0.0
 * @link https://developer.github.com/webhooks/
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
 * Provides Object-Oriented methods for reading and manipulating images
 * @see https://php.net/manual/en/ref.image.php
 */
trait Image
{
	/**
	 * Width of image in pixels
	 * @var int
	 */
	protected $_image_width = 0;

	/**
	 * Height of image in pixels
	 * @var int
	 */
	protected $_image_height = 0;

	/**
	 * Image type as an IMAGETYPE_* constant
	 * @var int
	 */
	protected $_image_type;

	/**
	 * Mime-Type of image
	 * @var string
	 */
	protected $_image_mime;

	/**
	 * Width and height of image as HTML attributes
	 * @var string
	 */
	protected $_image_attr = 'width="0" height="0"';

	/**
	 * Handle/resource for image itself
	 * @var resource
	 */
	protected $_image_handle;

	/**
	 * Value for the <img>'s alt attribute
	 * @var string
	 */
	public $alt_text = '';

	/**
	 * Get image attributes and create the handle/resource
	 *
	 * @param string $fname Path to image file
	 */
	final protected function _loadImage($fname)
	{
		$data = getimagesize($fname);
		if (is_array($data)) {
			list(
				$this->_image_width,
				$this->_image_height,
				$this->_image_type,
				$this->_image_attr
			) = $data;

			$this->_image_mime = array_key_exists('mime', $data)
				? $data['mime']
				: image_type_to_mime_type($this->_image_type);

			switch ($this->_image_type) {
				case IMAGETYPE_JPEG:
					$this->_image_handle = imagecreatefromjpeg($fname);
					break;

				case IMAGETYPE_PNG:
					$this->_image_handle = imagecreatefrompng($fname);
					break;

				case IMAGETYPE_GIF:
					$this->_image_handle = imagecreatefromgif($fname);
					break;
				default:
					trigger_error(sprintf('Unsupported file type for "%s"', $fname));
					break;
			}
		}
	}

	/**
	 * Get the image width
	 *
	 * @param void
	 * @return int  Width of image in pixels
	 */
	final public function imageWidth()
	{
		return imagesx($this->_image_handle);
	}

	/**
	 * Get the image height
	 *
	 * @param void
	 * @return int  Hight of image in pixels
	 */
	final public function imageHeight()
	{
		return imagesy($this->_image_handle);
	}

	/**
	 * Crop an image from $x, $y to $width & $height
	 *
	 * @param  int $x       Starting x coordinate
	 * @param  int $y       Starting y coordinate
	 * @param  int  $width  Ending width in pixels
	 * @param  int  $height Ending height in pixels
	 * @return self
	 */
	final public function crop($x = 0, $y = 0, $width = null, $height = null)
	{
		$this->_image_handle = imagecrop(
			$this->_image_handle,
			array_merge(
				array(
					'x' => 0,
					'y' => 0,
					'width' => $this->imageWidth(),
					'height' => $this->imageHeight()
				),
				array_filter(
					array_combine(
						array('x', 'y', 'width', 'height'),
						array($x, $y, $width, $height)
					)
				)
			)
		);

		return $this;
	}

	/**
	* Resize an image to an exact width and height
	*
	* @param  int $width  Width in pixels
	* @param  int $height Height in pixels
	* @return self        With $this->_image_handle as resized image
	*/
	final public function resizeImage($width = null, $height = null)
	{
		if (is_int($width) and is_int($height)) {
			$new_image = imagecreatetruecolor($width, $height);
			imagecopyresampled(
				$new_image,
				$this->_image_handle,
				0,
				0,
				0,
				0,
				$width,
				$height,
				$this->imageWidth(),
				$this->imageHeight()
			);
			if (is_resource($new_image)) {
				$this->_image_handle = $new_image;
			}
		}
		return $this;
	}

	/**
	 * Scale an image by given $factor
	 *
	 * @param float $factor Amount to scale by (0.5 is half, 2 is double, etc.)
	 * @return self
	 * @see https://php.net/manual/en/function.imagescale.php
	 */
	final public function scaleImage($factor = 1)
	{
		// Scaling by a factor of 1 produces no changes, so do not scale if it is 1
		if (is_numeric($factor) and $factor !== 1) {
			$new_width  = round(abs($factor * $this->imageWidth()));
			$new_height = round(abs($factor * $this->imageHeight()));
			$this->_image_handle = imagescale($this->_image_handle, $new_width, $new_height);
		}

		return $this;
	}

	/**
	 * Rotate an image with a given angle
	 *
	 * @param int     $angle              Rotation angle, in degrees.
	 * @param array   $bgd_color          RGBA array for background color
	 * @param bool    $ignore_transparent Ignore transparent colors?
	 */
	final public function rotateImage(
		$angle              = 0,
		array $bgd_color    = array(255, 0, 0, 0),
		$ignore_transparent = false
	)
	{
		$this->_image_handle = imagerotate(
			$this->_image_handle,
			$angle,
			$this->_createImageColorAlpha($bgd_color),
			$ignore_transparent ? 1 : 0
		);
	}

	/**
	 * Allocate a color for an image
	 *
	 * @param array $rgba RGBA array for color
	 * @return int        A color identifier or FALSE if the allocation failed.
	 * @see https://php.net/manual/en/function.imagecolorallocatealpha.php
	 */
	final protected function _createImageColorAlpha(array $rgba = array())
	{
		$keys = array('r', 'g', 'b', 'a');
		$rgba = array_filter($rgba, 'is_int');
		$rgba = array_map('abs', $rgba);
		$rgba = array_pad($rgba, count($keys), 0);
		$rgba = array_slice($rgba, 0, count($keys));
		$rgba = array_combine($keys, $rgba);

		extract($rgba);

		return imagecolorallocatealpha(
			$this->_image_handle,
			min($r, 255),
			min($g, 255),
			min($b, 255),
			min($a, 127)
		);
	}

	/**
	* Output JPEG image to browser or file
	*
	* @param string $filename The path to save the file to. null outputs directly
	* @param int    $quality  Range from 0 - 100
	* @return bool            True on success, false on failure
	* @see https://php.net/manual/en/function.imagejpeg.php
	*/
	final public function imageJPEG($filename = null, $quality = 75)
	{
		return imagejpeg($this->_image_handle, $filename, $quality);
	}

	/**
	* Output GIF image to browser or file
	*
	* @param string $filename The path to save the file to. null outputs directly
	* @return bool            True on success, false on failure
	* @see https://php.net/manual/en/function.imagegif.php
	*/
	final public function imageGIF($filename = null)
	{
		return imagegif($this->_image_handle, $filename);
	}

	/**
	* Output a PNG image to either the browser or a file
	*
	* @param string  $filename The path to save the file to. null outputs directly
	* @param int     $quality  Compression level: from 0 (no compression) to 9.
	* @param int     $filters  Any combination of the PNG_FILTER_XXX constants.
	* @return bool             True on success, false on failure
	*/
	final public function imagePNG($filename = null, $quality = -1, $filters = PNG_NO_FILTER)
	{
		return imagepng($this->_image_handle, $filename, $quality, $filters);
	}

	final public function saveImage($filename)
	{
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if (! is_string($extension)) {
			$extension = image_type_to_extension($this->_image_type);
			$filename .= ".{$extension}";
		}

		switch(strtolower($extension))
		{
			case 'jpeg':
			case 'jpg':
				return $this->imageJPEG($filename);
				break;

			case 'png':
				return $this->imagePNG($filename);
				break;

			case 'gif':
				return $this->imageGIF($filename);

			default:
				trigger_error('Invalid extension or not an image', E_USER_WARNING);
				return false;
		}
	}

	/**
	 * Create a DOMElement containing attributes of the image
	 *
	 * @param void
	 * @return DOMElement
	 * @uses DOMDocument
	 */
	final public function imageAsDOMElement($as = null)
	{
		$dom   = new \DOMDocument('1.0', 'UTF-8');
		$image = $dom->appendChild($dom->createElement('img'));
		$image->setAttribute('height', $this->imageHeight());
		$image->setAttribute('width', $this->imageWidth());
		$image->setAttribute('alt', $this->alt_text);
		$image->setAttribute('src', $this->dataURI($as));
		return $image;
	}

	/**
	 * Uses imageAsDOMElement and returns it as an HTML string
	 *
	 * @param void
	 * @return string   HTML <img> element
	 */
	final public function imageAsString($as = null)
	{
		$image = $this->imageAsDOMElement($as);
		return $image->ownerDocument->saveHTML($image);
	}

	/**
	 * Converts image to a base64 encoded string
	 *
	 * @param void
	 * @return string   "data:image/*;base64,..."
	 */
	final public function dataURI($as = null)
	{
		$mime = is_int($as) ? image_type_to_mime_type($as) : $this->_image_mime;
		return 'data:' . $mime . ';base64,' . base64_encode($this->imageAsBinary($as));
	}

	/**
	 * Calls image* method to get binary image data and returns as string using output buffering
	 *
	 * @param int     $type Optional IMAGETYPE_* constant to convert to
	 * @param bool    $ob   Whether or not to use output buffering (true returns string)
	 * @return mixed        Binary image data if $ob is true, otherwise null
	 */
	final public function imageAsBinary($as = null, $ob = true)
	{
		if ($ob) {
			ob_start();
		}
		switch (is_int($as) ? $as : $this->_image_type) {
			case IMAGETYPE_JPEG:
				$this->imageJPEG();
				break;

			case IMAGETYPE_GIF:
				$this->imageGIF();
				break;

			case IMAGETYPE_PNG:
				$this->imagePNG();
				break;
		}
		if ($ob) {
			return ob_get_clean();
		}
	}
}
