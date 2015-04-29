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
 * Provides magic methods to \DOMDocument... Make sure to extend it
 * @see https://php.net/manual/en/class.domdocument.php
 */
trait DOMDocument
{
	/**
	 * Magic alias of appendChild + createElement
	 *
	 * @param string $name  The tag name of the element.
	 * @param string $value The value of the element.
	 * @see https://php.net/manual/en/domdocument.createelement.php
	 */
	final public function __set($name, $value)
	{
		if (property_exists($this, 'body')) {
			$node = $this->body->appendChild($this->createElement($name));
			if (is_string($value)) {
				$node->appendChild($this->createTextNode($value));
			} elseif (is_object($value) and $value instanceof \DOMNode) {
				$node->appendChild($value);
			} elseif (is_array($value) or is_object($value) and $value = get_object_vars($value)) {
				array_map(
					function($tag, $content) use (&$node)
					{
						if (substr($tag, 0, 1) === '@') {
							$node->setAttribiute(substr($tag, 1), $content);
						} elseif (is_string($content)) {
							$node->appendChild($this->createElement($tag, $content));
						}
					},
					array_keys($value),
					array_values($value)
				);
			} elseif (isset($value)) {
				trigger_error(
					sprintf(
						'%s expects paramater 2 to be either a string or node, %s given',
						__METHOD__,
						gettype($value)
					),
					E_USER_WARNING
				);
			}
		} else {
			trigger_error('Attempting to append when there is no root element', E_USER_WARNING);
		}

	}

	/**
	 * Magic alias of getElementsByTagName
	 *
	 * @param  string $name  The local name (without namespace) of the tag
	 * @return \DOMNodeList  A new DOMNodeList object containing all the matched elements.
	 * @see https://php.net/manual/en/domdocument.getelementsbytagname.php
	 */
	final public function __get($name)
	{
		if (! in_array(substr($name, 0, 1), ['/', '*', '@'])) {
			$name = "*/{$name}";
		}
		return (new \DOMXPath($this))->query($name);
	}

	/**
	 * Checks if any matches found by checking length of NodeList
	 *
	 * @param  string  $name Tag name to search for
	 * @return bool          Whether or not any matching children are found
	 */
	final public function __isset($name)
	{
		return $this->__get($name)->length !== 0;
	}

	/**
	 * Remove all child nodes with Tag Name $name
	 *
	 * @param string $name Query for __get to return NodeList of
	 * @return void
	 * @see https://php.net/manual/en/domnode.removechild.php
	 */
	final public function __unset($name)
	{
		foreach ($this->__get($name) as $node) {
			$node->parentNode->removeChild($node);
		}
	}

	/**
	 * Abstract method for when class is used as a string
	 *
	 * @param void
	 * @return string XML, HTML... whatever it may be
	 */
	abstract public function __toString();

	/**
	 * Private method to set $this->root_el
	 *
	 * @param mixed $node Either node or node name to set as root element
	 * @return self
	 */
	final protected function _setRoot($node = 'root')
	{
		if (is_string($node)) {
			$this->body = $this->appendChild($this->createElement($node));
		} elseif (is_object($node) and $node instanceof \DOMNode) {
			$this->body = $this->appendChild($node);
		} else {
			trigger_error(
				sprintf('$node must be either a DOMNode or string, %s given', gettype($node)),
				E_USER_WARNING
			);
		}
		return $this;
	}

	/**
	 * Dynamically and seemingly magically build nodes and append to parent
	 *
	 * @param mixed    $key    Int or string to become tagname of new node
	 * @param mixed    $value  String, array, sdtClass object, DOMNode
	 * @param \DOMNode $parent Parent element to append to (defaults to $this)
	 * @return void
	 */
	final protected function _nodeBuilder($key, $value = null, \DOMNode &$parent = null)
	{
		if (is_null($parent)) {
			$parent = $this;
		}
		if (is_string($key)) {
			if (substr($key, 0, 1) === '@' and (is_string($value) or is_numeric($value))) {
				$parent->setAttribute(substr($key, 1), $value);
			} else {
				$node = $parent->appendChild($this->createElement($key));
				if (is_string($value)) {
					$node->appendChild($this->createTextNode($value));
				} elseif ($value instanceof \DOMNode) {
					$node->appendChild($content);
				} elseif (is_array($value) or (is_object($value) and $value = get_object_vars($vvalue))) {
					foreach ($value as $k => $v) {
						$this->{__FUNCTION__}($k, $v, $node);
						unset($k, $v);
					}
				}
			}
		} elseif (is_string($value)) {
			$parent->appendChild($this->createTextNode($value));
		} elseif ($value instanceof \DOMNode) {
			$parent->appendChild($value);
		} elseif (is_array($value) or is_object($value) and $value = get_object_vars($value)) {
			foreach ($value as $k => $v) {
				$this->{__FUNCTION__}($k, $v, $node);
				unset($k, $v);
			}
		}
	}
}
