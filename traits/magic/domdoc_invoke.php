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
 * Provides and easy to use __invoke method to all DOMDocuments
 */
trait DOMDoc_Invoke
{
	/**
	 * Create and append a new element when class used as a function
	 *
	 * @param  string   $tag        TagName for new element
	 * @param  string   $content    Optional text content/child node for new element
	 * @param  array    $attributes Optional array of attributes to set on new element
	 * @param  \DOMNode $node       Parent to append new element to
	 * @return \DOMElement          The newly created & appended element
	 * @example $div = $this();
	 * @example $a = $this('a', 'Link text', ['href => 'example.com'], $div);
	 */
	final public function __invoke(
		$tag              = 'div',
		$content          = null,
		array $attributes = array(),
		\DOMNode $parent  = null
	)
	{
		if (is_null($parent)) {
			$parent = $this->body;
		}

		if (is_null($content)) {
			$child = $parent->appendChild($this->createElement($tag));
		} elseif (is_string($content)) {
			$child = $parent->appendChild($this->createElement($tag, $content));
		} elseif (is_object($content) and $content instanceof \DOMNode) {
			$child = $parent->appendChild($this->createElement($tag));
			$child->appendChild($content);
		} elseif (is_array($content)) {
			$child = $parent->appendChild($this->createElement($tag));
			array_map(
				function($key, $value) use (&$child)
				{
					if (is_int($key) and is_string($value)) {
						$child->appendChild($this->createTextNode($value));
					} elseif (is_string($key)) {
						if (substr($key, 0, 1) === '@') {
							$child->setAttribute(substr($key, 1), $value);
						} else {
							$this($key, $value, [], $child);
						}
					}
				},
				array_keys($content),
				array_values($content)
			);
		} else {
			throw new \InvalidArgumentException(
				sprintf('Content must be null, string, or \\DOMNode, %s given', gettype($content))
			);
		}

		foreach ($attributes as $prop => $value) {
			$child->setAttribute((is_string($prop)) ? $prop : $value, $value);
		}

		return $child;
	}
}
