<?php

namespace shgysk8zer0\Core_API\Traits;

trait REST_Client
{
	private $_read_access  = false;

	private $_write_access = false;

	//private $_root_dir     = __DIR__;

	final public function ls($dir = null)
	{
		if (is_string($dir)) {
			$dir = $this->getRootDir() . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR;
		} else {
			$dir = $this->getRootDir() . DIRECTORY_SEPARATOR;
		}
		$list = glob("{$dir}*");
		array_walk($list, [$this, '_getInfo']);
		return $list;
	}

	final protected function _getMime($path)
	{
		static $finfo = null;
		if (is_null($finfo)) {
			echo 'Creating FINFO instance' . PHP_EOL;
			$finfo = new \finfo(FILEINFO_MIME);
		}
		return $finfo->file($path);
	}

	final protected function _getInfo(&$path = '')
	{
		$data            = new \stdClass;
		$data->name      = basename($path);
		$data->directory = dirname($path);
		$data->size      = filesize($path);
		$data->modified  = filemtime($path);
		$data->created   = filectime($path);
		$data->accessed  = fileatime($path);
		$data->readable  = is_readable($path);
		$data->writable  = is_writable($path);
		$data->owner     = fileowner($path);
		$data->group     = filegroup($path);
		$data->type      = filetype($path);
		$data->mime      = $this->_getMime($path);

		$path = $data;
	}

	abstract protected function getRootDir();
}
