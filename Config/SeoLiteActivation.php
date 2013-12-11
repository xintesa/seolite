<?php

class SeoLiteActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		$CroogoPlugin = new CroogoPlugin();
		$result = $CroogoPlugin->migrate('SeoLite');
		if ($result) {
			$Setting = ClassRegistry::init('Settings.Setting');
			$Setting->write('SeoLite.installed', true);
		}
		return $result;
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$Setting->deleteKey('SeoLite.installed');
	}

}
