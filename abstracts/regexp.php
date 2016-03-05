<?php
/**
 * @author Chris Zuber
 * @package shgysk8zer0\Core_API
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

/**
 * Abstract class defining Regular Expression patterns, such as for inputs
 * Compatible with HTML5 pattern attribute
 */
abstract class RegExp
{
	const TEXT         = '^(\w+ ?)+$';
	const NAME         = '^[A-Za-z]{3,30}$';
	const PASSWORD     = '^(?=^.{8,35}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$';
	const EMAIL        = '^.+@.+\.+[\w]+$';
	const URL          = '^(https?:\/\/)?[\S]+\.[\S]+$';
	const TEL          = '^\d{3}[\-]\d{3}[\-]\d{4}$';
	const NUMBER       = '^\d+(\.\d+)?$';
	const COLOR        = '^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$';
	const DATE         = '^(?:19|20)(?:(?:[13579][26]|[02468][048])-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))|(?:[0-9]{2}-(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:29|30))|(?:(?:0[13578]|1[02])-31)))$';
	const TIME         = '^(0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}$';
	const DATETIME     = '^([0-2][0-9]{3})\-([0-1][0-9])\-([0-3][0-9])T([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])(Z|([\-\+]([0-1][0-9])\:00))$';
	const WEEK         = '^\d{4}-W\d{2}$';
	const CREDIT       = '^\d{13,16}$';
	const HTML_COMMENT = '^<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->$';
	const MD5          = '^[0-9a-fA-F]{32}$';
	const IPV4         = '((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$';
	const IPV6         = '((^|:)([0-9a-fA-F]{0,4})){1,8}$';
	const GPS          = '^-?\d{1,3}\.\d+$';
	const ISBN         = '^(?:(?=.{17}$)97[89][ -](?:[0-9]+[ -]){2}[0-9]+[ -][0-9]|97[89][0-9]{10}|(?=.{13}$)(?:[0-9]+[ -]){2}[0-9]+[ -][0-9Xx]|[0-9]{9}[0-9Xx])$';
}
