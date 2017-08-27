<?php

namespace api\v4\modules\service\helpers;

class DynamicLabelsHelper {
	
	public function getLabels($fields) {
		$labels = [];
		foreach($fields as $field) {
			if(!empty($field['translate']['value'])) {
				$labels[$field['name']] = $field['translate']['value'];
			} else {
				$labels[$field['name']] = ucfirst($field['name']);
			}
		}
		return $labels;
	}
	
}
