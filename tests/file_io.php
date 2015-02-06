<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;

class File_IO implements API\Interfaces\File_IO
{
	use API\Traits\File_IO;
	use API\Traits\SIngleton;
	
	public function __construct($filename)
	{
		$this->openFile($filename);
	}
}
