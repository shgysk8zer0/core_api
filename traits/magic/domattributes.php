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
 * Trait for easily manipulating DOMElement attributes
 * @see https://secure.php.net/manual/en/class.domelement.php
 */
trait DOMAttributes
{
	/**
	 * Creates a new DOMDocument and constructs parent/DOMElement with the tagname
	 * This is should be called when the class is constructed, since a DOMElement
	 * without an ownerDocument cannot be used
	 *
	 * @param  string $tagname The type of element to create
	 * @return void
	 */
	final protected function _createSelf($tagname)
	{
		$dom = new \DOMDocument('1.0', 'UTF-8');
		parent::__construct($tagname);
		$dom->appendChild($this);
	}

	/**
	 * Adds new attribute
	 *
	 * @param string  $name  The name of the attribute.
	 * @param mixed   $value The value of the attribute.
	 * @return void
	 * @see https://secure.php.net/manual/en/domelement.setattribute.php
	 * @example $this->class = 'classname'
	 */
	final public function __set($name, $value)
	{
		$this->setAttribute($name, $value);
	}

	/**
	 * Returns value of attribute
	 *
	 * @param  string $name The name of the attribute.
	 * @return string       The value of the attribute, or an empty string
	 * @see https://secure.php.net/manual/en/domelement.getattribute.php
	 * @example echo $this->glass // Echoes 'classname'
	 */
	final public function __get($name)
	{
		return $this->getAttribute($name);
	}

	/**
	 * Checks to see if attribute exists
	 *
	 * @param  string $name The attribute name.
	 * @return bool         TRUE on success or FALSE on failure.
	 * @see https://secure.php.net/manual/en/domelement.hasattribute.php
	 * @example isset($element->class)
	 */
	final public function __isset($name)
	{
		return $this->hasAttribute($name);
	}

	/**
	 * Removes attribute
	 *
	 * @param string $name The name of the attribute.
	 * @return void
	 * @see https://secure.php.net/manual/en/domelement.removeattribute.php
	 * @example unset($element->class)
	 */
	final public function __unset($name)
	{
		$this->removeAttribute($name);
	}

	/**
	 * Returns the <iframe>'s HTML as a string
	 *
	 * @param void
	 * @return string HTML for the <iframe>
	 * @see https://secure.php.net/manual/en/domdocument.savehtml.php
	 * @example echo $element // Echoes '<iframe src="" ...></iframe>'
	 */
	final public function __toString()
	{
		return $this->ownerDocument->saveHTML($this);
	}
}
