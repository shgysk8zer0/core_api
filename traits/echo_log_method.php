<?php
namespace shgysk8zer0\Core_API\Traits;

trait Echo_Log_Method
{
	/**
	* Logs with an arbitrary level.
	*
	* @param mixed $level
	* @param string $message
	* @param array $context
	* @return null
	*/
	final public function log($level, $message, array $context = array())
	{
		if(! defined("\\shgysk8zer0\\Core\\Abstracts\\LogLevel::" . strtoupper($level))) {
			throw new \InvalidArgumentException("Undefined log level: {$level}");
		}
		echo strtr(
			$message,
			array_combine(
				array_map(
					function($key)
					{
						return "{{$key}}";
					},
					array_keys($context)
				),
				array_values($context)
			)
		) . PHP_EOL;
	}
}
