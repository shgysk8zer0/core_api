<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core
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

trait XML_Exception
{
	/**
	 * Converts a PHP Exception into a populated XML node
	 *
	 * @param Exception $e   The exception thrown & caught
	 * @param DOMNode   $par The parent node to be appending to
	 * @return void          $par is a pointer
	 */
	final protected function ExceptionAsXML(\Exception $e, \DOMNode &$par)
	{
		//echo $e . PHP_EOL .  print_r($par, true);
		$exc = $par->appendChild($this->createElement('Exception'));
		$exc->appendChild($this->createElement('File', $e->getFile()));
		$exc->appendChild($this->createElement('Line', $e->getLine()));
		$exc->appendChild($this->createElement('Code', $e->getCode()));
		$exc->appendChild(
			$this->createElement('Message', $e->getMessage())
		);

		array_reduce(
			$e->getTrace(),
			function($parent, $el)
			{
				$trace = $this->createElement('Trace');
				$parent->appendChild($trace);
				$trace->appendChild($this->createElement('File', $el['file']));
				$trace->appendChild($this->createElement('Line', $el['line']));
				$trace->appendChild(
					$this->createElement('Function', $el['function'])
				);
				$trace->appendChild($this->createElement('Type', $el['type']));
				$args = $trace->appendChild($this->createElement('Args'));

				foreach ($el['args'] as $arg) {
					$args->appendChild(
						$this->createElement('Arg', print_r($arg, true))
					);
				}
				return $parent;
			},
			$exc->appendChild($this->createElement('StackTrace'))
		);
	}
}
