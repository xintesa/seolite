<?php

namespace Seolite\View\Helper;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\View\Helper;
use Croogo\Core\Utility\StringConverter;

class SeoLiteHelper extends Helper
{

    public $helpers = [
        'Croogo/Core.Croogo',
        'Url',
    ];

    /**
     * Inject Analyze button
     *
     * @deprecated
     */
    protected function addAnalyzeButton()
    {
        $View = $this->getView();
        $this->Croogo->adminScript('Seolite.admin.js');
        $View->append('action-buttons');
        $entity = $View->get('node');
        $id = !empty($entity->id) ? $entity->id : null;
        $source = isset($entity) ? $entity->getSource() : null;
        $field = isset($field) ? $field : 'body';
        echo $this->Croogo->adminAction(__d('seolite', 'Analyze'), [
            'plugin' => 'Seolite',
            'controller' => 'Analyze',
            'action' => 'index',
            '?' => [
                'table' => $source,
                'id' => $id,
                'field' => $field,
            ],
            '_ext' => 'json',
        ], [
            'data-toggle' => 'seo-lite-analyze',
            'data-id' => $id,
            'icon' => 'cogs',
            'iconSize' => 'small',
            'tooltip' => [
                'data-title' => 'Simple auto keywords and description',
            ],
        ]);
        $View->end();

    }

    public function beforeRender()
    {
        if ($this->getView()->getRequest()->getParam('prefix') === 'admin') {
            // $this->addAnalyzeButton();
            return;
        }
        $url = Router::normalize($this->request->url);
        $urlTable = TableRegistry::get('Seolite.Urls');
        $data = $urlTable->find()
            ->select(['id', 'url'])
            ->where([
                'url' => $url,
                'status' => true
            ])
            ->contain(['Meta' => [
                'fields' => ['id', 'model', 'foreign_key', 'key', 'value'],
            ]])
            ->cache('urlmeta_' . Text::slug($url), 'seo_lite')
            ->first();

        $meta = (array)Configure::read('Meta.data');
        if ($data && isset($data->meta)) {
            foreach ($data->meta as $entity) {
                $meta[$entity->key] = $entity->value;
            }
        }
        $this->addOpenGraphProtocolTags($meta);
        Configure::write('Meta.data', $meta);
    }

    protected function addOpenGraphProtocolTags(array &$meta)
    {
        $keys = Configure::read('Meta.keys');
        $entity = $this->getView()->get('node');
        $entity = $entity ?: $this->getView()->get('entity');
        foreach ($keys as $key => $value) {
            if (!$entity || array_key_exists($key, $meta)) {
                continue;
            }

            switch ($key) {
                case 'og:title':
                    $meta[$key] = $entity->title;
                    break;
                case 'og:url':
                    $meta[$key] = $this->Url->build($entity->path, [
                        'fullBase' => true,
                    ]);
                    break;
                case 'og:image':
                    if (isset($entity->linked_assets['FeaturedImage'][0])) {
                        $attachment = $entity->linked_assets['FeaturedImage'][0];
                        $meta[$key] = $this->Url->build($attachment->path, [
                            'fullBase' => true,
                        ]);
                    }
                    break;
                default:
                    break;
            }

        }
    }
}
