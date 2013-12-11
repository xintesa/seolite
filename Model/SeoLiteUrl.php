<?php

App::uses('SeoLiteAppModel', 'SeoLite.Model');
App::uses('Croogo', 'Croogo.Lib');

/**
 * SeoLiteUrl Model
 *
 */
class SeoLiteUrl extends SeoLiteAppModel {

	public $useTable = 'urls';

	public $actsAs = array(
		'Croogo.Trackable',
		'Meta.Meta',
		'SeoLite.SeoCustomFields',
	);

	public $hasMany = array(
		'Meta' => array(
			'className' => 'Meta.Meta',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array('Meta.model' => 'SeoLiteUrl'),
		),
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'url' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
		),
		'status' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['url'])) {
			$url = Router::normalize($this->data[$this->alias]['url']);
			$this->data[$this->alias]['url'] = $url;
		}
		return true;
	}

	public function saveUrl($data) {
		$event = Croogo::dispatchEvent('Model.Node.beforeSaveNode', $this, compact('data'));
		$this->saveWithMeta($event->data['data']);
		$event = Croogo::dispatchEvent('Model.Node.afterSaveNode', $this, $event->data);
		return true;
	}

}
