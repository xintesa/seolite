<?php

namespace Seolite\Config;

class SeoLiteActivation {

	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
		$CroogoPlugin = new CroogoPlugin();
		$result = $CroogoPlugin->migrate('Seolite');
		if ($result) {
			$Setting = ClassRegistry::init('Settings.Setting');
			$Setting->write('Seolite.installed', true);
		}
		return $result;
	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
		$Setting = ClassRegistry::init('Settings.Setting');
		$Setting->deleteKey('Seolite.installed');
	}

}
