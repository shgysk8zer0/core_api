<?php
namespace shgysk8zer0\Core_API\Tests;
final class Path_Info
{
	use \shgysk8zer0\Core_API\Traits\Path_Info;

	public function __construct($file, $use_include_path = false)
	{
		$this->getPathInfo($file, $use_include_path);
	}
}
