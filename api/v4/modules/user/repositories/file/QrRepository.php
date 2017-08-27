<?php

namespace api\v4\modules\user\repositories\file;

use common\ddd\repositories\FileRepository;
use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;

class QrRepository extends FileRepository {
	
	public $size = 5;
	public $margin = 0;
	public $level = Enum::QR_ECLEVEL_H;
	public $pathName = 'qr';
	public $format = 'png';
	
	public function getOne($text) {
		if(!$this->isExists($text)) {
			$this->save($text);
		}
		$hash = $this->genHash($text);
		$file_url = $this->getUrl($hash);
		$file_path = $this->getFilePath($hash);
		return $this->forgeEntity([
			'text' => $text,
			'file_url' => $file_url,
			'file_path' => $file_path,
		]);
	}
	
	public function isExists($text) {
		$fileName = $this->getFileNameByText($text);
		return file_exists($fileName);
	}
	
	private function genHash($text) {
		$hash = hash('crc32b', $text);
		return $hash;
	}
	
	private function getFileNameByText($text) {
		$hash = hash('crc32b', $text);
		$fileName = $this->getFilePath($hash);
		return $fileName;
	}
	
	protected function getFileName($name, $format = null) {
		$newName = $name . BL . $this->level . $this->size . $this->margin;
		return parent::getFileName($newName, $format);
	}
	
	private function save($text) {
		$fileName = $this->getFileNameByText($text);
		$this->createDirectory();
		QrCode::encode($text, $fileName, $this->level, $this->size, $this->margin);
	}
	
}