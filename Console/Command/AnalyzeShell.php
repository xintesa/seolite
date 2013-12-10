<?php

App::uses('SeoLiteAnalyzer', 'SeoLite.Lib');
App::uses('AppShell', 'Console/Command');

class AnalyzeShell extends AppShell {

	public function getOptionParser() {
		return parent::getOptionParser()
			->addOption('field', array(
				'short' => 'f',
				'help' => 'Field name',
				'required' => false,
				'default' => 'body',
			))
			->addOption('model', array(
				'short' => 'm',
				'help' => 'Model name (PluginDot syntax).',
				'required' => true,
			));
	}

	public function main() {
		if (empty($this->params['model'])) {
			return $this->err('No model specified');
		}
		$this->run();
	}

	protected function _updateMeta($model, $foreignKey, $key, $value) {
		if (empty($value)) {
			return null;
		}
		static $Meta = null;
		if ($Meta === null) {
			$Meta = ClassRegistry::init('Meta.Meta');
		}

		$meta = $Meta->find('first', array(
			'recursive' => -1,
			'conditions' => array(
				'model' => $model,
				'foreign_key' => $foreignKey,
				'key' => $key,
			),
		));
		if (empty($meta)) {
			$meta = $Meta->create(array(
				'model' => $model,
				'foreign_key' => $foreignKey,
				'key' => $key,
				'value' => $value,
			));
		} else {
			$meta['Meta']['value'] = $value;
		}
		return $Meta->save($meta);
	}

	public function run() {
		$models = explode(',', $this->params['model']);
		$field = $this->params['field'];

		$Analyzer = new SeoLiteAnalyzer();
		foreach ($models as $model) {
			$Model = ClassRegistry::init($model);
			$rows = $Model->find('all', array(
				'recursive' => -1,
				'fields' => array($Model->primaryKey, $field),
			));

			$i = 0;
			foreach ($rows as $row) {
				$result = $Analyzer->analyze($row[$Model->alias][$field]);

				$this->_updateMeta(
					$Model->alias, $row[$Model->alias][$Model->primaryKey],
					'meta_keywords', $result['keywords']
				);
				$this->_updateMeta(
					$Model->alias, $row[$Model->alias][$Model->primaryKey],
					'meta_description', $result['description']
				);
				$i++;
			}
			$this->out(sprintf('Model %s: %d records', $model, $i));
		}
		$this->out('Done');
	}

}
