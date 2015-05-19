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
namespace shgysk8zer0\Core_API\Traits\Magic;

/**
 * Magic method to convert a DOMDocument or DOMElement to an XML string
 */
trait XML_String
{
	/**
	* Return the document or element as an XML string
	*
	* @param void
	* @return string XML content of document or element
	*/
	final public function __toString()
	{
		if ($this instanceof \DOMDocument) {
			return $this->saveXML();
		} elseif ($this instanceof \DOMElement) {
			return $this->ownerDocument->saveXML($this);
		}
	}
}
