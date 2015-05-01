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
 * Creates and sends a JSON encoded response for XMLHTTPRequests
 * Optimized to be handled by handleJSON in functions.js
 */
Interface AJAX_DOM
{
	/**
	 * Sets textContent of elements matching $selector to $content
	 *
	 * @param string $selector  Any valid CSS selector
	 * @param string $content   Text to fill it with
	 * @return self
	 */
	public function text($selector = null, $content = null);

	/**
	 * Creates a notification (or alert)
	 *
	 * @param string $title
	 * @param string $body
	 * @param string $icon
	 * @return self
	 * @example $resp->notify('Title', 'Body', 'path/to/icon.png');
	 */
	public function notify($title = null, $body = null, $icon = null);

	/**
	 * @param string $selector
	 * @param string $content
	 * @return self
	 * @example $resp->html('.cssSelector', '<p>Some HTML content</p>');
	 */
	public function html($selector = null, $content = null);

	/**
	 * @param string $selector
	 * @param string $content
	 * @return self
	 * @example $resp->append('.cssSelector', '<p>Some HTML content</p>');
	 */
	public function append($selector = null, $content = null);

	/**
	 *
	 * @param string $selector
	 * @param string $content
	 * @return self
	 * @example $resp->prepend('.cssSelector', '<p>Some HTML content</p>');
	 */
	public function prepend($selector = null, $content = null);

	/**
	 * @param string $selector
	 * @param string $content
	 * @return self
	 * @example $resp->before('.cssSelector', '<p>Some HTML content</p>');
	 */
	public function before($selector = null, $content = null);

	/**
	 * @param string $selector
	 * @param string $content
	 * @return self
	 * @example $resp->after('.cssSelector', '<p>Some HTML content</p>');
	 */
	public function after($selector = null, $content = null);

	/**
	 * @param string $selector
	 * @param string $classes
	 * @return self
	 * @example $resp->addClass('.cssSelector', 'newClass, otherClass');
	 */
	public function addClass($selector = null, $classes = null);

	/**
	 * @param string $selector
	 * @param string $classes
	 * @return self
	 * @example $resp->removeClass('.cssSelector', 'someClass, someOtherClass');
	 */
	public function removeClass($selector = null, $classes = null);

	/**
	 * @param string $selector
	 * @return self
	 * @example $resp->remove('html .class > #id');
	 */
	public function remove($selector = null);

	/**
	 * @param string $selector
	 * @param string $attribute
	 * @param mixed $value
	 * @return self
	 * @example $resp->attributes(
	 * 	'html', 'contextmenu', false
	 * )->attributes(
	 * 	'html', 'data-menu', 'admin'
	 * );
	 */
	public function attributes($selector = null, $attribute = null, $value = true);

	/**
	 * Increment $attribute of $selector by $by
	 *
	 * @param  string  $selector  [CSS selector for element]
	 * @param  string  $attribute [Attribute to increment]
	 * @param  integer $by		[Ammount to increment by]
	 * @return self
	 * @example $resp->increment('#progress', 'value', 1)
	 * @example $resp->increment('#progress')
	 */
	public function increment($selector, $attribute = 'value', $by = 1);

	/**
	 * Increase value of $selector by $by using .stepUp() method
	 *
	 * @param string  $selector [Any valid CSS selector]
	 * @param integer $by	   [Amount to increase by]
	 * @return self
	 */
	public function stepUp($selector, $by = 1);

	/**
	 * Decrease value of $selector by $by using .stepDown() method
	 *
	 * @param string  $selector [Any valid CSS selector]
	 * @param integer $by	   [Amount to decrease by]
	 * @return self
	 */
	public function stepDown($selector, $by = 1);

	/**
	 * handleJSON in functions.js will eval() $js
	 * Requires 'unsafe-eval' be set on script-src in csp.ini
	 * which is generally a BAD idea.
	 * Including because it is useful.
	 * *USE WITH CAUTION* and watch your quotes
	 *
	 * @param string $js (script to execute)
	 * @example $resp->script("alert('Hello world')");
	 * @return self
	 */
	public function script($js = null);

	/**
	 * handleJSON in functions.js will do sessionStorage[$key] = $value
	 * Useful for storing data temporarily (session) on the client side
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return self
	 * @example $resp->sessionStorage('nonce', $session->nonce)
	 */
	public function sessionStorage($key = null, $value = null);

	/**
	 * handleJSON in functions.js will do localStorage[$key] = $value
	 * Useful for storing data more permenantly on the client side
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return self
	 * @example $resp->localStorage('greeting', 'Hello World!')
	 */

	public function localStorage($key = null, $value = null);

	/**
	 * handleJSON in functions.js will console.log functions arguments
	 *
	 * @param mixed (arguments passed to function)
	 * @return self
	 * @example $resp->log($session->nonce, $_SERVER['SERVER_NAME']);
	 */
	public function log();

	/**
	 * Creates a table in browser console in supported browsers. Handler
	 * in JavaScript will revert to log() if not supported
	 *
	 * @param mixed function arguments   [Any quantity or kind]
	 * @return self
	 */
	public function table();

	/**
	 * Creates a better formatted version of log() in supported browsers
	 * JavaScript handler will fallback to log() if not supported
	 * @param mixed function arguments   [Any quantity or kind]
	 * @return self
	 */
	public function dir();

	/**
	 * handleJSON in functions.js will console.info functions arguments
	 *
	 * @param mixed (arguments passed to function)
	 * @return self
	 * @example $resp->info($session->nonce, $_SERVER['SERVER_NAME']);
	 */
	public function info();

	/**
	 * handleJSON in functions.js will console.warn functions arguments
	 *
	 * @param mixed Arguments passed to function
	 * @return self
	 * @example $resp->warn($session->nonce, $_SERVER['SERVER_NAME']);
	 */
	public function warn();

	/**
	 * handleJSON in functions.js will console.error functions arguments
	 *
	 * @param mixed (arguments passed to function)
	 * @return self
	 * @example $resp->error($error);
	 */
	public function error();

	/**
	 * Will use document.querySellectorAll($sel).item($nth).scrollIntoView()
	 * which means that you can scroll to any given element (body
	 * is default)
	 *
	 * @param string $sel (CSS selector)
	 * @param int $nth
	 * @return self
	 * @example $resp->scrollTo('ul.myList li', 3)
	 */
	public function scrollTo($sel = 'body', $nth = 0);

	/**
	 * Will use document.querySellector($sel).focus()
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->focus('input[name="password"]')
	 */
	public function focus($sel = 'input');

	/**
	 * Will use document.querySellector($sel).sselect()
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->select('input[name="password"]')
	 */
	public function select($sel = 'input');

	/**
	 * Triggers window.location.reload() in handleJSON
	 *
	 * @param void
	 * @return self
	 * @example $resp->reload()
	 */
	public function reload();

	/**
	 * Triggers document.forms[$form].reset() in handleJSON
	 *
	 * @param string $form (name of the form)
	 * @return self
	 * @example $resp->clear('login')
	 */
	public function clear($form = null);

	/**
	 * Will trigger an event ($event) on targets ($selector) in handleJSON
	 *
	 * handleJSON needs to determine which type of event to trigger
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Web/Events
	 * @param string $selector (CSS selector for target(s))
	 * @param string $event (Event to be triggered)
	 * @return self
	 * @example $resp->triggerEvent('button[type=submit]', 'click')
	 */
	public function triggerEvent($selector = null, $event = null);

	/**
	 * Creates a popup window via JavaScript's window.open()
	 *
	 * @see http://www.w3schools.com/jsref/met_win_open.asp
	 * @param string $url
	 * @param array $paramaters,
	 * @param boolean $replace
	 * @return self
	 * @example $resp->open(
	 * 	'http://example.com',
	 * 	[
	 * 		'height' => 500,
	 * 		'width' => 500
	 * 	],
	 * 	false
	 * )
	 */
	public function open(
		$url = null,
		array $paramaters = null,
		$replace = false,
		$name = '_blank'
	);

	/**
	 * Causes handleJSON to run show() on all $sel.
	 *
	 * For <deails>, this will add the 'open' attribute.
	 * For <dialog> this will run the native show() method, if
	 * available. Otherwise, just adds the 'open' attribute there as well.
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->show('dialog')
	 */
	public function show($sel = null);

	/**
	 * Causes handleJSON to run show() on all $sel.
	 *
	 * For <deails>, this will add the 'open' attribute.
	 * For <dialog> this will run the native show() method, if
	 * available. Otherwise, just adds the 'open' attribute there as well.
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->show('dialog')
	 */
	public function showModal($sel = null);

	/**
	 * Inverse of show() method. This removes
	 * the 'open' attribute or runs the native close() method
	 * for <dialog>
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->close('dialog,details')
	 */
	public function close($sel = null);

	/**
	 * Removes the 'disabled' attribute on all nodes matching $sel
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->enable(:disabled)
	 */
	public function enable($sel = null);

	/**
	 * Sets the 'disabled' attribute on all nodes
	 * matching $sel.
	 *
	 * @param string $sel (CSS selector)
	 * @return self
	 * @example $resp->disable('button, menuitem, fieldset')
	 */
	public function disable($sel = null);

	/**
	 * Sets/removes the hidden attribute on all nodes matching $sel
	 *
	 * @param string $sel (CSS selector)
	 * @param boolean $hide (true will add hidden, false will remove it)
	 * @return self
	 * @example $resp->hidden('[hidden]', false)
	 */

	public function hidden($sel = null, $hide = true);

	/**
	 * Sets data-* using $this->attributes.
	 *
	 * Makes necessary conversions
	 *
	 * @param string $sel (CSS selector)
	 * @param string $name (data-$name)
	 * @param string $value (string or boolean)
	 * @return self
	 * @example $resp->dataset('menuitem[label="Click Me"]', 'request', 'action=test')
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/HTMLElement.dataset
	 */
	public function dataset($sel = null, $name = null, $value = null);

	/**
	 * Sets inline style on Element matching $sel
	 *
	 * @param  string $sel	  [Any valid CSS selector]
	 * @param  string $property [Property to set]
	 * @param  string $value	[Value to set it to]
	 * @return self
	 */
	public function style($sel = null, $property = null, $value = null);

	/**
	 * Sets ID on Element matching $sel
	 *
	 * @param  string $sel [Any valid CSS selector]
	 * @param  mixed $id   [String, null, or false. False unsets]
	 * @return self
	 */
	public function id($sel = null, $id = false);

	/**
	 * Creates a new server event using handleJSON.
	 *
	 * Server Events are events sent by the server in specific time intervals,
	 * allowing continuous communication from server to browser
	 *
	 * @see https://developer.mozilla.org/en-US/docs/Server-sent_events/Using_server-sent_events
	 * @param string $uri (location of the source of the server event)
	 * @return self
	 * @example $resp->serverEvent('event_source.php')
	 */
	public function serverEvent($uri = null);

	/**
	 * @param bool $format
	 * @return self
	 * @example $resp->debug((true|false)?);
	 */
	public function debug($format = false);
}
