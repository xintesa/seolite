<?php

App::uses('CakeEventListener', 'Event');

class SeoLiteEventHandler extends Object implements CakeEventListener {

	public function implementedEvents() {
		return array(
			'Model.Node.beforeSaveNode' => array(
				'callable' => 'onBeforeSaveNode',
			),
		);
	}

	public function onBeforeSaveNode(CakeEvent $event) {
		$data =& $event->data;
		if (isset($data['data']['SeoLite'])) {
			if (empty($data['data']['Meta'])):
				$data['data']['Meta'] = array();
			endif;

			$values = array_values($data['data']['SeoLite']);
			foreach ($values as $value) {
				if (strlen($value['id']) == 36) {
					unset($value['id']);
				}
				$data['data']['Meta'][String::uuid()] = $value;
			}
		}
		unset($data['data']['SeoLite']);
		return $event;
	}

}
