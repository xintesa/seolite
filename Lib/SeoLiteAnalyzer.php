<?php

if (!class_exists('colossal_mind_mb_keyword_gen')) {
	require CakePlugin::path('Seolite') . 'Vendor/KeywordGenerator/class.colossal-mind-mb-keyword-generator.php';
}

class SeoLiteAnalyzer {

	public function analyze($text) {
		$params = array('content' => $text);
		$analyzer = new colossal_mind_mb_keyword_gen($params);
		$keywords = $analyzer->get_keywords();

		$para = trim(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));

		list($description, ) = explode("\n", strip_tags($para), 2);
		$description = trim($description);

		return compact('keywords', 'description');
	}

}
