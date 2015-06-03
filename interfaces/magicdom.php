<?php

namespace shgysk8zer0\Core_API\Interfaces;

interface MagicDOM extends Magic_Methods
{
	public function __call($name, array $arguments = array());
}
