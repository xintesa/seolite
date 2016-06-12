<?php


namespace Seolite\Event;

class SeoLiteEventHandler extends Object implements EventListener {

	public function implementedEvents() {
		return array(
			'Model.Node.beforeSaveNode' => array(
				'callable' => 'onBeforeSaveNode',
			),
			'Model.Node.afterSaveNode' => array(
				'callable' => 'onAfterSaveNode',
			),
		);
	}

/**
 * Format data so that it can be processed by MetaBehavior for saving
 */
	public function onBeforeSaveNode(Event $event) {
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
				if (!empty($value['value'])) {
					$data['data']['Meta'][Text::uuid()] = $value;
				} else {
					// mark empty records for deletion
					if (isset($value['id'])) {
						$data['delete'][] = $value['id'];
					}
				}
			}
		}
		unset($data['data']['SeoLite']);
		return $event;
	}

/**
 * Delete records that has been marked for deletion from $event->data['delete']
 */
	public function onAfterSaveNode(Event $event) {
		if (empty($event->data['delete'])) {
			return $event;
		}

		ClassRegistry::init('Meta.Meta')->deleteAll(array(
			'Meta.id' => $event->data['delete']
		));
		return $event;
	}

}
