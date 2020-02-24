<?php

namespace Seolite\Shell;

use Cake\ORM\TableRegistry;
use Croogo\Core\Shell\AppShell;
use Seolite\SeoLiteAnalyzer;

class AnalyzeShell extends AppShell
{

    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->addOption('field', [
                'short' => 'f',
                'help' => 'Field name',
                'required' => false,
                'default' => 'body',
            ])
            ->addOption('model', [
                'short' => 'm',
                'help' => 'Model name (PluginDot syntax).',
                'required' => true,
            ]);
    }

    public function main()
    {
        if (empty($this->params['model'])) {
            return $this->err('No model specified');
        }
        $this->run();
    }

    protected function _updateMeta($model, $foreignKey, $key, $value)
    {
        if (empty($value)) {
            return null;
        }
        $metaTable = TableRegistry::get('Croogo/Meta.Meta');

        $meta = $metaTable->findOrCreate([
            'model' => $model,
            'foreign_key' => $foreignKey,
            'key' => $key,
        ]);

        $meta->value = $value;

        return $metaTable->save($meta);
    }

    public function run()
    {
        $models = explode(',', $this->params['model']);
        $field = $this->params['field'];

        $Analyzer = new SeoLiteAnalyzer();
        foreach ($models as $model) {
            $model = TableRegistry::get($model);
            $rows = $model->find()
                ->select($model->primaryKey())
                ->select([$field]);

            $i = 0;
            foreach ($rows as $row) {
                $result = $Analyzer->analyze($row->field);

                $this->_updateMeta($model->registryAlias(), $row->get($model->primaryKey()), 'meta_keywords',
                    $result['keywords']);
                $this->_updateMeta($model->registryAlias(), $row->get($model->primaryKey()), 'meta_description',
                    $result['description']);
                $i++;
            }
            $this->out(sprintf('Model %s: %d records', $model, $i));
        }
        $this->out('Done');
    }
}
