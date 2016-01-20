<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Traits
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
 * Provides Object-oriented methods to array functions
 * @see https://php.net/manual/en/book.array.php
 */
trait ArrayMethods
{
	final public static function of()
	{
		return static::createFromArray(func_get_args());
	}

	final public static function from($items, Callable $map_callback = null)
	{
		if (is_array($items)) {
			$arr = $items;
		} elseif ($items instanceof \Transversable) {
			$arr = [];
			foreach ($items as $item) {
				array_push($arr, $item);
			}
		} elseif (is_object($items)) {
			$arr = get_object_vars($items);
		} else {
			throw new \InvalidArgumentException(sprintf('Expected an array-like object but got a %s', gettype($items)));
		}
		if (isset($map_callback)) {
			$arr = array_map($map_callback, $arr);
		}
		return static::createFromArray($arr);
	}
	/**
	 * Push one or more elements onto the end of array
	 * @param mixed ...
	 * @return int      Returns the new number of elements in the array.
	 * @see https://php.net/manual/en/function.array-push.php
	 */
	final public function push()
	{
		return call_user_func_array(
			'array_push',
			array_merge([&$this->{self::MAGIC_PROPERTY}], func_get_args())
		);
	}

	/**
	 * Pop the element off the end of array
	 * @param  void
	 * @return mixed Returns the last value of array
	 * @see https://secure.php.net/manual/en/function.array-pop.php
	 */
	final public function pop()
	{
		return array_pop($this->{self::MAGIC_PROPERTY});
	}

	/**
	 * Shift an element off the beginning of array
	 * @param void
	 * @return mixed Returns the shifted value
	 */
	final public function shift()
	{
		return array_shift($this->{self::MAGIC_PROPERTY});
	}

	/**
	 * Prepend one or more elements to the beginning of an array
	 * @param mixed ...  Items to prepend to array
	 * @return [type]    Returns the new number of elements in the array.
	 */
	final public function unshift()
	{
		return call_user_func_array(
			'array_unshift',
			array_merge([&$this->{self::MAGIC_PROPERTY}], func_get_args())
		);
	}

	/**
	 * Extract a slice of the array
	 * @param  int    $offset        Starting position in the array
	 * @param  int    $length        Number of items to include, starting from $offset
	 * @param  bool   $preserve_keys Prevent override of indices
	 * @return [type]                Returns the slice.
	 * @see https://secure.php.net/manual/en/function.array-slice.php
	 */
	final public function slice($offset, $length = null, $preserve_keys = false)
	{
		$arr = array_unshift($this->{self::MAGIC_PROPERTY}, $offset, $length, $preserve_keys);
		return static::createFromArray($arr);
	}

	/**
	 * Remove a portion of the array and replace it with something else
	 * @param  int    $offset      The starting index
	 * @param  int    $length      The number of items
	 * @param  array  $replacement Removed elements are replaced with elements from this array.
	 * @return [type]              Returns the array consisting of the extracted elements.
	 * @see https://secure.php.net/manual/en/function.array-splice.php
	 */
	final public function splice($offset, $length = null, array $replacement = array())
	{
		$arr = array_splice($this->{self::MAGIC_PROPERTY}, $offset, $length, $replacement);
		return static::createFromArray($arr);
	}

	/**
	 * Split an array into chunks
	 * @param  int    $size          The size of each chunk
	 * @param  bool   $preserve_keys Whether or not to preserve array keys
	 * @return [type]                Multidimensional numerically indexed array of size $size
	 * @see https://secure.php.net/manual/en/function.array-chunk.php
	 */
	final public function chunk($size, $preserve_keys = false)
	{
		$arr = array_chunk($this->{self::MAGIC_PROPERTY}, $size, $preserve_keys);
		return static::createFromArray($arr);
	}

	final public function intersect()
	{
		$args = func_get_args();
		array_unshift($args, $this->{self::MAGIC_PROPERTY});
		$arr = call_user_func_array('array_intersect', $args);
		return static::createFromArray($arr);
	}

	/**
	 * Searches the array for a given value and returns the corresponding key if successful
	 * @param  mixed  $needle [description]
	 * @param  bool   $strict [description]
	 * @return mixed          Returns the key for needle if it is found in the array, FALSE otherwise.
	 * @see https://secure.php.net/manual/en/function.array-search.php
	 */
	final public function search($needle, $strict = false)
	{
		return array_search($needle, $this->{self::MAGIC_PROPERTY}, $strict);
	}

	/**
	 * Exchanges all keys with their associated values in an array
	 * @param void
	 * @return [type] The flipped array on success and NULL on failure.
	 */
	final public function flip()
	{
		return static::createFromArray(array_flip($this->{self::MAGIC_PROPERTY}));
	}

	/**
	 * Return all the keys or a subset of the keys of an array
	 * @param  mixed  $search_value If specified, then only keys containing these values are returned.
	 * @param  bool   $strict       Determines if strict comparison (===) should be used during the search.
	 * @return array                Returns an array of all the keys in array
	 */
	final public function keys($search_value = null, $strict = false)
	{
		if (isset($search_value)) {
			return static::createFromArray(array_keys($this->{self::MAGIC_PROPERTY}, $search_value, $strict));
		} else {
			return static::createFromArray(array_keys($this->{self::MAGIC_PROPERTY}));
		}
	}

	/**
	 * Return all the values of an array
	 * @param void
	 * @return array The values from the array and indexes the array numerically.
	 */
	final public function values()
	{
		return static::createFromArray(array_values($this->{self::MAGIC_PROPERTY}));
	}

	/**
	 * Merge one or more arrays
	 * @param array ... Arrays to merge with $this
	 * @return [type]   [description]
	 */
	final public function merge()
	{
		$args = func_get_args();
		array_unshift($args, $this->{self::MAGIC_PROPERTY});
		$arr = call_user_func_array('array_merge', $args);
		return static::createFromArray($arr);
	}

	/**
	 * Replaces elements from passed arrays into the first array
	 * @param array ... Arrays with values to be extracted
	 * @return [type]   Returns an array, or NULL if an error occurs.
	 * @see https://secure.php.net/manual/en/function.array-replace.php
	 */
	final public function replace()
	{
		$args = func_get_args();
		array_unshift($this->{self::MAGIC_PROPERTY}, $args);
		$arr = call_user_func_array('array_replace', $args);
		return static::createFromArray($arr);
	}

	/**
	 * Pad array to the specified length with a value
	 * @param  int    $size  New size of the array.
	 * @param  mixed  $value Value to pad if array is less than size.
	 * @return [type]        Copy of the array padded to size specified by size with value value.
	 */
	final public function pad($size, $value)
	{
		return static::createFromArray(array_pad($this->{self::MAGIC_PROPERTY}, $size, $value));
	}

	/**
	 * Fill an array with values
	 * @param  int    $start_index The first index of the returned array.
	 * @param  int    $num         Number of elements to insert.
	 * @param  mixed  $value       Value to use for filling
	 * @return [type]              [description]
	 */
	final public static function fill($start_index, $num, $value)
	{
		return static::createFromArray(array_fill($start_index, $num, $value));
	}

	/**
	 * Sort multiple or multi-dimensional arrays
	 * @param  mixed  $array1_sort_order  SORT_ASC or  SORT_DESC
	 * @param  mixed  $array1_sort_flags  Sorting type flags
	 * @return [type]                     Returns TRUE on success or FALSE on failure.
	 * @see https://secure.php.net/manual/en/function.array-multisort.php
	 */
	final public function multisort(
		$array1_sort_order = SORT_ASC,
		$array1_sort_flags = SORT_REGULAR
	)
	{
		return array_multisort($this->{self::MAGIC_PROPERTY}, $array1_sort_order, $array1_sort_flags);
	}

	/**
	 * Removes duplicate values from an array
	 * @param  int    $sort_flags May be used to modify the sorting behavior
	 * @return [type]             Returns the filtered array.
	 * @see https://secure.php.net/manual/en/function.array-unique.php
	 */
	final public function unique($sort_flags = SORT_STRING)
	{
		$arr = array_unique($this->{self::MAGIC_PROPERTY}, $sort_flags);
		return static::createFromArray($arr);
	}

	/**
	 * Pick one or more random entries out of an array
	 * @param  int     $num Specifies how many entries should be picked.
	 * @return mixed        Array key if $num is 1, otherwise an array of keys
	 * @see https://secure.php.net/manual/en/function.array-rand.php
	 */
	final public function rand($num = 1)
	{
		return array_rand($this->{self::MAGIC_PROPERTY}, $num);
	}

	/**
	 * Calculate the sum of values in an array
	 * @param void
	 * @return mixed Returns the sum of values as an integer or float.
	 * @see https://secure.php.net/manual/en/function.array-sum.php
	 */
	final public function sum()
	{
		return array_sum($this->{self::MAGIC_PROPERTY});
	}

	/**
	 * Calculate the product of values in an array
	 * @param void
	 * @return [type] [description]
	 */
	final public function product()
	{
		return array_product($this->{self::MAGIC_PROPERTY});
	}

	/**
	 * Applies the callback to the elements of the array
	 * @param  Callable $callback Callback function to run for each element in the array.
	 * @return self               An array containing elements from current array with callback applied
	 */
	final public function map(Callable $callback)
	{
		$arr = array_map($callback, $this->{self::MAGIC_PROPERTY});
		return static::createFromArray($arr);
	}

	/**
	 * Apply a user supplied function to every member of an array
	 * @param  Callable $callback Typically, callback takes on two parameters. ($value, $index)
	 * @param  mixed    $userdata Optional third paramater for third paramater of $callback
	 * @return self
	 */
	final public function walk(Callable $callback, $userdata = null)
	{
		array_walk($this->{self::MAGIC_PROPERTY}, $callback);
		return $this;
	}

	/**
	 * Filters elements of an array using a callback function
	 * @param  Callable $callback The callback function to use
	 * @param  int      $flags    Flag determining what arguments are sent to callback
	 * @return array              Returns the filtered array.
	 * @see https://secure.php.net/manual/en/function.array-filter.php
	 */
	final public function filter(Callable $callback, $flags = 0)
	{
		$arr = array_filter($this->{self::MAGIC_PROPERTY}, $callback);
		return static::createFromArray($arr);
	}

	/**
	 * Iteratively reduce the array to a single value using a callback function
	 * @param  Callable $callback mixed callback ( mixed $carry , mixed $item )
	 * @param  mixed    $initial  Optional intitial value of $carry in $callback
	 * @return mixed              Returns the resulting value.
	 */
	final public function reduce(Callable $callback, $initial = null)
	{
		$result = array_reduce($this->{self::MAGIC_PROPERTY}, $callback, $initial);

		return static::from($result);
	}

	/**
	 * Creates an array by using one array for keys and another for its values
	 * @param  array  $keys   Array of keys to be used. Illegal values for key will be converted to string.
	 * @param  array  $values Array of values to be used
	 * @return array          Returns the combined array
	 */
	final public static function combine(array $keys, array $values)
	{
		return static::createFromArray(array_combine($keys, $value));
	}

	/**
	 * Creates a new instance from an object
	 * @param  mixed $object  Object to create from
	 * @return [type]         New instance of class with array data created from $object
	 */
	final public static function createFromObject($object)
	{
		return static::createFromArray(get_object_vars($object));
	}
}
