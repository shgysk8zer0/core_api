<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
 * @version 1.0.0
 * @copyright 2016, Chris Zuber
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
 * Trait providing properties compatible with the JavaScript implementation
 * of the Notification API. Client side, use as `new Notification(resp.title, resp.options);`.
 * @see https://developer.mozilla.org/en-US/docs/Web/API/notification/Notification
 */
trait Notification
{
	/**
	 * The title of the notificaiton
	 * @var string
	 */
	public $title = '';

	/**
	 * Array of options (converted into an Object)
	 * @var array
	 */
	public $options = array(
		'body' => '',
		'icon' => '',
		'dir' => 'auto',
		'lang' => '',
		'tag' => '',
		'sticky' => false
	);
}
