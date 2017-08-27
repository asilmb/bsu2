<?php

namespace common\ddd\repositories;

use common\ddd\repositories\BaseRepository;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class ApiRepository extends BaseRepository {
	
	const METHOD_POST = 'POST';
	const METHOD_GET = 'GET';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';
	
	public function sendGet($uri, $data = [], $headers = []) {
		$response = $this->sendRequest($uri, self::METHOD_GET, $data, $headers);
		return $response;
	}
	
	public function sendPost($uri, $data = [], $headers = []) {
		$response = $this->sendRequest($uri, self::METHOD_POST, $data, $headers);
		return $response;
	}
	
	public function sendPUT($uri, $data = [], $headers = []) {
		$response = $this->sendRequest($uri, self::METHOD_PUT, $data, $headers);
		return $response;
	}
	
	public function sendDelete($uri, $data = [], $headers = []) {
		$response = $this->sendRequest($uri, self::METHOD_DELETE, $data, $headers);
		return $response;
	}
	
	protected function sendRequest($uri, $method, $data = [], $headers = []) {
		$headers = $this->getHeaders($headers);
		$request = Yii::$app->httpClient->createRequest();
		$request->setMethod($method)->setUrl($uri)->setData($data)->setHeaders($headers);
		$response = $request->send();
		if($response->statusCode >= 400) {
			$this->showException($response->statusCode);
		}
		return $response;
	}
	
	protected function showException($statusCode) {
		if($statusCode == 401) {
			throw new UnauthorizedHttpException();
		}
		if($statusCode == 403) {
			throw new ForbiddenHttpException();
		}
	}
	
	protected function getHeaders($headers = []) {
		$authorization = Yii::$app->request->headers->get('Authorization');
		$language = Yii::$app->request->headers->get('Language');
		if(!empty($authorization) && empty($headers['Authorization'])) {
			$headers['Authorization'] = $authorization;
		}
		if(!empty($language) && empty($headers['Language'])) {
			$headers['Language'] = 'en';
		}
		return $headers;
	}
	
}