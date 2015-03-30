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
 * Provides magic getters, setters, as well as set and unset methods
 *
 * Any class using this trait is required to set a constant MAGIC_PROPERTY and
 * to have a protected or private property of the same name.
 * @see http://php.net/manual/en/language.oop5.magic.php
 */
trait Magic_Methods
{
	use Magic\Get;
	use Magic\Set;
	use Magic\Is_Set;
	use Magic\Un_Set;

	/**
	 * Single protected method for keeping MAGIC_PROPERTY keys consistent
	 *
	 * @param string $prop A pointer to the property
	 * @return void
	 */
	protected function magicPropConvert(&$prop)
	{
		$prop = preg_replace('/[\W]/', '_', strtolower($prop));
	}
}
