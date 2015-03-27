<?php
/**
 * @author Chris Zuber
 * @package shgysk8zer0\Core
 * @version 1.0.0
 * @since 1.0.0
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
namespace shgysk8zer0\Core_API\Abstracts;

use \DOMElement as Element;

/**
 * Extend \DOMDocument to make easier to use and add new features
 * @see http://php.net/manual/en/class.domdocument.php
 * @todo Make class abstract
 * @todo Figure out how to set attributes on nodes when created
 */
class XML_Document extends \DOMDocument implements \shgysk8zer0\Core_API\Interfaces\Magic_Methods
{
	const VERSION = '1.0';
	const ENCODING = 'UTF-8';
	const ROOT_EL = 'root';
	const FALSE = 0;
	const TRUE = 1;

	/**
	 * The root element of the document
	 * @var \DOMElement
	 */
	protected $root;

	/**
	 * Creates a new XML Document
	 *
	 * @param numeric $version  Version of XML to use
	 * @param string  $encoding Charset to use for document
	 * @param string  $root     The tag name of $root
	 */
	public function __construct(
		$version  = self::VERSION,
		$encoding = self::ENCODING,
		$root     = self::ROOT_EL
	)
	{
		parent::__construct($version, $encoding);
		$this->root = $this->appendChild(new Element($root));
	}

	/**
	 * Creates and append a new Element ($tag) containing with $content
	 *
	 * @param string $tag     Tag name for new element to be appended to root
	 * @param mixed $content  Anything $this::append can handle for $content
	 */
	public function __set($tag, $content)
	{
		$tag = $this->root->appendChild(new Element($tag));
		$this->append($tag, $content);
	}

	/**
	 * Get a node by tag name or ID. For id, the node must use
	 * `DOMNode::setAttribute` & `DOMNode::setIdAttribute`
	 *
	 * @param  string $query The tagName or Element ID to search for
	 * @return mixed         \DOMElement or \DOMNodeList
	 * @see http://php.net/manual/en/domdocument.getelementbyid.php
	 * @see http://php.net/manual/en/domdocument.getelementsbytagname.php
	 */
	public function __get($query)
	{
		if (substr($query, 0, 1) === '#') {
			return $this->getElementById(substr($query, 1));
		} else {
			return $this->getElementsByTagName($query);
		}

	}

	/**
	 * Magic chained method for setting multiple nodes
	 *
	 * @param  string $tag     Tag Name for node to create
	 * @param  array  $content Any valid content acceptable by $this::append
	 * @return self
	 * @example $this->$tage(['node' => 'value'], ...)
	 */
	public function __call($tag, array $content = array())
	{
		return $this->append(
			$this->root->appendChild(new Element($tag)),
			$content
		);
	}

	/**
	 * Creates and appends an array of content to $node (default is root)
	 *
	 * @param  array  $nodes   Any content compatible with $this::append
	 * @param  \DOMNode $node  Node to append it all to
	 * @return self
	 */
	public function __invoke(array $nodes = array(), \DOMNode $node = null)
	{
		if (is_null($node)) {
			$node = $this->root;
		}
		$this->append($node, $nodes);
		return $this;
	}

	/**
	 * Checks if a node matching tagName $query exists
	 *
	 * @param  string  $query TagName of a node
	 * @return bool           Whether or not one or more exist
	 */
	public function __isset($query)
	{
		return $this->getElementsByTagName($query)->length > 0;
	}

	/**
	 * Removes first node of tagName $query
	 *
	 * @param string $query TagName to search & destroy
	 * @return void
	 */
	public function __unset($query)
	{
		if (isset($this->$query)) {
			$node = $this->$query->item(0);
			$node->parentNode->removeChild($node);
		}
	}

	/**
	 * Method used when class is used as a string
	 *
	 * @return string Document as an HTML or XML string
	 * @example echo $this;
	 * @example $var = "{$this}";
	 */
	public function __toString()
	{
		return $this->saveXML();
	}

	/**
	 * Append any supported $content to $parent
	 *
	 * @param  DOMNode $parent  Node to append to
	 * @param  mixed   $content Content to append
	 * @return self
	 */
	protected function append(\DOMNode &$parent, $content = null)
	{
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
						$node = $parent->appendChild(new Element($node));
						if (is_string($value)) {
							$this->append(
								$node,
								$this->createTextNode($value)
							);
						} else {
							$this->append($node, $value);
						}
					} else {
						$this->append($parent, $value);
					}
				},
				array_keys($content),
				array_values($content)
			);
		} elseif (is_bool($content)) {
			$parent->appendChild(
				$this->createTextNode($content ? self::TRUE : self::FALSE)
			);
		} else {
			throw new \InvalidArgumentException('Unable to append unknown content [' . get_class($content) . '] to XML_Document');
		}

		return $this;
	}

	/**
	 * Set attributes on $node using [$name => $value]
	 *
	 * @param DOMNode $node  Node to set attributes on
	 * @param array   $attrs $key => $value array of attributes to set
	 */
	protected function setAttributes(\DOMNode $node, array $attrs = array())
	{
		$attrs = array_filter('is_string', $attrs);
		array_map(
			[$node, 'setAttribute'],
			array_keys($attrs),
			array_values($attrs)
		);
	}
}
