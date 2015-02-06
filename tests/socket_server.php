<?php
namespace shgysk8zer0\Core_API\Tests;
use \shgysk8zer0\Core_API as API;
class Socket_Server
{
	use API\Traits\Socket_Server;
	public function __construct()
	{
		$this->socketCreate()->socketBind('127.0.0.1', 9001);
		$this->socketListen();
	}
}
