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
namespace shgysk8zer0\Core_API\Interfaces;

/**
 * Defines an interface for events to be registered and triggered using magic
 * methods.
 */
interface Magic_Events
{
	/**
	 * Create a new Event as you would a class.
	 *
	 * @param string   $event    The name of the event to register
	 * @param Callable $callback The callback to call when triggered
	 *
	 * @example new Event('Exception', 'print_r');
	 * @example new Event('Exception', [$class, 'method']);
	 * @example new Event('My Event', function(array $args) use ($var){});
	 */
	public function __construct($event, Callable $callback);

	/**
	 * Trigger events using static method. Since constructor registers events,
	 * triggering events must be done statically.
	 *
	 * @param string $event   The name of the event to trigger
	 * @param array  $context An array of arguemnts.
	 * @return null
	 *
	 * @example Event::Exception($e->getMessage(), $e->getLine());
	 * @example Event::{'My Event'}($var1, $var2, ....);
	 */
	public static function __callStatic($event, array $context = array());
}
