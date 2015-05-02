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
 * Provides magic methods to \DOMElement... Make sure to extend it
 * @see https://php.net/manual/en/class.domelement.php
 */
trait DOMElement
{
	/**
	 * Magic alias of setAttribute
	 *
	 * @param string $name  The name of the attribute.
	 * @param string $value The value of the attribute.
	 * @return void
	 */
	final public function __set($name, $value = 'true')
	{
		if (substr($name, 0, 1) === '@') {
			$this->setAttribute(substr($name, 1), $value);
		} else {
			if (is_string($value) or is_null($value)) {
				$this->appendChild(new self($name, $value));
			} elseif (is_object($value) and $value instanceof \DOMNode) {
				$this->appendChild(new self($name))->appendChild($value);
			} elseif (is_array($value)) {
				$node = $this->appendChild(new self($name));
				array_map(
					function($key, $val) use (&$node)
					{
						$node->$key = $val;
					},
					array_keys($value),
					array_values($value)
				);
			}
		}
	}

	/**
	 * Magic alias of getAttribute
	 *
	 * @param  string $name The name of the attribute.
	 * @return string       The value of the attribute
	 */
	final public function __get($name)
	{
		if (substr($name, 0, 1) === '@') {
			return $this->getAttribute(substr($name, 1));
		} else {
			$xpath = new \DOMXPath($this->ownerDocument);
			return $xpath->query($name, $this);
		}
	}

	/**
	 * Magic alias of hasAttribute
	 *
	 * @param  string  $name The name of the attribute
	 * @return bool          TRUE on success or FALSE on failure.
	 */
	final public function __isset($name)
	{
		return $this->hasAttribute($name);
	}

	/**
	 * Magic alias of removeAttribute
	 *
	 * @param string $name The name of the attribute
	 * @return void
	 */
	final public function __unset($name)
	{
		$this->removeAttribute($name);
	}

	/**
	 * Import text content when using class as a function
	 *
	 * @param  string $content XML or HTML
	 * @return self
	 * @example $this('<div>Content</div>')
	 */
	final public function __invoke($content = '')
	{
		if (is_string($content)) {
			$fragment = $this->ownerDocument->createDocumentFragment();
			$fragment->appendXML(str_replace('&nbsp;', ' ', $content));
			$this->appendChild($fragment);
		} elseif ($content instanceof \DOMNode) {
			$this->appendChild($content);
		}
		return $this;
	}

	final public function appendHTML($html)
	{
		$dom = new \DOMDocument;
		$dom->loadHTML("{$html}");
		$xpath = new \DOMXpath($dom);
		foreach ($xpath->query('/*') as $node) {
			$this->appendChild($this->ownerDocument->importNode($node, true));
		}
		return $this;
	}

	/**
	 * Return nodeValue of $this when used as a string
	 *
	 * @return string Node's text value as HTML or XML
	 */
	abstract public function __toString();
}
