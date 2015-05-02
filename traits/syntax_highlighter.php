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
 * Since these methods make no use of "$this", the methods are static
 */
trait Syntax_Highlighter
{
	/**
	 * Reads file into a syntax-highlighed HTML string using <font color> instead of <span style>
	 *
	 * @param bool   $return        true returns the string, false outputs it
	 * @param array  $replacements  Associative array of things to replace
	 * @return string               HTML formated, syntax-highlighted contents
	 * @see https://php.net/manual/en/function.highlight-file.php
	 * @uses Core_API/Traits/File_Resources
	 */
	final public function highlightFile(
		$return             = true,
		array $replacements = array(
			'<span style="color: ' => '<font color="',
			'</span>' => '</font>'
		)
	)
	{
		return str_replace(
			array_keys($replacements),
			array_values($replacements),
			ltrim(highlight_string($this->fileGetContents(), $return === true))
		);
	}

	/**
	 * Inverse of highlight function. Attempts to convert HTML to regular string
	 *
	 * @param  string $contents     HTML encoded, syntax-highlighted string
	 * @param  bool   $update_file  Whether or not to update file's content
	 * @param  array  $replacements Associative array of things to replace
	 * @return string           Non-HTML version of string
	 */
	final public function unhighlightString(
		$contents           = '',
		$update_file        = false,
		array $replacements = array('<br />' => PHP_EOL, '<br>' => PHP_EOL, '&nbsp;' => ' ')
	)
	{
		$contents = str_replace(array_keys($replacements), array_values($replacements), $contents);
		$contents = strip_tags($contents);
		$contents = html_entity_decode($contents);
		$contents = trim($contents) . PHP_EOL;
		if ($update_file === true) {
			$this->filePutContents("$contents", null);
		}
		return $contents;
	}
}
