<?php

namespace Seolite\View\Helper;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\View\Helper;

class SeoLiteHelper extends Helper
{
    public function beforeRender()
    {
        if ($this->getView()->getRequest()->getParam('prefix') === 'admin') {
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
        if ($data && isset($data->meta)) {
            $meta = (array)Configure::read('Meta.data');
            foreach ($data->meta as $entity) {
                $meta[$entity->key] = $entity->value;
            }
            Configure::write('Meta.data', $meta);
        }
    }
}
