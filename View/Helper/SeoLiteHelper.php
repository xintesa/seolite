<?php

App::uses('AppHelper', 'View/Helper');

class SeoLiteHelper extends AppHelper {

	public function canonical() {
		if (empty($this->_View->viewVars['node']['CustomFields'])) {
			return null;
		}
		$path = $this->_View->viewVars['node']['CustomFields']['rel_canonical'];
		$template = '<link rel="canonical" href="%s"/>';
		$link = sprintf($template, $this->url($path));
		return $link;
	}

	public function beforeRender($viewFile) {
		if (isset($this->request->params['admin'])) {
			return;
		}
		$url = Router::normalize($this->request->url);
		$Url = ClassRegistry::init('SeoLite.SeoLiteUrl');
		$data = $Url->find('first', array(
			'fields' => array('id', 'url'),
			'recursive' => -1,
			'contain' => 'Meta',
			'conditions' => array(
				'url' => $url,
				'status' => true,
			),
			'cache' => array(
				'name' => 'urlmeta_' . Inflector::slug($url),
				'config' => 'seo_lite',
			),
		));
		if (isset($data['CustomFields'])) {
			$metas = array();
			foreach ($data['CustomFields'] as $key => $value) {
				if (strpos($key, 'meta_') !== false) {
					$metas[str_replace('meta_', '', $key)] = $value;
				}
			}
			Configure::write('Meta', $metas);
		}
	}

}
