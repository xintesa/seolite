<?php

/**
 * SeoLiteUrls Controller
 *
 * @property SeoLiteUrl $SeoLiteUrl
 * @property PaginatorComponent $Paginator
 */
namespace Seolite\Controller\Admin;

class UrlsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    public function add()
    {
        $entity = $this->Urls->newEntity();
        $this->_save($entity);
    }

    public function edit($id)
    {
        $entity = $this->Urls->get($id, [
            'associated' => [
                'Meta',
            ],
        ]);

        $this->_save($entity);
    }

    protected function _save($entity)
    {
        $request = $this->getRequest();
        if ($request->is(['patch', 'post', 'put'])) {
            $data = $request->getData();
            $entity = $this->Urls->patchEntity($entity, $data, [
                'associated' => [
                    'Meta',
                ],
            ]);
            if ($this->Urls->save($entity)) {
                $this->Flash->success(__('The url has been saved.'));

                if (isset($data['_apply'])) {
                    return $this->redirect(['action' => 'edit', $entity->id]);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The url could not be saved. Please, try again.'));
        }
        $this->set(compact('entity'));
    }
}
