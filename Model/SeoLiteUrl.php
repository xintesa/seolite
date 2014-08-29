<?php

App::uses('SeoLiteAppModel', 'Seolite.Model');
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
		'Seolite.SeoCustomFields',
		'Search.Searchable',
	);

	public $hasMany = array(
		'Meta' => array(
			'className' => 'Meta.Meta',
			'foreignKey' => 'foreign_key',
			'dependent' => true,
			'conditions' => array('Meta.model' => 'SeoLiteUrl'),
		),
	);

	public $filterArgs = array(
		'id' => array('type' => 'value'),
		'url' => array('type' => 'like'),
		'description' => array('type' => 'like'),
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
			'uniquePath' => array(
				'rule' => array('isUniquePath'),
			),
		),
		'status' => array(
			'boolean' => array(
				'rule' => array('boolean'),
			),
		),
	);

	public function isUniquePath($check) {
		if (empty($check['url'])) {
			return true;
		}
		$url = Router::normalize($check['url']);
		$Node = ClassRegistry::init('Nodes.Node');
		$node = $Node->find('first', array(
			'fields' => 'id',
			'recursive' => -1,
			'conditions' => array(
				'path' => $url,
			),
		));
		if (empty($node['Node']['id'])) {
			return true;
		}
		return __('URL "%s" conflicts with Node #%d', $url, $node['Node']['id']);
	}

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
