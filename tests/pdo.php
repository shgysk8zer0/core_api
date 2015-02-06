<?php
namespace shgysk8zer0\Core_API\Tests;

use \shgysk8zer0\Core_API as API;

final class PDO
	extends API\Abstracts\PDO_Connect implements API\Interfaces\PDO, API\Interfaces\File_IO
{
	use API\Traits\PDO;
	use API\Traits\Singleton;
	use API\Traits\PDO_Backups;

	const STM_CLASS = 'PDOStatement';
	const DEFAULT_CON = '/var/www/html/chriszuber/config/connect.json';

	public function __construct($con = null)
	{
		parent::connect(
			$con,
			[
				self::ATTR_STATEMENT_CLASS => ['\\' . __NAMESPACE__ . '\\' . self::STM_CLASS]
			]
		);
	}
}
