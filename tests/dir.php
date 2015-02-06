<?php
namespace shgysk8zer0\Core_API\Tests;

class Dir
{
	use \shgysk8zer0\Core_API\Traits\Singleton;
	private $abs_path;
	public $directories = [];
	public $files = [];

	public function __construct($path)
	{
		if (@is_file($path)) {
			$path = dirname($path);
		}
		$this->abs_path = realpath($path);
		if (! is_dir($this->abs_path)) {
			throw new \InvalidArgumentException("{$path} does not exist");
		}
		$dir = dir($this->abs_path);
		$dir->rewind();

		while ($path = $dir->read()) {
			if ($path !== '.' and $path !== '..') {
				$paths[] = $this->abs_path . DIRECTORY_SEPARATOR . $path;
			}
		}
		$dir->close();
		unset($path);

		$this->directories = array_filter($paths, 'is_dir');
		$this->files = array_filter($paths, 'is_file');
	}

	public function __get($path)
	{
		return self::load($this->abs_path . DIRECTORY_SEPARATOR . $path);
	}

	public function filesWithExtension($ext)
	{
		$ext = strtolower($ext);
		return array_filter($this->files, function($file) use ($ext)
		{
			return strtolower(pathinfo($file, PATHINFO_EXTENSION)) === $ext;
		});
	}
}
