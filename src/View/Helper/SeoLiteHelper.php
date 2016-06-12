<?php

namespace Seolite\View\Helper;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Croogo\Core\View\Helper\CroogoAppHelper;

class SeoLiteHelper extends CroogoAppHelper
{
    public function canonical()
    {
        if (empty($this->_View->viewVars['node']['custom_fields'])) {
            return null;
        }
        $path = $this->_View->viewVars['node']['custom_fields']['rel_canonical'];
        $template = '<link rel="canonical" href="%s"/>';
        $link = sprintf($template, $this->url($path));

        return $link;
    }

    public function beforeRender()
    {
        if ($this->request->param('prefix') === 'admin') {
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
            ->contain(['Meta'])
            ->cache('urlmeta_' . Text::slug($url), 'seo_lite')
            ->first();

        if ($data && $data->has('custom_fields')) {
            $metas = [];
            foreach ($data->custom_fields as $key => $value) {
                if (strpos($key, 'meta_') !== false) {
                    $metas[str_replace('meta_', '', $key)] = $value;
                }
            }
            Configure::write('Meta', $metas);
        }
    }
}
