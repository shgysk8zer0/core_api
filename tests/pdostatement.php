<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;
final class PDOStatement extends \PDOStatement implements API\Interfaces\PDOStatement
{
	use \shgysk8zer0\Core_API\Traits\PDOStatement;
	use \shgysk8zer0\Core_API\Traits\PDOStatement_Magic;
}
