<?php

App::uses('SeoLiteAppController', 'SeoLite.Controller');
require CakePlugin::path('SeoLite') . 'Vendor/KeywordGenerator/class.colossal-mind-mb-keyword-generator.php';

class SeoLiteAnalyzeController extends SeoLiteAppController {

	public function admin_index($plugin = null, $model = null, $id = null, $field = null) {
		if (empty($id)) {
			throw new NotFoundException('Invalid id');
		}

		$Model = ClassRegistry::init($plugin . '.' . $model);
		$Model->id = $id;
		$body = $Model->field($field);

		$params = array('content' => $body);
		$analyzer = new colossal_mind_mb_keyword_gen($params);
		$keywords = $analyzer->get_keywords();

		$para = html_entity_decode($body, ENT_QUOTES);
		list($description, ) = explode("\n", strip_tags($para), 2);
		$description = trim($description);

		$this->set('_rootNode', 'results');
		$this->set(compact('keywords', 'description'));
		$this->set('_serialize', array('keywords', 'description'));
	}

}
