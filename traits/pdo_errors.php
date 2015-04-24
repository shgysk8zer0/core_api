<?php

namespace shgysk8zer0\Core_API\Traits;

trait PDO_Errors
{
	final public function checkErrors()
	{
		if ($this->errorCode() !== '00000') {
			throw new \PDOException($this->errorInfo()[2], $this->errorCode());
		}
		return $this;
	}
}
