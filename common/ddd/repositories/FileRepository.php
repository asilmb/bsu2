<?php

namespace common\ddd\repositories;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;

class FileRepository extends BaseRepository {
	
	public $pathName;
	public $format;
	
	private $isDirectoryExists = false;
	
	protected function saveFile($name, $data, $format = null) {
		$fileName = $this->getFileName($name, $format);
		file_put_contents($fileName, $data);
	}
	
	protected function loadFile($name, $format = null) {
		$fileName = $this->getFileName($name, $format);
		return file_get_contents($fileName);
	}
	
	protected function getUrl($name, $format = null) {
		$path = env('url.static') . param('static.path.qr') . '/';
		$fileName = $path . $this->getFileName($name, $format);
		return $fileName;
	}
	
	protected function getFilePath($name, $format = null) {
		$path = $this->getPath();
		$fileName = $path . $this->getFileName($name, $format);
		return $fileName;
	}
    protected function getFrontFilePath($name, $format = null) {
        $path = $this->getFrontPath();
        $fileName = $path . $this->getFileName($name, $format);
        return $fileName;
    }
	protected function getFileName($name, $format = null) {
		$format = $this->getFormat($format);
		$fileName = $name . '.' . $format;
		return $fileName;
	}
	
	protected function getFormat($format = null) {
		if(empty($this->format)) {
			throw new InvalidConfigException('Property "format" not assigned');
		}
		$format = !empty($format) ? $format : $this->format;
		return $format;
	}
	
	protected function getPath($addPath = null) {
		if(empty($this->pathName)) {
			throw new InvalidConfigException('Property "pathName" not assigned');
		}
		$path = param('static.path.' . $this->pathName);
		$path = Yii::getAlias('@webroot/' . $path);
		$path = FileHelper::normalizePath($path);
		if($addPath) {
			$path .= DS . $addPath;
		}
		return $path . DS;
	}
    protected function getFrontPath($addPath = null) {
        if(empty($this->pathName)) {
            throw new InvalidConfigException('Property "pathName" not assigned');
        }
        $path = param('static.path.' . $this->pathName);

        $path = Yii::getAlias('@frontend/web/' . $path);
        $path = FileHelper::normalizePath($path);
        if($addPath) {
            $path .= DS . $addPath;
        }
        return $path . DS;
    }
	protected function createDirectory($addPath = null) {
		if(isset($this->isDirectoryExists[$addPath])) {
			return;
		}
		$dir = $this->getPath($addPath);
		if(!is_dir($dir)) {
			FileHelper::createDirectory($dir);
		}
		$this->isDirectoryExists[$addPath] = true;
	}
	
}