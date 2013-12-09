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

}
