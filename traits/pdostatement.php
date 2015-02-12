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

trait PDOStatement
{
	/**
	 * Binds a parameter to the specified variable name
	 *
	 * @param  array  $params [key => value (no need to prefix key with ":")]
	 * @return self
	 */
	final public function bind(array $params = array())
	{
		$params = $this->bindConversion($params);
		array_map(
			[$this, 'bindParam'],
			array_keys($params),
			array_values($params)
		);

		return $this;
	}

	/**
	 * Execute the prepared statement
	 *
	 * @param  array $bound_input_params  [$key => $value]
	 * @return self
	 */
	final public function execute($bound_input_params = null)
	{
		if (! is_array($bound_input_params) or empty($bound_input_params)) {
			parent::execute();
		} else {
			parent::execute($this->bindConversion($bound_input_params));
		}

		return $this;
	}

	/**
	 * Returns an array containing all of the result set rows
	 *
	 * @param mixed $col          int or null. If int, returns that index of results
	 * @param int   $fetch_style  Controls the contents of the returned array
	 * @see http://php.net/manual/en/pdostatement.fetchall.php
	 */
	final public function getResults($col = null, $fetch_style = \PDO::FETCH_CLASS)
	{
		if (is_int($col)) {
			return $this->fetchAll($fetch_style)[$col];
		} else {
			return $this->fetchAll($fetch_style);
		}
	}

	/**
	 * Prefixes paramaters for binding to prepared statements
	 *
	 * @param string $key Array key for $bound_input_params
	 * @return string     $key, prefixed with ':'
	 */
	final protected function bindKey($key)
	{
		return ":{$key}";
	}

	/**
	 * Converts an array into one compatible with bind() & execute()
	 *
	 * @param array $bound_input_params [$key => $value]
	 * @return array                    [:$key => $value]
	 */
	final protected function bindConversion(array $bound_input_params = array())
	{
		return array_combine(
			array_map([$this, 'bindKey'], array_keys($bound_input_params)),
			array_values($bound_input_params)
		);
	}
}
