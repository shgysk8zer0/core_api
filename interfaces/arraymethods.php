<?php
/**
 * @author Chris Zuber <shgysk8zer0@gmail.com>
 * @package shgysk8zer0\Core_API
 * @subpackage Interfaces
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
 * Interface providing Object-oriented methods to array functions
 * @see https://php.net/manual/en/book.array.php
 */
interface ArrayMethods
{
	/**
	 * Push one or more elements onto the end of array
	 * @param mixed ...
	 * @return int      Returns the new number of elements in the array.
	 * @see https://php.net/manual/en/function.array-push.php
	 */
	public function push();

	/**
	 * Pop the element off the end of array
	 * @param  void
	 * @return mixed Returns the last value of array
	 * @see https://secure.php.net/manual/en/function.array-pop.php
	 */
	public function pop();

	/**
	 * Shift an element off the beginning of array
	 * @param void
	 * @return mixed Returns the shifted value
	 */
	public function shift();

	/**
	 * Prepend one or more elements to the beginning of an array
	 * @param mixed ...  Items to prepend to array
	 * @return [type]    Returns the new number of elements in the array.
	 */
	public function unshift();

	/**
	 * Extract a slice of the array
	 * @param  int    $offset        Starting position in the array
	 * @param  int    $length        Number of items to include, starting from $offset
	 * @param  bool   $preserve_keys Prevent override of indices
	 * @return [type]                Returns the slice.
	 * @see https://secure.php.net/manual/en/function.array-slice.php
	 */
	public function slice($offset, $length = null, $preserve_keys = false);

	/**
	 * Remove a portion of the array and replace it with something else
	 * @param  int    $offset      The starting index
	 * @param  int    $length      The number of items
	 * @param  array  $replacement Removed elements are replaced with elements from this array.
	 * @return [type]              Returns the array consisting of the extracted elements.
	 * @see https://secure.php.net/manual/en/function.array-splice.php
	 */
	public function splice($offset, $length = null, array $replacement = array());

	/**
	 * Split an array into chunks
	 * @param  int    $size          The size of each chunk
	 * @param  bool   $preserve_keys Whether or not to preserve array keys
	 * @return [type]                Multidimensional numerically indexed array of size $size
	 * @see https://secure.php.net/manual/en/function.array-chunk.php
	 */
	public function chunk($size, $preserve_keys = false);

	/**
	 * Searches the array for a given value and returns the corresponding key if successful
	 * @param  mixed  $needle [description]
	 * @param  bool   $strict [description]
	 * @return mixed          Returns the key for needle if it is found in the array, FALSE otherwise.
	 * @see https://secure.php.net/manual/en/function.array-search.php
	 */
	public function search($needle, $strict = false);

	/**
	 * Exchanges all keys with their associated values in an array
	 * @param void
	 * @return [type] The flipped array on success and NULL on failure.
	 */
	public function flip();

	/**
	 * Return all the keys or a subset of the keys of an array
	 * @param  mixed  $search_value If specified, then only keys containing these values are returned.
	 * @param  bool   $strict       Determines if strict comparison (===) should be used during the search.
	 * @return array                Returns an array of all the keys in array
	 */
	public function keys($search_value = null, $strict = false);

	/**
	 * Return all the values of an array
	 * @param void
	 * @return array The values from the array and indexes the array numerically.
	 */
	public function values();

	/**
	 * Pad array to the specified length with a value
	 * @param  int    $size  New size of the array.
	 * @param  mixed  $value Value to pad if array is less than size.
	 * @return [type]        Copy of the array padded to size specified by size with value value.
	 */
	public function pad($size, $value);

	/**
	 * Fill an array with values
	 * @param  int    $start_index The first index of the returned array.
	 * @param  int    $num         Number of elements to insert.
	 * @param  mixed  $value       Value to use for filling
	 * @return [type]              [description]
	 */
	public static function fill($start_index, $num, $value);

	/**
	 * Sort multiple or multi-dimensional arrays
	 * @param  mixed  $array1_sort_order  SORT_ASC or  SORT_DESC
	 * @param  mixed  $array1_sort_flags  Sorting type flags
	 * @return [type]                     Returns TRUE on success or FALSE on failure.
	 * @see https://secure.php.net/manual/en/function.array-multisort.php
	 */
	public function multisort(
		$array1_sort_order = SORT_ASC,
		$array1_sort_flags = SORT_REGULAR
	);

	/**
	 * Removes duplicate values from an array
	 * @param  int    $sort_flags May be used to modify the sorting behavior
	 * @return [type]             Returns the filtered array.
	 * @see https://secure.php.net/manual/en/function.array-unique.php
	 */
	public function unique($sort_flags = SORT_STRING);

	/**
	 * Pick one or more random entries out of an array
	 * @param  int     $num Specifies how many entries should be picked.
	 * @return mixed        Array key if $num is 1, otherwise an array of keys
	 * @see https://secure.php.net/manual/en/function.array-rand.php
	 */
	public function rand($num = 1);

	/**
	 * Applies the callback to the elements of the array
	 * @param  Callable $callback Callback function to run for each element in the array.
	 * @return self               An array containing elements from current array with callback applied
	 */
	public function map(Callable $callback);

	/**
	 * Apply a user supplied function to every member of an array
	 * @param  Callable $callback Typically, callback takes on two parameters. ($value, $index)
	 * @param  mixed    $userdata Optional third paramater for third paramater of $callback
	 * @return self
	 */
	public function walk(Callable $callback, $userdata = null);

	/**
	 * Filters elements of an array using a callback function
	 * @param  Callable $callback The callback function to use
	 * @param  int      $flags    Flag determining what arguments are sent to callback
	 * @return array              Returns the filtered array.
	 * @see https://secure.php.net/manual/en/function.array-filter.php
	 */
	public function filter(Callable $callback, $flags = 0);

	/**
	 * Iteratively reduce the array to a single value using a callback function
	 * @param  Callable $callback mixed callback ( mixed $carry , mixed $item )
	 * @param  mixed    $initial  Optional intitial value of $carry in $callback
	 * @return mixed              Returns the resulting value.
	 */
	public function reduce(Callable $callback, $initial = null);

	/**
	 * Creates a new instance from an object
	 * @param  mixed $object  Object to create from
	 * @return [type]         New instance of class with array data created from $object
	 */
	public static function createFromObject($object);

	/**
	 * Creates a new instance from an array
	 * @param  array  $array An array
	 * @return [type]        New instance of class with array data created from $array
	 */
	public static function createFromArray(array $array);
}
