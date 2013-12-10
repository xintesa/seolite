<?php

App::uses('SeoLiteAnalyzer', 'SeoLite.Lib');
App::uses('SeoLiteAppController', 'SeoLite.Controller');

class SeoLiteAnalyzeController extends SeoLiteAppController {

	public function admin_index($plugin = null, $model = null, $id = null, $field = null) {
		if (empty($id)) {
			throw new NotFoundException('Invalid id');
		}

		$Model = ClassRegistry::init($plugin . '.' . $model);
		$Model->id = $id;
		$body = $Model->field($field);

		$Analyzer = new SeoLiteAnalyzer();
		$result = $Analyzer->analyze($body);
		extract($result);

		$this->set('_rootNode', 'results');
		$this->set(compact('keywords', 'description'));
		$this->set('_serialize', array('keywords', 'description'));
	}

}
