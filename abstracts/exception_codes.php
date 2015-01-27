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
namespace shgysk8zer0\Core_API\Abstracts;

/**
 * Defines constants for exception codes.
 *
 * @todo Define a pattern of some kind. Perhaps primary numbers or use system
 * similar to E_* (binary type). Could also use a system similar to HTTP status
 * codes, where they are defined in groups (500 for server errors, 300 for user)
 * @todo Method to invert these? Convert the exception code to string?
 */
abstract class Exception_Codes
{
	const UNDEFINED = 0;
	const INVALID_ARGS = 1;
	const NOT_FOUND = 2;
	const MISSING_USER_INPUT = 3;
	const UNAUHORIZED = 4;
	const DEPRECIATD = 5;
}
