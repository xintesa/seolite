<?php

/**
 * Url Model
 *
 */
namespace Seolite\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;

/**
 * Class UrlsTable
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class UrlsTable extends Table
{

    public function initialize(array $config)
    {
        $this->setTable('urls');
        $this->addBehavior('Croogo/Core.Trackable');
        $this->addBehavior('Croogo/Meta.Meta');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');

        $this->hasMany('Meta', [
            'className' => 'Croogo/Meta.Meta',
            'foreignKey' => 'foreign_key',
            'dependent' => true,
            'conditions' => ['Meta.model' => 'Seolite.Urls'],
        ]);
        $this->searchManager()
            ->value('id')
            ->like('url', [
                'before' => true,
                'after' => true
            ])
            ->like('description', [
                'before' => true,
                'after' => true
            ]);
        parent::initialize($config);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('url', 'isUniquePath', [
                'rule' => [$this, 'isUniquePath'],
            ])
            ->notBlank('url');

        $validator
            ->boolean('status');

        return $validator;
    }

    public function isUniquePath($check, array $context)
    {
        if (empty($check)) {
            return true;
        }
        $url = Router::normalize($check);
        $node = TableRegistry::get('Croogo/Nodes.Nodes')->find()
            ->select(['id'])
            ->where([
                'path' => $url,
            ])
            ->first();
        if (empty($node->id)) {
            return true;
        }

        return __('URL "{0}" conflicts with Node #{1}', $url, $node->id);
    }

    public function beforeSave(Event $event)
    {
        $entity = $event->data['entity'];
        if (isset($entity->url)) {
            $entity->url = Router::normalize($entity->url);
        }

        return true;
    }
}
