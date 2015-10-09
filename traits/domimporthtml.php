<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
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
 * Allows importing of HTML strings into a DOMElement
 */
trait DOMImportHTML
{
	/**
	 * Import HTML into a DOMElement
	 *
	 * @param  string $html A string of HTML
	 * @return void
	 */
	final public function importHTML($html)
	{
		$tmp_doc = new \DOMDocument('1.0', 'UTF-8');
		$tmp_doc->loadHTML($html);
		$nodes = array();
		foreach ($tmp_doc->documentElement->childNodes as $node) {
			array_push($nodes, $node);
			$this->appendChild($this->ownerDocument->importNode($node, true));
		}
		return $nodes;
	}

	final public function appendAll()
	{
		return array_map([$this, 'append'], func_get_args());
	}

	final public function append($content)
	{
		if ($content instanceof \DOMNode) {
			return $this->appendChild(isset($content->ownerDocument)
				? $this->ownerDocument->importNode($content, true)
				: $content
			);
		} elseif (is_string($content)) {
			return $this->importHTML($content);
		} else {
			throw new \InvalidArgumentException(
				sprintf('%s expected either a DOMNode or string, %s given', __METHOD__, gettype($content))
			);
		}
	}
}
