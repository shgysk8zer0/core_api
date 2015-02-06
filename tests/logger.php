<?php
namespace shgysk8zer0\Core_API\Tests;

final class Logger
	extends \shgysk8zer0\Core_API\Abstracts\Logger
	implements \shgysk8zer0\Core_API\Interfaces\Logger
{	use \shgysk8zer0\Core_API\Traits\Logger;
	use \shgysk8zer0\Core_API\Traits\Echo_Log_Method;
}
