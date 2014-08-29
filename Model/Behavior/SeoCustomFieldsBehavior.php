<?php

App::uses('ModelBehavior', 'Model');

class SeoCustomFieldsBehavior extends ModelBehavior {

	public function implementedEvents() {
		return array(
			'Model.Node.beforeSaveNode' => array(
				'callable' => 'onBeforeSaveNode',
			),
		);
	}

	public function afterFind(Model $model, $results, $primary = false) {
		if (!$primary) {
			return $results;
		}
		$keySettings = Configure::read('Seolite.keys');
		$keys = array_keys($keySettings);
		foreach ($results as &$result) {
			if (!isset($result['Meta'])) {
				continue;
			}
			foreach ($result['Meta'] as $index => $meta) {
				if (!in_array($meta['key'], $keys)) {
					continue;
				}
				$result['SeoLite'][$meta['key']] = array_intersect_key($meta, array('id' => '', 'key' => '', 'value' => ''));
				unset($result['Meta'][$index]);
			}
		}
		return $results;
	}

}
