<?php
namespace shgysk8zer0\Core_API\Tests;
use \shgysk8zer0\Core_API as API;
final class Parser
	implements API\Interfaces\File_IO,
	API\Interfaces\Magic_Methods
{
	use API\Traits\Parser;
	use API\Traits\Magic_Methods;

	private $parsed;

	const MAGIC_PROPERTY = 'parsed';

	public function __construct($file)
	{
		$this->{$this::MAGIC_PROPERTY} = $this->parse($file);
	}

	public function __toString()
	{
		return print_r($this->{self::MAGIC_PROPERTY}, true);
	}
}
