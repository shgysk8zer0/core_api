<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;
final class URL
{
	use API\Traits\URL;
	use API\Traits\Magic_Methods;
	use API\Traits\Singleton;

	const MAGIC_PROPERTY = 'url_data';

	public function __construct($url = null)
	{
		$this->parseURL($url);
	}

	public function __toString()
	{
		return $this->URLToString();
	}
}
