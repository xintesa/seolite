<?php

namespace Seolite\Controller\Admin;

use Seolite\SeoLiteAnalyzer;

class AnalyzeController extends AppController
{
    public function index()
    {
        $table = $this->request->query('table');
        $id = $this->request->query('id');
        $field = $this->request->query('field');
        $table = $this->loadModel($table);
        $item = $table->get($id);
        $body = $item->get($field);

        if ($item->has('excerpt')) {
            $excerpt = $item->get('excerpt');
        }

        $seoLiteAnalyzer = new SeoLiteAnalyzer();
        $result = $seoLiteAnalyzer->analyze($body);
        if (!empty($excerpt)) {
            $result['description'] = $excerpt;
        }
        extract($result);

        $this->set('_rootNode', 'results');
        $this->set(compact('keywords', 'description'));
        $this->set('_serialize', ['keywords', 'description']);
    }
}
