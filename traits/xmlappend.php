<?php
/**
 * @author Chris Zuber
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
 *
 */
trait XMLAppend
{
	/**
	 * Append any supported $content to $parent
	 *
	 * @param  DOMNode $parent  Node to append to
	 * @param  mixed   $content Content to append
	 * @return self
	 */
	protected function XMLAppend(\DOMNode &$parent = null, $content = null)
	{
		if (is_null($parent)) {
			$parent = $this->root;
		}
		if (
			is_string($content)
			or is_numeric($content)
			or (is_object($content) and method_exists($content, '__toString'))
		) {
			$parent->appendChild($this->createTextNode("$content"));
		} elseif (
			is_object($content)
			and is_subclass_of($content, '\DOMNode')
		) {
			$parent->appendChild($content);
		} elseif (
			is_array($content)
			or (is_object($content) and $content = get_object_vars($content))
		) {
			array_map(
				function($node, $value) use (&$parent){
					if (is_string($node)) {
						if (substr($node, 0, 1) === '@') {
							$parent->setAttribute(substr($node, 1), $value);
						} else {
							$node = $parent->appendChild($this->createElement($node));
							if (is_string($value)) {
								$this->XMLAppend(
									$node,
									$this->createTextNode($value)
								);
							} else {
								$this->XMLAppend($node, $value);
							}
						}
					} else {
						$this->XMLAppend($parent, $value);
					}
				},
				array_keys($content),
				array_values($content)
			);
		} elseif (is_bool($content)) {
			$parent->appendChild(
				$this->createTextNode($content ? 'true' : 'false')
			);
		} else {
			throw new \InvalidArgumentException(
				sprintf(
					'Unable to append unknown content [%s] to %s',
					get_class($content),
					get_class($this)
				)
			);
		}

		return $this;
	}
}
