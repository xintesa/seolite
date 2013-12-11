<?php

App::uses('SeoLiteAppController', 'SeoLite.Controller');
/**
 * SeoLiteUrls Controller
 *
 * @property SeoLiteUrl $SeoLiteUrl
 * @property PaginatorComponent $Paginator
 */
class SeoLiteUrlsController extends SeoLiteAppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SeoLiteUrl->recursive = 0;
		$this->set('seoLiteUrls', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->SeoLiteUrl->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid URL'));
		}
		$options = array('conditions' => array('SeoLiteUrl.' . $this->SeoLiteUrl->primaryKey => $id));
		$this->set('seoLiteUrl', $this->SeoLiteUrl->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SeoLiteUrl->create();
			if ($this->SeoLiteUrl->save($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The URL has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__d('croogo', 'The URL could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->SeoLiteUrl->exists($id)) {
			throw new NotFoundException(__d('croogo', 'Invalid URL'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SeoLiteUrl->saveUrl($this->request->data)) {
				$this->Session->setFlash(__d('croogo', 'The URL has been saved'), 'default', array('class' => 'success'));
				return $this->Croogo->redirect(array('action' => 'edit', $this->SeoLiteUrl->id));
			} else {
				$this->Session->setFlash(__d('croogo', 'The URL could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$options = array('conditions' => array('SeoLiteUrl.' . $this->SeoLiteUrl->primaryKey => $id));
			$this->request->data = $this->SeoLiteUrl->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->SeoLiteUrl->id = $id;
		if (!$this->SeoLiteUrl->exists()) {
			throw new NotFoundException(__d('croogo', 'Invalid URL'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SeoLiteUrl->delete()) {
			$this->Session->setFlash(__d('croogo', 'Seo lite url deleted'), 'default', array('class' => 'success'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('croogo', 'Seo lite url was not deleted'), 'default', array('class' => 'error'));
		$this->redirect(array('action' => 'index'));
	}

}
