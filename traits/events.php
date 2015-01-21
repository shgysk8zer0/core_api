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
 * PHP events system. Allows for arbitrary events to register predefined or
 * anonymous functions or class methods. Events may be triggered, whether registered
 * or not, may have multiple or zero handlers for a given event, and may be
 * triggered multiple times.
 *
 * To be implemented in classes either extending Abstracts\Events or using
 * Traits\Events.
 */
trait Events
{
	/**
	 * Protected array to hold [$event => $callback]
	 *
	 * @var array
	 */
	protected static $registered_events = [];

	/**
	 * Register a new handler to an event, whether or not that event already exists
	 *
	 * @param string   $event    Name of event. E.G. "Error"
	 * @param Callable $callback Callback to call when event is triggered
	 * @return void
	 */
	final protected static function registerEvent($event, Callable $callback)
	{
		static::$registered_events[$event][] = $callback;
	}

	/**
	 * Trigger an event an call its callback if any exist. Otherwise, nothing
	 *
	 * @param string $event   Name of event. E.G. "Error"
	 * @param array  $context An array of paramaters to pass to the callback
	 * @return void
	 */
	final protected static function triggerEvent($event, array $context = array())
	{
		if (array_key_exists($event, static::$registered_events)) {
			array_map(function($handler) use ($context)
			{
				call_user_func($handler, $context);
			}, static::$registered_events[$event]);
		}
	}
}
