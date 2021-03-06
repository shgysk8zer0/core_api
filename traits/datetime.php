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
 * Provides several useful methods for classes extending \DateTime
 */
trait DateTime
{
	/**
	 * Format to use when using __toString
	 * @var string
	 */
	public $format = self::W3C;

	/**
	 * Called when class is used as a string and returns date formated as string
	 *
	 * @return string
	 */
	final public function __toString()
	{
		return $this->format($this->format);
	}

	/**
	 * Attempts to get timezone with fallback to default, which in turn defaults to UTC
	 *
	 * @param mixed $timezone   Most likely a string or null, but could be a DateTimeZone
	 * @return DateTimeZone
	 */
	final protected function _getTimeZone($timezone = null)
	{
		if ($timezone = strtoupper($timezone) and defined("\\DateTimeZone::{$timezone}")) {
			$timezone = new \DateTimeZone($timezone);
		} elseif (! ($timezone instanceof \DateTimeZone)) {
			@date_default_timezone_set(date_default_timezone_get());
			$timezone = new \DateTimeZone(date_default_timezone_get());
		}
		return $timezone;
	}
}
