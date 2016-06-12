<?php

/**
 * SeoLiteUrl Model
 *
 */
namespace Seolite\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Routing\Router;

/**
 * Class UrlsTable
 *
 * @mixin \Search\Model\Behavior\SearchBehavior
 */
class UrlsTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('urls');
        $this->addBehavior('Croogo/Core.Trackable');
        $this->addBehavior('Seolite.CustomFields');
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
            ->notBlank('url');

        $validator
            ->boolean('status');
        return $validator;
    }

    public function isUniquePath($check)
    {
        //@TODO: Use as application rule
        if (empty($check['url'])) {
            return true;
        }
        $url = Router::normalize($check['url']);
        $Node = ClassRegistry::init('Nodes.Node');
        $node = $Node->find('first', [
            'fields' => 'id',
            'recursive' => -1,
            'conditions' => [
                'path' => $url,
            ],
        ]);
        if (empty($node['Node']['id'])) {
            return true;
        }

        return __('URL "{0}" conflicts with Node #{1}', $url, $node['Node']['id']);
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
