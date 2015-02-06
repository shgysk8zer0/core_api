<?php
namespace shgysk8zer0\Core_API\Tests;
class Socket_Client
{
	use \shgysk8zer0\Core_API\Traits\Socket_Client;

	public function __construct($server)
	{
		$this->socketAccept($server);
	}
}
