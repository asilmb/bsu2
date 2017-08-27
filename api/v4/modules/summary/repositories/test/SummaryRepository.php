<?php

namespace api\v4\modules\summary\repositories\test;

use api\v4\modules\summary\entities\UrlEntity;
use api\v4\modules\summary\entities\LastModifiedEntity;
use api\v4\modules\summary\entities\StaticIdEntity;
use api\v4\modules\summary\entities\SummaryEntity;
use common\ddd\repositories\BaseRepository;

class SummaryRepository extends BaseRepository {

	protected $modelClass = 'api\v4\modules\summary\models\Resource';

	public function findAll($condition) {
		$all = $this->data();
		$summary['url'] = new UrlEntity($all['url']);
		$summary['static_id'] = new StaticIdEntity($all['static_id']);
		$summary['last_modified'] = new LastModifiedEntity($all['last_modified']);
		$su = new SummaryEntity($summary);
		return $su;
	}

	private function data() {
		return [
			'static_id' => [
				'category_root' => 58,
				'addressless_transfer' => 306,
				'cnp_withdrawal' => 320,
				'iban_payment' => 818,
			],
			'url' => [
				'service_pictures' => 'http://static.test.wooppay.com/service',
				'service_menu_pictures' => 'http://static.test.wooppay.com/service_menu',
				'avatars' => 'http://static.test.wooppay.com/avatar',
				'bank_pictures' => 'http://static.test.wooppay.com/bank',
			],
			'last_modified' => [
				'city' => '2015-02-16T10:14:49Z',
				'country' => '2016-08-25T09:39:27Z',
				'service' => '2017-05-25T09:24:25Z',
				'service_category' => '2017-05-25T17:47:18Z',
			],
		];
	}
}